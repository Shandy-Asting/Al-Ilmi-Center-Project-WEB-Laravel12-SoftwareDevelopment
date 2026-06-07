@extends('layouts.app')

@section('title', 'Pengelolaan Paket - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Pengelolaan Paket')
@section('page-sub', 'Admin / Pengelolaan Paket')

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
/* ─────────────────────────────────────────────────
   TOKENS
───────────────────────────────────────────────── */
.pk {
    --navy:   #0f2342;
    --blue:   #1d4ed8;
    --slate:  #64748b;
    --line:   #e8ecf0;
    --bg:     #f5f7fa;
    --card:   #ffffff;
    --green:  #16a34a;
    --red:    #dc2626;
    --amber:  #d97706;
    --info:   #0284c7;
}

/* ─────────────────────────────────────────────────
   PAGE HEADER
───────────────────────────────────────────────── */
.pk-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.pk-header-left h4 {
    font-size: clamp(16px, 4vw, 20px);
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 3px;
}

.pk-header-left p {
    font-size: 13px;
    color: var(--slate);
    margin: 0;
}

.pk-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    border-radius: 10px;
    border: none;
    background: var(--navy);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    transition: opacity .15s;
}
.pk-add-btn:hover { opacity: .88; }

/* ─────────────────────────────────────────────────
   STAT CARDS
───────────────────────────────────────────────── */
.sc {
    background: var(--card);
    border-radius: 14px;
    padding: 16px;
    border: 1px solid var(--line);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: transform .18s, box-shadow .18s;
    height: 100%;
}
.sc:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }

.sc-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}

.sc-val {
    font-size: clamp(1.1rem, 4vw, 1.45rem);
    font-weight: 800;
    color: var(--navy);
    line-height: 1;
    word-break: break-all;
}
.sc-label { font-size: .76rem; color: var(--slate); margin-top: 4px; }

/* ─────────────────────────────────────────────────
   TABS
───────────────────────────────────────────────── */
.tab-nav {
    display: flex;
    gap: 5px;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 4px;
    margin-bottom: 20px;
    overflow-x: auto;
    flex-wrap: nowrap;          /* PENTING: jangan wrap */
    scrollbar-width: none;
}
.tab-nav::-webkit-scrollbar { display: none; }

.tab-btn {
    flex: 1;
    min-width: 120px;
    text-align: center;
    padding: 9px 8px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    color: var(--slate);
    border: none;
    background: transparent;
    white-space: nowrap;
    transition: all .18s;
    flex-shrink: 0;
}
.tab-btn.active  { background: var(--navy); color: #fff; }
.tab-btn:hover:not(.active) { background: var(--bg); color: var(--navy); }

.tab-pane { display: none; }
.tab-pane.active { display: block; }

/* ─────────────────────────────────────────────────
   FILTER BAR
───────────────────────────────────────────────── */
.filter-bar {
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
}

.search-wrap {
    flex: 1;
    min-width: 0;           /* PENTING: cegah overflow */
    position: relative;
}
.search-wrap i {
    position: absolute;
    left: 11px; top: 50%;
    transform: translateY(-50%);
    color: var(--slate); font-size: 13px;
    pointer-events: none;
}
.search-wrap input {
    width: 100%;
    padding: 8px 12px 8px 33px;
    border: 1.5px solid var(--line);
    border-radius: 9px;
    font-size: 13px;
    outline: none;
    background: var(--bg);
    color: var(--navy);
    min-width: 0;
}
.search-wrap input:focus { border-color: var(--navy); }

.filter-sel {
    padding: 8px 28px 8px 12px;
    border: 1.5px solid var(--line);
    border-radius: 9px;
    font-size: 13px;
    background: var(--bg)
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E")
        no-repeat right 10px center;
    appearance: none;
    color: var(--navy);
    outline: none;
    flex-shrink: 0;
}
.filter-sel:focus { border-color: var(--navy); }

/* ─────────────────────────────────────────────────
   PAKET CARD
───────────────────────────────────────────────── */
.pkg-card {
    background: var(--card);
    border-radius: 16px;
    border: 2px solid var(--line);
    padding: 20px;
    position: relative;
    /* Hapus overflow:hidden agar badge tidak terpotong */
    transition: transform .22s, box-shadow .22s;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.pkg-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,.09);
}
.pkg-card.popular { border-color: var(--navy); }

