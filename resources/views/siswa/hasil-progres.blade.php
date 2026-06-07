@extends('layouts.app')

@section('title', 'Hasil & Progres - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Hasil & Progres Belajar')
@section('page-sub', 'Dashboard / Hasil & Progres')

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
/* ═══════════════════════════════════════════
   RESPONSIVE VARIABLES & BASE
═══════════════════════════════════════════ */
:root {
    --radius-card: 16px;
    --radius-btn:  10px;
    --radius-sm:   8px;
    --shadow-card: 0 2px 12px rgba(0,0,0,.06);
    --shadow-hover: 0 8px 28px rgba(0,0,0,.10);
    --transition: .2s ease;
}

/* ═══════════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════════ */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 4px;
    flex-wrap: wrap;
}

.page-header-left h4 {
    font-size: clamp(16px, 4vw, 20px);
    font-weight: 800;
    margin-bottom: 4px;
    line-height: 1.2;
    color: var(--text);
}

.page-header-left .breadcrumb-text {
    font-size: 12px;
    color: var(--muted);
}

.page-header-left .breadcrumb-text span {
    color: var(--primary);
    font-weight: 600;
}

.page-header-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-shrink: 0;
    flex-wrap: wrap;
}

/* ═══════════════════════════════════════════
   FILTER & BUTTONS
═══════════════════════════════════════════ */
.filter-select {
    border-radius: var(--radius-btn);
    font-size: 12px;
    font-weight: 700;
    border: 1.5px solid var(--border);
    padding: 6px 10px;
    background: var(--card-bg);
    color: var(--text);
    cursor: pointer;
    height: 34px;
}

.btn-download {
    background: var(--primary);
    color: #fff;
    border-radius: var(--radius-btn);
    border: none;
    font-size: 12px;
    font-weight: 700;
    padding: 0 14px;
    height: 34px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    white-space: nowrap;
}

.btn-download:hover { background: var(--primary-dark, #152c4a); color: #fff; }

/* ═══════════════════════════════════════════
   TABS
═══════════════════════════════════════════ */
.main-tabs {
    display: flex;
    gap: 5px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 5px;
    margin: 16px 0;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.main-tabs::-webkit-scrollbar { display: none; }

.main-tab {
    flex: 1;
    min-width: 90px;
    text-align: center;
    padding: 8px 10px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all var(--transition);
    color: var(--muted);
    border: none;
    background: transparent;
    white-space: nowrap;
}

.main-tab.active {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 3px 12px rgba(30,58,95,.25);
}

.main-tab:hover:not(.active) {
    background: var(--bg);
    color: var(--primary);
}

/* Mobile: tab text with icon stacked */
@media (max-width: 480px) {
    .main-tab { min-width: 76px; font-size: 11px; padding: 7px 6px; }
    .main-tab .tab-text { display: none; }
}

/* ═══════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════ */
.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-card);
    padding: 18px 16px;
    height: 100%;
    transition: transform var(--transition), box-shadow var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: .04;
    background: var(--primary);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.stat-icon {
    width: 42px; height: 42px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 12px;
    flex-shrink: 0;
}

.stat-val {
    font-size: clamp(22px, 5vw, 28px);
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
    color: var(--text);
}

.stat-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}

.stat-change {
    font-size: 11px;
    font-weight: 700;
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 2px;
}
.stat-change.up   { color: var(--success); }
.stat-change.down { color: var(--danger); }

/* ═══════════════════════════════════════════
   SECTION TITLE
═══════════════════════════════════════════ */
.section-title {
    font-size: 14px;
    font-weight: 800;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
    color: var(--text);
}

.section-title a,
.section-title .section-link {
    font-size: 12px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    white-space: nowrap;
}

/* ═══════════════════════════════════════════
   CARD BOX
═══════════════════════════════════════════ */
.card-box {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-card);
    padding: 20px;
    box-shadow: var(--shadow-card);
}

/* ═══════════════════════════════════════════
   AKTIVITAS BAR CHART
═══════════════════════════════════════════ */
.aktivitas-chart {
    display: flex;
    align-items: flex-end;
    gap: 5px;
    height: 130px;
    padding: 0 2px;
}

.aktivitas-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    min-width: 0;
}

.aktivitas-count {
    font-size: 9px;
    font-weight: 700;
    color: var(--muted);
    min-height: 13px;
}

.aktivitas-bars {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}

.bar-latihan, .bar-kuis {
    width: 100%;
    border-radius: 4px;
    min-height: 4px;
}

.bar-latihan { background: var(--primary); border-radius: 4px 4px 0 0; }
.bar-kuis    { background: var(--accent);  border-radius: 0 0 4px 4px; }

.aktivitas-day {
    font-size: 9px;
    color: var(--muted);
    font-weight: 600;
}

.aktivitas-legend {
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
}

.legend-dot {
    width: 10px; height: 10px;
    border-radius: 3px;
    display: inline-block;
    flex-shrink: 0;
}

/* ═══════════════════════════════════════════
   DISTRIBUSI NILAI (DONUT)
═══════════════════════════════════════════ */
.donut-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.donut-legend {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px 10px;
    width: 100%;
    margin-top: 12px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
}

.legend-item strong {
    margin-left: auto;
    font-size: 12px;
}

/* ═══════════════════════════════════════════
   PROGRES MAPEL
═══════════════════════════════════════════ */
.mapel-row { margin-bottom: 16px; }
.mapel-row:last-child { margin-bottom: 0; }

.mapel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    gap: 8px;
}

.mapel-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 60%;
}

.mapel-pct {
    font-size: 14px;
    font-weight: 800;
    white-space: nowrap;
}

.custom-bar {
    height: 8px;
    border-radius: 20px;
    background: var(--bg);
    overflow: hidden;
}

.custom-bar-fill {
    height: 100%;
    border-radius: 20px;
    transition: width .6s ease;
}

.mapel-detail {
    display: flex;
    gap: 10px;
    margin-top: 5px;
    flex-wrap: wrap;
}

