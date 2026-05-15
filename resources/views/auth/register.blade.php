@extends('layouts.app')
@section('title', 'Daftar Akun Baru')

@section('content')
<div class="fixed inset-0 z-[-1] overflow-hidden">
    <div class="absolute inset-0 bg-slate-900/60 z-10 backdrop-blur-sm"></div>
    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover" alt="Background">
</div>

<div class="min-h-[90vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-5xl w-full flex flex-col md:flex-row items-center gap-12">
        {{-- Left: Greeting --}}
        <div class="flex-1 text-white space-y-6">
            <a href="/" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>
            <div class="space-y-2">
                <h2 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
                    Gabung <br>
                    <span class="text-blue-400">Bersama Kami</span>
                </h2>
                <p class="text-lg text-slate-300 font-medium max-w-sm leading-relaxed">
                    Buat akun untuk mulai mengakses layanan bimbingan konseling terbaik kami.
                </p>
            </div>
            <div class="flex items-center gap-4 pt-4">
                <div class="flex -space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-200"></div>
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-300"></div>
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-400"></div>
                </div>
                <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">+500 Siswa Terdaftar</p>
            </div>
        </div>

        {{-- Right: Register Form --}}
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-blue-600 p-8 text-white text-center">
                    <h3 class="text-xl font-bold">Pendaftaran Siswa</h3>
                    <p class="text-blue-100 text-xs mt-1 font-medium tracking-wide opacity-80 uppercase">Lengkapi Data Diri Anda</p>
                </div>
                
                <div class="p-8 space-y-6">
                    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Username</label>
                            <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition" placeholder="Username unik Anda">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Password</label>
                            <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition" placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition" placeholder="••••••••">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-600/20 transition-all hover:scale-[1.02] active:scale-[0.98] mt-2">
                            Daftar Sekarang
                        </button>
                    </form>

                    <div class="pt-4 text-center">
                        <p class="text-sm text-slate-500 font-medium">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
