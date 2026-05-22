<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Report;
use App\Models\Student;
use App\Models\AcademicPeriod;
use App\Models\TeacherClassAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        $pendingReports = Report::where('status', 'pending')->with('reporter')->get();
        
        $myInProgressReports = Report::where('handled_by', Auth::id())
                           ->where('status', 'in-progress')
                           ->with('reporter')
                           ->get();

        $myReports = Report::where('handled_by', Auth::id())
                           ->whereIn('status', ['in-progress', 'resolved'])
                           ->with('reporter')
                           ->get();

        // New Statistics Part
        $totalStudents = Student::where('teacher_id', $teacher->id)->count();
        $classStats = Student::where('teacher_id', $teacher->id)
            ->select('class', DB::raw('count(*) as total'))
            ->groupBy('class')
            ->get();
            
        $counseledStudentsCount = Student::where('teacher_id', $teacher->id)
            ->whereHas('archives', function($q) {
                $q->whereHas('report', function($q2) {
                    $q2->where('type', 'konsultasi');
                });
            })->count();
            
        $violationCount = Report::whereHas('student', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->where('type', 'pelaporan')->count();

        // Counseling Session Stats
        $totalSessions = \App\Models\CounselingSession::where('teacher_id', $teacher->id)->count();
        $topCategory = \App\Models\CounselingSession::where('teacher_id', $teacher->id)
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->first();
        $activeFollowUps = \App\Models\CounselingSession::where('teacher_id', $teacher->id)
            ->whereIn('status', ['monitoring', 'tindak_lanjut'])
            ->count();
        // Active period info
        $activePeriod = AcademicPeriod::active();
        $assignedClasses = [];
        if ($activePeriod && $teacher) {
            $assignedClasses = TeacherClassAssignment::where('academic_period_id', $activePeriod->id)
                ->where('teacher_id', $teacher->id)
                ->pluck('class')
                ->toArray();
        }
                           
        return view('gurubk.dashboard', compact(
            'pendingReports', 'myInProgressReports', 'myReports',
            'totalStudents', 'classStats', 'counseledStudentsCount', 'violationCount',
            'totalSessions', 'topCategory', 'activeFollowUps',
            'activePeriod', 'assignedClasses'
        ));
    }

    public function show(Report $report)
    {
        if ($report->handled_by !== Auth::id()) {
            return redirect()->route('gurubk.dashboard')->with('error', 'Anda tidak memiliki akses ke kasus ini.');
        }

        $report->load(['reporter', 'handler', 'chatMessages.sender']);

        return view('gurubk.reports.show', compact('report'));
    }

    public function claim(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        if ($report->status !== 'pending' || $report->handled_by !== null) {
            return back()->with('error', 'Kasus ini sudah diambil oleh guru lain.');
        }

        // Batasi maksimal 5 kasus aktif (gabungan laporan dan konsultasi) per Guru BK
        $activeCasesCount = Report::where('handled_by', Auth::id())
            ->where('status', 'in-progress')
            ->count();

        if ($activeCasesCount >= 5) {
            return back()->with('error', 'Batas maksimal penanganan kasus aktif adalah 5. Selesaikan kasus yang sedang ditangani sebelum mengambil kasus baru.');
        }

        $request->validate([
            'priority' => 'required|in:low,medium,high',
        ]);

        $report->update([
            'status' => 'in-progress',
            'handled_by' => Auth::id(),
            'priority' => $request->priority,
        ]);

        return back()->with('success', 'Kasus berhasil diambil.');
    }

    public function resolve(Report $report)
    {
        if ($report->handled_by !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses.');
        }

        // Self-Destruct: Delete all chat messages when case is resolved
        \App\Models\ChatMessage::where('report_id', $report->id)->update(['is_destroyed' => true]);

        $report->update(['status' => 'resolved']);

        // Create Archive entry
        $teacher = Auth::user()->teacher;
        
        // Find student if the reporter is a student AND not anonymous
        $student = null;
        if (!$report->is_anonymous && $report->reported_by) {
            $student = \App\Models\Student::where('user_id', $report->reported_by)->whereNotNull('user_id')->first();
        }

        $activePeriod = AcademicPeriod::active();

        \App\Models\Archive::create([
            'academic_period_id' => $activePeriod?->id,
            'student_id' => $student ? $student->id : null,
            'teacher_id' => $teacher->id,
            'handler_name' => $teacher->user->name ?? 'Guru BK',
            'report_id' => $report->id,
            'guidance_notes' => '[' . ucfirst($report->type) . '] ' . $report->title . ': ' . $report->content,
            'completed_date' => now(),
        ]);

        return back()->with('success', 'Kasus telah diselesaikan dan riwayat chat telah dihapus. Laporan telah masuk ke Arsip.');
    }
}

