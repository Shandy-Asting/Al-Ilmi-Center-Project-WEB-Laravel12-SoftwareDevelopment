@extends('layouts.app')

@section('title', 'Dashboard Siswa - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Dashboard')
@section('page-sub', 'Selamat datang kembali! 👋')

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
/* ══════════════════════════════════════════
   GREETING BANNER
══════════════════════════════════════════ */
.greeting-banner {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 55%, #3b6fa0 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}

.greeting-banner::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,.07);
    pointer-events: none;
}

.greeting-banner::after {
    content: '';
    position: absolute;
    bottom: -50px;
    right: 120px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    pointer-events: none;
}

.greeting-banner .tag {
    display: inline-block;
    background: rgba(255,255,255,.18);
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 8px;
}

.greeting-banner h2 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 4px;
}

.greeting-banner p {
    font-size: 13.5px;
    opacity: .8;
    margin-bottom: 18px;
    max-width: 480px;
}

.greeting-banner .btn-banner {
    display: inline-block;
    background: #fff;
    color: var(--primary);
    border: none;
    border-radius: 10px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: transform .15s, box-shadow .15s;
    position: relative;
    z-index: 1;
}

.greeting-banner .btn-banner:hover {
    transform: scale(1.04);
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
    color: var(--primary);
}

.streak-badge {
    position: absolute;
    right: 32px;
    top: 50%;
    transform: translateY(-50%);
    text-align: center;
    z-index: 1;
}

.streak-badge .streak-num {
    font-size: 42px;
    font-weight: 800;
    line-height: 1;
    color: #fff;
}

.streak-badge .streak-label {
    font-size: 12px;
    opacity: .75;
    color: #fff;
}

/* ══════════════════════════════════════════
   STAT CARDS
══════════════════════════════════════════ */
.stat-card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 18px;
    border: 1px solid var(--border);
    height: 100%;
    transition: transform .2s, box-shadow .2s;
    display: flex;
    flex-direction: column;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,.07);
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 12px;
    flex-shrink: 0;
}

.stat-val {
    font-size: 24px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
    word-break: break-all;
}

.stat-label {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.4;
}

.stat-change {
    font-size: 11px;
    font-weight: 600;
    margin-top: 8px;
}

.stat-change.up  { color: var(--success); }
.stat-change.down { color: var(--danger); }

/* ══════════════════════════════════════════
   SECTION TITLE
══════════════════════════════════════════ */
.section-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 6px;
}

.section-title a {
    font-size: 12px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    white-space: nowrap;
}

/* ══════════════════════════════════════════
   PROGRESS CARD
══════════════════════════════════════════ */
.progress-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border);
    padding: 20px;
    height: 100%;
}

.subject-row { margin-bottom: 16px; }
.subject-row:last-of-type { margin-bottom: 0; }

.subj-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}

.subj-name {
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 70%;
}

.subj-pct {
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}

.custom-progress {
    height: 7px;
    border-radius: 10px;
    background: var(--bg);
    overflow: hidden;
}

.custom-progress-bar {
    height: 100%;
    border-radius: 10px;
    transition: width .6s ease;
}

/* Mini Bar Chart */
.mini-bar-chart {
    margin-top: 16px;
    padding: 14px;
    border-radius: 12px;
    background: var(--bg);
}

.mini-bar-chart-bars {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    height: 60px;
    gap: 6px;
}

.mini-bar-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    height: 100%;
}

.mini-bar {
    width: 100%;
    border-radius: 4px 4px 0 0;
    background: var(--primary-light);
    opacity: .6;
    min-height: 6px;
}

.mini-bar.active {
    background: var(--primary);
    opacity: 1;
}

.mini-bar-label {
    font-size: 10px;
    color: var(--muted);
    margin-top: 4px;
}

.mini-bar-caption {
    font-size: 11px;
    color: var(--muted);
    text-align: center;
    margin-top: 8px;
}

/* ══════════════════════════════════════════
   JADWAL CARD
══════════════════════════════════════════ */
.jadwal-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    transition: box-shadow .2s;
}

.jadwal-card:last-child { margin-bottom: 0; }

.jadwal-card:hover {
    box-shadow: 0 4px 14px rgba(0,0,0,.07);
}

.jadwal-time {
    min-width: 66px;
    text-align: center;
    background: var(--bg);
    border-radius: 10px;
    padding: 8px 6px;
    flex-shrink: 0;
}

.time-val {
    font-size: 14px;
    font-weight: 800;
    color: var(--primary);
    white-space: nowrap;
}

