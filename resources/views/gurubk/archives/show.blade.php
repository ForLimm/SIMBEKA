@extends('layouts.app')
@section('title', 'Detail Arsip')
@section('title_display', 'Detail Arsip')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('gurubk.archives.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">ID Arsip:</span>
            <span class="text-xs font-black text-slate-900 tracking-tighter">#{{ str_pad($archive->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left: Content --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="card-premium p-8">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-2">Isi Catatan Bimbingan / Laporan</h4>
                <div class="bg-slate-50 rounded-[2rem] p-8 text-slate-700 leading-relaxed font-medium text-lg italic border border-slate-100 relative">
                    <svg class="w-12 h-12 text-slate-200 absolute -top-4 -left-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 14.899 16 16 16L19 16L19 13L16 13C13.239 13 11 15.239 11 18L11 21L14.017 21ZM5.017 21L5.017 18C5.017 16.899 5.899 16 7 16L10 16L10 13L7 13C4.239 13 2 15.239 2 18L2 21L5.017 21Z"></path></svg>
                    {{ $archive->guidance_notes }}
                </div>

                @if($archive->attachment_path)
                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Lampiran Dokumen</h4>
                        <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem]">
                            <div class="w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-600/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-black text-emerald-900 text-sm">Dokumen Surat Panggilan / Pendukung</p>
                                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mt-0.5">Format: PDF Document</p>
                            </div>
                            <a href="{{ asset('storage/' . $archive->attachment_path) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black px-6 py-3 rounded-xl transition-all shadow-lg shadow-emerald-600/20 active:scale-95 uppercase tracking-widest">
                                Buka File
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Original Report Meta --}}
            @if($archive->report)
                <div class="card-premium p-8">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Metadata Laporan Asli</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Judul Laporan</span>
                            <p class="font-bold text-slate-800 mt-1">{{ $archive->report->title }}</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Prioritas Awal</span>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $archive->report->priority === 'high' ? 'bg-rose-100 text-rose-600' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $archive->report->priority }}
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
            <div class="card-premium p-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Subjek</h4>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-xl font-black shadow-lg shadow-blue-600/20">
                        {{ substr($archive->reporter_username ?? $archive->reporter_name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-black text-slate-900 tracking-tight">{{ $archive->reporter_username ?? $archive->reporter_name ?? '-' }}</div>
                        @if($archive->is_anonymous)
                            <div class="text-[10px] bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded-md font-black w-fit uppercase tracking-tighter mt-0.5">Status Anonim</div>
                        @else
                            <div class="text-[10px] text-blue-600 font-black uppercase tracking-tighter">Siswa Terdaftar</div>
                        @endif
                    </div>
                </div>
                
                @if($archive->student)
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">NISN</span>
                        <p class="text-xs font-black text-slate-800 tracking-wider">{{ $archive->student->nisn }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kelas / Jurusan</span>
                        <p class="text-xs font-bold text-slate-800">{{ $archive->student->class }}</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Officer Info --}}
            <div class="card-premium p-6 bg-slate-900 text-white border-none">
                <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Ditangani Oleh</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-800 text-white rounded-xl flex items-center justify-center text-sm font-black border border-slate-700">
                        {{ substr($archive->handler_name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold tracking-tight text-white">{{ $archive->handler_name ?? 'Guru BK' }}</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Petugas Penanganan</div>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-800">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Selesai Pada</span>
                    <p class="text-xs font-bold text-slate-300 mt-1">{{ $archive->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
