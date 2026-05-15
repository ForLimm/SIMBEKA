@extends('layouts.app')
@section('title', 'Dashboard Guru BK - SIMBEKA')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Dashboard Guru BK</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola laporan dan konsultasi masuk dari siswa.</p>
    </div>
    <div class="flex gap-2 mt-4 md:mt-0">
        <a href="{{ route('gurubk.students.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded transition">Data Siswa</a>
        <a href="{{ route('gurubk.letters.create') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded transition">Buat Surat</a>
        <a href="{{ route('gurubk.archives.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded transition">Arsip</a>
    </div>
</div>

{{-- Tab Navigation --}}
<div x-data="{ tab: 'masuk' }">
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex gap-6">
            <button @click="tab = 'masuk'" :class="tab === 'masuk' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 border-b-2 text-sm font-medium transition">
                Antrean Masuk
                <span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $pendingReports->count() }}</span>
            </button>
            <button @click="tab = 'saya'" :class="tab === 'saya' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 border-b-2 text-sm font-medium transition">
                Kasus Saya
                <span class="ml-1 bg-blue-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $myReports->count() }}</span>
            </button>
        </nav>
    </div>

    {{-- Tab: Antrean Masuk --}}
    <div x-show="tab === 'masuk'" x-transition.opacity>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Perihal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Pelapor</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tipe</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Prioritas</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Isi Singkat</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Waktu</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pendingReports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $report->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $report->reporter->username ?? $report->reporter->name ?? '-' }}
                                @if($report->is_anonymous)
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1 rounded ml-1">ANONIM</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($report->type == 'konsultasi')
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded font-medium">Konsultasi</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded font-medium">Pelaporan</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded font-medium
                                    {{ $report->priority === 'high' ? 'bg-red-100 text-red-700' : ($report->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                    {{ ucfirst($report->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ Str::limit($report->content, 60) }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $report->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('gurubk.claim', $report->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded transition">Ambil Kasus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada laporan baru yang perlu ditangani.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tab: Kasus Saya --}}
    <div x-show="tab === 'saya'" x-transition.opacity x-cloak>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Perihal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Pelapor</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tipe</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Prioritas</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal Diambil</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($myReports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $report->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $report->reporter->username ?? $report->reporter->name ?? '-' }}
                                @if($report->is_anonymous)
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1 rounded ml-1">ANONIM</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($report->type == 'konsultasi')
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded font-medium">Konsultasi</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded font-medium">Pelaporan</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded font-medium
                                    {{ $report->priority === 'high' ? 'bg-red-100 text-red-700' : ($report->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                    {{ ucfirst($report->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded font-medium {{ $report->status === 'resolved' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $report->updated_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('gurubk.report.show', $report->id) }}" class="text-blue-600 hover:underline text-xs font-medium">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">Anda belum mengambil kasus apapun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
