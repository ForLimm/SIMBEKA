<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function manualLogin(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'login.required' => 'Kolom Username atau Email wajib diisi.',
            'password.required' => 'Kolom Password wajib diisi.',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where('email', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Username atau Email tidak terdaftar dalam sistem kami.',
            ])->onlyInput('login');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Kata sandi yang Anda masukkan salah. Silakan coba lagi.',
            ])->onlyInput('login');
        }

        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'guru_bk') return redirect()->route('gurubk.dashboard');
            if ($role === 'siswa') return redirect()->route('siswa.dashboard');
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Gagal masuk. Silakan periksa kembali akun Anda.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
