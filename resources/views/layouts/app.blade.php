<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SIMOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-slate-50 font-inter antialiased">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- ===== SIDEBAR ===== --}}
    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false"
         class="fixed inset-0 z-20 bg-black/50 lg:hidden" x-transition.opacity></div>

    <aside id="sidebar"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-64 bg-[#1e293b] text-white transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <div class="w-9 h-9 rounded-xl bg-blue-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm leading-tight">SIMOM</p>
                <p class="text-[10px] text-slate-400 leading-tight">Sistem Info Manajemen Organisasi</p>
            </div>
        </div>

        {{-- User Info --}}
        <div class="px-4 py-3 mx-3 mt-4 bg-white/5 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-sm font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->getRoleLabel() }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('departemen.index') }}"
               class="nav-link {{ request()->routeIs('departemen.*') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
                <span>Departemen & Anggota</span>
            </a>

            <a href="{{ route('rapat.index') }}"
               class="nav-link {{ request()->routeIs('rapat.*') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span>Rapat Akbar</span>
            </a>

            <a href="{{ route('inventaris.index') }}"
               class="nav-link {{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
                <span>Inventaris</span>
            </a>

            <a href="{{ route('berkas.index') }}"
               class="nav-link {{ request()->routeIs('berkas.*') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                </svg>
                <span>Berkas</span>
            </a>

            <div class="pt-3 mt-3 border-t border-white/10">
                <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Akun</p>
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Profil Saya</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full text-red-400 hover:text-red-300 hover:bg-red-500/10">
                        <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </nav>

        {{-- Footer --}}
        <div class="px-6 py-3 border-t border-white/10">
            <p class="text-[10px] text-slate-500 text-center">SIMOM v1.0 &copy; 2024</p>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Navbar --}}
        <header class="bg-white border-b border-slate-200 px-4 lg:px-6 py-3.5 flex items-center gap-4 shrink-0 shadow-sm z-10">
            {{-- Hamburger (mobile) --}}
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            {{-- Page Title --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-base font-semibold text-slate-800 truncate">@yield('page-title', 'Dashboard')</h1>
                @hasSection('breadcrumb')
                <div class="text-xs text-slate-500">@yield('breadcrumb')</div>
                @endif
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3 shrink-0">
                {{-- Role Badge --}}
                <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ Auth::user()->getRoleBadgeClass() }}">
                    {{ Auth::user()->getRoleLabel() }}
                </span>
                {{-- Notif placeholder --}}
                <button class="relative p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </button>
                {{-- Avatar --}}
                <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-6 pt-4">
            @if(session('success'))
            <div class="flex items-center gap-3 p-3.5 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm mb-0"
                 x-data x-init="setTimeout(() => $el.remove(), 4000)">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 p-3.5 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm mb-0"
                 x-data x-init="setTimeout(() => $el.remove(), 4000)">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
</div>

<style>
    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.625rem;
        font-size: 0.8125rem;
        font-weight: 500;
        color: rgb(148 163 184);
        transition: all 0.15s;
        text-decoration: none;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.07);
        color: white;
    }
    .nav-link.active {
        background: rgba(59,130,246,0.2);
        color: #60a5fa;
    }
    .font-inter { font-family: 'Inter', sans-serif; }
    .w-4\.5 { width: 1.125rem; }
    .h-4\.5 { height: 1.125rem; }
</style>

@stack('scripts')
</body>
</html>
