@extends('layouts.app')
@section('title', 'Arsip Bimbingan - SIMBEKA')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Arsip Bimbingan & Surat</h2>
        <p class="text-sm text-gray-500 mt-1">Riwayat surat panggilan dan catatan bimbingan.</p>
    </div>
    <div class="flex gap-2 mt-4 md:mt-0">
        <a href="{{ route('gurubk.dashboard') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded transition">&larr; Dashboard</a>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
    <form action="{{ route('gurubk.archives.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Siswa</label>
            <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama..." class="border border-gray-300 rounded px-3 py-2 text-sm w-48 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded px-3 py-2 text-sm w-40 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">Filter</button>
            <a href="{{ route('gurubk.archives.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded transition">Reset</a>
        </div>
    </form>
</div>

{{-- Tabel Arsip --}}
<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">No</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Siswa</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Catatan</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                <th class="px-4 py-3 font-semibold text-gray-600 text-center">Surat PDF</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($archives as $index => $archive)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">
                        @if($archive->student)
                            <span class="font-medium text-gray-800">{{ $archive->student->name ?? ($archive->student->user ? $archive->student->user->name : '-') }}</span>
                            <br><span class="text-xs text-gray-500">{{ $archive->student->class ?? '' }} — NISN: {{ $archive->student->nisn ?? '-' }}</span>
                        @elseif($archive->report)
                            <span class="font-medium text-gray-800">
                                {{ $archive->report->reporter->username ?? $archive->report->reporter->name ?? 'Pelapor' }}
                                @if($archive->report->is_anonymous)
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1 rounded ml-1">ANONIM</span>
                                @endif
                            </span>
                            <br><span class="text-xs text-gray-500 text-blue-600 uppercase">{{ $archive->report->type }}</span>
                        @else
                            <span class="text-gray-400 italic">Data Tidak Ditemukan</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 max-w-sm">{{ $archive->guidance_notes }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $archive->completed_date ? $archive->completed_date->format('d M Y') : '-' }}</td>
                    <td class="px-4 py-3 text-center flex items-center justify-center gap-2">
                        <a href="{{ route('gurubk.archives.show', $archive->id) }}" class="inline-flex items-center gap-1 bg-white border border-gray-300 text-gray-700 text-xs font-medium px-3 py-1.5 rounded hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Detail
                        </a>
                        @if($archive->attachment_path)
                            <a href="{{ asset('storage/' . $archive->attachment_path) }}" target="_blank" class="inline-flex items-center gap-1 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-medium px-3 py-1.5 rounded hover:bg-blue-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                PDF
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada data arsip bimbingan atau surat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
