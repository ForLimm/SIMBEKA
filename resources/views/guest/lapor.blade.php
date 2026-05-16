@extends('layouts.app')
@section('title', 'Buat ' . ucfirst($type) . ' - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Formulir ' . ucfirst($type))

@section('content')
<div class="w-full space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
        <div class="flex items-center gap-6">
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Batal
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Lengkapi Data {{ ucfirst($type) }}</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2 leading-none">Detail Pelaporan & Konsultasi Langsung ke Guru BK</p>
            </div>
        </div>
    </div>

    <form action="{{ route('lapor.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="priority" value="medium">

        {{-- Left: Main Form (8/12) --}}
        <div class="xl:col-span-8 space-y-6">
            <div class="card-premium overflow-hidden bg-white">
                <div class="bg-primary/5 px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Formulir Informasi</h3>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Wajib Diisi *</span>
                </div>
                
                <div class="p-8 space-y-8">
                    {{-- Title Input --}}
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Perihal / Judul <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-base focus:ring-8 focus:ring-primary/5 focus:border-primary outline-none transition-all font-bold text-slate-700 placeholder:font-medium placeholder:text-slate-300" 
                               placeholder="Contoh: Konsultasi Masalah Belajar">
                    </div>

                    {{-- Content Input --}}
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Isi Detail Permasalahan <span class="text-rose-500">*</span></label>
                        <textarea name="content" required rows="10" 
                                  class="w-full bg-slate-50 border border-slate-200 rounded-3xl px-6 py-5 text-base focus:ring-8 focus:ring-primary/5 focus:border-primary outline-none transition-all font-medium text-slate-700 placeholder:text-slate-300 resize-none leading-relaxed" 
                                  placeholder="Ceritakan detail permasalahan Anda di sini secara lengkap..."></textarea>
                    </div>
                </div>

                {{-- Action Bar --}}
                <div class="p-8 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-[9px] font-bold uppercase tracking-widest italic">Sistem mengenkripsi data Anda</span>
                    </div>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-black px-12 py-4 rounded-2xl shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.95] text-sm uppercase tracking-widest">
                        Kirim Formulir
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: Sidebar Info (4/12) --}}
        <div class="xl:col-span-4 space-y-6">
            <div class="card-premium p-8 bg-[#1e1e2d] text-white relative overflow-hidden group border-none">
                {{-- Decor --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-3xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>

                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 border border-white/5">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black mb-4 italic leading-tight">Privasi Data<br>Anda Terjamin</h4>
                    <p class="text-slate-400 text-xs leading-relaxed mb-8 font-medium">Laporan ini bersifat rahasia. Hanya Guru BK yang memiliki otoritas yang dapat melihat detail permasalahan Anda guna memberikan bimbingan yang tepat.</p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-emerald-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">Enkripsi End-to-End</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-emerald-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">Respon Cepat 24 Jam</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-premium p-8 bg-white border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Informasi Bimbingan</h4>
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed italic">"Jangan ragu untuk menyampaikan segala keresahanmu. Kami di sini untuk mendengarkan dan membimbingmu mencapai versi terbaikmu."</p>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="w-1 h-8 bg-primary rounded-full"></div>
                        <span class="text-[10px] font-black text-slate-700 uppercase tracking-widest">Tim Konseling SMPN 6 Palu</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
