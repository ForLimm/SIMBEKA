@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Ringkasan Sistem')

@section('content')
<div class="w-full space-y-8">
    {{-- Welcome Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight leading-none">Account Monitoring</h2>
            <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Statistik Akun Pengguna Sistem SIMBEKA</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-lg border border-white/10 shadow-sm">
            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-medium">Admin Mode</span>
        </div>
    </div>

    {{-- Stats Grid (Hanya Akun) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Guru BK --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 flex items-center gap-6 bg-white hover:border-primary/30 transition-all group">
            <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors duration-500 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-semibold text-slate-400 font-medium leading-none mb-2">Total Akun Guru BK</p>
                <h3 class="text-4xl font-semibold text-slate-900 tracking-tight">{{ $stats['total_teachers'] }}</h3>
            </div>
        </div>

        {{-- Akun Terdaftar (Manual) --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 flex items-center gap-6 bg-white hover:border-primary/30 transition-all group">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-lg flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-500 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-semibold text-slate-400 font-medium leading-none mb-2">Siswa Regis Manual</p>
                <h3 class="text-4xl font-semibold text-slate-900 tracking-tight">{{ $stats['total_manual_students'] }}</h3>
            </div>
        </div>

        {{-- Akun Guest --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 flex items-center gap-6 bg-white hover:border-amber-300/30 transition-all group">
            <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-500 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-semibold text-slate-400 font-medium leading-none mb-2">Total Akun Guest</p>
                <h3 class="text-4xl font-semibold text-slate-900 tracking-tight">{{ $stats['total_guests'] }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        {{-- Platform Security Info --}}
        <div class="xl:col-span-7">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-10 bg-slate-900 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="text-2xl font-semibold italic">Privasi Data Terjamin</h4>
                    </div>
                    <p class="text-slate-400 leading-relaxed mb-8">Sebagai Super Admin, Anda hanya memiliki otoritas untuk manajemen akun dan infrastruktur sistem. Data bimbingan, konsultasi, dan laporan bersifat privat dan hanya dapat diakses oleh Guru BK yang bersangkutan guna menjaga kerahasiaan siswa.</p>
                    
                    <div class="flex items-center gap-8">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            <span class="text-[10px] font-medium text-slate-300">Enkripsi Aktif</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            <span class="text-[10px] font-medium text-slate-300">Audit Logs Aktif</span>
                        </div>
                    </div>
                </div>
                {{-- Decor --}}
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-primary/10 rounded-full blur-[100px]"></div>
            </div>
        </div>

        {{-- Right Sidebar Dashboard --}}
        <div class="xl:col-span-5 space-y-6">
            {{-- Quick Links --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 bg-white">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-6">Administrasi Akun</h4>
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center justify-between p-5 bg-slate-50 rounded-lg border border-slate-100 hover:border-primary hover:bg-white transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-semibold text-slate-800">Master Data Guru BK</h5>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Kelola Akun Staf BK</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-primary transition-all translate-x-0 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.students.index') }}" class="flex items-center justify-between p-5 bg-slate-50 rounded-lg border border-slate-100 hover:border-primary hover:bg-white transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-semibold text-slate-800">Master Data Siswa</h5>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Kelola Basis Data Siswa</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-primary transition-all translate-x-0 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.academic_periods.index') }}" class="flex items-center justify-between p-5 bg-slate-50 rounded-lg border border-slate-100 hover:border-primary hover:bg-white transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-semibold text-slate-800">Periode Akademik</h5>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Kelola Tahun Ajaran & Semester</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-primary transition-all translate-x-0 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