/* Badge terpopuler — posisi absolut di pojok kanan atas,
   TANPA transform rotate agar tidak terpotong overflow */
.pkg-popular-badge {
    position: absolute;
    top: -1px;
    right: 14px;
    background: var(--navy);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 0 0 8px 8px;
    letter-spacing: .3px;
    white-space: nowrap;
}

/* Jenjang chip */
.pkg-jenjang {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    margin-bottom: 12px;
    background: #eff6ff;
    color: var(--navy);
}

.pkg-name {
    font-size: clamp(14px, 3vw, 17px);
    font-weight: 800;
    color: var(--navy);
    margin-bottom: 4px;
}

.pkg-price {
    font-size: clamp(18px, 5vw, 24px);
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.5px;
    line-height: 1;
}

.pkg-price-sub {
    font-size: 12px;
    color: var(--slate);
    margin-bottom: 14px;
    margin-top: 2px;
}

.pkg-divider {
    border: none;
    border-top: 1px dashed var(--line);
    margin: 10px 0 12px;
}

.pkg-feature {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 12.5px;
    margin-bottom: 8px;
    color: var(--navy);
    line-height: 1.4;
}
.pkg-feature i { font-size: 13px; margin-top: 1px; flex-shrink: 0; }
.pkg-feature.off { color: var(--slate); }

/* Tombol edit & hapus di bawah kartu */
.pkg-actions {
    display: flex;
    gap: 8px;
    margin-top: auto;
    padding-top: 14px;
}

.pkg-edit-btn {
    flex: 1;
    padding: 8px 10px;
    border-radius: 9px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    border: 1.5px solid var(--navy);
    background: #eff6ff;
    color: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: all .15s;
}
.pkg-edit-btn:hover { background: var(--navy); color: #fff; }

.pkg-del-btn {
    padding: 8px 12px;
    border-radius: 9px;
    font-size: 13px;
    cursor: pointer;
    border: 1.5px solid #fee2e2;
    background: #fff1f2;
    color: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .15s;
}
.pkg-del-btn:hover { background: var(--red); color: #fff; border-color: var(--red); }

/* ─────────────────────────────────────────────────
   CARD BOX (tabel)
───────────────────────────────────────────────── */
.card-box {
    background: var(--card);
    border-radius: 14px;
    border: 1px solid var(--line);
    overflow: hidden;
}

.cb-head {
    padding: 14px 18px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}

.cb-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--navy);
}

/* ─────────────────────────────────────────────────
   TABLE
───────────────────────────────────────────────── */
.tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

.tbl {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;   /* Scroll horizontal di mobile */
}

.tbl thead th {
    background: #f8fafc;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--slate);
    text-transform: uppercase;
    letter-spacing: .3px;
    padding: 10px 12px;
    border-bottom: 1px solid var(--line);
    white-space: nowrap;
}

