<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reports = Report::where('reported_by', $user->id)
                         ->where('is_hidden_for_reporter', false)
                         ->with('handler')
                         ->orderBy('created_at', 'desc')
                         ->get();

        $konsultasi = $reports->where('type', 'konsultasi');
        $pelaporan = $reports->where('type', 'pelaporan');

        return view('siswa.dashboard', compact('user', 'reports', 'konsultasi', 'pelaporan'));
    }

    public function hide(Report $report)
    {
        if ($report->reported_by !== Auth::id()) {
            abort(403);
        }

        $report->update(['is_hidden_for_reporter' => true]);

        return back()->with('success', 'Riwayat berhasil dihapus dari tampilan Anda.');
    }
}