.mapel-detail span {
    font-size: 11px;
    color: var(--muted);
}

.mapel-detail strong { color: var(--text); }

/* ═══════════════════════════════════════════
   ACHIEVEMENT GRID
═══════════════════════════════════════════ */
.achieve-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

@media (max-width: 400px) {
    .achieve-grid { grid-template-columns: repeat(2, 1fr); }
}

.achieve-card {
    background: var(--bg);
    border-radius: 12px;
    padding: 12px 10px;
    text-align: center;
    transition: transform var(--transition);
    border: 1px solid transparent;
}

.achieve-card:hover { transform: translateY(-2px); }

.achieve-card.unlocked {
    background: linear-gradient(135deg, var(--accent-soft), #fffbeb);
    border-color: var(--accent);
}

.achieve-card.locked {
    opacity: .4;
    filter: grayscale(1);
}

.achieve-icon { font-size: 26px; margin-bottom: 5px; }
.achieve-title { font-size: 11px; font-weight: 700; color: var(--text); line-height: 1.3; }
.achieve-sub { font-size: 9.5px; color: var(--muted); margin-top: 2px; line-height: 1.3; }

/* ═══════════════════════════════════════════
   RIWAYAT NILAI (KUIS ROW)
═══════════════════════════════════════════ */
.kuis-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}
.kuis-row:last-child { border-bottom: none; padding-bottom: 0; }

.kuis-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}

