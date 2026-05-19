@extends('layouts.app')

@section('title', 'Pemulihan Akun - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 flex flex-col md:flex-row overflow-hidden bg-white">
    {{-- Left Column: Recovery Form --}}
    <div class="w-full md:w-[45%] flex items-center justify-center p-8 md:p-12 overflow-y-auto custom-scrollbar bg-white">
        <div class="w-full max-w-sm" x-data="{ tab: 'recovery_code' }">
            {{-- Branding Logo --}}
            <div class="mb-8 flex justify-center md:justify-start">
                <a href="{{ url('/') }}" class="block">
                    <img src="{{ asset('assets/images/logo_simbeka_teks.svg') }}" alt="Logo SIMBEKA" class="h-18 w-auto object-contain brightness-0">
                </a>
            </div>

            <div class="mb-8">
                <h1 class="text-4xl font-black text-slate-900 mb-2 leading-tight">Pemulihan <br> Akun Siswa.</h1>
                <p class="text-slate-500 font-medium">Pilih metode pemulihan di bawah ini.</p>
            </div>

            {{-- Alert Messages --}}
            @if($errors->any() || session('success') || session('error'))
                <div class="mb-6 space-y-2">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-[11px] font-bold shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl text-[11px] font-bold shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl text-[11px] font-bold shadow-sm">
                            <ul class="list-disc ml-4 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Tab Switcher --}}
            <div class="flex bg-slate-100 p-1 rounded-2xl mb-8">
                <button @click="tab = 'recovery_code'" :class="tab === 'recovery_code' ? 'bg-white text-primary shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all duration-300">
                    Kode Pemulihan
                </button>
                <button @click="tab = 'security_question'" :class="tab === 'security_question' ? 'bg-white text-primary shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all duration-300">
                    Pertanyaan Keamanan
                </button>
            </div>

            {{-- Method 1: Recovery Code --}}
            <div x-show="tab === 'recovery_code'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <form action="{{ route('recovery.login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                            <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Username akun Anda">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kode Pemulihan (Recovery Code)</label>
                            <input type="text" name="recovery_code" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-black uppercase tracking-[0.2em]" placeholder="ABCD-1234">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 rounded-xl shadow-xl transition-all active:scale-[0.98] text-sm uppercase tracking-widest mt-4">
                        Masuk Sekarang
                    </button>
                </form>
            </div>

            {{-- Method 2: Security Question --}}
            <div x-show="tab === 'security_question'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                            <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Username Anda">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pertanyaan Keamanan</label>
                            <select name="security_question" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                                <option value="">Pilih pertanyaan Anda</option>
                                <option value="Apa nama hewan peliharaan pertama Anda?">Nama hewan peliharaan pertama?</option>
                                <option value="Nama sekolah dasar Anda?">Nama sekolah dasar Anda?</option>
                                <option value="Siapa nama guru favorit Anda?">Siapa nama guru favorit Anda?</option>
                                <option value="Di kota mana orang tua Anda bertemu?">Kota pertemuan orang tua?</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jawaban</label>
                            <input type="text" name="security_answer" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Jawaban rahasia">
                        </div>
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Password Baru</label>
                                <input type="password" name="new_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                                <input type="password" name="new_password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-black py-4 rounded-xl shadow-xl shadow-primary/20 transition-all active:scale-[0.98] text-sm uppercase tracking-widest mt-4">
                        Reset & Masuk
                    </button>
                </form>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    {{-- Right Column: Branding --}}
    <div class="hidden md:flex md:w-[55%] bg-slate-900 relative items-center justify-center p-20 overflow-hidden text-right">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] bg-primary/20 rounded-full blur-[120px]"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[10px] font-black uppercase tracking-[0.2em] mb-12 ml-auto">
                Account Recovery
            </div>
            <h2 class="text-6xl font-black text-white leading-[1.1] mb-8">Pemulihan <br> Akses <span class="text-primary text-7xl italic">Mandiri.</span></h2>
            <div class="h-1.5 w-32 bg-primary mb-8 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-lg leading-relaxed mb-12 font-medium">Lupa kredensial masuk? Gunakan kode pemulihan atau pertanyaan keamanan Anda untuk kembali mengakses workspace.</p>
            
            <div class="flex items-center gap-4 justify-end">
                <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-primary border border-white/10 italic font-black text-xl italic font-serif">?</div>
                <div class="text-left">
                    <p class="text-white text-xs font-black uppercase tracking-widest leading-none">Butuh Bantuan?</p>
                    <p class="text-slate-500 text-[10px] font-bold mt-1 uppercase tracking-tight">Hubungi Admin Sekolah</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
