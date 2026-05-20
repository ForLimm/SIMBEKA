@extends('layouts.app')

@section('title', '429 — Terlalu Banyak Permintaan')
@section('title_display', 'Terlalu Banyak Permintaan')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center max-w-md mx-auto">
        <div class="w-24 h-24 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-6xl font-semibold text-slate-900 mb-2">429</h1>
        <h2 class="text-xl font-bold text-slate-700 mb-4">Terlalu Banyak Percobaan</h2>
        <p class="text-slate-500 mb-8">Anda telah melakukan terlalu banyak percobaan. Silakan tunggu beberapa saat sebelum mencoba lagi.</p>
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>
@endsection
