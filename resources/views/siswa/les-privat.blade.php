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
    /* ── MAIN TABS ── */
    .main-tabs {
        display: flex;
        gap: 6px;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 5px;
        margin-bottom: 24px;
    }

    .main-tab {
        flex: 1;
        text-align: center;
        padding: 9px 8px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        color: var(--muted);
        border: none;
        background: transparent;
    }

    .main-tab.active {
        background: var(--primary);
        color: #fff;
    }

    .main-tab:hover:not(.active) {
        background: var(--bg);
        color: var(--primary);
    }

    /* ── STEP BAR ── */
    .step-bar {
        display: flex;
        align-items: center;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 14px 24px;
        margin-bottom: 28px;
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

    /* ── JENJANG SELECTOR ── */
    .jenjang-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .jenjang-card {
        background: var(--card-bg);
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 22px 16px;
        text-align: center;
        cursor: pointer;
        transition: all .25s;
    }

    .jenjang-card:hover {
        border-color: var(--primary-light);
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(30, 58, 95, .1);
    }

    .jenjang-card.selected {
        border-color: var(--primary);
        background: #eff6ff;
        box-shadow: 0 6px 22px rgba(30, 58, 95, .18);
    }

    .jenjang-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .jenjang-name {
        font-size: 18px;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 4px;
    }

    .jenjang-sub {
        font-size: 12px;
        color: var(--muted);
    }

    .jenjang-harga {
        font-size: 16px;
        font-weight: 800;
        margin-top: 8px;
    }

    /* ── PAKET DETAIL CARD ── */
    .paket-detail {
        background: var(--card-bg);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 20px;
        display: none;
    }

    .paket-detail.show {
        display: block;
    }

    .paket-fitur li {
        font-size: 13px;
        padding: 6px 0;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--text);
        border-bottom: 1px solid #f1f5f9;
    }

    .paket-fitur li:last-child {
        border-bottom: none;
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

    /* ── FORM ── */
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

    /* ── SLOT ── */
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

    .oi-tutor,
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

    /* ── TIMELINE ── */
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

    /* ── PILL ── */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .p-success {
        background: var(--success-soft);
        color: var(--success);
    }

    .p-warning {
        background: var(--warning-soft);
        color: var(--warning);
    }

    .p-danger {
        background: var(--danger-soft);
        color: var(--danger);
    }

    .p-info {
        background: var(--info-soft);
        color: var(--info);
    }

    /* ── MODAL ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .55);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 480px;
        max-height: 92vh;
        overflow-y: auto;
        animation: fadeUp .25s ease;
    }

    @keyframes fadeUp {
        from {
            transform: translateY(20px);
            opacity: 0
        }

        to {
            transform: translateY(0);
            opacity: 1
        }
    }

    .modal-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
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
        color: var(--text);
    }

    .modal-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: var(--bg);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: var(--muted);
    }

    /* ── RESPONSIVE ── */
    @media(max-width:991px) {
        .jenjang-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .summary-card {
            position: static;
        }
    }

    @media(max-width:767px) {
        .main-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .main-tab {
            min-width: 90px;
            flex: none;
            font-size: 12px;
        }

        .step-bar {
            padding: 12px 14px;
        }

        .step-label {
            font-size: 10px;
        }

        .jenjang-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .jenjang-card {
            padding: 14px 8px;
        }

        .jenjang-icon {
            font-size: 28px;
        }

        .jenjang-name {
            font-size: 14px;
        }

        .jenjang-sub {
            font-size: 10px;
        }

        .slot-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }

        .tutor-card {
            flex-wrap: wrap;
        }

        .tutor-price {
            margin-left: 0 !important;
            text-align: left !important;
            width: 100%;
        }

        .order-body {
            flex-wrap: wrap;
        }

        .order-action {
            width: 100%;
            flex-wrap: wrap;
        }

        .form-card {
            padding: 16px !important;
        }

        .summary-card {
            padding: 16px !important;
        }
    }

    @media(max-width:480px) {
        .step-label {
            display: none;
        }

        .slot-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .jenjang-harga {
            font-size: 13px;
        }
    }
</style>
@endpush

@section('content')

{{-- ALERT --}}
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

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-1 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">🎓 Les Privat</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Les Privat</span>
        </div>
    </div>
</div>

{{-- STEP BAR (hanya tampil di tab pesan) --}}
<div id="step-bar" class="step-bar">
    <div class="step-item">
        <div class="step-circle active" id="sc1">1</div>
        <div class="step-label active" id="sl1">Pilih Paket</div>
    </div>
    <div class="step-divider" id="sd1"></div>
    <div class="step-item">
        <div class="step-circle pending" id="sc2">2</div>
        <div class="step-label pending" id="sl2">Pilih Tutor</div>
    </div>
    <div class="step-divider" id="sd2"></div>
    <div class="step-item">
        <div class="step-circle pending" id="sc3">3</div>
        <div class="step-label pending" id="sl3">Jadwal & Lokasi</div>
    </div>
    <div class="step-divider" id="sd3"></div>
    <div class="step-item">
        <div class="step-circle pending" id="sc4">4</div>
        <div class="step-label pending" id="sl4">Konfirmasi</div>
    </div>
</div>

{{-- MAIN TABS --}}
<div class="main-tabs">
    <button class="main-tab active" id="tab-pesan" onclick="showMainTab('pesan')">
        <i class="bi bi-plus-circle me-1"></i> Pesan Les
    </button>
    <button class="main-tab" id="tab-status" onclick="showMainTab('status')">
        <i class="bi bi-list-check me-1"></i> Status Pesanan
        @if(isset($pesananAktif) && $pesananAktif->count() > 0)
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">{{ $pesananAktif->count() }}</span>
        @endif
    </button>
</div>

