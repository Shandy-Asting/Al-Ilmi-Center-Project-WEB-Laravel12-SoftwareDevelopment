@php
if (!isset($menunggu)) {
$menunggu = collect([]);
}
@endphp

@extends('layouts.app')

@section('title', 'Dashboard Tutor - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Dashboard Tutor')
@section('page-sub', 'Selamat datang kembali, Pak Budi! 👋')

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
    /* ── STAT CARDS ── */
    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .stat-val {
        font-size: 1.7rem;
        font-weight: 800;
        line-height: 1;
        color: var(--text);
    }

    .stat-label {
        font-size: .8rem;
        color: var(--muted);
        margin-top: 4px;
        font-weight: 500;
    }

    .stat-change {
        font-size: .75rem;
        font-weight: 600;
        margin-top: 8px;
    }

    .stat-change.up {
        color: var(--success);
    }

    .stat-change.down {
        color: var(--danger);
    }

    /* ── JADWAL ── */
    .schedule-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .schedule-item:last-child {
        border-bottom: none;
    }

    .schedule-item:hover {
        background: #f8faff;
    }

    .sched-time {
        min-width: 80px;
        text-align: center;
        padding: 8px 10px;
        background: var(--bg);
        border-radius: 10px;
    }

    .time-main {
        font-size: .9rem;
        font-weight: 700;
        color: var(--primary);
    }

    .time-dur {
        font-size: .7rem;
        color: var(--muted);
    }

    .sched-subject {
        font-weight: 600;
        font-size: .88rem;
        color: var(--text);
    }

    .sched-student {
        font-size: .78rem;
        color: var(--muted);
        margin-top: 2px;
    }

    .sched-mode {
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .sched-mode.online {
        background: var(--success-soft);
        color: var(--success);
    }

    .sched-mode.offline {
        background: #f5f3ff;
        color: #6d28d9;
    }

    .btn-sched {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--muted);
        font-size: .85rem;
        transition: all .2s;
    }

    .btn-sched:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* ── AKTIVITAS ── */
    .activity-item {
        display: flex;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .act-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .act-text {
        font-size: .84rem;
        color: var(--text);
    }

    .act-text strong {
        font-weight: 600;
    }

    .act-meta {
        font-size: .73rem;
        color: var(--muted);
        margin-top: 3px;
    }

    /* ── PROGRESS ── */
    .progress-item {
        padding: 12px 20px;
        border-bottom: 1px solid var(--border);
    }

    .progress-item:last-child {
        border-bottom: none;
    }

    .progress-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .progress-label {
        font-size: .83rem;
        font-weight: 500;
        color: var(--text);
    }

    .progress-pct {
        font-size: .78rem;
        font-weight: 700;
        color: var(--primary);
    }

    .progress {
        height: 7px;
        border-radius: 10px;
        background: var(--border);
    }

    .progress-bar {
        border-radius: 10px;
    }

    /* ── KALENDER ── */
    .mini-cal {
        padding: 16px 20px;
    }

    .cal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .cal-title {
        font-weight: 700;
        font-size: .92rem;
        color: var(--text);
    }

    .cal-nav {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--card-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: .75rem;
        color: var(--muted);
        transition: all .2s;
    }

    .cal-nav:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 3px;
        text-align: center;
    }

    .cal-day-name {
        font-size: .65rem;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        padding: 4px 0;
    }

    .cal-day {
        font-size: .78rem;
        padding: 6px 4px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .15s;
        font-weight: 500;
        color: var(--text);
    }

    .cal-day:hover {
        background: #eff6ff;
        color: var(--primary);
    }

    .cal-day.today {
        background: var(--primary);
        color: #fff;
        font-weight: 700;
    }

    .cal-day.has-event {
        position: relative;
    }

    .cal-day.has-event::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: var(--accent);
    }

    .cal-day.other-month {
        color: var(--border);
    }

    /* ── BADGE ── */
    .badge-subject {
        font-size: .7rem;
        padding: 3px 9px;
        border-radius: 20px;
        font-weight: 600;
        background: #eff6ff;
        color: var(--primary);
    }

    /* ── CARD BOX ── */
    .card-box {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border);
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
        font-size: .95rem;
        font-weight: 700;
        color: var(--text);
    }

    .card-box-title i {
        color: var(--primary);
        margin-right: 6px;
    }

    /* Tutor Dashboard Responsive */
    @media (max-width: 991px) {
        .jadwal-item {
            flex-wrap: wrap;
            gap: 10px;
        }

        .sched-time {
            min-width: 70px;
        }

        .sched-mode {
            margin-top: 4px;
        }
    }

    @media (max-width: 767px) {
        .jadwal-item {
            padding: 12px 14px;
        }

        .activity-item {
            padding: 10px 14px;
        }

        .progress-item {
            padding: 10px 14px;
        }

        .mini-cal {
            padding: 12px 14px;
        }

        .cal-day {
            font-size: 11px;
            padding: 5px 2px;
        }

        .d-flex.gap-3.mb-4 {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

{{-- GREETING --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Selamat pagi, {{ $user->name }} 👋</h4>
        <p style="font-size:.87rem;color:var(--muted);margin:0;">Berikut ringkasan aktivitas mengajar Anda hari ini.</p>
    </div>
    <a href="/tutor/jadwal" class="btn btn-sm fw-bold px-3 py-2"
        style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
    </a>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:var(--primary);"><i
                    class="bi bi-calendar-check-fill"></i></div>
            <div>
                {{-- Stat 1: Sesi Minggu Ini --}}
                <div class="stat-val">{{ $sesiMingguIni }}</div>
                <div class="stat-label">Sesi Minggu Ini</div>
                @php $selisihSesi = $sesiMingguIni - $sesiMingguLalu; @endphp
                <div class="stat-change {{ $selisihSesi >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $selisihSesi >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ abs($selisihSesi) }} dari minggu lalu
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i
                    class="bi bi-people-fill"></i></div>
            <div>
                {{-- Stat 2: Total Siswa Aktif --}}
                <div class="stat-val">{{ $totalSiswa }}</div>
                <div class="stat-label">Total Siswa Aktif</div>
                @php $siswaBar = $totalSiswa - $siswaBulanLalu; @endphp
                <div class="stat-change {{ $siswaBar >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $siswaBar >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ abs($siswaBar) }} siswa {{ $siswaBar >= 0 ? 'baru' : 'berkurang' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);"><i
                    class="bi bi-star-fill"></i></div>
            <div>
                {{-- Stat 3: Rating --}}
                <div class="stat-val">{{ $ratingRata ?: '-' }}</div>
                <div class="stat-label">Rating Rata-rata</div>
                <div class="stat-change up">
                    <i class="bi bi-star-fill" style="font-size:.65rem;"></i>
                    dari {{ $totalUlasan }} ulasan
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--info-soft);color:var(--info);"><i
                    class="bi bi-clock-history"></i></div>
            <div>
                {{-- Stat 4: Jam Mengajar --}}
                <div class="stat-val">{{ $jamBulanIni }} <span style="font-size:1rem;">jam</span></div>
                <div class="stat-label">Jam Mengajar Bulan Ini</div>
                @php $selisihJam = $jamBulanIni - $jamBulanLalu; @endphp
                <div class="stat-change {{ $selisihJam >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $selisihJam >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ abs($selisihJam) }} jam {{ $selisihJam >= 0 ? 'lebih' : 'kurang' }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ROW 2: JADWAL + KALENDER --}}
<div class="row g-3 mb-4">

    {{-- JADWAL HARI INI --}}
    <div class="col-lg-8">
        <div class="card-box h-100">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-calendar3"></i> Jadwal Mengajar Hari Ini</div>
                <div class="d-flex align-items-center gap-2">
                    <span class="pill p-primary" style="font-size:.72rem;">{{ now()->translatedFormat('d M Y') }}</span>
                    <a href="/tutor/jadwal" class="btn btn-sm rounded-2"
                        style="background:#eff6ff;color:var(--primary);font-size:.75rem;font-weight:600;border:none;">
                        Lihat Semua
                    </a>
                </div>
            </div>

            @forelse($jadwalHariIni as $j)
            <div class="schedule-item">
                <div class="sched-time">
                    <div class="time-main">{{ $j->jadwal->format('H.i') }}</div>
                    <div class="time-dur">{{ $j->durasi_menit }} mnt</div>
                </div>
                <div style="flex:1;">
                    <div class="sched-subject">
                        {{ $j->mata_pelajaran }}{{ $j->topik ? ' – '.$j->topik : '' }}
                        <span class="badge-subject ms-1">{{ strtoupper($j->siswa->jenjang ?? 'SMA') }}</span>
                    </div>
                    <div class="sched-student">
                        <i class="bi bi-person-fill me-1"></i>{{ $j->siswa->name ?? '-' }} &nbsp;·&nbsp;
                        <i class="bi bi-{{ $j->mode === 'online' ? 'camera-video-fill' : 'geo-alt-fill' }} me-1"></i>
                        {{ $j->mode === 'online' ? ($j->link_meeting ?? 'Via Meeting') : ($j->lokasi ?? 'Tatap Muka') }}
                    </div>
                </div>
                <span class="sched-mode {{ $j->mode === 'online' ? 'online' : 'offline' }}">
                    {{ $j->mode === 'online' ? 'Online' : 'Offline' }}
                </span>
                <div class="d-flex gap-1">
                    <button class="btn-sched" title="Detail"><i class="bi bi-eye"></i></button>
                    <button class="btn-sched" title="Mulai"><i class="bi bi-play-fill"></i></button>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:32px;color:var(--muted);">
                <i class="bi bi-calendar-x" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                <div style="font-size:14px;font-weight:700;">Tidak ada jadwal hari ini</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- KALENDER + RATING --}}
    <div class="col-lg-4 d-flex flex-column gap-3">
        <div class="card-box">
            <div class="mini-cal">
                @php
                // Ambil bulan & tahun dari query string, default ke bulan ini
                $month = request()->query('cal_month', now()->month);
                $year = request()->query('cal_year', now()->year);

                $currentDate = \Carbon\Carbon::createFromDate($year, $month, 1);
                $today = now()->startOfDay();

                $prevMonth = $currentDate->copy()->subMonth();
                $nextMonth = $currentDate->copy()->addMonth();

                // Hari pertama bulan ini (0=Min ... 6=Sab)
                $startDow = (int) $currentDate->copy()->startOfMonth()->dayOfWeek;
                $daysInMonth = (int) $currentDate->daysInMonth;
                $daysInPrevMonth = (int) $prevMonth->daysInMonth;

                // Bangun array sel kalender
                $cells = [];

                // Isi sisa dari bulan sebelumnya
                for ($i = $startDow - 1; $i >= 0; $i--) {
                $cells[] = [
                'day' => $daysInPrevMonth - $i,
                'other' => true,
                'date' => $prevMonth->copy()->day($daysInPrevMonth - $i),
                ];
                }

                // Isi hari-hari bulan ini
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $cells[]=[ 'day'=> $d,
                    'other' => false,
                    'date' => $currentDate->copy()->day($d),
                    ];
                    }

                    // Isi sisa ke bulan berikutnya (hingga grid penuh, kelipatan 7)
                    $remaining = count($cells) % 7;
                    if ($remaining !== 0) {
                    $fill = 7 - $remaining;
                    for ($d = 1; $d <= $fill; $d++) {
                        $cells[]=[ 'day'=> $d,
                        'other' => true,
                        'date' => $nextMonth->copy()->day($d),
                        ];
                        }
                        }

                        // Contoh array tanggal yang punya event (format Y-m-d)
                        // Ganti/isi sesuai data dari database kamu
                        $eventDates = collect($hariAdaSesi)->map(
                        fn($d) => $currentDate->format('Y-m') . '-' . str_pad($d, 2, '0', STR_PAD_LEFT)
                        )->toArray();
                        @endphp

                        <div class="cal-header">
                            <a href="?cal_month={{ $prevMonth->month }}&cal_year={{ $prevMonth->year }}" class="cal-nav"><i
                                    class="bi bi-chevron-left"></i></a>

                            <div class="cal-title">
                                {{ $currentDate->translatedFormat('F Y') }}
                            </div>

                            <a href="?cal_month={{ $nextMonth->month }}&cal_year={{ $nextMonth->year }}" class="cal-nav"><i
                                    class="bi bi-chevron-right"></i></a>
                        </div>

                        <div class="cal-grid">
                            @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $d)
                            <div class="cal-day-name">{{ $d }}</div>
                            @endforeach

                            @foreach ($cells as $cell)
                            @php
                            $isToday = !$cell['other'] && $cell['date']->isSameDay($today);
                            $hasEvent = in_array($cell['date']->format('Y-m-d'), $eventDates);
                            @endphp
                            <div
                                class="cal-day
    {{ $cell['other'] ? 'other-month' : '' }}
    {{ $isToday ? 'today' : '' }}
    {{ $hasEvent ? 'has-event' : '' }}"
                                onclick="loadJadwalKalender({{ $cell['day'] }}, {{ $cell['date']->month }}, {{ $cell['date']->year }})">
                                {{ $cell['day'] }}
                            </div>
                            @endforeach
                        </div>
            </div>

            {{-- HASIL KLIK KALENDER --}}
            <div id="jadwal-kalender-result" style="display:none;border-top:1px solid var(--border);padding:16px 20px;">
                <div id="jadwal-kalender-title" style="font-size:.82rem;font-weight:700;color:var(--text);margin-bottom:10px;"></div>
                <div id="jadwal-kalender-list"></div>
            </div>
        </div>



        {{-- RATING --}}
        <div class="card-box p-3 text-center">
            <div
                style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:6px;">
                RATING ANDA</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary);">{{ $ratingRata ?: '-' }}</div>
            <div style="color:var(--accent);font-size:.85rem;">
                @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i <= floor($ratingRata) ? '-fill' : '' }}"></i>
                    @endfor
            </div>
            <div style="font-size:.75rem;color:var(--muted);margin-top:4px;">dari {{ $totalUlasan }} ulasan siswa</div>
            <a href="#" class="btn btn-sm w-100 mt-3"
                style="background:#eff6ff;color:var(--primary);font-size:.78rem;font-weight:600;border-radius:8px;border:none;">
                Lihat Semua Ulasan
            </a>
        </div>
    </div>
