<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    public function register()
    {
        $teachers = \App\Models\Teacher::with('user')->withCount('students')->get();
        return view('auth.register', compact('teachers'));
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->username,
            'username' => $request->username,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'siswa',
        ]);

        \App\Models\Student::create([
            'user_id' => $user->id,
        ]);

        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('siswa.dashboard');
    }

    public function manualLogin(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'], // can be email or username
            'password' => ['required'],
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.teachers.index');
            if ($role === 'guru_bk') return redirect()->route('gurubk.dashboard');
            if ($role === 'siswa') return redirect()->route('siswa.dashboard');
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function guestLogin(Request $request)
    {
        $words = ['mangga', 'apel', 'jeruk', 'anggur', 'pisang', 'bayam', 'kangkung', 'wortel', 'brokoli', 'tomat'];
        
        do {
            $username = $words[array_rand($words)] . rand(1000, 9999);
        } while (User::where('username', $username)->exists());

        $password = Str::random(16);

        $user = User::create([
            'name' => 'Tamu ' . rand(100, 999),
            'username' => $username,
            'password' => Hash::make($password),
            'role' => 'siswa',
            'is_guest' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
