@extends('layouts.app')

@section('title', 'Pembayaran - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Pembayaran')
@section('page-sub', 'Dashboard / Pembayaran')

@section('sidebar-menu')
    <div class="menu-label">Menu Utama</div>
    <a href="/siswa/dashboard" class="nav-item-custom {{ request()->is('siswa/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="/siswa/belajar-tka" class="nav-item-custom {{ request()->is('siswa/belajar-tka') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Belajar TKA
        <span class="nav-badge">Baru</span>
    </a>
    <a href="/siswa/les-privat" class="nav-item-custom {{ request()->is('siswa/les-privat') ? 'active' : '' }}">
        <i class="bi bi-person-video3"></i> Les Privat
    </a>
    <a href="/siswa/hasil-progres" class="nav-item-custom {{ request()->is('siswa/hasil-progres') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line-fill"></i> Hasil & Progres
    </a>
    <div class="menu-label">Akun</div>
    <a href="/siswa/pembayaran" class="nav-item-custom {{ request()->is('siswa/pembayaran') ? 'active' : '' }}">
        <i class="bi bi-credit-card-fill"></i> Pembayaran
    </a>
    <a href="/siswa/notifikasi" class="nav-item-custom {{ request()->is('siswa/notifikasi') ? 'active' : '' }}">
        <i class="bi bi-bell-fill"></i> Notifikasi
        <span class="nav-badge">3</span>
    </a>
    <a href="/siswa/profil" class="nav-item-custom {{ request()->is('siswa/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
<style>
    /* ── TABS ── */
    .main-tabs{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:6px;margin:0 0 24px;}
    .main-tab{flex:1;text-align:center;padding:9px 10px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .main-tab.active{background:var(--primary);color:#fff;box-shadow:0 3px 10px rgba(30,58,95,.25);}
    .main-tab:hover:not(.active){background:var(--bg);color:var(--primary);}

    /* ── STAT CARDS ── */
    .stat-card{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:18px;height:100%;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.07);}
    .stat-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:12px;}
    .stat-val{font-size:20px;font-weight:800;line-height:1;margin-bottom:4px;color:var(--text);}
    .stat-label{font-size:12px;color:var(--muted);}

    /* ── SALDO CARD ── */
    .saldo-card{background:linear-gradient(135deg,var(--primary) 0%,var(--primary-light) 60%,#3b6fa0 100%);border-radius:20px;padding:24px 28px;color:#fff;position:relative;overflow:hidden;}
    .saldo-card::before{content:'';position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.07);}
    .saldo-card::after{content:'';position:absolute;bottom:-50px;left:60px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.05);}
    .sc-label{font-size:12px;font-weight:600;opacity:.75;margin-bottom:6px;position:relative;z-index:1;}
    .sc-amount{font-size:34px;font-weight:800;line-height:1;position:relative;z-index:1;}
    .sc-sub{font-size:12px;opacity:.65;margin-top:4px;position:relative;z-index:1;}
    .sc-actions{display:flex;gap:8px;margin-top:16px;position:relative;z-index:1;}
    .sc-btn{flex:1;padding:9px;border:none;border-radius:10px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .2s;}

    /* ── TAGIHAN CARD ── */
    .tagihan-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:16px;overflow:hidden;margin-bottom:14px;transition:box-shadow .2s;}
    .tagihan-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);}
    .tagihan-card.urgent{border-color:#fca5a5;}
    .tagihan-header{padding:12px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);}
    .tagihan-header.urgent{background:#fef2f2;}
    .tagihan-header.normal{background:#f8faff;}
    .tagihan-id{font-size:11.5px;font-weight:700;color:var(--muted);}
    .tagihan-body{padding:16px 18px;}
    .tagihan-row{display:flex;align-items:center;gap:14px;}
    .tagihan-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
    .ti-title{font-size:14px;font-weight:700;color:var(--text);}
    .ti-sub{font-size:12px;color:var(--muted);margin-top:2px;}
    .ti-due{font-size:12px;font-weight:700;margin-top:4px;}
    .tagihan-amount{margin-left:auto;text-align:right;flex-shrink:0;}
    .ta-val{font-size:20px;font-weight:800;}
    .ta-label{font-size:11px;color:var(--muted);}
    .tagihan-footer{padding:12px 18px;background:var(--bg);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:700;}
    .btn-bayar{border:none;border-radius:10px;padding:8px 22px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;}

    /* ── METODE PEMBAYARAN ── */
    .metode-card{background:var(--card-bg);border:2px solid var(--border);border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;cursor:pointer;transition:all .2s;margin-bottom:10px;}
    .metode-card:hover{border-color:var(--primary-light);}
    .metode-card.selected{border-color:var(--primary);background:#eff6ff;}
    .metode-logo{width:48px;height:30px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;flex-shrink:0;}
    .metode-name{font-size:13px;font-weight:700;color:var(--text);}
    .metode-sub{font-size:11.5px;color:var(--muted);}
    .metode-check{margin-left:auto;width:20px;height:20px;border-radius:50%;border:2px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .metode-card.selected .metode-check{background:var(--primary);border-color:var(--primary);color:#fff;}

    /* ── RIWAYAT ── */
    .trx-row{display:flex;align-items:center;gap:14px;padding:13px 0;border-bottom:1px solid var(--border);}
    .trx-row:last-child{border-bottom:none;padding-bottom:0;}
    .trx-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
    .ti-date{font-size:11px;color:var(--muted);margin-top:2px;}
    .trx-amount{margin-left:auto;text-align:right;flex-shrink:0;}
    .trx-amount .ta-val{font-size:15px;font-weight:800;}
    .ta-status{font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:6px;margin-top:3px;display:inline-block;}

    /* ── COUNTDOWN ── */
    .countdown-box{background:linear-gradient(135deg,#fef2f2,#fff5f5);border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:12px;margin-bottom:14px;}
    .cd-timer{font-size:22px;font-weight:800;color:var(--danger);}
    .cd-label{font-size:12.5px;color:#dc2626;}

    /* ── MODAL ── */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:90%;max-width:480px;max-height:90vh;overflow-y:auto;animation:fadeIn .25s ease;}
    @keyframes fadeIn{from{transform:scale(.93);opacity:0;}to{transform:scale(1);opacity:1;}}
    .modal-head{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-head h5{font-size:16px;font-weight:800;color:var(--text);}
    .modal-close{width:32px;height:32px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--muted);}
    .modal-body-p{padding:22px 24px;}
    .invoice-divider{border:none;border-top:1px dashed var(--border);margin:14px 0;}
    .invoice-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:8px;}
    .invoice-row .ir-label{color:var(--muted);}
    .invoice-row .ir-val{font-weight:600;color:var(--text);}
    .invoice-total{display:flex;justify-content:space-between;padding:12px 0;border-top:1.5px solid var(--text);border-bottom:1.5px solid var(--text);margin:8px 0;}
    .invoice-total .it-label{font-size:14px;font-weight:800;color:var(--text);}
    .invoice-total .it-val{font-size:18px;font-weight:800;color:var(--primary);}
    .btn-modal{width:100%;padding:11px;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;}

    /* CARD BOX */
    .card-box{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;}
    .section-title{font-size:15px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;justify-content:space-between;}
    .section-title a{font-size:12px;color:var(--primary);text-decoration:none;font-weight:600;}
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-1">💳 Pembayaran</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Pembayaran</span>
        </div>
    </div>
    <button class="btn btn-sm fw-bold px-3 py-2"
        style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:12px;"
        onclick="openInvoiceModal()">
        <i class="bi bi-file-earmark-text me-1"></i> Lihat Invoice
    </button>
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'tagihan')">
        <i class="bi bi-receipt me-1"></i> Informasi Tagihan
    </button>
    <button class="main-tab" onclick="switchTab(this,'status')">
        <i class="bi bi-activity me-1"></i> Status Pembayaran
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat Transaksi
    </button>
</div>

{{-- ══ TAB: TAGIHAN ══ --}}
<div id="tab-tagihan">
    <div class="row g-3 mb-4">

        {{-- SALDO + STAT --}}
        <div class="col-lg-5">
            <div class="saldo-card mb-3">
                <div class="sc-label">Saldo Al Ilmi Center</div>
                <div class="sc-amount">Rp 150.000</div>
                <div class="sc-sub">Dapat digunakan untuk pembayaran layanan</div>
                <div class="sc-actions">
                    <button class="sc-btn" style="background:rgba(255,255,255,.2);color:#fff;">
                        <i class="bi bi-plus-lg me-1"></i> Top Up
                    </button>
                    <button class="sc-btn" style="background:#fff;color:var(--primary);">
                        <i class="bi bi-arrow-right me-1"></i> Gunakan
                    </button>
                </div>
            </div>
            <div class="row g-2">
                @php
                $stats = [
                    ['var(--danger-soft)','var(--danger)','bi-exclamation-triangle-fill','2','Tagihan Belum Lunas','var(--danger)'],
                    ['var(--success-soft)','var(--success)','bi-check-circle-fill','8','Tagihan Lunas','var(--success)'],
                    ['#eff6ff','var(--primary)','bi-currency-dollar','Rp 275rb','Total Tagihan Aktif','var(--primary)'],
                    ['var(--info-soft)','var(--info)','bi-calendar3','8 Apr','Jatuh Tempo Terdekat','var(--info)'],
                ];
                @endphp
                @foreach($stats as $s)
                <div class="col-6">
                    <div class="stat-card" style="padding:16px;">
                        <div class="stat-icon" style="background:{{ $s[0] }};color:{{ $s[1] }};width:38px;height:38px;font-size:16px;margin-bottom:10px;">
                            <i class="bi {{ $s[2] }}"></i>
                        </div>
                        <div class="stat-val" style="font-size:18px;color:{{ $s[5] }};">{{ $s[3] }}</div>
                        <div class="stat-label">{{ $s[4] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TAGIHAN AKTIF --}}
        <div class="col-lg-7">
            <div class="section-title"><span>🔔 Tagihan Perlu Dibayar</span></div>

            <div class="countdown-box">
                <i class="bi bi-alarm-fill" style="font-size:22px;color:var(--danger);"></i>
                <div>
                    <div class="cd-timer" id="countdown">01:48:22</div>
                    <div class="cd-label">Batas waktu pembayaran <strong>#INV-2026-0412</strong> — segera selesaikan!</div>
                </div>
            </div>

            {{-- Tagihan 1 --}}
            <div class="tagihan-card urgent">
                <div class="tagihan-header urgent">
                    <span class="tagihan-id">#INV-2026-0412</span>
                    <span class="status-badge" style="background:var(--danger-soft);color:var(--danger);">
                        <i class="bi bi-clock-fill"></i> Segera Dibayar
                    </span>
                </div>
                <div class="tagihan-body">
                    <div class="tagihan-row">
                        <div class="tagihan-icon" style="background:#eff6ff;color:var(--primary);">
                            <i class="bi bi-person-video3"></i>
                        </div>
                        <div class="tagihan-info">
                            <div class="ti-title">Les Privat – Matematika (Online)</div>
                            <div class="ti-sub">Pak Budi Santoso · Selasa, 8 Apr · 11:00 WIB</div>
                            <div class="ti-due" style="color:var(--danger);">
                                <i class="bi bi-exclamation-circle me-1"></i>Jatuh tempo: 8 Apr 2026, 13:00 WIB
                            </div>
                        </div>
                        <div class="tagihan-amount">
                            <div class="ta-val" style="color:var(--danger);">Rp 75.000</div>
                            <div class="ta-label">Belum Lunas</div>
                        </div>
                    </div>
                </div>
                <div class="tagihan-footer">
                    <div style="font-size:12px;color:var(--muted);">
                        <i class="bi bi-shield-check me-1"></i>Pembayaran aman & terenkripsi
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn-bayar" style="background:var(--bg);color:var(--muted);" onclick="openInvoiceModal()">Invoice</button>
                        <button class="btn-bayar" style="background:var(--danger);color:#fff;box-shadow:0 4px 12px rgba(220,38,38,.3);" onclick="openBayarModal()">Bayar Sekarang</button>
                    </div>
                </div>
            </div>

            {{-- Tagihan 2 --}}
            <div class="tagihan-card">
                <div class="tagihan-header normal">
                    <span class="tagihan-id">#INV-2026-0418</span>
                    <span class="status-badge" style="background:var(--accent-soft);color:var(--warning);">
                        <i class="bi bi-hourglass-split"></i> Menunggu Bayar
                    </span>
                </div>
                <div class="tagihan-body">
                    <div class="tagihan-row">
                        <div class="tagihan-icon" style="background:var(--success-soft);color:var(--success);">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="tagihan-info">
                            <div class="ti-title">Paket Berlangganan – Pro (Bulan Ini)</div>
                            <div class="ti-sub">Periode: 1 – 30 April 2026</div>
                            <div class="ti-due" style="color:var(--warning);">
                                <i class="bi bi-calendar3 me-1"></i>Jatuh tempo: 15 Apr 2026
                            </div>
                        </div>
                        <div class="tagihan-amount">
                            <div class="ta-val" style="color:var(--primary);">Rp 199.000</div>
                            <div class="ta-label">Belum Lunas</div>
                        </div>
                    </div>
                </div>
                <div class="tagihan-footer">
                    <div style="font-size:12px;color:var(--muted);">
                        <i class="bi bi-info-circle me-1"></i>Perpanjang otomatis aktif
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn-bayar" style="background:var(--bg);color:var(--muted);" onclick="openInvoiceModal()">Invoice</button>
                        <button class="btn-bayar" style="background:var(--primary);color:#fff;box-shadow:0 4px 12px rgba(30,58,95,.3);" onclick="openBayarModal()">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- METODE PEMBAYARAN --}}
    <div class="card-box">
        <div class="section-title">
            <span>💳 Metode Pembayaran Tersimpan</span>
            <a href="#" onclick="openBayarModal();return false;">+ Tambah Metode</a>
        </div>
        <div class="row g-3">
            @php
            $metodes = [
                ['#003087','#fff','BCA','Bank BCA','Virtual Account · ****1234',true],
                ['#00a850','#fff','GP','GoPay','Dompet Digital · +62 812****78',false],
                ['#6b21a8','#fff','OVO','OVO','Dompet Digital · +62 812****78',false],
                ['var(--primary)','#fff','SALDO','Saldo Al Ilmi','Rp 150.000 tersedia',false],
            ];
            @endphp
            @foreach($metodes as $m)
            <div class="col-md-6">
                <div class="metode-card {{ $m[5] ? 'selected' : '' }}" onclick="selectMetode(this)">
                    <div class="metode-logo" style="background:{{ $m[0] }};color:{{ $m[1] }};">{{ $m[2] }}</div>
                    <div>
                        <div class="metode-name">{{ $m[3] }}</div>
                        <div class="metode-sub">{{ $m[4] }}</div>
                    </div>
                    <div class="metode-check">
                        @if($m[5])<i class="bi bi-check-lg" style="font-size:12px;"></i>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══ TAB: STATUS ══ --}}
<div id="tab-status" style="display:none;">
    <div class="row g-3 mb-4">
        @php
        $statusStats = [
            ['var(--success-soft)','var(--success)','bi-check-circle-fill','8','Lunas','var(--success)'],
            ['var(--accent-soft)','var(--warning)','bi-hourglass-split','2','Menunggu','var(--warning)'],
            ['var(--danger-soft)','var(--danger)','bi-x-circle-fill','1','Kedaluwarsa','var(--danger)'],
            ['#eff6ff','var(--primary)','bi-arrow-repeat','3','Diproses','var(--primary)'],
        ];
        @endphp
        @foreach($statusStats as $s)
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon mx-auto" style="background:{{ $s[0] }};color:{{ $s[1] }};">
                    <i class="bi {{ $s[2] }}"></i>
                </div>
                <div class="stat-val" style="color:{{ $s[5] }};">{{ $s[3] }}</div>
                <div class="stat-label">{{ $s[4] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card-box">
        <div class="section-title">
            <span>📋 Status Semua Pembayaran</span>
            <select class="form-select form-select-sm" style="font-size:12px;border-radius:8px;width:auto;">
                <option>Semua Status</option>
                <option>Lunas</option><option>Menunggu</option>
                <option>Diproses</option><option>Kedaluwarsa</option>
            </select>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg);">
                        @foreach(['ID Transaksi','Layanan','Tanggal','Jumlah','Status','Aksi'] as $h)
                        <th style="padding:10px 14px;font-size:11.5px;font-weight:700;color:var(--muted);text-align:{{ in_array($h,['Jumlah','Status','Aksi']) ? 'center' : 'left' }};border-bottom:1.5px solid var(--border);">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @php
                $rows = [
                    ['#INV-2026-0412','Les Privat – Matematika','8 Apr 2026','Rp 75.000','var(--danger-soft)','var(--danger)','Segera Bayar','bayar'],
                    ['#INV-2026-0418','Paket Pro – April 2026','15 Apr 2026','Rp 199.000','var(--accent-soft)','var(--warning)','Menunggu','bayar'],
                    ['#INV-2026-0398','Les Privat – Fisika','28 Mar 2026','Rp 90.000','#eff6ff','var(--primary)','Diproses','invoice'],
                    ['#INV-2026-0380','Paket Pro – Maret 2026','1 Mar 2026','Rp 199.000','var(--success-soft)','var(--success)','Lunas','invoice'],
                    ['#INV-2026-0361','Les Privat – Kimia','15 Feb 2026','Rp 75.000','var(--bg)','var(--muted)','Kedaluwarsa','detail'],
                ];
                @endphp
                @foreach($rows as $r)
                <tr style="transition:background .15s;" onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background=''">
                    <td style="padding:12px 14px;font-size:12.5px;font-weight:700;border-bottom:1px solid var(--border);">{{ $r[0] }}</td>
                    <td style="padding:12px 14px;font-size:13px;border-bottom:1px solid var(--border);">{{ $r[1] }}</td>
                    <td style="padding:12px 14px;font-size:12.5px;color:var(--muted);border-bottom:1px solid var(--border);">{{ $r[2] }}</td>
                    <td style="padding:12px 14px;font-size:13px;font-weight:700;text-align:center;border-bottom:1px solid var(--border);">{{ $r[3] }}</td>
                    <td style="padding:12px 14px;text-align:center;border-bottom:1px solid var(--border);">
                        <span class="status-badge" style="background:{{ $r[4] }};color:{{ $r[5] }};">{{ $r[6] }}</span>
                    </td>
                    <td style="padding:12px 14px;text-align:center;border-bottom:1px solid var(--border);">
                        <button onclick="{{ $r[7] === 'bayar' ? 'openBayarModal()' : 'openInvoiceModal()' }}"
                            style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 14px;font-size:12px;font-weight:700;cursor:pointer;">
                            {{ $r[7] === 'bayar' ? 'Bayar' : ($r[7] === 'invoice' ? 'Invoice' : 'Detail') }}
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══ TAB: RIWAYAT ══ --}}
<div id="tab-riwayat" style="display:none;">
    <div class="row g-3 mb-4">
        @php
        $rwStats = [
            ['var(--success-soft)','var(--success)','bi-arrow-down-circle-fill','Rp 643rb','Total Dibayar Bulan Ini'],
            ['#eff6ff','var(--primary)','bi-receipt-cutoff','11','Total Transaksi Bulan Ini'],
            ['var(--info-soft)','var(--info)','bi-piggy-bank-fill','Rp 2jt','Total Transaksi Tahun Ini'],
        ];
        @endphp
        @foreach($rwStats as $s)
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:{{ $s[0] }};color:{{ $s[1] }};"><i class="bi {{ $s[2] }}"></i></div>
                <div class="stat-val" style="color:{{ $s[1] }};">{{ $s[3] }}</div>
                <div class="stat-label">{{ $s[4] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex gap-2 mb-3 flex-wrap">
        <div style="position:relative;flex:1;min-width:200px;">
            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px;"></i>
            <input type="text" style="border:1.5px solid var(--border);border-radius:10px;padding:8px 14px 8px 36px;font-size:13px;width:100%;outline:none;" placeholder="Cari ID, layanan…"/>
        </div>
        <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
            <option>Semua Jenis</option>
            <option>Les Privat</option>
            <option>Paket Berlangganan</option>
        </select>
        <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
            <option>April 2026</option>
            <option>Maret 2026</option>
        </select>
        <button class="btn btn-sm fw-bold" style="background:var(--card-bg);border:1.5px solid var(--border);border-radius:8px;font-size:12px;color:var(--muted);">
            <i class="bi bi-download me-1"></i> Export
        </button>
    </div>

    @php
    $months = [
        'April 2026' => [
            ['#eff6ff','var(--primary)','bi-person-video3','Les Privat – Matematika (Online)','Pak Budi Santoso · #INV-2026-0412','8 Apr 2026 · BCA','- Rp 75.000','var(--danger)','var(--danger-soft)','Belum Lunas'],
            ['var(--success-soft)','var(--success)','bi-stars','Paket Pro – April 2026','Berlangganan Bulanan · #INV-2026-0418','1 Apr 2026 · GoPay','- Rp 199.000','var(--danger)','var(--accent-soft)','Menunggu'],
            ['var(--info-soft)','var(--info)','bi-arrow-down-circle-fill','Top Up Saldo Al Ilmi','Transfer BCA · #TOP-2026-0092','2 Apr 2026 · 09:14','+ Rp 200.000','var(--success)','var(--success-soft)','Berhasil'],
        ],
        'Maret 2026' => [
            ['#eff6ff','var(--primary)','bi-person-video3','Les Privat – Fisika (Tatap Muka)','Bu Sari Dewi · #INV-2026-0398','28 Mar 2026 · OVO','- Rp 120.000','var(--danger)','var(--success-soft)','Lunas'],
            ['var(--success-soft)','var(--success)','bi-stars','Paket Pro – Maret 2026','Berlangganan Bulanan · #INV-2026-0380','1 Mar 2026 · GoPay','- Rp 199.000','var(--danger)','var(--success-soft)','Lunas'],
        ],
    ];
    @endphp

    @foreach($months as $month => $trxs)
    <div style="font-size:12px;font-weight:700;color:var(--muted);margin-bottom:8px;letter-spacing:.04em;text-transform:uppercase;">{{ $month }}</div>
    <div class="card-box mb-3">
        @foreach($trxs as $t)
        <div class="trx-row">
            <div class="trx-icon" style="background:{{ $t[0] }};color:{{ $t[1] }};"><i class="bi {{ $t[2] }}"></i></div>
            <div>
                <div style="font-size:13px;font-weight:700;color:var(--text);">{{ $t[3] }}</div>
                <div style="font-size:11.5px;color:var(--muted);">{{ $t[4] }}</div>
                <div class="ti-date"><i class="bi bi-calendar3 me-1"></i>{{ $t[5] }}</div>
            </div>
            <div class="trx-amount">
                <div class="ta-val" style="color:{{ $t[7] }};">{{ $t[6] }}</div>
                <span class="ta-status" style="background:{{ $t[8] }};color:{{ $t[7] }};">{{ $t[9] }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    <div class="d-flex justify-content-center gap-2">
        @foreach(['<i class="bi bi-chevron-left"></i>','1','2','3','<i class="bi bi-chevron-right"></i>'] as $p)
        <button style="border-radius:8px;{{ $p === '1' ? 'background:var(--primary);color:#fff;border:none;' : 'background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);' }}font-size:12px;font-weight:700;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;">{!! $p !!}</button>
        @endforeach
    </div>
</div>

{{-- ══ MODAL INVOICE ══ --}}
<div class="modal-overlay" id="modal-invoice">
    <div class="modal-box">
        <div class="modal-head">
            <h5>🧾 Invoice Pembayaran</h5>
            <button class="modal-close" onclick="closeModal('modal-invoice')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-p">
            <div class="text-center mb-3">
                <div style="font-size:20px;font-weight:800;color:var(--primary);">Al Ilmi Center</div>
                <div style="font-size:11px;color:var(--muted);">Platform Bimbel Online Terpercaya</div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--muted);margin-bottom:8px;">
                <span>No. Invoice: <strong style="color:var(--text);">#INV-2026-0412</strong></span>
                <span>Tgl: <strong style="color:var(--text);">8 Apr 2026</strong></span>
            </div>
            <div style="background:var(--bg);border-radius:10px;padding:12px 14px;font-size:12.5px;margin-bottom:12px;">
                <div style="margin-bottom:4px;"><strong>Kepada:</strong> Andi Pratama</div>
                <div style="color:var(--muted);">Siswa · Kediri, Jawa Timur</div>
            </div>
            <hr class="invoice-divider"/>
            @php
            $invoiceRows = [
                ['Layanan','Les Privat – Matematika'],
                ['Tutor','Pak Budi Santoso, S.Pd'],
                ['Jadwal','Selasa, 8 Apr · 11:00 WIB'],
                ['Durasi','90 Menit'],
                ['Jenis','Online (Zoom/Meet)'],
            ];
            @endphp
            @foreach($invoiceRows as $ir)
            <div class="invoice-row"><span class="ir-label">{{ $ir[0] }}</span><span class="ir-val">{{ $ir[1] }}</span></div>
            @endforeach
            <hr class="invoice-divider"/>
            <div class="invoice-row"><span class="ir-label">Subtotal</span><span class="ir-val">Rp 75.000</span></div>
            <div class="invoice-row"><span class="ir-label">Biaya Layanan</span><span class="ir-val">Rp 2.000</span></div>
            <div class="invoice-row"><span class="ir-label">Diskon Member</span><span class="ir-val" style="color:var(--success);">- Rp 2.000</span></div>
            <div class="invoice-total">
                <span class="it-label">TOTAL BAYAR</span>
                <span class="it-val">Rp 75.000</span>
            </div>
            <div class="text-center mt-3">
                <span class="status-badge" style="background:var(--danger-soft);color:var(--danger);font-size:12px;">
                    <i class="bi bi-exclamation-circle me-1"></i>Belum Lunas — Jatuh tempo 8 Apr 2026
                </span>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn-modal" style="background:var(--bg);color:var(--muted);flex:1;" onclick="closeModal('modal-invoice')">Tutup</button>
                <button class="btn-modal" style="background:var(--primary);color:#fff;flex:1;" onclick="closeModal('modal-invoice');openBayarModal();">Bayar Sekarang</button>
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL BAYAR ══ --}}
<div class="modal-overlay" id="modal-bayar">
    <div class="modal-box">
        <div class="modal-head">
            <h5>💳 Pilih Metode Pembayaran</h5>
            <button class="modal-close" onclick="closeModal('modal-bayar')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-p">
            <div style="background:var(--bg);border-radius:12px;padding:14px 16px;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <div style="font-size:13px;font-weight:700;color:var(--text);">Les Privat – Matematika</div>
                    <div style="font-size:12px;color:var(--muted);">#INV-2026-0412</div>
                </div>
                <div style="font-size:20px;font-weight:800;color:var(--primary);">Rp 75.000</div>
            </div>
            <div style="font-size:13px;font-weight:700;margin-bottom:10px;color:var(--text);">Pilih Metode:</div>
            @php
            $bayarMetodes = [
                ['#003087','#fff','BCA','Bank BCA','Virtual Account',true],
                ['#00a850','#fff','GP','GoPay','Scan QR',false],
                ['var(--primary)','#fff','SALDO','Saldo Al Ilmi','Tersedia: Rp 150.000',false],
            ];
            @endphp
            @foreach($bayarMetodes as $bm)
            <div class="metode-card {{ $bm[5] ? 'selected' : '' }}" onclick="selectMetodeBayar(this)" style="margin-bottom:8px;">
                <div class="metode-logo" style="background:{{ $bm[0] }};color:{{ $bm[1] }};">{{ $bm[2] }}</div>
                <div>
                    <div class="metode-name">{{ $bm[3] }}</div>
                    <div class="metode-sub">{{ $bm[4] }}</div>
                </div>
                <div class="metode-check">
                    @if($bm[5])<i class="bi bi-check-lg" style="font-size:12px;"></i>@endif
                </div>
            </div>
            @endforeach

            <div style="background:var(--accent-soft);border:1px solid var(--accent);border-radius:10px;padding:10px 14px;font-size:12.5px;color:var(--warning);margin:12px 0;">
                <i class="bi bi-clock me-1"></i> Selesaikan dalam <strong id="modal-timer">01:47:51</strong> sebelum pesanan dibatalkan
            </div>
            <div class="d-flex gap-2">
                <button class="btn-modal" style="background:var(--bg);color:var(--muted);flex:1;" onclick="closeModal('modal-bayar')">Batal</button>
                <button class="btn-modal" style="background:var(--success);color:#fff;flex:2;box-shadow:0 4px 12px rgba(22,163,74,.3);" onclick="bayarBerhasil()">
                    <i class="bi bi-shield-check me-1"></i> Konfirmasi Bayar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL SUKSES ══ --}}
