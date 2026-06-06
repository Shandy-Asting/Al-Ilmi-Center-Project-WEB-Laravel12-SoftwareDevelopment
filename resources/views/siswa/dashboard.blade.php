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
    /* ── GREETING BANNER ── */
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
        background: rgba(255, 255, 255, .07);
    }

    .greeting-banner::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: 120px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
    }

    .greeting-banner .tag {
        display: inline-block;
        background: rgba(255, 255, 255, .18);
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
    }

    .greeting-banner .btn-banner {
        background: #fff;
        color: var(--primary);
        border: none;
        border-radius: 10px;
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s;
    }

    .greeting-banner .btn-banner:hover {
        transform: scale(1.03);
    }

    .streak-badge {
        position: absolute;
        right: 32px;
        top: 50%;
        transform: translateY(-50%);
        text-align: center;
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

    /* ── STAT CARDS ── */
    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px 20px 16px;
        border: 1px solid var(--border);
        height: 100%;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
    }

    .stat-val {
        font-size: 26px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12.5px;
        color: var(--muted);
    }

    .stat-change {
        font-size: 11.5px;
        font-weight: 600;
        margin-top: 8px;
    }

    .stat-change.up {
        color: var(--success);
    }

    .stat-change.down {
        color: var(--danger);
    }

    /* ── SECTION TITLE ── */
    .section-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-title a {
        font-size: 12px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    /* ── PROGRESS CARD ── */
    .progress-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border);
        padding: 20px;
        height: 100%;
    }

    .subject-row {
        margin-bottom: 16px;
    }

    .subject-row:last-child {
        margin-bottom: 0;
    }

    .subj-head {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .subj-name {
        font-size: 13px;
        font-weight: 600;
    }

    .subj-pct {
        font-size: 13px;
        font-weight: 700;
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
    }

    /* ── JADWAL CARD ── */
    .jadwal-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 10px;
        transition: box-shadow .2s;
    }

    .jadwal-card:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, .07);
    }

    .jadwal-time {
        min-width: 70px;
        text-align: center;
        background: var(--bg);
        border-radius: 10px;
        padding: 8px 6px;
    }

    .time-val {
        font-size: 14px;
        font-weight: 800;
        color: var(--primary);
    }

    .time-day {
        font-size: 10px;
        color: var(--muted);
    }

    .jadwal-info {
        flex: 1;
    }

    .j-subj {
        font-size: 13px;
        font-weight: 700;
    }

    .j-tutor {
        font-size: 12px;
        color: var(--muted);
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
        font-size: 14px;
        color: #fff;
        flex-shrink: 0;
    }

    /* ── REKOMENDASI CARD ── */
    .rec-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: box-shadow .2s;
        height: 100%;
    }

    .rec-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, .07);
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

    .rec-title {
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .rec-sub {
        font-size: 11.5px;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .btn-rec {
        font-size: 11.5px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        padding: 5px 14px;
        cursor: pointer;
    }

    /* ── TESTIMONI ── */
    .testi-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 18px;
        height: 100%;
    }

    .testi-stars {
        color: var(--accent);
        font-size: 13px;
        margin-bottom: 8px;
    }

    .testi-text {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
        margin-bottom: 14px;
        font-style: italic;
    }

    .testi-user {
        display: flex;
        align-items: center;
        gap: 10px;
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
    }

    .testi-name {
        font-size: 13px;
        font-weight: 700;
    }

    .testi-kelas {
        font-size: 11px;
        color: var(--muted);
    }

    /* ── HARGA CARD ── */
    .harga-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 22px 18px;
        text-align: center;
        height: 100%;
        transition: transform .2s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .harga-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09);
    }

    .harga-card.featured {
        background: linear-gradient(145deg, var(--primary), var(--primary-light));
        border-color: transparent;
        color: #fff;
    }

    .harga-badge {
        position: absolute;
        top: 12px;
        right: -22px;
        background: var(--accent);
        color: var(--primary);
        font-size: 10px;
        font-weight: 700;
        padding: 3px 28px;
        transform: rotate(35deg);
    }

    .harga-plan {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .harga-card.featured .harga-plan {
        color: rgba(255, 255, 255, .7);
    }

    .harga-price {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .harga-period {
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 16px;
    }

    .harga-card.featured .harga-period {
        color: rgba(255, 255, 255, .6);
    }

    .harga-features {
        list-style: none;
        padding: 0;
        text-align: left;
        margin-bottom: 18px;
    }

    .harga-features li {
        font-size: 12.5px;
        padding: 5px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .harga-features li i {
        color: var(--success);
    }

    .harga-card.featured .harga-features li i {
        color: #6EE7B7;
    }

    .btn-harga {
        border-radius: 10px;
        padding: 9px 0;
        width: 100%;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .streak-badge {
            display: none;
        }
    }

    /* ══ RESPONSIVE GLOBAL ══ */
    @media (max-width: 991px) {
        .row>[class*='col-lg'] {
            margin-bottom: 12px;
        }
    }

    @media (max-width: 767px) {
        h4.fw-bold {
            font-size: 1.1rem !important;
        }

        .d-flex.justify-content-between {
            flex-wrap: wrap;
            gap: 10px;
        }

        .stat-card {
            padding: 14px !important;
        }

        .stat-val {
            font-size: 1.3rem !important;
        }

        .main-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .main-tab {
            min-width: 100px;
            flex: none;
        }

        table {
            font-size: 12px !important;
        }

        table td,
        table th {
            padding: 8px 10px !important;
        }

        .card-box-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .modal-box {
            width: 96% !important;
            margin: 10px auto;
        }
    }

    @media (max-width: 480px) {
        .stat-card {
            flex-direction: column;
            gap: 8px;
        }

        .d-flex.gap-2 {
            flex-wrap: wrap;
        }

        .btn {
            font-size: 12px !important;
            padding: 7px 12px !important;
        }
    }

    /* Dashboard responsive */
    @media (max-width: 767px) {
        .greeting-card {
            padding: 16px 18px !important;
        }

        .greeting-card h4 {
            font-size: 1rem !important;
        }

        .col-6 .stat-card {
            padding: 12px !important;
        }

        .col-6 .stat-val {
            font-size: 1.2rem !important;
        }
    }
</style>
@endpush

@section('content')

{{-- GREETING BANNER --}}
<div class="greeting-banner">
    <span class="tag">🌟 Selamat Datang Kembali!</span>
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Kamu sudah belajar <strong>{{ $streak }} hari berturut-turut</strong>. Teruskan semangatmu hari ini!</p>
    <a href="/siswa/belajar-tka" class="btn-banner"><i class="bi bi-play-fill me-1"></i> Lanjutkan Belajar</a>
    <div class="streak-badge">
        <div style="font-size:22px;">🔥</div>
        <div class="streak-num">{{ $streak }}</div>
        <div class="streak-label">Hari Streak</div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
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
    <div class="col-6 col-md-3">
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
    <div class="col-6 col-md-3">
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
    <div class="col-6 col-md-3">
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

{{-- PROGRES + JADWAL --}}
<div class="row g-3 mb-4">

    {{-- Progres Belajar --}}
    <div class="col-lg-5">
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
                    <div class="custom-progress-bar" style="width:{{ $p['pct'] }}%;background:{{ $gradients[$idx % 5] }};"></div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:16px;color:var(--muted);font-size:13px;">
                <i class="bi bi-graph-up" style="font-size:1.5rem;display:block;margin-bottom:6px;opacity:.4;"></i>
                Belum ada data progres. Mulai kerjakan soal!
            </div>
            @endforelse

            {{-- Mini Bar Chart --}}
            <div class="mt-3 p-3 rounded-3" style="background:var(--bg);">
                <div class="d-flex justify-content-between align-items-end" style="height:60px;gap:6px;">
                    @foreach($aktivitasMingguan as $idx => $a)
                    @php $tinggi = $maxAktivitas > 0 ? max(8, round($a['menit'] / $maxAktivitas * 52)) : 8; @endphp
                    <div style="flex:1;text-align:center;">
                        <div style="background:{{ $idx >= 4 ? 'var(--primary)' : 'var(--primary-light)' }};height:{{ $tinggi }}px;border-radius:4px 4px 0 0;{{ $idx < 4 ? 'opacity:.6;' : '' }}"></div>
                        <div style="font-size:10px;color:var(--muted);margin-top:3px;">{{ $a['hari'] }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="font-size:11px;color:var(--muted);text-align:center;margin-top:2px;">Aktivitas Belajar Mingguan</div>
            </div>
        </div>
    </div>

    {{-- Jadwal Terdekat --}}
    <div class="col-lg-7">
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
                <div class="j-subj">{{ $j->mata_pelajaran }}{{ $j->topik ? ' – '.$j->topik : '' }}</div>
                <div class="j-tutor"><i class="bi bi-person-fill me-1"></i> {{ $j->tutor->name ?? '-' }}</div>
                <span class="j-type" style="background:{{ $j->mode === 'online' ? 'var(--info-soft)' : 'var(--success-soft)' }};color:{{ $j->mode === 'online' ? 'var(--info)' : 'var(--success)' }};">
                    {{ $j->mode === 'online' ? 'Online (Zoom)' : 'Tatap Muka' }}
                </span>
            </div>
            <div class="jadwal-avatar" style="background:var(--primary);">
                {{ strtoupper(substr($j->tutor->name ?? 'T', 0, 2)) }}
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:32px;color:var(--muted);background:var(--card-bg);border-radius:14px;border:1px solid var(--border);">
            <i class="bi bi-calendar-x" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
            <div style="font-size:13px;font-weight:700;margin-bottom:4px;">Belum ada jadwal les</div>
            <a href="/siswa/les-privat" style="font-size:12px;color:var(--primary);font-weight:600;">Pesan Les Sekarang →</a>
        </div>
        @endforelse
    </div>

</div>

{{-- REKOMENDASI --}}
<div class="section-title">
    <span>💡 Rekomendasi Pembelajaran</span>
    <a href="/siswa/belajar-tka">Lihat Semua →</a>
</div>
<div class="row g-3 mb-4">
    @php
    $ikonMap = [
    'matematika' => ['bi-calculator-fill', '#eff6ff', 'var(--primary)'],
    'fisika' => ['bi-lightning-charge-fill', '#dbeafe', '#2563eb'],
    'kimia' => ['bi-flask-conical-fill', 'var(--success-soft)', 'var(--success)'],
    'biologi' => ['bi-tree-fill', '#f0fdf4', '#15803d'],
    'bahasa inggris' => ['bi-translate', 'var(--accent-soft)', 'var(--warning)'],
    'bahasa indonesia'=> ['bi-book-fill', 'var(--danger-soft)', 'var(--danger)'],
    'ipa' => ['bi-stars', '#f0fdf4', '#0d9488'],
    'ips' => ['bi-globe2', '#fef3c7', '#d97706'],
    ];
    $def = ['bi-journal-text', '#f1f5f9', '#64748b'];
    $btnStyle = [
    0 => ['#eff6ff', 'var(--primary)'],
    1 => ['var(--info-soft)', 'var(--info)'],
    2 => ['var(--accent-soft)', 'var(--warning)'],
    ];
    @endphp

    @forelse($rekomendasiMateri as $idx => $m)
    @php
    $ik = $ikonMap[strtolower($m->mata_pelajaran)] ?? $def;
    $btn = $btnStyle[$idx % 3];
    $label = $m->tipe === 'video' ? 'Tonton Sekarang' : ($m->soal_count > 0 ? 'Mulai Latihan' : 'Buka Materi');
    @endphp
    <div class="col-md-4">
        <div class="rec-card">
            <div class="rec-icon" style="background:{{ $ik[1] }};color:{{ $ik[2] }};">
                <i class="bi {{ $ik[0] }}"></i>
            </div>
            <div>
                <div class="rec-title">{{ $m->judul }}</div>
                <div class="rec-sub">
                    {{ $m->mata_pelajaran }} · {{ strtoupper($m->jenjang) }}
                    @if($m->soal_count > 0) · {{ $m->soal_count }} soal @endif
                    @if($m->tipe === 'video') · 📹 Video @endif
                </div>
                <a href="/siswa/belajar-tka" class="btn-rec"
                    style="background:{{ $btn[0] }};color:{{ $btn[1] }};text-decoration:none;display:inline-block;">
                    {{ $label }}
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div style="text-align:center;padding:24px;color:var(--muted);font-size:13px;">
            Belum ada materi tersedia.
        </div>
    </div>
    @endforelse
</div>

{{-- TESTIMONI --}}
<div class="section-title">
    <span>💬 Testimoni Pengguna</span>
    <a href="#">Lihat Semua →</a>
</div>
<div class="row g-3 mb-4">
    @forelse($testimoni as $t)
    <div class="col-md-4">
        <div class="testi-card">
            <div class="testi-stars">
                @for($i=1;$i<=5;$i++){{ $i <= $t->bintang ? '★' : '☆' }}@endfor
                    </div>
                    <div class="testi-text">"{{ $t->komentar }}"</div>
                    <div class="testi-user">
                        <div class="testi-av" style="background:var(--primary);">
                            {{ strtoupper(substr($t->siswa->name ?? 'S', 0, 2)) }}
                        </div>
                        <div>
                            <div class="testi-name">{{ $t->siswa->name ?? '-' }}</div>
                            <div class="testi-kelas">{{ $t->siswa->kota ?? 'Al Ilmi Center' }}</div>
                        </div>
                    </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div style="text-align:center;padding:24px;color:var(--muted);font-size:13px;">
                Belum ada testimoni
            </div>
        </div>
        @endforelse
    </div>

    @endsection