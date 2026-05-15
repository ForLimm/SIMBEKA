<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/')->with('error', 'Anda belum dikonfigurasi sebagai Guru BK oleh Admin.');
        }
        $students = Student::with('user')->where('teacher_id', $teacher->id)->latest()->get();
        return view('gurubk.students.index', compact('students', 'teacher'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        return view('gurubk.students.create', compact('teacher'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:students,nisn',
            'class' => 'required|string',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            // Other fields are optional but validated
        ], [
            'nisn.size' => 'NISN harus berisi tepat 10 digit.',
        ]);

        $teacher = Auth::user()->teacher;

        // Check Quota
        $currentCount = Student::where('teacher_id', $teacher->id)->count();
        if ($currentCount >= $teacher->max_quota) {
            return redirect()->route('gurubk.students.index')->with('error', 'Kuota siswa bimbingan Anda sudah penuh (' . $teacher->max_quota . ').');
        }

        Student::create(array_merge($request->all(), ['teacher_id' => $teacher->id]));

        return redirect()->route('gurubk.students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $teacher = Auth::user()->teacher;
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.students.index')->with('error', 'Akses ditolak.');
        }
        return view('gurubk.students.edit', compact('student', 'teacher'));
    }

    public function update(Request $request, Student $student)
    {
        $teacher = Auth::user()->teacher;
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.students.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:students,nisn,' . $student->id,
            'class' => 'required|string',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
        ]);

        $student->update($request->all());

        return redirect()->route('gurubk.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }
    public function destroy(Student $student)
    {
        $teacher = Auth::user()->teacher;
        
        if ($student->teacher_id !== $teacher->id) {
            return back()->with('error', 'Anda tidak memiliki otoritas untuk menghapus siswa ini.');
        }

        $student->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}
