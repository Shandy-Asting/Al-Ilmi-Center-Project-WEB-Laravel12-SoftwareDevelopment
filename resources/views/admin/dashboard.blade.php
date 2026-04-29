@extends('layouts.app')

@section('title', 'Dashboard Admin - Al Ilmi Center')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Dashboard Admin')
@section('page-sub', 'Selamat datang di Panel Admin')

@section('sidebar-menu')
    <div class="menu-label">Manajemen</div>
    <a href="/admin/dashboard" class="nav-item-custom {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="/admin/pengguna" class="nav-item-custom {{ request()->is('admin/pengguna') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Pengguna
    </a>
    <a href="/admin/paket" class="nav-item-custom {{ request()->is('admin/paket') ? 'active' : '' }}">
        <i class="bi bi-star-fill"></i> Paket
    </a>
    <a href="/admin/transaksi" class="nav-item-custom {{ request()->is('admin/transaksi') ? 'active' : '' }}">
        <i class="bi bi-credit-card-fill"></i> Transaksi
    </a>
    <a href="/admin/laporan" class="nav-item-custom {{ request()->is('admin/laporan') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-fill"></i> Laporan
    </a>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">👑 Dashboard Admin</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Selamat datang di Panel Admin Al Ilmi Center</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['bi-people-fill','var(--primary-soft)','var(--primary)','Total Pengguna','128','+ 12 bulan ini'],
        ['bi-person-video3','var(--success-soft)','var(--success)','Total Tutor','24','+ 3 bulan ini'],
        ['bi-person-fill','var(--info-soft)','var(--info)','Total Siswa','104','+ 9 bulan ini'],
        ['bi-credit-card-fill','var(--accent-soft)','var(--warning)','Total Transaksi','Rp 8.4jt','+ 15% bulan ini'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-xl-3">
        <div style="background:var(--card-bg);border-radius:16px;padding:20px;border:1px solid var(--border);display:flex;gap:14px;align-items:flex-start;transition:transform .2s,box-shadow .2s;"
            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.08)'"
            onmouseout="this.style.transform='';this.style.boxShadow=''">
            <div style="width:46px;height:46px;border-radius:12px;background:{{ $s[1] }};color:{{ $s[2] }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">
                <i class="bi {{ $s[0] }}"></i>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;">{{ $s[1] }}</div>
                <div style="font-size:1.6rem;font-weight:800;color:var(--text);line-height:1;margin:4px 0;">{{ $s[3] }}</div>
                <div style="font-size:11.5px;color:var(--muted);">{{ $s[2] }}</div>
                <div style="font-size:11.5px;color:var(--success);font-weight:600;margin-top:4px;">{{ $s[4] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div style="background:var(--card-bg);border-radius:16px;border:1px solid var(--border);padding:20px;">
            <h6 class="fw-bold mb-3">📋 Pengguna Terbaru</h6>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg);">
                        <th style="padding:10px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border);">Nama</th>
                        <th style="padding:10px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border);">Role</th>
                        <th style="padding:10px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border);">Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\User::latest()->take(8)->get() as $u)
                    <tr onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background=''">
                        <td style="padding:11px 10px;border-bottom:1px solid var(--border);">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:8px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $u->name }}</div>
                                    <div style="font-size:11px;color:var(--muted);">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:11px 10px;border-bottom:1px solid var(--border);">
                            <span style="background:{{ $u->role === 'admin' ? 'var(--danger-soft)' : ($u->role === 'tutor' ? 'var(--success-soft)' : '#eff6ff') }};color:{{ $u->role === 'admin' ? 'var(--danger)' : ($u->role === 'tutor' ? 'var(--success)' : 'var(--primary)') }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td style="padding:11px 10px;border-bottom:1px solid var(--border);font-size:12px;color:var(--muted);">
                            {{ $u->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-4">
        <div style="background:var(--card-bg);border-radius:16px;border:1px solid var(--border);padding:20px;">
            <h6 class="fw-bold mb-3">⚡ Aksi Cepat</h6>
            <div class="d-flex flex-column gap-2">
                @php
                $aksi = [
                    ['/admin/pengguna','bi-people-fill','var(--primary)','Kelola Pengguna','Tambah & atur user'],
                    ['/admin/paket','bi-star-fill','var(--warning)','Kelola Paket','Atur paket berlangganan'],
                    ['/admin/transaksi','bi-credit-card-fill','var(--success)','Lihat Transaksi','Riwayat pembayaran'],
                    ['/admin/laporan','bi-bar-chart-fill','var(--info)','Buat Laporan','Export data sistem'],
                ];
                @endphp
                @foreach($aksi as $a)
                <a href="{{ $a[0] }}" style="display:flex;align-items:center;gap:12px;padding:12px;background:var(--bg);border-radius:10px;text-decoration:none;transition:all .2s;border:1px solid var(--border);"
                    onmouseover="this.style.background='#eff6ff';this.style.borderColor='var(--primary)'"
                    onmouseout="this.style.background='var(--bg)';this.style.borderColor='var(--border)'">
                    <div style="width:36px;height:36px;border-radius:8px;background:var(--card-bg);color:{{ $a[2] }};display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;border:1px solid var(--border);">
                        <i class="bi {{ $a[1] }}"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:var(--text);">{{ $a[2] }}</div>
                        <div style="font-size:11.5px;color:var(--muted);">{{ $a[3] }}</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color:var(--muted);font-size:13px;"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection