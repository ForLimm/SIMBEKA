@extends('layouts.app')
@section('title', 'Konsultasi Live')

@section('content')
<div class="fixed inset-0 lg:ml-72 bg-slate-50 flex flex-col z-[45]">
    {{-- Top Navigation / Header --}}
    <div class="h-16 md:h-20 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 shrink-0 shadow-sm z-10">
        <div class="flex items-center gap-3 md:gap-5 min-w-0">
            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center w-9 h-9 md:w-auto md:h-auto md:px-5 md:py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition shadow-sm group shrink-0">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden md:inline ml-2">Kembali</span>
            </a>
            <div class="h-8 w-px bg-slate-200 mx-0.5 hidden md:block"></div>
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 md:w-12 md:h-12 bg-blue-600 text-white rounded-xl md:rounded-2xl flex items-center justify-center font-black shadow-lg shadow-blue-600/20 text-sm md:text-lg shrink-0">
                    {{ substr($other_user->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-slate-800 tracking-tight text-sm md:text-lg leading-tight truncate">{{ $other_user->name }}</h3>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="relative flex h-1.5 w-1.5 shrink-0">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-[8px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate">Live</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-6">
            <div class="text-right">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Topik Konsultasi</div>
                <div class="text-sm font-bold text-slate-700 truncate max-w-[200px]">{{ $report->title }}</div>
            </div>
        </div>
    </div>

    {{-- Chat Body --}}
    <div class="flex-1 overflow-y-auto px-4 md:px-12 py-6 md:py-10 space-y-6 md:space-y-8 bg-[#f0f2f5] custom-scrollbar pattern-bg" id="chat-messages">
        {{-- Mode Self-Destruct Alert --}}
        <div class="max-w-2xl mx-auto mb-6 md:mb-10">
            <div class="bg-amber-50/80 backdrop-blur border border-amber-200/50 p-4 md:p-6 rounded-2xl md:rounded-[2rem] flex items-start gap-3 md:gap-4 shadow-sm">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-amber-100 rounded-xl md:rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs md:text-sm font-black text-amber-900 uppercase tracking-tight">Mode Self-Destruct Aktif</h4>
                    <p class="text-[10px] md:text-xs text-amber-700 font-medium leading-relaxed mt-1">Seluruh riwayat percakapan ini bersifat rahasia dan akan dihapus secara permanen setelah kasus dinyatakan selesai oleh Guru BK.</p>
                </div>
            </div>
        </div>

        @forelse($messages as $message)
            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[85%] md:max-w-[65%] group relative">
                    {{-- Sender Name (Other) --}}
                    @if($message->sender_id !== auth()->id())
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-3">{{ $other_user->name }}</span>
                    @endif

                    <div class="relative px-4 py-3 md:px-6 md:py-4 shadow-md {{ $message->sender_id === auth()->id() 
                        ? 'bg-blue-600 text-white rounded-2xl rounded-tr-none md:rounded-[1.8rem] md:rounded-tr-none' 
                        : 'bg-white text-slate-700 rounded-2xl rounded-tl-none md:rounded-[1.8rem] md:rounded-tl-none border border-white' }}">
                        
                        <p class="text-sm font-medium leading-relaxed">{{ $message->message }}</p>
                        
                        <div class="mt-2 flex items-center gap-1.5 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <span class="text-[8px] md:text-[9px] font-bold opacity-50 uppercase tracking-widest">{{ $message->created_at->format('H:i') }}</span>
                            @if($message->sender_id === auth()->id())
                                <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-full space-y-4 opacity-30">
                <div class="w-16 h-16 md:w-24 md:h-24 bg-white rounded-full flex items-center justify-center shadow-inner">
                    <svg class="w-8 h-8 md:w-12 md:h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <div class="text-center">
                    <p class="font-black uppercase tracking-[0.3em] text-xs md:text-sm text-slate-800">Mulai Chat</p>
                    <p class="text-[8px] md:text-[10px] font-bold mt-1 uppercase tracking-widest text-slate-500">Sampaikan keluhan atau pertanyaan Anda</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Chat Input --}}
    <div class="p-4 md:p-8 bg-white border-t border-slate-200 shrink-0">
        <form action="{{ route('chat.send', $report->id) }}" method="POST" class="max-w-5xl mx-auto flex gap-3 md:gap-5 items-center">
            @csrf
            <div class="flex-1 relative">
                <input type="text" name="message" required autocomplete="off" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-full px-6 py-4 md:px-8 md:py-5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 font-medium shadow-inner" 
                    placeholder="Tulis pesan Anda di sini...">
                <div class="absolute right-4 md:right-6 top-1/2 -translate-y-1/2 flex items-center gap-2 md:gap-3 text-slate-300">
                    <button type="button" class="hover:text-blue-500 transition-colors p-1 shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                    <button type="button" class="hover:text-blue-500 transition-colors p-1 shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    </button>
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center shadow-2xl shadow-blue-600/30 transition-all hover:scale-105 active:scale-95 group shrink-0">
                <svg class="w-5 h-5 md:w-7 md:h-7 rotate-45 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
    </div>
</div>

<style>
    .pattern-bg {
        background-color: #f0f2f5;
        background-image: url("https://www.transparenttextures.com/patterns/cubes.png");
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 20px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    [x-cloak] { display: none !important; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chat-messages');
        chatContainer.scrollTop = chatContainer.scrollHeight;
        
        // Auto-scroll on new message (simplified for now)
        const observer = new MutationObserver(() => {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
        observer.observe(chatContainer, { childList: true });
    });
</script>
@endsection
