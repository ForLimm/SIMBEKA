@extends('layouts.app')
@section('title', 'Master Data Guru BK - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Master Data Guru BK')

@section('content')
<div class="w-full space-y-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight">Master Data Guru BK</h2>
            <p class="text-slate-500 font-medium">Kelola data guru bimbingan konseling dan kuota bimbingan siswa.</p>
        </div>
        <a href="{{ route('admin.teachers.create') }}" class="mt-4 md:mt-0 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Guru BK
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden border-none shadow-xl shadow-slate-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/30">
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Nama Guru</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">NIP / Identitas</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-center">Siswa Terdaftar</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-center">Sisa Kuota</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                             <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-semibold border border-primary/20">
                                        {{ substr($teacher->user->name, 0, 1) }}
                                    </div>
                                    <div class="font-bold text-slate-800">{{ $teacher->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-slate-500 font-medium">
                                {{ $teacher->nip ?? '-' }}
                                <div class="text-[9px] text-slate-400 font-semibold uppercase tracking-tighter mt-1">NIP Resmi</div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="font-semibold text-lg {{ $teacher->students_count >= $teacher->max_quota ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $teacher->students_count }}
                                </span>
                                <span class="text-slate-400 font-bold ml-1">/ {{ $teacher->max_quota }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php $sisa = $teacher->max_quota - $teacher->students_count; @endphp
                                @if($sisa <= 0)
                                    <span class="bg-rose-50 text-rose-600 text-[10px] px-3 py-1.5 rounded-lg font-medium border border-rose-100">Penuh</span>
                                @else
                                    <span class="bg-accent/10 text-accent text-[10px] px-3 py-1.5 rounded-lg font-medium border border-accent/20">{{ $sisa }} Tersisa</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold rounded-lg border border-slate-200 transition shadow-sm text-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit & Reset
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4 opacity-30">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p class="font-medium text-sm">Belum ada data Guru BK</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
