@extends('layouts.app')
@section('title', 'Arsip Bimbingan')
@section('title_display', 'Arsip Bimbingan')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Tabs Navigation --}}
    <div class="flex items-center justify-center sm:justify-start">
        <div class="inline-flex p-1.5 bg-white border border-slate-100 rounded-3xl shadow-sm">
            <a href="{{ route('gurubk.archives.index') }}" 
                class="px-8 py-3 rounded-2xl text-sm font-bold transition-all {{ !request('type') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:text-slate-900' }}">
                Semua
            </a>
            <a href="{{ route('gurubk.archives.index', ['type' => 'konsultasi']) }}" 
                class="px-8 py-3 rounded-2xl text-sm font-bold transition-all {{ request('type') == 'konsultasi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:text-slate-900' }}">
                Konsultasi
            </a>
            <a href="{{ route('gurubk.archives.index', ['type' => 'pelaporan']) }}" 
                class="px-8 py-3 rounded-2xl text-sm font-bold transition-all {{ request('type') == 'pelaporan' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:text-slate-900' }}">
                Pelaporan
            </a>
            <a href="{{ route('gurubk.archives.index', ['type' => 'surat']) }}" 
                class="px-8 py-3 rounded-2xl text-sm font-bold transition-all {{ request('type') == 'surat' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:text-slate-900' }}">
                Surat
            </a>
        </div>
    </div>

    <div class="card-premium overflow-hidden border-none shadow-xl shadow-slate-200/50">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white">
            <div>
                <h3 class="font-black text-slate-800 text-xl tracking-tight">Database Arsip</h3>
                <p class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-widest">Kumpulan Kasus & Bimbingan Selesai</p>
            </div>
            <div class="bg-slate-50 text-slate-400 text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest border border-slate-100">
                {{ $archives->count() }} Data Ditemukan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/30">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Siswa / Pelapor</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Topik Masalah</th>
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
                                    <div class="w-11 h-11 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black border border-blue-100 transition-transform group-hover:scale-110 shadow-sm">
                                        {{ substr($archive->reporter_username ?? $archive->reporter_name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 leading-none mb-1.5">{{ $archive->reporter_username ?? $archive->reporter_name ?? '-' }}</div>
                                        <div class="flex items-center gap-1.5">
                                            @if($archive->is_anonymous)
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-400 text-[8px] font-black uppercase tracking-tighter rounded-md">Anonim</span>
                                            @endif
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Siswa SMPN 6</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="font-bold text-slate-700 leading-snug max-w-xs">{{ $archive->report_title }}</div>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded-md">Tiket #{{ str_pad($archive->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                                    <span class="font-black text-emerald-600 text-[10px] uppercase tracking-widest">Diselesaikan</span>
                                </div>
                                <div class="text-[9px] text-slate-400 mt-1 font-bold uppercase tracking-tighter">Oleh: {{ $archive->handler_name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="font-bold text-slate-700 text-xs">{{ $archive->created_at->format('d M, Y') }}</div>
                                <div class="text-[9px] text-slate-400 mt-1 font-bold">{{ $archive->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('gurubk.archives.show', $archive->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-blue-600 text-slate-400 hover:text-white font-bold px-4 py-2 rounded-xl border border-slate-200 hover:border-blue-600 transition-all shadow-sm text-xs group/btn">
                                    Detail
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
                                    <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-sm">Arsip Tidak Ditemukan</p>
                                    <p class="text-xs font-bold text-slate-300 mt-1 uppercase tracking-widest">Belum ada data untuk kategori ini</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
