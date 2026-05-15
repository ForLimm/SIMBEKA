@extends('layouts.app')
@section('title', 'Detail Kasus - SIMBEKA')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('gurubk.dashboard') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
            <h2 class="text-xl font-bold text-gray-800 mt-1">Detail Kasus</h2>
        </div>
        <div class="flex gap-2">
            @if($report->status === 'in-progress')
                <form action="{{ route('gurubk.report.resolve', $report->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded transition" onclick="return confirm('Tandai kasus ini sebagai selesai?')">
                        ✓ Selesaikan Kasus
                    </button>
                </form>
            @endif
            @if($report->type === 'konsultasi')
                <a href="{{ route('chat.show', $report->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Chat Siswa
                </a>
            @endif
        </div>
    </div>

    {{-- Report Card --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        {{-- Status Bar --}}
        <div class="px-6 py-3 border-b {{ $report->status === 'resolved' ? 'bg-green-50' : 'bg-blue-50' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $report->type === 'konsultasi' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                        {{ $report->type === 'konsultasi' ? 'Konsultasi' : 'Pelaporan' }}
                    </span>
                    <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $report->priority === 'high' ? 'bg-red-100 text-red-700' : ($report->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                        {{ ucfirst($report->priority) }}
                    </span>
                    <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $report->status === 'resolved' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $report->status === 'resolved' ? 'Selesai' : 'Dalam Proses' }}
                    </span>
                </div>
                <span class="text-xs text-gray-500">ID: #{{ $report->id }}</span>
            </div>
        </div>

        {{-- Report Details --}}
        <div class="p-6 space-y-5">
            {{-- Title --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Perihal</label>
                <p class="text-lg font-bold text-gray-800">{{ $report->title }}</p>
            </div>

            {{-- Reporter --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pelapor</label>
                    <p class="text-sm text-gray-800 font-medium">
                        {{ $report->reporter->username ?? $report->reporter->name ?? 'Tidak diketahui' }}
                        @if($report->reporter)
                            <span class="text-xs text-gray-400">({{ $report->reporter->username }})</span>
                        @endif
                        @if($report->is_anonymous)
                            <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded ml-2 font-bold">ANONIM</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Ditangani Oleh</label>
                    <p class="text-sm text-gray-800 font-medium">{{ $report->handler ? $report->handler->name : '-' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Laporan</label>
                    <p class="text-sm text-gray-600">{{ $report->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            {{-- Content --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Isi Laporan Lengkap</label>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $report->content }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
