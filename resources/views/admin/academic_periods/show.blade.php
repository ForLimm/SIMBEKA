@extends('layouts.app')
@section('title', 'Detail Periode - SIMBEKA')
@section('title_display', 'Detail Periode')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-6 bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <a href="{{ route('admin.academic_periods.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <div class="h-8 w-px bg-slate-100"></div>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">{{ $academicPeriod->name }}</h2>
                @if($academicPeriod->is_active)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary rounded-full font-bold text-[10px] uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        Aktif
                    </span>
                @endif
            </div>
            <p class="text-slate-500 text-xs font-medium mt-2">
                {{ $academicPeriod->start_date->format('d M Y') }} — {{ $academicPeriod->end_date->format('d M Y') }}
            </p>
        </div>
    </div>

    {{-- Assignments by Teacher --}}
    @if($assignments->isNotEmpty())
        <div class="space-y-4">
            @foreach($assignments as $teacherName => $teacherAssignments)
                <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex items-center gap-4">
                        <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">{{ $teacherName }}</h3>
                            <p class="text-[10px] font-medium text-slate-400">{{ $teacherAssignments->count() }} kelas diampu</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-3">
                            @foreach($teacherAssignments as $assignment)
                                <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-50 text-slate-700 rounded-lg font-bold text-sm border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Kelas {{ $assignment->class }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-16 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Penugasan</h3>
            <p class="text-sm text-slate-500 font-medium">Belum ada Guru BK yang melakukan klaim kelas untuk periode ini.</p>
        </div>
    @endif
</div>
@endsection