</div>

{{-- ROW 3: AKTIVITAS + PROGRES SISWA --}}
<div class="row g-3">

    {{-- AKTIVITAS --}}
    <div class="col-lg-6">
        <div class="card-box h-100">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-activity"></i> Ringkasan Aktivitas</div>
                <span class="pill p-success" style="font-size:.72rem;"><i class="bi bi-circle-fill"
                        style="font-size:.5rem;"></i> Hari Ini</span>
            </div>

            @php
            $activities = [
            [
            'var(--success)',
            'Sesi selesai',
            'Matematika dengan Aldi Pratama',
            '09.30 · Durasi 90 menit · Selesai tepat waktu',
            'var(--success)',
            ],
            [
            'var(--primary)',
            'Feedback diberikan',
            'kepada Sinta Dewi (Fisika)',
            '11.45 · Nilai tugas: 85/100',
            'var(--muted)',
            ],
            [
            'var(--accent)',
            'Materi baru diunggah',
            'Ringkasan Integral Tentu',
            '12.10 · PDF · 3 halaman',
            'var(--muted)',
            ],
            [
            '#6d28d9',
            'Jadwal dikonfirmasi',
            'Kimia dengan Rizky Aditya',
            '13.00 · Offline · Jl. Kenanga No.5',
            'var(--muted)',
            ],
            [
            'var(--danger)',
            'Permintaan reschedule',
            'dari Farhan Maulana',
            '14.22 · Perlu tindakan',
            'var(--danger)',
            ],
            [
            'var(--success)',
            'Ulasan baru ★★★★★',
            'dari orang tua Maya Putri',
            '16.05 · Penjelasannya sangat jelas',
            'var(--muted)',
            ],
            ];
            @endphp

            @foreach ($activities as $a)
            <div class="activity-item">
                <div class="act-dot" style="background:{{ $a[0] }};"></div>
                <div>
                    <div class="act-text"><strong>{{ $a[1] }}</strong> – {{ $a[2] }}</div>
                    <div class="act-meta" style="color:{{ $a[4] }};"><i
                            class="bi bi-clock me-1"></i>{{ $a[3] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- PROGRES MATERI SISWA --}}
    <div class="col-lg-6">
        <div class="card-box h-100">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-graph-up-arrow"></i> Progres Materi Siswa</div>
                <a href="#"
                    style="font-size:12px;color:var(--primary);font-weight:600;text-decoration:none;">Semua →</a>
            </div>

            @forelse($progresMapel as $p)
            <div class="progress-item">
                <div class="progress-row">
                    <div>
                        <span class="progress-label">{{ $p['nama'] }}</span>
                        <span class="badge-subject ms-2" style="font-size:.68rem;">{{ $p['mapel'] }}</span>
                    </div>
                    <span class="progress-pct">{{ $p['pct'] }}%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width:{{ $p['pct'] }}%;background:var(--primary);"></div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:24px;color:var(--muted);font-size:13px;">Belum ada data progres siswa</div>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function loadJadwalKalender(tgl, bulan, tahun) {
        fetch(`/tutor/jadwal/kalender?tgl=${tgl}&bulan=${bulan}&tahun=${tahun}`)
            .then(r => r.json())
            .then(data => {
                const box = document.getElementById('jadwal-kalender-result');
                const title = document.getElementById('jadwal-kalender-title');
                const list = document.getElementById('jadwal-kalender-list');

                title.textContent = data.label + ' (' + data.total + ' sesi)';

                if (data.jadwal.length === 0) {
                    list.innerHTML = `<div style="text-align:center;padding:16px;color:var(--muted);font-size:13px;">Tidak ada jadwal pada hari ini.</div>`;
                } else {
                    list.innerHTML = data.jadwal.map(j => `
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);">
                        <div style="min-width:56px;text-align:center;background:var(--bg);border-radius:8px;padding:6px 8px;">
                            <div style="font-size:.85rem;font-weight:700;color:var(--primary);">${j.waktu}</div>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:.84rem;font-weight:600;color:var(--text);">${j.mapel}</div>
                            <div style="font-size:.75rem;color:var(--muted);">${j.siswa} · ${j.mode === 'online' ? 'Online' : 'Offline'}</div>
                        </div>
                        <span style="font-size:.7rem;font-weight:600;padding:3px 10px;border-radius:20px;background:${j.mode === 'online' ? 'var(--success-soft)' : '#f5f3ff'};color:${j.mode === 'online' ? 'var(--success)' : '#6d28d9'};">
                            ${j.mode === 'online' ? 'Online' : 'Offline'}
                        </span>
                    </div>
                `).join('');
                }

                box.style.display = 'block';
            });
    }
</script>
@endpush