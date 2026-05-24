@extends('layouts.app')

@section('title', 'Daftar Akun Siswa - Sistem Informasi Manajemen Bimbingan & Konseling')

@section('content')
<div class="fixed inset-0 flex flex-col md:flex-row overflow-hidden bg-white">
    {{-- Left Column: Register Form --}}
    <div class="w-full md:w-[45%] flex items-center justify-center p-6 md:p-10 overflow-y-auto custom-scrollbar bg-white">
        <div class="w-full max-w-sm">
            {{-- Branding Logo --}}
            <div class="mb-8 flex justify-center md:justify-start">
                <a href="{{ url('/') }}" class="block">
                    <img src="{{ asset('assets/images/logo_simbeka_teks.svg') }}" alt="Logo SIMBEKA" class="h-18 w-auto object-contain brightness-0">
                </a>
            </div>

            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-semibold text-slate-900 mb-1 leading-tight tracking-tight">Registrasi Akun Baru</h1>
                <p class="text-slate-400 text-xs font-semibold">Buat akun untuk mulai menggunakan layanan BK.</p>
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

            <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Username Untuk Login <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Contoh: siswa123" value="{{ old('username') }}">
                </div>

                <div class="grid grid-cols-2 gap-4" x-data="{ showPass: false, showConf: false }">
                    <div class="space-y-1">
                        <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Password <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" value="{{ old('password') }}">
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
                    <div class="space-y-1">
                        <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Konfirmasi <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="••••••••" value="{{ old('password_confirmation') }}">
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

                <div class="space-y-1 pt-1" x-data="{ isCustomQuestion: false }">
                    <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Pertanyaan Keamanan (Pemulihan) <span class="text-rose-500">*</span></label>
                    <select :name="isCustomQuestion ? 'select_security_question' : 'security_question'" @change="isCustomQuestion = ($event.target.value === 'custom')" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition appearance-none font-medium">
                        <option value="" disabled selected>Pilih pertanyaan rahasia</option>
                        <option value="Apa nama hewan peliharaan pertama Anda?">Apa nama hewan peliharaan pertama Anda?</option>
                        <option value="Nama sekolah dasar Anda?">Nama sekolah dasar Anda?</option>
                        <option value="Siapa nama guru favorit Anda?">Siapa nama guru favorit Anda?</option>
                        <option value="Di kota mana orang tua Anda bertemu?">Di kota mana orang tua Anda bertemu?</option>
                        <option value="custom">Lainnya (Buat Pertanyaan Sendiri)</option>
                    </select>

                    <div x-show="isCustomQuestion" x-cloak class="mt-2 space-y-1">
                        <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Tulis Pertanyaan Keamanan Anda <span class="text-rose-500">*</span></label>
                        <input type="text" :name="isCustomQuestion ? 'security_question' : 'custom_security_question'" :required="isCustomQuestion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Contoh: Siapa nama sahabat kecil Anda?">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-semibold text-slate-400 font-medium ml-1">Jawaban Anda <span class="text-rose-500">*</span></label>
                    <input type="text" name="security_answer" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Jawaban rahasia Anda">
                </div>

                <div class="pt-2 space-y-4 text-center">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3 rounded-lg shadow-xl transition-all hover:scale-[1.01] active:scale-[0.98] text-xs font-medium">
                        Daftar Akun Baru
                    </button>
                    <p class="text-slate-400 text-[9px] font-bold font-medium">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-primary hover:underline font-semibold">Masuk Workspace</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Column: Branding --}}
    <div class="hidden md:flex md:w-[55%] bg-slate-900 relative items-center justify-center p-16 overflow-hidden text-right">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] bg-primary/20 rounded-full blur-[120px]"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-white/50 text-[9px] font-semibold  mb-8 ml-auto">
                Hai, Kamu..
            </div>
            <h2 class="text-4xl md:text-5xl font-semibold text-white leading-tight mb-6">Data Kamu Selalu <span class="text-primary italic block mt-1">Anonim.</span></h2>
            <div class="h-1 w-24 bg-primary mb-6 rounded-full ml-auto"></div>
            <p class="text-slate-400 text-sm leading-relaxed mb-8 font-medium">Seluruh proses pendaftaran dirancang untuk melindungi identitas Anda. Username Anda adalah satu-satunya identitas yang diperlukan.</p>
            
            <div class="grid grid-cols-2 gap-6 text-right">
                <div class="p-3 bg-white/5 rounded-lg border border-white/5">
                    <h4 class="text-white font-semibold text-[10px] font-medium mb-1">Anonimitas</h4>
                    <p class="text-slate-500 text-[9px] leading-relaxed">Sistem tidak meminta data sensitif seperti email atau no HP.</p>
                </div>
                <div class="p-3 bg-white/5 rounded-lg border border-white/5">
                    <h4 class="text-white font-semibold text-[10px] font-medium mb-1">Keamanan</h4>
                    <p class="text-slate-500 text-[9px] leading-relaxed">Gunakan pertanyaan keamanan untuk memulihkan akun Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
