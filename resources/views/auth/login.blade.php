@extends('layouts.app')

@section('title', 'Masuk ke Workspace - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 flex flex-col md:flex-row overflow-hidden bg-white">
    {{-- Left Column: Login Form & Guest Options --}}
    <div class="w-full md:w-[45%] flex items-center justify-center p-6 md:p-10 overflow-y-auto custom-scrollbar bg-white">
        <div class="w-full max-w-sm">
            {{-- Branding Logo --}}
            <div class="mb-8 flex justify-center md:justify-start">
                <a href="{{ url('/') }}" class="block">
                    <img src="{{ asset('assets/images/logo_simbeka_teks.svg') }}" alt="Logo SIMBEKA" class="h-18 w-auto object-contain brightness-0">
                </a>
            </div>

            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-semibold text-slate-900 mb-1 leading-tight tracking-tight">Masuk Ke Workspace</h1>
                <p class="text-slate-400 text-xs font-semibold">Pilih metode akses Anda di bawah ini.</p>
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

            {{-- Guest Access Section (COMPACT & HORIZONTAL) --}}
            <div class="mb-6 p-4 bg-slate-50 rounded-lg border border-slate-100/80">
                <form action="{{ route('guest.login') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 p-3 bg-white border border-slate-200 rounded-lg hover:border-primary hover:shadow-md hover:shadow-primary/5 transition-all group">
                        <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </div>
                        <div class="text-left">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 leading-tight">Masuk sebagai Guest</span>
                            <span class="block text-[8px] font-medium text-slate-400">Lapor Anonim / Konsul Cepat</span>
                        </div>
                    </button>
                </form>
            </div>

            <div class="relative flex items-center justify-center mb-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                <span class="relative px-3.5 bg-white text-[9px] font-semibold text-slate-400 font-medium">Atau Masuk Akun</span>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-3.5">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Username / Email</label>
                    <input type="text" name="login" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan ID Anda" value="{{ old('login') }}">
                </div>

                <div class="space-y-1">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[9px] font-semibold text-slate-400 font-medium">Password</label>
                        <a href="{{ route('password.request') }}" class="text-[8px] font-semibold text-primary font-medium hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" value="{{ old('password') }}">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 px-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/20">
                        <label for="remember" class="text-[9px] font-bold text-slate-400 uppercase tracking-tight cursor-pointer">Ingat Sesi</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-[9px] font-semibold text-amber-600 font-medium flex items-center gap-1 hover:underline">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Pakai Recovery Code
                    </a>
                </div>

                <div class="pt-2 space-y-4 text-center">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3 rounded-lg shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-xs font-medium">
                        Masuk Sekarang
                    </button>
                    <p class="text-slate-400 text-[9px] font-bold font-medium">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-primary hover:underline">Daftar Di Sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Column: Branding --}}
    <div class="hidden md:flex md:w-[55%] bg-slate-900 relative items-center justify-center p-16 overflow-hidden text-right">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] bg-primary/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[60%] h-[60%] bg-accent/10 rounded-full blur-[120px]"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[9px] font-semibold  mb-8 ml-auto">
                Selamat Datang!
            </div>
            <h2 class="text-4xl md:text-5xl font-semibold text-white leading-tight mb-6">Sistem Informasi Manajemen <span class="text-primary italic block mt-1">Bimbingan & Konseling</span></h2>
            <div class="h-1 w-24 bg-primary mb-6 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-sm leading-relaxed mb-8 font-medium">Sistem Informasi yang memprioritaskan privasi dan kemudahan akses siswa.</p>
            
            <div class="flex items-center gap-10 justify-end">
                <div>
                    <span class="block text-2xl font-semibold text-white">500+</span>
                    <span class="text-[9px] font-semibold text-slate-500 font-medium">Siswa Aktif</span>
                </div>
                <div class="w-px h-8 bg-white/10"></div>
                <div>
                    <span class="block text-2xl font-semibold text-white">100%</span>
                    <span class="text-[9px] font-semibold text-slate-500 font-medium">Privasi Aman</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
