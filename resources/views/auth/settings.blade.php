@extends('layouts.app')
@section('title', 'Pengaturan Akun - Sistem Informasi Bimbingan & Konseling')
@section('title_display', 'Pengaturan Akun')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Pengaturan Akun</h2>
            <p class="text-slate-500 font-medium">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>
        </div>
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-2xl text-sm font-bold shadow-sm">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-premium overflow-hidden bg-white">
        <div class="bg-[#1e1e2d] px-8 py-6 text-white flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold">Ubah Kata Sandi</h3>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">SIMBEKA Keamanan Sistem</p>
            </div>
            <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
        </div>

        <form action="{{ route('profile.password.update') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi Saat Ini <span class="text-rose-500">*</span></label>
                    <input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan kata sandi saat ini">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                    <input type="password" name="new_password" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                    <input type="password" name="new_password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Ulangi kata sandi baru">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                <button type="reset" class="px-8 py-4 text-slate-400 font-bold hover:text-slate-600 transition text-sm">Reset</button>
                <button type="submit" class="bg-primary hover:bg-secondary text-white font-black px-12 py-4 rounded-2xl shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.95]">
                    Simpan Sandi Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
