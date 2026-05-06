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
{{-- ALERT SUKSES --}}
@if(session('sukses'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
    <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:18px;"></i>
    <span style="font-size:13px;font-weight:600;color:var(--success);">{{ session('sukses') }}</span>
</div>
@endif

@if($errors->any())
<div style="background:var(--danger-soft);border:1px solid var(--danger);border-radius:12px;padding:12px 16px;margin-bottom:16px;">
    @foreach($errors->all() as $error)
    <div style="font-size:13px;color:var(--danger);"><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
    @endforeach
</div>
@endif
{{-- PAGE HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-1">
    <div>
        <h4 class="fw-bold mb-1">🎓 Les Privat</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Les Privat</span>
        </div>
    </div>
    <a href="/siswa/pesan-jadwal" class="btn btn-sm fw-bold px-3 py-2"
        style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;text-decoration:none;">
        <i class="bi bi-plus-lg me-1"></i> Pesan Les Baru
    </a>
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
                </div>

                {{-- TUTOR DARI DATABASE --}}
                @forelse($tutors as $tutor)
                <div class="tutor-card" onclick="selectTutor(this)"
                    data-id="{{ $tutor->id }}"
                    data-name="{{ $tutor->name }}">
                    <div class="tutor-av" style="background:var(--primary);">
                        {{ strtoupper(substr($tutor->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="tutor-name">{{ $tutor->name }}</div>
                        <div class="tutor-mapel">
                            <i class="bi bi-mortarboard-fill me-1"></i>
                            @php
                            $mapels = $tutor->materi()->distinct('mata_pelajaran')->pluck('mata_pelajaran')->join(', ');
                            @endphp
                            {{ $mapels ?: 'Semua Mata Pelajaran' }}
                        </div>
                        <div class="tutor-stars">★★★★★
                            <span style="color:var(--muted);font-size:11px;">4.8</span>
                        </div>
                    </div>
                    <div class="tutor-price">
                        <div class="tp-val">Rp 75rb</div>
                        <div class="tp-label">/ sesi</div>
                        <span class="tp-avail" style="background:var(--success-soft);color:var(--success);">● Tersedia</span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px;color:var(--muted);">
                    <i class="bi bi-people" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                    Belum ada tutor tersedia
                </div>
                @endforelse

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
                    <div class="summary-row"><span class="sr-label">Layanan</span><span class="sr-val" id="sum-layanan">-</span></div>
                    <div class="summary-row"><span class="sr-label">Tutor</span><span class="sr-val" id="sum-tutor">Belum dipilih</span></div>
                    <div class="summary-row"><span class="sr-label">Jadwal</span><span class="sr-val" style="color:var(--muted);">Belum dipilih</span></div>
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

    {{-- STEP 4: KONFIRMASI + FORM SUBMIT --}}
    <div id="form-step4" style="display:none;">
        <form action="/siswa/les-privat/pesan" method="POST">
            @csrf

            {{-- Hidden fields diisi JS --}}
            <input type="hidden" name="tutor_id" id="input-tutor-id" />
            <input type="hidden" name="mode" id="input-mode" value="online" />
            <input type="hidden" name="durasi_menit" id="input-durasi" value="90" />

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="form-card mb-3">
                        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">✅ Konfirmasi Pesanan</div>

                        {{-- Detail ringkasan --}}
                        <div style="background:var(--bg);border-radius:12px;padding:16px;margin-bottom:16px;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:52px;height:52px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;color:#fff;flex-shrink:0;" id="konfirm-avatar">?</div>
                                <div>
                                    <div style="font-size:14px;font-weight:800;color:var(--text);" id="konfirm-tutor-nama">-</div>
                                    <div style="font-size:12px;color:var(--muted);">Tutor Al Ilmi Center</div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex flex-column gap-2">
                                <div style="display:flex;justify-content:space-between;font-size:13px;padding:6px 0;border-bottom:1px solid var(--border);">
                                    <span style="color:var(--muted);">Mata Pelajaran</span>
                                    <span id="konfirm-mapel" style="font-weight:600;">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:13px;padding:6px 0;border-bottom:1px solid var(--border);">
                                    <span style="color:var(--muted);">Jadwal</span>
                                    <span id="konfirm-jadwal" style="font-weight:600;">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:13px;padding:6px 0;border-bottom:1px solid var(--border);">
                                    <span style="color:var(--muted);">Durasi</span>
                                    <span id="konfirm-durasi" style="font-weight:600;">90 Menit</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:13px;padding:6px 0;">
                                    <span style="color:var(--muted);">Mode</span>
                                    <span id="konfirm-mode" style="font-weight:600;">-</span>
                                </div>
                            </div>
                        </div>

                        {{-- Form detail --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="mata_pelajaran" class="form-control-custom" id="sel-mapel" onchange="updateKonfirm()">
                                    <option value="">-- Pilih --</option>
                                    <option>Matematika</option>
                                    <option>Fisika</option>
                                    <option>Kimia</option>
                                    <option>Biologi</option>
                                    <option>Bahasa Inggris</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Topik yang Dipelajari</label>
                                <input type="text" name="topik" class="form-control-custom" placeholder="Contoh: Integral, Trigonometri…" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Tanggal & Waktu <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="jadwal" id="input-jadwal" class="form-control-custom"
                                    min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                                    onchange="updateKonfirm()" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Durasi</label>
                                <select name="durasi_menit" class="form-control-custom" id="sel-durasi" onchange="updateDurasi()">
                                    <option value="60">60 Menit — Rp 50.000</option>
                                    <option value="90" selected>90 Menit — Rp 75.000</option>
                                    <option value="120">120 Menit — Rp 100.000</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Mode Belajar</label>
                                <select name="mode" class="form-control-custom" id="sel-mode" onchange="updateMode()">
                                    <option value="online">Online (Zoom/Meet)</option>
                                    <option value="tatap_muka">Tatap Muka</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="lokasi-wrap" style="display:none;">
                                <label class="form-label-custom">Alamat Lokasi</label>
                                <input type="text" name="lokasi" class="form-control-custom" placeholder="Jl. Merdeka No.1, Kediri" />
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Catatan untuk Tutor</label>
                                <textarea name="catatan" class="form-control-custom" rows="2" placeholder="Jelaskan kesulitan atau materi yang ingin difokuskan…"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn fw-bold px-4 py-2"
                                style="background:var(--bg);color:var(--muted);border-radius:12px;border:none;"
                                onclick="goStep(3)">
                                <i class="bi bi-chevron-left me-1"></i> Kembali
                            </button>
                            <button type="submit" class="btn fw-bold px-5 py-2"
                                style="background:var(--success);color:#fff;border-radius:12px;border:none;box-shadow:0 4px 12px rgba(22,163,74,.3);">
                                <i class="bi bi-check-circle-fill me-1"></i> Kirim Pesanan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-title">💳 Rincian Biaya</div>
                        <div class="summary-row"><span class="sr-label">Biaya Sesi</span><span class="sr-val" id="biaya-sesi">Rp 75.000</span></div>
                        <div class="summary-row"><span class="sr-label">Biaya Admin</span><span class="sr-val">Rp 2.000</span></div>
                        <div class="summary-row"><span class="sr-label">Diskon Member</span><span class="sr-val" style="color:var(--success);">– Rp 2.000</span></div>
                        <div class="summary-total">
                            <span class="st-label">Total Bayar</span>
                            <span class="st-val" id="biaya-total">Rp 75.000</span>
                        </div>
                        <div style="font-size:11.5px;color:var(--muted);margin-top:10px;background:var(--success-soft);border-radius:8px;padding:8px 10px;border-left:3px solid var(--success);">
                            <i class="bi bi-shield-check me-1" style="color:var(--success);"></i>
                            Pesanan akan dikonfirmasi tutor dalam 1x24 jam
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>{{-- /panel-pesan --}}

{{-- ══════ TAB: STATUS PEMESANAN ══════ --}}
{{-- ══════ TAB: STATUS PEMESANAN ══════ --}}
<div id="panel-status" style="display:none;">

    {{-- PESANAN AKTIF --}}
    <div style="font-size:15px;font-weight:700;margin-bottom:14px;">🟢 Pesanan Aktif</div>

    @forelse($pesananAktif as $p)
    <div class="order-card" style="{{ $p->status === 'menunggu' ? 'border-color:var(--accent);' : '' }}">
        <div class="order-header">
            <span class="order-id">#{{ strtoupper(substr($p->id, 0, 8)) }}</span>
            @if($p->status === 'menunggu')
            <span class="pill p-warning" style="font-size:11px;"><i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi</span>
            @elseif($p->status === 'dikonfirmasi')
            <span class="pill p-success" style="font-size:11px;"><i class="bi bi-check-circle-fill"></i> Dikonfirmasi</span>
            @endif
        </div>
        <div class="order-body">
            <div class="order-av" style="background:var(--primary);">
                {{ strtoupper(substr($p->tutor->name ?? 'T', 0, 2)) }}
            </div>
            <div class="order-info">
                <div class="oi-subj">{{ $p->mata_pelajaran }}{{ $p->topik ? ' – '.$p->topik : '' }}</div>
                <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i> {{ $p->tutor->name ?? '-' }}</div>
                <div class="oi-sched">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $p->jadwal->translatedFormat('l, d M Y · H:i') }} WIB
                    · {{ $p->getModeLabel() }}
                    · {{ $p->durasi_menit }} mnt
                </div>
                @if($p->status === 'dikonfirmasi' && $p->link_meeting)
                <div class="mt-1">
                    <a href="{{ $p->link_meeting }}" target="_blank"
                        style="font-size:12px;color:var(--primary);font-weight:600;">
                        <i class="bi bi-camera-video-fill me-1"></i> Masuk ke Meeting Room
                    </a>
                </div>
                @endif
            </div>
            <div class="order-action">
                <div style="text-align:right;">
                    <div style="font-size:14px;font-weight:800;color:var(--primary);">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                    <div style="font-size:11px;color:var(--muted);">{{ $p->pembayaran_status === 'lunas' ? '✅ Lunas' : '⏳ Belum Bayar' }}</div>
                </div>
                @if($p->status === 'menunggu')
                <form method="POST" action="/siswa/les-privat/{{ $p->id }}/batalkan"
                    onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf
                    <button type="submit" class="btn-action"
                        style="background:var(--danger-soft);color:var(--danger);margin-top:6px;">Batalkan</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Timeline status --}}
        <div class="mt-3 pt-3" style="border-top:1px solid var(--border);">
            <div class="status-timeline">
                <div class="timeline-item">
                    <div class="tl-dot done"><i class="bi bi-check-lg" style="font-size:10px;"></i></div>
                    <div class="tl-title">Pesanan Dikirim</div>
                    <div class="tl-time">{{ $p->created_at->translatedFormat('d M Y · H:i') }}</div>
                </div>
                <div class="timeline-item">
                    <div class="tl-dot {{ $p->status !== 'menunggu' ? 'done' : 'active' }}">
                        @if($p->status !== 'menunggu')
                        <i class="bi bi-check-lg" style="font-size:10px;"></i>
                        @else
                        <i class="bi bi-clock-fill" style="font-size:10px;"></i>
                        @endif
                    </div>
                    <div class="tl-title" style="{{ $p->status === 'menunggu' ? 'color:var(--warning);' : '' }}">
                        {{ $p->status === 'menunggu' ? 'Menunggu Konfirmasi Tutor' : 'Tutor Mengonfirmasi' }}
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="tl-dot {{ $p->status === 'dikonfirmasi' ? 'active' : 'pending' }}">
                        {{ $p->status === 'dikonfirmasi' ? '' : '3' }}
                        @if($p->status === 'dikonfirmasi')
                        <i class="bi bi-clock-fill" style="font-size:10px;"></i>
                        @endif
                    </div>
                    <div class="tl-title" style="color:var(--muted);">Menunggu Sesi Dimulai</div>
                    @if($p->status === 'dikonfirmasi')
                    <div class="tl-desc">{{ $p->jadwal->translatedFormat('l, d M · H:i') }} WIB</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:40px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
        <i class="bi bi-calendar-x" style="font-size:2.5rem;margin-bottom:10px;display:block;"></i>
        Belum ada pesanan aktif.
        <div style="margin-top:10px;">
            <button onclick="showTab('pesan')" style="background:var(--primary);color:#fff;border:none;border-radius:10px;padding:8px 20px;font-size:13px;font-weight:700;cursor:pointer;">
                Pesan Les Sekarang
            </button>
        </div>
    </div>
    @endforelse

    {{-- RIWAYAT --}}
    @if($riwayat->count() > 0)
    <div style="font-size:15px;font-weight:700;margin:24px 0 14px;">📁 Riwayat Pesanan</div>

    @foreach($riwayat as $r)
    <div class="order-card" style="opacity:.85;">
        <div class="order-header">
            <span class="order-id">#{{ strtoupper(substr($r->id, 0, 8)) }}</span>
            @if($r->status === 'selesai')
            <span class="pill p-success" style="font-size:11px;"><i class="bi bi-check2-all"></i> Selesai</span>
            @else
            <span class="pill p-danger" style="font-size:11px;"><i class="bi bi-x-circle-fill"></i> Dibatalkan</span>
            @endif
        </div>
        <div class="order-body">
            <div class="order-av" style="background:{{ $r->status === 'selesai' ? 'var(--success)' : 'var(--muted)' }};">
                {{ strtoupper(substr($r->tutor->name ?? 'T', 0, 2)) }}
            </div>
            <div class="order-info">
                <div class="oi-subj">{{ $r->mata_pelajaran }}{{ $r->topik ? ' – '.$r->topik : '' }}</div>
                <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i> {{ $r->tutor->name ?? '-' }}</div>
                <div class="oi-sched">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $r->jadwal->translatedFormat('d M Y · H:i') }} WIB
                    · {{ $r->getModeLabel() }}
                </div>
            </div>
            <div class="order-action">
                <div style="font-size:14px;font-weight:800;color:var(--muted);">Rp {{ number_format($r->harga, 0, ',', '.') }}</div>
                @if($r->status === 'selesai')
                <button onclick="showTab('pesan')"
                    class="btn-action" style="background:#eff6ff;color:var(--primary);margin-top:6px;">Pesan Ulang</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

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

    // Tambahkan fungsi ini ke script yang sudah ada
    function selectTutor(el) {
        document.querySelectorAll('.tutor-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        // Simpan data tutor ke hidden input
        document.getElementById('input-tutor-id').value = el.dataset.id;
        document.getElementById('sum-tutor').textContent = el.dataset.name;
        document.getElementById('konfirm-tutor-nama').textContent = el.dataset.name;
        document.getElementById('konfirm-avatar').textContent = el.dataset.name.substring(0, 2).toUpperCase();
    }

    function updateKonfirm() {
        const mapel = document.getElementById('sel-mapel')?.value;
        const jadwal = document.getElementById('input-jadwal')?.value;
        if (mapel) document.getElementById('konfirm-mapel').textContent = mapel;
        if (jadwal) {
            const d = new Date(jadwal);
            document.getElementById('konfirm-jadwal').textContent =
                d.toLocaleString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) + ' WIB';
        }
    }

    function updateDurasi() {
        const dur = document.getElementById('sel-durasi').value;
        const harga = dur == 60 ? 50000 : dur == 90 ? 75000 : 100000;
        document.getElementById('konfirm-durasi').textContent = dur + ' Menit';
        document.getElementById('biaya-sesi').textContent = 'Rp ' + harga.toLocaleString('id-ID');
        document.getElementById('biaya-total').textContent = 'Rp ' + harga.toLocaleString('id-ID');
        document.getElementById('input-durasi').value = dur;
    }

    function updateMode() {
        const mode = document.getElementById('sel-mode').value;
        document.getElementById('konfirm-mode').textContent = mode === 'online' ? 'Online (Zoom/Meet)' : 'Tatap Muka';
        document.getElementById('lokasi-wrap').style.display = mode === 'tatap_muka' ? '' : 'none';
        document.getElementById('input-mode').value = mode;
    }
</script>
@endpush