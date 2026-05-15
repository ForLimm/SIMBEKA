@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('title_display', 'Dashboard Siswa')

@section('content')
<div x-data="{ tab: 'menu' }" class="max-w-6xl mx-auto">
    {{-- Tab Navigation --}}
    <div class="flex gap-2 mb-8 bg-white p-1.5 rounded-2xl border border-slate-200 w-fit shadow-sm">
        <button @click="tab = 'menu'" :class="tab === 'menu' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all">
            Menu Utama
        </button>
        <button @click="tab = 'konsultasi'" :class="tab === 'konsultasi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            Konsultasi
            @if(isset($konsultasi) && $konsultasi->count() > 0)
                <span class="bg-white/20 text-white text-[10px] px-1.5 py-0.5 rounded-md">{{ $konsultasi->count() }}</span>
            @endif
        </button>
        <button @click="tab = 'pelaporan'" :class="tab === 'pelaporan' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50'" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
            Pelaporan
            @if(isset($pelaporan) && $pelaporan->count() > 0)
                <span class="bg-white/20 text-white text-[10px] px-1.5 py-0.5 rounded-md">{{ $pelaporan->count() }}</span>
            @endif
        </button>
    </div>

    {{-- Tab: Menu Utama --}}
    <div x-show="tab === 'menu'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Konsultasi --}}
            <a href="{{ route('lapor.create', ['type' => 'konsultasi']) }}" class="card-premium p-8 group transition-all hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-32 h-32 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                </div>
                <div class="bg-blue-50 text-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Konsultasi BK</h3>
                <p class="text-slate-500 leading-relaxed max-w-sm">Curahkan segala permasalahan akademik, pribadi, atau karir Anda secara rahasia bersama Guru BK pilihan Anda.</p>
                <div class="mt-8 flex items-center gap-2 text-blue-600 font-bold text-sm">
                    Mulai Konsultasi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4 4H3"></path></svg>
                </div>
            </a>

            {{-- Pelaporan --}}
            <a href="{{ route('lapor.create', ['type' => 'pelaporan']) }}" class="card-premium p-8 group transition-all hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-32 h-32 text-rose-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div class="bg-rose-50 text-rose-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Pelaporan Kasus</h3>
                <p class="text-slate-500 leading-relaxed max-w-sm">Laporkan insiden, pelanggaran, atau perundungan yang terjadi di sekolah secara aman dan anonim jika diperlukan.</p>
                <div class="mt-8 flex items-center gap-2 text-rose-600 font-bold text-sm">
                    Laporkan Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4 4H3"></path></svg>
                </div>
            </a>
        </div>
    </div>

    {{-- Tab: Riwayat Konseling --}}
    <div x-show="tab === 'konsultasi'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="card-premium overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-900">Riwayat Konsultasi</h3>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $konsultasi->count() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/30">
                        <tr>
                            <th class="px-8 py-4">Perihal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Guru BK</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($konsultasi as $report)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-900">{{ $report->title }}</div>
                                    <div class="text-[10px] uppercase font-bold mt-1 {{ $report->priority === 'high' ? 'text-rose-500' : ($report->priority === 'medium' ? 'text-amber-500' : 'text-emerald-500') }}">
                                        {{ $report->priority }} Priority
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($report->status === 'pending')
                                        <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">Menunggu</span>
                                    @elseif($report->status === 'in-progress')
                                        <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                                            Proses
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center text-[10px] font-bold text-slate-500">
                                            {{ substr($report->handler->name ?? '-', 0, 1) }}
                                        </div>
                                        <span class="font-medium text-slate-700">{{ $report->handler->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-slate-500 font-medium">
                                    {{ $report->created_at->format('d M Y') }}
                                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $report->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-3">
                                        @if($report->status === 'in-progress' && $report->handled_by)
                                            <a href="{{ route('chat.show', $report->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-lg shadow-blue-600/20">
                                                Lanjut Chat
                                            </a>
                                        @endif
                                        @if($report->status === 'resolved')
                                            <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" onsubmit="return confirm('Sembunyikan riwayat ini?')">
                                                @csrf
                                                <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <p class="font-bold">Belum ada riwayat konsultasi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tab: Riwayat Pelaporan --}}
    <div x-show="tab === 'pelaporan'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="card-premium overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-900">Riwayat Pelaporan</h3>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $pelaporan->count() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/30">
                        <tr>
                            <th class="px-8 py-4">Kasus / Perihal</th>
                            <th class="px-6 py-4">Status Penanganan</th>
                            <th class="px-6 py-4">Tanggal Lapor</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pelaporan as $report)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-900">{{ $report->title }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] uppercase font-bold {{ $report->priority === 'high' ? 'text-rose-500' : ($report->priority === 'medium' ? 'text-amber-500' : 'text-emerald-500') }}">
                                            {{ $report->priority }} Priority
                                        </span>
                                        @if($report->is_anonymous)
                                            <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-bold uppercase">Anonim</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($report->status === 'pending')
                                        <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">Menunggu</span>
                                    @elseif($report->status === 'in-progress')
                                        <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold">Proses</span>
                                    @else
                                        <span class="px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-slate-500 font-medium">
                                    {{ $report->created_at->format('d M Y') }}
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center">
                                        <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" onsubmit="return confirm('Sembunyikan riwayat ini?')">
                                            @csrf
                                            <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <p class="font-bold">Belum ada riwayat pelaporan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
