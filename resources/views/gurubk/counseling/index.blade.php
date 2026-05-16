@extends('layouts.app')
@section('title', 'Dokumentasi Konseling')
@section('title_display', 'Dokumentasi Sesi Konseling')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Riwayat Konseling</h2>
            <p class="text-slate-500 font-medium">Pantau perkembangan bimbingan tatap muka siswa binaan Anda.</p>
        </div>
        <a href="{{ route('gurubk.counseling.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-black px-6 py-3 rounded-2xl shadow-lg shadow-primary/20 transition-all hover:scale-105 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Catat Sesi Baru
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="card-premium p-4">
        <form action="{{ route('gurubk.counseling.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 pl-12 pr-4 text-sm font-bold placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all" 
                    placeholder="Cari Nama atau NISN Siswa...">
            </div>
            
            <div class="w-full md:w-48">
                <select name="category" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach(['akademik', 'disiplin', 'keluarga', 'pertemanan', 'bullying', 'karier', 'pribadi', 'lainnya'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-48">
                <select name="status" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="monitoring" {{ request('status') == 'monitoring' ? 'selected' : '' }}>Monitoring</option>
                    <option value="tindak_lanjut" {{ request('status') == 'tindak_lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                </select>
            </div>
            
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-black px-8 py-3 rounded-2xl transition shadow-lg shadow-slate-900/10 active:scale-95 text-sm">
                Filter
            </button>
            
            @if(request()->anyFilled(['search', 'category', 'status']))
                <a href="{{ route('gurubk.counseling.index') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-black px-6 py-3 rounded-2xl transition active:scale-95 text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Tanggal</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Info Siswa</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Kategori</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Ringkasan</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-slate-800">{{ $session->counseling_date->format('d M Y') }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm border border-primary/20">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('gurubk.students.show', $session->student->id) }}" class="font-bold text-slate-800 leading-tight hover:text-primary hover:underline transition-all">{{ $session->student->name }}</a>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Kelas {{ $session->student->class }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $session->category }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs text-slate-500 font-medium line-clamp-2 max-w-xs italic leading-relaxed">"{{ $session->summary }}"</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center">
                                @php
                                    $statusColors = [
                                        'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'monitoring' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'tindak_lanjut' => 'bg-amber-50 text-amber-600 border-amber-100'
                                    ];
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl border {{ $statusColors[$session->status] }} text-[9px] font-black uppercase tracking-widest whitespace-nowrap">
                                    {{ str_replace('_', ' ', $session->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('gurubk.counseling.edit', $session->id) }}" class="p-2 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('gurubk.counseling.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h4 class="text-slate-400 font-bold">Belum ada dokumentasi konseling</h4>
                                <a href="{{ route('gurubk.counseling.create') }}" class="text-primary font-black hover:underline text-sm">Catat Sesi Pertama</a>
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