{{-- ══════════════════════════════════════
     TAB PESAN LES
══════════════════════════════════════ --}}
<div id="panel-pesan">

    {{-- ── STEP 1: PILIH PAKET ── --}}
    <div id="form-step1">
        <div style="text-align:center;margin-bottom:24px;">
            <div style="font-size:19px;font-weight:800;color:var(--text);">📦 Pilih Paket Les Privat</div>
            <div style="font-size:13px;color:var(--muted);margin-top:4px;">Pilih jenjang pendidikanmu untuk melihat paket yang tersedia</div>
        </div>

        {{-- JENJANG CARDS --}}
        <div class="jenjang-grid">
            @php
            $meta = [
            'sd' => ['emoji'=>'📚','name'=>'SD', 'sub'=>'Kelas 1–6', 'durasi'=>'60 mnt/sesi','warna'=>'var(--success)'],
            'smp' => ['emoji'=>'🎒','name'=>'SMP','sub'=>'Kelas 7–9', 'durasi'=>'75 mnt/sesi','warna'=>'var(--primary)'],
            'sma' => ['emoji'=>'🏆','name'=>'SMA','sub'=>'Kelas 10–12', 'durasi'=>'90 mnt/sesi','warna'=>'#8B5CF6'],
            ];
            @endphp
            @foreach($meta as $key => $m)
            @php $group = $pakets->get($key) ?? collect(); $p = $group->isNotEmpty() ? $group->first() : null; @endphp
            <div class="jenjang-card" onclick="selectJenjang('{{ $key }}')" id="jcard-{{ $key }}">
                <div class="jenjang-icon">{{ $m['emoji'] }}</div>
                <div class="jenjang-name">{{ $m['name'] }}</div>
                <div class="jenjang-sub">{{ $m['sub'] }}</div>
                <div class="jenjang-harga" style="color:{{ $m['warna'] }};">
                    {{ $p ? 'Rp '.number_format($p->harga_min,0,',','.') : 'Hubungi Admin' }}
                </div>
                <div style="font-size:11px;color:var(--muted);margin-top:2px;">{{ $m['durasi'] }}</div>
                @if($group && $group->count() > 1)
                <div style="font-size:10.5px;font-weight:700;margin-top:4px;color:{{ $m['warna'] }};">{{ $group->count() }} pilihan paket</div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- PAKET DETAIL per jenjang --}}
        @foreach($meta as $key => $m)
        @php $group = $pakets->get($key) ?? collect(); @endphp
        <div class="paket-detail" id="paket-detail-{{ $key }}">
            <div style="font-size:16px;font-weight:800;color:var(--text);margin-bottom:16px;">
                {{ $m['emoji'] }} Pilih Paket {{ $m['name'] }}
            </div>

            {{-- Loop semua paket dalam tipe ini --}}
            @foreach($group as $pidx => $p)
            <div class="paket-option-card" id="pocard-{{ $key }}-{{ $pidx }}"
                onclick="selectPaketOption('{{ $key }}','{{ $pidx }}','{{ $p->id }}','{{ addslashes($p->nama) }}','Rp {{ number_format($p->harga_min,0,',','.') }}',{{ $p->harga_min }},{{ $p->jumlah_les ?? 0 }},{{ $p->jumlah_soal ?? 0 }})"
                style="border:2px solid var(--border);border-radius:14px;padding:16px;margin-bottom:10px;cursor:pointer;transition:all .2s;display:flex;align-items:flex-start;gap:14px;">
                <div style="width:18px;height:18px;border-radius:50%;border:2px solid var(--border);flex-shrink:0;margin-top:3px;display:flex;align-items:center;justify-content:center;" id="radio-{{ $key }}-{{ $pidx }}"></div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:800;color:var(--text);">{{ $p->nama }}</div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:8px;">{{ $m['sub'] }} · {{ $m['durasi'] }}</div>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @if($p->jumlah_les)
                        <span style="font-size:11.5px;background:var(--success-soft);color:var(--success);padding:2px 8px;border-radius:6px;font-weight:600;">✓ {{ $p->jumlah_les }} Sesi Les</span>
                        @endif
                        @if($p->jumlah_soal)
                        <span style="font-size:11.5px;background:#eff6ff;color:var(--primary);padding:2px 8px;border-radius:6px;font-weight:600;">✓ {{ $p->jumlah_soal }} Soal</span>
                        @endif
                        @if($p->feedback_tutor)
                        <span style="font-size:11.5px;background:var(--accent-soft);color:var(--warning);padding:2px 8px;border-radius:6px;font-weight:600;">✓ Feedback Tutor</span>
                        @endif
                        @if($p->akses_penuh)
                        <span style="font-size:11.5px;background:var(--info-soft);color:var(--info);padding:2px 8px;border-radius:6px;font-weight:600;">✓ Akses Penuh Materi</span>
                        @endif
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <div style="font-size:20px;font-weight:800;color:{{ $m['warna'] }};">Rp {{ number_format($p->harga_min,0,',','.') }}</div>
                    <div style="font-size:11px;color:var(--muted);">/ sesi</div>
                </div>
            </div>
            @endforeach

            <button
                onclick="lanjutDariPaket('{{ $key }}','{{ $m['name'] }}','{{ $m['warna'] }}')"
                style="width:100%;margin-top:8px;padding:13px;border-radius:12px;font-size:14px;font-weight:800;cursor:pointer;border:none;background:{{ $m['warna'] }};color:#fff;box-shadow:0 5px 16px rgba(0,0,0,.2);">
                <i class="bi bi-arrow-right-circle-fill me-2"></i>Lanjut Pilih Tutor →
            </button>
        </div>
        @endforeach

    </div>

    {{-- ── STEP 2: PILIH TUTOR ── --}}
    <div id="form-step2" style="display:none;">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px;">
                    <div style="font-size:15px;font-weight:700;">👨‍🏫 Pilih Tutor</div>
                    <div style="font-size:12px;color:var(--muted);">
                        Paket: <strong id="info-paket-step2">-</strong>
                    </div>
                </div>

                {{-- Tutor dari DB --}}
                @forelse($tutors as $tutor)
                <div class="tutor-card" onclick="selectTutor(this)"
                    data-id="{{ $tutor->id }}"
                    data-name="{{ $tutor->name }}">
                    <div class="tutor-av" style="background:var(--primary);">
                        {{ strtoupper(substr($tutor->name, 0, 2)) }}
                    </div>
                    <div style="flex:1;">
                        <div class="tutor-name">{{ $tutor->name }}</div>
                        <div class="tutor-mapel">
                            <i class="bi bi-mortarboard-fill me-1"></i>
                            {{ $tutor->mata_pelajaran_tutor ? implode(', ', array_slice($tutor->mata_pelajaran_tutor, 0, 3)) : 'Semua Mata Pelajaran' }}
                        </div>
                        <div class="tutor-stars">★★★★★ <span style="color:var(--muted);font-size:11px;">4.8 ({{ rand(20,80) }} ulasan)</span></div>
                        @if($tutor->jenjang_tutor)
                        <div style="font-size:11px;color:var(--muted);margin-top:2px;">
                            {{ implode(', ', array_map('strtoupper', $tutor->jenjang_tutor)) }}
                        </div>
                        @endif
                        <div class="tutor-tags mt-1">
                            @php $colors=['#eff6ff','#f0fdf4','#fef9c3']; $tc=['var(--primary)','var(--success)','var(--warning)']; @endphp
                            @foreach(($tutor->materi()->distinct('mata_pelajaran')->pluck('mata_pelajaran')->take(2)) as $ki => $m)
                            <span class="tutor-tag" style="background:{{ $colors[$ki%3] }};color:{{ $tc[$ki%3] }};">{{ $m }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="tutor-price">
                        <div class="tp-val" id="tp-val-{{ $tutor->id }}">
                            {{ $tutor->tarif_per_sesi ? 'Rp '.number_format($tutor->tarif_per_sesi,0,',','.') : 'Rp 75.000' }}
                        </div>
                        <div class="tp-label">/ sesi</div>
                        <span class="tp-avail" style="background:var(--success-soft);color:var(--success);">● Tersedia</span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
                    <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                    Belum ada tutor tersedia saat ini.
                </div>
                @endforelse

                <input type="hidden" id="input-tutor-id" name="tutor_id" />

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn fw-bold px-4 py-2"
                        style="background:var(--bg);color:var(--muted);border-radius:12px;border:1.5px solid var(--border);"
                        onclick="goStep(1)">
                        <i class="bi bi-chevron-left me-1"></i>Kembali
                    </button>
                    <button class="btn fw-bold px-5 py-2"
                        style="background:var(--primary);color:#fff;border-radius:12px;border:none;"
                        onclick="nextFromTutor()">
                        Lanjut Jadwal <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-12 col-lg-4">
                <div class="summary-card">
                    <div class="summary-title">📋 Ringkasan</div>
                    <div class="summary-row"><span class="sr-label">Paket</span><span class="sr-val" id="sum-paket">-</span></div>
                    <div class="summary-row"><span class="sr-label">Jenjang</span><span class="sr-val" id="sum-jenjang">-</span></div>
                    <div class="summary-row"><span class="sr-label">Tutor</span><span class="sr-val" id="sum-tutor">Belum dipilih</span></div>
                    <div class="summary-row"><span class="sr-label">Harga</span><span class="sr-val" id="sum-harga" style="color:var(--primary);font-weight:800;">-</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STEP 3: JADWAL & LOKASI ── --}}
    <div id="form-step3" style="display:none;">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="form-card mb-3">
                    <div style="font-size:15px;font-weight:700;margin-bottom:18px;">📅 Pilih Jadwal & Lokasi</div>

                    {{-- Mata Pelajaran --}}
                    <div class="mb-3">
                        <label class="form-label-custom">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select id="sel-mapel" class="form-control-custom" onchange="updateSummary()">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach(['Matematika','Fisika','Kimia','Biologi','Bahasa Inggris','Bahasa Indonesia','IPA','IPS','Ekonomi','Sejarah'] as $mp)
                            <option>{{ $mp }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Topik --}}
                    <div class="mb-3">
                        <label class="form-label-custom">Topik / Materi yang Ingin Dipelajari</label>
                        <input type="text" id="inp-topik" class="form-control-custom" placeholder="Contoh: Integral, Trigonometri, Grammar…" />
                    </div>

                    {{-- Tanggal & Waktu --}}
                    <div class="mb-3">
                        <label class="form-label-custom">Tanggal & Waktu <span class="text-danger">*</span></label>
                        <input type="datetime-local" id="input-jadwal" class="form-control-custom"
                            min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                            onchange="updateSummary()" />
                        <div style="font-size:12px;color:var(--muted);margin-top:4px;">
                            <i class="bi bi-info-circle me-1"></i>Minimal pemesanan H-1 dari jadwal sesi
                        </div>
                    </div>

                    {{-- Mode --}}
                    <div class="mb-3">
                        <label class="form-label-custom">Mode Belajar</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="lokasi-option selected" id="mode-online" onclick="selectMode('online')">
                                    <input type="radio" name="mode_radio" checked style="accent-color:var(--primary);width:16px;height:16px;" />
                                    <div style="width:36px;height:36px;border-radius:10px;background:var(--success-soft);color:var(--success);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
                                        <i class="bi bi-camera-video-fill"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:13.5px;font-weight:700;">Online</div>
                                        <div style="font-size:11px;color:var(--muted);">Zoom / Google Meet</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="lokasi-option" id="mode-offline" onclick="selectMode('tatap_muka')">
                                    <input type="radio" name="mode_radio" style="accent-color:var(--primary);width:16px;height:16px;" />
                                    <div style="width:36px;height:36px;border-radius:10px;background:var(--info-soft);color:var(--info);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:13.5px;font-weight:700;">Tatap Muka</div>
                                        <div style="font-size:11px;color:var(--muted);">Di rumah / tempat pilihan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi (tatap muka) --}}
                    <div id="lokasi-wrap" class="mb-3" style="display:none;">
                        <label class="form-label-custom">Alamat Lokasi <span class="text-danger">*</span></label>
                        <input type="text" id="inp-lokasi" class="form-control-custom" placeholder="Jl. Merdeka No.1, Kediri, Jawa Timur" />
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-3">
                        <label class="form-label-custom">Catatan untuk Tutor</label>
                        <textarea id="inp-catatan" class="form-control-custom" rows="2"
                            placeholder="Jelaskan kesulitan atau hal yang ingin difokuskan…"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn fw-bold px-4 py-2"
                        style="background:var(--bg);color:var(--muted);border-radius:12px;border:1.5px solid var(--border);"
                        onclick="goStep(2)">
                        <i class="bi bi-chevron-left me-1"></i>Kembali
                    </button>
                    <button class="btn fw-bold px-5 py-2"
                        style="background:var(--primary);color:#fff;border-radius:12px;border:none;"
                        onclick="nextFromJadwal()">
                        Lanjut Konfirmasi <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-12 col-lg-4">
                <div class="summary-card">
                    <div class="summary-title">📋 Ringkasan Pesanan</div>
                    <div class="summary-row"><span class="sr-label">Paket</span><span class="sr-val" id="sum3-paket">-</span></div>
                    <div class="summary-row"><span class="sr-label">Tutor</span><span class="sr-val" id="sum3-tutor">-</span></div>
                    <div class="summary-row"><span class="sr-label">Mata Pelajaran</span><span class="sr-val" id="sum3-mapel">Belum dipilih</span></div>
                    <div class="summary-row"><span class="sr-label">Jadwal</span><span class="sr-val" id="sum3-jadwal">Belum dipilih</span></div>
                    <div class="summary-row"><span class="sr-label">Mode</span><span class="sr-val" id="sum3-mode">Online</span></div>
                    <div class="summary-total">
                        <span class="st-label">Total</span>
                        <span class="st-val" id="sum3-harga">-</span>
                    </div>
                    <div style="font-size:11.5px;color:var(--muted);margin-top:10px;background:var(--success-soft);border-radius:8px;padding:8px 10px;border-left:3px solid var(--success);">
                        <i class="bi bi-shield-check me-1" style="color:var(--success);"></i>
                        Bayar setelah tutor konfirmasi pesanan
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STEP 4: KONFIRMASI & KIRIM ── --}}
    <div id="form-step4" style="display:none;">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="form-card mb-3">
                    <div style="font-size:15px;font-weight:700;margin-bottom:18px;">✅ Konfirmasi Pesanan</div>

                    {{-- Preview detail --}}
                    <div style="background:var(--bg);border-radius:14px;padding:18px;margin-bottom:18px;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                            <div style="width:50px;height:50px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;color:#fff;flex-shrink:0;" id="konfirm-av">TT</div>
                            <div>
                                <div style="font-size:15px;font-weight:800;color:var(--text);" id="konfirm-nama-tutor">-</div>
                                <div style="font-size:12px;color:var(--muted);">Tutor Al Ilmi Center</div>
                            </div>
                        </div>
                        @foreach([
                        ['bi-mortarboard-fill','Paket','konfirm-paket'],
                        ['bi-book-fill','Mata Pelajaran','konfirm-mapel'],
                        ['bi-calendar3','Jadwal','konfirm-jadwal'],
                        ['bi-clock-fill','Durasi','konfirm-durasi'],
                        ['bi-camera-video-fill','Mode','konfirm-mode'],
                        ] as $row)
                        <div style="display:flex;justify-content:space-between;font-size:13px;padding:7px 0;border-bottom:1px solid var(--border);">
                            <span style="color:var(--muted);display:flex;align-items:center;gap:6px;">
                                <i class="bi {{ $row[0] }}"></i>{{ $row[1] }}
                            </span>
                            <span style="font-weight:600;" id="{{ $row[2] }}">-</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Form hidden fields for POST --}}
                    <form id="form-pesan-les" action="/siswa/les-privat/pesan" method="POST">
                        @csrf
                        <input type="hidden" name="tutor_id" id="f-tutor-id" />
                        <input type="hidden" name="paket_id" id="f-paket-id" />
                        <input type="hidden" name="mata_pelajaran" id="f-mapel" />
                        <input type="hidden" name="topik" id="f-topik" />
                        <input type="hidden" name="jadwal" id="f-jadwal" />
                        <input type="hidden" name="durasi_menit" id="f-durasi" value="90" />
                        <input type="hidden" name="mode" id="f-mode" value="online" />
                        <input type="hidden" name="lokasi" id="f-lokasi" />
                        <input type="hidden" name="catatan" id="f-catatan" />
                        <input type="hidden" name="harga" id="f-harga" />
                    </form>

                    {{-- Persetujuan --}}
                    <div style="background:var(--accent-soft);border:1px solid var(--accent);border-radius:10px;padding:12px 14px;margin-bottom:16px;font-size:12.5px;color:#92400e;">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Dengan mengirim pesanan, kamu menyetujui bahwa pembayaran akan dilakukan <strong>setelah tutor mengkonfirmasi</strong> pesanan dalam 1×24 jam.
                    </div>

                    <div class="d-flex justify-content-between">
                        <button class="btn fw-bold px-4 py-2"
                            style="background:var(--bg);color:var(--muted);border-radius:12px;border:1.5px solid var(--border);"
                            onclick="goStep(3)">
                            <i class="bi bi-chevron-left me-1"></i>Kembali
                        </button>
                        <button type="button" onclick="submitPesanan()"
                            class="btn fw-bold px-5 py-2"
                            style="background:var(--success);color:#fff;border-radius:12px;border:none;box-shadow:0 4px 12px rgba(22,163,74,.3);">
                            <i class="bi bi-check-circle-fill me-1"></i>Kirim Pesanan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-12 col-lg-4">
                <div class="summary-card">
                    <div class="summary-title">💳 Rincian Biaya</div>
                    <div class="summary-row"><span class="sr-label">Biaya Sesi</span><span class="sr-val" id="sum4-biaya">-</span></div>
                    <div class="summary-row"><span class="sr-label">Biaya Admin</span><span class="sr-val">Rp 0</span></div>
                    <div class="summary-row"><span class="sr-label">Diskon</span><span class="sr-val" style="color:var(--success);">-</span></div>
                    <div class="summary-total">
                        <span class="st-label">Total Bayar</span>
                        <span class="st-val" id="sum4-total">-</span>
                    </div>
                    <div style="font-size:11.5px;color:var(--muted);margin-top:10px;line-height:1.6;">
                        <i class="bi bi-clock me-1"></i>Pembayaran dilakukan setelah tutor konfirmasi pesanan.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     TAB STATUS PESANAN
