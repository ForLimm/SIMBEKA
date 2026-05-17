<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function create()
    {
        $teachers = Teacher::with('user')->withCount('students')->get();
        return view('admin.students.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nisn' => 'nullable|string|digits:10|unique:students,nisn',
            'class' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
        ], [
            'name.regex' => 'Nama siswa hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nisn.digits' => 'NISN harus berisi tepat 10 digit angka.',
        ]);

        $teacher = Teacher::withCount('students')->findOrFail($request->teacher_id);
        
        if ($teacher->students_count >= $teacher->max_quota) {
            return back()->withErrors(['teacher_id' => 'Kuota Penuh untuk guru BK ini.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        Student::create([
            'user_id' => $user->id,
            'teacher_id' => $teacher->id,
            'nisn' => $request->nisn,
            'class' => $request->class,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }
}
