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
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return redirect('/')->with('error', 'Anda belum dikonfigurasi sebagai Guru BK oleh Admin.');
        }

        $query = Student::with('user')->where('teacher_id', $teacher->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        $students = $query->latest()->get();
        return view('gurubk.students.index', compact('students', 'teacher'));
    }

    public function show(Student $student)
    {
        $teacher = Auth::user()->teacher;
        
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('gurubk.students.index')->with('error', 'Akses ditolak.');
        }

        $student->load([
            'teacher.user', 
            'reports' => function($q) {
                $q->where('type', 'pelaporan')->latest();
            }, 
            'reports.reporter', 
            'archives' => function($q) {
                $q->latest();
            },
            'archives.report'
        ]);

        return view('gurubk.students.show', compact('student', 'teacher'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        return view('gurubk.students.create', compact('teacher'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'nisn' => 'required|string|digits:10|unique:students,nisn',
            'class' => 'required|string',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
            'birth_place' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'birth_date' => 'nullable|date|before:today',
            'living_status' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|digits_between:10,15',
            'father_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'mother_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'parents_job' => 'nullable|string|max:255',
            'parents_phone' => 'nullable|string|digits_between:10,15',
            'parents_address' => 'nullable|string|max:1000',
        ], [
            'name.regex' => 'Nama siswa hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nisn.digits' => 'NISN harus berupa 10 digit angka.',
            'phone.digits_between' => 'Nomor HP siswa harus berupa angka antara 10 sampai 15 digit.',
            'father_name.regex' => 'Nama ayah hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'mother_name.regex' => 'Nama ibu hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'parents_phone.digits_between' => 'Nomor HP orang tua harus berupa angka antara 10 sampai 15 digit.',
            'birth_place.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
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
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'nisn' => 'required|string|digits:10|unique:students,nisn,' . $student->id,
            'class' => 'required|string',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
            'birth_place' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'birth_date' => 'nullable|date|before:today',
            'living_status' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|digits_between:10,15',
            'father_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'mother_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'parents_job' => 'nullable|string|max:255',
            'parents_phone' => 'nullable|string|digits_between:10,15',
            'parents_address' => 'nullable|string|max:1000',
        ], [
            'name.regex' => 'Nama siswa hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nisn.digits' => 'NISN harus berupa 10 digit angka.',
            'phone.digits_between' => 'Nomor HP siswa harus berupa angka antara 10 sampai 15 digit.',
            'father_name.regex' => 'Nama ayah hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'mother_name.regex' => 'Nama ibu hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'parents_phone.digits_between' => 'Nomor HP orang tua harus berupa angka antara 10 sampai 15 digit.',
            'birth_place.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
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
