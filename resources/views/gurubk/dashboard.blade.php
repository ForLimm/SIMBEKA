@extends('layouts.app')
@section('title', 'Dashboard Guru BK')
@section('title_display', 'Dashboard Guru BK')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ $pendingReports->count() }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Antrean Kasus</div>
            </div>
        </div>
        <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ $myInProgressReports->count() }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sedang Ditangani</div>
            </div>
        </div>
        <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ \App\Models\Report::where('status', 'resolved')->count() }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kasus Selesai</div>
            </div>
        </div>
    </div>

    {{-- Pending Reports --}}
    <div class="card-premium overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-ping"></span>
                Antrean Kasus Masuk
            </h3>
            <span class="bg-amber-100 text-amber-700 text-[10px] px-2 py-0.5 rounded-md font-black uppercase tracking-widest">Baru</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/30">
                    <tr>
                        <th class="px-8 py-4">Perihal / Topik</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Prioritas</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingReports as $report)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="font-bold text-slate-900">{{ $report->title }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $report->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-700">{{ $report->reporter->username ?? $report->reporter->name ?? '-' }}</span>
                                    @if($report->is_anonymous)
                                        <span class="text-[9px] bg-slate-100 text-slate-400 px-1 py-0.5 rounded font-black">ANONIM</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] font-black uppercase tracking-tighter {{ $report->type === 'konsultasi' ? 'text-blue-500' : 'text-rose-500' }}">
                                    {{ $report->type }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $report->priority === 'high' ? 'bg-rose-50 text-rose-600' : ($report->priority === 'medium' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600') }}">
                                    {{ $report->priority }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <form action="{{ route('gurubk.report.take', $report->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2 rounded-xl transition shadow-lg shadow-blue-600/20 active:scale-95">
                                        Ambil Kasus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic font-medium">Tidak ada antrean kasus saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- My Tasks --}}
    <div class="card-premium overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-900">Kasus Yang Saya Tangani</h3>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $myInProgressReports->count() }} Aktif</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50/30">
                    <tr>
                        <th class="px-8 py-4">Perihal</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($myInProgressReports as $report)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 font-bold text-slate-900">{{ $report->title }}</td>
                            <td class="px-6 py-5 font-bold text-slate-700">
                                {{ $report->reporter->username ?? $report->reporter->name ?? '-' }}
                                @if($report->is_anonymous)
                                    <span class="text-[9px] bg-slate-100 text-slate-400 px-1 py-0.5 rounded font-black ml-1">ANONIM</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-[10px] font-black uppercase {{ $report->type === 'konsultasi' ? 'text-blue-500' : 'text-rose-500' }}">
                                    {{ $report->type }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="flex items-center gap-1.5 text-blue-600 font-bold text-xs">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                                    Dalam Proses
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <a href="{{ route('gurubk.report.show', $report->id) }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2 rounded-xl transition shadow-lg shadow-slate-900/10 active:scale-95">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic font-medium">Anda belum menangani kasus apa pun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
