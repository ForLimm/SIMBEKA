@extends('layouts.app')
@section('title', 'Tambah Siswa Baru - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Master Data Siswa')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Tambah Siswa Baru</h2>
            <p class="text-slate-500 font-medium">Input data siswa dan tentukan Guru BK pembimbing.</p>
        </div>
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali</span>
        </a>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-2xl text-sm font-bold shadow-sm">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-premium overflow-hidden">
        <div class="bg-primary px-8 py-6 text-white">
            <h3 class="text-lg font-bold">Identitas & Penempatan Siswa</h3>
            <p class="text-blue-100 text-[10px] font-black uppercase tracking-widest opacity-80 mt-1">Sistem Informasi Manajemen Bimbingan & Konseling</p>
        </div>

        <form action="{{ route('admin.students.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan nama lengkap siswa" required value="{{ old('name') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Akun <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="siswa@sekolah.sch.id" required value="{{ old('email') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Password Default <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">NISN</label>
                        <input type="text" name="nisn" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="10 Digit NISN" value="{{ old('nisn') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kelas <span class="text-rose-500">*</span></label>
                        <input type="text" name="class" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Contoh: IX-1" required value="{{ old('class') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tentukan Guru BK Pembimbing <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="teacher_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium" required>
                            <option value="" disabled selected>-- Pilih Guru BK --</option>
                            @foreach($teachers as $teacher)
                                @php
                                    $isFull = $teacher->students_count >= $teacher->max_quota;
                                @endphp
                                <option value="{{ $teacher->id }}" {{ $isFull ? 'disabled' : '' }}>
                                    {{ $teacher->user->name }} (Terisi: {{ $teacher->students_count }}/{{ $teacher->max_quota }}) 
                                    @if($isFull) - [KUOTA PENUH] @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @if($errors->has('teacher_id'))
                        <p class="text-rose-500 text-[10px] font-bold uppercase tracking-tight mt-1 ml-1">{{ $errors->first('teacher_id') }}</p>
                    @endif
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                <button type="reset" class="px-8 py-4 text-slate-400 font-bold hover:text-slate-600 transition text-sm">Reset</button>
                <button type="submit" class="bg-primary hover:bg-secondary text-white font-black px-12 py-4 rounded-2xl shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.95]">
                    Simpan & Daftarkan Siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
