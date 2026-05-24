@extends('layouts.app')

@section('title', 'Pemulihan Akun - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 flex flex-col md:flex-row overflow-hidden bg-white">
    {{-- Left Column: Recovery Form --}}
    <div class="w-full md:w-[45%] flex items-center justify-center p-8 md:p-12 overflow-y-auto custom-scrollbar bg-white">
        <div class="w-full max-w-sm" x-data="{ tab: 'recovery_code', showPass: false, showConf: false, isCustomQuestion: false }">
            {{-- Branding Logo --}}
            <div class="mb-8 flex justify-center md:justify-start">
                <a href="{{ url('/') }}" class="block">
                    <img src="{{ asset('assets/images/logo_simbeka_teks.svg') }}" alt="Logo SIMBEKA" class="h-18 w-auto object-contain brightness-0">
                </a>
            </div>

            <div class="mb-8">
                <h1 class="text-4xl font-semibold text-slate-900 mb-2 leading-tight">Pemulihan <br> Akun Siswa.</h1>
                <p class="text-slate-500 font-medium">Pilih metode pemulihan di bawah ini.</p>
            </div>

            {{-- Alert Messages --}}
            @if($errors->any() || session('success') || session('error'))
                <div class="mb-6 space-y-2">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-lg text-[11px] font-bold shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-lg text-[11px] font-bold shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-lg text-[11px] font-bold shadow-sm">
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
            <div class="flex bg-slate-100 p-1 rounded-lg mb-8">
                <button @click="tab = 'recovery_code'" :class="tab === 'recovery_code' ? 'bg-white text-primary shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="flex-1 py-3 rounded-lg text-[10px] font-semibold uppercase tracking-wider transition-all duration-300">
                    Kode Pemulihan
                </button>
                <button @click="tab = 'security_question'" :class="tab === 'security_question' ? 'bg-white text-primary shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="flex-1 py-3 rounded-lg text-[10px] font-semibold uppercase tracking-wider transition-all duration-300">
                    Pertanyaan Keamanan
                </button>
            </div>

            {{-- Method 1: Recovery Code --}}
            <div x-show="tab === 'recovery_code'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <form action="{{ route('recovery.login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold text-slate-400 font-medium ml-1">Username</label>
                            <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Username akun Anda">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold text-slate-400 font-medium ml-1">Kode Pemulihan (Recovery Code)</label>
                            <input type="text" name="recovery_code" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-semibold " placeholder="ABCD-1234">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-4 rounded-lg shadow-xl transition-all active:scale-[0.98] text-sm font-medium mt-4">
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
                            <label class="text-[10px] font-semibold text-slate-400 font-medium ml-1">Username</label>
                            <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Username Anda">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold text-slate-400 font-medium ml-1">Pertanyaan Keamanan</label>
                            <select :name="isCustomQuestion ? 'select_security_question' : 'security_question'" @change="isCustomQuestion = ($event.target.value === 'custom')" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                                <option value="">Pilih pertanyaan Anda</option>
                                <option value="Apa nama hewan peliharaan pertama Anda?">Nama hewan peliharaan pertama?</option>
                                <option value="Nama sekolah dasar Anda?">Nama sekolah dasar Anda?</option>
                                <option value="Siapa nama guru favorit Anda?">Siapa nama guru favorit Anda?</option>
                                <option value="Di kota mana orang tua Anda bertemu?">Kota pertemuan orang tua?</option>
                                <option value="custom">Lainnya (Tulis Pertanyaan Kustom)</option>
                            </select>

                            <div x-show="isCustomQuestion" x-cloak class="mt-2 space-y-1">
                                <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Tulis Pertanyaan Keamanan Anda <span class="text-rose-500">*</span></label>
                                <input type="text" :name="isCustomQuestion ? 'security_question' : 'custom_security_question'" :required="isCustomQuestion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan pertanyaan kustom Anda">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold text-slate-400 font-medium ml-1">Jawaban</label>
                            <input type="text" name="security_answer" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Jawaban rahasia">
                        </div>
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Password Baru</label>
                                <div class="relative">
                                    <input :type="showPass ? 'text' : 'password'" name="new_password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-10 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" value="{{ old('new_password') }}">
                                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                        <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Konfirmasi</label>
                                <div class="relative">
                                    <input :type="showConf ? 'text' : 'password'" name="new_password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-10 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" value="{{ old('new_password_confirmation') }}">
                                    <button type="button" @click="showConf = !showConf" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                        <svg x-show="!showConf" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg x-show="showConf" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="px-1 text-[8px] text-slate-400 leading-normal">
                            * Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&).
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-4 rounded-lg shadow-xl shadow-primary/20 transition-all active:scale-[0.98] text-sm font-medium mt-4">
                        Reset & Masuk
                    </button>
                </form>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[10px] font-semibold text-slate-400 font-medium hover:text-primary transition">
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
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[10px] font-semibold  mb-12 ml-auto">
                Account Recovery
            </div>
            <h2 class="text-6xl font-semibold text-white leading-[1.1] mb-8">Pemulihan <br> Akses <span class="text-primary text-7xl italic">Mandiri.</span></h2>
            <div class="h-1.5 w-32 bg-primary mb-8 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-lg leading-relaxed mb-12 font-medium">Lupa kredensial masuk? Gunakan kode pemulihan atau pertanyaan keamanan Anda untuk kembali mengakses workspace.</p>
            
            <div class="flex items-center gap-4 justify-end">
                <div class="w-12 h-12 bg-white/5 rounded-lg flex items-center justify-center text-primary border border-white/10 italic font-semibold text-xl italic font-serif">?</div>
                <div class="text-left">
                    <p class="text-white text-xs font-medium leading-none">Butuh Bantuan?</p>
                    <p class="text-slate-500 text-[10px] font-bold mt-1 uppercase tracking-tight">Hubungi Admin Sekolah</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
