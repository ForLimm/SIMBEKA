@extends('layouts.app')
@section('title', 'Detail Siswa - ' . $student->name)
@section('title_display', 'Profil Siswa Binaan')

@section('content')
<div class="w-full space-y-8" x-data="{ showExport: false, showLetterModal: false }">
    {{-- Header & Quick Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">{{ $student->name }}</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Siswa Binaan: {{ $student->teacher?->user?->name ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button @click="showLetterModal = true" class="bg-primary hover:bg-secondary text-white font-bold px-6 py-3 rounded-lg transition shadow-sm flex items-center gap-2 text-sm group/letter">
                <svg class="w-4 h-4 text-white/90 group-hover/letter:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Buat Surat Panggilan
            </button>
            <button @click="showExport = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-lg transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Anekdot
            </button>
        </div>
    </div>

    {{-- Export Modal --}}
    <div x-show="showExport" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showExport = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="bg-indigo-600 p-8 text-white flex items-center justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="font-semibold italic font-medium text-sm">Cetak Laporan Anekdot</h3>
                    <p class="text-indigo-100 text-xs text-slate-500 font-medium mt-1 opacity-80">{{ $student->name }}</p>
                </div>
                <button @click="showExport = false" class="relative z-10 w-8 h-8 flex items-center justify-center bg-white/10 rounded-full text-white hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('gurubk.anecdotes.export') }}" method="GET" class="p-8 space-y-6">
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-[10px] font-semibold text-slate-400 font-medium block mb-4 ml-1">Periode Laporan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative">
                                <input type="radio" name="period" value="month" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Bulan Ini</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="period" value="semester" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Semester Ini</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="period" value="year" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Tahun Ini</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="period" value="all" checked class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Semua Data</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="format" value="pdf">

                <div class="pt-4">
                    <button type="submit" @click="setTimeout(() => showExport = false, 500)" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-[1.5rem] shadow-xl shadow-indigo-600/20 transition-all active:scale-[0.95] font-medium text-xs flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Unduh Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Letter Selection Modal --}}
    <div x-show="showLetterModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showLetterModal = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="bg-primary p-8 text-white flex items-center justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="font-semibold italic font-medium text-sm">Pilih Jenis Surat</h3>
                    <p class="text-white/80 text-xs text-slate-500 font-medium mt-1">{{ $student->name }}</p>
                </div>
                <button @click="showLetterModal = false" class="relative z-10 w-8 h-8 flex items-center justify-center bg-white/10 rounded-full text-white hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-8 space-y-4">
                <p class="text-slate-500 text-xs font-semibold mb-2">Pilih jenis surat yang ingin diterbitkan untuk siswa ini:</p>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('gurubk.letters.create', ['student_id' => $student->id]) }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-primary/5 border border-slate-200 hover:border-primary rounded-lg transition-all group/opt">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-slate-800">Surat Panggilan Orang Tua</span>
                            <span class="block text-[10px] text-slate-400 font-medium">Surat panggilan resmi untuk orang tua/wali murid</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover/opt:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('gurubk.letters.sp1.create', ['student_id' => $student->id]) }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-primary/5 border border-slate-200 hover:border-primary rounded-lg transition-all group/opt">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-slate-800">Surat Peringatan 1 (SP1)</span>
                            <span class="block text-[10px] text-slate-400 font-medium">Surat peringatan tingkat pertama atas pelanggaran siswa</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover/opt:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('gurubk.letters.sp2.create', ['student_id' => $student->id]) }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-primary/5 border border-slate-200 hover:border-primary rounded-lg transition-all group/opt">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-slate-800">Surat Peringatan 2 (SP2)</span>
                            <span class="block text-[10px] text-slate-400 font-medium">Surat peringatan tingkat kedua setelah SP1 diabaikan</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover/opt:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('gurubk.letters.skorsing.create', ['student_id' => $student->id]) }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-primary/5 border border-slate-200 hover:border-primary rounded-lg transition-all group/opt">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-slate-800">Surat Skorsing</span>
                            <span class="block text-[10px] text-slate-400 font-medium">Surat pernyataan tindakan skorsing sementara bagi siswa</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover/opt:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        {{-- Left: Biodata (4/12) --}}
        <div class="xl:col-span-4 space-y-6">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-32 bg-primary/5 -z-10"></div>
                <div class="w-24 h-24 bg-white rounded-lg overflow-hidden shadow-xl mx-auto flex items-center justify-center border-4 border-white shrink-0">
                    @if($student->photo && file_exists(public_path('storage/' . $student->photo)))
                        <img src="{{ asset('storage/' . $student->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-primary/10 text-primary flex items-center justify-center font-bold text-3xl">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <h3 class="mt-6 text-xl font-semibold text-slate-800">{{ $student->name }}</h3>
                <p class="text-xs font-semibold text-primary font-medium mt-1">NISN: {{ $student->nisn }}</p>
                <div class="mt-4 inline-block px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full font-semibold text-[10px] font-medium">
                    Kelas {{ $student->class }}
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 space-y-6">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 pb-4">Informasi Personal</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Jenis Kelamin</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $student->gender }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Tempat Lahir</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $student->birth_place ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Tanggal Lahir</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->translatedFormat('d M Y') : '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Agama</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $student->religion ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 space-y-6">
                <h4 class="text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 pb-4">Kontak Orang Tua</h4>
                <div class="space-y-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Ayah</span>
                        <p class="text-xs font-semibold text-slate-700 mb-3">{{ $student->father_name ?? '-' }}</p>
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Ibu</span>
                        <p class="text-xs font-semibold text-slate-700">{{ $student->mother_name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Telepon</span>
                        <p class="text-xs font-semibold text-slate-700">{{ $student->parents_phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: History (8/12) --}}
        <div class="xl:col-span-8 space-y-8">
            {{-- Tabs for Histories --}}
            <div x-data="{ tab: 'anecdotes' }">
                <div class="flex gap-4 mb-6">
                    <button @click="tab = 'anecdotes'" :class="tab === 'anecdotes' ? 'bg-primary text-white shadow-sm' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-lg font-semibold text-xs font-medium transition-all">
                        Riwayat Anekdot ({{ $student->counselingSessions->count() }})
                    </button>
                    <button @click="tab = 'letters'" :class="tab === 'letters' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-lg font-semibold text-xs font-medium transition-all">
                        Riwayat Surat ({{ $student->letters->count() }})
                    </button>
                </div>

                {{-- Riwayat Anekdot Tab Content --}}
                <div x-show="tab === 'anecdotes'" class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-300">
                    {{-- 1. Semester Berjalan (Current Semester) --}}
                    @php
                        $currAnecdotes = $anecdotesByPeriod[$currentPeriodKey] ?? null;
                    @endphp
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6 space-y-6">
                        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide">Semester Berjalan</h4>
                            <span class="text-[10px] bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-bold">
                                {{ $currAnecdotes ? count($currAnecdotes['items']) : 0 }} Anekdot
                            </span>
                        </div>
                        
                        @if($currAnecdotes && count($currAnecdotes['items']) > 0)
                            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-slate-100">
                                @foreach($currAnecdotes['items'] as $session)
                                    <div class="relative flex items-start group pl-10">
                                        {{-- Dot --}}
                                        <div class="absolute left-0 mt-1 flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 group-hover:bg-primary group-hover:text-white text-slate-400 shadow shrink-0 transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        {{-- Card --}}
                                        <div class="flex-1 bg-slate-50/50 border border-slate-200 rounded-lg p-5 hover:bg-white hover:shadow-md transition-all">
                                            <div class="flex items-center justify-between space-x-2 mb-2">
                                                <div class="font-bold text-slate-800 text-sm">{{ $session->counseling_date->translatedFormat('d M Y') }}</div>
                                                <span class="px-2.5 py-0.5 bg-slate-200/60 text-slate-600 text-[9px] font-bold uppercase rounded">{{ $session->category }}</span>
                                            </div>
                                            <div class="font-bold text-slate-800 text-sm mb-1 leading-snug">{{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}</div>
                                            <div class="text-xs text-slate-500 mb-4 italic">"{{ $session->summary }}"</div>
                                            @if($session->follow_up)
                                                <div class="p-3 bg-primary/5 rounded-lg text-xs text-slate-700 font-medium mb-4">
                                                    <span class="block text-[9px] font-semibold uppercase text-primary mb-1">Tindak Lanjut</span>
                                                    {{ $session->follow_up }}
                                                </div>
                                            @endif
                                            <div class="flex items-center justify-between pt-4 border-t border-slate-200/60">
                                                <span class="text-[9px] font-bold text-slate-400">Guru: {{ $session->teacher_name ?? ($session->teacher?->user?->name ?? 'Guru BK') }}</span>
                                                <div class="flex items-center gap-2">
                                                    @php
                                                        $statusClass = [
                                                            'selesai' => 'bg-emerald-50 text-emerald-600',
                                                            'monitoring' => 'bg-blue-50 text-blue-600',
                                                            'tindak_lanjut' => 'bg-amber-50 text-amber-600'
                                                        ][$session->status];
                                                    @endphp
                                                    <span class="px-2 py-0.5 {{ $statusClass }} text-[9px] font-bold uppercase rounded">{{ str_replace('_', ' ', $session->status) }}</span>
                                                    @if($session->status === 'selesai')
                                                        <a href="{{ route('gurubk.counseling.show', $session->id) }}" class="px-2.5 py-1 border border-slate-200 hover:border-primary hover:text-white hover:bg-primary text-[9px] font-bold uppercase rounded transition-all bg-white text-slate-500">
                                                            Detail
                                                        </a>
                                                    @else
                                                        <a href="{{ route('gurubk.counseling.edit', $session->id) }}" class="px-2.5 py-1 border border-slate-200 hover:border-primary hover:text-white hover:bg-primary text-[9px] font-bold uppercase rounded transition-all bg-white text-slate-500">
                                                            Edit
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-slate-400 text-xs italic py-6">Belum ada catatan anekdot di semester berjalan ini.</div>
                        @endif
                    </div>

                    {{-- 2. Semester Lampau (Collapsible Accordion) --}}
                    @php
                        $pastAnecdotes = collect($anecdotesByPeriod)->forget($currentPeriodKey);
                    @endphp
                    
                    @if($pastAnecdotes->count() > 0)
                        <div class="space-y-3">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Arsip Semester Lampau</div>
                            @foreach($pastAnecdotes as $groupKey => $group)
                                <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden" x-data="{ open: false }">
                                    <button @click="open = !open" class="w-full px-6 py-4 bg-slate-50 hover:bg-slate-100/70 transition flex items-center justify-between border-b border-transparent" :class="open ? 'border-slate-100' : ''">
                                        <div class="flex items-center gap-2.5">
                                            <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <span class="font-bold text-slate-700 text-xs tracking-wide">{{ $group['label'] }}</span>
                                        </div>
                                        <span class="text-[9px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded font-bold">
                                            {{ count($group['items']) }} Anekdot
                                        </span>
                                    </button>
                                    
                                    <div x-show="open" x-cloak class="p-6 space-y-6 bg-white animate-in fade-in duration-200">
                                        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-slate-100">
                                            @foreach($group['items'] as $session)
                                                <div class="relative flex items-start group pl-10">
                                                    {{-- Dot --}}
                                                    <div class="absolute left-0 mt-1 flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 group-hover:bg-primary group-hover:text-white text-slate-400 shadow shrink-0 transition-all duration-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    </div>
                                                    {{-- Card --}}
                                                    <div class="flex-1 bg-slate-50/50 border border-slate-200 rounded-lg p-5 hover:bg-white hover:shadow-md transition-all">
                                                        <div class="flex items-center justify-between space-x-2 mb-2">
                                                            <div class="font-bold text-slate-800 text-sm">{{ $session->counseling_date->translatedFormat('d M Y') }}</div>
                                                            <span class="px-2.5 py-0.5 bg-slate-200/60 text-slate-600 text-[9px] font-bold uppercase rounded">{{ $session->category }}</span>
                                                        </div>
                                                        <div class="font-bold text-slate-800 text-sm mb-1 leading-snug">{{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}</div>
                                                        <div class="text-xs text-slate-500 mb-4 italic">"{{ $session->summary }}"</div>
                                                        @if($session->follow_up)
                                                            <div class="p-3 bg-primary/5 rounded-lg text-xs text-slate-700 font-medium mb-4">
                                                                <span class="block text-[9px] font-semibold uppercase text-primary mb-1">Tindak Lanjut</span>
                                                                {{ $session->follow_up }}
                                                            </div>
                                                        @endif
                                                        <div class="flex items-center justify-between pt-4 border-t border-slate-200/60">
                                                            <span class="text-[9px] font-bold text-slate-400">Guru: {{ $session->teacher_name ?? ($session->teacher?->user?->name ?? 'Guru BK') }}</span>
                                                            <div class="flex items-center gap-2">
                                                                @php
                                                                    $statusClass = [
                                                                        'selesai' => 'bg-emerald-50 text-emerald-600',
                                                                        'monitoring' => 'bg-blue-50 text-blue-600',
                                                                        'tindak_lanjut' => 'bg-amber-50 text-amber-600'
                                                                    ][$session->status];
                                                                @endphp
                                                                <span class="px-2 py-0.5 {{ $statusClass }} text-[9px] font-bold uppercase rounded">{{ str_replace('_', ' ', $session->status) }}</span>
                                                                @if($session->status === 'selesai')
                                                                    <a href="{{ route('gurubk.counseling.show', $session->id) }}" class="px-2.5 py-1 border border-slate-200 hover:border-primary hover:text-white hover:bg-primary text-[9px] font-bold uppercase rounded transition-all bg-white text-slate-500">
                                                                        Detail
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('gurubk.counseling.edit', $session->id) }}" class="px-2.5 py-1 border border-slate-200 hover:border-primary hover:text-white hover:bg-primary text-[9px] font-bold uppercase rounded transition-all bg-white text-slate-500">
                                                                        Edit
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Riwayat Surat Tab Content --}}
                <div x-show="tab === 'letters'" class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-300" x-cloak>
                    {{-- 1. Semester Berjalan (Current Semester) --}}
                    @php
                        $currLetters = $lettersByPeriod[$currentPeriodKey] ?? null;
                    @endphp
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6 space-y-6">
                        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide">Semester Berjalan</h4>
                            <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2.5 py-0.5 rounded-full font-bold">
                                {{ $currLetters ? count($currLetters['items']) : 0 }} Surat
                            </span>
                        </div>
                        
                        @if($currLetters && count($currLetters['items']) > 0)
                            <div class="space-y-4">
                                @foreach($currLetters['items'] as $letter)
                                    <div class="bg-slate-50/50 border border-slate-200 rounded-lg p-5 hover:bg-white hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="space-y-1.5 flex-1">
                                            <div class="flex items-center gap-2">
                                                @if(($letter->type ?? 'panggilan') == 'skorsing')
                                                    <span class="bg-rose-50 border border-rose-100 text-rose-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                        Surat Skorsing
                                                    </span>
                                                @elseif(($letter->type ?? 'panggilan') == 'sp1')
                                                    <span class="bg-amber-50 border border-amber-100 text-amber-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                        Surat SP1
                                                    </span>
                                                @elseif(($letter->type ?? 'panggilan') == 'sp2')
                                                    <span class="bg-orange-50 border border-orange-100 text-orange-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                        Surat SP2
                                                    </span>
                                                @else
                                                    <span class="bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                        Surat Panggilan
                                                    </span>
                                                @endif
                                                <span class="text-[10px] font-semibold text-slate-400">#{{ $letter->content_json['letter_number'] ?? 'No. Surat' }}</span>
                                            </div>
                                            
                                            <div class="font-bold text-slate-800 text-sm leading-snug">
                                                @if(($letter->type ?? 'panggilan') == 'skorsing')
                                                    Alasan: {{ $letter->content_json['reason'] ?? '-' }}
                                                @elseif(($letter->type ?? 'panggilan') == 'sp1' || ($letter->type ?? 'panggilan') == 'sp2')
                                                    Surat peringatan resmi diterbitkan.
                                                @else
                                                    Pertemuan Wali Kelas pada {{ isset($letter->content_json['date']) ? date('d M Y', strtotime($letter->content_json['date'])) : '-' }} Pukul {{ $letter->content_json['time'] ?? '09:00' }} WITA di {{ $letter->content_json['room'] ?? 'Ruang BK' }}
                                                @endif
                                            </div>
                                            
                                            <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wide">
                                                Dibuat pada: {{ $letter->created_at->translatedFormat('d M Y H:i') }} WITA
                                            </div>
                                        </div>
                                        
                                        <div class="shrink-0 flex items-center w-full sm:w-auto">
                                            <a href="{{ route('gurubk.letters.download', $letter->id) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Unduh PDF
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-slate-400 text-xs italic py-6">Belum ada surat panggilan di semester berjalan ini.</div>
                        @endif
                    </div>

                    {{-- 2. Semester Lampau (Collapsible Accordion) --}}
                    @php
                        $pastLetters = collect($lettersByPeriod)->forget($currentPeriodKey);
                    @endphp
                    
                    @if($pastLetters->count() > 0)
                        <div class="space-y-3">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Arsip Semester Lampau</div>
                            @foreach($pastLetters as $groupKey => $group)
                                <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden" x-data="{ open: false }">
                                    <button @click="open = !open" class="w-full px-6 py-4 bg-slate-50 hover:bg-slate-100/70 transition flex items-center justify-between border-b border-transparent" :class="open ? 'border-slate-100' : ''">
                                        <div class="flex items-center gap-2.5">
                                            <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <span class="font-bold text-slate-700 text-xs tracking-wide">{{ $group['label'] }}</span>
                                        </div>
                                        <span class="text-[9px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded font-bold">
                                            {{ count($group['items']) }} Surat
                                        </span>
                                    </button>
                                    
                                    <div x-show="open" x-cloak class="p-6 space-y-4 bg-white animate-in fade-in duration-200">
                                        @foreach($group['items'] as $letter)
                                            <div class="bg-slate-50/50 border border-slate-200 rounded-lg p-5 hover:bg-white hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                                <div class="space-y-1.5 flex-1">
                                                    <div class="flex items-center gap-2">
                                                        @if(($letter->type ?? 'panggilan') == 'skorsing')
                                                            <span class="bg-rose-50 border border-rose-100 text-rose-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                                Surat Skorsing
                                                            </span>
                                                        @elseif(($letter->type ?? 'panggilan') == 'sp1')
                                                            <span class="bg-amber-50 border border-amber-100 text-amber-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                                Surat SP1
                                                            </span>
                                                        @elseif(($letter->type ?? 'panggilan') == 'sp2')
                                                            <span class="bg-orange-50 border border-orange-100 text-orange-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                                Surat SP2
                                                            </span>
                                                        @else
                                                            <span class="bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                                                Surat Panggilan
                                                            </span>
                                                        @endif
                                                        <span class="text-[10px] font-semibold text-slate-400">#{{ $letter->content_json['letter_number'] ?? 'No. Surat' }}</span>
                                                    </div>
                                                    
                                                    <div class="font-bold text-slate-800 text-sm leading-snug">
                                                        @if(($letter->type ?? 'panggilan') == 'skorsing')
                                                            Alasan: {{ $letter->content_json['reason'] ?? '-' }}
                                                        @elseif(($letter->type ?? 'panggilan') == 'sp1' || ($letter->type ?? 'panggilan') == 'sp2')
                                                            Surat peringatan resmi diterbitkan.
                                                        @else
                                                            Pertemuan Wali Kelas pada {{ isset($letter->content_json['date']) ? date('d M Y', strtotime($letter->content_json['date'])) : '-' }} Pukul {{ $letter->content_json['time'] ?? '09:00' }} WITA di {{ $letter->content_json['room'] ?? 'Ruang BK' }}
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wide">
                                                        Dibuat pada: {{ $letter->created_at->translatedFormat('d M Y H:i') }} WITA
                                                    </div>
                                                </div>
                                                
                                                <div class="shrink-0 flex items-center w-full sm:w-auto">
                                                    <a href="{{ route('gurubk.letters.download', $letter->id) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        Unduh PDF
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
