@extends('layouts.app')
@section('title', 'Berhasil Terkirim - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Status Pengiriman')

@section('content')
<div class="max-w-xl mx-auto py-12">
    <div class="card-premium p-12 text-center bg-white relative overflow-hidden">
        {{-- Success Animation Placeholder Decor --}}
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-accent/10 rounded-full opacity-50"></div>
        <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-primary/10 rounded-full opacity-50"></div>

        <div class="relative">
            <div class="bg-accent/10 text-accent w-24 h-24 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-xl shadow-accent/10">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-4">Laporan Berhasil Terkirim!</h2>
            <p class="text-slate-500 font-medium leading-relaxed max-w-sm mx-auto mb-10">
                Terima kasih atas laporan Anda. Informasi Anda telah diterima dengan aman dan akan segera ditinjau oleh Guru BK sekolah.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ auth()->user()->role === 'siswa' ? route('siswa.dashboard') : route('gurubk.dashboard') }}" class="bg-primary hover:bg-secondary text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 text-sm">
                    Kembali ke Dashboard
                </a>
                
                @if(auth()->user()->is_guest)
                    <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-black px-10 py-4 rounded-2xl transition-all active:scale-95 text-sm border border-slate-200">
                            Keluar Sesi Tamu
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-12 flex items-center justify-center gap-4">
        <div class="w-8 h-1 bg-accent rounded-full"></div>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sistem Keamanan Terenkripsi</span>
        <div class="w-8 h-1 bg-primary rounded-full"></div>
    </div>
</div>
@endsection
