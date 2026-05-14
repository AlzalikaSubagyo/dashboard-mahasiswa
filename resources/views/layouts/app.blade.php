<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa')</title>

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            overflow-x: hidden;
            background: #f8fafc;
        }

        #app-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background: #f8fafc;
        }

        /* ======================
           SIDEBAR
        ====================== */
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

        /* ======================
           OVERLAY
        ====================== */
        #overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 20;
        }

        #overlay.show {
            display: block;
        }

        /* ======================
           MOBILE
        ====================== */
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

            #hamburger {
                display: flex !important;
            }
        }

        /* ======================
           DESKTOP
        ====================== */
        @media (min-width: 768px) {

            #sidebar {
                position: relative;
                transform: translateX(0) !important;
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

        /* ======================
           MAIN
        ====================== */
        #main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            min-width: 0;
        }

        #main-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        #main-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }

        #main-scroll::-webkit-scrollbar {
            width: 5px;
        }

        #main-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        /* ======================
           SIDEBAR ITEM
        ====================== */
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .sidebar-item:hover {
            background: rgba(99,102,241,0.08);
            color: #4f46e5;
        }

        .sidebar-item.active {
            background: rgba(99,102,241,0.12);
            color: #4f46e5;
            font-weight: 600;
            border-right: 3px solid #6366f1;
        }

        .sidebar-item svg {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>

<div id="app-wrapper">

    {{-- OVERLAY --}}
    <div id="overlay" onclick="closeSidebar()"></div></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar">

        {{-- BRAND --}}
        <div style="padding:20px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">

            <div style="display:flex; align-items:center; gap:12px;">

                <div style="width:36px; height:36px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>

                <div>
                    <p style="font-weight:700; font-size:14px; color:#1e293b; margin:0;">
                        Dashboard
                    </p>

                    <p style="font-size:11px; color:#94a3b8; margin:0;">
                        Monitoring Mahasiswa
                    </p>
                </div>
            </div>

            <button id="close-btn"
                    onclick="closeSidebar()"
                    style="display:none; background:none; border:none; cursor:pointer; padding:4px; color:#94a3b8;">

                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- NAVIGATION --}}
        <nav style="flex:1; padding:12px 8px; overflow-y:auto;">

            <a href="{{ route('dashboard') }}"
               onclick="closeSidebar()"
               class="sidebar-item">

                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7"/>
                </svg>

                Dashboard Saya
            </a>

            <a href="{{ route('kehadiran.index') }}"
               onclick="closeSidebar()"
               class="sidebar-item">

                Kehadiran Saya
            </a>

            <a href="{{ route('nilai.index') }}"
               onclick="closeSidebar()"
               class="sidebar-item">

                Nilai Saya
            </a>

        </nav>

    </aside>

    {{-- MAIN --}}
    <div id="main-content">

        {{-- HEADER --}}
        <header id="main-header">

            <div style="display:flex; align-items:center; gap:12px;">

                <button id="hamburger"
                        onclick="openSidebar()"
                        style="display:none; background:none; border:none; cursor:pointer; padding:6px; color:#64748b; align-items:center;">

                    <svg style="width:22px;height:22px;"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h1 style="font-size:15px; font-weight:700; color:#1e293b; margin:0;">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>

            <span style="font-size:12px; color:#94a3b8;">
                {{ now()->translatedFormat('d F Y') }}
            </span>
        </header>

        {{-- CONTENT --}}
        <main id="main-scroll">

            @yield('content')

        </main>

    </div>
</div>

<script>

    function isMobile() {
        return window.innerWidth < 768;
    }

    function openSidebar() {

        if (isMobile()) {

            document.getElementById('sidebar').classList.add('open');

            document.getElementById('overlay').classList.add('show');

            document.getElementById('close-btn').style.display = 'flex';
        }
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

    window.addEventListener('load', initLayout);

    document.addEventListener('DOMContentLoaded', initLayout);

</script>

</body>
</html>
