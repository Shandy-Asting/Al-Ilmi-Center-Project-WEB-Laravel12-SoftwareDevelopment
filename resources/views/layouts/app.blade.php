<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Al Ilmi Center')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #1e3a5f;
            --primary-light: #2d5282;
            --accent: #f6ad3c;
            --accent-soft: #fef3dc;
            --success: #16a34a;
            --success-soft: #dcfce7;
            --danger: #dc2626;
            --danger-soft: #fee2e2;
            --warning: #d97706;
            --warning-soft: #fef9c3;
            --info: #0284c7;
            --info-soft: #e0f2fe;
            --sidebar-w: 260px;
            --topbar-h: 60px;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ══ OVERLAY MOBILE ══ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 99;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ══ SIDEBAR ══ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        }

        .sidebar-brand {
            padding: 20px 18px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: var(--primary);
            font-weight: 800;
            flex-shrink: 0;
        }

        .brand-name {
            color: #fff;
            font-weight: 800;
            font-size: 17px;
            line-height: 1.2;
        }

        .brand-sub {
            color: rgba(255, 255, 255, .5);
            font-size: 11px;
        }

        .sidebar-menu {
            padding: 12px 10px;
            flex: 1;
        }

        .menu-label {
            color: rgba(255, 255, 255, .35);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 8px 10px 4px;
            margin-top: 6px;
        }

        .nav-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .65);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .nav-item-custom:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .nav-item-custom.active {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
        }

        .nav-item-custom i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid rgba(255, 255, 255, .1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .07);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
        }

        .user-role {
            color: rgba(255, 255, 255, .45);
            font-size: 11px;
        }

        /* ══ MAIN ══ */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin .3s;
        }

        /* ══ TOPBAR ══ */
        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: 0 20px;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-menu {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--bg);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
            font-size: 18px;
            transition: all .2s;
            flex-shrink: 0;
        }

        .btn-menu:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .topbar-titles {}

        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.2;
        }

        .topbar-sub {
            font-size: 11.5px;
            color: var(--muted);
        }

        .topbar-right {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .icon-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
            font-size: 16px;
            transition: all .2s;
            position: relative;
            text-decoration: none;
        }

        .icon-btn:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .badge-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 7px;
            height: 7px;
            background: var(--danger);
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .logout-btn {
            background: var(--danger-soft) !important;
            color: var(--danger) !important;
            border-color: var(--danger-soft) !important;
            min-width: 34px;
        }

        .logout-btn:hover {
            background: var(--danger) !important;
            color: #fff !important;
            border-color: var(--danger) !important;
        }

        /* ══ CONTENT ══ */
        .content {
            padding: 20px 24px;
            flex: 1;
        }

        /* ══ CARD BOX ══ */
        .card-box {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
        }

        .card-box-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-box-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .card-box-title i {
            color: var(--primary);
            margin-right: 6px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .p-success {
            background: var(--success-soft);
            color: var(--success);
        }

        .p-warning {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .p-danger {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .p-info {
            background: var(--info-soft);
            color: var(--info);
        }

        .p-primary {
            background: #eff6ff;
            color: var(--primary);
        }

        /* ══ RESPONSIVE ══ */
        @media (max-width:991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrap {
                margin-left: 0;
            }

            .btn-menu {
                display: flex;
            }

            .content {
                padding: 16px;
            }
        }

        @media (max-width:576px) {
            .content {
                padding: 12px;
            }

            .topbar {
                padding: 0 14px;
            }

            .logout-btn span {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- OVERLAY MOBILE -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo-wrap">
                <div class="logo-icon">A</div>
                <div>
                    <div class="brand-name">Al Ilmi Center</div>
                    <div class="brand-sub">@yield('sidebar-sub', 'Panel')</div>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            @yield('sidebar-menu')
        </div>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="user-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ auth()->user()->name ?? 'Pengguna' }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role ?? '') }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout"
                        style="width:30px;height:30px;border-radius:8px;border:none;background:rgba(255,255,255,.1);color:rgba(255,255,255,.6);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;transition:all .2s;">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-wrap" id="mainWrap">
        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn-menu" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-titles">
                    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                    <div class="topbar-sub">@yield('page-sub', '')</div>
                </div>
            </div>
            <div class="topbar-right">
                {{-- Notifikasi --}}
                @if (auth()->check())
                    @if (auth()->user()->role === 'siswa')
                        <a href="/siswa/notifikasi" class="icon-btn" title="Notifikasi">
                            <i class="bi bi-bell"></i>
                            <span class="badge-dot"></span>
                        </a>
                    @elseif(auth()->user()->role === 'tutor')
                        <a href="/tutor/notifikasi" class="icon-btn" title="Notifikasi">
                            <i class="bi bi-bell"></i>
                            <span class="badge-dot"></span>
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="/admin/notifikasi" class="icon-btn" title="Notifikasi">
                            <i class="bi bi-bell"></i>
                            <span class="badge-dot"></span>
                        </a>
                    @endif
                @endif

                {{-- Logout — hanya icon di mobile, icon+teks di desktop --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="icon-btn logout-btn" title="Logout"
                        style="background:var(--danger-soft);color:var(--danger);border-color:var(--danger-soft);">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- KONTEN -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebarOverlay');
            sb.classList.toggle('open');
            ov.classList.toggle('show');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('show');
        }
        // Tutup sidebar kalau resize ke desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 991) closeSidebar();
        });
    </script>
    @stack('scripts')
</body>

</html>
