<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Archive;
use App\Models\Letter;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        // Handle Surat (Letters) separately!
        if ($request->type === 'surat') {
            $lettersQuery = Letter::with('student.user')->where('teacher_id', $teacher->id);
            
            if ($request->has('name') && $request->name != '') {
                $searchName = $request->name;
                $lettersQuery->whereHas('student', function($q) use ($searchName) {
                    $q->where('name', 'like', '%' . $searchName . '%')
                      ->orWhereHas('user', function($q2) use ($searchName) {
                          $q2->where('name', 'like', '%' . $searchName . '%');
                      });
                });
            }
            
            if ($request->has('date') && $request->date != '') {
                $lettersQuery->whereDate('created_at', $request->date);
            }
            
            $letters = $lettersQuery->orderBy('created_at', 'desc')->get();
            
            return view('gurubk.archives.index', compact('letters'));
        }
        
        // Handle normal counseling/pelaporan archives!
        $query = Archive::with(['student.user', 'report.reporter'])->where('teacher_id', $teacher->id);
        
        if ($request->has('name') && $request->name != '') {
            $searchName = $request->name;
            $query->whereHas('student', function($q) use ($searchName) {
                $q->where('name', 'like', '%' . $searchName . '%')
                  ->orWhereHas('user', function($q2) use ($searchName) {
                      $q2->where('name', 'like', '%' . $searchName . '%');
                  });
            });
        }
        
        if ($request->has('type') && $request->type != '') {
            $query->whereHas('report', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('completed_date', $request->date);
        }
        
        // Exclude direct letter-only archives from this view
        $query->whereNotNull('report_id');
        
        $archives = $query->orderBy('completed_date', 'desc')->get();
        
        return view('gurubk.archives.index', compact('archives'));
    }

    public function show(Archive $archive)
    {
        $teacher = Auth::user()->teacher;
        
        if ($archive->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to archive.');
        }

        $archive->load(['student.user', 'report.reporter', 'report.handler']);
        
        return view('gurubk.archives.show', compact('archive'));
    }

    public function export(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $include_konsul = $request->has('konsul');
        $include_lapor = $request->has('lapor');
        $include_surat = $request->has('surat');
        
        $data = [];
        
        if ($include_konsul || $include_lapor) {
            $types = [];
            if ($include_konsul) $types[] = 'konsultasi';
            if ($include_lapor) $types[] = 'pelaporan';
            
            $data['archives'] = Archive::with(['student.user', 'report.reporter'])
                ->where('teacher_id', $teacher->id)
                ->whereHas('report', function($q) use ($types) {
                    $q->whereIn('type', $types);
                })
                ->orderBy('completed_date', 'desc')
                ->get();
        }
        
        if ($include_surat) {
            $data['letters'] = Letter::with('student.user')
                ->where('teacher_id', $teacher->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        if ($request->format === 'word') {
            $html = view('gurubk.archives.export_pdf', compact('data', 'teacher'))->render();
            $filename = 'Laporan_BK_' . now()->format('Ymd') . '.doc';
            
            return response($html)
                ->header('Content-Type', 'application/msword')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
        
        if ($request->format === 'excel') {
            $html = view('gurubk.archives.export_pdf', compact('data', 'teacher'))->render();
            $filename = 'Laporan_BK_' . now()->format('Ymd') . '.xls';
            
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }

        return back()->with('error', 'Format tidak didukung.');
    }
}
