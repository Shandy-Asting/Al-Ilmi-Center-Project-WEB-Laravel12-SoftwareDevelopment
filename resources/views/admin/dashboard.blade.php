@extends('layouts.app')

@section('title', 'Dashboard Admin - Al Ilmi Center')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Dashboard Admin')
@section('page-sub', 'Selamat datang kembali 👋')

@section('sidebar-menu')
<div class="menu-label">Utama</div>
<a href="/admin/dashboard" class="nav-item-custom {{ request()->is('admin/dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<div class="menu-label">Pengelolaan</div>
<a href="/admin/pengguna" class="nav-item-custom {{ request()->is('admin/pengguna') ? 'active' : '' }}">
    <i class="bi bi-people-fill"></i> Pengelolaan Pengguna
    <span class="nav-badge">12</span>
</a>
<a href="/admin/paket" class="nav-item-custom {{ request()->is('admin/paket') ? 'active' : '' }}">
    <i class="bi bi-box-seam"></i> Pengelolaan Paket
</a>
<a href="/admin/pembayaran" class="nav-item-custom {{ request()->is('admin/pembayaran') ? 'active' : '' }}">
    <i class="bi bi-cash-coin"></i> Pembayaran & Gaji
</a>
<a href="/admin/rekening" class="nav-item-custom {{ request()->is('admin/rekening') ? 'active' : '' }}">
    <i class="bi bi-bank"></i> Rekening Bank
</a>
<a href="/admin/laporan" class="nav-item-custom {{ request()->is('admin/laporan') ? 'active' : '' }}">
    <i class="bi bi-bar-chart-line-fill"></i> Laporan
</a>
@endsection

