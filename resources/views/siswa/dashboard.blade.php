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
    <a href="#" class="nav-item-custom">
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
    </style>
@endpush

@section('content')

    {{-- ── GREETING BANNER ── --}}
    <div class="greeting-banner">
        <span class="tag">🌟 Selamat Datang Kembali!</span>
        <h2>Halo, Andi Pratama!</h2>
        <p>Kamu sudah belajar <strong>5 hari berturut-turut</strong>. Teruskan semangatmu hari ini!</p>
        <button class="btn-banner"><i class="bi bi-play-fill me-1"></i> Lanjutkan Belajar</button>
        <div class="streak-badge">
            <div style="font-size:22px;">🔥</div>
            <div class="streak-num">5</div>
            <div class="streak-label">Hari Streak</div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div class="stat-val">87</div>
                <div class="stat-label">Rata-rata Nilai</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+5 dari minggu lalu</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--success-soft);color:var(--success);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-val">42</div>
                <div class="stat-label">Soal Diselesaikan</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+12 minggu ini</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="stat-val">8.5<span style="font-size:14px;font-weight:500;">j</span></div>
                <div class="stat-label">Jam Belajar Bulan Ini</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+2j bulan lalu</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="stat-val">3</div>
                <div class="stat-label">Les Privat Bulan Ini</div>
                <div class="stat-change down"><i class="bi bi-arrow-down-short"></i>-1 dari bulan lalu</div>
            </div>
        </div>
    </div>

    {{-- ── PROGRES + JADWAL ── --}}
    <div class="row g-3 mb-4">

        {{-- Progres Belajar --}}
        <div class="col-lg-5">
            <div class="section-title">
                <span>📊 Ringkasan Progres Belajar</span>
                <a href="#">Lihat Detail →</a>
            </div>
            <div class="progress-card">
                <div class="subject-row">
                    <div class="subj-head">
                        <span class="subj-name">Matematika</span>
                        <span class="subj-pct" style="color:var(--primary);">82%</span>
                    </div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar"
                            style="width:82%;background:linear-gradient(90deg,var(--primary),var(--primary-light));"></div>
                    </div>
                </div>
                <div class="subject-row">
                    <div class="subj-head">
                        <span class="subj-name">Fisika</span>
                        <span class="subj-pct" style="color:var(--info);">68%</span>
                    </div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar"
                            style="width:68%;background:linear-gradient(90deg,var(--info),#67E8F9);"></div>
                    </div>
                </div>
                <div class="subject-row">
                    <div class="subj-head">
                        <span class="subj-name">Kimia</span>
                        <span class="subj-pct" style="color:var(--success);">75%</span>
                    </div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar"
                            style="width:75%;background:linear-gradient(90deg,var(--success),#6EE7B7);"></div>
                    </div>
                </div>
                <div class="subject-row">
                    <div class="subj-head">
                        <span class="subj-name">Biologi</span>
                        <span class="subj-pct" style="color:var(--accent);">90%</span>
                    </div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar"
                            style="width:90%;background:linear-gradient(90deg,var(--accent),#FCD34D);"></div>
                    </div>
                </div>
                <div class="subject-row">
                    <div class="subj-head">
                        <span class="subj-name">Bahasa Indonesia</span>
                        <span class="subj-pct" style="color:var(--danger);">55%</span>
                    </div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar"
                            style="width:55%;background:linear-gradient(90deg,var(--danger),#FCA5A5);"></div>
                    </div>
                </div>

                {{-- Mini Bar Chart --}}
                <div class="mt-3 p-3 rounded-3" style="background:var(--bg);">
                    <div class="d-flex justify-content-between align-items-end" style="height:60px;gap:6px;">
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--primary-light);height:30px;border-radius:4px 4px 0 0;opacity:.6;">
                            </div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Sen</div>
                        </div>
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--primary-light);height:45px;border-radius:4px 4px 0 0;opacity:.7;">
                            </div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Sel</div>
                        </div>
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--primary-light);height:35px;border-radius:4px 4px 0 0;opacity:.6;">
                            </div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Rab</div>
                        </div>
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--primary-light);height:52px;border-radius:4px 4px 0 0;opacity:.8;">
                            </div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Kam</div>
                        </div>
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--primary);height:48px;border-radius:4px 4px 0 0;"></div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Jum</div>
                        </div>
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--primary);height:40px;border-radius:4px 4px 0 0;"></div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Sab</div>
                        </div>
                        <div style="flex:1;text-align:center;">
                            <div style="background:var(--border);height:20px;border-radius:4px 4px 0 0;"></div>
                            <div style="font-size:10px;color:var(--muted);margin-top:3px;">Min</div>
                        </div>
                    </div>
                    <div style="font-size:11px;color:var(--muted);text-align:center;margin-top:2px;">Aktivitas Belajar
                        Mingguan</div>
                </div>
            </div>
        </div>

        {{-- Jadwal Tutor --}}
        <div class="col-lg-7">
            <div class="section-title">
                <span>📅 Jadwal Terdekat dengan Tutor</span>
                <a href="#">Lihat Semua →</a>
            </div>
            <div class="jadwal-card">
                <div class="jadwal-time">
                    <div class="time-val">09.00</div>
                    <div class="time-day">Senin, 7 Apr</div>
                </div>
                <div class="jadwal-info">
                    <div class="j-subj">Matematika – Integral</div>
                    <div class="j-tutor"><i class="bi bi-person-fill me-1"></i> Pak Budi Santoso</div>
                    <span class="j-type" style="background:var(--info-soft);color:var(--info);">Online (Zoom)</span>
                </div>
                <div class="jadwal-avatar" style="background:var(--primary);">BS</div>
            </div>
            <div class="jadwal-card">
                <div class="jadwal-time">
                    <div class="time-val">14.00</div>
                    <div class="time-day">Selasa, 8 Apr</div>
                </div>
                <div class="jadwal-info">
                    <div class="j-subj">Fisika – Gelombang Bunyi</div>
                    <div class="j-tutor"><i class="bi bi-person-fill me-1"></i> Bu Sari Dewi</div>
                    <span class="j-type" style="background:var(--success-soft);color:var(--success);">Tatap Muka</span>
                </div>
                <div class="jadwal-avatar" style="background:var(--success);">SD</div>
            </div>
            <div class="jadwal-card">
                <div class="jadwal-time">
                    <div class="time-val">16.00</div>
                    <div class="time-day">Kamis, 10 Apr</div>
                </div>
                <div class="jadwal-info">
                    <div class="j-subj">Kimia – Laju Reaksi</div>
                    <div class="j-tutor"><i class="bi bi-person-fill me-1"></i> Pak Rizal Hakim</div>
                    <span class="j-type" style="background:var(--accent-soft);color:var(--warning);">Online (Zoom)</span>
                </div>
                <div class="jadwal-avatar" style="background:var(--warning);">RH</div>
            </div>
            <div class="jadwal-card" style="border:1.5px dashed var(--primary-light);background:#f8faff;">
                <div class="jadwal-time">
                    <div class="time-val" style="color:var(--muted);">+</div>
                    <div class="time-day">Tambah</div>
                </div>
                <div class="jadwal-info">
                    <div class="j-subj" style="color:var(--primary);">Pesan Jadwal Les Baru</div>
                    <div class="j-tutor">Pilih tutor & tentukan waktumu</div>
                </div>
                <button class="btn btn-sm"
                    style="background:#eff6ff;color:var(--primary);font-weight:700;font-size:12px;border-radius:8px;">Pesan</button>
            </div>
        </div>
    </div>

    {{-- ── REKOMENDASI ── --}}
    <div class="section-title">
        <span>💡 Rekomendasi Pembelajaran</span>
        <a href="#">Lihat Semua →</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="rec-card">
                <div class="rec-icon" style="background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-calculator-fill"></i>
                </div>
                <div>
                    <div class="rec-title">Latihan Integral Trigonometri</div>
                    <div class="rec-sub">Matematika · SMA · 25 soal latihan</div>
                    <button class="btn-rec" style="background:#eff6ff;color:var(--primary);">Mulai Latihan</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="rec-card">
                <div class="rec-icon" style="background:var(--info-soft);color:var(--info);">
                    <i class="bi bi-lightning-fill"></i>
                </div>
                <div>
                    <div class="rec-title">Kuis Hukum Newton</div>
                    <div class="rec-sub">Fisika · SMA · 15 soal kuis cepat</div>
                    <button class="btn-rec" style="background:var(--info-soft);color:var(--info);">Mulai Kuis</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="rec-card">
                <div class="rec-icon" style="background:var(--accent-soft);color:var(--warning);">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div>
                    <div class="rec-title">Video: Reaksi Redoks Lengkap</div>
                    <div class="rec-sub">Kimia · SMA · 18 menit tontonan</div>
                    <button class="btn-rec" style="background:var(--accent-soft);color:var(--warning);">Tonton
                        Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── TESTIMONI ── --}}
    <div class="section-title">
        <span>💬 Testimoni Pengguna</span>
        <a href="#">Lihat Semua →</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">"Berkat Al Ilmi Center, nilai matematika aku naik drastis dari 65 jadi 90 dalam 2
                    bulan. Tutornya sangat sabar!"</div>
                <div class="testi-user">
                    <div class="testi-av" style="background:var(--primary);">RA</div>
                    <div>
                        <div class="testi-name">Rizka Amalia</div>
                        <div class="testi-kelas">SMA Kelas 12 · Kediri</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">"Fitur latihan soal TKA-nya keren banget! Pembahasan lengkap dan ada feedback dari
                    tutor langsung."</div>
                <div class="testi-user">
                    <div class="testi-av" style="background:var(--success);">DP</div>
                    <div>
                        <div class="testi-name">Dani Putra</div>
                        <div class="testi-kelas">SMA Kelas 12 · Malang</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testi-card">
                <div class="testi-stars">★★★★☆</div>
                <div class="testi-text">"Les privat online-nya praktis, bisa dari rumah. Jadwalnya fleksibel, tidak
                    mengganggu sekolah."</div>
                <div class="testi-user">
                    <div class="testi-av" style="background:var(--warning);">SW</div>
                    <div>
                        <div class="testi-name">Siti Wahyuni</div>
                        <div class="testi-kelas">Orang Tua Siswa · Kediri</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── HARGA ── --}}
    <div class="section-title">
        <span>💳 Informasi Paket Harga</span>
        <a href="#">Bandingkan Paket →</a>
    </div>
    <div class="row g-3 mb-2">
        <div class="col-md-4">
            <div class="harga-card">
                <div class="harga-plan">Starter</div>
                <div class="harga-price">Rp 99K</div>
                <div class="harga-period">/ bulan</div>
                <ul class="harga-features">
                    <li><i class="bi bi-check-circle-fill"></i> Akses Belajar TKA</li>
                    <li><i class="bi bi-check-circle-fill"></i> 50 Soal Latihan/Bulan</li>
                    <li><i class="bi bi-check-circle-fill"></i> 1x Les Privat Online</li>
                    <li><i class="bi bi-x-circle-fill" style="color:var(--border);"></i> Feedback Tutor</li>
                </ul>
                <button class="btn-harga" style="background:var(--bg);color:var(--primary);">Pilih Paket</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="harga-card featured">
                <span class="harga-badge">Populer</span>
                <div class="harga-plan">Pro</div>
                <div class="harga-price">Rp 199K</div>
                <div class="harga-period">/ bulan</div>
                <ul class="harga-features">
                    <li><i class="bi bi-check-circle-fill"></i> Akses Belajar TKA Penuh</li>
                    <li><i class="bi bi-check-circle-fill"></i> Soal Latihan Tak Terbatas</li>
                    <li><i class="bi bi-check-circle-fill"></i> 4x Les Privat Online</li>
                    <li><i class="bi bi-check-circle-fill"></i> Feedback Tutor Langsung</li>
                </ul>
                <button class="btn-harga" style="background:var(--accent);color:var(--primary);">Pilih Paket</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="harga-card">
                <div class="harga-plan">Premium</div>
                <div class="harga-price">Rp 349K</div>
                <div class="harga-period">/ bulan</div>
                <ul class="harga-features">
                    <li><i class="bi bi-check-circle-fill"></i> Semua Fitur Pro</li>
                    <li><i class="bi bi-check-circle-fill"></i> 8x Les Privat Online/Offline</li>
                    <li><i class="bi bi-check-circle-fill"></i> Konsultasi Karir Studi</li>
                    <li><i class="bi bi-check-circle-fill"></i> Laporan Progres Mingguan</li>
                </ul>
                <button class="btn-harga" style="background:var(--primary);color:#fff;">Pilih Paket</button>
            </div>
        </div>
    </div>

@endsection
