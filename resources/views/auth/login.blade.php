@extends('layouts.app')

@section('title', 'Masuk ke Workspace - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 flex flex-col md:flex-row overflow-hidden bg-white">
    {{-- Left Column: Login Form & Guest Options --}}
    <div class="w-full md:w-[45%] flex items-center justify-center p-8 md:p-12 overflow-y-auto custom-scrollbar bg-white">
        <div class="w-full max-w-sm">
            {{-- Branding for Mobile --}}
            <div class="mb-8 md:hidden text-center">
                <h1 class="text-3xl font-black text-slate-900 leading-none">SIMBEKA.</h1>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-2">Sistem Informasi Manajemen BK</p>
            </div>

            <div class="mb-10 hidden md:block">
                <h1 class="text-4xl font-black text-slate-900 mb-2 leading-tight">Masuk <br> Ke Workspace.</h1>
                <p class="text-slate-500 font-medium">Pilih metode akses Anda di bawah ini.</p>
            </div>

            {{-- Guest Access Section (RESTORED) --}}
            <div class="mb-10 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 text-center">Akses Cepat (Tanpa Akun)</h4>
                <div class="grid grid-cols-2 gap-3">
                    <form action="{{ route('guest.login') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex flex-col items-center gap-2 p-4 bg-white border border-slate-200 rounded-2xl hover:border-primary hover:shadow-lg hover:shadow-primary/5 transition-all group">
                            <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-tight text-slate-600">Lapor Anonim</span>
                        </button>
                    </form>
                    <form action="{{ route('guest.login') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex flex-col items-center gap-2 p-4 bg-white border border-slate-200 rounded-2xl hover:border-primary hover:shadow-lg hover:shadow-primary/5 transition-all group">
                            <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-tight text-slate-600">Konsul Cepat</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="relative flex items-center justify-center mb-10">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                <span class="relative px-4 bg-white text-[10px] font-black text-slate-400 uppercase tracking-widest">Atau Masuk Akun</span>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Username / Email</label>
                    <input type="text" name="login" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan ID Anda" value="{{ old('login') }}">
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                        <a href="{{ route('password.request') }}" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between gap-3 px-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/20">
                        <label for="remember" class="text-[10px] font-bold text-slate-400 uppercase tracking-tight cursor-pointer">Ingat Sesi</label>
                    </div>
                    {{-- Recovery Code Link (RESTORED) --}}
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-amber-600 uppercase tracking-widest flex items-center gap-1 hover:underline">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Pakai Recovery Code
                    </a>
                </div>

                <div class="pt-4 space-y-6 text-center">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 rounded-xl shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-sm uppercase tracking-widest">
                        Masuk Sekarang
                    </button>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-primary hover:underline">Daftar Di Sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Column: Branding --}}
    <div class="hidden md:flex md:w-[55%] bg-slate-900 relative items-center justify-center p-20 overflow-hidden text-right">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] bg-primary/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[60%] h-[60%] bg-accent/10 rounded-full blur-[120px]"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[10px] font-black uppercase tracking-[0.2em] mb-12 ml-auto">
                Official SIMBEKA Platform
            </div>
            <h2 class="text-6xl font-black text-white leading-[1.1] mb-8">Manajemen <br> Bimbingan & <br> <span class="text-primary text-7xl italic">Konseling.</span></h2>
            <div class="h-1.5 w-32 bg-primary mb-8 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-lg leading-relaxed mb-12 font-medium">Sistem informasi bimbingan konseling terpadu yang memprioritaskan privasi dan kemudahan akses siswa.</p>
            
            <div class="flex items-center gap-12 justify-end">
                <div>
                    <span class="block text-3xl font-black text-white">500+</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Siswa Aktif</span>
                </div>
                <div class="w-px h-10 bg-white/10"></div>
                <div>
                    <span class="block text-3xl font-black text-white">100%</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Privasi Aman</span>
                </div>
            </div>
        </div>
        
        <a href="/" class="absolute top-10 left-10 flex items-center gap-2 text-white/40 hover:text-white transition-colors text-[10px] font-black uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Beranda
        </a>
    </div>
</div>
@endsection
