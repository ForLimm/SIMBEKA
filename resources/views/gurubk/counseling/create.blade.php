@extends('layouts.app')

@section('title', 'Tambah Catatan Anekdot - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.counseling.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Catatan Anekdot</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Bimbingan & Konseling Tatap Muka</p>
            </div>
        </div>
    </div>

    <form action="{{ route('gurubk.counseling.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf
        
        {{-- Left: Data Konseling (8/12) --}}
        <div class="xl:col-span-8 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-semibold text-slate-400 ">Data Sesi Konseling</h3>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Pilih Siswa Binaan <span class="text-rose-500">*</span></label>
                            <select name="student_id" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                                <option value="">Pilih Siswa...</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }} (Kelas {{ $student->class }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Tanggal Konseling <span class="text-rose-500">*</span></label>
                            <input type="date" name="counseling_date" value="{{ old('counseling_date', date('Y-m-d')) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Topik / Judul Bimbingan <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Contoh: Motivasi Belajar Menurun / Pelanggaran Disiplin">
                    </div>

                    <div x-data="{ 
                        isCustom: {{ !in_array(old('category'), ['akademik', 'disiplin', 'keluarga', 'pertemanan', 'bullying', 'karier', 'pribadi']) && old('category') !== null ? 'true' : 'false' }}, 
                        categoryValue: '{{ old('category') }}' 
                    }">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Kategori Masalah <span class="text-rose-500">*</span></label>
                        
                        {{-- Select Dropdown --}}
                        <div x-show="!isCustom">
                            <select 
                                x-model="categoryValue" 
                                x-on:change="if(categoryValue === 'lainnya') { isCustom = true; categoryValue = ''; }"
                                :name="!isCustom ? 'category' : ''" 
                                :required="!isCustom"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium"
                            >
                                <option value="">Pilih Kategori...</option>
                                <option value="akademik">Akademik</option>
                                <option value="disiplin">Disiplin</option>
                                <option value="keluarga">Keluarga</option>
                                <option value="pertemanan">Pertemanan</option>
                                <option value="bullying">Bullying</option>
                                <option value="karier">Karier</option>
                                <option value="pribadi">Pribadi</option>
                                <option value="lainnya">Lainnya (Isi Manual...)</option>
                            </select>
                        </div>

                        {{-- Text Input for Custom Category --}}
                        <div x-show="isCustom" x-cloak class="flex gap-2">
                            <div class="relative flex-grow">
                                <input 
                                    type="text" 
                                    x-model="categoryValue"
                                    :name="isCustom ? 'category' : ''" 
                                    :required="isCustom"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-16 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" 
                                    placeholder="Tulis kategori masalah secara manual..."
                                >
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-[8px] font-semibold text-primary/70 uppercase tracking-wider bg-primary/10 px-2 py-0.5 rounded">Manual</span>
                                </div>
                            </div>
                            <button 
                                type="button" 
                                x-on:click="isCustom = false; categoryValue = '';" 
                                class="px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-500 hover:text-slate-700 transition flex items-center justify-center shadow-sm"
                                title="Kembali ke pilihan"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Ringkasan Konseling <span class="text-rose-500">*</span></label>
                        <textarea name="summary" rows="6" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium italic resize-none" placeholder="Tuliskan inti dari sesi konseling yang telah dilakukan...">{{ old('summary') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Status & Action (4/12) --}}
        <div class="xl:col-span-4 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-[10px] font-semibold text-slate-400 font-medium">Status & Tindak Lanjut</h4>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-3 ml-1">Status Konseling <span class="text-rose-500">*</span></label>
                        <div class="space-y-2">
                            @foreach(['monitoring' => 'Monitoring', 'selesai' => 'Selesai'] as $val => $label)
                                <label class="relative cursor-pointer block group">
                                    <input type="radio" name="status" value="{{ $val }}" {{ old('status', 'monitoring') == $val ? 'checked' : '' }} class="peer sr-only">
                                    <div class="py-3 px-4 rounded-lg border border-slate-200 bg-white group-hover:bg-slate-50 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary peer-checked:[&_.indicator-circle]:border-primary peer-checked:[&_.indicator-circle]:bg-primary peer-checked:[&_.indicator-dot]:opacity-100 transition-all shadow-sm flex items-center justify-between">
                                        <span class="text-[10px] font-medium">{{ $label }}</span>
                                        <div class="indicator-circle w-4 h-4 rounded-full border-2 border-slate-200 flex items-center justify-center transition-all">
                                            <div class="indicator-dot w-1.5 h-1.5 rounded-full bg-white opacity-0 transition-all"></div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-semibold text-primary/60 font-medium mb-1.5 ml-1">Rencana Tindak Lanjut</label>
                        <textarea name="follow_up" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none font-medium" placeholder="Apa langkah selanjutnya? (Opsional)">{{ old('follow_up') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-4 rounded-lg shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-sm">
                    Simpan Catatan Anekdot
                </button>
                <button type="reset" class="w-full text-slate-400 font-bold font-medium text-[9px] py-4 hover:text-slate-600 transition">
                    Reset Formulir
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
