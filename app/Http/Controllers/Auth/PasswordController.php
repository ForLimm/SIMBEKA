<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\PasswordRules;

class PasswordController extends Controller
{
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

        if (!$user->is_guest) {
            return back()->withErrors(['recovery_code' => 'Akun ini sudah memiliki password. Silakan gunakan password Anda atau reset melalui Pertanyaan Keamanan.'])->onlyInput('username');
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
        $request->validate(array_merge([
            'username' => 'required|string',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
        ], PasswordRules::rules('new_password')), array_merge([
            'username.required' => 'Kolom Username wajib diisi.',
            'security_question.required' => 'Kolom Pertanyaan Keamanan wajib diisi.',
            'security_answer.required' => 'Kolom Jawaban Keamanan wajib diisi.',
        ], PasswordRules::messages('new_password')));

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username tidak ditemukan.'])->onlyInput('username');
        }

        if ($user->security_question !== $request->security_question) {
            return back()->withErrors(['security_question' => 'Pertanyaan Keamanan yang dipilih tidak cocok dengan akun ini.'])->onlyInput('username');
        }

        if (!Hash::check(strtolower($request->security_answer), $user->security_answer)) {
            return back()->withErrors(['security_answer' => 'Jawaban Keamanan Anda salah. Silakan coba lagi.'])->onlyInput('username');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('login')->with('success', 'Sandi berhasil diubah. Silakan masuk dengan sandi baru.');
    }

    public function showSettings()
    {
        return view('auth.settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate(array_merge([
            'current_password' => 'required',
        ], PasswordRules::rules('new_password')), array_merge([
            'current_password.required' => 'Password saat ini wajib diisi.',
        ], PasswordRules::messages('new_password')));

        $user = auth()->user();
        $verified = false;
        $wasGuest = $user->is_guest;

        if (Hash::check($request->current_password, $user->password)) {
            $verified = true;
        } elseif ($user->is_guest && strtoupper($request->current_password) === strtoupper($user->recovery_code)) {
            $verified = true;
        }

        if (!$verified) {
            $errorMsg = $user->is_guest 
                ? 'Password saat ini atau Kode Pemulihan salah.' 
                : 'Password saat ini salah.';
            return back()->withErrors(['current_password' => $errorMsg]);
        }

        $updateData = [
            'password' => Hash::make($request->new_password),
        ];

        // Guest yang berhasil set password → naik status jadi user biasa
        if ($wasGuest) {
            $updateData['is_guest'] = false;
            $updateData['recovery_code'] = strtoupper(\Illuminate\Support\Str::random(4) . '-' . \Illuminate\Support\Str::random(4));
        }

        $user->update($updateData);

        $message = $wasGuest
            ? 'Password berhasil diatur! Akun Anda sekarang sudah menjadi akun permanen.'
            : 'Password Anda berhasil diperbarui.';

        return back()->with('success', $message);
    }
}
