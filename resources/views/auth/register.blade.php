@extends('layouts.app')

@section('title', 'Daftar Akun Siswa - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 flex flex-col md:flex-row overflow-hidden bg-white">
    {{-- Left Column: Register Form --}}
    <div class="w-full md:w-[45%] flex items-center justify-center p-6 md:p-10 overflow-y-auto custom-scrollbar bg-white">
        <div class="w-full max-w-sm">
            {{-- Branding for Mobile --}}
            <div class="mb-6 md:hidden text-center">
                <h1 class="text-2xl font-black text-slate-900 leading-none">SIMBEKA.</h1>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-1.5">Pendaftaran Akun Baru</p>
            </div>

            <div class="mb-6 hidden md:block">
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-1 leading-tight tracking-tight">Registrasi Akun Baru</h1>
                <p class="text-slate-400 text-xs font-semibold">Buat akun untuk mulai menggunakan layanan BK.</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Username Untuk Login <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Contoh: siswa123" value="{{ old('username') }}">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Password <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                    </div>
                </div>

                <div class="space-y-1 pt-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Pertanyaan Keamanan (Pemulihan) <span class="text-rose-500">*</span></label>
                    <select name="security_question" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                        <option value="" disabled selected>Pilih pertanyaan rahasia</option>
                        <option value="Apa nama hewan peliharaan pertama Anda?">Apa nama hewan peliharaan pertama Anda?</option>
                        <option value="Nama sekolah dasar Anda?">Nama sekolah dasar Anda?</option>
                        <option value="Siapa nama guru favorit Anda?">Siapa nama guru favorit Anda?</option>
                        <option value="Di kota mana orang tua Anda bertemu?">Di kota mana orang tua Anda bertemu?</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Jawaban Anda <span class="text-rose-500">*</span></label>
                    <input type="text" name="security_answer" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Jawaban rahasia Anda">
                </div>

                <div class="pt-2 space-y-4 text-center">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-3 rounded-xl shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-xs uppercase tracking-widest">
                        Daftar Akun Baru
                    </button>
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-primary hover:underline font-black">Masuk Workspace</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Column: Branding --}}
    <div class="hidden md:flex md:w-[55%] bg-slate-900 relative items-center justify-center p-16 overflow-hidden text-right">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] bg-primary/20 rounded-full blur-[120px]"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[9px] font-black uppercase tracking-[0.2em] mb-8 ml-auto">
                Secure Registration
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">Satu Langkah Menuju <span class="text-primary italic block mt-1">Konsultasi.</span></h2>
            <div class="h-1 w-24 bg-primary mb-6 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-sm leading-relaxed mb-8 font-medium">Seluruh proses pendaftaran dirancang untuk melindungi identitas Anda. Username Anda adalah satu-satunya identitas yang diperlukan.</p>
            
            <div class="grid grid-cols-2 gap-6 text-right">
                <div class="p-3 bg-white/5 rounded-xl border border-white/5">
                    <h4 class="text-white font-black text-[10px] uppercase tracking-widest mb-1">Anonimitas</h4>
                    <p class="text-slate-500 text-[9px] leading-relaxed">Sistem tidak meminta data sensitif seperti email atau no HP.</p>
                </div>
                <div class="p-3 bg-white/5 rounded-xl border border-white/5">
                    <h4 class="text-white font-black text-[10px] uppercase tracking-widest mb-1">Keamanan</h4>
                    <p class="text-slate-500 text-[9px] leading-relaxed">Gunakan pertanyaan keamanan untuk memulihkan akun Anda kapan saja.</p>
                </div>
            </div>
        </div>
        
        <a href="/" class="absolute top-8 left-8 flex items-center gap-2 text-white/40 hover:text-white transition-colors text-[9px] font-black uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Beranda
        </a>
    </div>
</div>
@endsection
