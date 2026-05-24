@extends('layouts.app')
@section('title', 'Detail Kasus - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Detail Kasus')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Detail {{ $report->type === 'konsultasi' ? 'Konsultasi' : 'Pelaporan' }}</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">ID {{ $report->type === 'konsultasi' ? 'Konsultasi' : 'Pelaporan' }}: #{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-4 py-1.5 rounded-full text-[10px] font-medium {{ $report->status === 'resolved' ? 'bg-accent/10 text-accent' : 'bg-primary/10 text-primary' }}">
                {{ $report->status === 'resolved' ? 'Selesai' : ($report->status === 'in-progress' ? 'Dalam Proses' : 'Menunggu') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
        {{-- Left: Main Report Content (8/12 columns) --}}
        <div class="xl:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-10 relative overflow-hidden bg-white">
                <div class="absolute top-10 right-10 text-slate-50 opacity-50">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 14.899 16 16 16L19 16L19 13L16 13C13.239 13 11 15.239 11 18L11 21L14.017 21ZM5.017 21L5.017 18C5.017 16.899 5.899 16 7 16L10 16L10 13L7 13C4.239 13 2 15.239 2 18L2 21L5.017 21Z"></path></svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-[9px] font-semibold  text-primary bg-primary/10 px-2 py-0.5 rounded-md">{{ ucfirst($report->type) }}</span>
                        <span class="text-[9px] font-semibold  {{ $report->priority === 'high' ? 'text-rose-600 bg-rose-50' : 'text-slate-400 bg-slate-50' }} px-2 py-0.5 rounded-md">Prioritas {{ $report->priority === 'high' ? 'Tinggi' : ($report->priority === 'medium' ? 'Sedang' : 'Rendah') }}</span>
                    </div>
                    
                    <h1 class="text-3xl font-semibold text-slate-900 tracking-tight mb-8">{{ $report->title }}</h1>
                    
                    <div class="bg-slate-50/50 rounded-[2rem] p-8 text-slate-700 leading-relaxed font-medium text-lg italic border border-slate-100 shadow-inner">
                        {{ $report->content }}
                    </div>
                </div>
            </div>

            {{-- Action Buttons Card --}}
            @if($report->status !== 'resolved')
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 border-rose-100/50 bg-rose-50/5 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-1">Tindakan Penanganan</h3>
                    <p class="text-slate-500 text-xs font-medium">Selesaikan kasus jika pendampingan telah tuntas.</p>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto">
                    @if($report->type === 'konsultasi' && (int)$report->handled_by === (int)auth()->id())
                        <a href="{{ route('chat.show', $report->id) }}" class="flex-1 md:flex-none bg-primary hover:bg-secondary text-white font-semibold px-6 py-3.5 rounded-lg shadow-xl shadow-primary/20 transition-all flex items-center justify-center gap-2 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Lanjut Percakapan
                        </a>
                    @endif
                    <form action="{{ route('gurubk.report.resolve', $report->id) }}" method="POST" class="flex-1 md:flex-none">
                        @csrf
                        <button type="submit" class="w-full bg-accent hover:bg-emerald-700 text-white font-semibold px-6 py-3.5 rounded-lg shadow-xl shadow-accent/20 transition-all flex items-center justify-center gap-2 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Selesaikan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Info Sidebar (4/12 columns) --}}
        <div class="xl:col-span-4 space-y-6">
            {{-- Reporter Info --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-[10px] font-semibold text-slate-400 font-medium">Informasi {{ $report->type === 'konsultasi' ? 'Siswa' : 'Pelapor' }}</h4>
                </div>
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-primary text-white rounded-lg flex items-center justify-center text-3xl font-semibold shadow-sm">
                            {{ substr($report->reporter->username ?? $report->reporter->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900 tracking-tight text-xl leading-none mb-2">{{ $report->reporter->username ?? $report->reporter->name ?? '-' }}</div>
                            @php
                                $reporterUser = $report->reporter;
                                $accountStatus = 'Siswa Terdaftar';
                                if ($report->is_anonymous) {
                                    $accountStatus = 'Anonim';
                                } elseif ($reporterUser) {
                                    if ($reporterUser->is_guest) {
                                        $accountStatus = 'Akun Guest';
                                    } else {
                                        $accountStatus = 'Akun Regis';
                                    }
                                }
                            @endphp
                            <div class="text-[9px] {{ $accountStatus === 'Akun Guest' ? 'text-amber-500' : ($accountStatus === 'Akun Regis' ? 'text-indigo-600' : 'text-primary') }} font-medium">{{ $accountStatus }}</div>
                        </div>
                    </div>
                    
                    <div class="space-y-4 pt-6 border-t border-slate-50">
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-bold text-slate-400 font-medium">Dikirim Pada</span>
                            <span class="text-xs font-semibold text-slate-700">{{ $report->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                        </div>
                        @if($report->reporter && $report->reporter->student)
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-bold text-slate-400 font-medium">Kelas Siswa</span>
                            <span class="text-xs font-semibold text-slate-700">{{ $report->reporter->student->class }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Handler Card --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-[10px] font-semibold text-slate-400 font-medium">Petugas Penanganan</h4>
                </div>
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center text-3xl font-semibold border border-primary/20 mx-auto mb-4">
                        {{ substr($report->handler->name ?? '-', 0, 1) }}
                    </div>
                    <div class="font-bold text-slate-800 text-lg mb-1">{{ $report->handler->name ?? 'Belum ada' }}</div>
                    <div class="text-[10px] text-slate-400 font-bold font-medium">Guru BK Pendamping</div>
                    
                    @if($report->status === 'resolved')
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <div class="bg-accent/10 rounded-lg p-4 border border-accent/20">
                                <p class="text-[10px] text-accent font-bold mb-1 text-center">Status Akhir</p>
                                <p class="text-[11px] text-accent font-bold text-center">Selesai & Diarsipkan</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
