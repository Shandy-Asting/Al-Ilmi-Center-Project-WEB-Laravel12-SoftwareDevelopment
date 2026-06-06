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
    .stat-card {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow .2s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-label {
        font-size: 12px;
        color: var(--muted);
        font-weight: 500;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.2;
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
        gap: 10px;
    }

    .card-box-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
    }

    .filter-bar {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid var(--border);
    }

    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
    }

    .search-wrap i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 12px 8px 32px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        outline: none;
        background: var(--bg);
    }

    .search-wrap input:focus {
        border-color: var(--primary);
    }

    .filter-select {
        padding: 8px 28px 8px 12px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 12.5px;
        background: var(--bg);
        color: var(--text);
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
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
        padding: 10px 14px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .tbl tbody td {
        padding: 12px 14px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .tbl tbody tr:last-child td {
        border-bottom: none;
    }

    .tbl tbody tr:hover td {
        background: #fafcff;
    }

    .tx-id {
        font-weight: 700;
        color: var(--primary);
        font-size: 12px;
    }

    .user-av {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    .badge-stat {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .s-sukses {
        background: var(--success-soft);
        color: var(--success);
    }

    .s-pending {
        background: var(--warning-soft);
        color: var(--warning);
    }

    .s-gagal {
        background: var(--danger-soft);
        color: var(--danger);
    }

    .s-refund {
        background: var(--info-soft);
        color: var(--info);
    }

    .bar-track {
        height: 8px;
        background: #f1f5f9;
        border-radius: 99px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, var(--primary-light), var(--accent));
    }

    /* MODAL */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .55);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 460px;
        max-height: 92vh;
        overflow-y: auto;
        animation: fadeUp .25s ease;
    }

    @keyframes fadeUp {
        from {
            transform: translateY(20px);
            opacity: 0
        }

        to {
            transform: translateY(0);
            opacity: 1
        }
    }

    .modal-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-head h5 {
        font-size: 15px;
        font-weight: 800;
    }

    .modal-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: var(--bg);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: var(--muted);
    }

    .det-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        font-size: 13.5px;
    }

    .det-row:last-child {
        border-bottom: none;
    }

    .det-k {
        color: var(--muted);
        font-weight: 500;
    }

    .det-v {
        font-weight: 600;
    }

    @media(max-width:767px) {
        .filter-bar {
            flex-direction: column;
        }

        .search-wrap,
        .filter-select {
            width: 100%;
        }

        .tbl {
            font-size: 11.5px;
        }
    }
</style>
@endpush

@section('content')

