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
        return view('siswa.dashboard', compact('user'));
    }

    public function historyKonsultasi()
    {
        $user = Auth::user();
        $konsultasi = Report::where('reported_by', $user->id)
                            ->where('type', 'konsultasi')
                            ->where('is_hidden_for_reporter', false)
                            ->with('handler')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('siswa.history.konsultasi', compact('user', 'konsultasi'));
    }

    public function historyPelaporan()
    {
        $user = Auth::user();
        $pelaporan = Report::where('reported_by', $user->id)
                           ->where('type', 'pelaporan')
                           ->where('is_hidden_for_reporter', false)
                           ->with('handler')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('siswa.history.pelaporan', compact('user', 'pelaporan'));
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
