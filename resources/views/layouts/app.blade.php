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
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-item { transition: all 0.15s; }
        .sidebar-item:hover { background: rgba(99,102,241,0.08); }
        .sidebar-item.active { background: rgba(99,102,241,0.12); border-right: 3px solid #6366f1; color: #4f46e5; }
        #sidebar { transition: transform 0.25s ease; }

        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                transform: translateX(-100%);
                z-index: 30;
                height: 100%;
            }
            #sidebar.open {
                transform: translateX(0);
            }
            #hamburger {
                display: block !important;
            }
            #close-btn {
                display: block !important;
            }
        }

        @media (min-width: 1024px) {
            #sidebar {
                position: static;
                transform: translateX(0);
            }
            #hamburger {
                display: none !important;
            }
            #close-btn {
                display: none !important;
            }
            #overlay {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
<div class="flex h-screen overflow-hidden">

    <!-- Overlay -->
    <div id="overlay" onclick="closeSidebar()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:20;"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col shadow-sm shrink-0">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-sm">Dashboard</p>
                    <p class="text-xs text-slate-400">Monitoring Mahasiswa</p>
                </div>
            </div>
            <button id="close-btn" onclick="closeSidebar()" style="display:none;" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @if(auth()->user()->isAdmin())
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2 mt-1">Admin</p>

            <a href="{{ route('dashboard') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('mahasiswa.index') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Data Mahasiswa
            </a>

            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2 mt-4">Monitoring</p>

            <a href="{{ route('admin.monitoring') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('admin.monitoring') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Monitoring Risiko
            </a>

            <a href="{{ route('admin.kehadiran') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('admin.kehadiran') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Kehadiran
            </a>

            <a href="{{ route('admin.nilai') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('admin.nilai') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Nilai
            </a>

            <a href="{{ route('admin.pkl') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('admin.pkl*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Laporan PKL
            </a>

            <a href="{{ route('admin.aktivitas') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('admin.aktivitas') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Aktivitas
            </a>

            @else
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2 mt-1">Menu</p>

            <a href="{{ route('dashboard') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard Saya
            </a>

            <a href="{{ route('kehadiran.index') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('kehadiran.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Kehadiran Saya
            </a>

            <a href="{{ route('nilai.index') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Nilai Saya
            </a>

            @if(auth()->user()->mahasiswa && auth()->user()->mahasiswa->semester == 7)
            <a href="{{ route('pkl.index') }}" onclick="closeSidebar()"
               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('pkl.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Laporan PKL
            </a>
            @endif
            @endif
        </nav>

        <!-- User info -->
        <div class="p-4 border-t border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-700 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <header class="bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <button id="hamburger" onclick="openSidebar()" style="display:none;" class="text-slate-500 hover:text-slate-700 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-base font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
            </div>
            <span class="text-xs text-slate-400">{{ now()->translatedFormat('d F Y') }}</span>
        </header>

        <main class="flex-1 overflow-y-auto p-4">
            @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('close-btn').style.display = 'block';
}
function closeSidebar() {
    if (window.innerWidth < 1024) {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('close-btn').style.display = 'none';
    }
}
</script>
</body>
</html>