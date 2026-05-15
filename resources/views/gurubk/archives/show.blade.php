@extends('layouts.app')
@section('title', 'Detail Arsip - SIMBEKA')

@section('content')
<div class="mb-6">
    <a href="{{ route('gurubk.archives.index') }}" class="text-blue-600 hover:underline text-sm font-medium flex items-center gap-1">
        &larr; Kembali ke Daftar Arsip
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <div class="bg-gray-50 border-b px-6 py-4 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-800">Detail Arsip</h2>
        <span class="text-sm text-gray-500 italic">Diselesaikan pada: {{ $archive->completed_date ? $archive->completed_date->format('d M Y') : $archive->created_at->format('d M Y') }}</span>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            {{-- Info Siswa/Pelapor --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Informasi Subjek</h3>
                @if($archive->student)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $archive->student->name }}</p>
                            <p class="text-sm text-gray-500">Kelas: {{ $archive->student->class }} | NISN: {{ $archive->student->nisn }}</p>
                        </div>
                    </div>
                @elseif($archive->report)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">
                                {{ $archive->report->reporter->username ?? $archive->report->reporter->name ?? 'Pelapor' }}
                                @if($archive->report->is_anonymous)
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded ml-2 font-bold">ANONIM</span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 uppercase tracking-tight text-blue-600 font-medium">{{ $archive->report->type }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Info Petugas --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Ditangani Oleh</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $archive->teacher->user->name ?? 'Guru BK' }}</p>
                        <p class="text-sm text-gray-500">NIP: {{ $archive->teacher->nip ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mb-8">

        {{-- Isi Catatan/Kasus --}}
        <div>
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Catatan Bimbingan / Isi Laporan</h3>
            <div class="bg-gray-50 border border-gray-100 rounded-lg p-5">
                <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $archive->guidance_notes }}</p>
            </div>
        </div>

        @if($archive->attachment_path)
            <div class="mt-8">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Lampiran Terkait</h3>
                <div class="flex items-center gap-3 bg-blue-50 border border-blue-100 p-4 rounded-lg">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-blue-900">Dokumen Surat Panggilan</p>
                        <p class="text-xs text-blue-700">Format: PDF</p>
                    </div>
                    <a href="{{ asset('storage/' . $archive->attachment_path) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded transition">
                        Lihat PDF
                    </a>
                </div>
            </div>
        @endif

        @if($archive->report)
            <div class="mt-8 border-t pt-8">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Detail Laporan Asli</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-white border border-gray-200 p-3 rounded">
                        <span class="text-gray-500">Judul Laporan:</span>
                        <p class="font-medium text-gray-800">{{ $archive->report->title }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 p-3 rounded">
                        <span class="text-gray-500">Prioritas:</span>
                        <p class="font-medium">
                            <span class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $archive->report->priority === 'high' ? 'bg-red-100 text-red-700' : ($archive->report->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $archive->report->priority }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
