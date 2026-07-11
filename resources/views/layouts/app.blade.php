<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SIMOM</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }

        /* Sidebar */
        #sidebar {
    background: linear-gradient(160deg, #1a6b8a 0%, #0f4c6b 40%, #0a3550 100%);
    width: 240px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: sticky;
    top: 0;
    overflow-y: auto;
    scrollbar-width: none;
}
        #sidebar::-webkit-scrollbar { display: none; }

        /* Sidebar grid overlay */
        #sidebar::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 240px; height: 100vh;
            background-image:
                linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        /* Sidebar glow */
        #sidebar::after {
            content: '';
            position: fixed;
            bottom: 0; left: 0;
            width: 240px; height: 300px;
            background: radial-gradient(ellipse at bottom left, rgba(59,130,246,0.12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        #sidebar > * { position: relative; z-index: 1; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #93c5d8;
            transition: all 0.15s;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
       }
.nav-link:hover { background: rgba(255,255,255,0.08); color: #e0f2fe; }
.nav-link.active { background: rgba(255,255,255,0.15); color: #ffffff; }

        .nav-link.danger { color: #f87171; }
        .nav-link.danger:hover { background: rgba(239,68,68,0.1); color: #fca5a5; }

        .nav-icon { width: 16px; height: 16px; flex-shrink: 0; }

        .nav-section-label {
            padding: 0 10px;
            font-size: 10px;
            font-weight: 700;
            color: #4a8fa8;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        /* Main content */
        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            background: #f1f5f9;
        }

        /* Topbar */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
            z-index: 10;
        }

        /* Page scroll area */
        .page-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }

        /* Flash messages */
        .flash-msg {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .flash-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* Mobile overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 20;
        }

        @media (max-width: 1024px) {
            #sidebar {
                position: fixed;
                top: 0; left: 0;
                height: 100vh;
                z-index: 30;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }
            #sidebar.open { transform: translateX(0); }
            .main-content { height: 100vh; }
        }
    </style>
</head>
<body class="h-full" style="display:flex; background:#f1f5f9;">

    {{-- Mobile Overlay --}}
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeSidebar()"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar">

        {{-- Logo --}}
        <div style="padding: 20px 16px 16px; border-bottom: 1px solid rgba(255,255,255,0.07);">
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo"
     style="width:36px; height:36px; border-radius:8px; object-fit:contain; flex-shrink:0;">
<div>
    <div style="font-weight:800; font-size:14px; color:#f1f5f9; letter-spacing:0.05em; line-height:1.2;">SI-MOM</div>
    <div style="font-size:10px; color:#7ec8e3; line-height:1.2;">Manajemen Organisasi Mahasiswa</div>
</div>
    
            </div>
        </div>

        {{-- User Card --}}
        <div style="margin: 12px; padding: 10px 12px; background: rgba(255,255,255,0.08); border-radius: 10px; border: 1px solid rgba(255,255,255,0.12);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:50%; background:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:white; flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div style="min-width:0;">
                    <div style="font-size:12.5px; font-weight:600; color:#e2e8f0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:10.5px; color:#7ec8e3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ Auth::user()->getRoleLabel() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav style="flex:1; padding: 8px 12px; display:flex; flex-direction:column; gap:2px;">
            <div class="nav-section-label" style="margin-top:4px; margin-bottom:8px;">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('departemen.index') }}" class="nav-link {{ request()->routeIs('departemen.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
                </svg>
                Departemen & Anggota
            </a>

            <a href="{{ route('rapat.index') }}" class="nav-link {{ request()->routeIs('rapat.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                Rapat Akbar
            </a>

            <a href="{{ route('inventaris.index') }}" class="nav-link {{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
                Inventaris
            </a>

            <a href="{{ route('berkas.index') }}" class="nav-link {{ request()->routeIs('berkas.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
                </svg>
                Berkas
            </a>

            <div style="height:1px; background:rgba(255,255,255,0.06); margin: 12px 0;"></div>
            <div class="nav-section-label">Akun</div>

            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                Profil Saya
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link danger">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </nav>

        {{-- Sidebar Footer --}}
        <div style="padding: 12px 16px; border-top: 1px solid rgba(255,255,255,0.06); font-size:10px; color:#5b9ab8; text-align:center;">
            SIMOM v1.0 &copy; 2024
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main-content">

        {{-- Topbar --}}
        <header class="topbar">
            {{-- Hamburger (mobile) --}}
            <button onclick="toggleSidebar()" style="display:none;" id="hamburger"
                    style="padding:6px; border-radius:8px; background:none; border:none; cursor:pointer; color:#64748b;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            {{-- Page title + breadcrumb --}}
            <div style="flex:1; min-width:0;">
                <div style="font-size:15px; font-weight:600; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    @yield('page-title', 'Dashboard')
                </div>
                @hasSection('breadcrumb')
                <div style="font-size:12px; color:#94a3b8; margin-top:1px;">@yield('breadcrumb')</div>
                @endif
            </div>

            {{-- Right: role badge + notif + avatar --}}
            <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
                <span style="display:inline-flex; align-items:center; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; {{ Auth::user()->getRoleBadgeClass() }}">
                    {{ Auth::user()->getRoleLabel() }}
                </span>
                <button style="padding:6px; border-radius:8px; background:none; border:none; cursor:pointer; color:#94a3b8; transition:background 0.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                </button>
                <div style="width:32px; height:32px; border-radius:50%; background:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:white;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="page-scroll">

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="flash-msg flash-success" id="flashSuccess">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flash-msg flash-error" id="flashError">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Auto-hide flash messages
        ['flashSuccess','flashError'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => { el.style.opacity='0'; el.style.transition='opacity 0.4s'; setTimeout(()=>el.remove(),400); }, 4000);
        });

        // Mobile sidebar
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('mobileOverlay').style.display =
                document.getElementById('sidebar').classList.contains('open') ? 'block' : 'none';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('mobileOverlay').style.display = 'none';
        }

        // Show hamburger on mobile
        function checkMobile() {
            const h = document.getElementById('hamburger');
            if (h) h.style.display = window.innerWidth < 1024 ? 'flex' : 'none';
        }
        checkMobile();
        window.addEventListener('resize', checkMobile);
    </script>

    @stack('scripts')
</body>
</html>