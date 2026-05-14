<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        html, body { margin: 0; padding: 0; height: 100%; overflow: hidden; }

        #app-wrapper { display: flex; width: 100%; height: 100vh; background: #f8fafc; }

        /* SIDEBAR */
        #sidebar {
            width: 256px;
            min-width: 256px;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: transform 0.25s ease;
            z-index: 30;
        }

        /* OVERLAY - hidden by default, always */
        #overlay {
            display: none !important;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 20;
        }
        #overlay.show {
            display: block !important;
        }

        /* MOBILE: sidebar jadi drawer */
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                transform: translateX(-100%);
            }
            #sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            }
            #hamburger { display: flex !important; }
        }

        /* DESKTOP: sidebar selalu tampil */
        @media (min-width: 768px) {
            #sidebar {
                position: relative;
                transform: translateX(0) !important;
            }
            #hamburger { display: none !important; }
            #close-btn { display: none !important; }
        }

        /* MAIN */
        #main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; min-width: 0; }
        #main-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        #main-scroll { flex: 1; overflow-y: auto; padding: 16px; }
        #main-scroll::-webkit-scrollbar { width: 5px; }
        #main-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

        /* NAV ITEMS */
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; font-size: 14px; font-weight: 500; color: #64748b; text-decoration: none; transition: all 0.15s; margin-bottom: 2px; }
        .sidebar-item:hover { background: rgba(99,102,241,0.08); color: #4f46e5; }
        .sidebar-item.active { background: rgba(99,102,241,0.12); color: #4f46e5; font-weight: 600; border-right: 3px solid #6366f1; }
        .sidebar-item svg { flex-shrink: 0; width: 20px; height: 20px; }
    </style>
</head>
<body>
<div id="app-wrapper">

    <!-- Overlay (HANYA mobile) -->
    <div id="overlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar">
        <!-- Brand -->
        <div style="padding:20px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:36px; height:36px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p style="font-weight:700; font-size:14px; color:#1e293b; margin:0;">Dashboard</p>
                    <p style="font-size:11px; color:#94a3b8; margin:0;">Monitoring Mahasiswa</p>
                </div>
            </div>
            <button id="close-btn" onclick="closeSidebar()" style="display:none; background:none; border:none; cursor:pointer; padding:4px; color:#94a3b8;">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav style="flex:1; padding:12px 8px; overflow-y:auto;">
            @if(auth()->user()->isAdmin())
                <p style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; padding:0 12px; margin:4px 0 8px;">Admin</p>

                <a href="{{ route('dashboard') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('mahasiswa.index') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Data Mahasiswa
                </a>

                <p style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; padding:0 12px; margin:16px 0 8px;">Monitoring</p>

                <a href="{{ route('admin.monitoring') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('admin.monitoring') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Monitoring Risiko
                </a>
                <a href="{{ route('admin.kehadiran') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('admin.kehadiran') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Kehadiran
                </a>
                <a href="{{ route('admin.nilai') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('admin.nilai') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Nilai
                </a>
                <a href="{{ route('admin.pkl') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('admin.pkl*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Laporan PKL
                </a>
                <a href="{{ route('admin.aktivitas') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('admin.aktivitas') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Aktivitas
                </a>

            @else
                <p style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; padding:0 12px; margin:4px 0 8px;">Menu</p>

                <a href="{{ route('dashboard') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard Saya
                </a>
                <a href="{{ route('kehadiran.index') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('kehadiran.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Kehadiran Saya
                </a>
                <a href="{{ route('nilai.index') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Nilai Saya
                </a>
                <a href="{{ route('qr.show') }}" onclick="closeSidebar()"
   class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('qr.show') ? 'active' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.24M16.24 12l-.01.01M12 12v.01M12 16h.01M8 12H4m4 0v4m0-4V8m0 0H4m4 0h4"/>
    </svg>
    QR Absensi
</a>
                @if(auth()->user()->mahasiswa && auth()->user()->mahasiswa->semester == 7)
                <a href="{{ route('pkl.index') }}" onclick="closeSidebar()" class="sidebar-item {{ request()->routeIs('pkl.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Laporan PKL
                </a>
                @endif
            @endif
        </nav>

        <!-- User -->
        <div style="padding:12px 16px; border-top:1px solid #f1f5f9;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; background:linear-gradient(135deg,#818cf8,#a78bfa); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:14px; font-weight:700; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ auth()->user()->name }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:0; text-transform:capitalize;">{{ auth()->user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" title="Logout" style="background:none; border:none; cursor:pointer; padding:6px; color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'">
                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div id="main-content">
        <header id="main-header">
            <div style="display:flex; align-items:center; gap:12px;">
                <button id="hamburger" onclick="openSidebar()" style="display:none; background:none; border:none; cursor:pointer; padding:6px; color:#64748b; align-items:center;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 style="font-size:15px; font-weight:700; color:#1e293b; margin:0;">@yield('page-title', 'Dashboard')</h1>
            </div>
            <span style="font-size:12px; color:#94a3b8;">{{ now()->translatedFormat('d F Y') }}</span>
        </header>

        <main id="main-scroll">
            @if(session('success'))
            <div style="margin-bottom:16px; background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; padding:12px 16px; border-radius:12px; font-size:13px; display:flex; align-items:center; gap:8px;">
                <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="margin-bottom:16px; background:#fff1f2; border:1px solid #fecdd3; color:#9f1239; padding:12px 16px; border-radius:12px; font-size:13px; display:flex; align-items:center; gap:8px;">
                <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
    function isMobile() {
        return window.innerWidth < 768;
    }

    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('overlay').classList.add('show');
        document.getElementById('close-btn').style.display = 'flex';
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('show');
        document.getElementById('close-btn').style.display = 'none';
    }

    function initLayout() {
        if (isMobile()) {
            document.getElementById('hamburger').style.display = 'flex';
        } else {
            document.getElementById('hamburger').style.display = 'none';
            closeSidebar();
        }
    }

    window.addEventListener('resize', initLayout);
    document.addEventListener('DOMContentLoaded', initLayout);
</script>
</body>
</html>
