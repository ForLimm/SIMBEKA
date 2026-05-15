@extends('layouts.app')
@section('title', 'Master Data Guru BK - SIMBEKA')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Master Data Guru BK</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola data guru bimbingan konseling dan kuota siswa.</p>
    </div>
    <a href="{{ route('admin.teachers.create') }}" class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">+ Tambah Guru BK</a>
</div>

<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama Guru</th>
                <th class="px-4 py-3 font-semibold text-gray-600">NIP</th>
                <th class="px-4 py-3 font-semibold text-gray-600 text-center">Siswa Terdaftar</th>
                <th class="px-4 py-3 font-semibold text-gray-600 text-center">Sisa Kuota</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($teachers as $teacher)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $teacher->user->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $teacher->nip ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-medium {{ $teacher->students_count >= $teacher->max_quota ? 'text-red-600' : 'text-gray-700' }}">
                        {{ $teacher->students_count }} / {{ $teacher->max_quota }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        @php $sisa = $teacher->max_quota - $teacher->students_count; @endphp
                        @if($sisa <= 0)
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded font-medium">Penuh</span>
                        @else
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded font-medium">{{ $sisa }} Tersisa</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data Guru BK.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
