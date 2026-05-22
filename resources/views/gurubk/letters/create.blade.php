@extends('layouts.app')
@section('title', 'Buat Surat Panggilan - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Administrasi Surat')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.documents.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Surat Panggilan</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Generate surat panggilan orang tua / wali murid</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="bg-primary px-8 py-6 text-white">
            <h3 class="text-lg font-bold">Formulir Panggilan</h3>
            <p class="text-blue-100 text-[10px] font-medium opacity-80 mt-1">Sistem Informasi Manajemen Bimbingan & Konseling</p>
        </div>

        <form action="{{ route('gurubk.letters.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 font-medium mb-2 ml-1">Pilih Siswa (Bimbingan Anda) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="student_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium" required>
                        <option value="" disabled {{ !isset($selectedStudentId) ? 'selected' : '' }}>-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ (isset($selectedStudentId) && $selectedStudentId == $student->id) ? 'selected' : '' }}>{{ $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama') }} - {{ $student->class }} (NISN: {{ $student->nisn ?? '-' }})</option>
                        @endforeach
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tight ml-1 italic">* Nama & alamat orang tua akan otomatis diambil dari database.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 font-medium mb-2 ml-1">Nomor Surat <span class="text-rose-500">*</span></label>
                <input type="text" name="letter_number" placeholder="Contoh: 421.7 / 001 / SMP.06 / {{ date('Y') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" required>
                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tight ml-1 italic">* Masukkan nomor surat secara lengkap.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-400 font-medium mb-2 ml-1">Tanggal Panggilan <span class="text-rose-500">*</span></label>
                    <input type="date" name="date" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 font-medium mb-2 ml-1">Jam Panggilan</label>
                    <input type="time" name="time" value="09:00" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 font-medium mb-2 ml-1">Pilih Ruangan <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="room_select" id="room_select" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium" required>
                        <option value="Ruang Bimbingan Konseling (BK) SMP Negeri 6 Palu">Ruang Bimbingan Konseling (BK)</option>
                        <option value="Ruang Kepala Sekolah SMP Negeri 6 Palu">Ruang Kepala Sekolah</option>
                        <option value="Lainnya">Lainnya (Isi Manual)</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div id="manual_room_container" class="hidden">
                <label class="block text-xs font-bold text-slate-400 font-medium mb-2 ml-1">Nama Ruangan Manual <span class="text-rose-500">*</span></label>
                <input type="text" name="room_manual" id="room_manual" placeholder="Contoh: Ruang Rapat Guru" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-5 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-4 rounded-lg shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.95] flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Generate PDF & Arsipkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('room_select').addEventListener('change', function() {
        const manualContainer = document.getElementById('manual_room_container');
        const manualInput = document.getElementById('room_manual');
        if (this.value === 'Lainnya') {
            manualContainer.classList.remove('hidden');
            manualInput.setAttribute('required', 'required');
        } else {
            manualContainer.classList.add('hidden');
            manualInput.removeAttribute('required');
        }
    });
</script>
@endsection
