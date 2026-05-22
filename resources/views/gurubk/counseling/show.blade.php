@extends('layouts.app')
@section('title', 'Detail Sesi Bimbingan - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Detail Sesi Bimbingan')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.archives.index', ['type' => 'konseling']) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Detail Sesi Bimbingan</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Catatan Konseling Bimbingan & Konseling</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-400 font-medium">ID Sesi:</span>
            <span class="text-xs font-semibold text-slate-900 tracking-tighter">#{{ str_pad($session->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left: Content --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-6 border-b border-slate-100 pb-2">Ringkasan Sesi Konseling</h4>
                <div class="bg-slate-50 rounded-lg p-6 text-slate-700 leading-relaxed text-sm border border-slate-100 relative">
                    {{ $session->summary }}
                </div>

                @if($session->follow_up)
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-4">Rencana Tindak Lanjut</h4>
                        <div class="bg-primary/5 border border-primary/10 p-6 rounded-lg text-slate-700 leading-relaxed text-sm">
                            {{ $session->follow_up }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right: Meta Info --}}
        <div class="space-y-6">
            {{-- Subject Info --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-4">Informasi Subjek</h4>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary text-white rounded-lg flex items-center justify-center text-xl font-semibold shadow-sm">
                        {{ substr($session->student->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-slate-900 tracking-tight">{{ $session->student->name }}</div>
                        @php
                            $subjectUser = $session->student->user ?? null;
                            $accountStatus = 'Siswa Binaan';
                            if ($subjectUser) {
                                if ($subjectUser->is_guest) {
                                    $accountStatus = 'Akun Guest';
                                } else {
                                    $accountStatus = 'Akun Regis';
                                }
                            }
                        @endphp
                        <div class="text-[10px] {{ $accountStatus === 'Akun Guest' ? 'text-amber-500' : ($accountStatus === 'Akun Regis' ? 'text-indigo-600' : 'text-primary') }} font-semibold uppercase tracking-tighter">{{ $accountStatus }}</div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Topik / Judul</span>
                        <p class="text-xs font-semibold text-slate-800 leading-snug mt-0.5">{{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}</p>
                    </div>
                    @if($session->student->nisn)
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">NISN</span>
                        <p class="text-xs font-semibold text-slate-800 tracking-wider">{{ $session->student->nisn }}</p>
                    </div>
                    @endif
                    @if($session->student->class)
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kelas / Jurusan</span>
                        <p class="text-xs font-bold text-slate-800">{{ $session->student->class }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori Masalah</span>
                        <p class="mt-1">
                            <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-semibold uppercase rounded">
                                {{ $session->category }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Officer Info --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-4">Ditangani Oleh</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-100 text-slate-700 rounded-lg flex items-center justify-center text-sm font-semibold border border-slate-200">
                        {{ substr($session->teacher_name ?? ($session->teacher->user->name ?? '?'), 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-slate-900 tracking-tight">{{ $session->teacher_name ?? ($session->teacher->user->name ?? 'Guru BK') }}</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Guru BK</div>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Bimbingan</span>
                        <p class="text-xs font-semibold text-slate-800 mt-1">{{ $session->counseling_date->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Selesai Pada</span>
                        <p class="text-xs font-semibold text-slate-800 mt-1">
                            {{ $session->completed_at ? $session->completed_at->translatedFormat('d M Y, H:i') . ' WITA' : 'Belum Selesai' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