.time-day {
    font-size: 10px;
    color: var(--muted);
    white-space: nowrap;
}

.jadwal-info {
    flex: 1;
    min-width: 0; /* allow truncation */
}

.j-subj {
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.j-tutor {
    font-size: 12px;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.j-type {
    display: inline-block;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 6px;
    margin-top: 4px;
}

.jadwal-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    color: #fff;
    flex-shrink: 0;
}

/* ══════════════════════════════════════════
   REKOMENDASI CARD
══════════════════════════════════════════ */
.rec-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: box-shadow .2s, transform .2s;
    height: 100%;
}

.rec-card:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,.07);
    transform: translateY(-2px);
}

.rec-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.rec-body { min-width: 0; flex: 1; }

.rec-title {
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 3px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.rec-sub {
    font-size: 11.5px;
    color: var(--muted);
    margin-bottom: 10px;
    line-height: 1.5;
}

.btn-rec {
    display: inline-block;
    font-size: 11.5px;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    padding: 5px 14px;
    cursor: pointer;
    text-decoration: none;
    transition: filter .15s;
    white-space: nowrap;
}

.btn-rec:hover { filter: brightness(.93); }

/* ══════════════════════════════════════════
   TESTIMONI
══════════════════════════════════════════ */
.testi-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.testi-stars {
    color: var(--accent);
    font-size: 13px;
    margin-bottom: 8px;
}

.testi-text {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 14px;
    font-style: italic;
    flex: 1;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
}

.testi-user {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: auto;
}

.testi-av {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    color: #fff;
    flex-shrink: 0;
}

.testi-name {
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.testi-kelas {
    font-size: 11px;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ══════════════════════════════════════════
   EMPTY STATE
══════════════════════════════════════════ */
.empty-state {
    text-align: center;
    padding: 32px 16px;
    color: var(--muted);
    background: var(--card-bg);
    border-radius: 14px;
    border: 1px solid var(--border);
}

.empty-state i {
    font-size: 2rem;
    display: block;
    margin-bottom: 8px;
    opacity: .4;
}

.empty-state .empty-title {
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 4px;
    color: var(--text);
}

.empty-state a {
    font-size: 12px;
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */

/* Tablet ≤ 991px */
@media (max-width: 991px) {
    .streak-badge { display: none; }

    .greeting-banner {
        padding: 22px 24px;
    }

    .greeting-banner h2 { font-size: 18px; }
    .greeting-banner p  { font-size: 13px; margin-bottom: 14px; }

    /* Stack progress + jadwal vertically */
    .row.g-3 > [class*='col-lg'] {
        margin-bottom: 0;
    }
}

/* Mobile ≤ 767px */
@media (max-width: 767px) {
    .greeting-banner {
        padding: 20px 18px;
        border-radius: 16px;
        margin-bottom: 18px;
    }

    .greeting-banner h2  { font-size: 17px; }
    .greeting-banner p   { font-size: 12.5px; margin-bottom: 14px; }
    .greeting-banner .btn-banner { font-size: 12px; padding: 7px 16px; }

    /* Stat cards: 2-col grid on mobile */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }

    .stat-card {
        padding: 14px;
        border-radius: 14px;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .stat-val  { font-size: 20px; }
    .stat-label { font-size: 11.5px; }
    .stat-change { font-size: 10.5px; }

    /* Section titles */
    .section-title { font-size: 14px; }

    /* Progress card */
    .progress-card { padding: 16px; }
    .subj-name     { font-size: 12.5px; }
    .subj-pct      { font-size: 12.5px; }

    /* Jadwal */
    .jadwal-card   { padding: 12px 14px; gap: 10px; border-radius: 12px; }
    .jadwal-time   { min-width: 60px; padding: 6px 4px; }
    .time-val      { font-size: 13px; }
    .time-day      { font-size: 9.5px; }
    .j-subj        { font-size: 12.5px; }
    .j-tutor       { font-size: 11.5px; }
    .j-type        { font-size: 10px; }
    .jadwal-avatar { width: 32px; height: 32px; font-size: 12px; }

    /* Rec cards: stack full-width */
    .rec-card      { padding: 14px; border-radius: 12px; }
    .rec-icon      { width: 40px; height: 40px; font-size: 18px; }
    .rec-title     { font-size: 12.5px; }
    .rec-sub       { font-size: 11px; }

    /* Testi */
    .testi-card    { padding: 14px; }
    .testi-text    { font-size: 12.5px; -webkit-line-clamp: 3; }
    .testi-name    { font-size: 12.5px; }
}

/* Very small ≤ 399px */
@media (max-width: 399px) {
    .greeting-banner h2 { font-size: 15px; }
    .stat-val            { font-size: 18px; }
    .jadwal-time         { min-width: 54px; }
    .time-val            { font-size: 12px; }
}
</style>
@endpush

@section('content')

{{-- ╔══════════════════════════════════════════╗
     ║  GREETING BANNER                        ║
     ╚══════════════════════════════════════════╝ --}}
<div class="greeting-banner">
    <span class="tag">🌟 Selamat Datang Kembali!</span>
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Kamu sudah belajar <strong>{{ $streak }} hari berturut-turut</strong>. Teruskan semangatmu hari ini!</p>
    <a href="/siswa/belajar-tka" class="btn-banner">
        <i class="bi bi-play-fill me-1"></i> Lanjutkan Belajar
    </a>
    <div class="streak-badge">
        <div style="font-size:22px;">🔥</div>
        <div class="streak-num">{{ $streak }}</div>
        <div class="streak-label">Hari Streak</div>
    </div>
</div>

{{-- ╔══════════════════════════════════════════╗
     ║  STAT CARDS                             ║
     ╚══════════════════════════════════════════╝ --}}

{{-- Desktop: Bootstrap row; Mobile: CSS grid via wrapper class --}}
<div class="stat-grid d-md-none mb-3">
    {{-- shown only on mobile via CSS grid --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;color:var(--primary);">
            <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <div class="stat-val">{{ $rataRataNilai }}</div>
        <div class="stat-label">Rata-rata Nilai</div>
        <div class="stat-change {{ $selisihNilai >= 0 ? 'up' : 'down' }}">
            <i class="bi bi-arrow-{{ $selisihNilai >= 0 ? 'up' : 'down' }}-short"></i>
            {{ $selisihNilai >= 0 ? '+' : '' }}{{ $selisihNilai }} minggu lalu
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--success-soft);color:var(--success);">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="stat-val">{{ $soalDiselesaikan }}</div>
        <div class="stat-label">Soal Diselesaikan</div>
        <div class="stat-change up">
            <i class="bi bi-arrow-up-short"></i>+{{ $soalMingguIni }} minggu ini
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);">
            <i class="bi bi-clock-fill"></i>
        </div>
        <div class="stat-val">{{ $jamBulanIni }}<span style="font-size:13px;font-weight:500;">j</span></div>
        <div class="stat-label">Jam Belajar Bulan Ini</div>
        <div class="stat-change {{ $selisihJam >= 0 ? 'up' : 'down' }}">
            <i class="bi bi-arrow-{{ $selisihJam >= 0 ? 'up' : 'down' }}-short"></i>
            {{ $selisihJam >= 0 ? '+' : '' }}{{ $selisihJam }}j bulan lalu
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);">
            <i class="bi bi-trophy-fill"></i>
        </div>
        <div class="stat-val">{{ $lesPrivat }}</div>
        <div class="stat-label">Les Privat Bulan Ini</div>
        <div class="stat-change {{ $selisihLes >= 0 ? 'up' : 'down' }}">
            <i class="bi bi-arrow-{{ $selisihLes >= 0 ? 'up' : 'down' }}-short"></i>
            {{ $selisihLes >= 0 ? '+' : '' }}{{ $selisihLes }} bulan lalu
        </div>
    </div>
</div>

{{-- Desktop stat cards (Bootstrap grid) --}}
<div class="row g-3 mb-4 d-none d-md-flex">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:var(--primary);">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div class="stat-val">{{ $rataRataNilai }}</div>
            <div class="stat-label">Rata-rata Nilai</div>
            <div class="stat-change {{ $selisihNilai >= 0 ? 'up' : 'down' }}">
                <i class="bi bi-arrow-{{ $selisihNilai >= 0 ? 'up' : 'down' }}-short"></i>
                {{ $selisihNilai >= 0 ? '+' : '' }}{{ $selisihNilai }} dari minggu lalu
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-val">{{ $soalDiselesaikan }}</div>
            <div class="stat-label">Soal Diselesaikan</div>
            <div class="stat-change up">
                <i class="bi bi-arrow-up-short"></i>+{{ $soalMingguIni }} minggu ini
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);">
                <i class="bi bi-clock-fill"></i>
            </div>
            <div class="stat-val">{{ $jamBulanIni }}<span style="font-size:14px;font-weight:500;">j</span></div>
            <div class="stat-label">Jam Belajar Bulan Ini</div>
            <div class="stat-change {{ $selisihJam >= 0 ? 'up' : 'down' }}">
                <i class="bi bi-arrow-{{ $selisihJam >= 0 ? 'up' : 'down' }}-short"></i>
                {{ $selisihJam >= 0 ? '+' : '' }}{{ $selisihJam }}j bulan lalu
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);">
                <i class="bi bi-trophy-fill"></i>
            </div>
            <div class="stat-val">{{ $lesPrivat }}</div>
            <div class="stat-label">Les Privat Bulan Ini</div>
            <div class="stat-change {{ $selisihLes >= 0 ? 'up' : 'down' }}">
                <i class="bi bi-arrow-{{ $selisihLes >= 0 ? 'up' : 'down' }}-short"></i>
                {{ $selisihLes >= 0 ? '+' : '' }}{{ $selisihLes }} dari bulan lalu
            </div>
        </div>
    </div>
</div>

{{-- ╔══════════════════════════════════════════╗
     ║  PROGRES + JADWAL                       ║
     ╚══════════════════════════════════════════╝ --}}
<div class="row g-3 mb-4">

    {{-- Progres Belajar --}}
    <div class="col-12 col-lg-5">
        <div class="section-title">
            <span>📊 Ringkasan Progres Belajar</span>
            <a href="/siswa/hasil-progres">Lihat Detail →</a>
        </div>
        <div class="progress-card">
            @php
                $warna = ['var(--primary)','var(--info)','var(--success)','var(--accent)','var(--danger)'];
                $gradients = [
                    'linear-gradient(90deg,var(--primary),var(--primary-light))',
                    'linear-gradient(90deg,var(--info),#67E8F9)',
                    'linear-gradient(90deg,var(--success),#6EE7B7)',
                    'linear-gradient(90deg,var(--accent),#FCD34D)',
                    'linear-gradient(90deg,var(--danger),#FCA5A5)',
                ];
            @endphp

            @forelse($progresMapel as $idx => $p)
            <div class="subject-row">
                <div class="subj-head">
                    <span class="subj-name">{{ $p['nama'] }}</span>
                    <span class="subj-pct" style="color:{{ $warna[$idx % 5] }};">{{ $p['pct'] }}%</span>
                </div>
                <div class="custom-progress">
                    <div class="custom-progress-bar"
                         style="width:{{ $p['pct'] }}%;background:{{ $gradients[$idx % 5] }};"></div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-graph-up"></i>
                <div class="empty-title">Belum ada data progres</div>
                <a href="/siswa/belajar-tka">Mulai kerjakan soal →</a>
            </div>
            @endforelse

            {{-- Mini Bar Chart --}}
            <div class="mini-bar-chart">
                <div class="mini-bar-chart-bars">
                    @foreach($aktivitasMingguan as $idx => $a)
                    @php $tinggi = $maxAktivitas > 0 ? max(6, round($a['menit'] / $maxAktivitas * 52)) : 6; @endphp
                    <div class="mini-bar-wrap">
                        <div class="mini-bar {{ $idx >= 4 ? 'active' : '' }}"
                             style="height:{{ $tinggi }}px;"></div>
                        <div class="mini-bar-label">{{ $a['hari'] }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="mini-bar-caption">Aktivitas Belajar Mingguan</div>
            </div>
        </div>
    </div>

    {{-- Jadwal Terdekat --}}
    <div class="col-12 col-lg-7">
        <div class="section-title">
            <span>📅 Jadwal Terdekat dengan Tutor</span>
            <a href="/siswa/les-privat">Lihat Semua →</a>
        </div>

        @forelse($jadwalTerdekat as $j)
        <div class="jadwal-card">
            <div class="jadwal-time">
                <div class="time-val">{{ $j->jadwal->format('H.i') }}</div>
                <div class="time-day">{{ $j->jadwal->translatedFormat('l, d M') }}</div>
            </div>
            <div class="jadwal-info">
                <div class="j-subj">
                    {{ $j->mata_pelajaran }}{{ $j->topik ? ' – '.$j->topik : '' }}
                </div>
                <div class="j-tutor">
                    <i class="bi bi-person-fill me-1"></i>{{ $j->tutor->name ?? '-' }}
                </div>
                <span class="j-type"
                      style="background:{{ $j->mode === 'online' ? 'var(--info-soft)' : 'var(--success-soft)' }};
                             color:{{ $j->mode === 'online' ? 'var(--info)' : 'var(--success)' }};">
                    {{ $j->mode === 'online' ? 'Online (Zoom)' : 'Tatap Muka' }}
                </span>
            </div>
            <div class="jadwal-avatar" style="background:var(--primary);">
                {{ strtoupper(substr($j->tutor->name ?? 'T', 0, 2)) }}
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <div class="empty-title">Belum ada jadwal les</div>
            <a href="/siswa/les-privat">Pesan Les Sekarang →</a>
        </div>
        @endforelse
    </div>

</div>

{{-- ╔══════════════════════════════════════════╗
     ║  REKOMENDASI PEMBELAJARAN               ║
     ╚══════════════════════════════════════════╝ --}}
<div class="section-title">
    <span>💡 Rekomendasi Pembelajaran</span>
    <a href="/siswa/belajar-tka">Lihat Semua →</a>
</div>

<div class="row g-3 mb-4">
    @php
    $ikonMap = [
        'matematika'       => ['bi-calculator-fill',     '#eff6ff',           'var(--primary)'],
        'fisika'           => ['bi-lightning-charge-fill','#dbeafe',           '#2563eb'],
        'kimia'            => ['bi-flask-conical-fill',   'var(--success-soft)','var(--success)'],
        'biologi'          => ['bi-tree-fill',            '#f0fdf4',           '#15803d'],
        'bahasa inggris'   => ['bi-translate',            'var(--accent-soft)','var(--warning)'],
        'bahasa indonesia' => ['bi-book-fill',            'var(--danger-soft)','var(--danger)'],
        'ipa'              => ['bi-stars',                '#f0fdf4',           '#0d9488'],
        'ips'              => ['bi-globe2',               '#fef3c7',           '#d97706'],
    ];
    $def = ['bi-journal-text', '#f1f5f9', '#64748b'];
    $btnStyle = [
        0 => ['#eff6ff',           'var(--primary)'],
        1 => ['var(--info-soft)',   'var(--info)'],
        2 => ['var(--accent-soft)','var(--warning)'],
    ];
    @endphp

    @forelse($rekomendasiMateri as $idx => $m)
    @php
        $ik    = $ikonMap[strtolower($m->mata_pelajaran)] ?? $def;
        $btn   = $btnStyle[$idx % 3];
        $label = $m->tipe === 'video'
                    ? 'Tonton Sekarang'
                    : ($m->soal_count > 0 ? 'Mulai Latihan' : 'Buka Materi');
    @endphp
    <div class="col-12 col-md-6 col-lg-4">
        <div class="rec-card">
            <div class="rec-icon" style="background:{{ $ik[1] }};color:{{ $ik[2] }};">
                <i class="bi {{ $ik[0] }}"></i>
            </div>
            <div class="rec-body">
                <div class="rec-title">{{ $m->judul }}</div>
                <div class="rec-sub">
                    {{ $m->mata_pelajaran }} · {{ strtoupper($m->jenjang) }}
                    @if($m->soal_count > 0) · {{ $m->soal_count }} soal @endif
                    @if($m->tipe === 'video') · 📹 Video @endif
                </div>
                <a href="/siswa/belajar-tka" class="btn-rec"
                   style="background:{{ $btn[0] }};color:{{ $btn[1] }};">
                    {{ $label }}
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-journal-x"></i>
            <div class="empty-title">Belum ada materi tersedia</div>
        </div>
    </div>
    @endforelse
</div>

{{-- ╔══════════════════════════════════════════╗
     ║  TESTIMONI                              ║
     ╚══════════════════════════════════════════╝ --}}
<div class="section-title">
    <span>💬 Testimoni Pengguna</span>
    <a href="#">Lihat Semua →</a>
</div>

<div class="row g-3 mb-4">
    @forelse($testimoni as $t)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="testi-card">
            <div class="testi-stars">
                @for($i = 1; $i <= 5; $i++){{ $i <= $t->bintang ? '★' : '☆' }}@endfor
            </div>
            <div class="testi-text">"{{ $t->komentar }}"</div>
            <div class="testi-user">
                <div class="testi-av" style="background:var(--primary);">
                    {{ strtoupper(substr($t->siswa->name ?? 'S', 0, 2)) }}
                </div>
                <div style="min-width:0;">
                    <div class="testi-name">{{ $t->siswa->name ?? '-' }}</div>
                    <div class="testi-kelas">{{ $t->siswa->kota ?? 'Al Ilmi Center' }}</div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-chat-square-dots"></i>
            <div class="empty-title">Belum ada testimoni</div>
        </div>
    </div>
    @endforelse
</div>

@endsection