@extends('layouts.app')
@section('title', 'Buat Surat & Laporan - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Pusat Dokumen BK')

@section('content')
<div class="w-full space-y-8">
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-slate-800 tracking-tight">Buat Surat</h2>
        <p class="text-slate-500 font-medium mt-2">Pilih jenis surat yang ingin Anda buat dan cetak.</p>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        {{-- Card 1: Surat Panggilan --}}
        <a href="{{ route('gurubk.letters.create') }}" class="bg-white border border-slate-200 rounded-lg shadow-sm p-5 hover:shadow-md hover:border-blue-300 transition-all group flex flex-col h-full">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-blue-600 transition-colors">Surat Panggilan</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Buat dan cetak surat panggilan resmi untuk orang tua atau wali siswa terkait penanganan kasus/bimbingan.</p>
                </div>
            </div>
            
            <div class="mt-auto pt-3 border-t border-slate-50 flex items-center gap-2 text-blue-600 font-medium text-xs group-hover:translate-x-1 transition-transform">
                Buat Surat
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </a>

        {{-- Card 2: Surat Skorsing --}}
        <a href="{{ route('gurubk.letters.skorsing.create') }}" class="bg-white border border-slate-200 rounded-lg shadow-sm p-5 hover:shadow-md hover:border-rose-300 transition-all group flex flex-col h-full">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-rose-600 transition-colors">Surat Skorsing</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Buat dan cetak surat pemberitahuan tindakan disiplin berupa skorsing resmi bagi siswa yang melakukan pelanggaran tata tertib.</p>
                </div>
            </div>
            
            <div class="mt-auto pt-3 border-t border-slate-50 flex items-center gap-2 text-rose-600 font-medium text-xs group-hover:translate-x-1 transition-transform">
                Buat Surat
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </a>

        {{-- Card 3: Surat Peringatan (SP1) --}}
        <a href="{{ route('gurubk.letters.sp1.create') }}" class="bg-white border border-slate-200 rounded-lg shadow-sm p-5 hover:shadow-md hover:border-amber-300 transition-all group flex flex-col h-full">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-amber-600 transition-colors">Surat Peringatan (SP1)</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Buat dan cetak surat peringatan pertama (SP1) resmi untuk siswa yang melakukan pelanggaran disiplin.</p>
                </div>
            </div>
            
            <div class="mt-auto pt-3 border-t border-slate-50 flex items-center gap-2 text-amber-600 font-medium text-xs group-hover:translate-x-1 transition-transform">
                Buat Surat
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </a>

        {{-- Card 4: Surat Peringatan (SP2) --}}
        <a href="{{ route('gurubk.letters.sp2.create') }}" class="bg-white border border-slate-200 rounded-lg shadow-sm p-5 hover:shadow-md hover:border-orange-300 transition-all group flex flex-col h-full">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-orange-600 transition-colors">Surat Peringatan (SP2)</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Buat dan cetak surat peringatan kedua (SP2) resmi untuk siswa yang melakukan pelanggaran disiplin berulang.</p>
                </div>
            </div>
            
            <div class="mt-auto pt-3 border-t border-slate-50 flex items-center gap-2 text-orange-600 font-medium text-xs group-hover:translate-x-1 transition-transform">
                Buat Surat
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </a>
    </div>
</div>
@endsection
