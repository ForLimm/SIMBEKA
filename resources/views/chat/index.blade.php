@extends('layouts.app')
@section('title', 'Chat Konsultasi - SIMBEKA')

@section('content')
<div class="max-w-3xl mx-auto" x-data="chatApp()" x-init="startPolling()">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            @if(auth()->user()->role === 'guru_bk')
                <a href="{{ route('gurubk.report.show', $report->id) }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke Detail Kasus</a>
            @else
                <a href="{{ route('siswa.dashboard') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
            @endif
            <h2 class="text-xl font-bold text-gray-800 mt-1">Chat Konsultasi</h2>
            <p class="text-xs text-gray-400 mt-0.5">Topik: {{ $report->title }}</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-1.5">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                </span>
                <span class="text-xs text-gray-500">Live</span>
            </div>
            <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full font-medium flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m9.374-9.373a3 3 0 010 4.243L12 19.243l-7.374-7.373a3 3 0 010-4.243 3 3 0 014.243 0L12 10.87l3.131-3.243a3 3 0 014.243 0z"></path></svg>
                Self-Destruct
            </span>
        </div>
    </div>

    {{-- Self-destruct notice --}}
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4 flex items-start gap-2">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="text-sm font-medium text-amber-800">Mode Self-Destruct Aktif</p>
            <p class="text-xs text-amber-600 mt-0.5">Seluruh riwayat chat ini akan otomatis terhapus selamanya begitu Guru BK menekan tombol <strong>"Selesaikan Kasus"</strong>.</p>
        </div>
    </div>

    {{-- Chat Box --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col" style="height: 480px;">
        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3" id="chat-messages" x-ref="chatContainer">
            <template x-if="messages.length === 0">
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <p class="text-sm text-gray-400">Belum ada pesan. Mulai percakapan!</p>
                    </div>
                </div>
            </template>

            <template x-for="msg in messages" :key="msg.id">
                <div :class="msg.is_mine ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.is_mine 
                            ? 'bg-blue-600 text-white rounded-2xl rounded-br-md max-w-xs lg:max-w-md px-4 py-2.5 shadow-sm' 
                            : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md max-w-xs lg:max-w-md px-4 py-2.5 shadow-sm'">
                        <p class="text-xs font-semibold mb-1" :class="msg.is_mine ? 'text-blue-200' : 'text-gray-500'" x-text="msg.sender_name"></p>
                        <p class="text-sm leading-relaxed whitespace-pre-line" x-text="msg.message"></p>
                        <div class="flex items-center gap-1 mt-1" :class="msg.is_mine ? 'justify-end' : 'justify-start'">
                            <span class="text-xs opacity-60" x-text="msg.time"></span>
                            <template x-if="msg.is_mine">
                                <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"></path></svg>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Input Area --}}
        @if($report->status !== 'resolved')
        <div class="border-t border-gray-200 p-3 bg-gray-50">
            <form action="{{ route('chat.send', $report->id) }}" method="POST" class="flex gap-2" @submit="scrollToBottom()">
                @csrf
                <input 
                    type="text" 
                    name="message" 
                    placeholder="Ketik pesan..." 
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    required
                    autocomplete="off"
                >
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full px-5 py-2 text-sm font-medium transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim
                </button>
            </form>
        </div>
        @else
        <div class="border-t border-gray-200 p-4 bg-gray-50 text-center">
            <p class="text-sm text-gray-500">Kasus ini telah diselesaikan. Chat tidak lagi aktif.</p>
        </div>
        @endif
    </div>
</div>

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
        },

        destroy() {
            if (this.polling) clearInterval(this.polling);
        }
    }
}
</script>
@endsection