.tbl tbody td {
    padding: 11px 12px;
    font-size: 13px;
    color: var(--navy);
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.tbl tbody tr:last-child td { border-bottom: none; }
.tbl tbody tr:hover td { background: #f8fbff; }

/* Aksi di tabel */
.tbl-act {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1.5px solid var(--line);
    background: var(--card);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: all .15s;
}
.tbl-act.edit:hover { border-color: var(--navy); color: var(--navy); background: #eff6ff; }
.tbl-act.del:hover  { border-color: var(--red);  color: var(--red);  background: #fff1f2; }

/* ─────────────────────────────────────────────────
   MODAL
───────────────────────────────────────────────── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.modal-overlay.show { display: flex; }

.modal-box {
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 560px;
    max-height: 92vh;
    overflow-y: auto;
    animation: fadeUp .22s ease;
}

@keyframes fadeUp {
    from { transform: translateY(18px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

.modal-head {
    padding: 16px 20px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 1;
}

.modal-head h5 {
    font-size: 15px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
}

.modal-close {
    width: 30px; height: 30px;
    border-radius: 8px;
    border: none;
    background: var(--bg);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    color: var(--slate);
    flex-shrink: 0;
}
.modal-close:hover { background: #fee2e2; color: var(--red); }

/* Form inputs */
.form-lbl {
    font-size: 13px;
    font-weight: 600;
    color: var(--navy);
    margin-bottom: 6px;
    display: block;
}

.form-inp {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid var(--line);
    border-radius: 10px;
    font-size: 13.5px;
    color: var(--navy);
    outline: none;
    background: #fff;
    transition: border .18s;
}
.form-inp:focus { border-color: var(--navy); }

/* Modal footer buttons */
.modal-footer {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    padding-top: 8px;
    flex-wrap: wrap;
}

.btn-cancel {
    padding: 9px 18px;
    border-radius: 10px;
    border: 1.5px solid var(--line);
    background: var(--bg);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    color: var(--slate);
    white-space: nowrap;
}
.btn-cancel:hover { border-color: var(--navy); color: var(--navy); }

.btn-save {
    padding: 9px 20px;
    border-radius: 10px;
    border: none;
    background: var(--navy);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-save:hover { opacity: .88; }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 48px 20px;
    color: var(--slate);
    background: var(--card);
    border-radius: 16px;
    border: 1.5px dashed var(--line);
}
.empty-state i { font-size: 2.5rem; opacity: .35; display: block; margin-bottom: 10px; }
.empty-state strong { color: var(--navy); }

/* ─────────────────────────────────────────────────
   RESPONSIVE BREAKPOINTS
───────────────────────────────────────────────── */
@media (max-width: 576px) {
    .pk-header     { margin-bottom: 18px; }
    .pk-add-btn    { width: 100%; justify-content: center; }
    .pk-header     { flex-direction: column; }
    .sc            { padding: 13px; }
    .sc-icon       { width: 38px; height: 38px; }
    .pkg-card      { padding: 16px; }
    .filter-bar    { flex-direction: column; }
    .filter-sel    { width: 100%; }
    .modal-footer  { flex-direction: column-reverse; }
    .btn-cancel, .btn-save { width: 100%; justify-content: center; }
}

@media (max-width: 360px) {
    .pkg-actions { flex-direction: column; }
    .pkg-edit-btn { width: 100%; }
    .pkg-del-btn  { width: 100%; }
}
</style>
@endpush

@section('content')
<div class="pk">

{{-- ══════════════ HEADER ══════════════ --}}
<div class="pk-header">
    <div class="pk-header-left">
        <h4>📦 Pengelolaan Paket</h4>
        <p>Kelola layanan, harga, dan fitur paket les privat</p>
    </div>
    <button class="pk-add-btn" onclick="openModal('tambah')">
        <i class="bi bi-plus-lg"></i> Tambah Paket
    </button>
</div>

{{-- ══════════════ STAT CARDS ══════════════ --}}
@php
    $totalPaket = $pakets->count();
    $paketAktif = $pakets->count();
@endphp
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['bi-box-seam-fill',    '#eff6ff',  '#1d4ed8', $totalPaket,  'Total Paket'],
        ['bi-check-circle-fill','#f0fdf4',  '#16a34a', $paketAktif,  'Paket Aktif'],
        ['bi-people-fill',      '#f0f9ff',  '#0284c7', 248,          'Total Pelanggan'],
        ['bi-cash-coin',        '#fffbeb',  '#d97706', 'Rp 89.5jt',  'Pendapatan Bulan Ini'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-md-3">
        <div class="sc">
            <div class="sc-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div style="min-width:0;">
                <div class="sc-val">{{ $s[3] }}</div>
                <div class="sc-label">{{ $s[4] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ══════════════ TABS ══════════════ --}}
<div class="tab-nav">
    <button class="tab-btn active" onclick="switchTab(this,'privat')">
        <i class="bi bi-person-video3 me-1"></i> Paket Les Privat
    </button>
    <button class="tab-btn" onclick="switchTab(this,'semua')">
        <i class="bi bi-grid me-1"></i> Semua Paket
    </button>
</div>

{{-- ══════════════ TAB: PAKET PRIVAT ══════════════ --}}
<div class="tab-pane active" id="tab-privat">

    <div class="filter-bar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="search-privat"
                   placeholder="Cari nama paket…"
                   oninput="filterKartu()">
        </div>
        <select class="filter-sel" id="filter-tipe" onchange="filterKartu()">
            <option value="">Semua Jenjang</option>
            <option value="sd">SD</option>
            <option value="smp">SMP</option>
            <option value="sma">SMA</option>
        </select>
    </div>

    <div class="row g-3" id="kartu-container">
        @forelse($pakets as $p)
        @php
            $jenjangLabel = match(strtolower($p->tipe)) {
                'sd'  => 'SD — Kelas 1–6',
                'smp' => 'SMP — Kelas 7–9',
                'sma' => 'SMA — Kelas 10–12',
                default => strtoupper($p->tipe)
            };
            $isPopular = $loop->first;
        @endphp
        <div class="col-12 col-md-6 col-xl-4 kartu-item"
             data-nama="{{ strtolower($p->nama) }}"
             data-tipe="{{ strtolower($p->tipe) }}">
            <div class="pkg-card {{ $isPopular ? 'popular' : '' }}">

                {{-- Badge terpopuler — pojok kanan atas, tidak rotate --}}
                @if($isPopular)
                <div class="pkg-popular-badge">⭐ Terpopuler</div>
                @endif

                {{-- Jenjang chip --}}
                <div class="pkg-jenjang">
                    <i class="bi bi-person-video3"></i>
                    Les Privat · {{ $jenjangLabel }}
                </div>

                <div class="pkg-name">{{ $p->nama }}</div>

                <div class="pkg-price">Rp {{ number_format($p->harga_min, 0, ',', '.') }}</div>
                <div class="pkg-price-sub">
                    / sesi
                    @if($p->harga_max)
                        &nbsp;—&nbsp; maks Rp {{ number_format($p->harga_max, 0, ',', '.') }}
                    @endif
                </div>

                <hr class="pkg-divider">

                @if($p->jumlah_les)
                <div class="pkg-feature">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
                    {{ $p->jumlah_les }} sesi les privat
                </div>
                @endif

                @if($p->jumlah_soal)
                <div class="pkg-feature">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
                    {{ $p->jumlah_soal }} soal latihan
                </div>
                @endif

                @if($p->feedback_tutor)
                <div class="pkg-feature">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
                    Feedback tutor
                </div>
                @else
                <div class="pkg-feature off">
                    <i class="bi bi-x-circle-fill" style="color:#cbd5e1;"></i>
                    Feedback tutor
                </div>
                @endif

                @if($p->akses_penuh)
                <div class="pkg-feature">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
                    Akses penuh materi
                </div>
                @else
                <div class="pkg-feature off">
                    <i class="bi bi-x-circle-fill" style="color:#cbd5e1;"></i>
                    Akses penuh materi
                </div>
                @endif

                {{-- Aksi --}}
                <div class="pkg-actions">
                    <button class="pkg-edit-btn"
                        onclick="openModalEdit({{ $p->id }},'{{ addslashes($p->nama) }}',{{ $p->harga_min }},{{ $p->harga_max ?? 'null' }},'{{ $p->tipe }}',{{ $p->jumlah_soal ?? 'null' }},{{ $p->jumlah_les ?? 'null' }},{{ $p->feedback_tutor ? 1 : 0 }},{{ $p->akses_penuh ? 1 : 0 }})">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <form action="/admin/paket/{{ $p->id }}/hapus" method="POST"
                          onsubmit="return confirm('Hapus paket {{ addslashes($p->nama) }}?')">
                        @csrf
                        <button type="submit" class="pkg-del-btn" title="Hapus">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-box-seam"></i>
                Belum ada paket les privat.<br>
                Klik <strong>Tambah Paket</strong> untuk mulai.
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- ══════════════ TAB: SEMUA PAKET ══════════════ --}}
<div class="tab-pane" id="tab-semua">
    <div class="card-box">
        <div class="cb-head">
            <div class="cb-title">Semua Paket Layanan</div>
            <span style="font-size:12px;color:var(--slate);">{{ $pakets->count() }} paket</span>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Paket</th>
                        <th>Jenjang</th>
                        <th>Harga Min</th>
                        <th>Harga Max</th>
                        <th>Soal</th>
                        <th>Sesi Les</th>
                        <th>Feedback</th>
                        <th>Akses Penuh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $p)
                    <tr>
                        <td style="color:var(--slate);">{{ $loop->iteration }}</td>
                        <td style="font-weight:700;">{{ $p->nama }}</td>
                        <td>
                            <span style="background:#eff6ff;color:#1d4ed8;font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;">
                                {{ strtoupper($p->tipe) }}
                            </span>
                        </td>
                        <td style="white-space:nowrap;">Rp {{ number_format($p->harga_min, 0, ',', '.') }}</td>
                        <td style="white-space:nowrap;">{{ $p->harga_max ? 'Rp '.number_format($p->harga_max, 0, ',', '.') : '—' }}</td>
                        <td style="text-align:center;">{{ $p->jumlah_soal ?? '—' }}</td>
                        <td style="text-align:center;">{{ $p->jumlah_les ?? '—' }}</td>
                        <td style="text-align:center;">{{ $p->feedback_tutor ? '✅' : '❌' }}</td>
                        <td style="text-align:center;">{{ $p->akses_penuh ? '✅' : '❌' }}</td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <button class="tbl-act edit"
                                    onclick="openModalEdit({{ $p->id }},'{{ addslashes($p->nama) }}',{{ $p->harga_min }},{{ $p->harga_max ?? 'null' }},'{{ $p->tipe }}',{{ $p->jumlah_soal ?? 'null' }},{{ $p->jumlah_les ?? 'null' }},{{ $p->feedback_tutor ? 1 : 0 }},{{ $p->akses_penuh ? 1 : 0 }})"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="/admin/paket/{{ $p->id }}/hapus" method="POST"
                                      onsubmit="return confirm('Hapus paket {{ addslashes($p->nama) }}?')">
                                    @csrf
                                    <button type="submit" class="tbl-act del" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align:center;padding:32px;color:var(--slate);">
                            <i class="bi bi-box-seam" style="font-size:1.8rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                            Belum ada paket terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════ MODAL TAMBAH ══════════════ --}}
<div class="modal-overlay" id="modal-tambah" onclick="if(event.target===this)closeModal('tambah')">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-plus-lg me-2" style="color:var(--navy);"></i>Tambah Paket Baru</h5>
            <button class="modal-close" onclick="closeModal('tambah')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="/admin/paket" method="POST">
            @csrf
            <div style="padding:18px 20px;" class="row g-3">

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Nama Paket <span style="color:var(--red);">*</span></label>
                    <input type="text" name="nama" class="form-inp"
                           placeholder="Contoh: Paket Les Privat SMA" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Jenjang <span style="color:var(--red);">*</span></label>
                    <select name="tipe" class="form-inp" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="sd">SD (Kelas 1–6)</option>
                        <option value="smp">SMP (Kelas 7–9)</option>
                        <option value="sma">SMA (Kelas 10–12)</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Harga Min (Rp) <span style="color:var(--red);">*</span></label>
                    <input type="number" name="harga_min" class="form-inp"
                           placeholder="50000" min="0" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Harga Max (Rp)</label>
                    <input type="number" name="harga_max" class="form-inp"
                           placeholder="200000" min="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Jumlah Soal</label>
                    <input type="number" name="jumlah_soal" class="form-inp"
                           placeholder="100" min="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Jumlah Sesi Les</label>
                    <input type="number" name="jumlah_les" class="form-inp"
                           placeholder="4" min="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Feedback Tutor</label>
                    <select name="feedback_tutor" class="form-inp">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Akses Penuh Materi</label>
                    <select name="akses_penuh" class="form-inp">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="col-12">
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('tambah')">Batal</button>
                        <button type="submit" class="btn-save">
                            <i class="bi bi-plus-lg"></i> Simpan Paket
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ══════════════ MODAL EDIT ══════════════ --}}
<div class="modal-overlay" id="modal-edit" onclick="if(event.target===this)closeModal('edit')">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-pencil me-2" style="color:var(--navy);"></i>Edit Paket</h5>
            <button class="modal-close" onclick="closeModal('edit')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-edit" action="" method="POST">
            @csrf
            <div style="padding:18px 20px;" class="row g-3">

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Nama Paket <span style="color:var(--red);">*</span></label>
                    <input type="text" name="nama" id="edit-nama" class="form-inp" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Jenjang <span style="color:var(--red);">*</span></label>
                    <select name="tipe" id="edit-tipe" class="form-inp" required>
                        <option value="sd">SD (Kelas 1–6)</option>
                        <option value="smp">SMP (Kelas 7–9)</option>
                        <option value="sma">SMA (Kelas 10–12)</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Harga Min (Rp) <span style="color:var(--red);">*</span></label>
                    <input type="number" name="harga_min" id="edit-harga-min" class="form-inp" min="0" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Harga Max (Rp)</label>
                    <input type="number" name="harga_max" id="edit-harga-max" class="form-inp" min="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Jumlah Soal</label>
                    <input type="number" name="jumlah_soal" id="edit-jumlah-soal" class="form-inp" min="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Jumlah Sesi Les</label>
                    <input type="number" name="jumlah_les" id="edit-jumlah-les" class="form-inp" min="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Feedback Tutor</label>
                    <select name="feedback_tutor" id="edit-feedback" class="form-inp">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-lbl">Akses Penuh Materi</label>
                    <select name="akses_penuh" id="edit-akses" class="form-inp">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="col-12">
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('edit')">Batal</button>
                        <button type="submit" class="btn-save">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

