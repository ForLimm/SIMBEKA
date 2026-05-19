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
            ->where('teacher_id', $teacher->id)
            ->where('status', '!=', 'selesai');

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
            'title' => 'required|string|max:255',
            'counseling_date' => 'required|date',
            'category' => 'required|string|max:255',
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
            'teacher_id' => $teacher->id,
            'completed_at' => $request->status === 'selesai' ? now() : null
        ]));

        if ($request->status === 'selesai') {
            return redirect()->route('gurubk.archives.index', ['type' => 'konseling'])->with('success', 'Catatan bimbingan berhasil diselesaikan dan diarsipkan.');
        }

        return redirect()->route('gurubk.counseling.index')->with('success', 'Catatan konseling berhasil disimpan.');
    }

    public function show(CounselingSession $counseling)
    {
        $session = $counseling;
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Akses ditolak.');
        }

        $session->load('student');
        return view('gurubk.counseling.show', compact('session', 'teacher'));
    }

    public function edit(CounselingSession $counseling)
    {
        $session = $counseling;
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Akses ditolak.');
        }

        if ($session->status === 'selesai') {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Catatan konseling yang telah selesai tidak dapat diubah.');
        }

        $students = Student::where('teacher_id', $teacher->id)->orderBy('name')->get();
        return view('gurubk.counseling.edit', compact('session', 'students', 'teacher'));
    }

    public function update(Request $request, CounselingSession $counseling)
    {
        $session = $counseling;
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Akses ditolak.');
        }

        if ($session->status === 'selesai') {
            return redirect()->route('gurubk.counseling.index')->with('error', 'Catatan konseling yang telah selesai tidak dapat diubah.');
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'counseling_date' => 'required|date',
            'category' => 'required|string|max:255',
            'summary' => 'required|string',
            'follow_up' => 'nullable|string',
            'status' => 'required|in:selesai,monitoring,tindak_lanjut',
        ]);

        $session->update(array_merge($request->all(), [
            'completed_at' => $request->status === 'selesai' ? ($session->completed_at ?? now()) : null
        ]));

        if ($request->status === 'selesai') {
            return redirect()->route('gurubk.archives.index', ['type' => 'konseling'])->with('success', 'Catatan konseling diselesaikan dan dipindahkan ke arsip.');
        }

        return redirect()->route('gurubk.counseling.index')->with('success', 'Catatan konseling berhasil diperbarui.');
    }

    public function destroy(CounselingSession $counseling)
    {
        $session = $counseling;
        $teacher = Auth::user()->teacher;
        if ($session->teacher_id !== $teacher->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        if ($session->status === 'selesai') {
            return back()->with('error', 'Catatan konseling yang telah selesai tidak dapat dihapus.');
        }

        $session->delete();
        return back()->with('success', 'Catatan konseling berhasil dihapus.');
    }
}