<div class="modal-overlay" id="modal-sukses">
    <div class="modal-box">
        <div class="modal-body-p" style="text-align:center;padding:32px 28px;">
            <div style="font-size:56px;margin-bottom:12px;">🎉</div>
            <div style="font-size:18px;font-weight:800;margin-bottom:6px;color:var(--text);">Pembayaran Berhasil!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.6;">
                Pembayaran <strong>Rp 75.000</strong> untuk <strong>Les Privat Matematika</strong><br/>
                telah berhasil diproses. Invoice dikirim ke email kamu.
            </div>
            <div style="background:var(--success-soft);border-radius:12px;padding:14px;margin-bottom:20px;">
                <div style="font-size:12px;color:var(--success);font-weight:700;">
                    <i class="bi bi-check-circle-fill me-1"></i> ID Transaksi: #TXN-2026-08192
                </div>
                <div style="font-size:12px;color:var(--success);margin-top:4px;">Metode: Bank BCA Virtual Account</div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-modal" style="background:var(--bg);color:var(--muted);flex:1;" onclick="closeModal('modal-sukses')">Tutup</button>
                <button class="btn-modal" style="background:var(--primary);color:#fff;flex:1;" onclick="closeModal('modal-sukses')">Unduh Invoice</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(el, id) {
        document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        ['tagihan','status','riwayat'].forEach(t => {
            document.getElementById('tab-'+t).style.display = t === id ? '' : 'none';
        });
    }
    function selectMetode(el) {
        document.querySelectorAll('.metode-card').forEach(c => {
            c.classList.remove('selected');
            c.querySelector('.metode-check').innerHTML = '';
        });
        el.classList.add('selected');
        el.querySelector('.metode-check').innerHTML = '<i class="bi bi-check-lg" style="font-size:12px;"></i>';
    }
    function selectMetodeBayar(el) {
        document.querySelectorAll('#modal-bayar .metode-card').forEach(c => {
            c.classList.remove('selected');
            c.querySelector('.metode-check').innerHTML = '';
        });
        el.classList.add('selected');
        el.querySelector('.metode-check').innerHTML = '<i class="bi bi-check-lg" style="font-size:12px;"></i>';
    }
    function openInvoiceModal() { document.getElementById('modal-invoice').classList.add('show'); }
    function openBayarModal()   { document.getElementById('modal-bayar').classList.add('show'); }
    function closeModal(id)     { document.getElementById(id).classList.remove('show'); }
    function bayarBerhasil()    { closeModal('modal-bayar'); document.getElementById('modal-sukses').classList.add('show'); }

    let sec = 1 * 3600 + 48 * 60 + 22;
    function fmtTime(s) {
        const h = Math.floor(s/3600).toString().padStart(2,'0');
        const m = Math.floor((s%3600)/60).toString().padStart(2,'0');
        const ss = (s%60).toString().padStart(2,'0');
        return h+':'+m+':'+ss;
    }
    setInterval(() => {
        if(sec<=0) return;
        sec--;
        const el1 = document.getElementById('countdown');
        const el2 = document.getElementById('modal-timer');
        if(el1) el1.textContent = fmtTime(sec);
        if(el2) el2.textContent = fmtTime(sec);
    }, 1000);
</script>
@endpush