@extends('layouts.app')
@section('title', 'Pengaturan Akun - Sistem Informasi Manajemen Bimbingan & Konseling')
@section('title_display', 'Pengaturan Akun')

@section('content')
<div class="w-full space-y-4">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Pengaturan Akun</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Ubah Kata Sandi & Manajemen Keamanan Akun</p>
        </div>
    </div>
    <form action="{{ route('profile.password.update') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-6"
          x-data="{
              password: '',
              get hasMinLength() { return this.password.length >= 8; },
              get hasLowercase() { return /[a-z]/.test(this.password); },
              get hasUppercase() { return /[A-Z]/.test(this.password); },
              get hasNumber() { return /[0-9]/.test(this.password); },
              get hasSpecial() { return /[@$!%*?&]/.test(this.password); },
              get score() {
                  let s = 0;
                  if (this.hasMinLength) s++;
                  if (this.hasLowercase) s++;
                  if (this.hasUppercase) s++;
                  if (this.hasNumber) s++;
                  if (this.hasSpecial) s++;
                  return s;
              },
              get strengthText() {
                  if (this.password.length === 0) return 'Belum Diisi';
                  if (this.score <= 2) return 'Sangat Lemah';
                  if (this.score === 3) return 'Sedang';
                  if (this.score === 4) return 'Kuat';
                  return 'Sangat Kuat';
              },
              get strengthColorClass() {
                  if (this.password.length === 0) return 'bg-slate-200';
                  if (this.score <= 2) return 'bg-rose-500';
                  if (this.score === 3) return 'bg-amber-500';
                  if (this.score === 4) return 'bg-blue-500';
                  return 'bg-emerald-500';
              },
              get strengthTextColorClass() {
                  if (this.password.length === 0) return 'text-slate-400';
                  if (this.score <= 2) return 'text-rose-500';
                  if (this.score === 3) return 'text-amber-500';
                  if (this.score === 4) return 'text-blue-500';
                  return 'text-emerald-500';
              }
          }">
        @csrf
        
        {{-- Left: Ubah Kata Sandi (8/12) --}}
        <div class="xl:col-span-8 space-y-4">
            <div class="card-premium overflow-hidden bg-white">
                <div class="bg-slate-50 px-8 py-4 border-b border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Formulir Pengubahan Sandi</h3>
                </div>
                
                <div class="p-8 space-y-5">
                    <div>
                        @if(auth()->user()->is_guest)
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Kata Sandi Saat Ini / Kode Pemulihan <span class="text-rose-500">*</span></label>
                            <input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan kata sandi saat ini atau kode pemulihan">
                        @else
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Kata Sandi Saat Ini <span class="text-rose-500">*</span></label>
                            <input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan kata sandi saat ini">
                        @endif
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                        <input type="password" name="new_password" required x-model="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Masukkan kata sandi baru">
                        
                        {{-- Password Strength Meter --}}
                        <div class="mt-3 space-y-2.5">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kekuatan Sandi:</span>
                                <span class="text-[10px] font-black uppercase tracking-wider transition-colors" :class="strengthTextColorClass" x-text="strengthText"></span>
                            </div>
                            
                            {{-- Color segments --}}
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden flex gap-0.5">
                                <div class="h-full transition-all duration-300" :class="score >= 1 ? strengthColorClass : 'bg-slate-200'" :style="'width: ' + (password.length > 0 ? '20%' : '0%')"></div>
                                <div class="h-full transition-all duration-300" :class="score >= 2 ? strengthColorClass : 'bg-slate-200'" :style="'width: ' + (password.length > 0 ? '20%' : '0%')"></div>
                                <div class="h-full transition-all duration-300" :class="score >= 3 ? strengthColorClass : 'bg-slate-200'" :style="'width: ' + (password.length > 0 ? '20%' : '0%')"></div>
                                <div class="h-full transition-all duration-300" :class="score >= 4 ? strengthColorClass : 'bg-slate-200'" :style="'width: ' + (password.length > 0 ? '20%' : '0%')"></div>
                                <div class="h-full transition-all duration-300" :class="score >= 5 ? strengthColorClass : 'bg-slate-200'" :style="'width: ' + (password.length > 0 ? '20%' : '0%')"></div>
                            </div>
                            
                            {{-- Checklists --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-2 pt-1 border-t border-slate-50">
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 text-[10px] transition-colors" :class="hasMinLength ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500'">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <span class="text-[10px] font-bold transition-colors" :class="hasMinLength ? 'text-emerald-600' : 'text-slate-400'">Minimal 8 Karakter</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 text-[10px] transition-colors" :class="hasUppercase ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500'">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <span class="text-[10px] font-bold transition-colors" :class="hasUppercase ? 'text-emerald-600' : 'text-slate-400'">Huruf Besar (A-Z)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 text-[10px] transition-colors" :class="hasLowercase ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500'">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <span class="text-[10px] font-bold transition-colors" :class="hasLowercase ? 'text-emerald-600' : 'text-slate-400'">Huruf Kecil (a-z)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 text-[10px] transition-colors" :class="hasNumber ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500'">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <span class="text-[10px] font-bold transition-colors" :class="hasNumber ? 'text-emerald-600' : 'text-slate-400'">Angka (0-9)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 text-[10px] transition-colors" :class="hasSpecial ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500'">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <span class="text-[10px] font-bold transition-colors" :class="hasSpecial ? 'text-emerald-600' : 'text-slate-400'">Simbol (@$!%*?&)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                        <input type="password" name="new_password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition font-medium" placeholder="Ulangi kata sandi baru">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Submit & Security Card (4/12) --}}
        <div class="xl:col-span-4">
            <div class="card-premium bg-[#1e1e2d] border-none p-8 flex flex-col justify-center items-center text-center text-white relative overflow-hidden group">
                {{-- Decor --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-3xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-6 border border-white/10 group-hover:border-primary/50 transition-colors">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                
                <h4 class="text-xl font-black mb-2 relative z-10">Konfirmasi Sandi</h4>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-8 relative z-10">Pastikan sandi Anda sulit ditebak demi keamanan akun Anda.</p>
                
                <div class="w-full space-y-3 relative z-10">
                    <button type="submit" :disabled="score < 5" :class="score < 5 ? 'opacity-50 cursor-not-allowed bg-slate-700 text-slate-400' : 'bg-primary hover:bg-secondary text-white hover:scale-[1.02] active:scale-[0.95]'" class="w-full font-black py-4 rounded-2xl shadow-xl transition-all text-sm uppercase tracking-widest">
                        Simpan Sandi Baru
                    </button>
                    <button type="reset" @click="password = ''" class="w-full bg-white/5 hover:bg-white/10 text-slate-500 font-bold py-3 rounded-2xl transition text-[9px] uppercase tracking-[0.2em]">
                        Reset Formulir
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
