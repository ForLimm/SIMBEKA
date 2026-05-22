<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StudentRules;

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
            if ($request->teacher_id == 'unassigned') {
                $query->whereNull('teacher_id');
            } else {
                $query->where('teacher_id', $request->teacher_id);
            }
        }

        $students = $query->latest()->paginate(15);
        $classes = Student::whereNotNull('class')->distinct()->pluck('class');
        $teachers = Teacher::with('user')->get();

        return view('admin.students.index', compact('students', 'classes', 'teachers'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.students.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge(StudentRules::storeRules(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]), StudentRules::messages());

        // Generate username from email
        $username = strstr($request->email, '@', true);
        if (!$username || User::where('username', $username)->exists()) {
            $username = $username . '_' . Str::random(4);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'password' => 'nullable|min:6',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]), StudentRules::messages());

        $user = $student->user;
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

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
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;
            $class = $data['class'] ?? null;
            $nisn = $data['nisn'] ?? null;

            if (!$name || !$email || !$password || !$class) {
                $errors[] = "Baris #{$rowCount}: Kolom name, email, password, dan class wajib diisi.";
                continue;
            }

            if (User::where('email', $email)->exists()) {
                $errors[] = "Baris #{$rowCount}: Email '{$email}' sudah digunakan oleh pengguna lain.";
                continue;
            }

            if ($nisn && Student::where('nisn', $nisn)->exists()) {
                $errors[] = "Baris #{$rowCount}: NISN '{$nisn}' sudah terdaftar.";
                continue;
            }

            $username = strstr($email, '@', true);
            if (!$username || User::where('username', $username)->exists()) {
                $username = $username . '_' . Str::random(4);
            }

            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($password),
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
