<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->withCount('students')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*?&]/',  // must contain at least one special character
            ],
            'nip' => 'nullable|string|digits:18|unique:teachers,nip',
            'max_quota' => 'required|integer|min:1',
        ], [
            'name.regex' => 'Nama guru hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nip.digits' => 'NIP harus berisi tepat 18 digit angka.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&).',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru_bk',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'max_quota' => $request->max_quota,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Guru BK berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'password' => [
                'nullable',
                'min:8',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*?&]/',  // must contain at least one special character
            ],
            'nip' => 'nullable|string|digits:18|unique:teachers,nip,' . $teacher->id,
            'max_quota' => 'required|integer|min:1',
        ], [
            'name.regex' => 'Nama guru hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nip.digits' => 'NIP harus berisi tepat 18 digit angka.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&).',
        ]);

        $user = $teacher->user;
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

        $teacher->update([
            'nip' => $request->nip,
            'max_quota' => $request->max_quota,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru BK berhasil diperbarui.');
    }
}
