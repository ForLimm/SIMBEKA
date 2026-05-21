@extends('layouts.app')
@section('title', 'Riwayat Pelaporan - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Riwayat Pelaporan')

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
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Riwayat Pelaporan</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Daftar Laporan Kasus yang Pernah Anda Ajukan</p>
            </div>
        </div>
        <div class="px-6 py-2 bg-rose-50 border border-rose-100 text-rose-600 rounded-lg flex items-center gap-2">
            <span class="text-xl font-semibold">{{ $pelaporan->count() }}</span>
            <span class="text-[9px] font-medium opacity-60">Total Laporan</span>
        </div>
    </div>

    {{-- History Table Card --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-bold text-slate-400 font-medium bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5">Kasus / Perihal</th>
                        <th class="px-6 py-5">Status Penanganan</th>
                        <th class="px-6 py-5">Waktu Lapor</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pelaporan as $report)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-semibold text-slate-800 text-base tracking-tight mb-1">{{ $report->title }}</div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] uppercase font-semibold px-2 py-0.5 rounded {{ $report->priority === 'high' ? 'bg-rose-50 text-rose-500' : ($report->priority === 'medium' ? 'bg-amber-50 text-amber-500' : 'bg-emerald-50 text-emerald-500') }}">
                                        Prioritas {{ $report->priority === 'high' ? 'Tinggi' : ($report->priority === 'medium' ? 'Sedang' : 'Rendah') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-xs font-semibold">
                                @if($report->status === 'pending')
                                    <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 font-medium text-[9px]">Menunggu Antrean</span>
                                @elseif($report->status === 'in-progress')
                                    <span class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center gap-2 w-fit font-medium text-[9px]">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                        Sedang Ditangani
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 font-medium text-[9px]">Selesai Ditangani</span>
                                @endif
                            </td>
                            <td class="px-6 py-6 text-slate-500 font-medium">
                                <div class="font-bold text-slate-700">{{ $report->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">{{ $report->created_at->translatedFormat('H:i') }} WITA</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center">
                                    @if($report->status === 'resolved')
                                        <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" onsubmit="return confirm('Sembunyikan riwayat ini dari tampilan?')">
                                            @csrf
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[9px] font-bold text-slate-300 uppercase italic">Sedang Berjalan</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-10">
                                    <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <p class="text-xl font-medium">Belum Ada Riwayat Pelaporan</p>
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
