<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Student;
use App\Http\Requests\PasswordRules;

class RegisterController extends Controller
{
    public function register()
    {
        $teachers = \App\Models\Teacher::with('user')->withCount('students')->get();
        return view('auth.register', compact('teachers'));
    }

    public function registerPost(Request $request)
    {
        $request->validate(array_merge([
            'username' => 'required|string|unique:users,username',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
        ], PasswordRules::rules('password')), array_merge([
            'username.required' => 'Kolom Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan oleh akun lain.',
            'security_question.required' => 'Kolom Pertanyaan Keamanan wajib diisi.',
            'security_answer.required' => 'Kolom Jawaban Keamanan wajib diisi.',
        ], PasswordRules::messages('password')));

        $user = User::create([
            'name' => $request->username,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'recovery_code' => \Illuminate\Support\Facades\Crypt::encryptString($this->generateRecoveryCode()),
            'security_question' => $request->security_question,
            'security_answer' => Hash::make(strtolower($request->security_answer)),
        ]);

        Student::create([
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('siswa.dashboard')->with('show_recovery', true);
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
            'recovery_code' => \Illuminate\Support\Facades\Crypt::encryptString($this->generateRecoveryCode()),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')->with('show_recovery', true);
    }

    private function generateRecoveryCode()
    {
        return strtoupper(Str::random(4) . '-' . Str::random(4));
    }
}
