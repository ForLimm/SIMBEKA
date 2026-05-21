@extends('layouts.app')

@section('title', 'Tambah Siswa Baru - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('gurubk.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Tambah Siswa</h2>
                <p class="text-slate-400 text-xs text-slate-500 font-medium mt-2">Registrasi Database Bimbingan</p>
            </div>
        </div>
    </div>

    <form action="{{ route('gurubk.students.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf
        
        {{-- Left: Identitas Pribadi (8/12) --}}
        <div class="xl:col-span-8 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-semibold text-slate-400 ">Data Identitas Pribadi</h3>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-x-5 gap-y-4">
                    <div class="md:col-span-4">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" value="{{ old('name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Nama lengkap">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">NISN <span class="text-rose-500">*</span></label>
                        <input type="text" name="nisn" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('nisn') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="10 Digit Angka">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Kelas <span class="text-rose-500">*</span></label>
                        <select name="class" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Kelas</option>
                            @foreach(['VII-1','VII-2','VII-3','VII-4','VII-5','VII-6','VIII-1','VIII-2','VIII-3','VIII-4','VIII-5','VIII-6','IX-1','IX-2','IX-3','IX-4','IX-5','IX-6'] as $kls)
                                <option value="{{ $kls }}" {{ old('class') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Gender</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Agama</label>
                        <select name="religion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agm)
                                <option value="{{ $agm }}" {{ old('religion') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Tempat Lahir</label>
                        <input type="text" name="birth_place" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" value="{{ old('birth_place') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Kota">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Status Tinggal</label>
                        <select name="living_status" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Status</option>
                            @foreach(['Bersama Orang Tua','Bersama Wali','Kos / Kontrak','Panti Asuhan','Lainnya'] as $stts)
                                <option value="{{ $stts }}" {{ old('living_status') == $stts ? 'selected' : '' }}>{{ $stts }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Alamat Lengkap</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Alamat lengkap siswa">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">No. HP Siswa</label>
                        <input type="text" name="phone" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('phone') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Maks 15 Digit Angka">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Data Orang Tua (4/12) --}}
        <div class="xl:col-span-4 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-[10px] font-semibold text-slate-400 font-medium">Data Orang Tua / Wali</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Ayah</label>
                        <input type="text" name="father_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" value="{{ old('father_name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Nama Ayah">
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Ibu</label>
                        <input type="text" name="mother_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" value="{{ old('mother_name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Nama Ibu">
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Pekerjaan</label>
                        <select name="parents_job" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['PNS','TNI/POLRI','Karyawan Swasta','Wiraswasta','Buruh','Petani','Nelayan','Tidak Bekerja','Lainnya'] as $job)
                                <option value="{{ $job }}" {{ old('parents_job') == $job ? 'selected' : '' }}>{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">No. HP Orang Tua</label>
                        <input type="text" name="parents_phone" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('parents_phone') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Maks 15 Digit Angka">
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Alamat Orang Tua</label>
                        <textarea name="parents_address" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none font-medium" placeholder="Kosongkan jika sama dengan siswa">{{ old('parents_address') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-4 rounded-lg shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-sm">
                    Simpan Data Siswa
                </button>
                <button type="reset" class="w-full text-slate-400 font-bold font-medium text-[9px] py-4 hover:text-slate-600 transition">
                    Reset Formulir
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
