@extends('layouts.app')
@section('title', ($type == 'konsultasi' ? 'Form Konsultasi' : 'Form Pelaporan') . ' - SIMBEKA')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800">{{ $type == 'konsultasi' ? 'Form Konsultasi BK' : 'Form Pelaporan Kasus' }}</h2>
        <a href="{{ route('siswa.dashboard') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
    </div>

    @if(auth()->user()->is_guest)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm p-3 rounded mb-4">
            Anda login sebagai tamu. Identitas Anda akan disamarkan sebagai: <strong>{{ auth()->user()->username }}</strong>
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <form action="{{ route('lapor.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Perihal / Topik <span class="text-red-500">*</span></label>
                <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Contoh: Kesulitan belajar, Perundungan, dsb." required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Prioritas <span class="text-red-500">*</span></label>
                <div class="flex gap-6 mt-1">
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="priority" value="low" required class="text-green-600 focus:ring-green-500"> Biasa
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="priority" value="medium" checked class="text-yellow-500 focus:ring-yellow-500"> Penting
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="priority" value="high" class="text-red-600 focus:ring-red-500"> Mendesak
                    </label>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kronologi / Isi Lengkap <span class="text-red-500">*</span></label>
                <textarea name="content" rows="6" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none" placeholder="Ceritakan detail selengkapnya di sini..." required></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded text-sm transition">
                Kirim {{ ucfirst($type) }}
            </button>
        </form>
    </div>
</div>
@endsection
