@extends('layouts.app')
@section('title', 'Dashboard Guru BK')
@section('title_display', 'Dashboard Guru BK')

@section('content')
<div x-data="{ 
    showDetail: false, 
    selectedReport: {
        id: null,
        title: '',
        content: '',
        type: '',
        reporter: '',
        is_anonymous: false,
        created_at: ''
    } 
}">
    <div class="max-w-6xl mx-auto space-y-8">
        {{-- Student Binaan Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $totalStudents }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Siswa Binaan</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $classStats->count() }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Total Kelas</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $counseledStudentsCount }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Pernah Konseling</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $violationCount }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Total Pelanggaran</div>
                </div>
            </div>
        </div>

        {{-- Dokumentasi Sesi Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $totalSessions }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Total Sesi Dokumentasi</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-amber-50 text-amber-700 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $activeFollowUps }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Tindak Lanjut Aktif</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-purple-50 text-purple-700 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <div>
                    <div class="text-xl font-black text-slate-900">{{ $topCategory->category ?? '-' }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Masalah Terbanyak</div>
                </div>
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $pendingReports->count() }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Antrean Kasus</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-text">{{ $myInProgressReports->count() }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Sedang Ditangani</div>
                </div>
            </div>
            <div class="card-premium p-6 flex items-center gap-4 transition-all hover:shadow-lg">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ \App\Models\Report::where('status', 'resolved')->count() }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Kasus Selesai</div>
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
                                <td class="px-8 py-5 text-center">
                                    <button 
                                        @click="showDetail = true; selectedReport = {
                                            id: {{ $report->id }},
                                            title: '{{ addslashes($report->title) }}',
                                            content: '{{ addslashes(str_replace(["\r", "\n"], ' ', $report->content)) }}',
                                            type: '{{ $report->type }}',
                                            reporter: '{{ $report->reporter->username ?? $report->reporter->name ?? '-' }}',
                                            is_anonymous: {{ $report->is_anonymous ? 'true' : 'false' }},
                                            created_at: '{{ $report->created_at->diffForHumans() }}'
                                        }"
                                        class="bg-primary hover:bg-secondary text-white text-xs font-bold px-5 py-2 rounded-xl transition shadow-lg shadow-primary/20 active:scale-95"
                                    >
                                        Detail Kasus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic font-medium">Tidak ada antrean kasus saat ini.</td>
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
                                    <span class="flex items-center gap-1.5 text-primary font-bold text-xs">
                                        <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
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

    {{-- Detail Modal --}}
    <div x-show="showDetail" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showDetail = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="bg-primary px-8 py-6 text-white flex justify-between items-center">
                <h3 class="text-xl font-bold">Detail Kasus</h3>
                <button @click="showDetail = false" class="text-white/80 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Perihal</label>
                        <div class="text-lg font-bold text-slate-900" x-text="selectedReport.title"></div>
                    </div>
                    <div class="flex gap-8">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Tipe</label>
                            <div class="mt-1">
                                <span class="text-[10px] font-black uppercase px-2 py-1 rounded-md bg-blue-50 text-blue-600" x-text="selectedReport.type"></span>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pelapor</label>
                            <div class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                <span x-text="selectedReport.reporter"></span>
                                <template x-if="selectedReport.is_anonymous">
                                    <span class="text-[9px] bg-slate-100 text-slate-400 px-1 py-0.5 rounded font-black">ANONIM</span>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Isi Laporan / Konsultasi</label>
                        <div class="mt-2 text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100" x-text="selectedReport.content"></div>
                    </div>
                </div>

                <form :action="'/gurubk/claim/' + selectedReport.id" method="POST" class="pt-6 border-t border-slate-100 space-y-6">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-sm font-bold text-slate-700 block">Tentukan Prioritas Kasus <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="priority" value="low" class="peer sr-only" required>
                                <div class="px-4 py-3 rounded-xl border-2 border-slate-100 text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition group-hover:bg-slate-50">
                                    <span class="block text-[10px] font-black text-slate-600 peer-checked:text-emerald-700 uppercase tracking-wider">Low</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="priority" value="medium" class="peer sr-only">
                                <div class="px-4 py-3 rounded-xl border-2 border-slate-100 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition group-hover:bg-slate-50">
                                    <span class="block text-[10px] font-black text-slate-600 peer-checked:text-amber-700 uppercase tracking-wider">Medium</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="priority" value="high" class="peer sr-only">
                                <div class="px-4 py-3 rounded-xl border-2 border-slate-100 text-center peer-checked:border-rose-500 peer-checked:bg-rose-50 transition group-hover:bg-slate-50">
                                    <span class="block text-[10px] font-black text-slate-600 peer-checked:text-rose-700 uppercase tracking-wider">High</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-black py-4 rounded-2xl shadow-xl shadow-primary/20 transition active:scale-[0.98]">
                        Ambil & Tangani Kasus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
