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
        {{-- Consolidated Premium Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Student Overview --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-blue-500 rounded-lg p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-slate-500 mb-1">Total Siswa</div>
                        <div class="text-2xl font-bold text-slate-800">{{ $totalStudents }}</div>
                        <div class="text-xs text-slate-400 mt-1">Tersebar di {{ $classStats->count() }} Kelas</div>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Counseling Overview --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-purple-500 rounded-lg p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-slate-500 mb-1">Sesi Konseling</div>
                        <div class="text-2xl font-bold text-slate-800">{{ $totalSessions }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ $counseledStudentsCount }} Siswa Terbantu</div>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Active Cases Overview --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-amber-500 rounded-lg p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-slate-500 mb-1">Kasus Aktif</div>
                        <div class="text-2xl font-bold text-slate-800">{{ $pendingReports->count() + $myInProgressReports->count() }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ $pendingReports->count() }} Antrean | {{ $myInProgressReports->count() }} Proses</div>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Resolved Cases Overview --}}
            <div class="bg-white border border-slate-200 border-t-4 border-t-emerald-500 rounded-lg p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-slate-500 mb-1">Kasus Selesai</div>
                        <div class="text-2xl font-bold text-slate-800">{{ \App\Models\Report::where('status', 'resolved')->count() }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ $activeFollowUps }} Tindak Lanjut</div>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Reports --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-white">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-ping"></span>
                    Antrean Kasus Masuk
                </h3>
                <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded font-medium">Baru</span>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[400px] custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead class="text-sm font-semibold text-slate-600 bg-slate-50 sticky top-0 z-10 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3">Perihal / Topik</th>
                            <th class="px-6 py-3">Pelapor</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendingReports as $report)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $report->title }}</div>
                                    <div class="text-xs text-slate-400 mt-1">{{ $report->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-700">{{ $report->reporter->username ?? $report->reporter->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium px-2 py-1 rounded {{ $report->type === 'konsultasi' ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' }}">
                                        {{ ucfirst($report->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button 
                                        @click="showDetail = true; selectedReport = {
                                            id: {{ $report->id }},
                                            title: '{{ addslashes($report->title) }}',
                                            content: '{{ addslashes(str_replace(["\r", "\n"], ' ', $report->content)) }}',
                                            type: '{{ ucfirst($report->type) }}',
                                            reporter: '{{ $report->reporter->username ?? $report->reporter->name ?? '-' }}',
                                            is_anonymous: {{ $report->is_anonymous ? 'true' : 'false' }},
                                            created_at: '{{ $report->created_at->diffForHumans() }}'
                                        }"
                                        class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-medium px-4 py-1.5 rounded transition"
                                    >
                                        Detail Kasus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">Tidak ada antrean kasus saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- My Tasks --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-white">
                <h3 class="font-semibold text-slate-800">Kasus Yang Saya Tangani</h3>
                <span class="text-xs font-medium text-slate-500">{{ $myInProgressReports->count() }} Aktif</span>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[400px] custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead class="text-sm font-semibold text-slate-600 bg-slate-50 sticky top-0 z-10 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3">Perihal</th>
                            <th class="px-6 py-3">Pelapor</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($myInProgressReports as $report)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $report->title }}</td>
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $report->reporter->username ?? $report->reporter->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium px-2 py-1 rounded {{ $report->type === 'konsultasi' ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' }}">
                                        {{ ucfirst($report->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="flex items-center gap-1.5 text-blue-600 text-sm">
                                        <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                        Dalam Proses
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('gurubk.report.show', $report->id) }}" class="inline-block bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-medium px-4 py-1.5 rounded transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">Anda belum menangani kasus apa pun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div x-show="showDetail" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showDetail = false" class="bg-white rounded-lg shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="bg-primary px-8 py-6 text-white flex justify-between items-center">
                <h3 class="text-xl font-bold">Detail Kasus</h3>
                <button @click="showDetail = false" class="text-white/80 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-medium text-slate-400">Perihal</label>
                        <div class="text-lg font-bold text-slate-900" x-text="selectedReport.title"></div>
                    </div>
                    <div class="flex gap-8">
                        <div>
                            <label class="text-[10px] font-medium text-slate-400">Tipe</label>
                            <div class="mt-1">
                                <span class="text-[10px] font-semibold uppercase px-2 py-1 rounded-md bg-blue-50 text-blue-600" x-text="selectedReport.type"></span>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-medium text-slate-400">Pelapor</label>
                            <div class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                <span x-text="selectedReport.reporter"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-medium text-slate-400">Isi Laporan / Konsultasi</label>
                        <div class="mt-2 text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100" x-text="selectedReport.content"></div>
                    </div>
                </div>

                <form :action="'/gurubk/claim/' + selectedReport.id" method="POST" class="pt-6 border-t border-slate-100 space-y-6">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-sm font-bold text-slate-700 block">Tentukan Prioritas Kasus <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="priority" value="low" class="peer sr-only" required>
                                <div class="px-4 py-3 rounded-lg border-2 border-slate-100 text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition group-hover:bg-slate-50">
                                    <span class="block text-[10px] font-semibold text-slate-600 peer-checked:text-emerald-700 uppercase tracking-wider">Rendah</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="priority" value="medium" class="peer sr-only">
                                <div class="px-4 py-3 rounded-lg border-2 border-slate-100 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition group-hover:bg-slate-50">
                                    <span class="block text-[10px] font-semibold text-slate-600 peer-checked:text-amber-700 uppercase tracking-wider">Sedang</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="priority" value="high" class="peer sr-only">
                                <div class="px-4 py-3 rounded-lg border-2 border-slate-100 text-center peer-checked:border-rose-500 peer-checked:bg-rose-50 transition group-hover:bg-slate-50">
                                    <span class="block text-[10px] font-semibold text-slate-600 peer-checked:text-rose-700 uppercase tracking-wider">Tinggi</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    @if($myInProgressReports->count() >= 5)
                        <div class="p-4 bg-rose-50 border border-rose-100 rounded-lg text-rose-600 text-xs font-bold leading-relaxed text-center">
                            Batas maksimal penanganan kasus aktif adalah 5. Selesaikan kasus yang sedang Anda tangani saat ini sebelum mengambil kasus baru.
                        </div>
                    @else
                        <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-4 rounded-lg shadow-xl shadow-primary/20 transition active:scale-[0.98]">
                            Ambil & Tangani Kasus
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
