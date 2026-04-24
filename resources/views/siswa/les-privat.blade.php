@extends('layouts.app')

@section('title', 'Les Privat - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Les Privat')
@section('page-sub', 'Dashboard / Les Privat')

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
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 24px;
            margin: 20px 0 28px;
            overflow-x: auto;
            gap: 0;
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
            transition: all .3s;
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
            min-width: 20px;
            transition: background .3s;
        }

        .step-divider.done {
            background: var(--success);
        }

        /* ── LAYANAN CARD ── */
        .layanan-card {
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 22px 18px;
            cursor: pointer;
            transition: all .22s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .layanan-card:hover {
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(30, 58, 95, .12);
        }

        .layanan-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
            box-shadow: 0 6px 22px rgba(30, 58, 95, .18);
        }

        .selected-check {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--primary);
            display: none;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 13px;
        }

        .layanan-card.selected .selected-check {
            display: flex;
        }

        .layanan-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 14px;
        }

        .layanan-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 4px;
            color: var(--text);
        }

        .layanan-desc {
            font-size: 12.5px;
            color: var(--muted);
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .layanan-price {
            font-size: 18px;
            font-weight: 800;
        }

        .layanan-period {
            font-size: 11px;
            color: var(--muted);
        }

        .layanan-features {
            list-style: none;
            padding: 0;
            margin-top: 12px;
        }

        .layanan-features li {
            font-size: 12px;
            padding: 4px 0;
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--muted);
        }

        .layanan-features li i {
            color: var(--success);
            font-size: 13px;
        }

        .layanan-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* ── FORM CARD ── */
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        .form-label-custom {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
            display: block;
            color: var(--text);
        }

        .form-control-custom {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            width: 100%;
            outline: none;
            transition: border-color .2s;
            color: var(--text);
            background: #fff;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
        }

        select.form-control-custom {
            cursor: pointer;
        }

        /* ── TUTOR CARD ── */
        .tutor-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 10px;
        }

        .tutor-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 4px 14px rgba(30, 58, 95, .1);
        }

        .tutor-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .tutor-av {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
        }

        .tutor-name {
            font-size: 14px;
            font-weight: 800;
            color: var(--text);
        }

        .tutor-mapel {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .tutor-stars {
            color: var(--accent);
            font-size: 12px;
        }

        .tutor-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .tutor-tag {
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .tutor-price {
            margin-left: auto;
            text-align: right;
            flex-shrink: 0;
        }

        .tp-val {
            font-size: 14px;
            font-weight: 800;
            color: var(--primary);
        }

        .tp-label {
            font-size: 10px;
            color: var(--muted);
        }

        .tp-avail {
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            margin-top: 4px;
            display: inline-block;
        }

        /* ── LOKASI ── */
        .lokasi-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 10px;
        }

        .lokasi-option:hover {
            border-color: var(--primary-light);
            background: #f8faff;
        }

        .lokasi-option.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .lokasi-option input[type=radio] {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
        }

        .lokasi-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .lokasi-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text);
        }

        .lokasi-sub {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── JADWAL ── */
        .hari-tabs {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding-bottom: 4px;
            margin-bottom: 14px;
        }

        .hari-tab {
            flex-shrink: 0;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--muted);
        }

        .hari-tab:hover {
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .hari-tab.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 3px 10px rgba(30, 58, 95, .25);
        }

        .hari-tab.disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .slot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .slot-btn {
            padding: 10px 4px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: #fff;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            text-align: center;
            color: var(--muted);
        }

        .slot-btn:hover {
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .slot-btn.selected {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 3px 10px rgba(30, 58, 95, .25);
        }

        .slot-btn.booked {
            background: #f8fafc;
            border-color: var(--border);
            color: #cbd5e1;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* ── SUMMARY ── */
        .summary-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            position: sticky;
            top: 80px;
        }

        .summary-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .sr-label {
            color: var(--muted);
        }

        .sr-val {
            font-weight: 600;
            text-align: right;
            max-width: 55%;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-top: 1px solid var(--border);
            margin-top: 6px;
            border-bottom: 1px solid var(--border);
        }

        .st-label {
            font-size: 14px;
            font-weight: 700;
        }

        .st-val {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
        }

        .btn-pesan {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(30, 58, 95, .3);
            transition: all .2s;
            margin-top: 14px;
        }

        .btn-pesan:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        /* ── STATUS TIMELINE ── */
        .status-timeline {
            position: relative;
            padding-left: 28px;
        }

        .status-timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: var(--border);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .tl-dot {
            position: absolute;
            left: -28px;
            top: 3px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            flex-shrink: 0;
            z-index: 1;
        }

        .tl-dot.done {
            background: var(--success);
            color: #fff;
        }

        .tl-dot.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, .2);
        }

        .tl-dot.pending {
            background: #fff;
            border: 2px solid var(--border);
            color: var(--muted);
        }

        .tl-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .tl-desc {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .tl-time {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── ORDER CARD ── */
        .order-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 12px;
            transition: box-shadow .2s;
        }

        .order-card:hover {
            box-shadow: 0 4px 14px rgba(0, 0, 0, .07);
        }

        .order-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .order-id {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
        }

        .order-body {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .order-av {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
        }

        .oi-subj {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .oi-tutor {
            font-size: 12px;
            color: var(--muted);
        }

        .oi-sched {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .order-action {
            margin-left: auto;
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-action {
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        /* ── MODAL ── */
        .modal-custom {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-custom.show {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            max-width: 420px;
            width: 90%;
            text-align: center;
            animation: modalIn .25s ease;
        }

        @keyframes modalIn {
            from {
                transform: scale(.92);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endpush

@section('content')

    {{-- PAGE HEADER --}}
    <div class="d-flex align-items-start justify-content-between mb-1">
        <div>
            <h4 class="fw-bold mb-1">🎓 Les Privat</h4>
            <div style="font-size:13px;color:var(--muted);">
                Dashboard / <span style="color:var(--primary);font-weight:600;">Les Privat</span>
            </div>
        </div>
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
            onclick="showTab('pesan')">
            <i class="bi bi-plus-lg me-1"></i> Pesan Les Baru
        </button>
    </div>

    {{-- STEP BAR --}}
    <div id="step-bar" class="step-bar">
        <div class="step-item">
            <div class="step-circle active" id="sc1">1</div>
            <div class="step-label active" id="sl1">Pilih Layanan</div>
        </div>
        <div class="step-divider" id="sd1"></div>
        <div class="step-item">
            <div class="step-circle pending" id="sc2">2</div>
            <div class="step-label pending" id="sl2">Pilih Tutor</div>
        </div>
        <div class="step-divider" id="sd2"></div>
        <div class="step-item">
            <div class="step-circle pending" id="sc3">3</div>
            <div class="step-label pending" id="sl3">Lokasi & Jadwal</div>
        </div>
        <div class="step-divider" id="sd3"></div>
        <div class="step-item">
            <div class="step-circle pending" id="sc4">4</div>
            <div class="step-label pending" id="sl4">Konfirmasi</div>
        </div>
    </div>

    {{-- MAIN TABS --}}
    <div class="d-flex gap-2 mb-4">
        <button class="btn btn-sm fw-bold px-4 py-2" id="tab-pesan"
            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
            onclick="showTab('pesan')">
            <i class="bi bi-plus-circle me-1"></i> Pesan Les
        </button>
        <button class="btn btn-sm fw-bold px-4 py-2" id="tab-status"
            style="background:#fff;color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
            onclick="showTab('status')">
            <i class="bi bi-list-check me-1"></i> Status Pemesanan
        </button>
    </div>

    {{-- ══════ TAB: PESAN LES ══════ --}}
    <div id="panel-pesan">

        {{-- STEP 1: PILIH LAYANAN --}}
        <div id="form-step1">
            <div style="font-size:15px;font-weight:700;margin-bottom:14px;">📦 Pilih Jenis Layanan</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="layanan-card selected" onclick="selectLayanan(this)">
                        <span class="selected-check"><i class="bi bi-check-lg"></i></span>
                        <span class="layanan-badge" style="background:#eff6ff;color:var(--primary);">Paling Populer</span>
                        <div class="layanan-icon" style="background:#eff6ff;color:var(--primary);margin-top:20px;"><i
                                class="bi bi-camera-video-fill"></i></div>
                        <div class="layanan-title">Online (Zoom/Meet)</div>
                        <div class="layanan-desc">Belajar dari rumah lewat video call bersama tutor terpilih</div>
                        <div class="layanan-price" style="color:var(--primary);">Rp 75.000</div>
                        <div class="layanan-period">/ sesi (90 menit)</div>
                        <ul class="layanan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Fleksibel dari mana saja</li>
                            <li><i class="bi bi-check-circle-fill"></i> Rekaman sesi tersedia</li>
                            <li><i class="bi bi-check-circle-fill"></i> Whiteboard digital</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layanan-card" onclick="selectLayanan(this)">
                        <span class="selected-check"><i class="bi bi-check-lg"></i></span>
                        <div class="layanan-icon" style="background:var(--success-soft);color:var(--success);"><i
                                class="bi bi-house-fill"></i></div>
                        <div class="layanan-title">Tatap Muka (Rumah Siswa)</div>
                        <div class="layanan-desc">Tutor datang langsung ke rumah siswa sesuai jadwal</div>
                        <div class="layanan-price" style="color:var(--success);">Rp 120.000</div>
                        <div class="layanan-period">/ sesi (90 menit)</div>
                        <ul class="layanan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Interaksi langsung</li>
                            <li><i class="bi bi-check-circle-fill"></i> Lebih fokus & kondusif</li>
                            <li><i class="bi bi-check-circle-fill"></i> Tanpa biaya transportasi</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layanan-card" onclick="selectLayanan(this)">
                        <span class="selected-check"><i class="bi bi-check-lg"></i></span>
                        <div class="layanan-icon" style="background:var(--info-soft);color:var(--info);"><i
                                class="bi bi-building"></i></div>
                        <div class="layanan-title">Tatap Muka (Lokasi Tutor)</div>
                        <div class="layanan-desc">Belajar di tempat tutor atau tempat belajar yang ditentukan</div>
                        <div class="layanan-price" style="color:var(--info);">Rp 90.000</div>
                        <div class="layanan-period">/ sesi (90 menit)</div>
                        <ul class="layanan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Suasana belajar kondusif</li>
                            <li><i class="bi bi-check-circle-fill"></i> Fasilitas lengkap</li>
                            <li><i class="bi bi-check-circle-fill"></i> Bisa belajar kelompok</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn fw-bold px-5 py-2"
                    style="background:var(--primary);color:#fff;border-radius:12px;border:none;" onclick="goStep(2)">
                    Lanjut Pilih Tutor <i class="bi bi-chevron-right ms-1"></i>
                </button>
            </div>
        </div>

        {{-- STEP 2: PILIH TUTOR --}}
        <div id="form-step2" style="display:none;">
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span style="font-size:15px;font-weight:700;">👨‍🏫 Pilih Tutor</span>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm"
                                style="width:auto;font-size:12px;border-radius:8px;">
                                <option>Semua Mapel</option>
                                <option selected>Matematika</option>
                                <option>Fisika</option>
                                <option>Kimia</option>
                            </select>
                        </div>
                    </div>

                    <div class="tutor-card selected" onclick="selectTutor(this)">
                        <div class="tutor-av" style="background:var(--primary);">BS</div>
                        <div>
                            <div class="tutor-name">Pak Budi Santoso, S.Pd</div>
                            <div class="tutor-mapel"><i class="bi bi-mortarboard-fill me-1"></i> Matematika, Fisika · 6
                                Tahun</div>
                            <div class="tutor-stars">★★★★★ <span style="color:var(--muted);font-size:11px;">4.9 (128
                                    ulasan)</span></div>
                            <div class="tutor-tags">
                                <span class="tutor-tag" style="background:#eff6ff;color:var(--primary);">Kalkulus</span>
                                <span class="tutor-tag"
                                    style="background:var(--success-soft);color:var(--success);">Aljabar</span>
                                <span class="tutor-tag" style="background:var(--accent-soft);color:var(--warning);">TKA
                                    UTBK</span>
                            </div>
                        </div>
                        <div class="tutor-price">
                            <div class="tp-val">Rp 75rb</div>
                            <div class="tp-label">/ sesi</div>
                            <span class="tp-avail" style="background:var(--success-soft);color:var(--success);">●
                                Tersedia</span>
                        </div>
                    </div>

                    <div class="tutor-card" onclick="selectTutor(this)">
                        <div class="tutor-av" style="background:var(--success);">SD</div>
                        <div>
                            <div class="tutor-name">Bu Sari Dewi, M.Si</div>
                            <div class="tutor-mapel"><i class="bi bi-mortarboard-fill me-1"></i> Fisika, Kimia · 8 Tahun
                            </div>
                            <div class="tutor-stars">★★★★★ <span style="color:var(--muted);font-size:11px;">4.8 (97
                                    ulasan)</span></div>
                            <div class="tutor-tags">
                                <span class="tutor-tag"
                                    style="background:var(--info-soft);color:var(--info);">Termodinamika</span>
                                <span class="tutor-tag" style="background:#eff6ff;color:var(--primary);">Optika</span>
                            </div>
                        </div>
                        <div class="tutor-price">
                            <div class="tp-val">Rp 90rb</div>
                            <div class="tp-label">/ sesi</div>
                            <span class="tp-avail" style="background:var(--success-soft);color:var(--success);">●
                                Tersedia</span>
                        </div>
                    </div>

                    <div class="tutor-card" onclick="selectTutor(this)">
                        <div class="tutor-av" style="background:var(--warning);">RH</div>
                        <div>
                            <div class="tutor-name">Pak Rizal Hakim, S.Si</div>
                            <div class="tutor-mapel"><i class="bi bi-mortarboard-fill me-1"></i> Kimia · 4 Tahun</div>
                            <div class="tutor-stars">★★★★☆ <span style="color:var(--muted);font-size:11px;">4.6 (54
                                    ulasan)</span></div>
                            <div class="tutor-tags">
                                <span class="tutor-tag" style="background:var(--accent-soft);color:var(--warning);">Laju
                                    Reaksi</span>
                                <span class="tutor-tag"
                                    style="background:var(--success-soft);color:var(--success);">Stoikiometri</span>
                            </div>
                        </div>
                        <div class="tutor-price">
                            <div class="tp-val">Rp 75rb</div>
                            <div class="tp-label">/ sesi</div>
                            <span class="tp-avail" style="background:var(--accent-soft);color:var(--warning);">● Sibuk
                                Hari Ini</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn fw-bold px-4 py-2"
                            style="background:var(--bg);color:var(--muted);border-radius:12px;border:none;"
                            onclick="goStep(1)">
                            <i class="bi bi-chevron-left me-1"></i> Kembali
                        </button>
                        <button class="btn fw-bold px-5 py-2"
                            style="background:var(--primary);color:#fff;border-radius:12px;border:none;"
                            onclick="goStep(3)">
                            Lanjut Atur Jadwal <i class="bi bi-chevron-right ms-1"></i>
                        </button>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-title">📋 Ringkasan Pesanan</div>
                        <div class="summary-row"><span class="sr-label">Layanan</span><span class="sr-val">Online
                                (Zoom/Meet)</span></div>
                        <div class="summary-row"><span class="sr-label">Tutor</span><span class="sr-val">Pak Budi
                                Santoso</span></div>
                        <div class="summary-row"><span class="sr-label">Jadwal</span><span class="sr-val"
                                style="color:var(--muted);">Belum dipilih</span></div>
                        <div class="summary-row"><span class="sr-label">Durasi</span><span class="sr-val">90 Menit</span>
                        </div>
                        <div class="summary-total">
                            <span class="st-label">Total</span>
                            <span class="st-val">Rp 75.000</span>
                        </div>
                        <div style="font-size:11.5px;color:var(--muted);margin-top:10px;text-align:center;">Pilih jadwal
                            untuk melanjutkan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 3: LOKASI & JADWAL --}}
        <div id="form-step3" style="display:none;">
            <div class="row g-3">
                <div class="col-lg-8">

                    {{-- LOKASI --}}
                    <div class="form-card mb-3">
                        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">📍 Input Lokasi Pembelajaran</div>

                        <div class="lokasi-option selected" onclick="selectLokasi(this)">
                            <input type="radio" name="lokasi" checked />
                            <div class="lokasi-icon" style="background:#eff6ff;color:var(--primary);"><i
                                    class="bi bi-camera-video-fill"></i></div>
                            <div>
                                <div class="lokasi-title">Online (Zoom / Google Meet)</div>
                                <div class="lokasi-sub">Link meeting dikirim via email & notifikasi</div>
                            </div>
                        </div>
                        <div class="lokasi-option" onclick="selectLokasi(this)">
                            <input type="radio" name="lokasi" />
                            <div class="lokasi-icon" style="background:var(--success-soft);color:var(--success);"><i
                                    class="bi bi-house-fill"></i></div>
                            <div>
                                <div class="lokasi-title">Rumah Saya</div>
                                <div class="lokasi-sub">Tutor datang ke alamat terdaftar</div>
                            </div>
                        </div>
                        <div class="lokasi-option" onclick="selectLokasi(this)">
                            <input type="radio" name="lokasi" />
                            <div class="lokasi-icon" style="background:var(--info-soft);color:var(--info);"><i
                                    class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <div class="lokasi-title">Alamat Lain</div>
                                <div class="lokasi-sub">Tentukan lokasi khusus untuk sesi ini</div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label-custom">Alamat Lengkap</label>
                            <input type="text" class="form-control-custom"
                                value="Jl. Veteran No. 12, Kediri, Jawa Timur" />
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <label class="form-label-custom">Kota / Kabupaten</label>
                                <input type="text" class="form-control-custom" value="Kediri" />
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">Provinsi</label>
                                <input type="text" class="form-control-custom" value="Jawa Timur" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label-custom">Catatan Tambahan (opsional)</label>
                            <textarea class="form-control-custom" rows="2" placeholder="Contoh: Rumah warna biru, pagar besi..."></textarea>
                        </div>
                    </div>

                    {{-- JADWAL --}}
                    <div class="form-card mb-3">
                        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">📅 Pilih Jadwal</div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label-custom">Bulan</label>
                                <select class="form-control-custom">
                                    <option>April 2026</option>
                                    <option>Mei 2026</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">Mata Pelajaran</label>
                                <select class="form-control-custom">
                                    <option selected>Matematika</option>
                                    <option>Fisika</option>
                                    <option>Kimia</option>
                                </select>
                            </div>
                        </div>

                        <label class="form-label-custom">Pilih Hari</label>
                        <div class="hari-tabs mb-3">
                            <div class="hari-tab" onclick="selectHari(this)">Sen<br><small>7 Apr</small></div>
                            <div class="hari-tab active" onclick="selectHari(this)">Sel<br><small>8 Apr</small></div>
                            <div class="hari-tab" onclick="selectHari(this)">Rab<br><small>9 Apr</small></div>
                            <div class="hari-tab" onclick="selectHari(this)">Kam<br><small>10 Apr</small></div>
                            <div class="hari-tab disabled">Jum<br><small>11 Apr</small></div>
                            <div class="hari-tab" onclick="selectHari(this)">Sab<br><small>12 Apr</small></div>
                            <div class="hari-tab disabled">Min<br><small>13 Apr</small></div>
                        </div>

                        <label class="form-label-custom">Pilih Waktu</label>
                        <div class="slot-grid">
                            <button class="slot-btn booked">07:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">08:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">09:00</button>
                            <button class="slot-btn booked">10:00</button>
                            <button class="slot-btn selected" onclick="selectSlot(this)">11:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">13:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">14:00</button>
                            <button class="slot-btn booked">15:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">16:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">17:00</button>
                            <button class="slot-btn booked">18:00</button>
                            <button class="slot-btn" onclick="selectSlot(this)">19:00</button>
                        </div>
                        <div class="d-flex gap-3 mt-2" style="font-size:11px;color:var(--muted);">
                            <span><span
                                    style="display:inline-block;width:10px;height:10px;background:var(--primary);border-radius:3px;"></span>
                                Dipilih</span>
                            <span><span
                                    style="display:inline-block;width:10px;height:10px;background:#f8fafc;border:1px solid #cbd5e1;border-radius:3px;"></span>
                                Terpesan</span>
                            <span><span
                                    style="display:inline-block;width:10px;height:10px;background:#fff;border:1px solid var(--border);border-radius:3px;"></span>
                                Tersedia</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button class="btn fw-bold px-4 py-2"
                            style="background:var(--bg);color:var(--muted);border-radius:12px;border:none;"
                            onclick="goStep(2)">
                            <i class="bi bi-chevron-left me-1"></i> Kembali
                        </button>
                        <button class="btn fw-bold px-5 py-2"
                            style="background:var(--primary);color:#fff;border-radius:12px;border:none;"
                            onclick="goStep(4)">
                            Lanjut Konfirmasi <i class="bi bi-chevron-right ms-1"></i>
                        </button>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-title">📋 Ringkasan Pesanan</div>
                        <div class="summary-row"><span class="sr-label">Layanan</span><span class="sr-val">Online
                                (Zoom/Meet)</span></div>
                        <div class="summary-row"><span class="sr-label">Tutor</span><span class="sr-val">Pak Budi
                                Santoso</span></div>
                        <div class="summary-row"><span class="sr-label">Mapel</span><span
                                class="sr-val">Matematika</span></div>
                        <div class="summary-row"><span class="sr-label">Jadwal</span><span class="sr-val">Selasa, 8 Apr ·
                                11:00</span></div>
                        <div class="summary-row"><span class="sr-label">Durasi</span><span class="sr-val">90 Menit</span>
                        </div>
                        <div class="summary-total">
                            <span class="st-label">Total</span>
                            <span class="st-val">Rp 75.000</span>
                        </div>
                        <div
                            style="font-size:11.5px;color:var(--muted);margin-top:10px;background:var(--success-soft);border-radius:8px;padding:8px 10px;border-left:3px solid var(--success);">
                            <i class="bi bi-shield-check me-1" style="color:var(--success);"></i> Pembayaran aman &
                            terlindungi
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 4: KONFIRMASI --}}
        <div id="form-step4" style="display:none;">
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="form-card mb-3">
                        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">✅ Konfirmasi Pesanan</div>

                        <div style="background:var(--bg);border-radius:12px;padding:16px;margin-bottom:16px;">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    style="width:52px;height:52px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;color:#fff;flex-shrink:0;">
                                    BS</div>
                                <div>
                                    <div style="font-size:14px;font-weight:800;color:var(--text);">Pak Budi Santoso, S.Pd
                                    </div>
                                    <div style="font-size:12px;color:var(--muted);">Tutor Matematika · ★4.9 · 6 Tahun</div>
                                </div>
                                <span class="ms-auto pill p-success" style="font-size:11px;">● Konfirmasi Otomatis</span>
                            </div>
                        </div>

                        <div style="border:1px solid var(--border);border-radius:12px;overflow:hidden;">
                            <div
                                style="background:var(--bg);padding:10px 16px;font-size:12px;font-weight:700;color:var(--muted);">
                                DETAIL PEMESANAN</div>
                            <div class="summary-row"
                                style="padding:10px 16px;border-bottom:1px solid var(--border);margin:0;"><span
                                    class="sr-label">Jenis Layanan</span><span class="sr-val fw-bold">Online
                                    (Zoom/Meet)</span></div>
                            <div class="summary-row"
                                style="padding:10px 16px;border-bottom:1px solid var(--border);margin:0;"><span
                                    class="sr-label">Mata Pelajaran</span><span class="sr-val fw-bold">Matematika</span>
                            </div>
                            <div class="summary-row"
                                style="padding:10px 16px;border-bottom:1px solid var(--border);margin:0;"><span
                                    class="sr-label">Jadwal</span><span class="sr-val fw-bold">Selasa, 8 Apr 2026 · 11:00
                                    WIB</span></div>
                            <div class="summary-row"
                                style="padding:10px 16px;border-bottom:1px solid var(--border);margin:0;"><span
                                    class="sr-label">Durasi</span><span class="sr-val fw-bold">90 Menit</span></div>
                            <div class="summary-row" style="padding:10px 16px;margin:0;"><span
                                    class="sr-label">Lokasi</span><span class="sr-val fw-bold">Online — Link dikirim via
                                    email</span></div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label-custom">Metode Pembayaran</label>
                            <select class="form-control-custom mb-2">
                                <option>Transfer Bank (BCA, Mandiri, BNI)</option>
                                <option>QRIS / Scan Barcode</option>
                                <option>GoPay / OVO / Dana</option>
                                <option>Saldo Al Ilmi Center (Rp 150.000)</option>
                            </select>
                        </div>

                        <div class="mt-2 p-3 rounded-3"
                            style="background:var(--accent-soft);border:1px solid var(--accent);">
                            <div style="font-size:12.5px;color:var(--warning);">
                                <i class="bi bi-clock-fill me-1"></i>
                                <strong>Penting:</strong> Pembayaran harus diselesaikan dalam <strong>2 jam</strong>.
                                Pesanan otomatis dibatalkan jika melewati batas waktu.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button class="btn fw-bold px-4 py-2"
                                style="background:var(--bg);color:var(--muted);border-radius:12px;border:none;"
                                onclick="goStep(3)">
                                <i class="bi bi-chevron-left me-1"></i> Kembali
                            </button>
                            <button class="btn fw-bold px-5 py-2"
                                style="background:var(--success);color:#fff;border-radius:12px;border:none;box-shadow:0 4px 12px rgba(22,163,74,.3);"
                                onclick="showModal()">
                                <i class="bi bi-check-circle-fill me-1"></i> Konfirmasi & Bayar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-title">💳 Rincian Pembayaran</div>
                        <div class="summary-row"><span class="sr-label">Biaya Sesi</span><span class="sr-val">Rp
                                75.000</span></div>
                        <div class="summary-row"><span class="sr-label">Biaya Layanan</span><span class="sr-val">Rp
                                2.000</span></div>
                        <div class="summary-row"><span class="sr-label">Diskon Member</span><span class="sr-val"
                                style="color:var(--success);">– Rp 2.000</span></div>
                        <div class="summary-total">
                            <span class="st-label">Total Bayar</span>
                            <span class="st-val">Rp 75.000</span>
                        </div>
                        <div
                            style="font-size:11.5px;color:var(--muted);margin-top:10px;background:var(--success-soft);border-radius:8px;padding:8px 10px;border-left:3px solid var(--success);">
                            <i class="bi bi-shield-check me-1" style="color:var(--success);"></i> Diproses aman dengan
                            enkripsi SSL
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /panel-pesan --}}

    {{-- ══════ TAB: STATUS PEMESANAN ══════ --}}
    <div id="panel-status" style="display:none;">

        <div class="d-flex gap-2 mb-3 flex-wrap">
            <div style="position:relative;flex:1;min-width:200px;">
                <i class="bi bi-search"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);"></i>
                <input type="text" class="form-control-custom" style="padding-left:36px;"
                    placeholder="Cari pesanan…" />
            </div>
            <select class="form-control-custom" style="width:auto;">
                <option>Semua Status</option>
                <option>Menunggu Konfirmasi</option>
                <option>Dikonfirmasi</option>
                <option>Selesai</option>
                <option>Dibatalkan</option>
            </select>
        </div>

        {{-- PESANAN AKTIF --}}
        <div style="font-size:15px;font-weight:700;margin-bottom:14px;">🟢 Pesanan Aktif</div>

        <div class="order-card">
            <div class="order-header">
                <span class="order-id">#AI-2026-0412</span>
                <span class="pill p-success" style="font-size:11px;"><i class="bi bi-check-circle-fill"></i>
                    Dikonfirmasi</span>
            </div>
            <div class="order-body">
                <div class="order-av" style="background:var(--primary);">BS</div>
                <div class="order-info">
                    <div class="oi-subj">Matematika – Integral</div>
                    <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i> Pak Budi Santoso</div>
                    <div class="oi-sched"><i class="bi bi-calendar3 me-1"></i> Selasa, 8 April 2026 · 11:00 WIB · Online
                    </div>
                </div>
                <div class="order-action">
                    <button class="btn-action" style="background:#eff6ff;color:var(--primary);">Detail</button>
                    <button class="btn-action" style="background:var(--primary);color:#fff;">Masuk Sesi</button>
                </div>
            </div>
            <div class="mt-3 pt-3" style="border-top:1px solid var(--border);">
                <div class="status-timeline">
                    <div class="timeline-item">
                        <div class="tl-dot done"><i class="bi bi-check-lg" style="font-size:10px;"></i></div>
                        <div class="tl-title">Pesanan Dibuat</div>
                        <div class="tl-time">Minggu, 6 Apr · 14:23</div>
                    </div>
                    <div class="timeline-item">
                        <div class="tl-dot done"><i class="bi bi-check-lg" style="font-size:10px;"></i></div>
                        <div class="tl-title">Pembayaran Berhasil</div>
                        <div class="tl-time">Minggu, 6 Apr · 14:45</div>
                    </div>
                    <div class="timeline-item">
                        <div class="tl-dot done"><i class="bi bi-check-lg" style="font-size:10px;"></i></div>
                        <div class="tl-title">Tutor Mengonfirmasi</div>
                        <div class="tl-time">Minggu, 6 Apr · 15:10</div>
                    </div>
                    <div class="timeline-item">
                        <div class="tl-dot active"><i class="bi bi-clock-fill" style="font-size:10px;"></i></div>
                        <div class="tl-title">Menunggu Sesi Dimulai</div>
                        <div class="tl-desc">Sesi dimulai Selasa, 8 April · 11:00 WIB</div>
                    </div>
                    <div class="timeline-item">
                        <div class="tl-dot pending">5</div>
                        <div class="tl-title" style="color:var(--muted);">Sesi Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-card" style="border-color:var(--accent);">
            <div class="order-header">
                <span class="order-id">#AI-2026-0415</span>
                <span class="pill p-warning" style="font-size:11px;"><i class="bi bi-hourglass-split"></i> Menunggu
                    Konfirmasi</span>
            </div>
            <div class="order-body">
                <div class="order-av" style="background:var(--success);">SD</div>
                <div class="order-info">
                    <div class="oi-subj">Fisika – Gelombang</div>
                    <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i> Bu Sari Dewi</div>
                    <div class="oi-sched"><i class="bi bi-calendar3 me-1"></i> Kamis, 10 April · 14:00 WIB · Tatap Muka
                    </div>
                </div>
                <div class="order-action">
                    <button class="btn-action" style="background:var(--accent-soft);color:var(--warning);">Detail</button>
                    <button class="btn-action"
                        style="background:var(--danger-soft);color:var(--danger);">Batalkan</button>
                </div>
            </div>
        </div>

        {{-- RIWAYAT --}}
        <div style="font-size:15px;font-weight:700;margin:24px 0 14px;">📁 Riwayat Pesanan</div>

        <div class="order-card" style="opacity:.8;">
            <div class="order-header">
                <span class="order-id">#AI-2026-0398</span>
                <span class="pill p-success" style="font-size:11px;"><i class="bi bi-check2-all"></i> Selesai</span>
            </div>
            <div class="order-body">
                <div class="order-av" style="background:var(--primary);">BS</div>
                <div class="order-info">
                    <div class="oi-subj">Matematika – Limit</div>
                    <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i> Pak Budi Santoso</div>
                    <div class="oi-sched"><i class="bi bi-calendar3 me-1"></i> Jumat, 28 Mar · 09:00 WIB · Online</div>
                </div>
                <div class="order-action">
                    <button class="btn-action" style="background:var(--bg);color:var(--muted);">Detail</button>
                    <button class="btn-action" style="background:#eff6ff;color:var(--primary);">Pesan Ulang</button>
                </div>
            </div>
        </div>

        <div class="order-card" style="opacity:.8;">
            <div class="order-header">
                <span class="order-id">#AI-2026-0371</span>
                <span class="pill p-danger" style="font-size:11px;"><i class="bi bi-x-circle-fill"></i> Dibatalkan</span>
            </div>
            <div class="order-body">
                <div class="order-av" style="background:var(--warning);">RH</div>
                <div class="order-info">
                    <div class="oi-subj">Kimia – Laju Reaksi</div>
                    <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i> Pak Rizal Hakim</div>
                    <div class="oi-sched"><i class="bi bi-calendar3 me-1"></i> Sabtu, 15 Mar · 13:00 WIB · Tatap Muka
                    </div>
                </div>
                <div class="order-action">
                    <button class="btn-action" style="background:var(--bg);color:var(--muted);">Detail</button>
                    <button class="btn-action" style="background:#eff6ff;color:var(--primary);">Pesan Ulang</button>
                </div>
            </div>
        </div>

    </div>{{-- /panel-status --}}

    {{-- MODAL SUKSES --}}
    <div class="modal-custom" id="modal-sukses">
        <div class="modal-box">
            <div style="font-size:52px;margin-bottom:14px;">🎉</div>
            <div style="font-size:18px;font-weight:800;margin-bottom:6px;color:var(--text);">Pesanan Berhasil Dibuat!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:22px;line-height:1.6;">
                Pesanan les privat dengan <strong>Pak Budi Santoso</strong> pada<br>
                <strong>Selasa, 8 April 2026 · 11:00 WIB</strong><br>
                telah dikonfirmasi. Selesaikan pembayaran dalam 2 jam.
            </div>
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn fw-bold px-4 py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:none;"
                    onclick="closeModal()">Tutup</button>
                <button class="btn fw-bold px-4 py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;"
                    onclick="closeModal();showTab('status');">Lihat Status</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function goStep(n) {
            [1, 2, 3, 4].forEach(i => {
                const el = document.getElementById('form-step' + i);
                if (el) el.style.display = 'none';
            });
            document.getElementById('form-step' + n).style.display = '';

            [1, 2, 3, 4].forEach(i => {
                const sc = document.getElementById('sc' + i);
                const sl = document.getElementById('sl' + i);
                const sd = document.getElementById('sd' + i);
                if (!sc) return;
                sc.className = 'step-circle ' + (i < n ? 'done' : i === n ? 'active' : 'pending');
                sl.className = 'step-label ' + (i < n ? 'done' : i === n ? 'active' : 'pending');
                sc.innerHTML = i < n ? '<i class="bi bi-check-lg"></i>' : i;
                if (sd) sd.className = 'step-divider ' + (i < n ? 'done' : '');
            });
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showTab(tab) {
            const isPesan = tab === 'pesan';
            document.getElementById('panel-pesan').style.display = isPesan ? '' : 'none';
            document.getElementById('panel-status').style.display = isPesan ? 'none' : '';
            document.getElementById('step-bar').style.display = isPesan ? '' : 'none';

            const tp = document.getElementById('tab-pesan');
            const ts = document.getElementById('tab-status');
            tp.style.background = isPesan ? 'var(--primary)' : '#fff';
            tp.style.color = isPesan ? '#fff' : 'var(--muted)';
            tp.style.border = isPesan ? 'none' : '1.5px solid var(--border)';
            ts.style.background = !isPesan ? 'var(--primary)' : '#fff';
            ts.style.color = !isPesan ? '#fff' : 'var(--muted)';
            ts.style.border = !isPesan ? 'none' : '1.5px solid var(--border)';
        }

        function selectLayanan(el) {
            document.querySelectorAll('.layanan-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        function selectTutor(el) {
            document.querySelectorAll('.tutor-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        function selectLokasi(el) {
            document.querySelectorAll('.lokasi-option').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            el.querySelector('input[type=radio]').checked = true;
        }

        function selectHari(el) {
            if (el.classList.contains('disabled')) return;
            document.querySelectorAll('.hari-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }

        function selectSlot(el) {
            if (el.classList.contains('booked')) return;
            document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
            el.classList.add('selected');
        }

        function showModal() {
            document.getElementById('modal-sukses').classList.add('show');
        }

        function closeModal() {
            document.getElementById('modal-sukses').classList.remove('show');
        }
    </script>
@endpush
