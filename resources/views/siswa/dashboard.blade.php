@extends('layouts.app')
@section('title', 'Dashboard Siswa - SIMBEKA')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Dashboard Siswa</h2>
    <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}.
        @if(auth()->user()->is_guest)
            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded ml-1">Tamu</span>
        @endif
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Konsultasi --}}
    <a href="{{ route('lapor.create', ['type' => 'konsultasi']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm p-6 hover:border-blue-400 hover:shadow transition group">
        <div class="flex items-center gap-4 mb-3">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">Konsultasi BK</h3>
        </div>
        <p class="text-sm text-gray-500">Ceritakan masalah pribadi, akademik, atau karir Anda secara personal kepada Guru BK.</p>
    </a>

    {{-- Pelaporan --}}
    <a href="{{ route('lapor.create', ['type' => 'pelaporan']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm p-6 hover:border-red-400 hover:shadow transition group">
        <div class="flex items-center gap-4 mb-3">
            <div class="bg-red-100 text-red-600 p-3 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 group-hover:text-red-600 transition">Pelaporan Kasus</h3>
        </div>
        <p class="text-sm text-gray-500">Laporkan pelanggaran, perundungan, atau insiden di sekolah. Identitas Anda dijaga kerahasiaannya.</p>
    </a>
</div>
@endsection
