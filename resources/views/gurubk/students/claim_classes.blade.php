@extends('layouts.app')
@section('title', 'Ambil Kelas Bimbingan - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Ambil Kelas Bimbingan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{
    maxQuota: {{ $teacher->max_quota }},
    classes: [
        @foreach($classData as $c)
        {
            name: '{{ $c->class }}',
            count: {{ $c->total_students }},
            myStudents: {{ $c->my_students }},
            checked: {{ $c->my_students > 0 ? 'true' : 'false' }}
        },
        @endforeach
    ],
    get totalClaimed() {
        return this.classes.filter(c => c.checked).reduce((sum, c) => sum + c.count, 0);
    },
    get isOverQuota() {
        return this.totalClaimed > this.maxQuota;
    }
}">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Ambil Kelas Bimbingan</h2>
                <p class="text-slate-500 text-xs font-medium mt-2">Pilih kelas bimbingan Anda secara massal dari database pusat.</p>
            </div>
        </div>
    </div>

    {{-- Quota Alert / Tracker --}}
    <div class="p-6 rounded-lg border transition-all"
         :class="isOverQuota ? 'bg-rose-50 border-rose-200 text-rose-800' : 'bg-slate-950 text-white border-slate-900 shadow-xl'">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="text-[10px] font-semibold uppercase tracking-wider opacity-60">Kuota Bimbingan Anda</div>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-extrabold" x-text="totalClaimed"></span>
                    <span class="text-sm opacity-60">/ <span x-text="maxQuota"></span> Siswa Terpilih</span>
                </div>
            </div>
            <div class="flex-1 md:max-w-xs">
                <div class="w-full bg-white/10 rounded-full h-2.5 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-300"
                         :class="isOverQuota ? 'bg-rose-500' : 'bg-primary'"
                         :style="'width: ' + Math.min(100, (totalClaimed / maxQuota) * 100) + '%'"></div>
                </div>
                <div class="text-[10px] mt-2 text-right opacity-80" :class="isOverQuota ? 'text-rose-600 font-bold' : ''">
                    <span x-show="isOverQuota">Melebihi kuota bimbingan!</span>
                    <span x-show="!isOverQuota">Sisa kuota: <span x-text="maxQuota - totalClaimed"></span> siswa</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('gurubk.students.claim_classes') }}" method="POST" class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        @csrf
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100 text-center w-20">Pilih</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100">Kelas</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100 text-center w-40">Jumlah Siswa</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100">Status & Pengampu Saat Ini</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($classData as $index => $c)
                        <tr class="hover:bg-slate-50/30 transition-colors" :class="classes[{{ $index }}].checked ? 'bg-primary/5' : ''">
                            <td class="px-8 py-5 text-center">
                                <input type="checkbox" name="classes[]" value="{{ $c->class }}"
                                       x-model="classes[{{ $index }}].checked"
                                       class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary/20 cursor-pointer">
                            </td>
                            <td class="px-8 py-5 font-bold text-slate-800">Kelas {{ $c->class }}</td>
                            <td class="px-8 py-5 text-center font-bold text-slate-700">{{ $c->total_students }} Siswa</td>
                            <td class="px-8 py-5 text-xs">
                                @if($c->my_students > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Kelas Anda
                                    </span>
                                @elseif(isset($classHandlers[$c->class]))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-full font-bold border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Diampu: {{ $classHandlers[$c->class] }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-500 rounded-full font-bold border border-slate-200">
                                        Belum Diklaim
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center text-slate-400 font-medium">
                                Tidak ada data siswa/kelas yang tersedia di database pusat. Hubungi Super Admin untuk mengimpor data siswa terlebih dahulu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500 font-medium">
                Pilih satu atau beberapa kelas lalu klik Simpan.
            </div>
            <button type="submit" :disabled="isOverQuota"
                    class="bg-slate-900 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed hover:bg-black text-sm">
                Simpan Perubahan Kelas
            </button>
        </div>
    </form>
</div>
@endsection
