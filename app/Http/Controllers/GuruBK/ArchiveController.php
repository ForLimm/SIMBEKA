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
        
        $query = Archive::with(['student.user'])->where('teacher_id', $teacher->id);
        
        if ($request->has('name') && $request->name != '') {
            $searchName = $request->name;
            $query->whereHas('student', function($q) use ($searchName) {
                $q->where('name', 'like', '%' . $searchName . '%')
                  ->orWhereHas('user', function($q2) use ($searchName) {
                      $q2->where('name', 'like', '%' . $searchName . '%');
                  });
            });
        }
        
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('completed_date', $request->date);
        }
        
        $archives = $query->orderBy('completed_date', 'desc')->get();
        
        return view('gurubk.archives.index', compact('archives'));
    }
}
