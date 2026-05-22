@extends('layouts.app')
@section('title', request('type') == 'surat' ? 'Arsip Surat Terbit - Sistem Informasi Manajemen Bimbingan & Konseling' : (request('type') == 'konseling' ? 'Arsip Sesi Bimbingan - Sistem Informasi Manajemen Bimbingan & Konseling' : 'Arsip Kasus & Bimbingan - Sistem Informasi Manajemen Bimbingan & Konseling'))
@section('title_display', request('type') == 'surat' ? 'Arsip Surat Terbit' : (request('type') == 'konseling' ? 'Arsip Sesi Bimbingan' : 'Arsip Kasus & Bimbingan'))

@section('content')
@php
    $now = now();
    $currentYear = $now->year;
    $currentMonth = $now->month;
    if ($currentMonth >= 7 && $currentMonth <= 12) {
        $currSem = '1';
        $currYear = $currentYear . '/' . ($currentYear + 1);
    } else {
        $currSem = '2';
        $currYear = ($currentYear - 1) . '/' . $currentYear;
    }
    $currKey = $currYear . '_' . $currSem;
@endphp
<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4" x-data="{ showExport: false, showExportSurat: false }">
        {{-- Tabs Navigation or Section Header --}}
        @if(request('type') !== 'surat')
            <div class="flex overflow-x-auto whitespace-nowrap p-1.5 bg-white border border-slate-100 rounded-lg shadow-sm max-w-full custom-scrollbar shrink-0">
                <a href="{{ route('gurubk.archives.index') }}" 
                    class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all shrink-0 {{ !request('type') ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                    Semua Kasus
                </a>
                <a href="{{ route('gurubk.archives.index', ['type' => 'konseling']) }}" 
                    class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all shrink-0 {{ request('type') == 'konseling' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                    Konseling
                </a>
                <a href="{{ route('gurubk.archives.index', ['type' => 'konsultasi']) }}" 
                    class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all shrink-0 {{ request('type') == 'konsultasi' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                    Konsultasi
                </a>
                <a href="{{ route('gurubk.archives.index', ['type' => 'pelaporan']) }}" 
                    class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all shrink-0 {{ request('type') == 'pelaporan' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                    Pelaporan
                </a>
            </div>
        @else
            <div class="shrink-0">
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Arsip Surat Terbit</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Daftar Surat Panggilan Orang Tua & Wali Siswa</p>
            </div>
        @endif
 
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
            @if(request('type') == 'surat')
                <button @click="showExportSurat = true" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-bold px-8 py-3.5 rounded-lg hover:bg-slate-50 transition shadow-sm flex items-center justify-center gap-2 text-sm group">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Laporan Resmi
                </button>
            @else
                <button @click="showExport = true" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-bold px-8 py-3.5 rounded-lg hover:bg-slate-50 transition shadow-sm flex items-center justify-center gap-2 text-sm group">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Arsip Bimbingan
                </button>
            @endif
        </div>

        {{-- Export Modal --}}
        <div x-show="showExport" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showExport = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="bg-primary p-8 text-white flex items-center justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-semibold text-sm">Konfigurasi Ekspor Arsip Bimbingan</h3>
                        <p class="text-blue-100 text-xs font-medium mt-1 opacity-80">Pilih Data Terpadu (Format PDF)</p>
                    </div>
                    <button @click="showExport = false" class="relative z-10 w-8 h-8 flex items-center justify-center bg-white/10 rounded-full text-white hover:bg-white/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('gurubk.archives.export') }}" method="GET" class="p-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-semibold text-slate-400 block mb-4 ml-1">Gabungkan Jenis Data</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-6 h-6 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="konseling" checked class="w-4 h-4 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800 leading-none">Riwayat Konseling</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Data Sesi Bimbingan Selesai</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-6 h-6 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="konsultasi" checked class="w-4 h-4 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800 leading-none">Riwayat Konsultasi</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Data Sesi BK Tatap Muka</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-6 h-6 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="pelaporan" checked class="w-4 h-4 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800 leading-none">Riwayat Pelaporan</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Data Kasus & Pelaporan Siswa</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-semibold text-slate-400 block mb-1 ml-1">Filter Tahun Ajaran & Semester (Opsional)</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative">
                                <select name="academic_year" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium text-slate-700 pr-8">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <div class="relative">
                                <select name="semester" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium text-slate-700 pr-8">
                                    <option value="">Semua Semester</option>
                                    <option value="1">Semester 1 (Ganjil)</option>
                                    <option value="2">Semester 2 (Genap)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" @click="setTimeout(() => showExport = false, 500)" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-4 rounded-lg shadow-xl shadow-primary/20 transition-all active:scale-[0.95] text-xs flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Laporan PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Export Surat Modal --}}
        <div x-show="showExportSurat" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showExportSurat = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="bg-primary p-8 text-white flex items-center justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-semibold text-sm">Konfigurasi Ekspor Laporan Resmi</h3>
                        <p class="text-blue-100 text-xs font-medium mt-1 opacity-80">Pilih Data Terpadu (Format PDF)</p>
                    </div>
                    <button @click="showExportSurat = false" class="relative z-10 w-8 h-8 flex items-center justify-center bg-white/10 rounded-full text-white hover:bg-white/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('gurubk.archives.export') }}" method="GET" class="p-8 space-y-6">
                    <input type="hidden" name="surat" value="1">
                    <input type="hidden" name="format" value="pdf">

                    <div>
                        <label class="text-[10px] font-semibold text-slate-400 block mb-4 ml-1">Pilih Jenis Surat</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-5 h-5 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="letter_types[]" value="panggilan" checked class="w-3.5 h-3.5 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-800 leading-none">Surat Panggilan</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Panggilan Wali</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-5 h-5 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="letter_types[]" value="sp1" checked class="w-3.5 h-3.5 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-800 leading-none">Surat SP1</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Peringatan Pertama</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-5 h-5 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="letter_types[]" value="sp2" checked class="w-3.5 h-3.5 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-800 leading-none">Surat SP2</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Peringatan Kedua</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-lg border border-slate-100 cursor-pointer hover:border-primary/30 transition-all group">
                                <div class="w-5 h-5 rounded border-2 border-slate-200 flex items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="letter_types[]" value="skorsing" checked class="w-3.5 h-3.5 rounded text-primary focus:ring-primary border-none bg-transparent">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-800 leading-none">Surat Skorsing</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-1">Pemberitahuan Skorsing</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-semibold text-slate-400 block mb-1 ml-1">Filter Tahun Ajaran & Semester (Opsional)</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative">
                                <select name="academic_year" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium text-slate-700 pr-8">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <div class="relative">
                                <select name="semester" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium text-slate-700 pr-8">
                                    <option value="">Semua Semester</option>
                                    <option value="1">Semester 1 (Ganjil)</option>
                                    <option value="2">Semester 2 (Genap)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" @click="setTimeout(() => showExportSurat = false, 500)" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-4 rounded-lg shadow-xl shadow-primary/20 transition-all active:scale-[0.95] text-xs flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Laporan PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif

            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="name" value="{{ request('name') }}" 
                    class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 pl-12 pr-4 text-sm font-bold placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all" 
                    placeholder="Cari Nama Siswa...">
            </div>
            
            <div class="w-full md:w-56 relative">
                <select name="academic_year" class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 pr-10 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="w-full md:w-48 relative">
                <select name="semester" class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 pr-10 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Semester</option>
                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-8 py-3 rounded-lg transition shadow-sm active:scale-95 text-sm">
                Filter
            </button>
            
            @if(request('name') || request('academic_year') || request('semester'))
                <a href="{{ route('gurubk.archives.index', request()->only('type')) }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold px-6 py-3 rounded-lg transition active:scale-95 text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden border-none shadow-xl shadow-slate-200/50">
        <div class="px-4 md:px-8 py-6 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            <div>
                <h3 class="font-semibold text-slate-800 text-xl tracking-tight">
                    @if(request('type') == 'surat')
                        Database Arsip Surat
                    @elseif(request('type') == 'konseling')
                        Database Arsip Konseling
                    @else
                        Database Arsip Kasus & Bimbingan
                    @endif
                </h3>
                <p class="text-xs text-slate-400 mt-1 font-bold font-medium">
                    @if(request('type') == 'surat')
                        Kumpulan Surat Panggilan Resmi
                    @elseif(request('type') == 'konseling')
                        Dokumentasi Sesi Bimbingan / Konseling yang Telah Selesai
                    @else
                        Kumpulan Sesi Konsul & Laporan Selesai
                    @endif
                </p>
            </div>
            <div class="bg-slate-50 text-slate-400 text-[10px] font-semibold px-4 py-2 rounded-lg font-medium border border-slate-100 self-start sm:self-auto">
                @php
                    $totalItems = 0;
                    if(request('type') == 'surat') {
                        foreach($letters as $group) {
                            $totalItems += count($group['items']);
                        }
                    } elseif(request('type') == 'konseling') {
                        foreach($sessions as $group) {
                            $totalItems += count($group['items']);
                        }
                    } else {
                        foreach($archives as $group) {
                            $totalItems += count($group['items']);
                        }
                    }
                @endphp
                {{ $totalItems }} Data Ditemukan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                @if(request('type') == 'surat')
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Nama Siswa</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Jenis Surat</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Tujuan / Alasan Panggilan</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Tanggal Dibuat</th>
                            <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" x-data="{ activeGroups: { @foreach(array_keys($letters) as $key) '{{ $key }}': '{{ $key }}' === '{{ $currKey }}', @endforeach } }">
                        @forelse($letters as $groupKey => $group)
                            <!-- Group Header Row -->
                            <tr class="bg-slate-100/40 hover:bg-slate-100/60 transition-colors cursor-pointer select-none" @click="activeGroups['{{ $groupKey }}'] = !activeGroups['{{ $groupKey }}']">
                                <td colspan="5" class="px-8 py-3.5 border-y border-slate-200/60">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg :class="activeGroups['{{ $groupKey }}'] ? 'rotate-90' : ''" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <span class="font-bold text-slate-700 text-xs tracking-wide">{{ $group['label'] }}</span>
                                        </div>
                                        <span class="text-[9px] bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-bold">
                                            {{ count($group['items']) }} Arsip
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Group Items -->
                            @foreach($group['items'] as $letter)
                                <tr x-show="activeGroups['{{ $groupKey }}']" class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center font-semibold border border-amber-100 transition-transform group-hover:scale-110 shadow-sm">
                                                {{ substr($letter->student->name ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $letter->student->name ?? 'Tanpa Nama' }}</div>
                                                <div class="text-[9px] font-bold text-slate-400 font-medium">Kelas {{ $letter->student->class ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        @if(($letter->type ?? 'panggilan') == 'skorsing')
                                            <span class="bg-rose-50 border border-rose-100 text-rose-600 text-[9px] font-semibold px-2.5 py-1 rounded-lg font-medium">
                                                Surat Skorsing
                                            </span>
                                        @elseif(($letter->type ?? 'panggilan') == 'sp1')
                                            <span class="bg-amber-50 border border-amber-100 text-amber-600 text-[9px] font-semibold px-2.5 py-1 rounded-lg font-medium">
                                                Surat SP1
                                            </span>
                                        @elseif(($letter->type ?? 'panggilan') == 'sp2')
                                            <span class="bg-orange-50 border border-orange-100 text-orange-600 text-[9px] font-semibold px-2.5 py-1 rounded-lg font-medium">
                                                Surat SP2
                                            </span>
                                        @else
                                            <span class="bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-semibold px-2.5 py-1 rounded-lg font-medium">
                                                Surat Panggilan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-700 leading-snug max-w-xs">{{ $letter->content_json['reason'] ?? '-' }}</div>
                                        <div class="text-[9px] text-slate-400 mt-1 font-bold font-medium">
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
                                        <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Unduh PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-12 h-12 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-semibold  text-sm">Arsip Surat Kosong</p>
                                            <p class="text-xs font-bold text-slate-300 mt-1 font-medium">Belum ada surat terbit yang dibuat</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @elseif(request('type') == 'konseling')
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Siswa</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Topik & Kategori</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Ringkasan Sesi</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Tanggal Selesai</th>
                            <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" x-data="{ activeGroups: { @foreach(array_keys($sessions) as $key) '{{ $key }}': '{{ $key }}' === '{{ $currKey }}', @endforeach } }">
                        @forelse($sessions as $groupKey => $group)
                            <!-- Group Header Row -->
                            <tr class="bg-slate-100/40 hover:bg-slate-100/60 transition-colors cursor-pointer select-none" @click="activeGroups['{{ $groupKey }}'] = !activeGroups['{{ $groupKey }}']">
                                <td colspan="5" class="px-8 py-3.5 border-y border-slate-200/60">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg :class="activeGroups['{{ $groupKey }}'] ? 'rotate-90' : ''" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <span class="font-bold text-slate-700 text-xs tracking-wide">{{ $group['label'] }}</span>
                                        </div>
                                        <span class="text-[9px] bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-bold">
                                            {{ count($group['items']) }} Arsip
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Group Items -->
                            @foreach($group['items'] as $session)
                                <tr x-show="activeGroups['{{ $groupKey }}']" class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-semibold border border-primary/20 transition-transform group-hover:scale-110 shadow-sm">
                                                {{ substr($session->student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $session->student->name }}</div>
                                                <div class="text-[9px] font-bold text-slate-400 font-medium">Kelas {{ $session->student->class }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-700 leading-snug max-w-xs">
                                            {{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-[9px] font-semibold text-primary font-medium bg-primary/10 px-2.5 py-0.5 rounded-md">
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
                                        <a href="{{ route('gurubk.counseling.show', $session->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                            Detail Sesi
                                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-12 h-12 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-semibold  text-sm">Arsip Kosong</p>
                                            <p class="text-xs font-bold text-slate-300 mt-1 font-medium">Belum ada sesi bimbingan yang diselesaikan</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @else
                    <thead>
                        <tr class="bg-slate-50/30">
                            <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Siswa / Pelapor</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Kategori & Topik Masalah</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Status Akhir</th>
                            <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Waktu Selesai</th>
                            <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" x-data="{ activeGroups: { @foreach(array_keys($archives) as $key) '{{ $key }}': '{{ $key }}' === '{{ $currKey }}', @endforeach } }">
                        @forelse($archives as $groupKey => $group)
                            <!-- Group Header Row -->
                            <tr class="bg-slate-100/40 hover:bg-slate-100/60 transition-colors cursor-pointer select-none" @click="activeGroups['{{ $groupKey }}'] = !activeGroups['{{ $groupKey }}']">
                                <td colspan="5" class="px-8 py-3.5 border-y border-slate-200/60">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg :class="activeGroups['{{ $groupKey }}'] ? 'rotate-90' : ''" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <span class="font-bold text-slate-700 text-xs tracking-wide">{{ $group['label'] }}</span>
                                        </div>
                                        <span class="text-[9px] bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-bold">
                                            {{ count($group['items']) }} Arsip
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Group Items -->
                            @foreach($group['items'] as $archive)
                                @php
                                    $isSession = $archive instanceof \App\Models\CounselingSession;
                                    $displayName = $isSession 
                                        ? ($archive->student->name ?? '-') 
                                        : ($archive->student->name ?? ($archive->report && $archive->report->reporter ? ($archive->report->reporter->username ?? $archive->report->reporter->name) : '-'));
                                @endphp
                                <tr x-show="activeGroups['{{ $groupKey }}']" class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-semibold border border-primary/20 transition-transform group-hover:scale-110 shadow-sm">
                                                {{ substr($displayName, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $displayName }}</div>
                                                <div class="flex items-center gap-1.5">
                                                    @php
                                                        $accountStatus = 'Siswa Binaan';
                                                        if (!$isSession) {
                                                            $subjectUser = null;
                                                            if ($archive->student && $archive->student->user) {
                                                                $subjectUser = $archive->student->user;
                                                            } elseif ($archive->report && $archive->report->reporter) {
                                                                $subjectUser = $archive->report->reporter;
                                                            }

                                                            if ($archive->report && $archive->report->is_anonymous) {
                                                                $accountStatus = 'Anonim';
                                                            } elseif ($subjectUser) {
                                                                if ($subjectUser->is_guest) {
                                                                    $accountStatus = 'Akun Guest';
                                                                } else {
                                                                    $accountStatus = 'Akun Regis';
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="text-[9px] font-bold {{ $accountStatus === 'Akun Guest' ? 'text-amber-500' : ($accountStatus === 'Akun Regis' ? 'text-indigo-600' : 'text-slate-400') }} font-medium">{{ $accountStatus }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-700 leading-snug max-w-xs">
                                            {{ $isSession ? ($archive->title ?? 'Sesi Bimbingan Tatap Muka') : ($archive->report->title ?? 'Sesi Bimbingan Mandiri') }}
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-[9px] font-semibold text-primary font-medium bg-primary/10 px-2.5 py-0.5 rounded-md">
                                                {{ $isSession ? 'Konseling' : ($archive->report && $archive->report->type === 'konsultasi' ? 'Konsultasi' : 'Pelaporan') }}
                                            </span>
                                            @if(!$isSession)
                                                <span class="text-[9px] font-semibold text-slate-400 font-medium bg-slate-100 px-2 py-0.5 rounded-md">
                                                    Tiket #{{ str_pad($archive->id, 5, '0', STR_PAD_LEFT) }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 bg-accent rounded-full"></div>
                                            <span class="font-semibold text-accent text-[10px] font-medium">Diselesaikan</span>
                                        </div>
                                        <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-tighter">Oleh: {{ $isSession ? ($archive->teacher_name ?? ($archive->teacher->user->name ?? 'Guru BK')) : ($archive->handler_name ?? ($archive->teacher->user->name ?? 'Guru BK')) }}</div>
                                    </td>
                                    <td class="px-6 py-6">
                                        @php
                                            $sortDate = $isSession ? ($archive->completed_at ?? $archive->counseling_date) : ($archive->completed_date ?? $archive->created_at);
                                            $startDate = $isSession ? $archive->counseling_date : ($archive->report ? $archive->report->created_at : null);
                                        @endphp
                                        <div class="font-bold text-slate-700 text-xs">{{ $sortDate->translatedFormat('d M Y') }}</div>
                                        <div class="text-[9px] text-slate-400 mt-1 font-bold">{{ $sortDate->translatedFormat('H:i') }} WITA</div>
                                        @if($startDate)
                                            <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-tighter">
                                                Masuk: {{ $startDate->translatedFormat('d M Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="{{ $isSession ? route('gurubk.counseling.show', $archive->id) : route('gurubk.archives.show', $archive->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                            Detail {{ $isSession ? 'Sesi' : 'Kasus' }}
                                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-12 h-12 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-semibold  text-sm">Arsip Kasung Kosong</p>
                                            <p class="text-xs font-bold text-slate-300 mt-1 font-medium">Belum ada kasus yang diselesaikan</p>
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
