<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Http\Requests\StudentRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'teacher.user']);

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

        if ($request->filled('teacher_id')) {
            if ($request->teacher_id === 'unassigned') {
                $query->whereNull('teacher_id');
            } else {
                $query->where('teacher_id', $request->teacher_id);
            }
        }

        $students = $query->latest()->paginate(15)->withQueryString();
        $teachers = Teacher::with('user')->get();
        $classes = Student::whereNotNull('class')->distinct()->orderBy('class')->pluck('class');

        return view('admin.students.index', compact('students', 'teachers', 'classes'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.students.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge(StudentRules::storeRules(), [
            'teacher_id' => 'nullable|exists:teachers,id',
        ]), StudentRules::messages());

        $email = $request->nisn . '@siswa.simbeka.id';
        $username = 'siswa_' . $request->nisn;

        // Check if email or username is already taken
        if (User::where('email', $email)->exists() || User::where('username', $username)->exists()) {
            return back()->withInput()->withErrors(['nisn' => 'Email atau Username yang dihasilkan dari NISN ini sudah terdaftar.']);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($request->nisn),
            'role' => 'siswa',
        ]);

        $data = $request->only(StudentRules::safeFields());
        $data['user_id'] = $user->id;
        $data['teacher_id'] = $request->teacher_id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        Student::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $teachers = Teacher::with('user')->get();
        return view('admin.students.edit', compact('student', 'teachers'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate(array_merge(StudentRules::updateRules($student->id), [
            'teacher_id' => 'nullable|exists:teachers,id',
        ]), StudentRules::messages());

        $user = $student->user;
        $email = $request->nisn . '@siswa.simbeka.id';
        $username = 'siswa_' . $request->nisn;

        // Check if email or username is taken by a different user
        if (User::where('email', $email)->where('id', '!=', $user->id)->exists() || 
            User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
            return back()->withInput()->withErrors(['nisn' => 'Email atau Username yang dihasilkan dari NISN ini sudah terdaftar untuk siswa lain.']);
        }

        $user->update([
            'name' => $request->name,
            'username' => $username,
            'email' => $email,
        ]);

        $data = $request->only(StudentRules::safeFields());
        $data['teacher_id'] = $request->teacher_id;

        // Handle photo removal
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($student->photo && file_exists(public_path('storage/' . $student->photo))) {
                @unlink(public_path('storage/' . $student->photo));
            }
            $data['photo'] = null;
        }

        // Handle new photo upload
        if ($request->hasFile('photo')) {
            if ($student->photo && file_exists(public_path('storage/' . $student->photo))) {
                @unlink(public_path('storage/' . $student->photo));
            }
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:4096',
        ], [
            'file.required' => 'File CSV wajib diunggah.',
            'file.mimes' => 'Format file harus berupa CSV.',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $firstLine = fgets(fopen($path, 'r'));
        $separator = ',';
        if (str_contains($firstLine, ';')) {
            $separator = ';';
        }

        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle, 0, $separator);
        if (!$headers) {
            return back()->with('error', 'Format file CSV tidak valid.');
        }

        $headers = array_map(function($h) {
            return strtolower(trim(preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $h)));
        }, $headers);

        $rowCount = 0;
        $successCount = 0;
        $errors = [];

        while (($row = fgetcsv($handle, 0, $separator)) !== FALSE) {
            $rowCount++;
            if (empty(array_filter($row))) {
                continue;
            }

            $data = [];
            foreach ($headers as $index => $header) {
                if (isset($row[$index])) {
                    $data[$header] = trim($row[$index]);
                }
            }

            $name = $data['name'] ?? null;
            $class = $data['class'] ?? null;
            $nisn = $data['nisn'] ?? null;

            if (!$name || !$nisn || !$class) {
                $errors[] = "Baris #{$rowCount}: Kolom name, nisn, dan class wajib diisi.";
                continue;
            }

            // NISN validation length check
            if (strlen($nisn) !== 10 || !is_numeric($nisn)) {
                $errors[] = "Baris #{$rowCount}: NISN '{$nisn}' tidak valid (harus 10 digit angka).";
                continue;
            }

            $email = $nisn . '@siswa.simbeka.id';
            $username = 'siswa_' . $nisn;

            if (User::where('email', $email)->exists() || User::where('username', $username)->exists()) {
                $errors[] = "Baris #{$rowCount}: Siswa dengan NISN '{$nisn}' sudah terdaftar (Email/Username terpakai).";
                continue;
            }

            if (Student::where('nisn', $nisn)->exists()) {
                $errors[] = "Baris #{$rowCount}: NISN '{$nisn}' sudah terdaftar di database.";
                continue;
            }

            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($nisn),
                'role' => 'siswa',
            ]);

            Student::create([
                'user_id' => $user->id,
                'name' => $name,
                'nisn' => $nisn,
                'class' => $class,
                'gender' => $data['gender'] ?? 'Laki-laki',
                'religion' => $data['religion'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'father_name' => $data['father_name'] ?? null,
                'mother_name' => $data['mother_name'] ?? null,
            ]);

            $successCount++;
        }
        fclose($handle);

        $msg = "Berhasil mengimpor {$successCount} siswa.";
        if (count($errors) > 0) {
            return redirect()->route('admin.students.index')->with('success', $msg)->withErrors($errors);
        }

        return redirect()->route('admin.students.index')->with('success', $msg);
    }
}
