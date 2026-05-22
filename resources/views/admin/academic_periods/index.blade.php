@extends('layouts.app')
@section('title', 'Kelola Periode Akademik - SIMBEKA')
@section('title_display', 'Periode Akademik')

@section('content')
<div class="w-full space-y-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight leading-none">Periode Akademik</h2>
            <p class="text-slate-500 text-xs font-medium mt-2">Kelola tahun ajaran dan semester untuk rotasi penugasan Guru BK.</p>
        </div>
        <a href="{{ route('admin.academic_periods.create') }}" 
           class="inline-flex items-center gap-2 bg-slate-900 text-white font-semibold px-5 py-3 rounded-lg shadow-sm transition active:scale-[0.98] hover:bg-black text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Periode Baru
        </a>
    </div>

    {{-- Info Banner --}}
    <div class="p-6 bg-slate-950 text-white rounded-lg border border-slate-900 shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-lg font-semibold">Cara Kerja Periode Akademik</h4>
            </div>
            <p class="text-slate-400 text-sm leading-relaxed max-w-3xl">
                Saat Anda <strong class="text-white">mengaktifkan periode baru</strong>, semua penugasan Guru BK → Siswa akan di-reset. 
                Guru BK perlu melakukan <strong class="text-white">klaim kelas ulang</strong> untuk periode baru tersebut. 
                Arsip dan catatan dari periode sebelumnya tetap tersimpan dan bisa diakses oleh guru yang membuatnya.
            </p>
        </div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-primary/10 rounded-full blur-[100px]"></div>
    </div>

    {{-- Periods List --}}
    <div class="space-y-4">
        @forelse($periods as $period)
            <div class="bg-white border rounded-lg shadow-sm overflow-hidden transition-all hover:shadow-md
                {{ $period->is_active ? 'border-primary/30 ring-2 ring-primary/10' : 'border-slate-200' }}">
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    {{-- Left: Period Info --}}
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-lg flex items-center justify-center shrink-0 shadow-sm
                            {{ $period->is_active ? 'bg-primary text-white' : 'bg-slate-100 text-slate-400' }}">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-bold text-slate-900">{{ $period->name }}</h3>
                                @if($period->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary rounded-full font-bold text-[10px] uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-500 rounded-full font-bold text-[10px] uppercase tracking-wider">
                                        Nonaktif
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500 font-medium">
                                {{ $period->start_date->format('d M Y') }} — {{ $period->end_date->format('d M Y') }}
                            </p>
                            <div class="flex items-center gap-6 mt-3">
                                <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $period->assigned_teachers_count }} Guru BK
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $period->assigned_classes_count }} Kelas
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('admin.academic_periods.show', $period) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-50 text-slate-600 font-bold rounded-lg hover:bg-slate-100 transition text-xs border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Detail
                        </a>

                        @if(!$period->is_active)
                            <form action="{{ route('admin.academic_periods.activate', $period) }}" method="POST" 
                                  onsubmit="return confirm('⚠️ PERHATIAN: Mengaktifkan periode ini akan MENONAKTIFKAN periode lain dan ME-RESET semua penugasan Guru BK → Siswa. Guru BK harus klaim kelas ulang.\n\nLanjutkan?')">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition text-xs shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Aktifkan
                                </button>
                            </form>

                            <form action="{{ route('admin.academic_periods.destroy', $period) }}" method="POST"
                                  onsubmit="return confirm('Hapus periode ini? Data penugasan kelas di periode ini juga akan dihapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 text-rose-600 font-bold rounded-lg hover:bg-rose-100 transition text-xs border border-rose-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-50 text-emerald-600 font-bold rounded-lg text-xs border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Sedang Berjalan
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Periode Akademik</h3>
                <p class="text-sm text-slate-500 font-medium mb-6">Buat periode akademik pertama untuk mulai mengelola rotasi penugasan Guru BK.</p>
                <a href="{{ route('admin.academic_periods.create') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-semibold px-5 py-3 rounded-lg shadow-sm transition hover:bg-black text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Periode Pertama
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