@push('styles')
<style>
    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 60%, #3b6fa0 100%);
        border-radius: 16px;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: -40px;
        right: 120px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: 60px;
        width: 280px;
        height: 280px;
        background: rgba(255, 255, 255, .04);
        border-radius: 50%;
    }

    .hero-text .greeting {
        color: rgba(255, 255, 255, .7);
        font-size: 13px;
        font-weight: 500;
    }

    .hero-text .title {
        color: #fff;
        font-size: 22px;
        font-weight: 800;
        margin-top: 2px;
    }

    .hero-text .sub {
        color: rgba(255, 255, 255, .6);
        font-size: 13px;
        margin-top: 6px;
        max-width: 420px;
    }

    .hero-pills {
        display: flex;
        gap: 8px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .hero-pill {
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .2);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .hero-pill.accent {
        background: var(--accent);
        color: var(--primary);
        border-color: var(--accent);
    }

    .hero-stats {
        display: flex;
        gap: 24px;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
    }

    .hero-stat-item {
        text-align: center;
    }

    .hero-stat-num {
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .hero-stat-lbl {
        font-size: 11px;
        color: rgba(255, 255, 255, .6);
        margin-top: 4px;
        font-weight: 500;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        border: 1px solid var(--border);
        transition: all .2s;
    }

    .stat-card:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, .07);
        transform: translateY(-2px);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-trend {
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .trend-up {
        background: var(--success-soft);
        color: var(--success);
    }

    .trend-down {
        background: var(--danger-soft);
        color: var(--danger);
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--text);
        margin-top: 12px;
        line-height: 1;
    }

    .stat-label {
        font-size: 12.5px;
        color: var(--muted);
        font-weight: 500;
        margin-top: 4px;
    }

    .stat-bar-track {
        height: 5px;
        background: #f1f5f9;
        border-radius: 99px;
        overflow: hidden;
        margin-top: 12px;
    }

    .stat-bar-fill {
        height: 100%;
        border-radius: 99px;
    }

    .stat-bar-meta {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: var(--muted);
        margin-top: 5px;
    }

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

    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        height: 140px;
        padding: 0 4px;
    }

    .bc-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .bc-bar {
        width: 100%;
        border-radius: 5px 5px 0 0;
        transition: height .4s ease;
        position: relative;
    }

    .bc-label {
        font-size: 10px;
        color: var(--muted);
        font-weight: 500;
    }

    .bc-primary {
        background: linear-gradient(180deg, var(--primary-light), var(--primary));
    }

    .bc-accent {
        background: linear-gradient(180deg, #fbbf24, var(--accent));
    }

    .bc-success {
        background: linear-gradient(180deg, #34d399, var(--success));
    }

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

    .feed-item {
        display: flex;
        gap: 12px;
        padding: 12px 18px;
        border-bottom: 1px solid var(--border);
        align-items: flex-start;
    }

    .feed-item:last-child {
        border-bottom: none;
    }

    .feed-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .status-row {
        display: flex;
        align-items: center;
        padding: 10px 18px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }

    .status-row:last-child {
        border-bottom: none;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dot-green {
        background: var(--success);
    }

    .dot-yellow {
        background: var(--warning);
    }

    .qa-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 16px;
    }

    .qa-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #fff;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .qa-btn:hover {
        border-color: var(--primary);
        background: #eff6ff;
    }

    .qa-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all .2s;
    }

    .qa-btn:hover .qa-icon {
        background: var(--primary);
        color: #fff;
    }

    .qa-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text);
    }

    .qa-sub {
        font-size: 11px;
        color: var(--muted);
        margin-top: 1px;
    }

    @media(max-width:767px) {
        .hero-stats {
            display: none;
        }

        .hero-banner {
            padding: 18px 20px;
        }

        .stat-value {
            font-size: 20px;
        }

        .bar-chart {
            height: 100px;
        }

        .qa-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
<div class="hero-banner mb-4">
    <div class="hero-text">
        <div class="greeting">Halo, Admin 👋</div>
        <div class="title">Ringkasan Sistem Al Ilmi Center</div>
        <div class="sub">
            Semua berjalan normal.
            @if($pembayaranPending > 0) Ada {{ $pembayaranPending }} pembayaran pending & @endif
            {{ $pesananBaru }} pesanan les baru masuk.
        </div>
        <div class="hero-pills">
            @if($pembayaranPending > 0)
            <div class="hero-pill accent">
                <i class="bi bi-lightning-charge-fill"></i> {{ $pembayaranPending }} Pembayaran Pending
            </div>
            @endif
            <div class="hero-pill"><i class="bi bi-person-video3"></i> {{ $pesananBaru }} Pesanan Les Baru</div>
            <div class="hero-pill"><i class="bi bi-clock"></i> Update: Baru saja</div>
        </div>
    </div>
    <div class="hero-stats">
        {{-- data sudah dari route --}}
        <div class="hero-stat-item">
            <div class="hero-stat-num">{{ $totalSiswa + $totalTutor }}</div>
            <div class="hero-stat-lbl">Total Pengguna</div>
        </div>
        <div style="width:1px;background:rgba(255,255,255,.15);align-self:stretch;"></div>
        <div class="hero-stat-item">
            <div class="hero-stat-num">{{ $totalTutor }}</div>
            <div class="hero-stat-lbl">Total Tutor</div>
        </div>
        <div style="width:1px;background:rgba(255,255,255,.15);align-self:stretch;"></div>
        <div class="hero-stat-item">
            <div class="hero-stat-num">{{ $totalLes }}</div>
            <div class="hero-stat-lbl">Total Les</div>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
    ['icon'=>'bi-people-fill','bg'=>'#eff6ff','color'=>'var(--primary)','val'=>$totalPengguna,'label'=>'Total Pengguna','bar'=>'82%','bar_color'=>'var(--primary)','trend'=>'+18%','trend_up'=>true],
    ['icon'=>'bi-person-check-fill','bg'=>'var(--success-soft)','color'=>'var(--success)','val'=>$totalSiswa,'label'=>'Total Siswa','bar'=>'68%','bar_color'=>'var(--success)','trend'=>'+12%','trend_up'=>true],
    ['icon'=>'bi-cash-stack','bg'=>'var(--accent-soft)','color'=>'var(--warning)','val'=>'Rp '.number_format($pendapatanLes/1000000,1).'Jt','label'=>'Pendapatan Les','bar'=>'73%','bar_color'=>'var(--accent)','trend'=>'+15%','trend_up'=>true],
    ['icon'=>'bi-book-fill','bg'=>'var(--info-soft)','color'=>'var(--info)','val'=>$sesiSelesai,'label'=>'Sesi Selesai','bar'=>'90%','bar_color'=>'var(--info)','trend'=>'+31%','trend_up'=>true],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background:{{ $c['bg'] }};color:{{ $c['color'] }};"><i class="bi {{ $c['icon'] }}"></i></div>
                <div class="stat-trend {{ $c['trend_up'] ? 'trend-up' : 'trend-down' }}">
                    <i class="bi bi-arrow-{{ $c['trend_up'] ? 'up' : 'down' }}"></i> {{ $c['trend'] }}
                </div>
            </div>
            <div class="stat-value">{{ $c['val'] }}</div>
            <div class="stat-label">{{ $c['label'] }}</div>
            <div class="stat-bar-track">
                <div class="stat-bar-fill" style="width:{{ $c['bar'] }};background:{{ $c['bar_color'] }};"></div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ROW 2: Grafik + Status --}}
