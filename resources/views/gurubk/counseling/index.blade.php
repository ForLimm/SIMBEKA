@extends('layouts.app')
@section('title', 'Dokumentasi Konseling')
@section('title_display', 'Dokumentasi Sesi Konseling')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight">Riwayat Konseling</h2>
            <p class="text-slate-500 font-medium">Pantau perkembangan bimbingan tatap muka siswa binaan Anda.</p>
        </div>
        <a href="{{ route('gurubk.counseling.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition-all hover:scale-105 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Catat Sesi Baru
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
        <form action="{{ route('gurubk.counseling.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 pl-12 pr-4 text-sm font-bold placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all" 
                    placeholder="Cari Nama atau NISN Siswa...">
            </div>
            
            <div class="w-full md:w-48">
                <select name="category" class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach(['akademik', 'disiplin', 'keluarga', 'pertemanan', 'bullying', 'karier', 'pribadi', 'lainnya'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-48">
                <select name="status" class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="monitoring" {{ request('status') == 'monitoring' ? 'selected' : '' }}>Monitoring</option>
                    <option value="tindak_lanjut" {{ request('status') == 'tindak_lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-8 py-3 rounded-lg transition shadow-sm active:scale-95 text-sm">
                Filter
            </button>
            
            @if(request()->anyFilled(['search', 'category', 'status']))
                <a href="{{ route('gurubk.counseling.index') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold px-6 py-3 rounded-lg transition active:scale-95 text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/30">
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Siswa</th>
                        <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Topik & Kategori</th>
                        <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Ringkasan Sesi</th>
                        <th class="px-6 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Waktu / Status</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($sessions as $session)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-semibold border border-primary/20 transition-transform group-hover:scale-110 shadow-sm">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 leading-none mb-1.5">
                                        <a href="{{ route('gurubk.students.show', $session->student->id) }}" class="hover:text-primary transition-all">{{ $session->student->name }}</a>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[9px] font-bold text-slate-400 font-medium">Siswa Binaan</span>
                                        <span class="text-[9px] font-bold text-slate-300">•</span>
                                        <span class="text-[9px] font-bold text-slate-400 font-medium">Kelas {{ $session->student->class }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="font-bold text-slate-700 leading-snug max-w-xs">
                                {{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[9px] font-semibold text-primary font-medium bg-primary/10 px-2.5 py-0.5 rounded-md">
                                    Konseling
                                </span>
                                <span class="text-[9px] font-semibold text-slate-400 font-medium bg-slate-100 px-2 py-0.5 rounded-md">
                                    {{ ucfirst($session->category) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-xs text-slate-500 font-medium line-clamp-2 max-w-xs italic leading-relaxed">"{{ $session->summary }}"</p>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $sortDate = $session->completed_at ?? $session->counseling_date;
                            @endphp
                            <div class="font-bold text-slate-700 text-xs">{{ $sortDate->translatedFormat('d M Y') }}</div>
                            <div class="text-[9px] text-slate-400 mt-1 font-bold">{{ $sortDate->translatedFormat('H:i') }} WITA</div>
                            @if($session->status === 'selesai')
                                <div class="text-[9px] text-emerald-600 mt-1.5 font-bold uppercase tracking-tighter bg-emerald-50 px-2 py-0.5 rounded-md inline-block">Selesai</div>
                            @else
                                <div class="text-[9px] mt-1.5 font-bold uppercase tracking-tighter px-2 py-0.5 rounded-md inline-block {{ $session->status === 'monitoring' ? 'text-blue-600 bg-blue-50' : 'text-amber-600 bg-amber-50' }}">
                                    {{ str_replace('_', ' ', $session->status) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($session->status === 'selesai')
                                <a href="{{ route('gurubk.counseling.show', $session->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                    Detail Sesi
                                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('gurubk.counseling.edit', $session->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn">
                                        Kelola Sesi
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                    <form action="{{ route('gurubk.counseling.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-400 hover:text-red-600 hover:bg-red-50 hover:border-red-100 transition-all shadow-sm" title="Hapus Sesi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center text-slate-200 mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h4 class="text-slate-400 font-bold">Belum ada dokumentasi konseling</h4>
                                <a href="{{ route('gurubk.counseling.create') }}" class="text-primary font-semibold hover:underline text-sm">Catat Sesi Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $sessions->links() }}
    </div>
</div>
@endsection
