<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
use App\Models\AcademicPeriod;
use App\Models\TeacherClassAssignment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/')->with('error', 'Anda belum dikonfigurasi sebagai Guru BK oleh Admin.');
        }

        $activePeriod = AcademicPeriod::active();

        $query = Student::with('user')->where('teacher_id', $teacher->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        $students = $query->latest()->get();
        
        $currentYear = date('Y');
        $academicYears = [];
        for ($y = 2024; $y <= $currentYear + 1; $y++) {
            $academicYears[] = $y . '/' . ($y + 1);
        }

        // Get assigned classes for the active period
        $assignedClasses = [];
        if ($activePeriod) {
            $assignedClasses = TeacherClassAssignment::where('academic_period_id', $activePeriod->id)
                ->where('teacher_id', $teacher->id)
                ->pluck('class')
                ->toArray();
        }
        
        return view('gurubk.students.index', compact('students', 'teacher', 'academicYears', 'activePeriod', 'assignedClasses'));
    }

    public function show(Student $student)
    {
        $teacher = Auth::user()->teacher;
        
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.students.index')->with('error', 'Akses ditolak.');
        }

        $student->load([
            'teacher.user', 
            'counselingSessions' => function($q) {
                $q->latest('counseling_date');
            },
            'letters' => function($q) {
                $q->latest();
            }
        ]);

        $now = \Carbon\Carbon::now();
        $currentPeriod = $this->getAcademicPeriod($now);
        $currentPeriodKey = $currentPeriod['academic_year'] . '_' . $currentPeriod['semester'];

        // Group anecdotes (counselingSessions)
        $anecdotesByPeriod = [];
        foreach ($student->counselingSessions as $session) {
            $period = $this->getAcademicPeriod($session->counseling_date);
            $key = $period['academic_year'] . '_' . $period['semester'];
            
            if (!isset($anecdotesByPeriod[$key])) {
                $anecdotesByPeriod[$key] = [
                    'label' => $period['label'],
                    'academic_year' => $period['academic_year'],
                    'semester' => $period['semester'],
                    'items' => []
                ];
            }
            $anecdotesByPeriod[$key]['items'][] = $session;
        }
        krsort($anecdotesByPeriod);

        // Group letters
        $lettersByPeriod = [];
        foreach ($student->letters as $letter) {
            $period = $this->getAcademicPeriod($letter->created_at);
            $key = $period['academic_year'] . '_' . $period['semester'];
            
            if (!isset($lettersByPeriod[$key])) {
                $lettersByPeriod[$key] = [
                    'label' => $period['label'],
                    'academic_year' => $period['academic_year'],
                    'semester' => $period['semester'],
                    'items' => []
                ];
            }
            $lettersByPeriod[$key]['items'][] = $letter;
        }
        krsort($lettersByPeriod);

        return view('gurubk.students.show', compact('student', 'teacher', 'anecdotesByPeriod', 'lettersByPeriod', 'currentPeriodKey'));
    }

    private function getAcademicPeriod($date)
    {
        $carbonDate = \Carbon\Carbon::parse($date);
        $year = $carbonDate->year;
        $month = $carbonDate->month;

        if ($month >= 7 && $month <= 12) {
            $semester = '1';
            $academicYear = $year . '/' . ($year + 1);
        } else {
            $semester = '2';
            $academicYear = ($year - 1) . '/' . $year;
        }

        return [
            'semester' => $semester,
            'academic_year' => $academicYear,
            'label' => "Semester $semester (TA $academicYear)"
        ];
    }

    public function claimClassesForm()
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/')->with('error', 'Anda belum dikonfigurasi sebagai Guru BK oleh Admin.');
        }

        $activePeriod = AcademicPeriod::active();
        if (!$activePeriod) {
            return redirect()->route('gurubk.students.index')
                ->with('error', 'Tidak ada periode akademik yang aktif saat ini. Hubungi Admin untuk mengaktifkan periode.');
        }

        // Get all unique classes and student counts per class
        $classData = Student::select('class')
            ->selectRaw('count(*) as total_students')
            ->selectRaw('sum(case when teacher_id = ? then 1 else 0 end) as my_students', [$teacher->id])
            ->selectRaw('sum(case when teacher_id is not null and teacher_id != ? then 1 else 0 end) as other_students', [$teacher->id])
            ->groupBy('class')
            ->orderBy('class')
            ->get();

        // Check which classes are already assigned in this period (by other teachers)
        $periodAssignments = TeacherClassAssignment::where('academic_period_id', $activePeriod->id)
            ->with('teacher.user')
            ->get()
            ->keyBy('class');

        // Get my current assignments for this period
        $myAssignedClasses = TeacherClassAssignment::where('academic_period_id', $activePeriod->id)
            ->where('teacher_id', $teacher->id)
            ->pluck('class')
            ->toArray();

        // Build class handlers info
        $classHandlers = [];
        foreach ($periodAssignments as $cls => $assignment) {
            if ($assignment->teacher_id !== $teacher->id) {
                $classHandlers[$cls] = $assignment->teacher->user->name ?? 'Guru Lain';
            }
        }

        // Get previous period's assignments for carry-over feature
        $previousAssignments = [];
        $previousPeriod = AcademicPeriod::where('is_active', false)
            ->orderByDesc('end_date')
            ->first();

        if ($previousPeriod) {
            $previousAssignments = TeacherClassAssignment::where('academic_period_id', $previousPeriod->id)
                ->where('teacher_id', $teacher->id)
                ->pluck('class')
                ->toArray();
        }

        return view('gurubk.students.claim_classes', compact(
            'teacher', 'classData', 'classHandlers', 'activePeriod', 
            'myAssignedClasses', 'previousAssignments'
        ));
    }

    public function claimClasses(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/')->with('error', 'Anda belum dikonfigurasi sebagai Guru BK oleh Admin.');
        }

        $activePeriod = AcademicPeriod::active();
        if (!$activePeriod) {
            return back()->with('error', 'Tidak ada periode akademik yang aktif.');
        }

        $submittedClasses = $request->input('classes', []);

        // Check if any of the submitted classes are already claimed by another teacher in this period
        $conflicting = TeacherClassAssignment::where('academic_period_id', $activePeriod->id)
            ->where('teacher_id', '!=', $teacher->id)
            ->whereIn('class', $submittedClasses)
            ->with('teacher.user')
            ->get();

        if ($conflicting->isNotEmpty()) {
            $conflictInfo = $conflicting->map(fn($a) => "{$a->class} ({$a->teacher->user->name})")->join(', ');
            return back()->with('error', "Kelas berikut sudah di-claim guru lain: {$conflictInfo}");
        }

        // Check if claiming these classes would exceed quota
        $targetStudentsCount = Student::whereIn('class', $submittedClasses)->count();
        if ($targetStudentsCount > $teacher->max_quota) {
            return back()->with('error', "Jumlah siswa di kelas yang Anda pilih (total: {$targetStudentsCount}) melebihi kuota bimbingan Anda ({$teacher->max_quota}). Silakan kurangi pilihan kelas.");
        }

        // Remove old assignments for this teacher in this period
        TeacherClassAssignment::where('academic_period_id', $activePeriod->id)
            ->where('teacher_id', $teacher->id)
            ->delete();

        // Create new assignments
        foreach ($submittedClasses as $class) {
            TeacherClassAssignment::create([
                'academic_period_id' => $activePeriod->id,
                'teacher_id' => $teacher->id,
                'class' => $class,
            ]);
        }

        // Sync students.teacher_id: Release classes no longer handled by this teacher
        Student::where('teacher_id', $teacher->id)
            ->whereNotIn('class', $submittedClasses)
            ->update(['teacher_id' => null]);

        // Claim the new classes
        if (!empty($submittedClasses)) {
            Student::whereIn('class', $submittedClasses)
                ->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('gurubk.students.index')->with('success', 'Kelas bimbingan berhasil diperbarui untuk periode ' . $activePeriod->name . '.');
    }

    public function create()
    {
        return redirect()->route('gurubk.students.index')->with('error', 'Otoritas menambah data siswa secara langsung telah dialihkan ke Super Admin.');
    }

    public function store(Request $request)
    {
        return redirect()->route('gurubk.students.index')->with('error', 'Otoritas menambah data siswa secara langsung telah dialihkan ke Super Admin.');
    }

    public function edit(Student $student)
    {
        return redirect()->route('gurubk.students.index')->with('error', 'Otoritas mengubah data siswa secara langsung telah dialihkan ke Super Admin.');
    }

    public function update(Request $request, Student $student)
    {
        return redirect()->route('gurubk.students.index')->with('error', 'Otoritas mengubah data siswa secara langsung telah dialihkan ke Super Admin.');
    }

    public function destroy(Student $student)
    {
        return redirect()->route('gurubk.students.index')->with('error', 'Otoritas menghapus data siswa secara langsung telah dialihkan ke Super Admin.');
    }

    public function bulkDestroy(Request $request)
    {
        return redirect()->route('gurubk.students.index')->with('error', 'Otoritas menghapus data siswa secara langsung telah dialihkan ke Super Admin.');
    }
}
