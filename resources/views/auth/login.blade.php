@extends('layouts.app')
@section('title', 'Masuk ke SIMBEKA')

@section('content')
<div class="fixed inset-0 z-[-1] overflow-hidden">
    <div class="absolute inset-0 bg-slate-900/60 z-10 backdrop-blur-sm"></div>
    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover" alt="Background">
</div>

<div class="min-h-[85vh] flex items-center justify-center px-4">
    <div class="max-w-5xl w-full flex flex-col md:flex-row items-center gap-12 py-12">
        {{-- Left: Greeting --}}
        <div class="flex-1 text-white space-y-6">
            <a href="/" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>
            <div class="space-y-2">
                <h2 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
                    Halo 👋 <br>
                    <span class="text-blue-400">Selamat Datang!</span>
                </h2>
                <p class="text-lg text-slate-300 font-medium max-w-sm leading-relaxed">
                    Masuk untuk mengakses layanan bimbingan konseling Anda secara profesional.
                </p>
            </div>
        </div>

        {{-- Right: Login Form --}}
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-blue-600 p-8 text-white text-center">
                    <h3 class="text-xl font-bold">Silahkan Masuk</h3>
                    <p class="text-blue-100 text-xs mt-1 font-medium tracking-wide opacity-80 uppercase">Akses Akun SIMBEKA</p>
                </div>
                
                <div class="p-8 space-y-6">
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Username / Email</label>
                            <input type="text" name="login" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition" placeholder="Masukkan identitas Anda">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Password</label>
                            <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition" placeholder="••••••••">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-600/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Masuk Ke Akun
                        </button>
                    </form>

                    <div class="relative flex items-center justify-center py-2">
                        <div class="border-t border-slate-100 w-full"></div>
                        <span class="bg-white px-4 text-xs font-bold text-slate-400 uppercase tracking-widest absolute">Atau</span>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <form action="{{ route('guest.login') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold py-4 rounded-2xl border border-slate-200 transition text-sm flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Masuk Sebagai Tamu
                            </button>
                        </form>
                        <p class="text-center text-sm text-slate-500">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
