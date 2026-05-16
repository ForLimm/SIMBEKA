@extends('layouts.app')

@section('title', 'Edit Data Siswa - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Edit Data Siswa</h2>
            <p class="text-slate-500 font-medium">Perbarui informasi untuk siswa <strong>{{ $student->name }}</strong>.</p>
        </div>
        <a href="{{ route('gurubk.students.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('gurubk.students.update', $student->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        {{-- Section: Data Pribadi --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    Data Identitas Pribadi
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap Siswa <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name', $student->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="Masukkan nama lengkap siswa">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">NISN <span class="text-red-500">*</span></label>
                    <input type="text" name="nisn" required maxlength="10" value="{{ old('nisn', $student->nisn) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="10 Digit NISN">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="class" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none">
                        <option value="">Pilih Kelas</option>
                        @foreach(['VII-1','VII-2','VII-3','VII-4','VII-5','VII-6','VIII-1','VIII-2','VIII-3','VIII-4','VIII-5','VIII-6','IX-1','IX-2','IX-3','IX-4','IX-5','IX-6'] as $kls)
                            <option value="{{ $kls }}" {{ old('class', $student->class) == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender', $student->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $student->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="Kota Kelahiran">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Agama</label>
                    <select name="religion" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none">
                        <option value="">Pilih Agama</option>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agm)
                            <option value="{{ $agm }}" {{ old('religion', $student->religion) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Tinggal</label>
                    <textarea name="address" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="Alamat lengkap siswa">{{ old('address', $student->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">No. HP Siswa</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Status Tinggal</label>
                    <select name="living_status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none">
                        <option value="">Pilih Status Tinggal</option>
                        @foreach(['Bersama Orang Tua','Bersama Wali','Kos / Kontrak','Panti Asuhan','Lainnya'] as $stts)
                            <option value="{{ $stts }}" {{ old('living_status', $student->living_status) == $stts ? 'selected' : '' }}>{{ $stts }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Section: Data Orang Tua --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <div class="w-8 h-8 bg-secondary rounded-xl flex items-center justify-center text-white shadow-lg shadow-secondary/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    Data Orang Tua / Wali
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Ayah</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="Nama lengkap Ayah">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Ibu</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="Nama lengkap Ibu">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Pekerjaan Orang Tua</label>
                    <select name="parents_job" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach(['PNS','TNI/POLRI','Karyawan Swasta','Wiraswasta','Buruh','Petani','Nelayan','Tidak Bekerja','Lainnya'] as $job)
                            <option value="{{ $job }}" {{ old('parents_job', $student->parents_job) == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">No. HP Orang Tua</label>
                    <input type="text" name="parents_phone" value="{{ old('parents_phone', $student->parents_phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="08xxxxxxxxxx">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Orang Tua</label>
                    <textarea name="parents_address" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition" placeholder="Kosongkan jika sama dengan alamat siswa">{{ old('parents_address', $student->parents_address) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4">
            <button type="submit" class="bg-primary hover:bg-secondary text-white font-black px-12 py-4 rounded-2xl shadow-xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                Perbarui Data Siswa
            </button>
        </div>
    </form>
</div>
@endsection
