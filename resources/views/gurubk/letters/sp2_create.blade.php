@extends('layouts.app')
@section('title', 'Buat Surat Peringatan (SP2) - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Administrasi Surat')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.documents.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Surat Peringatan (SP2)</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Generate surat peringatan kedua resmi pelanggaran tata tertib berulang</p>
            </div>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="bg-orange-600 px-8 py-6 text-white">
            <h3 class="text-lg font-bold">Formulir Surat Peringatan Kedua (SP2)</h3>
            <p class="text-orange-100 text-[10px] font-black uppercase tracking-widest opacity-80 mt-1">Sistem Informasi Manajemen Bimbingan & Konseling</p>
        </div>

        <form action="{{ route('gurubk.letters.sp2.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Pilih Siswa (Bimbingan Anda) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="student_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition appearance-none font-medium" required>
                        <option value="" disabled {{ !isset($selectedStudentId) ? 'selected' : '' }}>-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ (isset($selectedStudentId) && $selectedStudentId == $student->id) ? 'selected' : '' }}>{{ $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama') }} - {{ $student->class }} (NISN: {{ $student->nisn ?? '-' }})</option>
                        @endforeach
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tight ml-1 italic">* Nama orang tua akan otomatis diambil dari database.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Surat <span class="text-rose-500">*</span></label>
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus-within:ring-4 focus-within:ring-orange-500/10 focus-within:border-orange-500 transition max-w-sm">
                    <span class="text-sm font-bold text-slate-500">421.7 /</span>
                    <input type="text" name="letter_number" maxlength="3" placeholder="001" class="w-16 bg-transparent border-b-2 border-slate-300 font-bold text-center text-sm outline-none focus:border-orange-500 transition" required>
                    <span class="text-sm font-bold text-slate-500">/ SMP.06 / {{ date('Y') }}</span>
                </div>
                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tight ml-1 italic">* Masukkan 3 digit nomor urut surat (contoh: 001, 012).</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Pelanggaran / Alasan SP2 <span class="text-rose-500">*</span></label>
                <textarea name="reason" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition resize-none font-medium" placeholder="Contoh: Sering bolos sekolah tanpa keterangan dan terlambat masuk..." required></textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-orange-600/20 transition-all hover:scale-[1.02] active:scale-[0.95] flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Generate PDF & Arsipkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
