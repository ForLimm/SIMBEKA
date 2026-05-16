@extends('layouts.app')
@section('title', 'Tambah Guru BK - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Administrasi Staf')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.teachers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Tambah Guru BK</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Registrasi Personel Guru BK Baru</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.teachers.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf
        
        {{-- Left: Identitas Staf (8/12) --}}
        <div class="xl:col-span-8">
            <div class="card-premium overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas Staf BK</h3>
                    <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest leading-none">Wajib Diisi *</span>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan nama lengkap & gelar">
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Email Sekolah <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="email@sekolah.sch.id">
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Password Default <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">NIP (Nomor Induk Pegawai) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Wajib diisi">
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Jatah Kuota Bimbingan <span class="text-rose-500">*</span></label>
                        <input type="number" name="max_quota" value="50" min="1" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-bold text-center">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Submit Card (4/12) --}}
        <div class="xl:col-span-4">
            <div class="card-premium bg-[#1e1e2d] border-none p-8 flex flex-col justify-center items-center text-center text-white relative overflow-hidden group">
                {{-- Decor --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-3xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-6 border border-white/10 group-hover:border-primary/50 transition-colors">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                
                <h4 class="text-xl font-black mb-2 relative z-10">Simpan Staf Baru</h4>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-8 relative z-10">Data akun akan langsung aktif setelah disimpan.</p>
                
                <div class="w-full space-y-3 relative z-10">
                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-black py-4 rounded-2xl shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.95] text-sm uppercase tracking-widest">
                        Konfirmasi & Simpan
                    </button>
                    <button type="reset" class="w-full bg-white/5 hover:bg-white/10 text-slate-500 font-bold py-3 rounded-2xl transition text-[9px] uppercase tracking-[0.2em]">
                        Reset Formulir
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
