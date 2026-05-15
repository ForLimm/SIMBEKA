@extends('layouts.app')
@section('title', 'Dashboard Siswa - SIMBEKA')

@section('content')
<div x-data="{ tab: 'menu' }">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Dashboard Siswa</h2>
        <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}.
            @if(auth()->user()->is_guest)
                <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded ml-1">Tamu</span>
            @endif
        </p>
    </div>

    {{-- Tab Navigation --}}
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex gap-6">
            <button @click="tab = 'menu'" :class="tab === 'menu' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 border-b-2 text-sm font-medium transition">
                Menu Utama
            </button>
            <button @click="tab = 'konsultasi'" :class="tab === 'konsultasi' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 border-b-2 text-sm font-medium transition">
                Riwayat Konseling
                @if(isset($konsultasi) && $konsultasi->count() > 0)
                    <span class="ml-1 bg-blue-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $konsultasi->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'pelaporan'" :class="tab === 'pelaporan' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 border-b-2 text-sm font-medium transition">
                Riwayat Pelaporan
                @if(isset($pelaporan) && $pelaporan->count() > 0)
                    <span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $pelaporan->count() }}</span>
                @endif
            </button>
        </nav>
    </div>

    {{-- Tab: Menu Utama --}}
    <div x-show="tab === 'menu'" x-transition.opacity>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Konsultasi --}}
            <a href="{{ route('lapor.create', ['type' => 'konsultasi']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm p-6 hover:border-blue-400 hover:shadow transition group">
                <div class="flex items-center gap-4 mb-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">Konsultasi BK</h3>
                </div>
                <p class="text-sm text-gray-500">Ceritakan masalah pribadi, akademik, atau karir Anda secara personal kepada Guru BK.</p>
            </a>

            {{-- Pelaporan --}}
            <a href="{{ route('lapor.create', ['type' => 'pelaporan']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm p-6 hover:border-red-400 hover:shadow transition group">
                <div class="flex items-center gap-4 mb-3">
                    <div class="bg-red-100 text-red-600 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-red-600 transition">Pelaporan Kasus</h3>
                </div>
                <p class="text-sm text-gray-500">Laporkan pelanggaran, perundungan, atau insiden di sekolah. Identitas Anda dijaga kerahasiaannya.</p>
            </a>
        </div>
    </div>

    {{-- Tab: Riwayat Konseling --}}
    <div x-show="tab === 'konsultasi'" x-transition.opacity x-cloak>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Perihal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Prioritas</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Guru BK</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($konsultasi as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $report->title }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded font-medium {{ $report->priority === 'high' ? 'bg-red-100 text-red-700' : ($report->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                    {{ ucfirst($report->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($report->status === 'pending')
                                    <span class="text-xs px-2 py-0.5 rounded font-medium bg-gray-100 text-gray-600">Menunggu</span>
                                @elseif($report->status === 'in-progress')
                                    <span class="text-xs px-2 py-0.5 rounded font-medium bg-blue-100 text-blue-700">Dalam Proses</span>
                                @else
                                    <span class="text-xs px-2 py-0.5 rounded font-medium bg-green-100 text-green-700">Selesai</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-sm">{{ $report->handler ? $report->handler->name : '-' }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $report->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($report->status === 'in-progress' && $report->handled_by)
                                    <a href="{{ route('chat.show', $report->id) }}" class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        Chat
                                    </a>
                                @elseif($report->status === 'pending')
                                    <span class="text-xs text-gray-400 italic">Menunggu diambil</span>
                                @else
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-xs text-green-600 font-medium">✓ Selesai</span>
                                        <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus riwayat ini dari tampilan Anda? (Tetap tersimpan di Arsip Sekolah)')">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus Riwayat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat konseling.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tab: Riwayat Pelaporan --}}
    <div x-show="tab === 'pelaporan'" x-transition.opacity x-cloak>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Perihal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Prioritas</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pelaporan as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $report->title }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded font-medium {{ $report->priority === 'high' ? 'bg-red-100 text-red-700' : ($report->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                    {{ ucfirst($report->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($report->status === 'pending')
                                    <span class="text-xs px-2 py-0.5 rounded font-medium bg-gray-100 text-gray-600">Menunggu</span>
                                @elseif($report->status === 'in-progress')
                                    <span class="text-xs px-2 py-0.5 rounded font-medium bg-blue-100 text-blue-700">Dalam Proses</span>
                                @else
                                    <span class="text-xs px-2 py-0.5 rounded font-medium bg-green-100 text-green-700">Selesai</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $report->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('siswa.report.hide', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus riwayat ini dari tampilan Anda? (Tetap tersimpan di Arsip Sekolah)')">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Hapus Riwayat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat pelaporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
