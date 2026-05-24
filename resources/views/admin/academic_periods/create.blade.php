@extends('layouts.app')
@section('title', 'Buat Periode Akademik Baru - SIMBEKA')
@section('title_display', 'Buat Periode Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-6 bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <a href="{{ route('admin.academic_periods.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <div class="h-8 w-px bg-slate-100"></div>
        <div>
            <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Buat Periode Akademik Baru</h2>
            <p class="text-slate-500 text-xs font-medium mt-2">Atur tahun ajaran dan semester untuk periode baru.</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.academic_periods.store') }}" method="POST" class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden" 
          x-data="{
            academicYear: '{{ old('academic_year', date('Y') . '/' . (date('Y') + 1)) }}',
            semester: '{{ old('semester', '1') }}',
            get periodName() {
                return this.academicYear + ' - Semester ' + this.semester;
            },
            get suggestedStartDate() {
                if (!this.academicYear) return '';
                const parts = this.academicYear.split('/');
                if (parts.length !== 2) return '';
                return this.semester === '1' ? parts[0] + '-07-01' : parts[1] + '-01-01';
            },
            get suggestedEndDate() {
                if (!this.academicYear) return '';
                const parts = this.academicYear.split('/');
                if (parts.length !== 2) return '';
                return this.semester === '1' ? parts[0] + '-12-31' : parts[1] + '-06-30';
            }
          }">
        @csrf

        <div class="p-8 space-y-6">
            {{-- Academic Year --}}
            <div>
                <label for="academic_year" class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Tahun Ajaran</label>
                <select name="academic_year" id="academic_year" x-model="academicYear" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    @for($y = 2024; $y <= date('Y') + 2; $y++)
                        <option value="{{ $y }}/{{ $y + 1 }}" {{ old('academic_year') == $y.'/'.($y+1) ? 'selected' : '' }}>
                            {{ $y }}/{{ $y + 1 }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Semester --}}
            <div>
                <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Semester</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="semester" value="1" x-model="semester" class="sr-only peer" {{ old('semester', '1') == '1' ? 'checked' : '' }}>
                        <div class="px-5 py-4 rounded-lg border-2 text-center transition-all
                            peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary
                            border-slate-200 hover:border-slate-300">
                            <div class="text-sm font-bold">Semester 1</div>
                            <div class="text-[10px] font-medium mt-1 opacity-60">Ganjil (Jul — Des)</div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="semester" value="2" x-model="semester" class="sr-only peer" {{ old('semester') == '2' ? 'checked' : '' }}>
                        <div class="px-5 py-4 rounded-lg border-2 text-center transition-all
                            peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary
                            border-slate-200 hover:border-slate-300">
                            <div class="text-sm font-bold">Semester 2</div>
                            <div class="text-[10px] font-medium mt-1 opacity-60">Genap (Jan — Jun)</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Date Range --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" required
                           :value="suggestedStartDate"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                </div>
                <div>
                    <label for="end_date" class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" required
                           :value="suggestedEndDate"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                </div>
            </div>

            {{-- Preview --}}
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <div>
                    <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Preview Nama Periode</div>
                    <div class="text-sm font-bold text-slate-800 mt-0.5" x-text="periodName"></div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">Periode baru akan dibuat dalam status <strong>nonaktif</strong>. Anda bisa mengaktifkannya nanti.</p>
            <button type="submit" class="bg-slate-900 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition active:scale-[0.98] hover:bg-black text-sm">
                Buat Periode
            </button>
        </div>
    </form>
</div>
@endsection
