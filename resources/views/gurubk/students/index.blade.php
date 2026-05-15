@extends('layouts.app')
@section('title', 'Data Siswa Bimbingan - SIMBEKA')

@section('content')
<div x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Data Siswa Bimbingan</h2>
            <p class="text-sm text-gray-500 mt-1">Total: <strong>{{ $students->count() }}</strong> / {{ $teacher->max_quota }} siswa (Sisa kuota: {{ $teacher->max_quota - $students->count() }})</p>
        </div>
        <div class="flex gap-2 mt-4 md:mt-0">
            <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">+ Tambah Siswa</button>
            <a href="{{ route('gurubk.dashboard') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded transition">&larr; Kembali</a>
        </div>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama Lengkap</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">NISN</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">L/P</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">No. HP</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Orang Tua</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Ditambahkan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($students as $index => $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $student->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600 font-mono">{{ $student->nisn ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $student->class ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $student->gender ? substr($student->gender, 0, 1) : '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $student->phone ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                @if($student->father_name || $student->mother_name)
                                    {{ $student->father_name ?? '' }}{{ $student->father_name && $student->mother_name ? ' / ' : '' }}{{ $student->mother_name ?? '' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $student->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada data siswa bimbingan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Siswa --}}
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-start justify-center min-h-screen px-4 pt-10 pb-20">
            <div x-show="showModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/40" @click="showModal = false"></div>

            <div x-show="showModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-lg shadow-xl w-full max-w-3xl z-10 border border-gray-200">
                
                <div class="flex items-center justify-between px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Form Input Data Siswa</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <div class="px-6 py-5 max-h-[75vh] overflow-y-auto">
                    <form action="{{ route('gurubk.students.store') }}" method="POST">
                        @csrf
                        
                        {{-- SECTION: Data Identitas Siswa --}}
                        <fieldset class="mb-6">
                            <legend class="text-sm font-bold text-blue-700 uppercase tracking-wide mb-3 border-b border-blue-100 pb-2 w-full">Data Identitas Siswa</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NISN (10 Digit) <span class="text-red-500">*</span></label>
                                    <input type="text" name="nisn" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" required minlength="10" maxlength="10" pattern="\d{10}" title="NISN harus 10 digit angka" value="{{ old('nisn') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                                    <input type="text" name="class" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required placeholder="Contoh: XII IPA 1" value="{{ old('class') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                    <input type="text" name="birth_place" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" value="{{ old('birth_place') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" value="{{ old('birth_date') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <select name="gender" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                                    <select name="religion" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                                        <option value="">-- Pilih --</option>
                                        <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Siswa</label>
                                    <input type="text" name="phone" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Siswa</label>
                                    <textarea name="address" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </fieldset>

                        {{-- SECTION: Data Keluarga --}}
                        <fieldset class="mb-6">
                            <legend class="text-sm font-bold text-red-600 uppercase tracking-wide mb-3 border-b border-red-100 pb-2 w-full">Data Keluarga / Wali</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                                    <input type="text" name="father_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" value="{{ old('father_name') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                                    <input type="text" name="mother_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" value="{{ old('mother_name') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Orang Tua</label>
                                    <input type="text" name="parents_job" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" value="{{ old('parents_job') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Orang Tua / Wali</label>
                                    <input type="text" name="parents_phone" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="08xxxxxxxxxx" value="{{ old('parents_phone') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Tinggal</label>
                                    <select name="living_status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                                        <option value="">-- Pilih --</option>
                                        <option value="Bersama Orang Tua" {{ old('living_status') == 'Bersama Orang Tua' ? 'selected' : '' }}>Bersama Orang Tua</option>
                                        <option value="Bersama Wali / Saudara" {{ old('living_status') == 'Bersama Wali / Saudara' ? 'selected' : '' }}>Bersama Wali / Saudara</option>
                                        <option value="Kost / Asrama" {{ old('living_status') == 'Kost / Asrama' ? 'selected' : '' }}>Kost / Asrama</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Orang Tua / Wali</label>
                                    <textarea name="parents_address" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none">{{ old('parents_address') }}</textarea>
                                </div>
                            </div>
                        </fieldset>

                        {{-- Submit --}}
                        <div class="flex justify-end gap-3 border-t pt-4">
                            <button type="button" @click="showModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-5 py-2.5 rounded transition">Batal</button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded transition">Simpan Data Siswa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
