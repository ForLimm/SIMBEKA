<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Archive;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
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
}
