@extends('layouts.app')

@section('title', '403 — Akses Ditolak')
@section('title_display', 'Akses Ditolak')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center max-w-md mx-auto">
        <div class="w-24 h-24 bg-rose-100 text-rose-500 rounded-lg flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>
        </div>
        <h1 class="text-6xl font-semibold text-slate-900 mb-2">403</h1>
        <h2 class="text-xl font-bold text-slate-700 mb-4">Akses Ditolak</h2>
        <p class="text-slate-500 mb-8">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>
@endsection
