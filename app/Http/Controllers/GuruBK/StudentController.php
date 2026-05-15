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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:students,nisn',
            'class' => 'required|string',
            'birth_place' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'father_name' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'parents_job' => 'nullable|string',
            'parents_phone' => 'nullable|string',
            'parents_address' => 'nullable|string',
            'living_status' => 'nullable|string',
        ], [
            'nisn.size' => 'NISN harus berisi tepat 10 digit.',
        ]);

        $teacher = Auth::user()->teacher;

        // Check Quota
        $currentCount = Student::where('teacher_id', $teacher->id)->count();
        if ($currentCount >= $teacher->max_quota) {
            return back()->with('error', 'Kuota siswa bimbingan Anda sudah penuh (' . $teacher->max_quota . ').');
        }

        Student::create([
            'teacher_id' => $teacher->id,
            'name' => $request->name,
            'nisn' => $request->nisn,
            'class' => $request->class,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'address' => $request->address,
            'phone' => $request->phone,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parents_job' => $request->parents_job,
            'parents_phone' => $request->parents_phone,
            'parents_address' => $request->parents_address,
            'living_status' => $request->living_status,
        ]);

        return back()->with('success', 'Data siswa berhasil ditambahkan.');
    }
}
