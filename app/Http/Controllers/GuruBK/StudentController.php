<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StudentRules;

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
        $request->validate(StudentRules::storeRules(), StudentRules::messages());

        $teacher = Auth::user()->teacher;

        // Check Quota
        $currentCount = Student::where('teacher_id', $teacher->id)->count();
        if ($currentCount >= $teacher->max_quota) {
            return redirect()->route('gurubk.students.index')->with('error', 'Kuota siswa bimbingan Anda sudah penuh (' . $teacher->max_quota . ').');
        }

        Student::create(array_merge(
            $request->only(StudentRules::safeFields()),
            ['teacher_id' => $teacher->id]
        ));

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

        $request->validate(StudentRules::updateRules($student->id), StudentRules::messages());

        $student->update($request->only(StudentRules::safeFields()));

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

    public function bulkDestroy(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$request->has('student_ids')) {
            return back()->with('error', 'Tidak ada siswa yang dipilih.');
        }

        $ids = explode(',', $request->student_ids);
        
        // Ensure the teacher only deletes their own students
        $students = Student::whereIn('id', $ids)->where('teacher_id', $teacher->id)->get();
        foreach ($students as $student) {
            $student->delete();
        }

        return back()->with('success', 'Data siswa terpilih berhasil dihapus.');
    }
}
