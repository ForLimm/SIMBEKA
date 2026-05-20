@extends('layouts.app')
@section('title', 'Detail Arsip - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Detail Arsip')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.archives.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Detail Arsip</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Arsip Catatan Bimbingan & Surat</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-400 font-medium">ID Arsip:</span>
            <span class="text-xs font-semibold text-slate-900 tracking-tighter">#{{ str_pad($archive->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left: Content --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-6 border-b border-slate-100 pb-2">Isi Catatan Bimbingan / Laporan</h4>
                
                @php
                    $rawNotes = $archive->guidance_notes;
                    $title = '';
                    $desc = '';
                    $category = '';

                    if (preg_match('/^\[(.*?)\] (.*?): (.*)$/s', $rawNotes, $matches)) {
                        $category = $matches[1];
                        $title = $matches[2];
                        $desc = $matches[3];
                    } elseif (preg_match('/^(.*?): (.*)$/s', $rawNotes, $matches)) {
                        $title = $matches[1];
                        $desc = $matches[2];
                        if (str_contains($title, 'Surat') || str_contains($title, 'SP1') || str_contains($title, 'SP2') || str_contains($title, 'Skorsing')) {
                            $category = 'Surat Terbit';
                        } else {
                            $category = 'Umum';
                        }
                    } else {
                        $desc = $rawNotes;
                    }

                    if (!$category && $archive->report) {
                        $category = $archive->report->type === 'konsultasi' ? 'Konsultasi' : 'Pelaporan';
                    }
                @endphp

                @if($title)
                    <div class="mb-6 bg-slate-50/50 p-6 rounded-lg border border-slate-100/80">
                        <span class="text-[9px] font-semibold text-slate-400 font-medium block mb-1">Topik Catatan / Kasus</span>
                        <h3 class="text-lg font-semibold text-slate-800 tracking-tight">{{ $title }}</h3>
                    </div>
                @endif

                <div class="relative">
                    <span class="text-[9px] font-semibold text-slate-400 font-medium block mb-3">Detail Deskripsi / Alasan</span>
                    <div class="bg-slate-50 rounded-[2rem] p-8 text-slate-700 leading-relaxed font-medium text-lg italic border border-slate-100 relative">
                        <svg class="w-12 h-12 text-slate-200 absolute -top-4 -left-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 14.899 16 16 16L19 16L19 13L16 13C13.239 13 11 15.239 11 18L11 21L14.017 21ZM5.017 21L5.017 18C5.017 16.899 5.899 16 7 16L10 16L10 13L7 13C4.239 13 2 15.239 2 18L2 21L5.017 21Z"></path></svg>
                        {{ $desc }}
                    </div>
                </div>

                @if($archive->attachment_path)
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-4">Lampiran Dokumen</h4>
                        <div class="flex items-center gap-4 bg-accent/10 border border-accent/20 p-6 rounded-[2rem]">
                            <div class="w-12 h-12 bg-accent text-white rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-slate-900 text-sm">Dokumen Surat Panggilan / Pendukung</p>
                                <p class="text-[10px] text-accent font-bold font-medium mt-0.5">Format: PDF Document</p>
                            </div>
                            <a href="{{ asset('storage/' . $archive->attachment_path) }}" target="_blank" class="bg-accent hover:bg-emerald-700 text-white text-[10px] font-semibold px-6 py-3 rounded-lg transition-all shadow-sm active:scale-95 font-medium">
                                Buka File
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Original Report Meta --}}
            @if($archive->report)
                <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8">
                    <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-6">Metadata Laporan Asli</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 font-medium">Judul Laporan</span>
                            <p class="font-bold text-slate-800 mt-1">{{ $archive->report->title }}</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 font-medium">Prioritas Awal</span>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-medium {{ $archive->report->priority === 'high' ? 'bg-rose-100 text-rose-600' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $archive->report->priority === 'high' ? 'Tinggi' : ($archive->report->priority === 'medium' ? 'Sedang' : 'Rendah') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Meta Info --}}
        <div class="space-y-6">
            {{-- Subject Info --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium mb-4">Informasi Subjek</h4>
                @php
                    $isAnonymous = $archive->report && $archive->report->is_anonymous;
                    $displayName = '-';
                    if ($isAnonymous) {
                        $displayName = $archive->report->reporter->username ?? 'Tamu';
                    } else {
                        $displayName = $archive->student->name ?? ($archive->report && $archive->report->reporter ? $archive->report->reporter->name : '-');
                    }
                @endphp
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary text-white rounded-lg flex items-center justify-center text-xl font-semibold shadow-sm">
                        {{ substr($displayName, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-slate-900 tracking-tight">{{ $displayName }}</div>
                        @php
                            $subjectUser = null;
                            if ($archive->student && $archive->student->user) {
                                $subjectUser = $archive->student->user;
                            } elseif ($archive->report && $archive->report->reporter) {
                                $subjectUser = $archive->report->reporter;
                            }

                            $accountStatus = 'Siswa Terdaftar';
                            if ($archive->report && $archive->report->is_anonymous) {
                                $accountStatus = 'Anonim';
                            } elseif ($subjectUser) {
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
                
                @if($archive->student && ($archive->student->nisn || $archive->student->class))
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-4">
                    @if($archive->student->nisn)
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">NISN</span>
                        <p class="text-xs font-semibold text-slate-800 tracking-wider">{{ $archive->student->nisn }}</p>
                    </div>
                    @endif
                    @if($archive->student->class)
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kelas / Jurusan</span>
                        <p class="text-xs font-bold text-slate-800">{{ $archive->student->class }}</p>
                    </div>
                    @endif
                </div>
                @endif

                @if($category)
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori Bimbingan</span>
                    <p class="mt-1.5">
                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-[9px] font-semibold uppercase rounded-md tracking-wider">
                            {{ $category }}
                        </span>
                    </p>
                </div>
                @endif
            </div>

            {{-- Officer Info --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6 bg-slate-900 text-white border-none shadow-xl shadow-slate-900/20">
                <h4 class="text-[10px] font-semibold text-slate-500 font-medium mb-4">Ditangani Oleh</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-800 text-white rounded-lg flex items-center justify-center text-sm font-semibold border border-slate-700">
                        {{ substr($archive->handler_name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold tracking-tight text-white">{{ $archive->handler_name ?? 'Guru BK' }}</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Petugas Penanganan</div>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-800 space-y-4">
                    @if($archive->report)
                    <div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                            Tanggal {{ $archive->report->type === 'konsultasi' ? 'Konsultasi' : 'Laporan' }}
                        </span>
                        <p class="text-xs font-bold text-slate-300 mt-1">
                            {{ $archive->report->created_at->translatedFormat('d M Y, H:i') }} WITA
                        </p>
                    </div>
                    @endif
                    <div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Selesai Pada</span>
                        <p class="text-xs font-bold text-slate-300 mt-1">
                            {{ $archive->created_at->translatedFormat('d M Y, H:i') }} WITA
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
