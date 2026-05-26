@extends('layouts.app')

@section('title', 'Transaksi - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Pengelolaan Transaksi')
@section('page-sub', 'Admin / Transaksi')

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
    .stat-card{background:var(--card-bg);border-radius:14px;padding:20px;border:1px solid var(--border);display:flex;align-items:center;gap:16px;transition:box-shadow .2s;}
    .stat-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.06);}
    .stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .stat-label{font-size:12px;color:var(--muted);font-weight:500;}
    .stat-value{font-size:22px;font-weight:800;color:var(--text);line-height:1.2;}
    .card-box{background:var(--card-bg);border-radius:14px;border:1px solid var(--border);overflow:hidden;}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;}
    .card-box-title{font-size:15px;font-weight:700;color:var(--text);}
    .filter-bar{display:flex;gap:8px;flex-wrap:wrap;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border);}
    .search-wrap{position:relative;flex:1;min-width:180px;}
    .search-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);}
    .search-wrap input{width:100%;padding:8px 12px 8px 32px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;outline:none;background:var(--bg);}
    .search-wrap input:focus{border-color:var(--primary);}
    .filter-select{padding:8px 28px 8px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:12.5px;background:var(--bg);color:var(--text);outline:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{background:#f8fafc;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;padding:10px 14px;border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:12px 14px;font-size:13px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#fafcff;}
    .tx-id{font-weight:700;color:var(--primary);font-size:12px;}
    .user-av{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;}
    .badge-stat{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;}
    .s-sukses{background:var(--success-soft);color:var(--success);}
    .s-pending{background:var(--warning-soft);color:var(--warning);}
    .s-gagal{background:var(--danger-soft);color:var(--danger);}
    .s-refund{background:var(--info-soft);color:var(--info);}
    .bar-track{height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
    .bar-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--primary-light),var(--accent));}
    /* MODAL */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;padding:16px;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:100%;max-width:460px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-head h5{font-size:15px;font-weight:800;}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .det-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);font-size:13.5px;}
    .det-row:last-child{border-bottom:none;}
    .det-k{color:var(--muted);font-weight:500;}
    .det-v{font-weight:600;}
    @media(max-width:767px){.filter-bar{flex-direction:column;}.search-wrap,.filter-select{width:100%;}.tbl{font-size:11.5px;}}
</style>
@endpush

@section('content')

