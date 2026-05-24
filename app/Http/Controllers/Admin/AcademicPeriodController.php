<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\Student;
use App\Models\TeacherClassAssignment;

class AcademicPeriodController extends Controller
{
    public function index()
    {
        $periods = AcademicPeriod::withCount('teacherClassAssignments')
            ->orderByDesc('is_active')
            ->orderByDesc('start_date')
            ->get();

        // Enrich with additional stats
        foreach ($periods as $period) {
            $assignedClasses = TeacherClassAssignment::where('academic_period_id', $period->id)
                ->distinct('class')->count('class');
            $assignedTeachers = TeacherClassAssignment::where('academic_period_id', $period->id)
                ->distinct('teacher_id')->count('teacher_id');
            $period->assigned_classes_count = $assignedClasses;
            $period->assigned_teachers_count = $assignedTeachers;
        }

        return view('admin.academic_periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.academic_periods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|in:1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check uniqueness
        $exists = AcademicPeriod::where('academic_year', $request->academic_year)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Periode akademik ini sudah ada.');
        }

        $semLabel = $request->semester == '1' ? 'Semester 1' : 'Semester 2';

        AcademicPeriod::create([
            'name' => $request->academic_year . ' - ' . $semLabel,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => false,
        ]);

        return redirect()->route('admin.academic_periods.index')
            ->with('success', 'Periode akademik berhasil dibuat.');
    }

    public function show(AcademicPeriod $academicPeriod)
    {
        $assignments = TeacherClassAssignment::where('academic_period_id', $academicPeriod->id)
            ->with('teacher.user')
            ->orderBy('class')
            ->get()
            ->groupBy(function ($item) {
                return $item->teacher->user->name ?? 'Unknown';
            });

        return view('admin.academic_periods.show', compact('academicPeriod', 'assignments'));
    }

    public function activate(AcademicPeriod $academicPeriod)
    {
        // Deactivate all other periods
        AcademicPeriod::where('id', '!=', $academicPeriod->id)
            ->update(['is_active' => false]);

        // Activate this period
        $academicPeriod->update(['is_active' => true]);

        // Reset all students' teacher_id to null (they need to be re-claimed)
        Student::whereNotNull('teacher_id')->update(['teacher_id' => null]);

        return redirect()->route('admin.academic_periods.index')
            ->with('success', "Periode \"{$academicPeriod->name}\" telah diaktifkan. Semua penugasan guru-siswa telah di-reset. Guru BK perlu melakukan klaim kelas ulang.");
    }

    public function destroy(AcademicPeriod $academicPeriod)
    {
        if ($academicPeriod->is_active) {
            return back()->with('error', 'Tidak bisa menghapus periode yang sedang aktif.');
        }

        $academicPeriod->delete();
        return redirect()->route('admin.academic_periods.index')
            ->with('success', 'Periode akademik berhasil dihapus.');
    }
}
