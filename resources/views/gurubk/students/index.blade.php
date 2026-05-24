@extends('layouts.app')
@section('title', 'Data Siswa')
@section('title_display', 'Data Siswa')

@section('content')
<div class="w-full space-y-8" x-data="{ showExport: false, exportMode: 'all', selectedStudents: [], selectAll: false, toggleAll() { if(this.selectAll) { this.selectedStudents = [{!! $students->pluck('id')->map(fn($id) => '\'' . $id . '\'')->join(',') !!}]; } else { this.selectedStudents = []; } }, exportPeriod: 'semester', exportYear: '', exportSemester: '' }">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight">Manajemen Siswa</h2>
            <p class="text-slate-500 font-medium">Kelola data siswa bimbingan Anda ({{ $students->total() }}/{{ $teacher->max_quota }})</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button @click="exportMode = 'all'; showExport = true" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition-all hover:scale-105 active:scale-95 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Anekdot
            </button>
            <a href="{{ route('gurubk.students.claim_classes_form') }}" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-secondary text-white font-bold px-6 py-3 rounded-lg shadow-sm transition-all hover:scale-105 active:scale-95 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Ambil Kelas
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

                <input type="hidden" name="format" value="pdf">

                <div class="pt-4">
                    <button type="submit" @click="setTimeout(() => showExport = false, 500)" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-lg shadow-xl shadow-indigo-600/20 transition-all active:scale-[0.95] font-medium text-xs flex items-center justify-center gap-3">
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
                        $classes = [
                            '7 andalan', '7 budi pekerti', '7 tut wuri handayani', '7 kebangsaan', '7 ki hajar dewantara', '7 merdeka', '7 kebanggaan', '7 harmonis',
                            '8 andalan', '8 budi pekerti', '8 tut wuri handayani', '8 kebangsaan', '8 ki hajar dewantara', '8 merdeka', '8 kebanggaan', '8 harmonis',
                            '9 andalan', '9 budi pekerti', '9 tut wuri handayani', '9 kebangsaan', '9 ki hajar dewantara', '9 merdeka', '9 kebanggaan', '9 harmonis'
                        ];
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

    {{-- Class Tabs --}}
    @if(count($assignedClasses) > 0)
        <div class="flex gap-2 border-b border-slate-100 pb-1 overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
            <a href="{{ route('gurubk.students.index', array_merge(request()->query(), ['class' => '', 'page' => 1])) }}" 
                class="px-5 py-2.5 rounded-t-lg font-bold text-xs border-b-2 transition-all shrink-0 {{ !request('class') ? 'bg-white border-primary text-primary shadow-sm' : 'bg-slate-50 border-transparent text-slate-400 hover:text-slate-600' }}">
                Semua Kelas
            </a>
            @foreach($assignedClasses as $assignedClass)
                <a href="{{ route('gurubk.students.index', array_merge(request()->query(), ['class' => $assignedClass, 'page' => 1])) }}" 
                    class="px-5 py-2.5 rounded-t-lg font-bold text-xs border-b-2 transition-all shrink-0 {{ request('class') === $assignedClass ? 'bg-white border-primary text-primary shadow-sm' : 'bg-slate-50 border-transparent text-slate-400 hover:text-slate-600' }}">
                    Kelas {{ $assignedClass }}
                </a>
            @endforeach
        </div>
    @endif

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
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="hidden md:table-header-group">
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
                <tbody class="block md:table-row-group divide-y divide-slate-100">
                    @forelse($students as $student)
                    <tr class="block md:table-row group hover:bg-slate-50/50 transition-colors p-4 md:p-0 space-y-3 md:space-y-0" :class="selectedStudents.includes('{{ $student->id }}') ? 'bg-primary/5' : ''">
                        <td class="block md:table-cell px-4 md:px-6 py-2 md:py-5 text-left md:text-center">
                            <span class="inline-flex md:hidden text-[9px] font-bold text-slate-400 uppercase mr-2">Pilih:</span>
                            <input type="checkbox" x-model="selectedStudents" value="{{ $student->id }}" class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 cursor-pointer">
                        </td>
                        <td class="block md:table-cell px-4 py-2 md:py-5">
                            <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Info Siswa</span>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-100 shadow-sm flex-shrink-0 bg-slate-50 flex items-center justify-center">
                                    @if($student->photo && file_exists(public_path('storage/' . $student->photo)))
                                        <img src="{{ asset('storage/' . $student->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('gurubk.students.show', $student->id) }}" class="font-bold text-slate-800 leading-tight hover:text-primary hover:underline transition-all">{{ $student->name }}</a>
                                    <p class="text-xs text-slate-500 font-medium">{{ $student->gender }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="block md:table-cell px-4 py-2 md:py-5">
                            <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">NISN</span>
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">{{ $student->nisn }}</span>
                        </td>
                        <td class="block md:table-cell px-4 py-2 md:py-5">
                            <span class="block md:hidden text-[9px] font-bold text-slate-400 uppercase mb-1">Kelas</span>
                            <p class="text-sm font-bold text-slate-700">Kelas {{ $student->class }}</p>
                        </td>
                        <td class="block md:table-cell px-4 py-3 md:py-5 text-right">
                            <a href="{{ route('gurubk.students.show', $student->id) }}" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-primary text-slate-400 hover:text-white font-bold px-4 py-2 rounded-lg border border-slate-200 hover:border-primary transition-all shadow-sm text-xs group/btn w-full md:w-auto">
                                Detail Siswa
                                <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="block md:table-row">
                        <td colspan="5" class="block md:table-cell px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-lg flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold tracking-tight">Belum ada data siswa</p>
                                <a href="{{ route('gurubk.students.claim_classes_form') }}" class="text-blue-600 font-bold hover:underline text-sm">Ambil Kelas Pertama Anda</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
            <div class="px-8 py-5 border-t border-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
