@extends('layouts.app')
@section('title', 'Buat Surat Panggilan - SIMBEKA')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800">Buat Surat Panggilan Orang Tua</h2>
        <a href="{{ route('gurubk.dashboard') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <form action="{{ route('gurubk.letters.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Siswa (Bimbingan Anda) <span class="text-red-500">*</span></label>
                <select name="student_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white" required>
                    <option value="" disabled selected>-- Pilih Siswa --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama') }} - {{ $student->class }} (NISN: {{ $student->nisn ?? '-' }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Nama & alamat orang tua akan otomatis diambil dari data siswa.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Panggilan <span class="text-red-500">*</span></label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Panggilan</label>
                    <input type="time" name="time" value="09:00" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Panggilan / Keterangan <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none" placeholder="Contoh: Terkait ketidakhadiran berturut-turut selama 5 hari..." required></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('gurubk.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-5 py-2.5 rounded transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded transition">Generate PDF & Arsipkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
