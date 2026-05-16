<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CounselingSession;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class CounselingSessionController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        $query = CounselingSession::with('student')
            ->where('teacher_id', $teacher->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('counseling_date', $request->date);
        }

        $sessions = $query->latest('counseling_date')->paginate(10);
        return view('gurubk.counseling.index', compact('sessions', 'teacher'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        $students = Student::where('teacher_id', $teacher->id)->orderBy('name')->get();
        return view('gurubk.counseling.create', compact('students', 'teacher'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'counseling_date' => 'required|date',
            'category' => 'required|in:akademik,disiplin,keluarga,pertemanan,bullying,karier,pribadi,lainnya',
            'summary' => 'required|string',
            'follow_up' => 'nullable|string',
            'status' => 'required|in:selesai,monitoring,tindak_lanjut',
        ]);

        // Security check: ensure student belongs to teacher
        $student = Student::findOrFail($request->student_id);
        if ($student->teacher_id !== $teacher->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        CounselingSession::create(array_merge($request->all(), [
            'teacher_id' => $teacher->id
        ]));

        return redirect()->route('gurubk.counseling.index')->with('success', 'Catatan konseling berhasil disimpan.');
    }

    public function edit(CounselingSession $session)
    {
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Akses ditolak.');
        }

        $students = Student::where('teacher_id', $teacher->id)->orderBy('name')->get();
        return view('gurubk.counseling.edit', compact('session', 'students', 'teacher'));
    }

    public function update(Request $request, CounselingSession $session)
    {
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'counseling_date' => 'required|date',
            'category' => 'required|in:akademik,disiplin,keluarga,pertemanan,bullying,karier,pribadi,lainnya',
            'summary' => 'required|string',
            'follow_up' => 'nullable|string',
            'status' => 'required|in:selesai,monitoring,tindak_lanjut',
        ]);

        $session->update($request->all());

        return redirect()->route('gurubk.counseling.index')->with('success', 'Catatan konseling berhasil diperbarui.');
    }

    public function destroy(CounselingSession $session)
    {
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        $session->delete();
        return back()->with('success', 'Catatan konseling berhasil dihapus.');
    }
}
