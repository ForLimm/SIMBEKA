@extends('layouts.app')

@section('title', '500 — Kesalahan Server')
@section('title_display', 'Kesalahan Server')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center max-w-md mx-auto">
        <div class="w-24 h-24 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h1 class="text-6xl font-black text-slate-900 mb-2">500</h1>
        <h2 class="text-xl font-bold text-slate-700 mb-4">Terjadi Kesalahan</h2>
        <p class="text-slate-500 mb-8">Maaf, terjadi kesalahan pada server kami. Tim teknis sudah diberitahu. Silakan coba lagi nanti.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-primary/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Muat Ulang
        </a>
    </div>
</div>
@endsection
