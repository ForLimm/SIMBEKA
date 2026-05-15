<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingReports = Report::where('status', 'pending')->with('reporter')->get();
        
        $myReports = Report::where('handled_by', Auth::id())
                           ->whereIn('status', ['in-progress', 'resolved'])
                           ->with('reporter')
                           ->get();
                           
        return view('gurubk.dashboard', compact('pendingReports', 'myReports'));
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

        $report->update([
            'status' => 'in-progress',
            'handled_by' => Auth::id(),
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

        \App\Models\Archive::create([
            'student_id' => $student ? $student->id : null,
            'teacher_id' => $teacher->id,
            'report_id' => $report->id,
            'guidance_notes' => '[' . ucfirst($report->type) . '] ' . $report->title . ': ' . $report->content,
            'completed_date' => now(),
        ]);

        return back()->with('success', 'Kasus telah diselesaikan dan riwayat chat telah dihapus. Laporan telah masuk ke Arsip.');
    }
}