<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">💳 Pengelolaan Transaksi</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Monitor semua transaksi pembayaran les privat</p>
    </div>
    <a href="/admin/transaksi/export?{{ http_build_query(request()->query()) }}"
        style="background:var(--primary);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;padding:7px 14px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
        <i class="bi bi-download"></i> Export
    </a>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $stCards = [
    ['bi-arrow-left-right','var(--info-soft)','var(--info)',
    number_format($totalTransaksi),'Total Transaksi',
    ($totalTransaksi - $bulanLalu >= 0 ? '↑' : '↓') . ' vs bulan lalu'],
    ['bi-check-circle','var(--success-soft)','var(--success)',
    number_format($totalBerhasil),'Berhasil',
    ($totalBerhasil - $berhasilBulanLalu >= 0 ? '↑' : '↓') . ' vs bulan lalu'],
    ['bi-clock','var(--warning-soft)','var(--warning)',
    number_format($totalPending),'Pending','Perlu tindak lanjut'],
    ['bi-cash-stack','var(--accent-soft)','var(--warning)',
    'Rp ' . number_format($totalPendapatan/1000000, 1) . 'Jt','Total Pendapatan',
    ($totalPendapatan - $pendapatanBulanLalu >= 0 ? '↑' : '↓') . ' vs bulan lalu'],
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
            <form method="GET" action="/admin/transaksi" class="filter-bar">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Cari transaksi…" value="{{ request('search') }}" />
                </div>
                <select class="filter-select" name="status" onchange="this.form.submit()">
                    <option value="semua">Semua Status</option>
                    <option value="berhasil" {{ request('status')==='berhasil'?'selected':'' }}>Berhasil</option>
                    <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                    <option value="gagal" {{ request('status')==='gagal'?'selected':'' }}>Gagal</option>
                </select>
                <select class="filter-select" name="metode" onchange="this.form.submit()">
                    <option value="semua">Semua Metode</option>
                    <option value="BCA" {{ request('metode')==='BCA'?'selected':'' }}>Transfer BCA</option>
                    <option value="BRI" {{ request('metode')==='BRI'?'selected':'' }}>Transfer BRI</option>
                    <option value="Mandiri" {{ request('metode')==='Mandiri'?'selected':'' }}>Transfer Mandiri</option>
                    <option value="QRIS" {{ request('metode')==='QRIS'?'selected':'' }}>QRIS</option>
                </select>
            </form>
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pengguna</th>
                            <th>Layanan</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $tx)
                        <tr>
                            <td><span class="tx-id">#{{ $tx->nomor_invoice }}</span></td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div class="user-av" style="background:var(--primary);color:#fff;">
                                        {{ strtoupper(substr($tx->siswa->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span style="font-weight:600;font-size:12.5px;">{{ $tx->siswa->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td style="font-size:12.5px;">Les Privat – {{ $tx->lesPrivat->mata_pelajaran ?? '-' }}</td>
                            <td>
                                <span style="background:#f1f5f9;color:var(--muted);font-size:11.5px;font-weight:600;padding:3px 8px;border-radius:6px;">
                                    <i class="bi bi-bank me-1"></i>{{ $tx->bank_tujuan ?? '-' }}
                                </span>
                            </td>
                            <td style="font-weight:700;color:{{ $tx->status==='dikonfirmasi'?'var(--success)':($tx->status==='ditolak'?'var(--danger)':'var(--warning)') }};">
                                Rp {{ number_format($tx->jumlah, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($tx->status==='dikonfirmasi')
                                <span class="badge-stat s-sukses"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Berhasil</span>
                                @elseif($tx->status==='menunggu')
                                <span class="badge-stat s-pending"><i class="bi bi-clock-fill" style="font-size:7px;"></i> Pending</span>
                                @else
                                <span class="badge-stat s-gagal"><i class="bi bi-x-circle-fill" style="font-size:7px;"></i> Gagal</span>
                                @endif
                            </td>
                            <td style="font-size:12px;color:var(--muted);">{{ $tx->created_at->format('d M Y') }}</td>
                            <td>
                                <button onclick="bukaDetail('{{ $tx->nomor_invoice }}','{{ $tx->siswa->name ?? '-' }}','{{ $tx->siswa->email ?? '-' }}','{{ $tx->status }}','{{ $tx->lesPrivat->mata_pelajaran ?? '-' }}','{{ $tx->bank_tujuan ?? '-' }}','{{ $tx->created_at->format('d M Y, H:i') }} WIB','{{ number_format($tx->jumlah, 0, ',', '.') }}')"
                                    style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer;">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:24px;color:var(--muted);">Tidak ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px;">
                <span style="font-size:12.5px;color:var(--muted);">
                    Menampilkan {{ $transaksi->firstItem() }}–{{ $transaksi->lastItem() }} dari {{ number_format($transaksi->total()) }} transaksi
                </span>
                <div style="display:flex;gap:4px;">
                    @if($transaksi->onFirstPage())
                    <button disabled style="width:32px;height:32px;border-radius:8px;background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);font-size:12px;cursor:not-allowed;display:flex;align-items:center;justify-content:center;"><i class="bi bi-chevron-left"></i></button>
                    @else
                    <a href="{{ $transaksi->previousPageUrl() }}" style="width:32px;height:32px;border-radius:8px;background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);font-size:12px;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    @foreach($transaksi->getUrlRange(max(1,$transaksi->currentPage()-1), min($transaksi->lastPage(),$transaksi->currentPage()+1)) as $page => $url)
                    <a href="{{ $url }}" style="width:32px;height:32px;border-radius:8px;{{ $page==$transaksi->currentPage()?'background:var(--primary);color:#fff;border:none;':'background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);' }}font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;text-decoration:none;">{{ $page }}</a>
                    @endforeach

                    @if($transaksi->hasMorePages())
                    <a href="{{ $transaksi->nextPageUrl() }}" style="width:32px;height:32px;border-radius:8px;background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);font-size:12px;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="bi bi-chevron-right"></i></a>
                    @else
                    <button disabled style="width:32px;height:32px;border-radius:8px;background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);font-size:12px;cursor:not-allowed;display:flex;align-items:center;justify-content:center;"><i class="bi bi-chevron-right"></i></button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SIDE PANEL --}}
    <div class="col-12 col-xl-4 d-flex flex-column gap-3">
        {{-- Donut Status --}}
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Status Pembayaran</div>
            </div>
            <div class="p-4">
                <div style="text-align:center;margin-bottom:16px;">
                    <div style="display:inline-block;position:relative;width:120px;height:120px;">
                        <svg viewBox="0 0 36 36" width="120" height="120" style="transform:rotate(-90deg);">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f1f5f9" stroke-width="3" />
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--success)" stroke-width="3"
                                stroke-dasharray="{{ $pctBerhasil }} {{ 100-$pctBerhasil }}" />
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--warning)" stroke-width="3"
                                stroke-dasharray="{{ $pctPending }} {{ 100-$pctPending }}"
                                stroke-dashoffset="-{{ $pctBerhasil }}" />
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--danger)" stroke-width="3"
                                stroke-dasharray="{{ $pctGagal }} {{ 100-$pctGagal }}"
                                stroke-dashoffset="-{{ $pctBerhasil + $pctPending }}" />
                        </svg>
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                            <div style="font-size:20px;font-weight:800;color:var(--primary);">{{ $pctBerhasil }}%</div>
                            <div style="font-size:10px;color:var(--muted);">Sukses</div>
                        </div>
                    </div>
                </div>
                @foreach([
                ['var(--success)','Berhasil', number_format($totalBerhasil), $pctBerhasil.'%'],
                ['var(--warning)','Pending', number_format($totalPending), $pctPending.'%'],
                ['var(--danger)', 'Gagal', number_format($totalGagal), $pctGagal.'%'],
                ] as $d)
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
            <div class="card-box-header">
                <div class="card-box-title">Pendapatan per Layanan</div>
            </div>
            <div class="p-4 d-flex flex-column gap-3">
                @foreach($pendapatanPerLayanan as $l)
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px;">
                        <span style="font-weight:600;">{{ $l['nama'] }}</span>
                        <span style="font-weight:700;color:var(--primary);">Rp {{ number_format($l['jumlah']/1000000, 1) }}Jt</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:{{ round($l['jumlah']/$maxLayanan*100) }}%;"></div>
                    </div>
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
            <button class="modal-close-btn" style="background:rgba(255,255,255,.2);color:#fff;"
                onclick="document.getElementById('modal-detail-tx').classList.remove('show')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div style="background:#f8fafc;padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:9px;">
                <div id="det-inisial" class="user-av" style="width:40px;height:40px;border-radius:10px;background:var(--primary);color:#fff;font-size:14px;"></div>
                <div>
                    <div id="det-nama" style="font-weight:700;font-size:13px;"></div>
                    <div id="det-email" style="font-size:11.5px;color:var(--muted);"></div>
                </div>
            </div>
            <span id="det-badge" class="badge-stat s-sukses"></span>
        </div>
        <div style="padding:14px 20px;">
            <div class="det-row"><span class="det-k">ID Transaksi</span><span id="det-id" class="det-v"></span></div>
            <div class="det-row"><span class="det-k">Tanggal</span><span id="det-tgl" class="det-v"></span></div>
            <div class="det-row"><span class="det-k">Layanan</span><span id="det-mapel" class="det-v"></span></div>
            <div class="det-row"><span class="det-k">Metode</span><span id="det-bank" class="det-v"></span></div>
            <div class="det-row"><span class="det-k">Total Bayar</span><span id="det-jumlah" class="det-v" style="font-size:16px;color:var(--primary);font-weight:800;"></span></div>
        </div>
        <div style="padding:12px 20px;border-top:1px solid var(--border);display:flex;gap:8px;justify-content:flex-end;">
            <button onclick="document.getElementById('modal-detail-tx').classList.remove('show')"
                style="padding:8px 16px;border-radius:8px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function bukaDetail(id, nama, email, status, mapel, bank, tgl, jumlah) {
        document.getElementById('det-id').textContent = '#' + id;
        document.getElementById('det-nama').textContent = nama;
        document.getElementById('det-email').textContent = email;
        document.getElementById('det-tgl').textContent = tgl;
        document.getElementById('det-mapel').textContent = 'Les Privat – ' + mapel;
        document.getElementById('det-bank').textContent = bank;
        document.getElementById('det-jumlah').textContent = 'Rp ' + jumlah;

        const badge = document.getElementById('det-badge');
        if (status === 'dikonfirmasi') {
            badge.className = 'badge-stat s-sukses';
            badge.innerHTML = '<i class="bi bi-circle-fill" style="font-size:7px;"></i> Berhasil';
        } else if (status === 'menunggu') {
            badge.className = 'badge-stat s-pending';
            badge.innerHTML = '<i class="bi bi-clock-fill" style="font-size:7px;"></i> Pending';
        } else {
            badge.className = 'badge-stat s-gagal';
            badge.innerHTML = '<i class="bi bi-x-circle-fill" style="font-size:7px;"></i> Gagal';
        }

        document.getElementById('det-inisial').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('modal-detail-tx').classList.add('show');
    }
</script>
@endpush

@endsection