<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">💳 Pengelolaan Transaksi</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Monitor semua transaksi pembayaran les privat</p>
    </div>
    <button style="background:var(--primary);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;padding:7px 14px;cursor:pointer;">
        <i class="bi bi-download me-1"></i> Export
    </button>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $stCards = [
        ['bi-arrow-left-right','var(--info-soft)','var(--info)','1.284','Total Transaksi','↑ 12% bulan ini'],
        ['bi-check-circle','var(--success-soft)','var(--success)','1.047','Berhasil','↑ 8% vs lalu'],
        ['bi-clock','var(--warning-soft)','var(--warning)','165','Pending','Perlu tindak lanjut'],
        ['bi-cash-stack','var(--accent-soft)','var(--warning)','Rp 48.7Jt','Total Pendapatan','↑ 15% bulan ini'],
    ];
    @endphp
    @foreach($stCards as $s)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div>
                <div class="stat-label">{{ $s[3] }}</div>
                <div class="stat-value">{{ $s[4] }}</div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:2px;">{{ $s[5] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-3">
    {{-- TABLE --}}
    <div class="col-12 col-xl-8">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Data Transaksi — Terbaru</div>
            </div>
            <div class="filter-bar">
                <div class="search-wrap"><i class="bi bi-search"></i><input type="text" placeholder="Cari transaksi…"/></div>
                <select class="filter-select"><option>Semua Status</option><option>Berhasil</option><option>Pending</option><option>Gagal</option></select>
                <select class="filter-select"><option>Semua Metode</option><option>Transfer Bank</option><option>QRIS</option></select>
            </div>
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead><tr><th>ID</th><th>Pengguna</th><th>Layanan</th><th>Metode</th><th>Jumlah</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @php
                    $txList = [
                        ['TRX-0041','Andi Pratama','var(--primary)','Les Privat – Matematika','Transfer BCA','Rp 75.000','sukses','02 Mei 2026'],
                        ['TRX-0040','Siti Rahma','#be185d','Les Privat – Fisika','QRIS','Rp 50.000','pending','02 Mei 2026'],
                        ['TRX-0039','Maya Putri','var(--success)','Les Privat – Kimia','Transfer BRI','Rp 75.000','sukses','01 Mei 2026'],
                        ['TRX-0038','Rizky Aditya','#b45309','Les Privat – B.Inggris','Transfer Mandiri','Rp 50.000','gagal','01 Mei 2026'],
                        ['TRX-0037','Farhan Maulana','#6d28d9','Les Privat – Biologi','QRIS','Rp 75.000','sukses','30 Apr 2026'],
                        ['TRX-0036','Nadia Putri','var(--danger)','Les Privat – Fisika','Transfer BCA','Rp 100.000','sukses','29 Apr 2026'],
                    ];
                    @endphp
                    @foreach($txList as $tx)
                    <tr>
                        <td><span class="tx-id">#{{ $tx[0] }}</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div class="user-av" style="background:{{ $tx[2] }};color:#fff;">{{ substr($tx[1],0,1) }}</div>
                                <span style="font-weight:600;font-size:12.5px;">{{ $tx[1] }}</span>
                            </div>
                        </td>
                        <td style="font-size:12.5px;">{{ $tx[3] }}</td>
                        <td><span style="background:#f1f5f9;color:var(--muted);font-size:11.5px;font-weight:600;padding:3px 8px;border-radius:6px;"><i class="bi bi-bank me-1"></i>{{ $tx[4] }}</span></td>
                        <td style="font-weight:700;color:{{ $tx[6]==='sukses'?'var(--success)':($tx[6]==='gagal'?'var(--danger)':'var(--warning)') }};">{{ $tx[5] }}</td>
                        <td>
                            @if($tx[6]==='sukses')
                            <span class="badge-stat s-sukses"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Berhasil</span>
                            @elseif($tx[6]==='pending')
                            <span class="badge-stat s-pending"><i class="bi bi-clock-fill" style="font-size:7px;"></i> Pending</span>
                            @else
                            <span class="badge-stat s-gagal"><i class="bi bi-x-circle-fill" style="font-size:7px;"></i> Gagal</span>
                            @endif
                        </td>
                        <td style="font-size:12px;color:var(--muted);">{{ $tx[7] }}</td>
                        <td>
                            <button onclick="document.getElementById('modal-detail-tx').classList.add('show')"
                                style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer;">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);">
                <span style="font-size:12.5px;color:var(--muted);">Menampilkan 1–6 dari 1.284 transaksi</span>
                <div style="display:flex;gap:4px;">
                    @foreach(['<i class="bi bi-chevron-left"></i>','1','2','3','...','42','<i class="bi bi-chevron-right"></i>'] as $pg)
                    <button style="width:32px;height:32px;border-radius:8px;{{ $pg==='1'?'background:var(--primary);color:#fff;border:none;':'background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);' }}font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;">{!! $pg !!}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- SIDE PANEL --}}
    <div class="col-12 col-xl-4 d-flex flex-column gap-3">
        {{-- Donut Status --}}
        <div class="card-box">
            <div class="card-box-header"><div class="card-box-title">Status Pembayaran</div></div>
            <div class="p-4">
                <div style="text-align:center;margin-bottom:16px;">
                    <div style="display:inline-block;position:relative;width:120px;height:120px;">
                        <svg viewBox="0 0 36 36" width="120" height="120" style="transform:rotate(-90deg);">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f1f5f9" stroke-width="3"/>
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--success)" stroke-width="3" stroke-dasharray="82 18"/>
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--warning)" stroke-width="3" stroke-dasharray="13 87" stroke-dashoffset="-82"/>
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--danger)" stroke-width="3" stroke-dasharray="5 95" stroke-dashoffset="-95"/>
                        </svg>
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                            <div style="font-size:20px;font-weight:800;color:var(--primary);">82%</div>
                            <div style="font-size:10px;color:var(--muted);">Sukses</div>
                        </div>
                    </div>
                </div>
                @foreach([['var(--success)','Berhasil','1.047','82%'],['var(--warning)','Pending','165','13%'],['var(--danger)','Gagal','72','5%']] as $d)
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:10px;height:10px;border-radius:50%;background:{{ $d[0] }};display:inline-block;"></span>
                        <span style="font-size:13px;">{{ $d[1] }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:13px;font-weight:700;color:{{ $d[0] }};">{{ $d[2] }}</span>
                        <span style="font-size:11px;color:var(--muted);">({{ $d[3] }})</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Pendapatan per Layanan --}}
        <div class="card-box">
            <div class="card-box-header"><div class="card-box-title">Pendapatan per Layanan</div></div>
            <div class="p-4 d-flex flex-column gap-3">
                @foreach([['Les Privat – Matematika','Rp 18.2Jt',100],['Les Privat – Fisika','Rp 13.5Jt',74],['Les Privat – Kimia','Rp 9.8Jt',54],['Les Privat – B.Inggris','Rp 7.2Jt',40]] as $l)
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px;">
                        <span style="font-weight:600;">{{ $l[0] }}</span>
                        <span style="font-weight:700;color:var(--primary);">{{ $l[1] }}</span>
                    </div>
                    <div class="bar-track"><div class="bar-fill" style="width:{{ $l[2] }}%;"></div></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL TRANSAKSI --}}
