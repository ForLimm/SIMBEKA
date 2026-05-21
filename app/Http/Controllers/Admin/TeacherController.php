<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordRules;

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
        $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|digits:18|unique:teachers,nip',
            'max_quota' => 'required|integer|min:1',
        ], PasswordRules::rules('password', true, false)), array_merge([
            'name.regex' => 'Nama guru hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nip.digits' => 'NIP harus berisi tepat 18 digit angka.',
        ], PasswordRules::messages('password')));

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
        $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'nip' => 'nullable|string|digits:18|unique:teachers,nip,' . $teacher->id,
            'max_quota' => 'required|integer|min:1',
        ], PasswordRules::rules('password', false, false)), array_merge([
            'name.regex' => 'Nama guru hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nip.digits' => 'NIP harus berisi tepat 18 digit angka.',
        ], PasswordRules::messages('password')));

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
