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
            'password' => 'required|min:6',
            'nip' => 'nullable|string|digits:18|unique:teachers,nip',
            'max_quota' => 'required|integer|min:1',
        ], [
            'name.regex' => 'Nama guru hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nip.digits' => 'NIP harus berisi tepat 18 digit angka.',
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
}
