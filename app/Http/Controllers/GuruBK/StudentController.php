<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
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
        
        return view('gurubk.students.index', compact('students', 'teacher', 'academicYears'));
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

        // Get all unique classes and student counts per class
        $classData = Student::select('class')
            ->selectRaw('count(*) as total_students')
            ->selectRaw('sum(case when teacher_id = ? then 1 else 0 end) as my_students', [$teacher->id])
            ->selectRaw('sum(case when teacher_id is not null and teacher_id != ? then 1 else 0 end) as other_students', [$teacher->id])
            ->groupBy('class')
            ->orderBy('class')
            ->get();

        // For each class, find the current teacher(s) handling it if any
        $classTeachers = [];
        $studentsWithTeachers = Student::whereNotNull('class')
            ->whereNotNull('teacher_id')
            ->with('teacher.user')
            ->get();

        foreach ($studentsWithTeachers as $s) {
            $classTeachers[$s->class][$s->teacher->user->name] = true;
        }

        $classHandlers = [];
        foreach ($classTeachers as $cls => $names) {
            $classHandlers[$cls] = implode(', ', array_keys($names));
        }

        return view('gurubk.students.claim_classes', compact('teacher', 'classData', 'classHandlers'));
    }

    public function claimClasses(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/')->with('error', 'Anda belum dikonfigurasi sebagai Guru BK oleh Admin.');
        }

        $submittedClasses = $request->input('classes', []);

        // Check if claiming these classes would exceed quota
        $targetStudentsCount = Student::whereIn('class', $submittedClasses)->count();
        if ($targetStudentsCount > $teacher->max_quota) {
            return back()->with('error', "Jumlah siswa di kelas yang Anda pilih (total: {$targetStudentsCount}) melebihi kuota bimbingan Anda ({$teacher->max_quota}). Silakan kurangi pilihan kelas.");
        }

        // Release classes that were previously handled by this teacher but are not in the submitted list
        Student::where('teacher_id', $teacher->id)
            ->whereNotIn('class', $submittedClasses)
            ->update(['teacher_id' => null]);

        // Claim the new classes
        if (!empty($submittedClasses)) {
            Student::whereIn('class', $submittedClasses)
                ->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('gurubk.students.index')->with('success', 'Kelas bimbingan berhasil diperbarui.');
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