<div class="row g-3 mb-3">
    {{-- Grafik --}}
    <div class="col-12 col-xl-8">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Statistik Pengguna — 6 Bulan Terakhir</div>
                <div style="display:flex;gap:12px;font-size:12px;color:var(--muted);">
                    <span><span style="width:10px;height:10px;border-radius:2px;background:var(--primary);display:inline-block;margin-right:4px;"></span>Siswa</span>
                    <span><span style="width:10px;height:10px;border-radius:2px;background:var(--accent);display:inline-block;margin-right:4px;"></span>Tutor</span>
                    <span><span style="width:10px;height:10px;border-radius:2px;background:var(--success);display:inline-block;margin-right:4px;"></span>Les Selesai</span>
                </div>
            </div>
            <div class="p-4">
                <div class="bar-chart">
                    @php
                    $months = ['Nov','Des','Jan','Feb','Mar','Apr'];
                    $siswaH = [52,58,65,72,80,100];
                    $tutorH = [30,34,38,50,62,94];
                    $lesH = [60,66,72,78,85,96];
                    @endphp
                    @foreach($months as $i => $m)
                    <div class="bc-col">
                        <div class="bc-bar bc-primary" style="height:{{ $siswaH[$i] }}%"></div>
                        <div class="bc-label">{{ $m }}</div>
                    </div>
                    @endforeach
                    <div style="width:1px;background:var(--border);margin:0 8px;"></div>
                    @foreach($months as $i => $m)
                    <div class="bc-col">
                        <div class="bc-bar bc-accent" style="height:{{ $tutorH[$i] }}%"></div>
                        <div class="bc-label">{{ $m }}</div>
                    </div>
                    @endforeach
                    <div style="width:1px;background:var(--border);margin:0 8px;"></div>
                    @foreach($months as $i => $m)
                    <div class="bc-col">
                        <div class="bc-bar bc-success" style="height:{{ $lesH[$i] }}%"></div>
                        <div class="bc-label">{{ $m }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="row g-2 mt-1">
                    @foreach([['var(--primary)','Siswa Baru','12'],['var(--accent)','Tutor Baru','3'],['var(--success)','Retensi',84]] as $s)
                    <div class="col-4">
                        <div style="text-align:center;padding:10px;background:#f8fafc;border-radius:10px;">
                            <div style="font-size:17px;font-weight:800;color:{{ $s[0] }};">{{ $s[2] }}{{ is_numeric($s[2]) && $s[2]<50?'':'%' }}</div>
                            <div style="font-size:11px;color:var(--muted);">{{ $s[1] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Status Sistem --}}
    <div class="col-12 col-xl-4">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Status Sistem</div>
                <span class="pill p-success" style="font-size:11px;"><i class="bi bi-circle-fill"></i> Normal</span>
            </div>
            @php
            $statuses = [
            ['Web Server','99.9%','Online','green','p-success'],
            ['Database','12ms','Normal','green','p-success'],
            ['Storage','84%','Penuh','yellow','p-warning'],
            ['Email Service','100%','Online','green','p-success'],
            ];
            @endphp
            @foreach($statuses as $s)
            <div class="status-row">
                <div class="status-dot dot-{{ $s[3] }}"></div>
                <div style="flex:1;font-weight:600;color:var(--text);margin-left:10px;">{{ $s[0] }}</div>
                <div style="font-size:12px;color:var(--muted);margin-right:8px;">{{ $s[1] }}</div>
                <span class="pill {{ $s[4] }}" style="font-size:10.5px;">{{ $s[2] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ROW 3: Feed + Aksi Cepat --}}
<div class="row g-3 mb-3">
    {{-- Feed --}}
    <div class="col-12 col-xl-8">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Aktivitas Terbaru</div>
                <a href="#" style="font-size:12px;color:var(--primary);font-weight:600;text-decoration:none;">Lihat semua <i class="bi bi-arrow-right"></i></a>
            </div>
            @forelse($aktivitasTerbaru as $f)
            <div class="feed-item">
                <div class="feed-icon" style="background:{{ $f['bg'] }};color:{{ $f['color'] }};"><i class="bi {{ $f['icon'] }}"></i></div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $f['title'] }}</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:2px;">{{ $f['desc'] }}</div>
                </div>
                <div style="font-size:11px;color:var(--muted);flex-shrink:0;white-space:nowrap;">{{ $f['time'] }}</div>
            </div>
            @empty
            <div style="text-align:center;padding:24px;color:var(--muted);font-size:13px;">Belum ada aktivitas</div>
            @endforelse
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="col-12 col-xl-4">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Aksi Cepat</div>
            </div>
            <div class="qa-grid">
                @php
                $qaItems = [
                ['/admin/pengguna','bi-person-plus','#eff6ff','var(--primary)','Tambah User','Siswa / Tutor'],
                ['/admin/paket','bi-box-seam','var(--success-soft)','var(--success)','Kelola Paket','Layanan baru'],
                ['/admin/laporan','bi-bar-chart','var(--accent-soft)','var(--warning)','Lihat Laporan','Statistik sistem'],
                ['/admin/transaksi','bi-download','var(--info-soft)','var(--info)','Transaksi','Semua data bayar'],
                ['/admin/pembayaran','bi-cash-coin','var(--success-soft)','var(--success)','Gaji Tutor','Konfirmasi'],
                ['/admin/rekening','bi-bank','#f5f3ff','#6d28d9','Rekening Bank','Kelola rekening'],
                ];
                @endphp
                @foreach($qaItems as $q)
                <a href="{{ $q[0] }}" class="qa-btn">
                    <div class="qa-icon" style="background:{{ $q[2] }};color:{{ $q[3] }};"><i class="bi {{ $q[1] }}"></i></div>
                    <div>
                        <div class="qa-label">{{ $q[4] }}</div>
                        <div class="qa-sub">{{ $q[5] }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- TABEL PENGGUNA TERBARU --}}
<div class="card-box">
    <div class="card-box-header">
        <div class="card-box-title">Pengguna Terdaftar Terbaru <span style="font-size:12px;font-weight:500;color:var(--muted);">— 7 hari terakhir</span></div>
        <a href="/admin/pengguna" style="font-size:12px;color:var(--primary);font-weight:600;text-decoration:none;">Kelola semua <i class="bi bi-arrow-right"></i></a>
    </div>
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Peran</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penggunaTerbaru as $u)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div style="width:32px;height:32px;border-radius:8px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">
                                {{ strtoupper(substr($u->name,0,1)) }}
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:600;">{{ $u->name }}</div>
                                <div style="font-size:11px;color:var(--muted);">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="pill {{ $u->role === 'admin' ? 'p-danger' : ($u->role === 'tutor' ? 'p-warning' : 'p-primary') }}">{{ ucfirst($u->role) }}</span></td>
                    <td style="font-size:12.5px;color:var(--muted);">{{ $u->created_at->format('d M Y') }}</td>
                    <td><span class="pill p-success"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif</span></td>
                    <td>
                        <button style="border:1px solid var(--success);background:var(--success-soft);color:var(--success);border-radius:6px;padding:3px 10px;font-size:12px;font-weight:600;cursor:pointer;">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:32px;color:var(--muted);">Belum ada pengguna</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection