@extends('layouts.app')
@section('title', 'Tambah Guru BK - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Administrasi Staf')

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.teachers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Tambah Guru BK</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Registrasi Personel Guru BK Baru</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.teachers.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf
        
        {{-- Left: Identitas Staf (8/12) --}}
        <div class="xl:col-span-8">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-semibold text-slate-400 ">Identitas Staf BK</h3>
                    <span class="text-[9px] font-bold text-slate-300 font-medium leading-none">Wajib Diisi *</span>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan nama lengkap & gelar">
                    </div>

                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Email Pribadi Guru <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="email.guru@gmail.com">
                    </div>

                    <div x-data="{ showPass: false }">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Password Default <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-10 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" value="{{ old('password') }}">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="px-1 mt-1.5 text-[8px] text-slate-400 leading-normal">
                            * Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&).
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">NIP (Nomor Induk Pegawai) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" required maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="18 Digit Angka NIP">
                    </div>

                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Jatah Kuota Bimbingan <span class="text-rose-500">*</span></label>
                        <input type="number" name="max_quota" value="50" min="1" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-bold text-center">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Submit Card (4/12) --}}
        <div class="xl:col-span-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8 flex flex-col justify-center items-center text-center relative overflow-hidden group">
                <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-6 border border-primary/20 group-hover:border-primary/50 transition-colors">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                
                <h4 class="text-xl font-semibold mb-2 relative z-10 text-slate-800">Simpan Staf Baru</h4>
                <p class="text-slate-400 text-xs font-medium mb-8 relative z-10">Data akun akan langsung aktif setelah disimpan.</p>
                
                <div class="w-full space-y-3 relative z-10">
                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-4 rounded-lg shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.95] text-sm font-medium">
                        Konfirmasi & Simpan
                    </button>
                    <button type="reset" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-500 font-bold py-3 rounded-lg transition text-[9px] border border-slate-100">
                        Reset Formulir
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