.kuis-info { flex: 1; min-width: 0; }
.ki-title { font-size: 13px; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ki-sub   { font-size: 11px; color: var(--muted); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.kuis-score { margin-left: auto; text-align: right; flex-shrink: 0; }
.ks-val   { font-size: 20px; font-weight: 800; line-height: 1; }
.ks-grade { font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-top: 2px; }
.ks-date  { font-size: 10px; color: var(--muted); margin-top: 3px; }

/* ═══════════════════════════════════════════
   STATISTIK NILAI SIDEBAR
═══════════════════════════════════════════ */
.stat-nilai-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    border-bottom: 1px solid var(--border);
}
.stat-nilai-row:last-child { border-bottom: none; }
.stat-nilai-label { font-size: 12.5px; color: var(--muted); }
.stat-nilai-val   { font-size: 17px; font-weight: 800; }

.tren-mini {
    background: var(--bg);
    border-radius: 10px;
    padding: 12px;
    margin-top: 10px;
}

.tren-mini-label {
    font-size: 11px;
    color: var(--muted);
    margin-bottom: 8px;
    font-weight: 600;
}

.tren-mini-chart {
    display: flex;
    align-items: flex-end;
    gap: 5px;
    height: 50px;
}

/* ═══════════════════════════════════════════
   REKOMENDASI CARD
═══════════════════════════════════════════ */
.rekomendasi-card {
    background: linear-gradient(135deg, var(--accent-soft), #fffbeb);
    border: 1px solid var(--accent);
    border-radius: var(--radius-card);
    padding: 16px;
}

.rekomendasi-title {
    font-size: 13px;
    font-weight: 800;
    color: var(--warning);
    margin-bottom: 8px;
}

.rekomendasi-text {
    font-size: 12.5px;
    color: #78350F;
    line-height: 1.6;
}

.btn-mulai {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 10px;
    background: var(--warning);
    color: #fff;
    border-radius: 8px;
    border: none;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 14px;
    text-decoration: none;
    transition: opacity var(--transition);
}
.btn-mulai:hover { opacity: .85; color: #fff; }

/* ═══════════════════════════════════════════
   COMPARE BAR
═══════════════════════════════════════════ */
.compare-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.compare-row:last-child { margin-bottom: 0; }

.compare-label {
    font-size: 12px;
    font-weight: 600;
    width: 90px;
    flex-shrink: 0;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.c-bar {
    height: 18px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    padding-left: 7px;
    font-size: 10.5px;
    font-weight: 700;
    color: #fff;
    transition: width .7s ease;
    min-width: 28px;
}

/* ═══════════════════════════════════════════
   KEMAMPUAN GRID
═══════════════════════════════════════════ */
.kemampuan-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

@media (max-width: 400px) {
    .kemampuan-grid { grid-template-columns: 1fr; }
}

.kemampuan-item {
    background: var(--bg);
    border-radius: 12px;
    padding: 12px 14px;
}

.ki-label {
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--text);
    gap: 4px;
}

.ki-label span {
    font-weight: 800;
    color: var(--primary);
    white-space: nowrap;
}

.ki-label-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 0;
}

.ki-bar { height: 6px; border-radius: 20px; background: var(--border); overflow: hidden; }
.ki-bar-fill { height: 100%; border-radius: 20px; }

/* ═══════════════════════════════════════════
   FOKUS BELAJAR CARD
═══════════════════════════════════════════ */
.fokus-card {
    background: var(--accent-soft);
    border: 1px solid var(--accent);
    border-radius: 12px;
    padding: 12px 14px;
    margin-top: 14px;
}

.fokus-title {
    font-size: 13px;
    font-weight: 800;
    color: var(--warning);
    margin-bottom: 6px;
}

.fokus-text {
    font-size: 12.5px;
    color: #78350F;
    line-height: 1.5;
}

/* ═══════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════ */
.pagination-wrap {
    display: flex;
    justify-content: center;
    gap: 5px;
    margin-top: 16px;
    flex-wrap: wrap;
}

.page-btn {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: 1.5px solid var(--border);
    background: var(--card-bg);
    color: var(--muted);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all var(--transition);
}

.page-btn:hover:not([disabled]) {
    background: var(--bg);
    color: var(--primary);
    border-color: var(--primary);
}

.page-btn.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

.page-btn[disabled] {
    opacity: .4;
    cursor: not-allowed;
}

/* ═══════════════════════════════════════════
   TREN JAM BELAJAR
═══════════════════════════════════════════ */
.jam-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 90px;
    padding: 0 2px;
}

.jam-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.jam-val {
    font-size: 10px;
    font-weight: 600;
}

.jam-bar {
    width: 100%;
    border-radius: 6px 6px 0 0;
    min-height: 6px;
    transition: height .5s ease;
}

.jam-label {
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: clip;
    max-width: 100%;
    text-align: center;
}

/* ═══════════════════════════════════════════
   DOWNLOAD OVERLAY
═══════════════════════════════════════════ */
#download-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

#download-overlay.show { display: flex; }

.dl-box {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 32px 36px;
    text-align: center;
    width: 100%;
    max-width: 280px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: fadeUp .25s ease;
}

@keyframes fadeUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

.dl-spinner {
    width: 48px; height: 48px;
    border: 4px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin .8s linear infinite;
    margin: 0 auto 16px;
}

@keyframes spin { to { transform: rotate(360deg); } }

.dl-title    { font-size: 15px; font-weight: 800; color: var(--text); margin-bottom: 5px; }
.dl-subtitle { font-size: 12px; color: var(--muted); margin-bottom: 16px; line-height: 1.5; }

.dl-dots span {
    display: inline-block;
    width: 7px; height: 7px;
    background: var(--primary);
    border-radius: 50%;
    margin: 0 3px;
    animation: bounce .8s ease infinite;
}
.dl-dots span:nth-child(2) { animation-delay: .15s; }
.dl-dots span:nth-child(3) { animation-delay: .30s; }

@keyframes bounce {
    0%,80%,100% { transform: scale(.6); opacity: .4; }
    40%          { transform: scale(1);  opacity: 1; }
}

.dl-cancel-btn {
    margin-top: 14px;
    font-size: 12px;
    color: var(--muted);
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: underline;
    display: block;
    width: 100%;
}
.dl-cancel-btn:hover { color: var(--danger); }

/* ═══════════════════════════════════════════
   RESPONSIVE BREAKPOINTS
═══════════════════════════════════════════ */
@media (max-width: 576px) {
    .card-box { padding: 16px; }
    .stat-card { padding: 14px; }
    .stat-icon { width: 38px; height: 38px; font-size: 16px; margin-bottom: 10px; }

    /* Stack header on very small screens */
    .page-header { flex-direction: column; }
    .page-header-actions { width: 100%; justify-content: flex-end; }

    /* Aktivitas chart smaller gap */
    .aktivitas-chart { gap: 3px; height: 110px; }

    /* Achievement 2 col on small */
    .achieve-grid { grid-template-columns: repeat(2, 1fr); }

    /* Donut smaller */
    .donut-svg { width: 110px !important; height: 110px !important; }
}

@media (max-width: 400px) {
    .page-header-actions { flex-wrap: wrap; }
    .filter-select { flex: 1; min-width: 0; }
    .btn-download  { flex: 1; justify-content: center; }
}

@media (min-width: 992px) {
    .aktivitas-chart { gap: 8px; }
}
</style>
@endpush

@section('content')

{{-- DOWNLOAD OVERLAY --}}
<div id="download-overlay">
    <div class="dl-box">
        <div class="dl-spinner"></div>
        <div class="dl-title" id="dl-title">Menyiapkan File...</div>
        <div class="dl-subtitle" id="dl-subtitle">Mohon tunggu, sedang memproses dokumenmu</div>
        <div class="dl-dots">
            <span></span><span></span><span></span>
        </div>
        <button class="dl-cancel-btn" onclick="hideDownloadOverlay()">Batal / Tutup</button>
    </div>
</div>

<iframe id="download-frame" style="display:none;"></iframe>

{{-- ══════ PAGE HEADER ══════ --}}
<div class="page-header">
    <div class="page-header-left">
        <h4>📊 Hasil &amp; Progres Belajar</h4>
        <div class="breadcrumb-text">
            Dashboard / <span>Hasil &amp; Progres</span>
        </div>
    </div>
    <div class="page-header-actions">
        <select id="filter-periode" class="filter-select">
            <option value="bulan_ini">Bulan Ini</option>
            <option value="3_bulan">3 Bulan Terakhir</option>
            <option value="6_bulan">6 Bulan Terakhir</option>
            <option value="semua">Semua Waktu</option>
        </select>
        <div class="dropdown">
            <button class="btn-download dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i>
                <span>Unduh</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end"
                style="border-radius:12px;border:1px solid var(--border);padding:6px;min-width:170px;">
                <li>
                    <a href="#" onclick="startDownload('excel'); return false;"
                       class="dropdown-item"
                       style="border-radius:8px;font-size:13px;font-weight:600;padding:8px 12px;">
                        <i class="bi bi-file-earmark-excel me-2" style="color:#16a34a;"></i> Excel
                    </a>
                </li>
                <li>
                    <a href="#" onclick="startDownload('pdf'); return false;"
                       class="dropdown-item"
                       style="border-radius:8px;font-size:13px;font-weight:600;padding:8px 12px;">
                        <i class="bi bi-file-earmark-pdf me-2" style="color:#dc2626;"></i> PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- ══════ TABS ══════ --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'ringkasan')">
        <i class="bi bi-grid"></i> <span class="tab-text">Ringkasan</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'nilai')">
        <i class="bi bi-trophy"></i> <span class="tab-text">Nilai</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'progres')">
        <i class="bi bi-graph-up"></i> <span class="tab-text">Perkembangan</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'kemampuan')">
        <i class="bi bi-stars"></i> <span class="tab-text">Kemampuan</span>
    </button>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 1: RINGKASAN
