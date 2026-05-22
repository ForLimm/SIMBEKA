<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SIMBEKA — Sistem Informasi Manajemen Bimbingan dan Konseling">
    <title>@yield('title', 'SIMBEKA - Sistem Informasi Manajemen Bimbingan & Konseling')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        secondary: '#1E40AF',
                        accent: '#10B981',
                        background: '#F8FAFC',
                        text: '#1E293B'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <style>
        body { 
            background-color: #F8FAFC;
            color: #1E293B;
        }
        [x-cloak] { display: none !important; }
        .sidebar-item-active {
            background: linear-gradient(135deg, #2563EB, #1E40AF);
            color: white !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        .sidebar-item-inactive {
            color: #9899ac;
        }
        .sidebar-item-inactive:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .bg-white border border-slate-200 rounded-lg shadow-sm {
            background: #FFFFFF;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #E2E8F0;
        }
    </style>
</head>
<body class="text-slate-800 antialiased" x-data="{ showLogoutModal: false, sidebarOpen: false }">

    @php
        $isGuestPage = request()->is('/') || 
                       request()->is('login') || 
                       request()->is('register');

        $dashboardUrl = '#';
        if (auth()->check()) {
            if (auth()->user()->role === 'siswa') {
                $dashboardUrl = route('siswa.dashboard');
            } elseif (auth()->user()->role === 'admin') {
                $dashboardUrl = route('admin.dashboard');
            } else {
                $dashboardUrl = route('gurubk.dashboard');
            }
        }
    @endphp

    <div class="flex min-h-screen">
        {{-- Sidebar Backdrop for Mobile --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        @auth
            @if(!$isGuestPage)
                <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="w-72 bg-[#1e1e2d] flex flex-col fixed h-full z-50 transition-all duration-300 ease-in-out transform lg:translate-x-0">
                    {{-- Logo Section --}}
                    <div class="py-6 px-4 flex items-center justify-center">
                        <a href="{{ $dashboardUrl }}" class="block transition-transform hover:scale-95 active:scale-90">
                            <img src="{{ asset('assets/images/logo_simbeka_teks.svg') }}" alt="Logo SIMBEKA" class="h-18 w-auto object-contain max-w-full">
                        </a>
                    </div>



                    {{-- Navigation --}}
                    <nav class="flex-1 px-4 space-y-8 overflow-y-auto custom-scrollbar">
                        {{-- Group: Menu Utama --}}
                        <div>
                            <span class="px-4 text-[10px] font-semibold text-[#565674]  mb-4 block">Menu Utama</span>
                            <div class="space-y-1">
                                @if(auth()->user()->role === 'siswa')
                                    {{-- Dashboard --}}
                                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('siswa.dashboard') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.dashboard') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span class="font-bold text-sm">Menu Utama</span>
                                    </a>

                                    <div class="pt-6 pb-2 px-4">
                                        <span class="text-[10px] font-semibold text-[#565674] ">Aktivitas Saya</span>
                                    </div>

                                    {{-- Riwayat Konsultasi --}}
                                    <a href="{{ route('siswa.history.konsultasi') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('siswa.history.konsultasi') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.history.konsultasi') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <span class="font-bold text-sm">Riwayat Konsultasi</span>
                                    </a>

                                    {{-- Riwayat Pelaporan --}}
                                    <a href="{{ route('siswa.history.pelaporan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('siswa.history.pelaporan') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.history.pelaporan') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <span class="font-bold text-sm">Riwayat Pelaporan</span>
                                    </a>
                                @endif

                                @if(auth()->user()->role === 'guru_bk')
                                    <a href="{{ route('gurubk.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('gurubk.dashboard') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('gurubk.dashboard') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        <span class="font-bold text-sm">Dashboard Utama</span>
                                    </a>
                                @endif

                                @if(auth()->user()->role === 'admin')
                                    {{-- Dashboard --}}
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span class="font-bold text-sm">Dashboard</span>
                                    </a>

                                    <div class="pt-6 pb-2 px-4">
                                        <span class="text-[10px] font-semibold text-[#565674] ">Master Data</span>
                                    </div>

                                    {{-- Data Guru BK --}}
                                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.teachers.*') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('admin.teachers.*') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span class="font-bold text-sm">Master Guru BK</span>
                                    </a>

                                    {{-- Data Siswa --}}
                                    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.students.*') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                        <svg class="w-5 h-5 {{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <span class="font-bold text-sm">Master Siswa</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Group: Manajemen BK (For Teacher) --}}
                        @if(auth()->user()->role === 'guru_bk')
                        <div>
                            <span class="px-4 text-[10px] font-semibold text-[#565674]  mb-4 block">Manajemen Bimbingan</span>
                            <div class="space-y-1">
                                <a href="{{ route('gurubk.students.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('gurubk.students.*') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('gurubk.students.*') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span class="font-bold text-sm">Data Siswa</span>
                                </a>
                                <a href="{{ route('gurubk.counseling.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('gurubk.counseling.*') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('gurubk.counseling.*') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="font-bold text-sm">Catatan Anekdot</span>
                                </a>
                                {{-- Arsip Bimbingan --}}
                                <a href="{{ route('gurubk.archives.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('gurubk.archives.*') && request('type') != 'surat' ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('gurubk.archives.*') && request('type') != 'surat' ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                    <span class="font-bold text-sm">Arsip Bimbingan</span>
                                </a>

                                {{-- Arsip Surat --}}
                                <a href="{{ route('gurubk.archives.index', ['type' => 'surat']) }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('gurubk.archives.*') && request('type') == 'surat' ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('gurubk.archives.*') && request('type') == 'surat' ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="font-bold text-sm">Arsip Surat Terbit</span>
                                </a>

                                {{-- Buat Surat & Laporan --}}
                                <a href="{{ route('gurubk.documents.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('gurubk.documents.*') || request()->routeIs('gurubk.letters.create') || request()->routeIs('letters.*') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('gurubk.documents.*') || request()->routeIs('gurubk.letters.create') || request()->routeIs('letters.*') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="font-bold text-sm">Buat Surat</span>
                                </a>
                            </div>
                        </div>
                        @endif

                        {{-- Group: Akun --}}
                        <div>
                            <span class="px-4 text-[10px] font-semibold text-[#565674]  mb-4 block">Akun</span>
                            <div class="space-y-1">
                                <a href="{{ route('profile.settings') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('profile.settings') ? 'sidebar-item-active' : 'sidebar-item-inactive' }}">
                                    <svg class="w-5 h-5 {{ request()->routeIs('profile.settings') ? 'text-white' : 'text-[#494b74] group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="font-bold text-sm">Pengaturan Akun</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="button" @click="showLogoutModal = true" class="w-full flex items-center gap-4 px-4 py-3.5 rounded-lg transition-all duration-200 group sidebar-item-inactive">
                                        <svg class="w-5 h-5 text-[#494b74] group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        <span class="font-bold text-sm group-hover:text-rose-500">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </nav>
                </aside>
            @endif
        @endauth

        {{-- Main Content --}}
        <div class="flex-1 @auth @if(!$isGuestPage) lg:ml-72 @endif @endauth flex flex-col min-w-0">
            {{-- Header --}}
            @auth
                @if(!$isGuestPage)
                    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-40 shadow-sm">
                        <div class="flex items-center gap-3">
                            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-slate-100 lg:hidden text-slate-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <h1 class="text-base lg:text-lg font-bold text-slate-900 truncate">@yield('title_display', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="hidden sm:flex flex-col items-end">
                                <span class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] uppercase tracking-wider font-bold text-primary">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                            </div>
                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 font-bold border border-slate-200 shrink-0">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </header>
                @endif
            @endauth

            <main class="flex-1 @if(!$isGuestPage) p-4 md:p-8 @endif">
                {{-- Flash Messages --}}
                @if(session('success') || session('error') || $errors->any())
                <div class="max-w-4xl mx-auto mb-6 @if($isGuestPage) mt-4 px-4 @endif">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg">
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
    {{-- Logout Confirmation Modal --}}
    <div x-show="showLogoutModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showLogoutModal = false" class="bg-white rounded-lg shadow-2xl w-full max-w-sm overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-8 text-center">
                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Konfirmasi Logout</h3>
                
                @if(auth()->check() && auth()->user()->is_guest)
                    <div class="bg-slate-900 rounded-[2rem] p-6 mb-8 text-left border border-white/10 shadow-2xl" x-data="{ copied: false }">
                        <p class="text-xs text-slate-400 font-bold font-medium mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                            Simpan Kode Pemulihan!
                        </p>
                        <div 
                            @click="navigator.clipboard.writeText('{{ auth()->user()->recovery_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="bg-white/5 border-2 border-dashed border-white/10 rounded-lg p-4 text-center group cursor-pointer hover:border-primary/50 transition-all relative overflow-hidden"
                        >
                            <span class="text-2xl font-semibold tracking-[0.2em] text-primary select-all transition-opacity" :class="copied ? 'opacity-20' : 'opacity-100'">
                                {{ auth()->user()->recovery_code ?? 'TIDAK-ADA' }}
                            </span>
                            <div x-show="copied" x-transition class="absolute inset-0 flex items-center justify-center text-primary font-semibold text-xs font-medium">
                                Tersalin!
                            </div>
                            <div class="text-[8px] uppercase font-semibold text-slate-500 mt-2 tracking-widest" x-show="!copied">Klik untuk menyalin kode</div>
                        </div>
                    </div>
                @else
                    <p class="text-slate-500 text-sm mb-8 font-medium">Apakah Anda yakin ingin keluar dari sistem?</p>
                @endif

                <div class="flex flex-col gap-3">
                    <button 
                        @click="document.getElementById('logout-form').submit()"
                        class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-4 rounded-lg shadow-xl shadow-rose-600/20 transition active:scale-[0.98]"
                    >
                        Ya, Keluar Sekarang
                    </button>
                    <button 
                        @click="showLogoutModal = false"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-4 rounded-lg transition"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- Recovery Code Welcome Modal --}}
    @if(session('show_recovery') && auth()->check())
    <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md">
        <div @click.away="open = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-500">
            <div class="bg-primary p-8 text-white text-center relative">
                <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-2xl font-semibold">Kode Pemulihan Anda</h3>
                <p class="text-blue-100 text-xs mt-2 font-bold font-medium opacity-80">Penting: Jangan Sampai Hilang!</p>
            </div>
            <div class="p-8 space-y-6 bg-white" x-data="{ copied: false }">
                <div 
                    @click="navigator.clipboard.writeText('{{ auth()->user()->recovery_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="bg-slate-50 rounded-lg p-6 text-center border border-slate-100 relative overflow-hidden group cursor-pointer hover:border-primary/50 transition-all"
                >
                    <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="text-4xl font-semibold tracking-[0.2em] text-slate-900 select-all relative z-10 block mb-2 transition-opacity" :class="copied ? 'opacity-10' : 'opacity-100'">
                        {{ auth()->user()->recovery_code ?? 'TIDAK-ADA' }}
                    </span>
                    <div x-show="copied" x-transition class="absolute inset-0 flex items-center justify-center text-primary font-semibold text-lg font-medium z-20">
                        Tersalin!
                    </div>
                    <p class="text-[9px] font-semibold text-primary  relative z-10" x-show="!copied">Klik untuk menyalin kode</p>
                </div>

                <div class="space-y-4">
                    <p class="text-slate-500 text-xs text-center leading-relaxed font-medium px-4">
                        Simpan kode ini baik-baik. Anda membutuhkannya untuk masuk kembali jika sesi berakhir atau jika Anda lupa password.
                    </p>
                    
                    <button @click="open = false" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-4 rounded-lg shadow-xl transition active:scale-[0.98] font-medium text-xs">
                        Saya Sudah Simpan Kodenya
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Global Form Loading State --}}
    <script>
        document.addEventListener('alpine:init', () => {
            // Auto-add loading state to all forms with data-loading attribute
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Global: prevent double submission on all forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const btn = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (!btn) return;
                    
                    // Skip if already submitting
                    if (form.dataset.submitting === 'true') {
                        e.preventDefault();
                        return;
                    }
                    
                    form.dataset.submitting = 'true';
                    
                    const originalText = btn.innerHTML;
                    btn.disabled = true;
                    btn.style.opacity = '0.7';
                    btn.innerHTML = `
                        <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    `;
                    
                    // Reset after 10s in case of network timeout
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.style.opacity = '1';
                        btn.innerHTML = originalText;
                        form.dataset.submitting = 'false';
                    }, 10000);
                });
            });
        });
    </script>
</body>
</html>
