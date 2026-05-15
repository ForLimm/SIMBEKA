@extends('layouts.app')
@section('title', 'Buat ' . ucfirst($type))
@section('title_display', 'Formulir ' . ucfirst($type))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-premium overflow-hidden">
        <div class="bg-blue-600 p-8 text-white">
            <h2 class="text-2xl font-bold">Lengkapi Data {{ ucfirst($type) }}</h2>
            <p class="text-blue-100 text-sm mt-1 font-medium opacity-80 uppercase tracking-widest">Detail Pelaporan & Konsultasi</p>
        </div>

        <form action="{{ route('lapor.store') }}" method="POST" class="p-8 space-y-8">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="space-y-6">
                {{-- Title --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label class="text-sm font-bold text-slate-600 uppercase tracking-wider">Perihal / Judul <span class="text-rose-500">*</span></label>
                    <div class="md:col-span-2">
                        <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition" placeholder="Contoh: Konsultasi Masalah Akademik">
                    </div>
                </div>

                {{-- Content --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="text-sm font-bold text-slate-600 uppercase tracking-wider mt-4">Isi Laporan <span class="text-rose-500">*</span></label>
                    <div class="md:col-span-2">
                        <textarea name="content" required rows="5" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition resize-none" placeholder="Ceritakan detail permasalahan Anda di sini..."></textarea>
                    </div>
                </div>

                {{-- Priority --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label class="text-sm font-bold text-slate-600 uppercase tracking-wider">Tingkat Prioritas <span class="text-rose-500">*</span></label>
                    <div class="md:col-span-2">
                        <select name="priority" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition appearance-none">
                            <option value="low">Rendah (Low)</option>
                            <option value="medium">Sedang (Medium)</option>
                            <option value="high">Tinggi (High)</option>
                        </select>
                    </div>
                </div>

            <div class="pt-8 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-black px-12 py-3.5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all hover:scale-[1.02] active:scale-[0.98] text-sm">
                    Kirim {{ ucfirst($type) }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
