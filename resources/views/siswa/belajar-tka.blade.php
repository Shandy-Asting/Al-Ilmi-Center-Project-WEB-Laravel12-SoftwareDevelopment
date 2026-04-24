@extends('layouts.app')

@section('title', 'Belajar TKA - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Belajar TKA')
@section('page-sub', 'Dashboard / Belajar TKA')

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
        /* ── STEP BAR ── */
        .step-bar {
            display: flex;
            align-items: center;
            gap: 0;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 24px;
            margin-bottom: 28px;
            overflow-x: auto;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .step-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-circle.done {
            background: var(--success);
            color: #fff;
        }

        .step-circle.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(30, 58, 95, .15);
        }

        .step-circle.pending {
            background: var(--bg);
            color: var(--muted);
            border: 2px solid var(--border);
        }

        .step-label {
            font-size: 12.5px;
            font-weight: 600;
        }

        .step-label.active {
            color: var(--primary);
        }

        .step-label.done {
            color: var(--success);
        }

        .step-label.pending {
            color: var(--muted);
        }

        .step-divider {
            flex: 1;
            height: 2px;
            background: var(--border);
            margin: 0 12px;
            min-width: 24px;
        }

        .step-divider.done {
            background: var(--success);
        }

        /* ── JENJANG CARD ── */
        .jenjang-card {
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 22px 18px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            height: 100%;
        }

        .jenjang-card:hover {
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(30, 58, 95, .12);
        }

        .jenjang-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
            box-shadow: 0 6px 20px rgba(30, 58, 95, .18);
        }

        .jenjang-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .jenjang-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 4px;
            color: var(--text);
        }

        .jenjang-sub {
            font-size: 12px;
            color: var(--muted);
        }

        .jenjang-badge {
            display: inline-block;
            margin-top: 8px;
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* ── MATERI CARD ── */
        .materi-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 10px;
        }

        .materi-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 4px 14px rgba(30, 58, 95, .1);
        }

        .materi-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .materi-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .m-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .m-sub {
            font-size: 12px;
            color: var(--muted);
        }

        .m-tags {
            margin-top: 5px;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .materi-tag {
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .materi-progress {
            margin-left: auto;
            text-align: center;
            min-width: 56px;
        }

        .mp-val {
            font-size: 16px;
            font-weight: 800;
            color: var(--primary);
        }

        .mp-label {
            font-size: 10px;
            color: var(--muted);
        }

        /* ── TABS ── */
        .tka-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 6px;
        }

        .tka-tab {
            flex: 1;
            text-align: center;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            color: var(--muted);
            border: none;
            background: transparent;
        }

        .tka-tab.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 3px 10px rgba(30, 58, 95, .25);
        }

        .tka-tab:hover:not(.active) {
            background: var(--bg);
            color: var(--primary);
        }

        /* ── SOAL AREA ── */
        .soal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 60%, #3b6fa0 100%);
            border-radius: 16px;
            padding: 20px 24px;
            color: #fff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .soal-header h5 {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .soal-header p {
            font-size: 12.5px;
            opacity: .8;
            margin: 0;
        }

        .timer-box {
            background: rgba(255, 255, 255, .15);
            border-radius: 10px;
            padding: 8px 16px;
            text-align: center;
        }

        .t-val {
            font-size: 22px;
            font-weight: 800;
        }

        .t-label {
            font-size: 10px;
            opacity: .7;
        }

        .soal-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        .soal-num {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .soal-text {
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 20px;
            font-weight: 500;
            color: var(--text);
        }

        .opsi-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all .2s;
        }

        .opsi-item:hover {
            border-color: var(--primary-light);
            background: #f8faff;
        }

        .opsi-item.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .opsi-item.correct {
            border-color: var(--success);
            background: var(--success-soft);
        }

        .opsi-item.wrong {
            border-color: var(--danger);
            background: var(--danger-soft);
        }

        .opsi-key {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            background: var(--bg);
            color: var(--muted);
            flex-shrink: 0;
        }

        .opsi-item.selected .opsi-key {
            background: var(--primary);
            color: #fff;
        }

        .opsi-item.correct .opsi-key {
            background: var(--success);
            color: #fff;
        }

        .opsi-item.wrong .opsi-key {
            background: var(--danger);
            color: #fff;
        }

        .opsi-text {
            font-size: 13.5px;
            line-height: 1.5;
            padding-top: 4px;
            color: var(--text);
        }

        .soal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-soal {
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-soal-prev {
            background: var(--bg);
            color: var(--muted);
        }

        .btn-soal-prev:hover {
            background: #eff6ff;
            color: var(--primary);
        }

        .btn-soal-next {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(30, 58, 95, .3);
        }

        .btn-soal-next:hover {
            background: var(--primary-light);
        }

        .btn-soal-submit {
            background: var(--success);
            color: #fff;
            box-shadow: 0 4px 12px rgba(22, 163, 74, .3);
        }

        /* ── NOMOR SOAL GRID ── */
        .nomor-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
        }

        .nomor-btn {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--bg);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            color: var(--muted);
        }

        .nomor-btn:hover {
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .nomor-btn.answered {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .nomor-btn.current {
            background: var(--primary-light);
            border-color: var(--primary-light);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, .2);
        }

        .nomor-btn.correct {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
        }

        .nomor-btn.wrong {
            background: var(--danger);
            border-color: var(--danger);
            color: #fff;
        }

        /* ── PEMBAHASAN ── */
        .pembahasan-box {
            background: var(--success-soft);
            border: 1.5px solid #a7f3d0;
            border-radius: 14px;
            padding: 18px 20px;
            margin-top: 16px;
        }

        .pb-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--success);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pb-text {
            font-size: 13.5px;
            line-height: 1.7;
            color: var(--text);
        }

        /* ── FEEDBACK TUTOR ── */
        .feedback-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 18px 20px;
        }

        .feedback-av {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 14px;
            flex-shrink: 0;
        }

        .feedback-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .feedback-role {
            font-size: 11px;
            color: var(--muted);
        }

        .feedback-text {
            font-size: 13px;
            line-height: 1.7;
            color: var(--muted);
            background: var(--bg);
            border-radius: 10px;
            padding: 12px 14px;
            border-left: 3px solid var(--primary);
        }

        .feedback-time {
            font-size: 11px;
            color: var(--muted);
            margin-top: 8px;
        }

        /* ── HASIL KUIS ── */
        .hasil-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 60%, #3b6fa0 100%);
            border-radius: 20px;
            padding: 30px 32px;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .hasil-score {
            font-size: 64px;
            font-weight: 800;
            line-height: 1;
        }

        .hasil-score span {
            font-size: 22px;
        }

        .hasil-grade {
            font-size: 18px;
            font-weight: 700;
            margin-top: 6px;
            opacity: .9;
        }

        .hasil-sub {
            font-size: 13px;
            opacity: .75;
            margin-top: 4px;
        }

        .hasil-stat {
            display: flex;
            justify-content: center;
            gap: 32px;
            margin-top: 20px;
        }

        .hs-val {
            font-size: 22px;
            font-weight: 800;
        }

        .hs-label {
            font-size: 11px;
            opacity: .7;
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
    </style>
@endpush

@section('content')

    {{-- ── PAGE HEADER ── --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">📚 Belajar TKA</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Belajar TKA</span>
        </div>
    </div>

    {{-- ── STEP BAR ── --}}
    <div class="step-bar">
        <div class="step-item">
            <div class="step-circle done"><i class="bi bi-check-lg"></i></div>
            <div class="step-label done">Pilih Jenjang</div>
        </div>
        <div class="step-divider done"></div>
        <div class="step-item">
            <div class="step-circle done"><i class="bi bi-check-lg"></i></div>
            <div class="step-label done">Pilih Materi</div>
        </div>
        <div class="step-divider done"></div>
        <div class="step-item">
            <div class="step-circle active">3</div>
            <div class="step-label active">Latihan / Kuis</div>
        </div>
        <div class="step-divider"></div>
        <div class="step-item">
            <div class="step-circle pending">4</div>
            <div class="step-label pending">Pembahasan</div>
        </div>
        <div class="step-divider"></div>
        <div class="step-item">
            <div class="step-circle pending">5</div>
            <div class="step-label pending">Feedback Tutor</div>
        </div>
    </div>

    {{-- ══ STEP 1: PILIH JENJANG ══ --}}
    <div id="step-jenjang">
        <div class="section-title"><span>🎓 Pilih Jenjang Pendidikan</span></div>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="jenjang-card" onclick="selectJenjang(this,'SD')">
                    <div class="jenjang-icon">🏫</div>
                    <div class="jenjang-title">SD / Sederajat</div>
                    <div class="jenjang-sub">Kelas 1 – 6 Sekolah Dasar</div>
                    <span class="jenjang-badge" style="background:var(--success-soft);color:var(--success);">12 Materi
                        Tersedia</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jenjang-card selected" onclick="selectJenjang(this,'SMP')">
                    <div class="jenjang-icon">🏛️</div>
                    <div class="jenjang-title">SMP / Sederajat</div>
                    <div class="jenjang-sub">Kelas 7 – 9 Sekolah Menengah Pertama</div>
                    <span class="jenjang-badge" style="background:var(--accent-soft);color:var(--warning);">18 Materi
                        Tersedia</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jenjang-card" onclick="selectJenjang(this,'SMA')">
                    <div class="jenjang-icon">🎓</div>
                    <div class="jenjang-title">SMA / Sederajat</div>
                    <div class="jenjang-sub">Kelas 10 – 12 Sekolah Menengah Atas</div>
                    <span class="jenjang-badge" style="background:#eff6ff;color:var(--primary);">24 Materi Tersedia</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ STEP 2: PILIH MATERI ══ --}}
    <div id="step-materi">
        <div class="section-title">
            <span>📖 Pilih Materi Pembelajaran</span>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
                    <option>Semua Mapel</option>
                    <option>Matematika</option>
                    <option>Fisika</option>
                    <option>Kimia</option>
                    <option>Biologi</option>
                </select>
                <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
                    <option>Semua Kelas</option>
                    <option>Kelas 10</option>
                    <option selected>Kelas 11</option>
                    <option>Kelas 12</option>
                </select>
            </div>
        </div>

        {{-- TABS MAPEL --}}
        <div class="tka-tabs mb-3">
            <button class="tka-tab active" onclick="switchTab(this)">Matematika</button>
            <button class="tka-tab" onclick="switchTab(this)">Fisika</button>
            <button class="tka-tab" onclick="switchTab(this)">Kimia</button>
            <button class="tka-tab" onclick="switchTab(this)">Biologi</button>
            <button class="tka-tab" onclick="switchTab(this)">B. Indonesia</button>
        </div>

        <div class="materi-card selected">
            <div class="materi-icon" style="background:#eff6ff;color:var(--primary);"><i class="bi bi-calculator-fill"></i>
            </div>
            <div class="flex-grow-1">
                <div class="m-title">Integral Tak Tentu & Tentu</div>
                <div class="m-sub">Matematika · SMA Kelas 12 · 30 Soal Latihan</div>
                <div class="m-tags">
                    <span class="materi-tag" style="background:#eff6ff;color:var(--primary);">Kalkulus</span>
                    <span class="materi-tag" style="background:var(--accent-soft);color:var(--warning);">⭐ Favorit</span>
                </div>
            </div>
            <div class="materi-progress">
                <div class="mp-val">75%</div>
                <div class="mp-label">Selesai</div>
            </div>
        </div>
        <div class="materi-card">
            <div class="materi-icon" style="background:var(--success-soft);color:var(--success);"><i
                    class="bi bi-graph-up-arrow"></i></div>
            <div class="flex-grow-1">
                <div class="m-title">Limit Fungsi Aljabar</div>
                <div class="m-sub">Matematika · SMA Kelas 11 · 25 Soal Latihan</div>
                <div class="m-tags">
                    <span class="materi-tag" style="background:var(--success-soft);color:var(--success);">Aljabar</span>
                </div>
            </div>
            <div class="materi-progress">
                <div class="mp-val">40%</div>
                <div class="mp-label">Selesai</div>
            </div>
        </div>
        <div class="materi-card">
            <div class="materi-icon" style="background:var(--info-soft);color:var(--info);"><i class="bi bi-bezier2"></i>
            </div>
            <div class="flex-grow-1">
                <div class="m-title">Trigonometri Lanjut</div>
                <div class="m-sub">Matematika · SMA Kelas 11 · 20 Soal Latihan</div>
                <div class="m-tags">
                    <span class="materi-tag" style="background:var(--info-soft);color:var(--info);">Trigonometri</span>
                    <span class="materi-tag" style="background:var(--danger-soft);color:var(--danger);">🔥 Populer</span>
                </div>
            </div>
            <div class="materi-progress">
                <div class="mp-val">20%</div>
                <div class="mp-label">Selesai</div>
            </div>
        </div>
        <div class="materi-card">
            <div class="materi-icon" style="background:var(--accent-soft);color:var(--warning);"><i
                    class="bi bi-diagram-3-fill"></i></div>
            <div class="flex-grow-1">
                <div class="m-title">Statistika & Peluang</div>
                <div class="m-sub">Matematika · SMA Kelas 12 · 35 Soal Latihan</div>
                <div class="m-tags">
                    <span class="materi-tag" style="background:var(--accent-soft);color:var(--warning);">Statistika</span>
                </div>
            </div>
            <div class="materi-progress">
                <div class="mp-val">0%</div>
                <div class="mp-label">Belum Mulai</div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3 mb-4">
            <button class="btn btn-sm px-4 py-2 fw-bold"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;" onclick="showLatihan()">
                <i class="bi bi-pencil-fill me-1"></i> Latihan Soal
            </button>
            <button class="btn btn-sm px-4 py-2 fw-bold"
                style="background:var(--accent-soft);color:var(--warning);border-radius:10px;border:none;"
                onclick="showKuis()">
                <i class="bi bi-lightning-fill me-1"></i> Mulai Kuis
            </button>
        </div>
    </div>

    {{-- ══ STEP 3: LATIHAN SOAL ══ --}}
    <div id="step-latihan" style="display:none;">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="soal-header">
                    <div>
                        <h5>Integral Tak Tentu & Tentu</h5>
                        <p>SMA Kelas 12 · Matematika · 15 Soal</p>
                    </div>
                    <div class="timer-box">
                        <div class="t-val" id="timer">14:32</div>
                        <div class="t-label">Sisa Waktu</div>
                    </div>
                </div>

                <div class="soal-card">
                    <div class="soal-num">SOAL 3 DARI 15</div>
                    <div class="soal-text">
                        Tentukan hasil dari integral berikut:<br><br>
                        <div class="text-center my-3 p-3"
                            style="background:var(--bg);border-radius:10px;font-size:18px;font-weight:700;">
                            ∫ (3x² + 2x – 5) dx
                        </div>
                        Pilih jawaban yang paling tepat:
                    </div>

                    <div class="opsi-item" onclick="pilihOpsi(this,'A')">
                        <div class="opsi-key">A</div>
                        <div class="opsi-text">x³ + x² – 5x + C</div>
                    </div>
                    <div class="opsi-item selected" onclick="pilihOpsi(this,'B')">
                        <div class="opsi-key">B</div>
                        <div class="opsi-text">x³ + x² – 5x + C</div>
                    </div>
                    <div class="opsi-item" onclick="pilihOpsi(this,'C')">
                        <div class="opsi-key">C</div>
                        <div class="opsi-text">3x³ + 2x² – 5x + C</div>
                    </div>
                    <div class="opsi-item" onclick="pilihOpsi(this,'D')">
                        <div class="opsi-key">D</div>
                        <div class="opsi-text">x³ + x² + 5x + C</div>
                    </div>
                    <div class="opsi-item" onclick="pilihOpsi(this,'E')">
                        <div class="opsi-key">E</div>
                        <div class="opsi-text">6x + 2 + C</div>
                    </div>

                    <div class="soal-nav">
                        <button class="btn-soal btn-soal-prev"><i class="bi bi-chevron-left me-1"></i> Sebelumnya</button>
                        <button class="btn-soal" style="background:var(--bg);color:var(--muted);border-radius:10px;"
                            onclick="showPembahasan()">
                            <i class="bi bi-lightbulb me-1"></i> Lihat Pembahasan
                        </button>
                        <button class="btn-soal btn-soal-next">Selanjutnya <i
                                class="bi bi-chevron-right ms-1"></i></button>
                    </div>
                </div>

                {{-- PEMBAHASAN --}}
                <div id="pembahasan-box" class="pembahasan-box mt-3" style="display:none;">
                    <div class="pb-title"><i class="bi bi-lightbulb-fill"></i> Pembahasan Soal</div>
                    <div class="pb-text">
                        Untuk mengintegralkan <strong>∫ (3x² + 2x – 5) dx</strong>:<br><br>
                        <strong>Langkah 1:</strong> ∫ 3x² dx = x³<br>
                        <strong>Langkah 2:</strong> ∫ 2x dx = x²<br>
                        <strong>Langkah 3:</strong> ∫ –5 dx = –5x<br><br>
                        Hasil: <strong>x³ + x² – 5x + C</strong> ✅ — Jawaban <strong>B</strong>
                    </div>
                </div>

                {{-- FEEDBACK TUTOR --}}
                <div class="feedback-card mt-3">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="feedback-av">BS</div>
                        <div>
                            <div class="feedback-name">Pak Budi Santoso</div>
                            <div class="feedback-role">Tutor Matematika · ★ 4.9</div>
                        </div>
                        <span class="ms-auto pill p-success" style="font-size:11px;">Feedback Tutor</span>
                    </div>
                    <div class="feedback-text">
                        "Andi, kamu sudah benar memilih jawaban B! Perhatikan selalu tambahkan konstanta <strong>C</strong>.
                        Untuk latihan lanjutan, coba kerjakan soal integral trigonometri. Semangat! 💪"
                    </div>
                    <div class="feedback-time"><i class="bi bi-clock me-1"></i> Dikirim 2 jam lalu</div>
                </div>
            </div>

            {{-- Panel Samping --}}
            <div class="col-lg-4">
                <div class="card-box mb-3">
                    <div style="font-size:13px;font-weight:700;margin-bottom:12px;">Navigasi Soal</div>
                    <div class="nomor-grid mb-3">
                        <button class="nomor-btn correct">1</button>
                        <button class="nomor-btn correct">2</button>
                        <button class="nomor-btn current">3</button>
                        <button class="nomor-btn answered">4</button>
                        <button class="nomor-btn">5</button>
                        <button class="nomor-btn">6</button>
                        <button class="nomor-btn">7</button>
                        <button class="nomor-btn">8</button>
                        <button class="nomor-btn">9</button>
                        <button class="nomor-btn">10</button>
                        <button class="nomor-btn">11</button>
                        <button class="nomor-btn">12</button>
                        <button class="nomor-btn">13</button>
                        <button class="nomor-btn">14</button>
                        <button class="nomor-btn">15</button>
                    </div>
                    <div style="font-size:11px;color:var(--muted);margin-bottom:10px;">
                        <span class="me-3"><span
                                style="display:inline-block;width:10px;height:10px;background:var(--primary);border-radius:3px;"></span>
                            Dijawab (2)</span>
                        <span class="me-3"><span
                                style="display:inline-block;width:10px;height:10px;background:var(--success);border-radius:3px;"></span>
                            Benar (2)</span>
                        <span><span
                                style="display:inline-block;width:10px;height:10px;background:var(--border);border-radius:3px;"></span>
                            Belum (11)</span>
                    </div>
                    <button class="btn-soal btn-soal-submit w-100" onclick="showHasil()">
                        <i class="bi bi-check-circle-fill me-1"></i> Kumpulkan Jawaban
                    </button>
                </div>

                <div class="card-box">
                    <div style="font-size:13px;font-weight:700;margin-bottom:12px;">Statistik Sesi Ini</div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-center">
                            <div style="font-size:20px;font-weight:800;color:var(--success);">2</div>
                            <div style="font-size:11px;color:var(--muted);">Benar</div>
                        </div>
                        <div class="text-center">
                            <div style="font-size:20px;font-weight:800;color:var(--danger);">0</div>
                            <div style="font-size:11px;color:var(--muted);">Salah</div>
                        </div>
                        <div class="text-center">
                            <div style="font-size:20px;font-weight:800;color:var(--muted);">13</div>
                            <div style="font-size:11px;color:var(--muted);">Belum</div>
                        </div>
                        <div class="text-center">
                            <div style="font-size:20px;font-weight:800;color:var(--primary);">13%</div>
                            <div style="font-size:11px;color:var(--muted);">Progres</div>
                        </div>
                    </div>
                    <div style="height:6px;background:var(--bg);border-radius:10px;overflow:hidden;">
                        <div style="height:100%;width:13%;background:var(--primary);border-radius:10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ HASIL KUIS ══ --}}
    <div id="step-hasil" style="display:none;">
        <div class="hasil-banner">
            <div style="font-size:14px;font-weight:600;opacity:.8;margin-bottom:8px;">🎉 Latihan Selesai!</div>
            <div class="hasil-score">87<span>/100</span></div>
            <div class="hasil-grade">Nilai: A – Sangat Baik!</div>
            <div class="hasil-sub">Integral Tak Tentu & Tentu · SMA Kelas 12 · Matematika</div>
            <div class="hasil-stat">
                <div class="text-center">
                    <div class="hs-val">13</div>
                    <div class="hs-label">Soal Benar</div>
                </div>
                <div class="text-center">
                    <div class="hs-val">2</div>
                    <div class="hs-label">Soal Salah</div>
                </div>
                <div class="text-center">
                    <div class="hs-val">18m</div>
                    <div class="hs-label">Waktu</div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card-box text-center">
                    <i class="bi bi-arrow-repeat" style="font-size:28px;color:var(--primary);"></i>
                    <div style="font-size:13px;font-weight:700;margin-top:10px;">Ulangi Latihan</div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:14px;">Kerjakan ulang soal yang sama</div>
                    <button class="btn btn-sm w-100 fw-bold"
                        style="background:var(--bg);color:var(--primary);border-radius:10px;border:none;"
                        onclick="showLatihan()">Ulangi</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box text-center">
                    <i class="bi bi-lightbulb-fill" style="font-size:28px;color:var(--warning);"></i>
                    <div style="font-size:13px;font-weight:700;margin-top:10px;">Review Pembahasan</div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:14px;">Pelajari soal yang salah</div>
                    <button class="btn btn-sm w-100 fw-bold"
                        style="background:var(--accent-soft);color:var(--warning);border-radius:10px;border:none;"
                        onclick="showLatihan()">Review</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box text-center">
                    <i class="bi bi-book-fill" style="font-size:28px;color:var(--success);"></i>
                    <div style="font-size:13px;font-weight:700;margin-top:10px;">Materi Selanjutnya</div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:14px;">Lanjut ke topik berikutnya</div>
                    <button class="btn btn-sm w-100 fw-bold"
                        style="background:var(--success-soft);color:var(--success);border-radius:10px;border:none;">Lanjut</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function selectJenjang(el, val) {
            document.querySelectorAll('.jenjang-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        function switchTab(el) {
            document.querySelectorAll('.tka-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }

        function pilihOpsi(el, key) {
            document.querySelectorAll('.opsi-item').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            el.querySelector('.opsi-key').textContent = key;
        }

        function showLatihan() {
            document.getElementById('step-jenjang').style.display = 'none';
            document.getElementById('step-materi').style.display = 'none';
            document.getElementById('step-latihan').style.display = '';
            document.getElementById('step-hasil').style.display = 'none';
            document.getElementById('pembahasan-box').style.display = 'none';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showKuis() {
            showLatihan();
        }

        function showPembahasan() {
            const pb = document.getElementById('pembahasan-box');
            pb.style.display = pb.style.display === 'none' ? '' : 'none';
        }

        function showHasil() {
            document.getElementById('step-latihan').style.display = 'none';
            document.getElementById('step-hasil').style.display = '';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Timer
        let seconds = 14 * 60 + 32;
        setInterval(() => {
            if (seconds <= 0) return;
            seconds--;
            const m = Math.floor(seconds / 60).toString().padStart(2, '0');
            const s = (seconds % 60).toString().padStart(2, '0');
            const el = document.getElementById('timer');
            if (el) el.textContent = m + ':' + s;
        }, 1000);
    </script>
@endpush
