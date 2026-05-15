@extends('layouts.app')
@section('title', 'Berhasil Terkirim - SIMBEKA')

@section('content')
<div class="max-w-md mx-auto text-center mt-10">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8">
        <div class="bg-green-100 text-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-2">Berhasil Terkirim!</h2>
        <p class="text-sm text-gray-500 mb-6">Form Anda telah diterima dan akan segera ditindaklanjuti oleh Guru BK.</p>
        <div class="flex gap-3">
            <a href="{{ route('siswa.dashboard') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded text-sm transition text-center">Kembali ke Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 rounded text-sm transition">Keluar</button>
            </form>
        </div>
    </div>
</div>
@endsection
