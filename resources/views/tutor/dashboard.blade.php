@php
if (!isset($menunggu)) {
    $menunggu = collect([]);
}
@endphp

@extends('layouts.app')

@section('title', 'Dashboard Tutor - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Dashboard Tutor')
@section('page-sub', 'Selamat datang kembali!')

@section('sidebar-menu')
<div class="menu-label">Utama</div>
<a href="/tutor/dashboard" class="nav-item-custom {{ request()->is('tutor/dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid-1x2-fill"></i> Dashboard
</a>
<a href="/tutor/jadwal" class="nav-item-custom {{ request()->is('tutor/jadwal') ? 'active' : '' }}">
    <i class="bi bi-calendar3"></i> Jadwal Mengajar
</a>
<a href="/tutor/daftar-siswa" class="nav-item-custom {{ request()->is('tutor/daftar-siswa') ? 'active' : '' }}">
    <i class="bi bi-people-fill"></i> Daftar Siswa
</a>
<a href="/tutor/materi" class="nav-item-custom {{ request()->is('tutor/materi') ? 'active' : '' }}">
    <i class="bi bi-journal-text"></i> Materi Ajar
</a>
<div class="menu-label">Akademik</div>
<a href="/tutor/soal" class="nav-item-custom {{ request()->is('tutor/soal') ? 'active' : '' }}">
    <i class="bi bi-patch-question-fill"></i> Bank Soal
</a>
<a href="/tutor/les-privat" class="nav-item-custom {{ request()->is('tutor/les-privat') ? 'active' : '' }}">
    <i class="bi bi-person-video3"></i> Les Privat
</a>
<a href="/tutor/pembayaran" class="nav-item-custom {{ request()->is('tutor/pembayaran') ? 'active' : '' }}">
    <i class="bi bi-cash-coin"></i> Pembayaran
    <span class="nav-badge">2</span>
</a>
<div class="menu-label">Akun</div>
<a href="/tutor/notifikasi" class="nav-item-custom {{ request()->is('tutor/notifikasi') ? 'active' : '' }}">
    <i class="bi bi-bell-fill"></i> Notifikasi
</a>
<a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> Profil Saya
</a>
@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════ */
* { box-sizing: border-box; }

/* ═══════════════════════════════════════════
   GREETING HEADER
═══════════════════════════════════════════ */
.dash-greeting {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.dash-greeting h4 {
    font-size: 1.1rem;
    font-weight: 800;
    margin: 0;
    color: var(--text);
    line-height: 1.3;
}
.dash-greeting p {
    font-size: .82rem;
    color: var(--muted);
    margin: 2px 0 0;
}
.btn-tambah-jadwal {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--primary);
    color: #fff !important;
    border-radius: 10px;
    border: none;
    font-size: .8rem;
    font-weight: 700;
    padding: 9px 16px;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    transition: opacity .2s;
}
.btn-tambah-jadwal:hover { opacity: .88; }

/* ═══════════════════════════════════════════
   STAT CARDS GRID
═══════════════════════════════════════════ */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}
@media (max-width: 1199px) {
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .stat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
}

.stat-card {
    background: var(--card-bg);
    border-radius: 14px;
    padding: 16px;
    border: 1px solid var(--border);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: transform .2s, box-shadow .2s;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,.07);
}
.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.stat-val {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1;
    color: var(--text);
}
.stat-val span { font-size: .95rem; font-weight: 600; }
.stat-label {
    font-size: .75rem;
    color: var(--muted);
    margin-top: 3px;
    font-weight: 500;
}
.stat-change {
    font-size: .72rem;
    font-weight: 600;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 2px;
}
.stat-change.up   { color: var(--success); }
.stat-change.down { color: var(--danger); }

/* ═══════════════════════════════════════════
   MAIN LAYOUT (Jadwal + Kalender)
═══════════════════════════════════════════ */
.dash-main-row {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 16px;
    margin-bottom: 20px;
    align-items: start;
}
@media (max-width: 1199px) {
    .dash-main-row { grid-template-columns: 1fr 280px; }
}
@media (max-width: 991px) {
    .dash-main-row { grid-template-columns: 1fr; }
}

