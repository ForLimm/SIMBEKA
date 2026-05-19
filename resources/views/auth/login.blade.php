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
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-1 leading-tight tracking-tight">Masuk Ke Workspace</h1>
                <p class="text-slate-400 text-xs font-semibold">Pilih metode akses Anda di bawah ini.</p>
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

            {{-- Guest Access Section (COMPACT & HORIZONTAL) --}}
            <div class="mb-6 p-4 bg-slate-50 rounded-2xl border border-slate-100/80">
                <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Akses Cepat (Tanpa Akun)</h4>
                <div class="grid grid-cols-2 gap-3">
                    <form action="{{ route('guest.login') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl hover:border-primary hover:shadow-md hover:shadow-primary/5 transition-all group">
                            <div class="w-8 h-8 bg-rose-50 text-rose-500 rounded-lg flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-colors shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-wider text-slate-600 text-left leading-none">Lapor Anonim</span>
                        </button>
                    </form>
                    <form action="{{ route('guest.login') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl hover:border-primary hover:shadow-md hover:shadow-primary/5 transition-all group">
                            <div class="w-8 h-8 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-wider text-slate-600 text-left leading-none">Konsul Cepat</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="relative flex items-center justify-center mb-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                <span class="relative px-3.5 bg-white text-[9px] font-black text-slate-400 uppercase tracking-widest">Atau Masuk Akun</span>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-3.5">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Username / Email</label>
                    <input type="text" name="login" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan ID Anda" value="{{ old('login') }}">
                </div>

                <div class="space-y-1">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                        <a href="{{ route('password.request') }}" class="text-[8px] font-black text-primary uppercase tracking-widest hover:underline">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between gap-3 px-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/20">
                        <label for="remember" class="text-[9px] font-bold text-slate-400 uppercase tracking-tight cursor-pointer">Ingat Sesi</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-[9px] font-black text-amber-600 uppercase tracking-widest flex items-center gap-1 hover:underline">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Pakai Recovery Code
                    </a>
                </div>

                <div class="pt-2 space-y-4 text-center">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-3 rounded-xl shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-xs uppercase tracking-widest">
                        Masuk Sekarang
                    </button>
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest">
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
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[9px] font-black uppercase tracking-[0.2em] mb-8 ml-auto">
                Official SIMBEKA Platform
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">Manajemen Bimbingan & <span class="text-primary italic block mt-1">Konseling.</span></h2>
            <div class="h-1 w-24 bg-primary mb-6 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-sm leading-relaxed mb-8 font-medium">Sistem informasi bimbingan konseling terpadu yang memprioritaskan privasi dan kemudahan akses siswa.</p>
            
            <div class="flex items-center gap-10 justify-end">
                <div>
                    <span class="block text-2xl font-black text-white">500+</span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Siswa Aktif</span>
                </div>
                <div class="w-px h-8 bg-white/10"></div>
                <div>
                    <span class="block text-2xl font-black text-white">100%</span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Privasi Aman</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
