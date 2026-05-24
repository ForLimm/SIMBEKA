@extends('layouts.app')
@section('title', 'Edit Data Siswa - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Master Data Siswa')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-slate-100 shadow-sm">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition shadow-sm text-xs group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="h-8 w-px bg-slate-100"></div>
            <div>
                <h2 class="text-2xl font-semibold text-slate-800 tracking-tight leading-none">Edit Data Siswa</h2>
                <p class="text-slate-500 text-xs font-medium mt-2">Perbarui data identitas dan akun siswa.</p>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-lg text-sm font-bold shadow-sm">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf
        @method('PUT')
        
        {{-- Left Column (8/12) --}}
        <div class="xl:col-span-8 space-y-6">
            {{-- Data Identitas Pribadi --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100">
                    <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Identitas Pribadi Siswa</h3>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-x-5 gap-y-4">
                    <div class="md:col-span-4">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" value="{{ old('name', $student->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Nama lengkap">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">NISN <span class="text-rose-500">*</span></label>
                        <input type="text" name="nisn" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('nisn', $student->nisn) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="10 Digit Angka">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Kelas</label>
                        <select name="class" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Kelas</option>
                            @foreach([
                                '7 andalan', '7 budi pekerti', '7 tut wuri handayani', '7 kebangsaan', '7 ki hajar dewantara', '7 merdeka', '7 kebanggaan', '7 harmonis',
                                '8 andalan', '8 budi pekerti', '8 tut wuri handayani', '8 kebangsaan', '8 ki hajar dewantara', '8 merdeka', '8 kebanggaan', '8 harmonis',
                                '9 andalan', '9 budi pekerti', '9 tut wuri handayani', '9 kebangsaan', '9 ki hajar dewantara', '9 merdeka', '9 kebanggaan', '9 harmonis'
                            ] as $kls)
                                <option value="{{ $kls }}" {{ old('class', $student->class) == $kls ? 'selected' : '' }}>Kelas {{ $kls }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Jenis Kelamin</label>
                        <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Gender</option>
                            <option value="Laki-laki" {{ old('gender', $student->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $student->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Agama</label>
                        <select name="religion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agm)
                                <option value="{{ $agm }}" {{ old('religion', $student->religion) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Tempat Lahir</label>
                        <input type="text" name="birth_place" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" value="{{ old('birth_place', $student->birth_place) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Kota">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('Y-m-d') : '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Status Tinggal</label>
                        <select name="living_status" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Status</option>
                            @foreach(['Bersama Orang Tua','Bersama Wali','Kos / Kontrak','Panti Asuhan','Lainnya'] as $stts)
                                <option value="{{ $stts }}" {{ old('living_status', $student->living_status) == $stts ? 'selected' : '' }}>{{ $stts }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Alamat Lengkap</label>
                        <input type="text" name="address" value="{{ old('address', $student->address) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Alamat lengkap siswa">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">No. HP Siswa</label>
                        <input type="text" name="phone" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('phone', $student->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Maks 15 Digit Angka">
                    </div>

                    <div class="md:col-span-6 space-y-3">
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Foto Siswa (4x6)</label>
                        <div class="flex items-center gap-4">
                            @if($student->photo && file_exists(public_path('storage/' . $student->photo)))
                                <div class="w-16 h-20 border border-slate-200 rounded-lg overflow-hidden flex-shrink-0 bg-slate-50 relative group">
                                    <img src="{{ asset('storage/' . $student->photo) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="remove_photo" id="remove_photo" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                    <label for="remove_photo" class="text-xs font-bold text-rose-600 cursor-pointer">Hapus Foto Lama</label>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="photo" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-xs focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
                        <p class="text-[9px] text-slate-400 mt-1 font-medium ml-1">Format: JPG, JPEG, PNG. Maksimal ukuran file: 2MB. (Pilih file untuk mengganti foto)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column (4/12) --}}
        <div class="xl:col-span-4 space-y-6">
            {{-- Penempatan Guru BK --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Penempatan Guru BK</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Guru BK Pembimbing</label>
                        <div class="relative">
                            <select name="teacher_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                                <option value="">-- Belum Ditentukan (Opsional) --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $student->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Orang Tua / Wali --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden bg-white">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h4 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Orang Tua / Wali</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Ayah</label>
                        <input type="text" name="father_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" value="{{ old('father_name', $student->father_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Nama Ayah">
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Nama Ibu</label>
                        <input type="text" name="mother_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')" value="{{ old('mother_name', $student->mother_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Nama Ibu">
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Pekerjaan</label>
                        <select name="parents_job" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['PNS','TNI/POLRI','Karyawan Swasta','Wiraswasta','Buruh','Petani','Nelayan','Tidak Bekerja','Lainnya'] as $job)
                                <option value="{{ $job }}" {{ old('parents_job', $student->parents_job) == $job ? 'selected' : '' }}>{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">No. HP Orang Tua</label>
                        <input type="text" name="parents_phone" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('parents_phone', $student->parents_phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Maks 15 Digit Angka">
                    </div>
                    <div>
                        <label class="block text-[9px] font-semibold text-slate-400 font-medium mb-1.5 ml-1">Alamat Orang Tua</label>
                        <textarea name="parents_address" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none font-medium" placeholder="Kosongkan jika sama dengan siswa">{{ old('parents_address', $student->parents_address) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-4 rounded-lg shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-sm">
                    Perbarui Data Siswa
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
