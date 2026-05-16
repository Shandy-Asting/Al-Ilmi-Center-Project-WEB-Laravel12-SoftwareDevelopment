@extends('layouts.app')

@section('title', 'Pembayaran & Gaji - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Pembayaran & Gaji Tutor')
@section('page-sub', 'Admin / Pembayaran & Gaji')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/admin/dashboard" class="nav-item-custom"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <div class="menu-label">Pengelolaan</div>
    <a href="/admin/pengguna" class="nav-item-custom"><i class="bi bi-people-fill"></i> Pengelolaan Pengguna</a>
    <a href="/admin/paket" class="nav-item-custom"><i class="bi bi-box-seam"></i> Pengelolaan Paket</a>
    <a href="/admin/transaksi" class="nav-item-custom"><i class="bi bi-credit-card-fill"></i> Transaksi</a>
    <a href="/admin/pembayaran" class="nav-item-custom active"><i class="bi bi-cash-coin"></i> Pembayaran & Gaji</a>
    <a href="/admin/rekening" class="nav-item-custom"><i class="bi bi-bank"></i> Rekening Bank</a>
    <a href="/admin/laporan" class="nav-item-custom"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
@endsection

@push('styles')
<style>
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:all .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .stat-val{font-size:1.4rem;font-weight:800;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}
    .main-tabs{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .main-tab{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .main-tab.active{background:var(--primary);color:#fff;}
    .main-tab:hover:not(.active){background:var(--bg);color:var(--primary);}
    .card-box{background:var(--card-bg);border-radius:14px;border:1px solid var(--border);overflow:hidden;}
    .card-box-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:14px;font-weight:700;color:var(--text);}
    .filter-bar{display:flex;gap:8px;flex-wrap:wrap;padding:12px 16px;border-bottom:1px solid var(--border);}
    .search-wrap{flex:1;min-width:180px;position:relative;}
    .search-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);}
    .search-wrap input{width:100%;padding:8px 12px 8px 32px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;outline:none;background:var(--bg);}
    .search-wrap input:focus{border-color:var(--primary);}
    .filter-select{padding:8px 28px 8px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:12.5px;background:var(--bg);color:var(--text);outline:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{background:#f8fafc;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;padding:10px 14px;border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:12px 14px;font-size:13px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#fafcff;}
    /* Gaji Card */
    .gaji-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:14px;padding:18px;margin-bottom:14px;transition:box-shadow .2s;}
    .gaji-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.07);}
    .gaji-card.pending-gaji{border-color:var(--accent);}
    .gc-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;margin-bottom:14px;}
    .tutor-av{width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;color:#fff;flex-shrink:0;}
    .gc-body{display:flex;align-items:flex-start;gap:14px;flex-wrap:wrap;}
    .gc-info{flex:1;min-width:160px;}
    .gc-actions{display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;}
    .btn-konfirm-gaji{border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;}
    /* MODAL */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;padding:16px;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:100%;max-width:520px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-head h5{font-size:15px;font-weight:800;}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .form-label-c{font-size:13px;font-weight:600;margin-bottom:6px;display:block;}
    .form-input-c{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;outline:none;background:#fff;transition:border .2s;}
    .form-input-c:focus{border-color:var(--primary);}
    .lightbox{display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;}
    .lightbox.show{display:flex;}
    @media(max-width:767px){.main-tabs{overflow-x:auto;flex-wrap:nowrap;}.main-tab{min-width:120px;flex:none;font-size:12px;}.gc-body{flex-direction:column;}.gc-actions{flex-direction:column;}.btn-konfirm-gaji{width:100%;}}
</style>
@endpush

@section('content')

{{-- ALERT --}}
@if(session('sukses'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
    <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:18px;"></i>
    <span style="font-size:13px;font-weight:600;color:var(--success);">{{ session('sukses') }}</span>
</div>
@endif

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">💰 Pembayaran & Gaji Tutor</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Monitor pembayaran siswa & konfirmasi gaji tutor</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $statPay = [
        ['bi-hourglass-split','var(--accent-soft)','var(--warning)','5','Pembayaran Menunggu'],
        ['bi-check-circle-fill','var(--success-soft)','var(--success)','128','Dikonfirmasi'],
        ['bi-cash-coin','var(--success-soft)','var(--success)','Rp 9.6Jt','Total Dikonfirmasi'],
        ['bi-person-video3','#eff6ff','var(--primary)','8','Gaji Tutor Belum Cair'],
    ];
    @endphp
    @foreach($statPay as $s)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div><div class="stat-val">{{ $s[3] }}</div><div class="stat-label">{{ $s[4] }}</div></div>
        </div>
    </div>
    @endforeach
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'pembayaran')">
        <i class="bi bi-receipt me-1"></i> Pembayaran Siswa
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">5</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'gaji')">
        <i class="bi bi-cash-coin me-1"></i> Gaji Tutor
        <span style="background:var(--accent);color:var(--primary);font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">8</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat
    </button>
</div>

{{-- ══ TAB PEMBAYARAN SISWA ══ --}}
<div id="tab-pembayaran">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-hourglass-split me-2" style="color:var(--warning);"></i>Pembayaran Menunggu Verifikasi Tutor</div>
            <span style="background:var(--accent-soft);color:var(--warning);font-size:12px;font-weight:700;padding:4px 12px;border-radius:20px;">5 Pending</span>
        </div>
        <div class="filter-bar">
            <div class="search-wrap"><i class="bi bi-search"></i><input type="text" placeholder="Cari siswa, tutor, ID…"/></div>
            <select class="filter-select"><option>Semua Tutor</option><option>Pak Budi Santoso</option><option>Bu Sari Dewi</option></select>
            <select class="filter-select"><option>Semua Bank</option><option>Bank BCA</option><option>Bank BRI</option><option>Bank Mandiri</option></select>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead><tr><th>ID</th><th>Siswa</th><th>Tutor</th><th>Layanan</th><th>Bank</th><th>Jumlah</th><th>Status Tutor</th><th>Masuk</th><th>Aksi</th></tr></thead>
                <tbody>
                @php
                $payList = [
                    ['PAY-0052','Andi Pratama','Pak Budi Santoso','Les Privat – Matematika','BCA','Rp 75.000','menunggu_verifikasi','2 jam lalu'],
                    ['PAY-0051','Siti Rahma','Bu Sari Dewi','Les Privat – Fisika','BRI','Rp 50.000','menunggu_verifikasi','5 jam lalu'],
                    ['PAY-0050','Maya Putri','Pak Budi Santoso','Les Privat – Kalkulus','BCA','Rp 100.000','menunggu_verifikasi','1 hari lalu'],
                    ['PAY-0049','Rizky Aditya','Pak Rizal Hakim','Les Privat – Kimia','Mandiri','Rp 75.000','menunggu_verifikasi','1 hari lalu'],
                    ['PAY-0048','Farhan Maulana','Bu Anisa Putri','Les Privat – Biologi','BCA','Rp 50.000','menunggu_verifikasi','2 hari lalu'],
                    ['PAY-0047','Aldi Pratama','Pak Budi Santoso','Les Privat – Trigonometri','BCA','Rp 75.000','dikonfirmasi','29 Apr 2026'],
                    ['PAY-0046','Sinta Dewi','Bu Sari Dewi','Les Privat – Newton','BRI','Rp 50.000','dikonfirmasi','28 Apr 2026'],
                    ['PAY-0044','Budi Kurnia','Bu Anisa Putri','Les Privat – Genetika','BCA','Rp 50.000','ditolak','26 Apr 2026'],
                ];
                @endphp
                @foreach($payList as $p)
                <tr>
                    <td style="font-weight:700;font-size:11.5px;color:var(--primary);">#{{ $p[0] }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:7px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">{{ substr($p[1],0,1) }}</div>
                            <span style="font-weight:600;font-size:12.5px;">{{ $p[1] }}</span>
                        </div>
                    </td>
                    <td style="font-size:12.5px;">{{ $p[2] }}</td>
                    <td style="font-size:12px;">{{ $p[3] }}</td>
                    <td><span style="background:{{ $p[4]==='BCA'?'#003087':($p[4]==='BRI'?'#004ea8':'#005e97') }};color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:5px;">{{ $p[4] }}</span></td>
                    <td style="font-weight:700;">{{ $p[5] }}</td>
                    <td>
                        @if($p[6]==='menunggu_verifikasi')
                        <span style="background:var(--accent-soft);color:var(--warning);font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;">⏳ Menunggu</span>
                        @elseif($p[6]==='dikonfirmasi')
                        <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:3px;"><i class="bi bi-check-circle-fill" style="font-size:9px;"></i> Lunas</span>
                        @else
                        <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;">❌ Ditolak</span>
                        @endif
                    </td>
                    <td style="font-size:12px;color:var(--muted);">{{ $p[7] }}</td>
                    <td>
                        <button onclick="openDetailPembayaran('{{ $p[0] }}')"
                            style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer;">
                            Detail
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══ TAB GAJI TUTOR ══ --}}
<div id="tab-gaji" style="display:none;">

    <div style="background:var(--accent-soft);border:1px solid var(--accent);border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:12px;">
        <i class="bi bi-info-circle-fill" style="color:var(--warning);font-size:18px;flex-shrink:0;"></i>
        <div>
            <div style="font-size:13.5px;font-weight:700;color:var(--text);margin-bottom:3px;">Cara Kerja Gaji Tutor</div>
            <div style="font-size:12.5px;color:var(--muted);line-height:1.6;">
                Setelah sesi les selesai dan pembayaran dikonfirmasi oleh tutor → Admin memverifikasi kelayakan → Admin konfirmasi pencairan gaji tutor → Nominal ditransfer ke rekening tutor yang terdaftar.
                <br/><strong>Komisi platform: 20%</strong> dari setiap sesi yang berhasil.
            </div>
        </div>
    </div>

    @php
    $gajiList = [
        ['Pak Budi Santoso','Matematika','3 sesi selesai','Rp 225.000','Rp 180.000','BCA – 1234567890','Mei 2026',true],
        ['Bu Sari Dewi','Fisika','2 sesi selesai','Rp 100.000','Rp 80.000','BRI – 0987654321','Mei 2026',true],
        ['Pak Rizal Hakim','Kimia','4 sesi selesai','Rp 300.000','Rp 240.000','Mandiri – 1122334455','Mei 2026',true],
        ['Bu Anisa Putri','Biologi','1 sesi selesai','Rp 50.000','Rp 40.000','BCA – 5566778899','Mei 2026',false],
        ['Pak Fauzan','B. Inggris','2 sesi selesai','Rp 100.000','Rp 80.000','BRI – 6677889900','Mei 2026',false],
    ];
    @endphp

    @foreach($gajiList as $g)
    <div class="gaji-card {{ $g[7] ? 'pending-gaji' : '' }}">
        <div class="gc-header">
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="tutor-av" style="background:var(--primary);">{{ strtoupper(substr($g[0],0,2)) }}</div>
                <div>
                    <div style="font-size:14px;font-weight:700;color:var(--text);">{{ $g[0] }}</div>
                    <div style="font-size:12px;color:var(--muted);"><i class="bi bi-book-fill me-1"></i>{{ $g[1] }}</div>
                </div>
            </div>
            @if($g[7])
            <span style="background:var(--accent-soft);color:var(--warning);font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:20px;">
                <i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi Admin
            </span>
            @else
            <span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:20px;">
                <i class="bi bi-check-circle-fill me-1"></i>Sudah Dibayar
            </span>
            @endif
        </div>
        <div class="gc-body">
            <div class="gc-info" style="background:var(--bg);border-radius:12px;padding:14px;">
                @foreach([['Periode','Mei 2026'],['Sesi Selesai',$g[2]],['Total Pendapatan',$g[3]],['Setelah Komisi 20%',$g[4].' (yang diterima tutor)'],['Rekening Tujuan',$g[5]]] as $r)
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);font-size:12.5px;">
                    <span style="color:var(--muted);">{{ $r[0] }}</span>
                    <span style="font-weight:600;color:var(--text);">{{ $r[1] }}</span>
                </div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding:10px 0 4px;font-size:14px;">
                    <span style="font-weight:700;color:var(--text);">Total Ditransfer</span>
                    <span style="font-weight:800;color:var(--success);font-size:16px;">{{ $g[4] }}</span>
                </div>
            </div>
        </div>
        @if($g[7])
        <div class="gc-actions">
            <button onclick="openModalTolakGaji('{{ $g[0] }}')"
                class="btn-konfirm-gaji" style="background:var(--danger-soft);color:var(--danger);">
                <i class="bi bi-x-circle me-1"></i> Tunda
            </button>
            <button onclick="konfirmasiGaji('{{ $g[0] }}','{{ $g[4] }}')"
                class="btn-konfirm-gaji" style="background:var(--primary);color:#fff;flex:2;box-shadow:0 3px 10px rgba(30,58,95,.25);">
                <i class="bi bi-check-circle-fill me-1"></i> Konfirmasi & Transfer Gaji {{ $g[4] }}
            </button>
        </div>
        @endif
    </div>
    @endforeach

