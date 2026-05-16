@extends('layouts.app')
@section('title', 'Detail Siswa - ' . $student->name)
@section('title_display', 'Profil Siswa Binaan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    {{-- Header & Quick Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('gurubk.students.index') }}" class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight leading-none">{{ $student->name }}</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Siswa Binaan: {{ $student->teacher->user->name ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('gurubk.students.edit', $student->id) }}" class="bg-white border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        {{-- Left: Biodata (4/12) --}}
        <div class="xl:col-span-4 space-y-6">
            <div class="card-premium p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-32 bg-primary/5 -z-10"></div>
                <div class="w-24 h-24 bg-white rounded-[2rem] shadow-xl mx-auto flex items-center justify-center text-primary font-black text-4xl border-4 border-white">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <h3 class="mt-6 text-xl font-black text-slate-800">{{ $student->name }}</h3>
                <p class="text-xs font-black text-primary uppercase tracking-widest mt-1">NISN: {{ $student->nisn }}</p>
                <div class="mt-4 inline-block px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full font-black text-[10px] uppercase tracking-widest">
                    Kelas {{ $student->class }}
                </div>
            </div>

            <div class="card-premium p-8 space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">Informasi Personal</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Jenis Kelamin</span>
                        <span class="text-xs font-black text-slate-700">{{ $student->gender }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Tempat Lahir</span>
                        <span class="text-xs font-black text-slate-700">{{ $student->birth_place ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Tanggal Lahir</span>
                        <span class="text-xs font-black text-slate-700">{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d M Y') : '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Agama</span>
                        <span class="text-xs font-black text-slate-700">{{ $student->religion ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="card-premium p-8 space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">Kontak Orang Tua</h4>
                <div class="space-y-4">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Ayah / Ibu</span>
                        <p class="text-xs font-black text-slate-700">{{ $student->father_name ?? '-' }} / {{ $student->mother_name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Telepon</span>
                        <p class="text-xs font-black text-slate-700">{{ $student->parents_phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: History (8/12) --}}
        <div class="xl:col-span-8 space-y-8">
            {{-- Tabs for Histories --}}
            <div x-data="{ tab: 'counseling' }">
                <div class="flex gap-4 mb-6">
                    <button @click="tab = 'counseling'" :class="tab === 'counseling' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                        Riwayat Konsultasi ({{ $student->archives->where('report.type', 'konsultasi')->count() }})
                    </button>
                    <button @click="tab = 'violations'" :class="tab === 'violations' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                        Riwayat Pelanggaran ({{ $student->reports->where('type', 'pelaporan')->count() }})
                    </button>
                    <button @click="tab = 'sessions'" :class="tab === 'sessions' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'bg-white text-slate-500 hover:text-slate-800 border border-slate-100'" class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                        Dokumentasi Sesi ({{ $student->counselingSessions->count() }})
                    </button>
                </div>

                {{-- Counseling Documentation Timeline --}}
                <div x-show="tab === 'sessions'" class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-slate-100 animate-in fade-in slide-in-from-bottom-4 duration-300" x-cloak>
                    @forelse($student->counselingSessions as $session)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            {{-- Dot --}}
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 group-hover:bg-primary group-hover:text-white text-slate-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            {{-- Card --}}
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] card-premium p-6 hover:shadow-xl transition-all">
                                <div class="flex items-center justify-between space-x-2 mb-2">
                                    <div class="font-black text-slate-800">{{ $session->counseling_date->format('d M Y') }}</div>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-black uppercase rounded">{{ $session->category }}</span>
                                </div>
                                <div class="text-sm text-slate-600 mb-4 italic">"{{ $session->summary }}"</div>
                                @if($session->follow_up)
                                    <div class="p-3 bg-primary/5 rounded-xl text-xs text-slate-700 font-medium mb-4">
                                        <span class="block text-[9px] font-black uppercase text-primary mb-1">Tindak Lanjut</span>
                                        {{ $session->follow_up }}
                                    </div>
                                @endif
                                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                    <span class="text-[9px] font-bold text-slate-400">Guru: {{ $session->teacher->user->name }}</span>
                                    @php
                                        $statusClass = [
                                            'selesai' => 'bg-emerald-50 text-emerald-600',
                                            'monitoring' => 'bg-blue-50 text-blue-600',
                                            'tindak_lanjut' => 'bg-amber-50 text-amber-600'
                                        ][$session->status];
                                    @endphp
                                    <span class="px-2 py-0.5 {{ $statusClass }} text-[9px] font-black uppercase rounded">{{ str_replace('_', ' ', $session->status) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-premium p-12 text-center text-slate-400 italic">Belum ada dokumentasi sesi untuk siswa ini.</div>
                    @endforelse
                </div>

                {{-- Counseling List --}}
                <div x-show="tab === 'counseling'" class="space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-300">
                    @forelse($student->archives->where('report.type', 'konsultasi') as $archive)
                        <div class="card-premium p-6 flex gap-6 hover:border-primary/30 transition-all">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h5 class="font-black text-slate-800">{{ $archive->report->title }}</h5>
                                    <span class="text-[10px] font-bold text-slate-400">{{ $archive->completed_date->format('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-slate-500 mt-2 line-clamp-2 italic">"{{ $archive->guidance_notes }}"</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded">Kasus Selesai</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-premium p-12 text-center text-slate-400 italic">Belum ada riwayat konsultasi.</div>
                    @endforelse
                </div>

                {{-- Violation List --}}
                <div x-show="tab === 'violations'" class="space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-300" x-cloak>
                    @forelse($student->reports->where('type', 'pelaporan') as $report)
                        <div class="card-premium p-6 flex gap-6 hover:border-rose-500/30 transition-all">
                            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h5 class="font-black text-slate-800">{{ $report->title }}</h5>
                                    <span class="text-[10px] font-bold text-slate-400">{{ $report->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-slate-500 mt-2">{{ $report->content }}</p>
                                <div class="mt-4 flex items-center gap-3">
                                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest bg-rose-50 px-2 py-0.5 rounded">Terlapor oleh: {{ $report->reporter->name ?? 'Sistem' }}</span>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-black uppercase rounded">{{ $report->status }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-premium p-12 text-center text-slate-400 italic">Bersih dari riwayat pelanggaran.</div>
                    @endforelse
                </div>
            </div>

            {{-- Teacher Notes --}}
            <div class="card-premium p-8 bg-slate-50/50 border-dashed border-2 border-slate-200">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan Tambahan Guru BK</h4>
                </div>
                <div class="text-sm text-slate-600 leading-relaxed italic">
                    {{ $student->notes ?? 'Belum ada catatan khusus untuk siswa ini.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
