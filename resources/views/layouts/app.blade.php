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

        /* ── SIDEBAR ── */
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
        }

        .sidebar-brand {
            padding: 24px 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .10);
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--primary);
            font-weight: 800;
        }

        .brand-name {
            color: #fff;
            font-weight: 800;
            font-size: 18px;
        }

        .brand-sub {
            color: rgba(255, 255, 255, .5);
            font-size: 11px;
            font-weight: 500;
        }

        .sidebar-menu {
            padding: 16px 12px;
            flex: 1;
        }

        .menu-label {
            color: rgba(255, 255, 255, .35);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 8px 10px 4px;
            margin-top: 8px;
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
            padding: 16px 12px;
            border-top: 1px solid rgba(255, 255, 255, .10);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .07);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
        }

        .user-role {
            color: rgba(255, 255, 255, .45);
            font-size: 11px;
        }

        /* ── MAIN ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
            font-size: 16px;
            transition: all .2s;
            position: relative;
        }

        .icon-btn:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .icon-btn .badge-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        /* ── CONTENT ── */
        .content {
            padding: 24px 28px;
            flex: 1;
        }

        /* ── CARD BOX ── */
        .card-box {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-box-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-box-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text);
        }

        .card-box-title span {
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            margin-left: 5px;
        }

        /* ── PILLS / BADGES ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .pill i {
            font-size: 8px;
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

        /* ── TABLE ── */
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead th {
            background: #f8fafc;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .tbl tbody td {
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .tbl tbody tr:hover td {
            background: #fafcff;
        }

        /* ── USER CELL ── */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .u-ava {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }

        .u-name {
            font-size: 13px;
            font-weight: 600;
        }

        .u-sub {
            font-size: 11px;
            color: var(--muted);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrap {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ====== SIDEBAR ====== --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <div class="sidebar-brand">
            <div class="logo-wrap">
                <div class="logo-icon">A</div>
                <div>
                    <div class="brand-name">Al Ilmi Center</div>
                    <div class="brand-sub">@yield('sidebar-sub', 'Panel')</div>
                </div>
            </div>
        </div>

        {{-- Menu --}}
        <div class="sidebar-menu">
            @yield('sidebar-menu')
        </div>

        {{-- User Info --}}
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role ?? '') }}</div>
                </div>
            </div>
        </div>

    </aside>

    {{-- ====== MAIN ====== --}}
    <div class="main-wrap">

        {{-- Topbar --}}
        <div class="topbar">
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-sub">@yield('page-sub', '')</div>
            </div>
            <div class="topbar-right">
                <div class="icon-btn"><i class="bi bi-search"></i></div>
                <div class="icon-btn">
                    <i class="bi bi-bell"></i>
                    <span class="badge-dot"></span>
                </div>
                <div class="icon-btn"><i class="bi bi-envelope"></i></div>
                {{-- <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-sm ms-1"
          style="background:var(--primary);color:#fff;border-radius:8px;
                 font-size:13px;font-weight:600;padding:6px 14px;border:none">
          <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
      </form> --}}
                <a href="#" class="btn btn-sm ms-1"
                    style="background:var(--primary);color:#fff;border-radius:8px;
         font-size:13px;font-weight:600;padding:6px 14px;border:none">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </div>

        {{-- Konten Halaman --}}
        <div class="content">
            @yield('content')
        </div>

    </div>{{-- /main-wrap --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>
