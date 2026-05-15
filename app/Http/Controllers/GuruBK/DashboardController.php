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
        $pendingReports = Report::where('status', 'pending')->get();
        
        $myReports = Report::where('handled_by', Auth::id())
                           ->whereIn('status', ['in-progress', 'resolved'])
                           ->get();
                           
        return view('gurubk.dashboard', compact('pendingReports', 'myReports'));
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
}