══════════════════════════════════════════════════════ --}}
<div id="tab-ringkasan">

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="stat-val">{{ $rataRataNilai }}</div>
                <div class="stat-label">Rata-rata Nilai</div>
                <div class="stat-change {{ $selisihNilai >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $selisihNilai >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ $selisihNilai >= 0 ? '+' : '' }}{{ $selisihNilai }} dari bulan lalu
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--success-soft);color:var(--success);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-val">{{ $latihanSelesai }}</div>
                <div class="stat-label">Latihan Selesai</div>
                <div class="stat-change up">
                    <i class="bi bi-arrow-up-short"></i>+{{ $latihanMingguIni }} minggu ini
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--info-soft);color:var(--info);">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div class="stat-val">{{ $kuisDikerjakan }}</div>
                <div class="stat-label">Kuis Dikerjakan</div>
                <div class="stat-change {{ $selisihKuis >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $selisihKuis >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ $selisihKuis >= 0 ? '+' : '' }}{{ $selisihKuis }} dari bulan lalu
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="stat-val">{{ $jamBelajar }}<small style="font-size:13px;font-weight:500;">j</small></div>
                <div class="stat-label">Total Jam Belajar</div>
                <div class="stat-change up">
                    <i class="bi bi-arrow-up-short"></i>+{{ $jamBulanIni }}j bulan ini
                </div>
            </div>
        </div>
    </div>

    {{-- CHART ROW --}}
    <div class="row g-3 mb-4">
        {{-- AKTIVITAS CHART --}}
        <div class="col-12 col-lg-8">
            <div class="card-box h-100">
                <div class="section-title">
                    <span>📈 Aktivitas Belajar Mingguan</span>
                    <div class="aktivitas-legend">
                        <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                            <span class="legend-dot" style="background:var(--primary);"></span> Latihan
                        </span>
                        <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                            <span class="legend-dot" style="background:var(--accent);"></span> Kuis
                        </span>
                    </div>
                </div>
                @php
                    $maxAktivitas = max(array_map(fn($d) => max($d['latihan'] + $d['kuis'], 1), $aktivitasMingguan));
                @endphp
                <div class="aktivitas-chart">
                    @foreach($aktivitasMingguan as $idx => $day)
                    @php
                        $totalH = $day['latihan'] + $day['kuis'];
                        $pctL   = $maxAktivitas > 0 ? round(($day['latihan'] / $maxAktivitas) * 100) : 0;
                        $pctK   = $maxAktivitas > 0 ? round(($day['kuis']    / $maxAktivitas) * 100) : 0;
                        $isLast = $idx === count($aktivitasMingguan) - 1;
                        $alpha  = $isLast ? '.45' : '.9';
                    @endphp
                    <div class="aktivitas-col">
                        <div class="aktivitas-count">{{ $totalH > 0 ? $totalH : '' }}</div>
                        <div class="aktivitas-bars" style="flex:1;">
                            <div class="bar-latihan" style="height:{{ max($pctL,3) }}px;opacity:{{ $alpha }};"></div>
                            <div class="bar-kuis"    style="height:{{ max($pctK,2) }}px;opacity:{{ $alpha }};"></div>
                        </div>
                        <div class="aktivitas-day">{{ $day['hari'] }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="text-align:center;font-size:11px;color:var(--muted);margin-top:10px;">
                    Total <strong>{{ $totalAktivitasMinggu }}</strong> aktivitas minggu ini
                    · Rata-rata <strong>{{ $rataHari }}</strong>/hari
                </div>
            </div>
        </div>

        {{-- DISTRIBUSI NILAI --}}
        <div class="col-12 col-lg-4">
            <div class="card-box h-100">
                <div class="section-title"><span>🎯 Distribusi Nilai</span></div>
                @php
                    $keliling = 314;
                    $dashA    = round($distribusi['A'] / 100 * $keliling);
                    $offsetB  = -$dashA;
                    $dashB    = round($distribusi['B'] / 100 * $keliling);
                    $offsetC  = -($dashA + $dashB);
                    $dashC    = round($distribusi['C'] / 100 * $keliling);
                    $offsetD  = -($dashA + $dashB + $dashC);
                    $dashD    = round($distribusi['D'] / 100 * $keliling);
                @endphp
                <div class="donut-wrap">
                    <div style="position:relative;display:inline-block;">
                        <svg class="donut-svg" viewBox="0 0 120 120" width="130" height="130" style="transform:rotate(-90deg);">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--border)" stroke-width="16"/>
                            @if($distribusi['A'] > 0)
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--primary)" stroke-width="16"
                                stroke-dasharray="{{ $dashA }} {{ $keliling - $dashA }}" stroke-linecap="round"/>
                            @endif
                            @if($distribusi['B'] > 0)
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--info)" stroke-width="16"
                                stroke-dasharray="{{ $dashB }} {{ $keliling - $dashB }}"
                                stroke-dashoffset="{{ $offsetB }}" stroke-linecap="round"/>
                            @endif
                            @if($distribusi['C'] > 0)
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--success)" stroke-width="16"
                                stroke-dasharray="{{ $dashC }} {{ $keliling - $dashC }}"
                                stroke-dashoffset="{{ $offsetC }}" stroke-linecap="round"/>
                            @endif
                            @if($distribusi['D'] > 0)
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--accent)" stroke-width="16"
                                stroke-dasharray="{{ $dashD }} {{ $keliling - $dashD }}"
                                stroke-dashoffset="{{ $offsetD }}" stroke-linecap="round"/>
                            @endif
                        </svg>
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                            <div style="font-size:20px;font-weight:800;color:var(--primary);">{{ $rataRataNilai }}</div>
                            <div style="font-size:10px;color:var(--muted);">Rata-rata</div>
                        </div>
                    </div>
                    <div class="donut-legend">
                        <div class="legend-item">
                            <span class="legend-dot" style="background:var(--primary);"></span>
                            <span style="font-size:11.5px;">A (87–100)</span>
                            <strong>{{ $distribusi['A'] }}%</strong>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background:var(--info);"></span>
                            <span style="font-size:11.5px;">B (70–86)</span>
                            <strong>{{ $distribusi['B'] }}%</strong>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background:var(--success);"></span>
                            <span style="font-size:11.5px;">C (55–69)</span>
                            <strong>{{ $distribusi['C'] }}%</strong>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background:var(--accent);"></span>
                            <span style="font-size:11.5px;">D (&lt;55)</span>
                            <strong>{{ $distribusi['D'] }}%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PROGRES MAPEL + ACHIEVEMENT --}}
    <div class="row g-3 mb-4">
        {{-- PROGRES MAPEL --}}
        <div class="col-12 col-lg-7">
            <div class="card-box">
                <div class="section-title"><span>📚 Progres per Mata Pelajaran</span></div>
                @php
                    $warnaMapel = [
                        'matematika'       => ['var(--primary)',       'linear-gradient(90deg,var(--primary),var(--primary-light))'],
                        'fisika'           => ['var(--info)',          'linear-gradient(90deg,var(--info),#67E8F9)'],
                        'kimia'            => ['var(--success)',       'linear-gradient(90deg,var(--success),#6EE7B7)'],
                        'biologi'          => ['var(--accent)',        'linear-gradient(90deg,var(--accent),#FCD34D)'],
                        'b. indonesia'     => ['var(--danger)',        'linear-gradient(90deg,var(--danger),#FCA5A5)'],
                        'bahasa indonesia' => ['var(--danger)',        'linear-gradient(90deg,var(--danger),#FCA5A5)'],
                        'b. inggris'       => ['var(--warning)',       'linear-gradient(90deg,var(--warning),#FCD34D)'],
                        'bahasa inggris'   => ['var(--warning)',       'linear-gradient(90deg,var(--warning),#FCD34D)'],
                    ];
                    $defaultWarna = ['var(--primary-light)', 'linear-gradient(90deg,var(--primary-light),#C7D2FE)'];
                    $emojiMapel   = [
                        'matematika'       => '🔢', 'fisika'           => '⚡', 'kimia'          => '🧪',
                        'biologi'          => '🌿', 'b. indonesia'     => '📝', 'bahasa indonesia'=> '📝',
                        'b. inggris'       => '🌍', 'bahasa inggris'   => '🌍',
                    ];
                @endphp
                @forelse($progresMapel as $namaMapel => $data)
                @php
                    $key   = strtolower($namaMapel);
                    $warna = $warnaMapel[$key] ?? $defaultWarna;
                    $emoji = $emojiMapel[$key] ?? '📖';
                @endphp
                <div class="mapel-row">
                    <div class="mapel-head">
                        <span class="mapel-name">{{ $emoji }} {{ $namaMapel }}</span>
                        <span class="mapel-pct" style="color:{{ $warna[0] }};">{{ $data['pct'] }}%</span>
                    </div>
                    <div class="custom-bar">
                        <div class="custom-bar-fill" style="width:{{ $data['pct'] }}%;background:{{ $warna[1] }};"></div>
                    </div>
                    <div class="mapel-detail">
                        <span>Soal: <strong>{{ $data['totalSoal'] }}</strong></span>
                        <span>Benar: <strong>{{ $data['totalBenar'] }}</strong></span>
                        <span>Rata-rata: <strong>{{ $data['rata'] }}</strong></span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:28px;color:var(--muted);font-size:13px;">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    Belum ada data. Mulai kerjakan latihan soal!
                </div>
                @endforelse
            </div>
        </div>

        {{-- ACHIEVEMENT --}}
        <div class="col-12 col-lg-5">
            <div class="card-box">
                <div class="section-title"><span>🏆 Pencapaian</span></div>
                @php
                    $achievements = [
                        ['🔥', 'Streak 5 Hari',    'Belajar 5 hari berturut',  $totalAktivitasMinggu >= 5],
                        ['⭐', 'Nilai Sempurna',    'Skor 100 di kuis',         \App\Models\HasilKuis::where('user_id', auth()->id())->where('nilai', 100)->exists()],
                        ['📚', 'Kutu Buku',         'Selesai 5 materi',         $latihanSelesai >= 5],
                        ['⚡', 'Kilat!',            'Kuis < 10 menit',          \App\Models\HasilKuis::where('user_id', auth()->id())->where('tipe','kuis')->where('durasi_menit','<',10)->where('durasi_menit','>',0)->exists()],
                        ['🥇', 'Juara Mapel',       'Rata-rata 95+ semua',      $rataRataNilai >= 95],
                        ['🌙', 'Belajar Malam',     'Latihan > 22:00',          \App\Models\HasilKuis::where('user_id', auth()->id())->whereTime('created_at','>=','22:00:00')->exists()],
                    ];
                    $unlocked = collect($achievements)->filter(fn($a) => $a[3])->count();
                @endphp
                <div class="achieve-grid">
                    @foreach($achievements as $a)
                    <div class="achieve-card {{ $a[3] ? 'unlocked' : 'locked' }}">
                        <div class="achieve-icon">{{ $a[0] }}</div>
                        <div class="achieve-title">{{ $a[1] }}</div>
                        <div class="achieve-sub">{{ $a[2] }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="text-align:center;font-size:12px;color:var(--muted);margin-top:12px;padding-top:10px;border-top:1px solid var(--border);">
                    <strong style="color:var(--primary);">{{ $unlocked }}</strong>
                    dari {{ count($achievements) }} pencapaian terbuka
                </div>
            </div>
        </div>
    </div>

</div>{{-- /tab-ringkasan --}}

{{-- ══════════════════════════════════════════════════════
     TAB 2: NILAI
══════════════════════════════════════════════════════ --}}
<div id="tab-nilai" style="display:none;">
    <div class="row g-3 mb-4">

        {{-- RIWAYAT NILAI --}}
        <div class="col-12 col-lg-8">
            <div class="card-box">
                <div class="section-title">
                    <span>📋 Riwayat Nilai</span>
                    <span class="section-link" style="cursor:default;color:var(--muted);">
                        {{ $riwayatNilai->total() }} hasil
                    </span>
                </div>
                @php
                    $ikonMapelNilai = [
                        'matematika'       => ['bi-calculator-fill', '#eff6ff',             'var(--primary)'],
                        'fisika'           => ['bi-lightning-fill',  'var(--info-soft)',    'var(--info)'],
                        'kimia'            => ['bi-flask-fill',      'var(--success-soft)', 'var(--success)'],
                        'biologi'          => ['bi-flower1',         'var(--accent-soft)',  'var(--warning)'],
                        'b. indonesia'     => ['bi-journal-text',    'var(--danger-soft)',  'var(--danger)'],
                        'bahasa indonesia' => ['bi-journal-text',    'var(--danger-soft)',  'var(--danger)'],
                    ];
                    $defIkon = ['bi-book-fill','#f1f5f9','#64748b'];
                @endphp
                @forelse($riwayatNilai as $h)
                @php
                    $mapelKey   = strtolower($h->materi->mata_pelajaran ?? '');
                    $ik         = $ikonMapelNilai[$mapelKey] ?? $defIkon;
                    $grade      = $h->nilai >= 87 ? 'A' : ($h->nilai >= 70 ? 'B' : ($h->nilai >= 55 ? 'C' : 'D'));
                    $gradeColor = $h->nilai >= 87 ? 'var(--primary)' : ($h->nilai >= 70 ? 'var(--info)' : ($h->nilai >= 55 ? 'var(--warning)' : 'var(--danger)'));
                    $gradeBg    = $h->nilai >= 87 ? '#eff6ff' : ($h->nilai >= 70 ? 'var(--info-soft)' : ($h->nilai >= 55 ? 'var(--accent-soft)' : 'var(--danger-soft)'));
                @endphp
                <div class="kuis-row">
                    <div class="kuis-icon" style="background:{{ $ik[1] }};color:{{ $ik[2] }};">
                        <i class="bi {{ $ik[0] }}"></i>
                    </div>
                    <div class="kuis-info">
                        <div class="ki-title">{{ $h->materi->judul ?? 'Materi Dihapus' }}</div>
                        <div class="ki-sub">
                            {{ $h->materi->mata_pelajaran ?? '-' }} ·
                            {{ ucfirst($h->tipe) }} ·
                            {{ $h->total_soal }} soal ·
                            {{ $h->durasi_menit }} mnt
                        </div>
                    </div>
                    <div class="kuis-score">
                        <div class="ks-val" style="color:{{ $gradeColor }};">{{ $h->nilai }}</div>
                        <span class="ks-grade" style="background:{{ $gradeBg }};color:{{ $gradeColor }};">{{ $grade }}</span>
                        <div class="ks-date">{{ $h->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:28px;color:var(--muted);font-size:13px;">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    Belum ada riwayat nilai.
                </div>
                @endforelse

                @if($riwayatNilai->hasPages())
                <div class="pagination-wrap">
                    @if($riwayatNilai->onFirstPage())
                        <button class="page-btn" disabled><i class="bi bi-chevron-left"></i></button>
                    @else
                        <a href="{{ $riwayatNilai->previousPageUrl() }}#tab-nilai" class="page-btn">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($riwayatNilai->getUrlRange(1, $riwayatNilai->lastPage()) as $page => $url)
                        <a href="{{ $url }}#tab-nilai"
                           class="page-btn {{ $page == $riwayatNilai->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($riwayatNilai->hasMorePages())
                        <a href="{{ $riwayatNilai->nextPageUrl() }}#tab-nilai" class="page-btn">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <button class="page-btn" disabled><i class="bi bi-chevron-right"></i></button>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- STATISTIK NILAI --}}
        <div class="col-12 col-lg-4">
            <div class="card-box mb-3">
                <div class="section-title"><span>📊 Statistik Nilai</span></div>
                @php
                    $statsNilai = [
                        ['Nilai Tertinggi',  $nilaiTertinggi,  'var(--success)'],
                        ['Nilai Terendah',   $nilaiTerendah,   'var(--danger)'],
                        ['Nilai Rata-rata',  $rataRataNilai,   'var(--primary)'],
                        ['Total Dikerjakan', $totalHasil,      'var(--text)'],
                    ];
                @endphp
                @foreach($statsNilai as $s)
                <div class="stat-nilai-row">
                    <span class="stat-nilai-label">{{ $s[0] }}</span>
                    <span class="stat-nilai-val" style="color:{{ $s[2] }};">{{ $s[1] }}</span>
                </div>
                @endforeach

                <div class="tren-mini">
                    <div class="tren-mini-label">Tren Nilai 6 Terakhir</div>
                    @php $maxTren = $tren6Terakhir->max() ?: 100; @endphp
                    <div class="tren-mini-chart">
                        @forelse($tren6Terakhir as $b)
                        <div style="flex:1;background:{{ $b == $maxTren ? 'var(--primary)' : 'var(--primary-light)' }};border-radius:4px 4px 0 0;height:{{ round(($b/$maxTren)*50) }}px;opacity:.85;" title="{{ $b }}"></div>
                        @empty
                        <div style="flex:1;font-size:11px;color:var(--muted);text-align:center;align-self:center;">Belum ada data</div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($rekomendasiMapel)
            <div class="rekomendasi-card">
                <div class="rekomendasi-title">💡 Rekomendasi</div>
                <div class="rekomendasi-text">
                    Nilai <strong>{{ $rekomendasiMapel['nama'] }}</strong> kamu masih
                    {{ $rekomendasiMapel['rata'] }}. Coba kerjakan lebih banyak latihan soal!
                </div>
                <a href="/siswa/belajar-tka" class="btn-mulai">
                    <i class="bi bi-arrow-right"></i> Mulai Latihan
                </a>
            </div>
            @endif
        </div>

    </div>
</div>{{-- /tab-nilai --}}

{{-- ══════════════════════════════════════════════════════
     TAB 3: PERKEMBANGAN
══════════════════════════════════════════════════════ --}}
<div id="tab-progres" style="display:none;">
    <div class="row g-3 mb-4">

        {{-- TREN NILAI --}}
        <div class="col-12 col-lg-8">
            <div class="card-box">
                <div class="section-title"><span>📈 Tren Nilai per Pengerjaan</span></div>
                @php
                    $trenNilai = \App\Models\HasilKuis::where('user_id', auth()->id())
                        ->orderBy('created_at','asc')->take(10)
                        ->pluck('nilai')->values();
                    $maxTrenNilai = $trenNilai->max() ?: 100;
                    $svgW  = 460; $svgH = 130;
                    $points = [];
                    $count  = $trenNilai->count();
                    foreach($trenNilai as $idx => $val) {
                        $x = $count > 1 ? round(30 + ($idx / ($count-1)) * ($svgW-60)) : $svgW/2;
                        $y = round($svgH - 20 - (($val/$maxTrenNilai) * ($svgH-40)));
                        $points[] = "$x,$y";
                    }
                    $polyline = implode(' ', $points);
                @endphp
                @if($trenNilai->count() >= 2)
                <div style="position:relative;height:140px;padding:0 4px;overflow:hidden;">
                    <svg viewBox="0 0 {{ $svgW }} {{ $svgH }}" preserveAspectRatio="none" style="width:100%;height:100%;">
                        @foreach([26,52,78,104] as $yLine)
                        <line x1="0" y1="{{ $yLine }}" x2="{{ $svgW }}" y2="{{ $yLine }}" stroke="var(--border)" stroke-width="1"/>
                        @endforeach
                        <polyline points="{{ $polyline }}" fill="none" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        @foreach($trenNilai as $idx => $val)
                        @php
                            $px = $count > 1 ? round(30 + ($idx / ($count-1)) * ($svgW-60)) : $svgW/2;
                            $py = round($svgH - 20 - (($val/$maxTrenNilai) * ($svgH-40)));
                        @endphp
                        <circle cx="{{ $px }}" cy="{{ $py }}" r="{{ $loop->last ? 5 : 4 }}"
                            fill="{{ $loop->last ? '#fff' : 'var(--primary)' }}"
                            stroke="var(--primary)" stroke-width="2"/>
                        <text x="{{ $px }}" y="{{ $py - 8 }}" font-size="8" fill="var(--primary)" text-anchor="middle">{{ $val }}</text>
                        @endforeach
                    </svg>
                </div>
                @else
                <div style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">
                    <i class="bi bi-graph-up" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    Kerjakan minimal 2 latihan untuk melihat tren nilai.
                </div>
                @endif
            </div>
        </div>

        {{-- PERBANDINGAN MAPEL --}}
        <div class="col-12 col-lg-4">
            <div class="card-box">
                <div class="section-title"><span>🆚 Perbandingan Mapel</span></div>
                @php
                    $warnaBar = ['var(--primary)','var(--accent)','var(--success)','var(--info)','var(--danger)'];
                    $idx = 0;
                @endphp
                @forelse($progresMapel as $nm => $data)
                <div class="compare-row">
                    <span class="compare-label" title="{{ $nm }}">{{ Str::limit($nm, 11) }}</span>
                    <div style="flex:1;">
                        <div class="c-bar" style="width:{{ max($data['pct'],8) }}%;background:{{ $warnaBar[$idx % count($warnaBar)] }};">
                            {{ $data['pct'] }}%
                        </div>
                    </div>
                </div>
                @php $idx++; @endphp
                @empty
                <div style="font-size:13px;color:var(--muted);text-align:center;padding:20px;">Belum ada data.</div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- TREN JAM BELAJAR --}}
    <div class="card-box mb-4">
        <div class="section-title">
            <span>⏱️ Tren Jam Belajar per Minggu</span>
            <span style="font-size:12px;color:var(--muted);">Total: <strong>{{ $jamBelajar }}</strong> jam</span>
        </div>
        <div class="jam-chart">
            @foreach($trenJam as $w)
            @php
                $pct    = $maxJam > 0 ? round(($w['menit'] / $maxJam) * 80) : 6;
                $isLast = $loop->last;
            @endphp
            <div class="jam-col">
                <div class="jam-val" style="color:{{ $isLast ? 'var(--primary)' : 'var(--muted)' }};font-weight:{{ $isLast ? '700' : '400' }};">
                    {{ $w['jam'] }}j
                </div>
                <div class="jam-bar"
                     style="height:{{ max($pct,6) }}px;background:{{ $isLast ? 'linear-gradient(180deg,var(--primary),var(--primary-light))' : 'var(--primary-light)' }};opacity:{{ $isLast ? '1' : '.7' }};flex:1;">
                </div>
                <div class="jam-label" style="color:{{ $isLast ? 'var(--primary)' : 'var(--muted)' }};font-weight:{{ $isLast ? '700' : '400' }};">
                    {{ $w['label'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>{{-- /tab-progres --}}

{{-- ══════════════════════════════════════════════════════
     TAB 4: KEMAMPUAN
══════════════════════════════════════════════════════ --}}
<div id="tab-kemampuan" style="display:none;">
    <div class="row g-3 mb-4">

        {{-- RADAR CHART --}}
        <div class="col-12 col-lg-5">
            <div class="card-box text-center">
                <div class="section-title justify-content-center"><span>🧠 Peta Kemampuan</span></div>
                @php
                    $mapelList = collect($progresMapel)->take(6)->values();
                    $total6    = $mapelList->count();
                    $radarPoints = [];
                    $cx = 100; $cy = 100; $r = 70;
                    for ($i = 0; $i < $total6; $i++) {
                        $angle         = deg2rad(-90 + ($i * 360 / max($total6, 1)));
                        $val           = ($mapelList[$i]['pct'] ?? 0) / 100;
                        $radarPoints[] = round($cx + $r * $val * cos($angle)) . ',' . round($cy + $r * $val * sin($angle));
                    }
                    $radarPoly = implode(' ', $radarPoints);
                @endphp
                <svg viewBox="0 0 200 200" width="200" height="200" style="display:block;margin:0 auto;max-width:100%;">
                    @for($ring = 4; $ring >= 1; $ring--)
                    @php
                        $rPts = [];
                        for ($i = 0; $i < max($total6,1); $i++) {
                            $angle  = deg2rad(-90 + ($i * 360 / max($total6,1)));
                            $rPts[] = round($cx + ($r * $ring/4) * cos($angle)) . ',' . round($cy + ($r * $ring/4) * sin($angle));
                        }
                    @endphp
                    <polygon points="{{ implode(' ', $rPts) }}" fill="none" stroke="var(--border)" stroke-width="1"/>
                    @endfor

                    @for($i = 0; $i < $total6; $i++)
                    @php
                        $angle = deg2rad(-90 + ($i * 360 / max($total6,1)));
                        $ex    = round($cx + $r * cos($angle));
                        $ey    = round($cy + $r * sin($angle));
                    @endphp
                    <line x1="{{ $cx }}" y1="{{ $cy }}" x2="{{ $ex }}" y2="{{ $ey }}" stroke="var(--border)" stroke-width="1"/>
                    @endfor

                    @if(count($radarPoints) >= 3)
                    <polygon points="{{ $radarPoly }}" fill="#1e3a5f" fill-opacity="0.15" stroke="var(--primary)" stroke-width="2"/>
                    @endif

                    @foreach($mapelList as $i => $mp)
                    @php
                        $angle = deg2rad(-90 + ($i * 360 / max($total6,1)));
                        $lx    = round($cx + ($r + 20) * cos($angle));
                        $ly    = round($cy + ($r + 20) * sin($angle));
                    @endphp
                    <text x="{{ $lx }}" y="{{ $ly }}" font-size="7.5" fill="var(--text)" text-anchor="middle" font-weight="bold">
                        {{ Str::limit($mp['nama'] ?? '', 8) }} {{ $mp['pct'] }}%
                    </text>
                    @endforeach
                </svg>
            </div>
        </div>

        {{-- DETAIL KEMAMPUAN --}}
        <div class="col-12 col-lg-7">
            <div class="card-box">
                <div class="section-title"><span>🎯 Detail Kemampuan per Mata Pelajaran</span></div>
                @php
                    $warnaKemampuan = [
                        ['var(--primary)',       'var(--primary-light)'],
                        ['var(--success)',       '#6EE7B7'],
                        ['var(--info)',          '#67E8F9'],
                        ['var(--accent)',        '#FCD34D'],
                        ['var(--danger)',        '#FCA5A5'],
                        ['var(--warning)',       '#FED7AA'],
                        ['var(--primary-light)', '#C7D2FE'],
                        ['#0d9488',              '#6EE7B7'],
                    ];
                    $ki = 0;
                @endphp
                <div class="kemampuan-grid">
                    @forelse($kemampuanTopik as $topik => $nilai)
                    @php $wk = $warnaKemampuan[$ki % count($warnaKemampuan)]; $ki++; @endphp
                    <div class="kemampuan-item">
                        <div class="ki-label">
                            <span class="ki-label-text">{{ Str::limit($topik, 18) }}</span>
                            <span>{{ $nilai }}%</span>
                        </div>
                        <div class="ki-bar">
                            <div class="ki-bar-fill" style="width:{{ $nilai }}%;background:linear-gradient(90deg,{{ $wk[0] }},{{ $wk[1] }});"></div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column:span 2;text-align:center;padding:20px;color:var(--muted);font-size:13px;">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                        Belum ada data kemampuan.
                    </div>
                    @endforelse
                </div>

                @if($rekomendasiMapel)
                <div class="fokus-card">
                    <div class="fokus-title">🎯 Fokus Belajar</div>
                    <div class="fokus-text">
                        Prioritas: <strong>{{ $rekomendasiMapel['nama'] }}</strong>
                        – rata-rata {{ $rekomendasiMapel['rata'] }}. Perlu ditingkatkan!
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>{{-- /tab-kemampuan --}}

@endsection

@push('scripts')
<script>
// ── Tab Switcher ─────────────────────────────────────────────────────────
function switchTab(el, id) {
    document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    ['ringkasan', 'nilai', 'progres', 'kemampuan'].forEach(t => {
        document.getElementById('tab-' + t).style.display = (t === id) ? '' : 'none';
    });
    // Scroll ke atas tab content di mobile
    if (window.innerWidth < 768) {
        document.querySelector('.main-tabs').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Buka tab dari anchor hash
document.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash;
    if (hash === '#tab-nilai') {
        document.querySelectorAll('.main-tab')[1].click();
    } else if (hash === '#tab-progres') {
        document.querySelectorAll('.main-tab')[2].click();
    } else if (hash === '#tab-kemampuan') {
        document.querySelectorAll('.main-tab')[3].click();
    }
});

// ── Download Overlay ─────────────────────────────────────────────────────
let downloadTimer = null;

function startDownload(type) {
    const periode = document.getElementById('filter-periode').value;
    const isExcel = type === 'excel';
    const url     = isExcel
        ? `/siswa/hasil-progres/export-excel?periode=${periode}`
        : `/siswa/hasil-progres/export-pdf?periode=${periode}`;

    document.getElementById('dl-title').textContent    = isExcel ? 'Menyiapkan Excel...' : 'Menyiapkan PDF...';
    document.getElementById('dl-subtitle').textContent = isExcel
        ? 'Sedang membangun spreadsheet datamu'
        : 'Sedang merender dokumen PDF';

    document.getElementById('download-overlay').classList.add('show');
    document.getElementById('download-frame').src = url;

    const estimasi = isExcel ? 3500 : 7000;
    downloadTimer  = setTimeout(() => hideDownloadOverlay(), estimasi);

    document.getElementById('download-frame').onload = () => {
        clearTimeout(downloadTimer);
        setTimeout(() => hideDownloadOverlay(), 800);
    };
}

function hideDownloadOverlay() {
    clearTimeout(downloadTimer);
    document.getElementById('download-overlay').classList.remove('show');
    document.getElementById('download-frame').onload = null;
}

document.getElementById('download-overlay').addEventListener('click', function(e) {
    if (e.target === this) hideDownloadOverlay();
});
</script>
@endpush