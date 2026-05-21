@extends('layouts.app')
@section('title', 'Detail Siswa - ' . $student->name)
@section('title_display', 'Profil Siswa Binaan')

@section('content')
<div class="w-full space-y-8" x-data="{ showExport: false }">
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
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Siswa Binaan: {{ $student->teacher->user->name ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('gurubk.letters.create', ['student_id' => $student->id]) }}" class="bg-primary hover:bg-secondary text-white font-bold px-6 py-3 rounded-lg transition shadow-sm flex items-center gap-2 text-sm group/letter">
                <svg class="w-4 h-4 text-white/90 group-hover/letter:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Buat Surat Panggilan
            </a>
            <button @click="showExport = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-lg transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Anekdot
            </button>
            <a href="{{ route('gurubk.students.edit', $student->id) }}" class="bg-white border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-lg hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Profil
            </a>
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

                <div class="grid grid-cols-3 gap-3">
                    <label class="relative col-span-3">
                        <span class="text-[10px] font-semibold text-slate-400 font-medium block mb-4 ml-1">Format Dokumen</span>
                    </label>
                    <label class="relative">
                        <input type="radio" name="format" value="word" checked class="peer sr-only">
                        <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                            <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Word</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="format" value="pdf" class="peer sr-only">
                        <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                            <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">PDF</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="format" value="excel" class="peer sr-only">
                        <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                            <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Excel</span>
                        </div>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" @click="setTimeout(() => showExport = false, 500)" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-[1.5rem] shadow-xl shadow-indigo-600/20 transition-all active:scale-[0.95] font-medium text-xs flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Unduh Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        {{-- Left: Biodata (4/12) --}}
        <div class="xl:col-span-4 space-y-6">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-32 bg-primary/5 -z-10"></div>
                <div class="w-24 h-24 bg-white rounded-[2rem] shadow-xl mx-auto flex items-center justify-center text-primary font-semibold text-4xl border-4 border-white">
                    {{ substr($student->name, 0, 1) }}
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
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Ayah / Ibu</span>
                        <p class="text-xs font-semibold text-slate-700">{{ $student->father_name ?? '-' }} / {{ $student->mother_name ?? '-' }}</p>
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
            <div x-data="{ tab: 'counseling' }">
                <div class="flex gap-4 mb-6">
                    <button @click="tab = 'counseling'" :class="tab === 'counseling' ? 'bg-primary text-white shadow-sm' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-lg font-semibold text-xs font-medium transition-all">
                        Riwayat Konsultasi ({{ $student->archives->where('report.type', 'konsultasi')->count() }})
                    </button>
                    <button @click="tab = 'violations'" :class="tab === 'violations' ? 'bg-rose-500 text-white shadow-sm' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-lg font-semibold text-xs font-medium transition-all">
                        Riwayat Pelanggaran ({{ $student->reports->where('type', 'pelaporan')->count() }})
                    </button>
                    <button @click="tab = 'sessions'" :class="tab === 'sessions' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-lg font-semibold text-xs font-medium transition-all">
                        Dokumentasi Sesi ({{ $student->counselingSessions->count() }})
                    </button>
                </div>

                {{-- Counseling Documentation Timeline --}}
                <div x-show="tab === 'sessions'" class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-slate-100 animate-in fade-in slide-in-from-bottom-4 duration-300" x-cloak>
                    @forelse($student->counselingSessions as $session)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            {{-- Dot --}}
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 group-hover:bg-primary group-hover:text-white text-slate-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            {{-- Card --}}
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white border border-slate-200 rounded-lg shadow-sm p-6 hover:shadow-xl transition-all">
                                <div class="flex items-center justify-between space-x-2 mb-2">
                                    <div class="font-semibold text-slate-800">{{ $session->counseling_date->translatedFormat('d M Y') }}</div>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-semibold uppercase rounded">{{ $session->category }}</span>
                                </div>
                                <div class="font-bold text-slate-800 text-sm mb-1 leading-snug">{{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}</div>
                                <div class="text-xs text-slate-500 mb-4 italic">"{{ $session->summary }}"</div>
                                @if($session->follow_up)
                                    <div class="p-3 bg-primary/5 rounded-lg text-xs text-slate-700 font-medium mb-4">
                                        <span class="block text-[9px] font-semibold uppercase text-primary mb-1">Tindak Lanjut</span>
                                        {{ $session->follow_up }}
                                    </div>
                                @endif
                                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                    <span class="text-[9px] font-bold text-slate-400">Guru: {{ $session->teacher->user->name }}</span>
                                    <div class="flex items-center gap-2">
                                        @php
                                            $statusClass = [
                                                'selesai' => 'bg-emerald-50 text-emerald-600',
                                                'monitoring' => 'bg-blue-50 text-blue-600',
                                                'tindak_lanjut' => 'bg-amber-50 text-amber-600'
                                            ][$session->status];
                                        @endphp
                                        <span class="px-2 py-0.5 {{ $statusClass }} text-[9px] font-semibold uppercase rounded">{{ str_replace('_', ' ', $session->status) }}</span>
                                        @if($session->status === 'selesai')
                                            <a href="{{ route('gurubk.counseling.show', $session->id) }}" class="px-2 py-0.5 border border-slate-200 hover:border-primary hover:text-primary text-[9px] font-semibold uppercase rounded transition-all bg-white text-slate-500">
                                                Detail
                                            </a>
                                        @else
                                            <a href="{{ route('gurubk.counseling.edit', $session->id) }}" class="px-2 py-0.5 border border-slate-200 hover:border-primary hover:text-primary text-[9px] font-semibold uppercase rounded transition-all bg-white text-slate-500">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-12 text-center text-slate-400 italic">Belum ada dokumentasi sesi untuk siswa ini.</div>
                    @endforelse
                </div>

                {{-- Counseling List --}}
                <div x-show="tab === 'counseling'" class="space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-300">
                    @forelse($student->archives->where('report.type', 'konsultasi') as $archive)
                        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6 flex gap-6 hover:border-primary/30 transition-all">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center text-primary flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h5 class="font-semibold text-slate-800">{{ $archive->report->title }}</h5>
                                    <span class="text-[10px] font-bold text-slate-400">{{ $archive->completed_date->translatedFormat('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-slate-500 mt-2 line-clamp-2 italic">"{{ $archive->guidance_notes }}"</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="text-[9px] font-semibold text-emerald-500 font-medium bg-emerald-50 px-2 py-0.5 rounded">Kasus Selesai</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-12 text-center text-slate-400 italic">Belum ada riwayat konsultasi.</div>
                    @endforelse
                </div>

                {{-- Violation List --}}
                <div x-show="tab === 'violations'" class="space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-300" x-cloak>
                    @forelse($student->reports->where('type', 'pelaporan') as $report)
                        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6 flex gap-6 hover:border-rose-500/30 transition-all">
                            <div class="w-12 h-12 bg-rose-50 rounded-lg flex items-center justify-center text-rose-500 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h5 class="font-semibold text-slate-800">{{ $report->title }}</h5>
                                    <span class="text-[10px] font-bold text-slate-400">{{ $report->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-slate-500 mt-2">{{ $report->content }}</p>
                                <div class="mt-4 flex items-center gap-3">
                                    <span class="text-[9px] font-semibold text-rose-500 font-medium bg-rose-50 px-2 py-0.5 rounded">Terlapor oleh: {{ $report->reporter->name ?? 'Sistem' }}</span>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-semibold uppercase rounded">{{ $report->status }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-12 text-center text-slate-400 italic">Bersih dari riwayat pelanggaran.</div>
                    @endforelse
                </div>
            </div>

            {{-- Teacher Notes --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 bg-slate-50/50 border-dashed border-2 border-slate-200">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h4 class="text-[10px] font-semibold text-slate-400 font-medium">Catatan Tambahan Guru BK</h4>
                </div>
                <div class="text-sm text-slate-600 leading-relaxed italic">
                    {{ $student->notes ?? 'Belum ada catatan khusus untuk siswa ini.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
