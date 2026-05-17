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
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'guru_bk') return redirect()->route('gurubk.dashboard');
            if ($role === 'siswa') return redirect()->route('siswa.dashboard');
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
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

        $user = User::where('username', $request->username)
                    ->where('recovery_code', $request->recovery_code)
                    ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors(['recovery_code' => 'Username atau Kode Pemulihan tidak valid.']);
    }

    public function resetWithSecurity(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('username', $request->username)
                    ->where('security_question', $request->security_question)
                    ->where('security_answer', $request->security_answer)
                    ->first();

        if ($user) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silahkan masuk.');
        }

        return back()->withErrors(['security_answer' => 'Jawaban keamanan salah.']);
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
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
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
