@extends('layouts.app')
@section('title', 'Riwayat Konsultasi - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Riwayat Konsultasi')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Riwayat Konsultasi</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Daftar Sesi Bimbingan yang Pernah Dilakukan</p>
            </div>
        </div>
        <div class="px-6 py-2 bg-blue-50 border border-blue-100 text-primary rounded-2xl flex items-center gap-2">
            <span class="text-xl font-black">{{ $konsultasi->count() }}</span>
            <span class="text-[9px] font-black uppercase tracking-widest opacity-60">Total Sesi</span>
        </div>
    </div>

    {{-- History Table Card --}}
    <div class="card-premium overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5">Perihal / Kasus</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5">Guru BK Penanggung Jawab</th>
                        <th class="px-6 py-5">Waktu Pengajuan</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($konsultasi as $report)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-black text-slate-800 text-base tracking-tight mb-1">{{ $report->title }}</div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] uppercase font-black px-2 py-0.5 rounded {{ $report->priority === 'high' ? 'bg-rose-50 text-rose-500' : ($report->priority === 'medium' ? 'bg-amber-50 text-amber-500' : 'bg-emerald-50 text-emerald-500') }}">
                                        {{ $report->priority }} Priority
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-xs font-black">
                                @if($report->status === 'pending')
                                    <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-widest text-[9px]">Menunggu</span>
                                @elseif($report->status === 'in-progress')
                                    <span class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center gap-2 w-fit uppercase tracking-widest text-[9px]">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                        Sedang Diproses
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest text-[9px]">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center text-xs font-black text-slate-400 group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all">
                                        {{ substr($report->handler->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-700 leading-none mb-1">{{ $report->handler->name ?? 'Belum Ditentukan' }}</span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Petugas BK</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-slate-500 font-medium">
                                <div class="font-bold text-slate-700">{{ $report->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">{{ $report->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    @if($report->status === 'in-progress' && $report->handled_by)
                                        <a href="{{ route('chat.show', $report->id) }}" class="bg-primary hover:bg-secondary text-white text-[10px] font-black px-6 py-2.5 rounded-xl transition shadow-lg shadow-primary/20 uppercase tracking-widest">
                                            Lanjut Chat
                                        </a>
                                    @endif
                                    @if($report->status === 'resolved')
                                        <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" onsubmit="return confirm('Sembunyikan riwayat ini dari tampilan?')">
                                            @csrf
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-10">
                                    <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <p class="text-xl font-black uppercase tracking-widest">Belum Ada Riwayat Konsultasi</p>
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