</div>{{-- /pk --}}
@endsection

@push('scripts')
<script>
/* ── Tab ─────────────────────────────────────── */
function switchTab(el, id) {
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    ['privat','semua'].forEach(t => {
        document.getElementById('tab-'+t).classList.toggle('active', t === id);
    });
}

/* ── Modal ───────────────────────────────────── */
function openModal(id) {
    document.getElementById('modal-'+id).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById('modal-'+id).classList.remove('show');
    document.body.style.overflow = '';
}

/* ── Modal Edit — isi data ───────────────────── */
function openModalEdit(id, nama, hargaMin, hargaMax, tipe, jumlahSoal, jumlahLes, feedback, akses) {
    document.getElementById('form-edit').action = '/admin/paket/' + id + '/update';
    document.getElementById('edit-nama').value        = nama;
    document.getElementById('edit-tipe').value        = tipe;
    document.getElementById('edit-harga-min').value   = hargaMin;
    document.getElementById('edit-harga-max').value   = hargaMax ?? '';
    document.getElementById('edit-jumlah-soal').value = jumlahSoal ?? '';
    document.getElementById('edit-jumlah-les').value  = jumlahLes ?? '';
    document.getElementById('edit-feedback').value    = feedback;
    document.getElementById('edit-akses').value       = akses;
    openModal('edit');
}

/* ── Filter kartu ────────────────────────────── */
function filterKartu() {
    const kw   = document.getElementById('search-privat').value.toLowerCase().trim();
    const tipe = document.getElementById('filter-tipe').value.toLowerCase();

    document.querySelectorAll('.kartu-item').forEach(el => {
        const cocokNama = kw   === '' || el.dataset.nama.includes(kw);
        const cocokTipe = tipe === '' || el.dataset.tipe === tipe;
        el.style.display = (cocokNama && cocokTipe) ? '' : 'none';
    });
}
</script>
@endpush