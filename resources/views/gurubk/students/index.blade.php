@extends('layouts.app')
@section('title', 'Data Siswa')
@section('title_display', 'Data Siswa')

@section('content')
<div class="max-w-6xl mx-auto space-y-8" x-data="{ showExport: false, exportMode: 'all', selectedStudents: [], selectAll: false, toggleAll() { if(this.selectAll) { this.selectedStudents = [{!! $students->pluck('id')->map(fn($id) => '\'' . $id . '\'')->join(',') !!}]; } else { this.selectedStudents = []; } } }">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight">Manajemen Siswa</h2>
            <p class="text-slate-500 font-medium">Kelola data siswa bimbingan Anda ({{ $students->count() }}/{{ $teacher->max_quota }})</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="exportMode = 'all'; showExport = true" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition-all hover:scale-105 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Anekdot
            </button>
            <a href="{{ route('gurubk.students.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition-all hover:scale-105 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    {{-- Export Modal --}}
    <div x-show="showExport" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showExport = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="bg-indigo-600 p-8 text-white flex items-center justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="font-semibold italic font-medium text-sm" x-text="exportMode === 'all' ? 'Cetak Anekdot Keseluruhan' : (selectedStudents.length === 1 ? 'Cetak Anekdot Individu' : 'Cetak Anekdot Terpilih')">Cetak Anekdot Keseluruhan</h3>
                    <p class="text-indigo-100 text-xs text-slate-500 font-medium mt-1 opacity-80" x-text="exportMode === 'all' ? 'Semua Anak Wali BK' : selectedStudents.length + ' Siswa Terpilih'">Semua Anak Wali BK</p>
                </div>
                <button @click="showExport = false" class="relative z-10 w-8 h-8 flex items-center justify-center bg-white/10 rounded-full text-white hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('gurubk.anecdotes.export') }}" method="GET" class="p-8 space-y-6">
                <template x-if="exportMode === 'selected'">
                    <input type="hidden" name="student_ids" :value="selectedStudents.join(',')">
                </template>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-[10px] font-semibold text-slate-400 font-medium block mb-4 ml-1">Periode Laporan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative">
                                <input type="radio" name="period" value="month" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Bulan Ini</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="period" value="semester" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Semester Ini</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="period" value="year" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Tahun Ini</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="period" value="all" checked class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Semua Data</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <label class="relative col-span-3">
                        <span class="text-[10px] font-semibold text-slate-400 font-medium block mb-4 ml-1">Format Dokumen</span>
                    </label>
                    <label class="relative">
                        <input type="radio" name="format" value="word" checked class="peer sr-only">
                        <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                            <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Word</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="format" value="pdf" class="peer sr-only">
                        <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                            <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">PDF</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="format" value="excel" class="peer sr-only">
                        <div class="p-3 rounded-lg border-2 border-slate-100 bg-slate-50 text-center cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                            <span class="block text-[10px] font-semibold text-slate-800 peer-checked:text-indigo-700 font-medium">Excel</span>
                        </div>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" @click="setTimeout(() => showExport = false, 500)" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-[1.5rem] shadow-xl shadow-indigo-600/20 transition-all active:scale-[0.95] font-medium text-xs flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Unduh Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
        <form action="{{ route('gurubk.students.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 pl-12 pr-4 text-sm font-bold placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all" 
                    placeholder="Cari berdasarkan Nama atau NISN...">
            </div>
            
            <div class="w-full md:w-48">
                <select name="class" class="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 px-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @php
                        $classes = ['7A', '7B', '7C', '8A', '8B', '8C', '9A', '9B', '9C'];
                    @endphp
                    @foreach($classes as $class)
                        <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>Kelas {{ $class }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-8 py-3 rounded-lg transition shadow-sm active:scale-95 text-sm">
                Filter
            </button>
            
            @if(request('search') || request('class'))
                <a href="{{ route('gurubk.students.index') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold px-6 py-3 rounded-lg transition active:scale-95 text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Floating Action Bar --}}
    <div class="fixed bottom-8 left-0 right-0 flex justify-center z-50 pointer-events-none">
        <div x-show="selectedStudents.length > 0" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-12 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-12 scale-95"
             class="bg-slate-900 text-white px-6 py-4 rounded-full shadow-2xl flex items-center gap-6 pointer-events-auto" x-cloak>
            <div class="flex items-center gap-2 border-r border-slate-700 pr-6">
                <span class="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-xs font-semibold" x-text="selectedStudents.length"></span>
                <span class="text-sm font-bold tracking-wide hidden sm:block">Siswa Terpilih</span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" @click="exportMode = 'selected'; showExport = true" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 rounded-lg text-xs font-bold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span class="hidden sm:block">Cetak Anekdot</span>
                </button>
                <form action="{{ route('gurubk.students.bulk_destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa yang dipilih secara permanen?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="student_ids" :value="selectedStudents.join(',')">
                    <button type="submit" class="px-4 py-2 bg-rose-500 hover:bg-rose-600 rounded-lg text-xs font-bold transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span class="hidden sm:block">Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-center w-12 border-b border-slate-100">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 cursor-pointer">
                        </th>
                        <th class="px-4 py-5 text-xs font-bold text-slate-400 font-medium border-b border-slate-100">Info Siswa</th>
                        <th class="px-4 py-5 text-xs font-bold text-slate-400 font-medium border-b border-slate-100">NISN</th>
                        <th class="px-4 py-5 text-xs font-bold text-slate-400 font-medium border-b border-slate-100">Kelas</th>
                        <th class="px-4 py-5 text-xs font-bold text-slate-400 font-medium border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                    <tr class="group hover:bg-slate-50/50 transition-colors" :class="selectedStudents.includes('{{ $student->id }}') ? 'bg-primary/5' : ''">
                        <td class="px-6 py-5 text-center">
                            <input type="checkbox" x-model="selectedStudents" value="{{ $student->id }}" class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 cursor-pointer">
                        </td>
                        <td class="px-4 py-5">
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
                        <td class="px-4 py-5">
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">{{ $student->nisn }}</span>
                        </td>
                        <td class="px-4 py-5">
                            <p class="text-sm font-bold text-slate-700">{{ $student->class }}</p>
                        </td>
                        <td class="px-4 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('gurubk.students.edit', $student->id) }}" class="p-2 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('gurubk.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-lg flex items-center justify-center text-slate-300">
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
