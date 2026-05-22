@extends('layouts.app')
@section('title', 'Master Data Siswa - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Master Data Siswa')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 tracking-tight">Master Data Siswa</h2>
            <p class="text-slate-500 font-medium">Kelola seluruh data siswa terdaftar dan hubungkan dengan Guru BK pembimbing.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-3 rounded-lg shadow-sm transition-all flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Impor CSV / Excel
            </button>
            <a href="{{ route('admin.students.create') }}" class="bg-primary hover:bg-secondary text-white font-semibold px-5 py-3 rounded-lg shadow-sm transition-all flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Siswa Manual
            </a>
        </div>
    </div>

    {{-- Error CSV Reporting --}}
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-6 py-4 rounded-lg text-sm font-bold shadow-sm space-y-2">
            <div class="font-bold text-rose-700">Terdapat kesalahan saat memproses data:</div>
            <ul class="list-disc ml-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filter & Search --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.students.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2 ml-1">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NISN..." class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2 ml-1">Filter Kelas</label>
                <div class="relative">
                    <select name="class" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls }}" {{ request('class') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2 ml-1">Filter Guru BK</label>
                <div class="relative">
                    <select name="teacher_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                        <option value="">Semua Guru BK</option>
                        <option value="unassigned" {{ request('teacher_id') == 'unassigned' ? 'selected' : '' }}>Belum Ditentukan (Unassigned)</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>{{ $t->user->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2.5 rounded-lg text-sm transition">Filter</button>
                <a href="{{ route('admin.students.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-4 py-2.5 rounded-lg text-sm transition">Reset</a>
            </div>
        </form>
    </div>

    {{-- Student Database Table --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden shadow-xl shadow-slate-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/30">
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Siswa</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">NISN</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-center">Kelas</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50">Guru BK Pembimbing</th>
                        <th class="px-8 py-5 text-[10px] font-semibold text-slate-400 font-medium border-b border-slate-50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-100 shadow-sm flex-shrink-0 bg-slate-50 flex items-center justify-center">
                                        @if($student->photo && file_exists(public_path('storage/' . $student->photo)))
                                            <img src="{{ asset('storage/' . $student->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $student->name }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">{{ $student->user?->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-500 font-medium">{{ $student->nisn ?? '-' }}</td>
                            <td class="px-8 py-5 text-center font-semibold text-slate-700">{{ $student->class ?? '-' }}</td>
                            <td class="px-8 py-5">
                                @if($student->teacher)
                                    <span class="font-semibold text-slate-800">{{ $student->teacher->user->name }}</span>
                                @else
                                    <span class="text-rose-500 text-xs font-bold uppercase tracking-tight bg-rose-50 border border-rose-100/50 px-2 py-1 rounded">Belum Ditentukan</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold rounded-lg border border-slate-200 transition text-xs shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Semua sesi bimbingan dan pelaporan terkait siswa ini juga akan terhapus.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-lg border border-rose-200 transition text-xs shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5  7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4 opacity-30">
                                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p class="font-medium text-slate-500">Belum ada data siswa terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
            <div class="px-8 py-5 border-t border-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Import CSV Modal --}}
<div id="importModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60" aria-hidden="true" onclick="document.getElementById('importModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
            <div class="bg-primary px-6 py-4 text-white flex items-center justify-between">
                <h3 class="text-md font-bold">Impor Data Siswa via Excel CSV</h3>
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="text-blue-100 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-xs text-slate-600 space-y-2 leading-relaxed">
                        <div class="font-bold text-slate-700">Petunjuk Format File:</div>
                        <p>Format file harus berupa <strong>CSV</strong> (koma atau titik koma sebagai pemisah).</p>
                        <p>Baris pertama file CSV harus berupa nama kolom persis seperti berikut:</p>
                        <code class="block bg-slate-100 p-2 rounded text-[10px] border border-slate-200 font-mono text-slate-800 whitespace-nowrap overflow-x-auto">
                            name,email,password,class,nisn,gender,religion,phone,address,father_name,mother_name
                        </code>
                        <div class="text-rose-500 font-bold">* Kolom name, email, password, dan class wajib diisi.</div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Pilih File CSV</label>
                        <input type="file" name="file" accept=".csv,.txt" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-secondary">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-5 py-2.5 text-slate-500 font-bold hover:text-slate-700 transition text-sm">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2.5 rounded-lg shadow-sm transition">Mulai Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