══════════════════════════════════════ --}}
<div id="panel-status" style="display:none;">

    <div style="font-size:15px;font-weight:700;margin-bottom:14px;">🟢 Pesanan Aktif</div>

    @forelse($pesananAktif as $p)
    <div class="order-card" style="border-left:3px solid {{ $p->status==='menunggu'?'var(--accent)':'var(--success)' }};">
        <div class="order-header">
            <span class="order-id">#{{ strtoupper(substr($p->id, 0, 8)) }}</span>
            @if($p->status==='menunggu')
            <span class="pill p-warning"><i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi</span>
            @elseif($p->status==='dikonfirmasi')
            <span class="pill p-success"><i class="bi bi-check-circle-fill"></i> Dikonfirmasi</span>
            @endif
        </div>
        <div class="order-body">
            <div class="order-av" style="background:var(--primary);">{{ strtoupper(substr($p->tutor->name??'T',0,2)) }}</div>
            <div class="order-info" style="flex:1;min-width:0;">
                <div class="oi-subj">{{ $p->mata_pelajaran }}{{ $p->topik?' – '.$p->topik:'' }}</div>
                <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i>{{ $p->tutor->name??'-' }}</div>
                <div class="oi-sched">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $p->jadwal->translatedFormat('l, d M Y · H:i') }} WIB
                    · {{ $p->getModeLabel() }}
                    · {{ $p->durasi_menit }} mnt
                </div>
                @if($p->status==='dikonfirmasi' && $p->link_meeting)
                <div class="mt-1">
                    <a href="{{ $p->link_meeting }}" target="_blank" style="font-size:12px;color:var(--primary);font-weight:600;">
                        <i class="bi bi-camera-video-fill me-1"></i>Masuk ke Meeting Room
                    </a>
                </div>
                @endif
            </div>
            <div class="order-action" style="flex-direction:column;align-items:flex-end;">
                <div style="font-size:15px;font-weight:800;color:var(--primary);">Rp {{ number_format($p->harga,0,',','.') }}</div>
                @if($p->pembayaran_status==='lunas')
                <span class="pill p-success" style="font-size:10.5px;margin-top:4px;">✅ Lunas</span>
                @elseif($p->pembayaran_status==='menunggu')
                <span class="pill p-warning" style="font-size:10.5px;margin-top:4px;">⏳ Verifikasi</span>
                @else
                <a href="/siswa/pembayaran" class="pill p-danger" style="font-size:10.5px;margin-top:4px;text-decoration:none;">💳 Bayar</a>
                @endif
                @if($p->status==='menunggu')
                <form method="POST" action="/siswa/les-privat/{{ $p->id }}/batalkan"
                    onsubmit="return confirm('Batalkan pesanan ini?')" style="margin-top:6px;">
                    @csrf
                    <button type="submit" class="btn-action" style="background:var(--danger-soft);color:var(--danger);">Batalkan</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Timeline --}}
        <div class="mt-3 pt-3" style="border-top:1px solid var(--border);">
            <div class="status-timeline">
                <div class="timeline-item">
                    <div class="tl-dot done"><i class="bi bi-check-lg" style="font-size:10px;"></i></div>
                    <div class="tl-title">Pesanan Dikirim</div>
                    <div class="tl-time">{{ $p->created_at->translatedFormat('d M Y · H:i') }}</div>
                </div>
                <div class="timeline-item">
                    <div class="tl-dot {{ $p->status!=='menunggu'?'done':'active' }}">
                        @if($p->status!=='menunggu')<i class="bi bi-check-lg" style="font-size:10px;"></i>
                        @else<i class="bi bi-clock-fill" style="font-size:10px;"></i>@endif
                    </div>
                    <div class="tl-title" style="{{ $p->status==='menunggu'?'color:var(--warning);':'' }}">
                        {{ $p->status==='menunggu'?'Menunggu Konfirmasi Tutor':'Tutor Mengonfirmasi' }}
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="tl-dot {{ $p->pembayaran_status==='lunas'?'done':($p->status==='dikonfirmasi'?'active':'pending') }}">
                        @if($p->pembayaran_status==='lunas')<i class="bi bi-check-lg" style="font-size:10px;"></i>
                        @elseif($p->status==='dikonfirmasi')<i class="bi bi-cash-coin" style="font-size:10px;"></i>
                        @else 3 @endif
                    </div>
                    <div class="tl-title">Pembayaran</div>
                    <div class="tl-desc">
                        {{ $p->pembayaran_status==='lunas'?'✅ Lunas':($p->pembayaran_status==='menunggu'?'⏳ Menunggu Verifikasi':'Belum Dibayar') }}
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="tl-dot pending">4</div>
                    <div class="tl-title">Sesi Selesai</div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
        <i class="bi bi-calendar-x" style="font-size:2.5rem;display:block;margin-bottom:10px;"></i>
        <div style="font-size:15px;font-weight:700;margin-bottom:4px;">Belum Ada Pesanan Aktif</div>
        <button onclick="showMainTab('pesan')"
            style="margin-top:10px;background:var(--primary);color:#fff;border:none;border-radius:10px;padding:10px 24px;font-size:13px;font-weight:700;cursor:pointer;">
            Pesan Les Sekarang
        </button>
    </div>
    @endforelse

    @if(isset($riwayat) && $riwayat->count()>0)
    <div style="font-size:15px;font-weight:700;margin:24px 0 14px;">📁 Riwayat Pesanan</div>
    @foreach($riwayat as $r)
    <div class="order-card" style="opacity:.85;">
        <div class="order-header">
            <span class="order-id">#{{ strtoupper(substr($r->id,0,8)) }}</span>
            @if($r->status==='selesai')
            <span class="pill p-success"><i class="bi bi-check2-all"></i> Selesai</span>
            @else
            <span class="pill p-danger"><i class="bi bi-x-circle-fill"></i> Dibatalkan</span>
            @endif
        </div>
        <div class="order-body">
            <div class="order-av" style="background:{{ $r->status==='selesai'?'var(--success)':'var(--muted)' }};">{{ strtoupper(substr($r->tutor->name??'T',0,2)) }}</div>
            <div class="order-info" style="flex:1;min-width:0;">
                <div class="oi-subj">{{ $r->mata_pelajaran }}{{ $r->topik?' – '.$r->topik:'' }}</div>
                <div class="oi-tutor"><i class="bi bi-person-fill me-1"></i>{{ $r->tutor->name??'-' }}</div>
                <div class="oi-sched"><i class="bi bi-calendar3 me-1"></i>{{ $r->jadwal->translatedFormat('d M Y · H:i') }} WIB · {{ $r->getModeLabel() }}</div>
            </div>
            <div class="order-action" style="flex-direction:column;align-items:flex-end;">
                <div style="font-size:14px;font-weight:800;color:var(--muted);">Rp {{ number_format($r->harga,0,',','.') }}</div>
                @if($r->status==='selesai')
                <button onclick="showMainTab('pesan')" class="btn-action"
                    style="background:#eff6ff;color:var(--primary);margin-top:6px;">
                    Pesan Ulang
                </button>
                @if(!$r->ulasan)
                <button onclick="bukaModalUlasan('{{ $r->id }}','{{ addslashes($r->mata_pelajaran) }}','{{ addslashes($r->tutor->name ?? '') }}')"
                    class="btn-action"
                    style="background:var(--accent-soft);color:var(--warning);margin-top:6px;">
                    ⭐ Beri Ulasan
                </button>
                @else
                <span style="font-size:10.5px;color:var(--success);margin-top:4px;display:block;">
                    ✅ Sudah Diulas
                </span>
                @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

