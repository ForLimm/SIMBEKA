@extends('layouts.app')
@section('title', 'Selamat Datang di SIMBEKA - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 z-[-1] overflow-hidden">
    <div class="absolute inset-0 bg-slate-900/40 z-10 backdrop-blur-[2px]"></div>
    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover" alt="Background">
</div>

<div class="min-h-screen flex flex-col items-center justify-center px-4 text-center">
    <div class="max-w-4xl space-y-8 relative z-20">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-bold font-medium mb-4">
            <span class="w-2 h-2 bg-accent rounded-full animate-ping"></span>
            Sistem Informasi Manajemen Bimbingan & Konseling
        </div>
        
        <h1 class="text-5xl md:text-8xl font-semibold text-white tracking-tighter leading-none">
            Solusi Digital <br>
            <span class="text-blue-400">Bimbingan Siswa</span>
        </h1>
        
        <p class="text-lg md:text-xl text-slate-200 font-medium max-w-2xl mx-auto leading-relaxed">
            Platform modern untuk layanan bimbingan dan konseling yang aman, rahasia, dan terpercaya. Mendukung perkembangan karakter siswa secara maksimal.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
            @auth
                <a href="{{ auth()->user()->role === 'siswa' ? route('siswa.dashboard') : route('gurubk.dashboard') }}" class="w-full sm:w-auto bg-primary hover:bg-secondary text-white font-semibold px-12 py-5 rounded-lg shadow-md transition-all hover:scale-105 active:scale-95 text-lg">
                    Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-primary hover:bg-secondary text-white font-semibold px-12 py-5 rounded-lg shadow-md transition-all hover:scale-105 active:scale-95 text-lg">
                    Mulai Sekarang
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold px-12 py-5 rounded-lg border border-white/30 transition-all text-lg">
                    Daftar Akun
                </a>
            @endauth
        </div>

        <div class="pt-16 grid grid-cols-2 md:grid-cols-4 gap-8 opacity-60">
            <div class="text-white text-center">
                <div class="text-2xl font-semibold">100%</div>
                <div class="text-[10px] uppercase font-bold tracking-widest text-slate-300">Rahasia</div>
            </div>
            <div class="text-white text-center">
                <div class="text-2xl font-semibold">24/7</div>
                <div class="text-[10px] uppercase font-bold tracking-widest text-slate-300">Akses</div>
            </div>
            <div class="text-white text-center">
                <div class="text-2xl font-semibold">Daring</div>
                <div class="text-[10px] uppercase font-bold tracking-widest text-slate-300">Konsultasi</div>
            </div>
            <div class="text-white text-center">
                <div class="text-2xl font-semibold">Mudah</div>
                <div class="text-[10px] uppercase font-bold tracking-widest text-slate-300">Pelaporan</div>
            </div>
        </div>
    </div>
</div>
@endsection
