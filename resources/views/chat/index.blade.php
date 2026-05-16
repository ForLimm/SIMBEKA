@extends('layouts.app')
@section('title', 'Live Konsultasi - SIMBEKA')

@section('content')
<div class="fixed inset-0 lg:ml-64 bg-slate-50 flex flex-col z-[45]" x-data="chatApp()" x-init="startPolling()">
    {{-- Chat Header --}}
    <div class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0 shadow-sm z-10">
        <div class="flex items-center gap-5">
            {{-- Improved Back Button --}}
            @if(auth()->user()->role === 'guru_bk')
                <a href="{{ route('gurubk.report.show', $report->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali</span>
                </a>
            @else
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali</span>
                </a>
            @endif
            <div class="h-10 w-px bg-slate-200 mx-1"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-primary/20 text-lg">
                    {{ substr($report->reporter->name ?? 'S', 0, 1) }}
                </div>
                <div>
                    <h3 class="font-black text-slate-800 tracking-tight text-lg leading-tight">
                        {{ auth()->user()->role === 'guru_bk' ? ($report->reporter->name ?? 'Siswa') : 'Guru BK' }}
                    </h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sesi Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-6">
            <div class="text-right">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Topik</div>
                <div class="text-sm font-bold text-slate-700 truncate max-w-[200px]">{{ $report->title }}</div>
            </div>
            <div class="px-4 py-2 bg-amber-50 border border-amber-100 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Self-Destruct</span>
            </div>
        </div>
    </div>

    {{-- Chat Body --}}
    <div class="flex-1 overflow-y-auto px-6 md:px-12 py-10 space-y-8 bg-[#f0f2f5] custom-scrollbar pattern-bg" id="chat-messages" x-ref="chatContainer">
        {{-- Notice --}}
        <div class="max-w-2xl mx-auto mb-10">
            <div class="bg-amber-50/80 backdrop-blur border border-amber-200/50 p-6 rounded-[2rem] flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 bg-amber-100 rounded-2xl flex items-center justify-center shrink-0 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-black text-amber-900 uppercase tracking-tight">Mode Self-Destruct Aktif</h4>
                    <p class="text-xs text-amber-700 font-medium leading-relaxed mt-1">Seluruh riwayat percakapan ini akan otomatis terhapus selamanya begitu Guru BK menekan tombol <strong>"Selesaikan Kasus"</strong>.</p>
                </div>
            </div>
        </div>

        <template x-if="messages.length === 0">
            <div class="flex flex-col items-center justify-center h-full space-y-4 opacity-30">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-inner">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <div class="text-center">
                    <p class="font-black uppercase tracking-[0.3em] text-sm text-slate-800">Mulai Chat</p>
                </div>
            </div>
        </template>

        <template x-for="msg in messages" :key="msg.id">
            <div class="flex" :class="msg.is_mine ? 'justify-end' : 'justify-start'">
                <div class="max-w-[85%] md:max-w-[65%] group relative">
                    <template x-if="!msg.is_mine">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-4" x-text="msg.sender_name"></span>
                    </template>

                    <div class="relative px-6 py-4 shadow-md break-words overflow-hidden" :class="msg.is_mine 
                        ? 'bg-primary text-white rounded-[1.8rem] rounded-tr-none' 
                        : 'bg-white text-slate-700 rounded-[1.8rem] rounded-tl-none border border-white'">
                        
                        <p class="text-sm font-medium leading-relaxed whitespace-pre-wrap break-words" x-text="msg.message"></p>
                        
                        <div class="mt-2 flex items-center gap-2" :class="msg.is_mine ? 'justify-end' : 'justify-start'">
                            <span class="text-[9px] font-bold opacity-50 uppercase tracking-widest" x-text="msg.time"></span>
                            <template x-if="msg.is_mine">
                                <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Chat Input --}}
    <div class="p-6 md:p-8 bg-white border-t border-slate-200 shrink-0">
        @if($report->status !== 'resolved')
        <form action="{{ route('chat.send', $report->id) }}" method="POST" class="max-w-5xl mx-auto flex gap-5 items-end" @submit="scrollToBottom()">
            @csrf
            <div class="flex-1 relative">
                <textarea name="message" required autocomplete="off" rows="1"
                    x-on:input="$el.style.height = '56px'; $el.style.height = $el.scrollHeight + 'px'"
                    class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-8 py-4 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all placeholder:text-slate-400 font-medium shadow-inner resize-none overflow-hidden max-h-40" 
                    placeholder="Tulis pesan Anda di sini..."
                    style="height: 56px;"></textarea>
            </div>
            <button type="submit" class="bg-primary hover:bg-secondary text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl shadow-primary/30 transition-all hover:scale-110 active:scale-95 group shrink-0 mb-0.5">
                <svg class="w-6 h-6 rotate-45 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
        @else
        <div class="max-w-2xl mx-auto text-center py-4 px-8 bg-slate-100 rounded-2xl border border-slate-200">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Sesi Konsultasi Telah Selesai & Diarsipkan</p>
        </div>
        @endif
    </div>
</div>

<style>
    .pattern-bg {
        background-color: #f0f2f5;
        background-image: url("https://www.transparenttextures.com/patterns/cubes.png");
    }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<script>
function chatApp() {
    return {
        messages: @json($chatMessages),
        polling: null,

        startPolling() {
            this.scrollToBottom();
            this.polling = setInterval(() => this.fetchMessages(), 3000);
        },

        async fetchMessages() {
            try {
                const res = await fetch('{{ route("chat.poll", $report->id) }}');
                const data = await res.json();
                const wasAtBottom = this.isAtBottom();
                this.messages = data.messages;
                if (wasAtBottom) {
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch(e) {
                console.error('Poll error:', e);
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.chatContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        isAtBottom() {
            const container = this.$refs.chatContainer;
            if (!container) return true;
            return container.scrollHeight - container.scrollTop - container.clientHeight < 50;
        }
    }
}
</script>
@endsection
