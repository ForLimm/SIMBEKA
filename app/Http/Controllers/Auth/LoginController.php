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
            'password' => 'required|min:6|confirmed',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->username,
            'username' => $request->username,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'siswa',
            'recovery_code' => $this->generateRecoveryCode(),
            'security_question' => $request->security_question,
            'security_answer' => $request->security_answer,
        ]);

        \App\Models\Student::create([
            'user_id' => $user->id,
        ]);

        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('siswa.dashboard')->with('show_recovery', true);
    }

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

    public function guestLogin(Request $request)
    {
        $words = [
            // Buah-buahan
            'Mangga', 'Apel', 'Jeruk', 'Anggur', 'Pisang', 'Semangka', 'Melon', 'Durian', 
            'Rambutan', 'Manggis', 'Kelapa', 'Jambu', 'Alpukat', 'Stroberi', 'Leci', 
            'Kelengkeng', 'Nangka', 'Pepaya', 'Nanas', 'BuahNaga', 'Markisa', 'Sirsak',
            // Sayur-sayuran
            'Bayam', 'Kangkung', 'Wortel', 'Brokoli', 'Tomat', 'Sawi', 'Kentang', 
            'Kubis', 'Terong', 'Jamur', 'Labu', 'Jagung', 'Buncis', 'Kacang', 
            'Seledri', 'Lobak', 'Paprika', 'Mentimun', 'Pare', 'Selada', 'Asparagus'
        ];
        
        do {
            $username = $words[array_rand($words)] . rand(100, 999);
        } while (User::where('username', $username)->exists());

        $password = Str::random(16);

        $user = User::create([
            'name' => $username,
            'username' => $username,
            'password' => Hash::make($password),
            'role' => 'siswa',
            'is_guest' => true,
            'recovery_code' => $this->generateRecoveryCode(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')->with('show_recovery', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function recoveryLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'recovery_code' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username tidak ditemukan.'])->onlyInput('username');
        }

        if (strtoupper($user->recovery_code) !== strtoupper($request->recovery_code)) {
            return back()->withErrors(['recovery_code' => 'Kode pemulihan salah. Silakan periksa kembali.'])->onlyInput('username');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('siswa.dashboard');
    }

    public function resetWithSecurity(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'username.required' => 'Kolom Username wajib diisi.',
            'security_question.required' => 'Kolom Pertanyaan Keamanan wajib diisi.',
            'security_answer.required' => 'Kolom Jawaban Keamanan wajib diisi.',
            'new_password.required' => 'Kolom Password Baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username tidak ditemukan.'])->onlyInput('username');
        }

        if ($user->security_question !== $request->security_question) {
            return back()->withErrors(['security_question' => 'Pertanyaan Keamanan yang dipilih tidak cocok dengan akun ini.'])->onlyInput('username');
        }

        if (strtolower($user->security_answer) !== strtolower($request->security_answer)) {
            return back()->withErrors(['security_answer' => 'Jawaban Keamanan Anda salah. Silakan coba lagi.'])->onlyInput('username');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('login')->with('success', 'Sandi berhasil diubah. Silakan masuk dengan sandi baru.');
    }

    private function generateRecoveryCode()
    {
        return strtoupper(Str::random(4) . '-' . Str::random(4));
    }

    public function showSettings()
    {
        return view('auth.settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*?&]/',  // must contain at least one special character
                'confirmed'
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&).',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password Anda berhasil diperbarui.');
    }
}
