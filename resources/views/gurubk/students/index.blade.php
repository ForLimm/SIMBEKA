@extends('layouts.app')
@section('title', 'Data Siswa')
@section('title_display', 'Data Siswa')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen Siswa</h2>
            <p class="text-slate-500 font-medium">Kelola data siswa bimbingan Anda ({{ $students->count() }}/{{ $teacher->max_quota }})</p>
        </div>
        <a href="{{ route('gurubk.students.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-black px-6 py-3 rounded-2xl shadow-lg shadow-primary/20 transition-all hover:scale-105 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Siswa
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="card-premium p-4">
        <form action="{{ route('gurubk.students.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 pl-12 pr-4 text-sm font-bold placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all" 
                    placeholder="Cari berdasarkan Nama atau NISN...">
            </div>
            
            <div class="w-full md:w-48">
                <select name="class" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @php
                        $classes = ['7A', '7B', '7C', '8A', '8B', '8C', '9A', '9B', '9C'];
                    @endphp
                    @foreach($classes as $class)
                        <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>Kelas {{ $class }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-black px-8 py-3 rounded-2xl transition shadow-lg shadow-slate-900/10 active:scale-95 text-sm">
                Filter
            </button>
            
            @if(request('search') || request('class'))
                <a href="{{ route('gurubk.students.index') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-black px-6 py-3 rounded-2xl transition active:scale-95 text-sm flex items-center justify-center">
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
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Info Siswa</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">NISN</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Kelas</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm border border-primary/20">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('gurubk.students.show', $student->id) }}" class="font-bold text-slate-800 leading-tight hover:text-primary hover:underline transition-all">{{ $student->name }}</a>
                                    <p class="text-xs text-slate-500 font-medium">{{ $student->gender }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">{{ $student->nisn }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-sm font-bold text-slate-700">{{ $student->class }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('gurubk.students.edit', $student->id) }}" class="p-2 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('gurubk.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
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
                        <td colspan="4" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold tracking-tight">Belum ada data siswa</p>
                                <a href="{{ route('gurubk.students.create') }}" class="text-blue-600 font-bold hover:underline text-sm">Tambah Siswa Pertama</a>
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
