@extends('layouts.app')
@section('title', 'Dashboard Siswa - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Menu Utama')

@section('content')
<div class="w-full space-y-8">
    {{-- Welcome Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-8 rounded-lg border border-slate-100 shadow-sm relative overflow-hidden group">
        {{-- Decorative element --}}
        
        
        <div class="relative z-10">
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight leading-none">Halo, {{ auth()->user()->username }}!</h2>
            <p class="text-slate-400 text-xs text-slate-500 font-medium mt-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Selamat Datang di Ruang Kerja Siswa
            </p>
        </div>
        
    </div>

    {{-- Menu Grid: Full Width --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Konsultasi Card --}}
        <a href="{{ route('lapor.create', ['type' => 'konsultasi']) }}" class="bg-white border border-slate-200 rounded-lg shadow-sm p-10 group transition-all hover:scale-[1.01] active:scale-[0.99] relative overflow-hidden bg-white border-slate-100 flex flex-col justify-between min-h-[300px]">
            {{-- Big Background Icon --}}
            

            <div class="relative z-10">
                <div class="bg-blue-50 text-primary w-12 h-12 rounded-lg flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-xl shadow-blue-500/10">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                </div>
                <h3 class="text-3xl font-semibold text-slate-800 tracking-tight mb-4">Konsultasi BK</h3>
                <p class="text-slate-400 font-medium leading-relaxed max-w-md">Curahkan segala permasalahan akademik, pribadi, atau karir Anda secara rahasia bersama Guru BK pilihan Anda.</p>
            </div>

            <div class="mt-12 flex items-center justify-between relative z-10">
                <div class="flex items-center gap-3 text-primary font-semibold  text-[10px]">
                    Mulai Konsultasi
                    <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
                <div class="px-4 py-2 bg-slate-50 rounded-lg text-[9px] font-bold text-slate-400 font-medium border border-slate-100 group-hover:bg-primary/5 group-hover:text-primary group-hover:border-primary/20 transition-all">Sangat Rahasia</div>
            </div>
        </a>

        {{-- Pelaporan Card --}}
        <a href="{{ route('lapor.create', ['type' => 'pelaporan']) }}" class="bg-white border border-slate-200 rounded-lg shadow-sm p-10 group transition-all hover:scale-[1.01] active:scale-[0.99] relative overflow-hidden bg-white border-slate-100 flex flex-col justify-between min-h-[300px]">
            {{-- Big Background Icon --}}
            

            <div class="relative z-10">
                <div class="bg-rose-50 text-rose-600 w-12 h-12 rounded-lg flex items-center justify-center mb-8 group-hover:bg-rose-600 group-hover:text-white transition-all duration-500 shadow-xl shadow-rose-500/10">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-3xl font-semibold text-slate-800 tracking-tight mb-4">Pelaporan Kasus</h3>
                <p class="text-slate-400 font-medium leading-relaxed max-w-md">Laporkan insiden, pelanggaran, atau perundungan yang terjadi di sekolah secara aman menggunakan akun terdaftar Anda.</p>
            </div>

            <div class="mt-12 flex items-center justify-between relative z-10">
                <div class="flex items-center gap-3 text-rose-600 font-semibold  text-[10px]">
                    Laporkan Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
                <div class="px-4 py-2 bg-slate-50 rounded-lg text-[9px] font-bold text-slate-400 font-medium border border-slate-100 group-hover:bg-rose-50 group-hover:text-rose-600 group-hover:border-rose-200 transition-all">Akses Keamanan</div>
            </div>
        </a>
    </div>

    {{-- Info Footer Section --}}
    <div class="bg-slate-900 rounded-lg p-10 text-white relative overflow-hidden group">
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-[100px] -mb-32 -mr-32 group-hover:scale-150 transition-transform duration-700"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            <div class="space-y-4">
                <h4 class="text-lg font-semibold italic">Bantuan & Dukungan</h4>
                <p class="text-slate-400 text-xs leading-relaxed font-medium">Jika Anda dalam situasi darurat atau membutuhkan bantuan segera, jangan ragu untuk melapor.</p>
            </div>
            <div class="space-y-4">
                <h4 class="text-lg font-semibold italic">Privasi Anda Prioritas</h4>
                <p class="text-slate-400 text-xs leading-relaxed font-medium">Sistem kami mengenkripsi identitas pelapor untuk menjamin keamanan batin Anda.</p>
            </div>
            <div class="flex items-center md:justify-end">
                <div class="px-6 py-3 border border-white/10 bg-white/5 rounded-lg flex items-center gap-3">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                    <span class="text-[10px] font-medium text-white">Sistem Aktif 24/7</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