</div>

{{-- ══ TAB RIWAYAT ══ --}}
<div id="tab-riwayat" style="display:none;">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-clock-history me-2" style="color:var(--primary);"></i>Riwayat Pembayaran & Gaji</div>
            <button onclick="window.print()"
                style="background:var(--danger-soft);color:var(--danger);border:1.5px solid var(--danger);border-radius:8px;font-size:12px;font-weight:600;padding:5px 12px;cursor:pointer;">
                <i class="bi bi-printer-fill me-1"></i> Cetak
            </button>
        </div>
        <div class="filter-bar">
            <div class="search-wrap"><i class="bi bi-search"></i><input type="text" placeholder="Cari ID, siswa, tutor…"/></div>
            <select class="filter-select"><option>Semua Jenis</option><option>Pembayaran Siswa</option><option>Gaji Tutor</option></select>
            <select class="filter-select"><option>Semua Status</option><option>Dikonfirmasi</option><option>Ditolak</option></select>
            <select class="filter-select"><option>Mei 2026</option><option>April 2026</option><option>Maret 2026</option></select>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead><tr><th>ID</th><th>Jenis</th><th>Dari / Untuk</th><th>Jumlah</th><th>Status</th><th>Tanggal</th></tr></thead>
                <tbody>
                @php
                $riwayatList = [
                    ['PAY-0047','Pembayaran Siswa','Aldi → Pak Budi','Rp 75.000','dikonfirmasi','29 Apr 2026'],
                    ['GAJ-0031','Gaji Tutor','Pak Budi Santoso','Rp 180.000','dibayar','28 Apr 2026'],
                    ['PAY-0046','Pembayaran Siswa','Sinta → Bu Sari','Rp 50.000','dikonfirmasi','28 Apr 2026'],
                    ['GAJ-0030','Gaji Tutor','Bu Sari Dewi','Rp 80.000','dibayar','27 Apr 2026'],
                    ['PAY-0044','Pembayaran Siswa','Budi → Bu Anisa','Rp 50.000','ditolak','26 Apr 2026'],
                    ['PAY-0043','Pembayaran Siswa','Nadia → Pak Fauzan','Rp 50.000','dikonfirmasi','25 Apr 2026'],
                    ['GAJ-0029','Gaji Tutor','Pak Rizal Hakim','Rp 240.000','dibayar','24 Apr 2026'],
                ];
                @endphp
                @foreach($riwayatList as $r)
                <tr>
                    <td style="font-weight:700;font-size:11.5px;color:var(--primary);">#{{ $r[0] }}</td>
                    <td>
                        @if(str_contains($r[0],'PAY'))
                        <span style="background:#eff6ff;color:var(--primary);font-size:11.5px;font-weight:700;padding:3px 9px;border-radius:20px;"><i class="bi bi-credit-card-fill me-1"></i>Bayar Siswa</span>
                        @else
                        <span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:3px 9px;border-radius:20px;"><i class="bi bi-cash-coin me-1"></i>Gaji Tutor</span>
                        @endif
                    </td>
                    <td style="font-size:12.5px;font-weight:600;">{{ $r[2] }}</td>
                    <td style="font-weight:700;">{{ $r[3] }}</td>
                    <td>
                        @if(in_array($r[4],['dikonfirmasi','dibayar']))
                        <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:3px;"><i class="bi bi-check-circle-fill" style="font-size:9px;"></i>{{ $r[4]==='dibayar'?'Dibayar':'Dikonfirmasi' }}</span>
                        @else
                        <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;">❌ Ditolak</span>
                        @endif
                    </td>
                    <td style="font-size:12px;color:var(--muted);">{{ $r[5] }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:12px 18px;border-top:1px solid var(--border);font-size:12.5px;color:var(--muted);">
            Menampilkan 7 dari 131 transaksi
        </div>
    </div>
</div>

{{-- MODAL DETAIL PEMBAYARAN --}}
<div class="modal-overlay" id="modal-detail-pay">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-info-circle-fill me-2" style="color:var(--primary);"></i>Detail Pembayaran</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-detail-pay').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            <div style="font-size:12px;font-weight:700;color:var(--primary);margin-bottom:14px;" id="dp-id">#PAY-0052</div>
            <div style="background:var(--bg);border-radius:12px;padding:14px;margin-bottom:14px;">
                @foreach([['Siswa','Andi Pratama'],['Tutor','Pak Budi Santoso'],['Layanan','Les Privat – Matematika'],['Bank','BCA – 1234567890'],['Jumlah','Rp 75.000'],['Status Tutor','Menunggu Verifikasi'],['Dikirim','2 jam lalu']] as $d)
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;">
                    <span style="color:var(--muted);">{{ $d[0] }}</span>
                    <span style="font-weight:600;">{{ $d[1] }}</span>
                </div>
                @endforeach
            </div>
            <div style="background:var(--bg);border-radius:10px;padding:28px;text-align:center;border:2px dashed var(--border);margin-bottom:14px;">
                <i class="bi bi-image" style="font-size:2.5rem;color:var(--muted);display:block;margin-bottom:6px;"></i>
                <div style="font-size:12px;color:var(--muted);">Foto bukti transfer akan tampil setelah backend terhubung</div>
            </div>
            <div style="background:var(--accent-soft);border-radius:10px;padding:12px 14px;font-size:12px;color:#92400e;margin-bottom:16px;">
                <i class="bi bi-info-circle-fill me-1"></i>
                <strong>Info Admin:</strong> Konfirmasi pembayaran dilakukan oleh tutor. Admin hanya memonitor dan menindaklanjuti jika ada kendala.
            </div>
            <button onclick="document.getElementById('modal-detail-pay').classList.remove('show')"
                style="width:100%;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- MODAL TUNDA GAJI --}}
<div class="modal-overlay" id="modal-tunda-gaji">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-head">
            <h5><i class="bi bi-pause-circle-fill me-2" style="color:var(--warning);"></i>Tunda Pembayaran Gaji</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-tunda-gaji').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            <div style="background:var(--warning-soft);border-radius:10px;padding:12px;margin-bottom:14px;font-size:13px;color:var(--warning);">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Gaji tutor <strong id="tunda-nama">-</strong> akan ditunda. Tutor akan mendapat notifikasi.
            </div>
            <div class="mb-3">
                <label class="form-label-c">Alasan Penundaan <span style="color:var(--danger);">*</span></label>
                <textarea class="form-input-c" rows="3" placeholder="Contoh: Rekening tidak valid, perlu verifikasi dokumen, dll…"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button onclick="document.getElementById('modal-tunda-gaji').classList.remove('show')"
                    style="flex:1;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">Batal</button>
                <button onclick="document.getElementById('modal-tunda-gaji').classList.remove('show')"
                    style="flex:1;padding:10px;border-radius:10px;border:none;background:var(--warning);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                    <i class="bi bi-pause-circle me-1"></i> Tunda
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SUKSES GAJI --}}
<div class="modal-overlay" id="modal-sukses-gaji">
    <div class="modal-box" style="max-width:420px;">
        <div style="padding:32px 28px;text-align:center;">
            <div style="font-size:60px;margin-bottom:14px;">✅</div>
            <div style="font-size:20px;font-weight:800;margin-bottom:6px;">Gaji Berhasil Dikonfirmasi!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.6;" id="sukses-gaji-pesan">
                Gaji tutor berhasil dikonfirmasi. Tutor akan mendapat notifikasi transfer.
            </div>
            <div style="background:var(--success-soft);border-radius:12px;padding:14px;margin-bottom:20px;text-align:left;">
                <div style="font-size:12px;color:var(--success);font-weight:700;">
                    <i class="bi bi-check-circle-fill me-1"></i> Transfer ke rekening tutor sedang diproses
                </div>
            </div>
            <button onclick="document.getElementById('modal-sukses-gaji').classList.remove('show')"
                style="width:100%;padding:10px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                OK, Mengerti
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(el, id) {
    document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    ['pembayaran','gaji','riwayat'].forEach(t => {
        document.getElementById('tab-'+t).style.display = t === id ? '' : 'none';
    });
}
function openDetailPembayaran(id) {
    document.getElementById('dp-id').textContent = '#' + id;
    document.getElementById('modal-detail-pay').classList.add('show');
}
function openModalTolakGaji(nama) {
    document.getElementById('tunda-nama').textContent = nama;
    document.getElementById('modal-tunda-gaji').classList.add('show');
}
function konfirmasiGaji(nama, jumlah) {
    if(!confirm('Konfirmasi transfer gaji ' + jumlah + ' untuk ' + nama + '?')) return;
    document.getElementById('sukses-gaji-pesan').innerHTML =
        'Gaji <strong>' + nama + '</strong> sebesar <strong>' + jumlah + '</strong> berhasil dikonfirmasi. Transfer sedang diproses.';
    document.getElementById('modal-sukses-gaji').classList.add('show');
}
</script>
@endpush