{{-- MODAL SUKSES --}}
<div class="modal-overlay" id="modal-sukses">
    <div class="modal-box" style="max-width:420px;">
        <div style="padding:32px 28px;text-align:center;">
            <div style="font-size:60px;margin-bottom:14px;">🎉</div>
            <div style="font-size:20px;font-weight:800;color:var(--text);margin-bottom:6px;">Pesanan Terkirim!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.6;">
                Pesanan les privat berhasil dikirim!<br />
                Menunggu konfirmasi tutor dalam <strong>1×24 jam</strong>.
            </div>
            <div style="background:var(--success-soft);border-radius:12px;padding:14px;margin-bottom:20px;text-align:left;">
                <div style="font-size:12px;color:var(--success);font-weight:700;">
                    <i class="bi bi-check-circle-fill me-1"></i>Status: Menunggu Konfirmasi Tutor
                </div>
                <div style="font-size:12px;color:var(--success);margin-top:4px;">
                    Kamu akan mendapat notifikasi setelah dikonfirmasi.
                </div>
            </div>
            <div class="d-flex gap-2">
                <button onclick="document.getElementById('modal-sukses').classList.remove('show')"
                    style="flex:1;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                    Tutup
                </button>
                <button onclick="document.getElementById('modal-sukses').classList.remove('show');showMainTab('status')"
                    style="flex:2;padding:10px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                    Lihat Status <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ULASAN --}}