/* ═══════════════════════════════════════════
   BOTTOM ROW (Aktivitas + Progres)
═══════════════════════════════════════════ */
.dash-bottom-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 991px) {
    .dash-bottom-row { grid-template-columns: 1fr; }
}

/* ═══════════════════════════════════════════
   CARD BOX
═══════════════════════════════════════════ */
.card-box {
    background: var(--card-bg);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
}
.card-box-header {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
}
.card-box-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 6px;
}
.card-box-title i { color: var(--primary); }
.card-box-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

/* ═══════════════════════════════════════════
   JADWAL ITEM
═══════════════════════════════════════════ */
.schedule-item {
    display: grid;
    grid-template-columns: 76px 1fr auto auto;
    align-items: center;
    gap: 12px;
    padding: 13px 18px;
    border-bottom: 1px solid var(--border);
    transition: background .15s;
}
.schedule-item:last-child { border-bottom: none; }
.schedule-item:hover { background: #f8faff; }

.sched-time {
    text-align: center;
    padding: 7px 8px;
    background: var(--bg);
    border-radius: 10px;
}
.time-main { font-size: .88rem; font-weight: 700; color: var(--primary); }
.time-dur  { font-size: .68rem; color: var(--muted); margin-top: 1px; }

.sched-subject { font-weight: 600; font-size: .85rem; color: var(--text); }
.sched-student {
    font-size: .76rem;
    color: var(--muted);
    margin-top: 3px;
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
}

.sched-mode {
    font-size: .69rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
    flex-shrink: 0;
}
.sched-mode.online  { background: var(--success-soft); color: var(--success); }
.sched-mode.offline { background: #f5f3ff; color: #6d28d9; }

.sched-actions { display: flex; gap: 6px; flex-shrink: 0; }
.btn-sched {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--muted);
    font-size: .8rem;
    transition: all .2s;
}
.btn-sched:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

/* Mobile: jadwal stack */
@media (max-width: 575px) {
    .schedule-item {
        grid-template-columns: 68px 1fr;
        grid-template-rows: auto auto;
        gap: 8px;
        padding: 12px 14px;
    }
    .sched-time { grid-row: 1 / 3; align-self: start; }
    .sched-body { grid-column: 2; }
    .sched-mode { grid-column: 2; justify-self: start; }
    .sched-actions { grid-column: 1 / 3; justify-content: flex-end; padding-top: 4px; border-top: 1px solid var(--border); margin-top: 4px; }
}

/* ═══════════════════════════════════════════
   KALENDER KOLOM KANAN
═══════════════════════════════════════════ */
.cal-side { display: flex; flex-direction: column; gap: 14px; }

.mini-cal { padding: 14px 16px; }
.cal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}
.cal-title { font-weight: 700; font-size: .88rem; color: var(--text); }
.cal-nav {
    width: 26px; height: 26px;
    border-radius: 7px;
    border: 1px solid var(--border);
    background: var(--card-bg);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .7rem; color: var(--muted);
    text-decoration: none;
    transition: all .2s;
}
.cal-nav:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

.cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    text-align: center;
}
.cal-day-name {
    font-size: .6rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    padding: 4px 0;
}
.cal-day {
    font-size: .76rem;
    padding: 6px 2px;
    border-radius: 7px;
    cursor: pointer;
    transition: all .15s;
    font-weight: 500;
    color: var(--text);
    position: relative;
}
.cal-day:hover       { background: #eff6ff; color: var(--primary); }
.cal-day.today       { background: var(--primary); color: #fff; font-weight: 700; }
.cal-day.other-month { color: var(--border); pointer-events: none; }
.cal-day.has-event::after {
    content: '';
    position: absolute;
    bottom: 2px; left: 50%;
    transform: translateX(-50%);
    width: 4px; height: 4px;
    border-radius: 50%;
    background: var(--accent);
}
.cal-day.today.has-event::after { background: #fff; }

/* Kalender result */
.cal-result {
    display: none;
    border-top: 1px solid var(--border);
    padding: 14px 16px;
}
.cal-result-title { font-size: .8rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }

.cal-sched-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid var(--border);
}
.cal-sched-item:last-child { border-bottom: none; }
.cal-sched-time {
    min-width: 50px;
    text-align: center;
    background: var(--bg);
    border-radius: 8px;
    padding: 5px 6px;
    font-size: .8rem;
    font-weight: 700;
    color: var(--primary);
    flex-shrink: 0;
}
.cal-sched-info { flex: 1; min-width: 0; }
.cal-sched-mapel { font-size: .82rem; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cal-sched-siswa { font-size: .72rem; color: var(--muted); margin-top: 1px; }

/* Rating card */
.rating-card {
    padding: 16px;
    text-align: center;
}
.rating-label { font-size: .72rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 6px; }
.rating-val   { font-size: 2rem; font-weight: 800; color: var(--primary); line-height: 1; }
.rating-stars { color: var(--accent); font-size: .85rem; margin: 6px 0 4px; }
.rating-count { font-size: .73rem; color: var(--muted); }
.btn-lihat-ulasan {
    display: block;
    margin-top: 12px;
    padding: 7px 0;
    background: #eff6ff;
    color: var(--primary);
    font-size: .76rem;
    font-weight: 700;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    transition: background .2s;
}
.btn-lihat-ulasan:hover { background: #dbeafe; }

/* ═══════════════════════════════════════════
   AKTIVITAS
═══════════════════════════════════════════ */
.activity-item {
    display: flex;
    gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--border);
}
.activity-item:last-child { border-bottom: none; }
.act-dot {
    width: 9px; height: 9px;
    border-radius: 50%;
    margin-top: 5px;
    flex-shrink: 0;
}
.act-text { font-size: .83rem; color: var(--text); line-height: 1.4; }
.act-text strong { font-weight: 600; }
.act-meta { font-size: .72rem; color: var(--muted); margin-top: 2px; }

/* ═══════════════════════════════════════════
   PROGRES SISWA
═══════════════════════════════════════════ */
.progress-item {
    padding: 12px 18px;
    border-bottom: 1px solid var(--border);
}
.progress-item:last-child { border-bottom: none; }
.progress-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    gap: 8px;
}
.progress-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; min-width: 0; }
.progress-label { font-size: .82rem; font-weight: 500; color: var(--text); }
.progress-pct { font-size: .78rem; font-weight: 700; color: var(--primary); flex-shrink: 0; }
.progress-bar-wrap {
    height: 7px;
    border-radius: 10px;
    background: var(--border);
    overflow: hidden;
}
.progress-bar-fill {
    height: 100%;
    border-radius: 10px;
    background: var(--primary);
    transition: width .4s ease;
}

/* ═══════════════════════════════════════════
   MISC
═══════════════════════════════════════════ */
.badge-subject {
    font-size: .67rem;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 700;
    background: #eff6ff;
    color: var(--primary);
    white-space: nowrap;
    flex-shrink: 0;
}
.empty-state {
    text-align: center;
    padding: 28px 16px;
    color: var(--muted);
}
.empty-state i { font-size: 2rem; display: block; margin-bottom: 8px; opacity: .35; }
.empty-state span { font-size: .84rem; font-weight: 600; }

/* pill helper */
.pill-date {
    font-size: .7rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    background: #eff6ff;
    color: var(--primary);
    white-space: nowrap;
}
.pill-today {
    font-size: .7rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    background: var(--success-soft);
    color: var(--success);
    display: flex;
    align-items: center;
    gap: 4px;
}
.link-semua {
    font-size: .75rem;
    font-weight: 600;
    color: var(--primary);
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}
.link-semua:hover { text-decoration: underline; }
</style>
@endpush

@section('content')

{{-- ═══ GREETING ═══ --}}
<div class="dash-greeting">
    <div>
        <h4>Selamat pagi, {{ $user->name }} 👋</h4>
        <p>Berikut ringkasan aktivitas mengajar Anda hari ini.</p>
    </div>
    <a href="/tutor/jadwal" class="btn-tambah-jadwal">
        <i class="bi bi-plus-lg"></i> Tambah Jadwal
    </a>
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div class="stat-grid">

    {{-- Sesi Minggu Ini --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;color:var(--primary);">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div>
            <div class="stat-val">{{ $sesiMingguIni }}</div>
            <div class="stat-label">Sesi Minggu Ini</div>
            @php $selisihSesi = $sesiMingguIni - $sesiMingguLalu; @endphp
            <div class="stat-change {{ $selisihSesi >= 0 ? 'up' : 'down' }}">
                <i class="bi bi-arrow-{{ $selisihSesi >= 0 ? 'up' : 'down' }}-short"></i>
                {{ abs($selisihSesi) }} dari minggu lalu
            </div>
        </div>
    </div>

    {{-- Total Siswa Aktif --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--success-soft);color:var(--success);">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <div class="stat-val">{{ $totalSiswa }}</div>
            <div class="stat-label">Total Siswa Aktif</div>
            @php $siswaBar = $totalSiswa - $siswaBulanLalu; @endphp
            <div class="stat-change {{ $siswaBar >= 0 ? 'up' : 'down' }}">
                <i class="bi bi-arrow-{{ $siswaBar >= 0 ? 'up' : 'down' }}-short"></i>
                {{ abs($siswaBar) }} siswa {{ $siswaBar >= 0 ? 'baru' : 'berkurang' }}
            </div>
        </div>
    </div>

    {{-- Rating --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);">
            <i class="bi bi-star-fill"></i>
        </div>
        <div>
            <div class="stat-val">{{ $ratingRata ?: '-' }}</div>
            <div class="stat-label">Rating Rata-rata</div>
            <div class="stat-change up">
                <i class="bi bi-star-fill" style="font-size:.6rem;"></i>
                dari {{ $totalUlasan }} ulasan
            </div>
        </div>
    </div>

    {{-- Jam Mengajar --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--info-soft);color:var(--info);">
            <i class="bi bi-clock-history"></i>
        </div>
        <div>
            <div class="stat-val">{{ $jamBulanIni }} <span>jam</span></div>
            <div class="stat-label">Jam Mengajar Bulan Ini</div>
            @php $selisihJam = $jamBulanIni - $jamBulanLalu; @endphp
            <div class="stat-change {{ $selisihJam >= 0 ? 'up' : 'down' }}">
                <i class="bi bi-arrow-{{ $selisihJam >= 0 ? 'up' : 'down' }}-short"></i>
                {{ abs($selisihJam) }} jam {{ $selisihJam >= 0 ? 'lebih' : 'kurang' }}
            </div>
        </div>
    </div>

</div>

{{-- ═══ ROW 2: JADWAL + KALENDER/RATING ═══ --}}
<div class="dash-main-row">

    {{-- JADWAL HARI INI --}}
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title">
                <i class="bi bi-calendar3"></i> Jadwal Mengajar Hari Ini
            </div>
            <div class="card-box-meta">
                <span class="pill-date">{{ now()->translatedFormat('d M Y') }}</span>
                <a href="/tutor/jadwal" class="link-semua">Lihat Semua →</a>
            </div>
        </div>

        @forelse($jadwalHariIni as $j)
        <div class="schedule-item">
            <div class="sched-time">
                <div class="time-main">{{ $j->jadwal->format('H.i') }}</div>
                <div class="time-dur">{{ $j->durasi_menit }} mnt</div>
            </div>
            <div class="sched-body">
                <div class="sched-subject">
                    {{ $j->mata_pelajaran }}{{ $j->topik ? ' – '.$j->topik : '' }}
                    <span class="badge-subject">{{ strtoupper($j->siswa->jenjang ?? 'SMA') }}</span>
                </div>
                <div class="sched-student">
                    <i class="bi bi-person-fill"></i>
                    {{ $j->siswa->name ?? '-' }}
                    <span style="opacity:.4;">·</span>
                    <i class="bi bi-{{ $j->mode === 'online' ? 'camera-video-fill' : 'geo-alt-fill' }}"></i>
                    {{ $j->mode === 'online' ? ($j->link_meeting ?? 'Via Meeting') : ($j->lokasi ?? 'Tatap Muka') }}
                </div>
            </div>
            <span class="sched-mode {{ $j->mode === 'online' ? 'online' : 'offline' }}">
                {{ $j->mode === 'online' ? 'Online' : 'Offline' }}
            </span>
            <div class="sched-actions">
                <button class="btn-sched" title="Detail"><i class="bi bi-eye"></i></button>
                <button class="btn-sched" title="Mulai"><i class="bi bi-play-fill"></i></button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <span>Tidak ada jadwal hari ini</span>
        </div>
        @endforelse
    </div>

    {{-- KALENDER + RATING --}}
    <div class="cal-side">

        {{-- MINI KALENDER --}}
        <div class="card-box">
            <div class="mini-cal">
                @php
                    $month       = request()->query('cal_month', now()->month);
                    $year        = request()->query('cal_year',  now()->year);
                    $currentDate = \Carbon\Carbon::createFromDate($year, $month, 1);
                    $today       = now()->startOfDay();
                    $prevMonth   = $currentDate->copy()->subMonth();
                    $nextMonth   = $currentDate->copy()->addMonth();
                    $startDow    = (int) $currentDate->copy()->startOfMonth()->dayOfWeek;
                    $daysInMonth     = (int) $currentDate->daysInMonth;
                    $daysInPrevMonth = (int) $prevMonth->daysInMonth;

                    $cells = [];
                    for ($i = $startDow - 1; $i >= 0; $i--) {
                        $cells[] = ['day' => $daysInPrevMonth - $i, 'other' => true,
                                    'date' => $prevMonth->copy()->day($daysInPrevMonth - $i)];
                    }
                    for ($d = 1; $d <= $daysInMonth; $d++) {
                        $cells[] = ['day' => $d, 'other' => false,
                                    'date' => $currentDate->copy()->day($d)];
                    }
                    $remaining = count($cells) % 7;
                    if ($remaining !== 0) {
                        for ($d = 1; $d <= (7 - $remaining); $d++) {
                            $cells[] = ['day' => $d, 'other' => true,
                                        'date' => $nextMonth->copy()->day($d)];
                        }
                    }
                    $eventDates = collect($hariAdaSesi)->map(
                        fn($d) => $currentDate->format('Y-m').'-'.str_pad($d, 2, '0', STR_PAD_LEFT)
                    )->toArray();
                @endphp

                <div class="cal-header">
                    <a href="?cal_month={{ $prevMonth->month }}&cal_year={{ $prevMonth->year }}" class="cal-nav">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <div class="cal-title">{{ $currentDate->translatedFormat('F Y') }}</div>
                    <a href="?cal_month={{ $nextMonth->month }}&cal_year={{ $nextMonth->year }}" class="cal-nav">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

                <div class="cal-grid">
                    @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $dn)
                        <div class="cal-day-name">{{ $dn }}</div>
                    @endforeach

                    @foreach($cells as $cell)
                        @php
                            $isToday   = !$cell['other'] && $cell['date']->isSameDay($today);
                            $hasEvent  = in_array($cell['date']->format('Y-m-d'), $eventDates);
                        @endphp
                        <div
                            class="cal-day
                                {{ $cell['other'] ? 'other-month' : '' }}
                                {{ $isToday      ? 'today'       : '' }}
                                {{ $hasEvent     ? 'has-event'   : '' }}"
                            @if(!$cell['other'])
                                onclick="loadJadwalKalender({{ $cell['day'] }}, {{ $cell['date']->month }}, {{ $cell['date']->year }})"
                            @endif
                        >{{ $cell['day'] }}</div>
                    @endforeach
                </div>
            </div>

            {{-- Hasil klik kalender --}}
            <div class="cal-result" id="jadwal-kalender-result">
                <div class="cal-result-title" id="jadwal-kalender-title"></div>
                <div id="jadwal-kalender-list"></div>
            </div>
        </div>

        {{-- RATING --}}
        <div class="card-box">
            <div class="rating-card">
                <div class="rating-label">Rating Anda</div>
                <div class="rating-val">{{ $ratingRata ?: '-' }}</div>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= floor($ratingRata) ? '-fill' : '' }}"></i>
                    @endfor
                </div>
                <div class="rating-count">dari {{ $totalUlasan }} ulasan siswa</div>
                <a href="#" class="btn-lihat-ulasan">Lihat Semua Ulasan</a>
            </div>
        </div>

    </div>
</div>

{{-- ═══ ROW 3: AKTIVITAS + PROGRES ═══ --}}
<div class="dash-bottom-row">

    {{-- AKTIVITAS --}}
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-activity"></i> Ringkasan Aktivitas</div>
            <div class="pill-today">
                <i class="bi bi-circle-fill" style="font-size:.45rem;"></i> Hari Ini
            </div>
        </div>

        @php
        $activities = [
            ['var(--success)', 'Sesi selesai',          'Matematika dengan Aldi Pratama',       '09.30 · Durasi 90 menit · Selesai tepat waktu', 'var(--success)'],
            ['var(--primary)', 'Feedback diberikan',    'kepada Sinta Dewi (Fisika)',            '11.45 · Nilai tugas: 85/100',                   'var(--muted)'],
            ['var(--accent)',  'Materi baru diunggah',  'Ringkasan Integral Tentu',              '12.10 · PDF · 3 halaman',                        'var(--muted)'],
            ['#6d28d9',        'Jadwal dikonfirmasi',   'Kimia dengan Rizky Aditya',             '13.00 · Offline · Jl. Kenanga No.5',            'var(--muted)'],
            ['var(--danger)',  'Permintaan reschedule', 'dari Farhan Maulana',                   '14.22 · Perlu tindakan',                         'var(--danger)'],
            ['var(--success)', 'Ulasan baru ★★★★★',    'dari orang tua Maya Putri',             '16.05 · Penjelasannya sangat jelas',             'var(--muted)'],
        ];
        @endphp

        @foreach($activities as $a)
        <div class="activity-item">
            <div class="act-dot" style="background:{{ $a[0] }};"></div>
            <div>
                <div class="act-text"><strong>{{ $a[1] }}</strong> – {{ $a[2] }}</div>
                <div class="act-meta" style="color:{{ $a[4] }};"><i class="bi bi-clock me-1"></i>{{ $a[3] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- PROGRES MATERI SISWA --}}
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-graph-up-arrow"></i> Progres Materi Siswa</div>
            <a href="#" class="link-semua">Semua →</a>
        </div>

        @forelse($progresMapel as $p)
        <div class="progress-item">
            <div class="progress-row">
                <div class="progress-left">
                    <span class="progress-label">{{ $p['nama'] }}</span>
                    <span class="badge-subject">{{ $p['mapel'] }}</span>
                </div>
                <span class="progress-pct">{{ $p['pct'] }}%</span>
            </div>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" style="width:{{ $p['pct'] }}%;"></div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="bi bi-bar-chart-line"></i>
            <span>Belum ada data progres siswa</span>
        </div>
        @endforelse
    </div>

</div>

@endsection

@push('scripts')
<script>
function loadJadwalKalender(tgl, bulan, tahun) {
    const result = document.getElementById('jadwal-kalender-result');
    const title  = document.getElementById('jadwal-kalender-title');
    const list   = document.getElementById('jadwal-kalender-list');

    // Loading state
    title.textContent = 'Memuat...';
    list.innerHTML = '';
    result.style.display = 'block';

    fetch(`/tutor/jadwal/kalender?tgl=${tgl}&bulan=${bulan}&tahun=${tahun}`)
        .then(r => r.json())
        .then(data => {
            title.textContent = `${data.label} (${data.total} sesi)`;

            if (data.jadwal.length === 0) {
                list.innerHTML = `
                    <div style="text-align:center;padding:16px 0;color:var(--muted);font-size:.82rem;">
                        Tidak ada jadwal pada hari ini.
                    </div>`;
            } else {
                list.innerHTML = data.jadwal.map(j => `
                    <div class="cal-sched-item">
                        <div class="cal-sched-time">${j.waktu}</div>
                        <div class="cal-sched-info">
                            <div class="cal-sched-mapel">${j.mapel}</div>
                            <div class="cal-sched-siswa">${j.siswa} · ${j.mode === 'online' ? 'Online' : 'Offline'}</div>
                        </div>
                        <span style="font-size:.68rem;font-weight:700;padding:3px 9px;border-radius:20px;
                            background:${j.mode === 'online' ? 'var(--success-soft)' : '#f5f3ff'};
                            color:${j.mode === 'online' ? 'var(--success)' : '#6d28d9'};flex-shrink:0;">
                            ${j.mode === 'online' ? 'Online' : 'Offline'}
                        </span>
                    </div>`
                ).join('');
            }
        })
        .catch(() => {
            title.textContent = 'Gagal memuat data.';
            list.innerHTML = '';
        });
}
</script>
@endpush