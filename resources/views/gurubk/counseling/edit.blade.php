@extends('layouts.app')

@section('title', 'Edit Dokumentasi Konseling - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.counseling.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Edit Dokumentasi</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">ID Sesi: #{{ $session->id }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('gurubk.counseling.update', $session->id) }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf
        @method('PUT')
        
        {{-- Left: Data Konseling (8/12) --}}
        <div class="xl:col-span-8 space-y-4">
            <div class="card-premium overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pembaruan Catatan Sesi</h3>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Siswa Terkait <span class="text-rose-500">*</span></label>
                            <select name="student_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $session->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }} (Kelas {{ $student->class }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Tanggal Konseling <span class="text-rose-500">*</span></label>
                            <input type="date" name="counseling_date" value="{{ $session->counseling_date->format('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Kategori Masalah <span class="text-rose-500">*</span></label>
                        <select name="category" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            @foreach(['akademik', 'disiplin', 'keluarga', 'pertemanan', 'bullying', 'karier', 'pribadi', 'lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ $session->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Ringkasan Konseling <span class="text-rose-500">*</span></label>
                        <textarea name="summary" rows="6" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium italic resize-none" placeholder="Tuliskan inti dari sesi konseling yang telah dilakukan...">{{ $session->summary }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Status & Action (4/12) --}}
        <div class="xl:col-span-4 space-y-4">
            <div class="card-premium overflow-hidden bg-white">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status & Tindak Lanjut</h4>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Status Konseling <span class="text-rose-500">*</span></label>
                        <div class="space-y-2">
                            @foreach(['selesai' => 'Selesai', 'monitoring' => 'Monitoring', 'tindak_lanjut' => 'Tindak Lanjut'] as $val => $label)
                                <label class="relative cursor-pointer block group">
                                    <input type="radio" name="status" value="{{ $val }}" {{ $session->status == $val ? 'checked' : '' }} class="peer sr-only">
                                    <div class="py-3 px-4 rounded-xl border border-slate-200 bg-white group-hover:bg-slate-50 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all shadow-sm flex items-center justify-between">
                                        <span class="text-[10px] font-black uppercase tracking-widest">{{ $label }}</span>
                                        <div class="w-4 h-4 rounded-full border-2 border-slate-200 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all">
                                            <div class="w-1.5 h-1.5 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-primary/60 uppercase tracking-widest mb-1.5 ml-1">Rencana Tindak Lanjut</label>
                        <textarea name="follow_up" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none font-medium" placeholder="Apa langkah selanjutnya? (Opsional)">{{ $session->follow_up }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 rounded-xl shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-sm">
                    Perbarui Dokumentasi
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