<div class="modal-overlay" id="modal-detail-tx">
    <div class="modal-box">
        <div class="modal-head" style="background:var(--primary);border-radius:20px 20px 0 0;">
            <h5 style="color:#fff;">Detail Transaksi</h5>
            <button class="modal-close-btn" style="background:rgba(255,255,255,.2);color:#fff;" onclick="document.getElementById('modal-detail-tx').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="background:#f8fafc;padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:9px;">
                <div class="user-av" style="width:40px;height:40px;border-radius:10px;background:var(--primary);color:#fff;font-size:14px;">A</div>
                <div><div style="font-weight:700;font-size:13px;">Andi Pratama</div><div style="font-size:11.5px;color:var(--muted);">andi@gmail.com</div></div>
            </div>
            <span class="badge-stat s-sukses"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Berhasil</span>
        </div>
        <div style="padding:14px 20px;">
            @foreach([['ID Transaksi','#TRX-0041'],['Tanggal','02 Mei 2026, 14:32 WIB'],['Layanan','Les Privat – Matematika'],['Metode','Transfer Bank BCA'],['No. Referensi','BCA202605021432'],['Subtotal','Rp 73.000'],['Biaya Admin','Rp 2.000'],['Total Bayar','Rp 75.000']] as $d)
            <div class="det-row">
                <span class="det-k">{{ $d[0] }}</span>
                <span class="det-v" style="{{ $d[0]==='Total Bayar'?'font-size:16px;color:var(--primary);font-weight:800;':'' }}">{{ $d[1] }}</span>
            </div>
            @endforeach
        </div>
        <div style="padding:12px 20px;border-top:1px solid var(--border);display:flex;gap:8px;justify-content:flex-end;">
            <button onclick="document.getElementById('modal-detail-tx').classList.remove('show')"
                style="padding:8px 16px;border-radius:8px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">Tutup</button>
            <button style="padding:8px 16px;border-radius:8px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:600;cursor:pointer;">
                <i class="bi bi-file-earmark-arrow-down me-1"></i> Unduh Invoice
            </button>
        </div>
    </div>
</div>

@endsection