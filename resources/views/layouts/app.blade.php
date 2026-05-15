<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMBEKA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
        }
        [x-cloak] { display: none !important; }
        .sidebar-item-active {
            background-color: #eff6ff;
            color: #2563eb;
            border-right: 4px solid #2563eb;
        }
        .card-premium {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body class="text-slate-800 antialiased">

    @php
        $isGuestPage = request()->is('/') || 
                       request()->is('login') || 
                       request()->is('register') || 
                       request()->is('form*');
    @endphp

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @auth
            @if(!$isGuestPage)
                <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed h-full z-50">
                    <div class="p-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-blue-600/20">S</div>
                        <span class="font-bold text-xl tracking-tight text-slate-900">SIMBEKA</span>
                    </div>

                    <nav class="flex-1 mt-4 px-3 space-y-1">
                        @if(auth()->user()->role === 'siswa')
                            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('siswa.dashboard') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span class="font-medium text-sm">Dashboard</span>
                            </a>
                        @endif

                        @if(auth()->user()->role === 'guru_bk')
                            <a href="{{ route('gurubk.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('gurubk.dashboard') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span class="font-medium text-sm">Dashboard</span>
                            </a>
                            <a href="{{ route('gurubk.students.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('gurubk.students.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="font-medium text-sm">Data Siswa</span>
                            </a>
                            <a href="{{ route('gurubk.archives.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('gurubk.archives.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                <span class="font-medium text-sm">Arsip</span>
                            </a>
                        @endif
                    </nav>

                    <div class="p-4 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl w-full text-red-500 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span class="font-medium text-sm">Logout</span>
                            </button>
                        </form>
                    </div>
                </aside>
            @endif
        @endauth

        {{-- Main Content --}}
        <div class="flex-1 @auth @if(!$isGuestPage) ml-64 @endif @endauth flex flex-col min-w-0">
            {{-- Header --}}
            @auth
                @if(!$isGuestPage)
                    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
                        <h1 class="text-lg font-bold text-slate-900">@yield('title_display', 'Dashboard')</h1>
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-end">
                                <span class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] uppercase tracking-wider font-bold text-blue-600">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                            </div>
                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </header>
                @endif
            @endauth

            <main class="flex-1 @if(!$isGuestPage) p-8 @endif">
                {{-- Flash Messages --}}
                @if(session('success') || session('error') || $errors->any())
                <div class="max-w-4xl mx-auto mb-6 @if($isGuestPage) mt-4 px-4 @endif">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl">
                            <ul class="list-disc ml-5 text-sm font-medium">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
