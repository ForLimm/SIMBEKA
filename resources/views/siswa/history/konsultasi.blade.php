@extends('layouts.app')
@section('title', 'Riwayat Konsultasi - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Riwayat Konsultasi')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Riwayat Konsultasi</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Daftar Sesi Bimbingan yang Pernah Dilakukan</p>
            </div>
        </div>
        <div class="px-6 py-2 bg-blue-50 border border-blue-100 text-primary rounded-lg flex items-center gap-2">
            <span class="text-xl font-semibold">{{ $konsultasi->count() }}</span>
            <span class="text-[9px] font-medium opacity-60">Total Sesi</span>
        </div>
    </div>

    {{-- History Table Card --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="hidden md:table-header-group text-xs font-bold text-slate-400 font-medium bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5">Perihal / Kasus</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5">Guru BK Penanggung Jawab</th>
                        <th class="px-6 py-5">Waktu Pengajuan</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="block md:table-row-group divide-y divide-slate-100">
                    @forelse($konsultasi as $report)
                        <tr class="block md:table-row hover:bg-slate-50/80 transition-colors group p-4 md:p-0 space-y-3 md:space-y-0">
                            <td class="block md:table-cell px-4 md:px-8 py-2 md:py-6">
                                <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Perihal / Kasus</span>
                                <div class="font-semibold text-slate-800 text-base tracking-tight mb-1">{{ $report->title }}</div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] uppercase font-semibold px-2 py-0.5 rounded {{ $report->priority === 'high' ? 'bg-rose-50 text-rose-500' : ($report->priority === 'medium' ? 'bg-amber-50 text-amber-500' : 'bg-emerald-50 text-emerald-500') }}">
                                        Prioritas {{ $report->priority === 'high' ? 'Tinggi' : ($report->priority === 'medium' ? 'Sedang' : 'Rendah') }}
                                    </span>
                                </div>
                            </td>
                            <td class="block md:table-cell px-4 md:px-6 py-2 md:py-6 text-xs font-semibold">
                                <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Status</span>
                                @if($report->status === 'pending')
                                    <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 font-medium text-[9px]">Menunggu</span>
                                @elseif($report->status === 'in-progress')
                                    <span class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center gap-2 w-fit font-medium text-[9px]">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                        Sedang Diproses
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 font-medium text-[9px]">Selesai</span>
                                @endif
                            </td>
                            <td class="block md:table-cell px-4 md:px-6 py-2 md:py-6">
                                <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Guru BK Penanggung Jawab</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center text-xs font-semibold text-slate-400 group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all">
                                        {{ substr($report->handler->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-700 leading-none mb-1">{{ $report->handler->name ?? 'Belum Ditentukan' }}</span>
                                        <span class="text-[9px] font-bold text-slate-400 font-medium">Petugas BK</span>
                                    </div>
                                </div>
                            </td>
                            <td class="block md:table-cell px-4 md:px-6 py-2 md:py-6 text-slate-500 font-medium">
                                <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Waktu Pengajuan</span>
                                <div class="font-bold text-slate-700">{{ $report->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">{{ $report->created_at->translatedFormat('H:i') }} WITA</div>
                            </td>
                            <td class="block md:table-cell px-4 md:px-8 py-3 md:py-6">
                                <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Aksi</span>
                                <div class="flex items-center gap-3">
                                    @if($report->status === 'in-progress' && $report->handled_by)
                                        <a href="{{ route('chat.show', $report->id) }}" class="bg-primary hover:bg-secondary text-white text-[10px] font-semibold px-6 py-2.5 rounded-lg transition shadow-sm font-medium w-full text-center md:w-auto">
                                            Lanjut Percakapan
                                        </a>
                                    @endif
                                    @if($report->status === 'resolved')
                                        <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" onsubmit="return confirm('Sembunyikan riwayat ini dari tampilan?')" class="w-full md:w-auto">
                                            @csrf
                                            <button type="submit" class="w-full md:w-10 h-10 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all border border-slate-200 md:border-none py-2 md:py-0 flex items-center justify-center gap-2">
                                                <span class="block md:hidden text-xs font-semibold">Sembunyikan Riwayat</span>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="block md:table-row">
                            <td colspan="5" class="block md:table-cell px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-10">
                                    <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <p class="text-xl font-medium">Belum Ada Riwayat Konsultasi</p>
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
