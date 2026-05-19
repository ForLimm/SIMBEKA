@extends('layouts.app')
@section('title', request('type') == 'surat' ? 'Arsip Surat Terbit - Sistem Informasi Manajemen Bimbingan & Konseling' : (request('type') == 'konseling' ? 'Arsip Sesi Bimbingan - Sistem Informasi Manajemen Bimbingan & Konseling' : 'Arsip Kasus & Bimbingan - Sistem Informasi Manajemen Bimbingan & Konseling'))
@section('title_display', request('type') == 'surat' ? 'Arsip Surat Terbit' : (request('type') == 'konseling' ? 'Arsip Sesi Bimbingan' : 'Arsip Kasus & Bimbingan'))

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4" x-data="{ showExport: false }">
        {{-- Tabs Navigation or Section Header --}}
        @if(request('type') !== 'surat')
            <div class="flex overflow-x-auto whitespace-nowrap p-1.5 bg-white border border-slate-100 rounded-3xl shadow-sm max-w-full custom-scrollbar shrink-0">
                <a href="{{ route('gurubk.archives.index') }}" 
                    class="px-6 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ !request('type') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:text-slate-900' }}">
                    Semua Kasus (Konsul & Lapor)
                </a>
                <a href="{{ route('gurubk.archives.index', ['type' => 'konseling']) }}" 
                    class="px-6 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ request('type') == 'konseling' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:text-slate-900' }}">
                    Konseling
                </a>
                <a href="{{ route('gurubk.archives.index', ['type' => 'konsultasi']) }}" 
                    class="px-6 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ request('type') == 'konsultasi' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:text-slate-900' }}">
                    Konsultasi
                </a>
                <a href="{{ route('gurubk.archives.index', ['type' => 'pelaporan']) }}" 
                    class="px-6 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ request('type') == 'pelaporan' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:text-slate-900' }}">
                    Pelaporan
                </a>
            </div>
        @else
            <div class="shrink-0">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Arsip Surat Terbit</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Daftar Surat Panggilan Orang Tua & Wali Siswa</p>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
            @if(request('type') == 'surat')
                <a href="{{ route('gurubk.letters.create') }}" class="w-full sm:w-auto bg-primary hover:bg-secondary text-white font-bold px-6 py-3.5 rounded-2xl transition shadow-lg shadow-primary/20 flex items-center justify-center gap-2 text-sm group">
                    <svg class="w-5 h-5 text-white/80 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Surat Panggilan
                </a>
            @endif

            <button @click="showExport = true" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-bold px-8 py-3.5 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center justify-center gap-2 text-sm group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Laporan Resmi
            </button>
        </div>

        {{-- Export Modal --}}
        <div x-show="showExport" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showExport = false" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="bg-primary p-8 text-white flex items-center justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-black italic uppercase tracking-widest text-sm">Konfigurasi Laporan</h3>
                        <p class="text-blue-100 text-[10px] font-bold uppercase tracking-widest mt-1 opacity-80">Pilih Data Terpadu</p>
                    </div>
                    <button @click="showExport = false" class="relative z-10 w-8 h-8 flex items-center justify-center bg-white/10 rounded-full text-white hover:bg-white/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('gurubk.archives.export') }}" method="GET" class="p-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4 ml-1">Gabungkan Jenis Data</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-6 h-6 rounded-lg border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="konsul" checked class="w-4 h-4 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800 leading-none">Riwayat Konsultasi</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Data Sesi BK Tatap Muka</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-6 h-6 rounded-lg border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="lapor" checked class="w-4 h-4 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800 leading-none">Riwayat Pelaporan</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Data Kasus & Insiden Siswa</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-6 h-6 rounded-lg border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="surat" checked class="w-4 h-4 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800 leading-none">Arsip Surat Terbit</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Surat Panggilan & Referensi</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4 ml-1">Format Dokumen</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="relative">
                                    <input type="radio" name="format" value="pdf" checked class="peer sr-only">
                                    <div class="py-4 px-1 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                        <span class="block text-xs font-black text-slate-800 peer-checked:text-primary uppercase tracking-widest">PDF</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="format" value="word" class="peer sr-only">
                                    <div class="py-4 px-1 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                        <span class="block text-xs font-black text-slate-800 peer-checked:text-primary uppercase tracking-widest">Word</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="format" value="excel" class="peer sr-only">
                                    <div class="py-4 px-1 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                        <span class="block text-xs font-black text-slate-800 peer-checked:text-primary uppercase tracking-widest">Excel</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" @click="setTimeout(() => showExport = false, 500)" class="w-full bg-primary hover:bg-secondary text-white font-black py-4 rounded-[1.5rem] shadow-xl shadow-primary/20 transition-all active:scale-[0.95] uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Laporan Terpadu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-premium overflow-hidden border-none shadow-xl shadow-slate-200/50">
        <div class="px-4 md:px-8 py-6 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            <div>
                <h3 class="font-black text-slate-800 text-xl tracking-tight">
                    @if(request('type') == 'surat')
                        Database Arsip Surat
                    @elseif(request('type') == 'konseling')
                        Database Arsip Konseling
                    @else
                        Database Arsip Kasus & Bimbingan
                    @endif
                </h3>
                <p class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-widest">
                    @if(request('type') == 'surat')
                        Kumpulan Surat Panggilan Resmi
                    @elseif(request('type') == 'konseling')
                        Dokumentasi Sesi Bimbingan / Konseling yang Telah Selesai
                    @else
                        Kumpulan Sesi Konsul & Laporan Selesai
                    @endif
                </p>
            </div>
            <div class="bg-slate-50 text-slate-400 text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest border border-slate-100 self-start sm:self-auto">
                @if(request('type') == 'surat')
                    {{ $letters->count() }}
                @elseif(request('type') == 'konseling')
                    {{ $sessions->count() }}
                @else
                    {{ $archives->count() }}
                @endif
                Data Ditemukan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                @if(request('type') == 'surat')
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Nama Siswa</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Jenis Surat</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Tujuan / Alasan Panggilan</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Tanggal Dibuat</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($letters as $letter)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center font-black border border-amber-100 transition-transform group-hover:scale-110 shadow-sm">
                                            {{ substr($letter->student->name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $letter->student->name ?? 'Tanpa Nama' }}</div>
                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kelas {{ $letter->student->class ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    @if(($letter->type ?? 'panggilan') == 'skorsing')
                                        <span class="bg-rose-50 border border-rose-100 text-rose-600 text-[9px] font-black px-2.5 py-1 rounded-xl uppercase tracking-widest">
                                            Surat Skorsing
                                        </span>
                                    @elseif(($letter->type ?? 'panggilan') == 'sp1')
                                        <span class="bg-amber-50 border border-amber-100 text-amber-600 text-[9px] font-black px-2.5 py-1 rounded-xl uppercase tracking-widest">
                                            Surat SP1
                                        </span>
                                    @elseif(($letter->type ?? 'panggilan') == 'sp2')
                                        <span class="bg-orange-50 border border-orange-100 text-orange-600 text-[9px] font-black px-2.5 py-1 rounded-xl uppercase tracking-widest">
                                            Surat SP2
                                        </span>
                                    @else
                                        <span class="bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-black px-2.5 py-1 rounded-xl uppercase tracking-widest">
                                            Surat Panggilan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-700 leading-snug max-w-xs">{{ $letter->content_json['reason'] ?? '-' }}</div>
                                    <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-widest">
                                        @if(($letter->type ?? 'panggilan') == 'skorsing')
                                            Durasi: {{ $letter->content_json['duration'] ?? '-' }} Hari | {{ isset($letter->content_json['start_date']) ? date('d M Y', strtotime($letter->content_json['start_date'])) : '-' }} s/d {{ isset($letter->content_json['end_date']) ? date('d M Y', strtotime($letter->content_json['end_date'])) : '-' }}
                                        @elseif(($letter->type ?? 'panggilan') == 'sp1' || ($letter->type ?? 'panggilan') == 'sp2')
                                            Dibuat: {{ $letter->created_at->format('d M Y') }}
                                        @else
                                            Rencana: {{ isset($letter->content_json['date']) ? date('d M Y', strtotime($letter->content_json['date'])) : '-' }} | Pukul {{ $letter->content_json['time'] ?? '09:00' }} WITA
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-700 text-xs">{{ $letter->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="text-[9px] text-slate-400 mt-1 font-bold">{{ $letter->created_at->translatedFormat('H:i') }} WITA</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-xl border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Unduh PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-sm">Arsip Surat Kosong</p>
                                            <p class="text-xs font-bold text-slate-300 mt-1 uppercase tracking-widest">Belum ada surat terbit yang dibuat</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @elseif(request('type') == 'konseling')
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Siswa</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Topik & Kategori</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Ringkasan Sesi</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Tanggal Selesai</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($sessions as $session)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 bg-primary/10 text-primary rounded-2xl flex items-center justify-center font-black border border-primary/20 transition-transform group-hover:scale-110 shadow-sm">
                                            {{ substr($session->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $session->student->name }}</div>
                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kelas {{ $session->student->class }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-700 leading-snug max-w-xs">
                                        {{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-0.5 rounded-md">
                                            {{ $session->category }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <p class="text-xs text-slate-500 font-medium line-clamp-2 max-w-xs italic leading-relaxed">"{{ $session->summary }}"</p>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-700 text-xs">
                                        {{ $session->completed_at ? $session->completed_at->translatedFormat('d M Y') : $session->counseling_date->translatedFormat('d M Y') }}
                                    </div>
                                    @if($session->completed_at)
                                        <div class="text-[9px] text-slate-400 mt-1 font-bold">{{ $session->completed_at->translatedFormat('H:i') }} WITA</div>
                                    @endif
                                    <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-tighter">Mulai: {{ $session->counseling_date->translatedFormat('d M Y') }}</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('gurubk.counseling.show', $session->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-xl border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                        Detail Sesi
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-sm">Arsip Kosong</p>
                                            <p class="text-xs font-bold text-slate-300 mt-1 uppercase tracking-widest">Belum ada sesi bimbingan yang diselesaikan</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @else
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Siswa / Pelapor</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Kategori & Topik Masalah</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Status Akhir</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Waktu Selesai</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($archives as $archive)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        @php
                                            $displayName = $archive->student->name ?? ($archive->report && $archive->report->reporter ? ($archive->report->reporter->username ?? $archive->report->reporter->name) : '-');
                                        @endphp
                                        <div class="w-11 h-11 bg-primary/10 text-primary rounded-2xl flex items-center justify-center font-black border border-primary/20 transition-transform group-hover:scale-110 shadow-sm">
                                            {{ substr($displayName, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $displayName }}</div>
                                            <div class="flex items-center gap-1.5">
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
                                                <span class="text-[9px] font-bold {{ $accountStatus === 'Akun Guest' ? 'text-amber-500' : ($accountStatus === 'Akun Regis' ? 'text-indigo-600' : 'text-slate-400') }} uppercase tracking-widest">{{ $accountStatus }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-700 leading-snug max-w-xs">
                                        {{ $archive->report->title ?? 'Sesi Bimbingan Mandiri' }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-[9px] font-black text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-0.5 rounded-md">
                                            {{ $archive->report && $archive->report->type === 'konsultasi' ? 'Konsultasi' : 'Pelaporan' }}
                                        </span>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded-md">
                                            Tiket #{{ str_pad($archive->id, 5, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-accent rounded-full"></div>
                                        <span class="font-black text-accent text-[10px] uppercase tracking-widest">Diselesaikan</span>
                                    </div>
                                    <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-tighter">Oleh: {{ $archive->teacher->user->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-700 text-xs">{{ $archive->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="text-[9px] text-slate-400 mt-1 font-bold">{{ $archive->created_at->translatedFormat('H:i') }} WITA</div>
                                    @if($archive->report)
                                        <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-tighter">
                                            Masuk: {{ $archive->report->created_at->translatedFormat('d M Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('gurubk.archives.show', $archive->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-xl border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                        Detail Kasus
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-sm">Arsip Kasung Kosong</p>
                                            <p class="text-xs font-bold text-slate-300 mt-1 uppercase tracking-widest">Belum ada kasus yang diselesaikan</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>

@if(session('download_pdf_path'))
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const pdfUrl = "{{ session('download_pdf_path') }}";
            
            // 1. Auto Preview in new tab
            const previewWin = window.open(pdfUrl, '_blank');
            
            // 2. Auto Download using a temporary link
            const link = document.createElement('a');
            link.href = pdfUrl;
            const filename = pdfUrl.substring(pdfUrl.lastIndexOf('/') + 1);
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
@endif
@endsection
