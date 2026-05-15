@extends('layouts.app')
@section('title', 'Detail Kasus')
@section('title_display', 'Detail Kasus')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    {{-- Case Header --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('gurubk.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <div class="flex items-center gap-3">
            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $report->status === 'resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                {{ str_replace('-', ' ', $report->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left: Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="card-premium p-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">{{ $report->type }}</span>
                    <span class="text-[10px] font-black uppercase tracking-widest {{ $report->priority === 'high' ? 'text-rose-600 bg-rose-50' : 'text-slate-500 bg-slate-50' }} px-2 py-0.5 rounded-md">{{ $report->priority }} Priority</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-6">{{ $report->title }}</h1>
                
                <div class="bg-slate-50 rounded-[2rem] p-8 text-slate-700 leading-relaxed font-medium text-lg italic border border-slate-100 relative">
                    <svg class="w-12 h-12 text-slate-200 absolute -top-4 -left-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 14.899 16 16 16L19 16L19 13L16 13C13.239 13 11 15.239 11 18L11 21L14.017 21ZM5.017 21L5.017 18C5.017 16.899 5.899 16 7 16L10 16L10 13L7 13C4.239 13 2 15.239 2 18L2 21L5.017 21Z"></path></svg>
                    {{ $report->content }}
                </div>
            </div>

            {{-- Actions --}}
            @if($report->status !== 'resolved')
            <div class="card-premium p-8 border-rose-100 bg-rose-50/10">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Tindakan Penanganan</h3>
                <p class="text-slate-500 text-sm mb-6 font-medium">Selesaikan kasus ini jika penanganan telah selesai dilakukan.</p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($report->type === 'konsultasi' && $report->handled_by === auth()->id())
                        <a href="{{ route('chat.show', $report->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-600/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Lanjutkan Konseling (Chat)
                        </a>
                    @endif
                    <form action="{{ route('gurubk.report.resolve', $report->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-emerald-600/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Selesaikan Kasus & Arsipkan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Sidebar Info --}}
        <div class="space-y-6">
            <div class="card-premium p-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Pelapor</h4>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-xl font-black shadow-lg shadow-blue-600/20">
                        {{ substr($report->reporter->username ?? $report->reporter->name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-black text-slate-900 tracking-tight">{{ $report->reporter->username ?? $report->reporter->name ?? '-' }}</div>
                        @if($report->is_anonymous)
                            <div class="text-[10px] bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded-md font-black w-fit uppercase tracking-tighter mt-0.5">Anonim Terjaga</div>
                        @else
                            <div class="text-[10px] text-blue-600 font-black uppercase tracking-tighter">Siswa Terdaftar</div>
                        @endif
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Dikirim</span>
                        <span class="text-xs font-bold text-slate-700">{{ $report->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Waktu</span>
                        <span class="text-xs font-bold text-slate-700">{{ $report->created_at->format('H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6 bg-slate-900 text-white border-none">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Pendamping / Guru BK</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-800 text-white rounded-xl flex items-center justify-center text-sm font-black border border-slate-700">
                        {{ substr($report->handler->name ?? '-', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold tracking-tight">{{ $report->handler->name ?? 'Belum ada' }}</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Petugas Penanganan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