<div class="modal-overlay" id="modal-ulasan">
    <div class="modal-box" style="max-width:440px;">
        <div class="modal-head">
            <h5><i class="bi bi-star-fill me-2" style="color:var(--accent);"></i>Beri Ulasan</h5>
            <button class="modal-close-btn"
                onclick="document.getElementById('modal-ulasan').classList.remove('show')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form method="POST" action="/siswa/ulasan">
            @csrf
            <input type="hidden" name="les_privat_id" id="ulasan-les-id" />
            <div style="padding:20px 22px;">
                <div style="text-align:center;margin-bottom:16px;">
                    <div style="font-size:13.5px;font-weight:700;color:var(--text);" id="ulasan-mapel"></div>
                    <div style="font-size:12px;color:var(--muted);" id="ulasan-tutor"></div>
                </div>

                <div style="text-align:center;margin-bottom:16px;">
                    <div style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:10px;">Rating</div>
                    <div style="display:flex;justify-content:center;gap:8px;" id="star-container">
                        @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star" data-val="{{ $i }}"
                            onclick="setBintang({{ $i }})"
                            style="font-size:28px;cursor:pointer;color:var(--border);transition:color .15s;"></i>
                            @endfor
                    </div>
                    <input type="hidden" name="bintang" id="input-bintang" value="0" />
                </div>

                <div class="mb-3">
                    <label style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;display:block;">
                        Komentar (opsional)
                    </label>
                    <textarea name="komentar" rows="3"
                        style="width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;outline:none;resize:vertical;"
                        placeholder="Ceritakan pengalaman belajarmu..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button"
                        onclick="document.getElementById('modal-ulasan').classList.remove('show')"
                        style="flex:1;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                        Batal
                    </button>
                    <button type="submit" id="btn-kirim-ulasan" disabled
                        style="flex:2;padding:10px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;opacity:.6;">
                        <i class="bi bi-send-fill me-1"></i> Kirim Ulasan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── STATE ──
    let state = {
        jenjang: '',
        jenjangName: '',
        paketId: '',
        harga: 0,
        tutorId: '',
        tutorName: '',
        mapel: '',
        jadwal: '',
        mode: 'online',
        durasi: 90
    };

    function lanjutDariPaket(key, jenjangName, warna) {
        if (!selectedPaketOption[key]) {
            alert('Pilih salah satu paket terlebih dahulu!');
            return;
        }
        const opt = selectedPaketOption[key];
        const durasi = key === 'sd' ? 60 : key === 'smp' ? 75 : 90;

        state.jenjang = key;
        state.jenjangName = jenjangName;
        state.paketId = opt.paketId;
        state.harga = opt.hargaRaw;
        state.durasi = durasi;

        document.getElementById('sum-paket').textContent = opt.nama;
        document.getElementById('sum-jenjang').textContent = jenjangName;
        document.getElementById('sum-harga').textContent = opt.harga + ' / sesi';
        document.getElementById('info-paket-step2').textContent = opt.nama + ' · ' + opt.harga;

        document.querySelectorAll('[id^="tp-val-"]').forEach(el => {
            el.textContent = opt.harga;
        });

        goStep(2);
    }

    // ── MAIN TAB ──
    function showMainTab(tab) {
        const isPesan = tab === 'pesan';
        document.getElementById('panel-pesan').style.display = isPesan ? '' : 'none';
        document.getElementById('panel-status').style.display = isPesan ? 'none' : '';
        document.getElementById('step-bar').style.display = isPesan ? '' : 'none';

        document.getElementById('tab-pesan').classList.toggle('active', isPesan);
        document.getElementById('tab-status').classList.toggle('active', !isPesan);
    }

    // ── STEP NAVIGATION ──
    function goStep(n) {
        [1, 2, 3, 4].forEach(i => {
            const el = document.getElementById('form-step' + i);
            if (el) el.style.display = 'none';
        });
        const target = document.getElementById('form-step' + n);
        if (target) target.style.display = '';

        [1, 2, 3, 4].forEach(i => {
            const sc = document.getElementById('sc' + i);
            const sl = document.getElementById('sl' + i);
            const sd = document.getElementById('sd' + i);
            if (!sc) return;
            if (i < n) {
                sc.className = 'step-circle done';
                sc.innerHTML = '<i class="bi bi-check-lg"></i>';
                sl.className = 'step-label done';
            } else if (i === n) {
                sc.className = 'step-circle active';
                sc.innerHTML = i;
                sl.className = 'step-label active';
            } else {
                sc.className = 'step-circle pending';
                sc.innerHTML = i;
                sl.className = 'step-label pending';
            }
            if (sd) sd.className = 'step-divider ' + (i < n ? 'done' : '');
        });
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // ── STEP 1: SELECT JENJANG ──
    function selectJenjang(key) {
        // Clear all
        document.querySelectorAll('.jenjang-card').forEach(c => c.classList.remove('selected'));
        document.querySelectorAll('.paket-detail').forEach(d => d.classList.remove('show'));

        // Select
        document.getElementById('jcard-' + key).classList.add('selected');
        document.getElementById('paket-detail-' + key).classList.add('show');

        // Scroll to detail
        setTimeout(() => {
            document.getElementById('paket-detail-' + key).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }

    function pilihPaket(key, name, harga, paketId) {
        state.jenjang = key;
        state.jenjangName = name;
        state.paketId = paketId;
        state.harga = parseInt(harga.replace(/[^0-9]/g, ''));
        state.durasi = key === 'sd' ? 60 : key === 'smp' ? 75 : 90;

        // Update summary step 2
        document.getElementById('sum-paket').textContent = 'Les Privat ' + name;
        document.getElementById('sum-jenjang').textContent = name;
        document.getElementById('sum-harga').textContent = harga + ' / sesi';
        document.getElementById('info-paket-step2').textContent = 'Les Privat ' + name + ' · ' + harga;

        // Update harga per tutor card
        document.querySelectorAll('[id^="tp-val-"]').forEach(el => {
            el.textContent = harga;
        });

        goStep(2);
    }

    // ── STEP 2: SELECT TUTOR ──
    function selectTutor(el) {
        document.querySelectorAll('.tutor-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        state.tutorId = el.dataset.id;
        state.tutorName = el.dataset.name;
        document.getElementById('sum-tutor').textContent = el.dataset.name;
    }

    function nextFromTutor() {
        if (!state.tutorId) {
            alert('Pilih tutor terlebih dahulu!');
            return;
        }
        // Update summary step 3
        document.getElementById('sum3-paket').textContent = 'Les Privat ' + state.jenjangName;
        document.getElementById('sum3-tutor').textContent = state.tutorName;
        document.getElementById('sum3-harga').textContent = 'Rp ' + state.harga.toLocaleString('id-ID');
        goStep(3);
    }

    // ── STEP 3: MODE & SUMMARY ──
    function selectMode(mode) {
        state.mode = mode;
        document.getElementById('mode-online').classList.toggle('selected', mode === 'online');
        document.getElementById('mode-offline').classList.toggle('selected', mode === 'tatap_muka');
        document.getElementById('mode-online').querySelector('input').checked = mode === 'online';
        document.getElementById('mode-offline').querySelector('input').checked = mode === 'tatap_muka';
        document.getElementById('lokasi-wrap').style.display = mode === 'tatap_muka' ? '' : 'none';
        document.getElementById('sum3-mode').textContent = mode === 'online' ? 'Online (Zoom/Meet)' : 'Tatap Muka';
    }

    function updateSummary() {
        const mapel = document.getElementById('sel-mapel').value;
        const jadwal = document.getElementById('input-jadwal').value;
        if (mapel) {
            document.getElementById('sum3-mapel').textContent = mapel;
            state.mapel = mapel;
        }
        if (jadwal) {
            const d = new Date(jadwal);
            const fmt = d.toLocaleString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('sum3-jadwal').textContent = fmt + ' WIB';
            state.jadwal = jadwal;
        }
    }

    function nextFromJadwal() {
        if (!document.getElementById('sel-mapel').value) {
            alert('Pilih mata pelajaran!');
            return;
        }
        if (!document.getElementById('input-jadwal').value) {
            alert('Isi tanggal & waktu sesi!');
            return;
        }

        state.mapel = document.getElementById('sel-mapel').value;
        state.jadwal = document.getElementById('input-jadwal').value;
        state.topik = document.getElementById('inp-topik').value;
        state.lokasi = document.getElementById('inp-lokasi').value;
        state.catatan = document.getElementById('inp-catatan').value;

        if (state.mode === 'tatap_muka' && !state.lokasi) {
            alert('Isi alamat lokasi tatap muka!');
            return;
        }

        // Update konfirmasi step 4
        document.getElementById('konfirm-av').textContent = state.tutorName.substring(0, 2).toUpperCase();
        document.getElementById('konfirm-nama-tutor').textContent = state.tutorName;
        document.getElementById('konfirm-paket').textContent = 'Les Privat ' + state.jenjangName;
        document.getElementById('konfirm-mapel').textContent = state.mapel + (state.topik ? ' – ' + state.topik : '');
        document.getElementById('konfirm-durasi').textContent = state.durasi + ' Menit';
        document.getElementById('konfirm-mode').textContent = state.mode === 'online' ? 'Online (Zoom/Meet)' : 'Tatap Muka';
        const d = new Date(state.jadwal);
        document.getElementById('konfirm-jadwal').textContent = d.toLocaleString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) + ' WIB';

        document.getElementById('sum4-biaya').textContent = 'Rp ' + state.harga.toLocaleString('id-ID');
        document.getElementById('sum4-total').textContent = 'Rp ' + state.harga.toLocaleString('id-ID');

        goStep(4);
    }

    // ── SUBMIT ──
    function submitPesanan() {
        // Isi hidden fields
        document.getElementById('f-tutor-id').value = state.tutorId;
        document.getElementById('f-paket-id').value = state.paketId || '';
        document.getElementById('f-mapel').value = state.mapel;
        document.getElementById('f-topik').value = state.topik || '';
        document.getElementById('f-jadwal').value = state.jadwal;
        document.getElementById('f-durasi').value = state.durasi;
        document.getElementById('f-mode').value = state.mode;
        document.getElementById('f-lokasi').value = state.lokasi || '';
        document.getElementById('f-catatan').value = state.catatan || '';
        document.getElementById('f-harga').value = state.harga;

        // Submit form
        document.getElementById('form-pesan-les').submit();
    }

    function bukaModalUlasan(lesId, mapel, tutor) {
        document.getElementById('ulasan-les-id').value = lesId;
        document.getElementById('ulasan-mapel').textContent = mapel;
        document.getElementById('ulasan-tutor').textContent = 'Tutor: ' + tutor;
        document.getElementById('input-bintang').value = 0;

        const btnKirim = document.getElementById('btn-kirim-ulasan');
        btnKirim.disabled = true;
        btnKirim.style.opacity = '.6';

        document.querySelectorAll('#star-container i').forEach(s => {
            s.className = 'bi bi-star';
            s.style.color = 'var(--border)';
        });

        document.getElementById('modal-ulasan').classList.add('show');
    }

    function setBintang(val) {
        document.getElementById('input-bintang').value = val;

        const btnKirim = document.getElementById('btn-kirim-ulasan');
        btnKirim.disabled = false;
        btnKirim.style.opacity = '1';

        document.querySelectorAll('#star-container i').forEach((s, i) => {
            s.className = i < val ? 'bi bi-star-fill' : 'bi bi-star';
            s.style.color = i < val ? 'var(--accent)' : 'var(--border)';
        });
    }
    // ── PILIH PAKET OPTION ──
    let selectedPaketOption = {};

    function selectPaketOption(key, pidx, paketId, nama, harga, hargaRaw, jumlahLes, jumlahSoal) {
        // Reset semua radio di jenjang ini
        document.querySelectorAll('[id^="radio-' + key + '-"]').forEach(r => {
            r.style.background = '';
            r.style.borderColor = 'var(--border)';
        });
        document.querySelectorAll('[id^="pocard-' + key + '-"]').forEach(c => {
            c.style.borderColor = 'var(--border)';
            c.style.background = '';
        });

        // Aktifkan yang dipilih
        const radio = document.getElementById('radio-' + key + '-' + pidx);
        const card = document.getElementById('pocard-' + key + '-' + pidx);
        radio.style.background = 'var(--primary)';
        radio.style.borderColor = 'var(--primary)';
        card.style.borderColor = 'var(--primary)';
        card.style.background = '#f0f7ff';

        selectedPaketOption[key] = {
            paketId,
            nama,
            harga,
            hargaRaw
        };
    }

    function lanjutDariPaket(key, jenjangName, warna) {
        if (!selectedPaketOption[key]) {
            alert('Pilih salah satu paket terlebih dahulu!');
            return;
        }
        const opt = selectedPaketOption[key];
        const durasi = key === 'sd' ? 60 : key === 'smp' ? 75 : 90;

        state.jenjang = key;
        state.jenjangName = jenjangName;
        state.paketId = opt.paketId;
        state.harga = opt.hargaRaw;
        state.durasi = durasi;

        document.getElementById('sum-paket').textContent = opt.nama;
        document.getElementById('sum-jenjang').textContent = jenjangName;
        document.getElementById('sum-harga').textContent = opt.harga + ' / sesi';
        document.getElementById('info-paket-step2').textContent = opt.nama + ' · ' + opt.harga;

        document.querySelectorAll('[id^="tp-val-"]').forEach(el => {
            el.textContent = opt.harga;
        });

        goStep(2);
    }
</script>
@endpush