@extends('layouts.app')

@section('title', 'Pesan Jadwal Les - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Pesan Jadwal Les')
@section('page-sub', 'Dashboard / Pesan Jadwal Les')

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
<a href="/siswa/pesan-jadwal" class="nav-item-custom {{ request()->is('siswa/pesan-jadwal') ? 'active' : '' }}">
    <i class="bi bi-calendar-plus-fill"></i> Pesan Jadwal
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
        margin-bottom: 28px;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 18px;
        left: 60%;
        width: 80%;
        height: 2px;
        background: var(--border);
        z-index: 0;
    }

    .step-item.done:not(:last-child)::after {
        background: var(--primary);
    }

    .step-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--card-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: var(--muted);
        position: relative;
        z-index: 1;
        transition: all .3s;
    }

    .step-item.active .step-circle {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(30, 58, 95, .3);
    }

    .step-item.done .step-circle {
        background: var(--success);
        border-color: var(--success);
        color: #fff;
    }

    .step-label {
        font-size: 11.5px;
        font-weight: 600;
        color: var(--muted);
        margin-top: 6px;
        text-align: center;
    }

    .step-item.active .step-label {
        color: var(--primary);
        font-weight: 700;
    }

    .step-item.done .step-label {
        color: var(--success);
    }

    /* ── TUTOR CARDS ── */
    .tutor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 12px;
    }

    .tutor-card {
        background: var(--card-bg);
        border: 2px solid var(--border);
        border-radius: 14px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
    }

    .tutor-card:hover {
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 95, .1);
    }

    .tutor-card.selected {
        border-color: var(--primary);
        background: #eff6ff;
        box-shadow: 0 6px 20px rgba(30, 58, 95, .15);
    }

    .tutor-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 20px;
        margin: 0 auto 10px;
    }

    .tutor-name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 2px;
    }

    .tutor-mapel {
        font-size: 11.5px;
        color: var(--muted);
    }

    .tutor-rating {
        font-size: 12px;
        color: var(--warning);
        margin-top: 4px;
        font-weight: 600;
    }

    .tutor-badge {
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        margin-top: 6px;
        display: inline-block;
    }

    /* ── JADWAL SLOT ── */
    .slot-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 8px;
        margin-top: 10px;
    }

    .slot-btn {
        padding: 10px 8px;
        border: 2px solid var(--border);
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        transition: all .2s;
        background: var(--card-bg);
        text-align: center;
    }

    .slot-btn:hover {
        border-color: var(--primary-light);
        color: var(--primary);
    }

    .slot-btn.selected {
        border-color: var(--primary);
        background: #eff6ff;
        color: var(--primary);
    }

    .slot-btn.taken {
        background: var(--bg);
        color: var(--border);
        cursor: not-allowed;
        border-color: var(--border);
    }

    /* ── FORM SECTION ── */
    .form-section {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
    }

    .form-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title i {
        color: var(--primary);
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 13.5px;
        color: var(--text);
        background: #fff;
        transition: all .2s;
        outline: none;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 95, .08);
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    /* ── SUMMARY CARD ── */
    .summary-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 16px;
        padding: 20px;
        color: #fff;
        margin-bottom: 16px;
    }

    .sc-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 0;
        border-bottom: 1px solid rgba(255, 255, 255, .12);
    }

    .sc-row:last-child {
        border-bottom: none;
    }

    .sc-label {
        font-size: 12.5px;
        opacity: .75;
    }

    .sc-val {
        font-size: 13px;
        font-weight: 700;
    }

    /* ── RIWAYAT PESANAN TABLE ── */
    .tbl {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl thead th {
        padding: 10px 14px;
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        background: var(--bg);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .tbl tbody td {
        padding: 12px 14px;
        font-size: 13px;
        color: var(--text);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .tbl tbody tr:last-child td {
        border-bottom: none;
    }

    .tbl tbody tr:hover td {
        background: #f8faff;
    }

    /* ── STATUS BADGE ── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
    }

    /* ── MODAL ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        width: 90%;
        max-width: 480px;
        max-height: 90vh;
        overflow-y: auto;
        animation: fadeUp .25s ease;
    }

    @keyframes fadeUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-head {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-head h5 {
        font-size: 16px;
        font-weight: 800;
        color: var(--text);
    }

    .modal-close-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: var(--bg);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--muted);
    }

    .modal-body-p {
        padding: 22px 24px;
    }

    /* ── TABS ── */
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
        padding: 9px 10px;
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

    /* CARD BOX */
    .card-box {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
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
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text);
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
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">📅 Pesan Jadwal Les</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Pesan Jadwal Les</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button onclick="exportExcel()" class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--success-soft);color:var(--success);border-radius:10px;border:1.5px solid var(--success);font-size:12px;">
            <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel
        </button>
        <button onclick="exportPDF()" class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--danger-soft);color:var(--danger);border-radius:10px;border:1.5px solid var(--danger);font-size:12px;">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
        </button>
    </div>
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'pesan')">
        <i class="bi bi-calendar-plus me-1"></i> Pesan Jadwal Baru
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat Pesanan
    </button>
</div>

{{-- ══ TAB: PESAN JADWAL BARU ══ --}}
<div id="tab-pesan">

    {{-- STEP BAR --}}
    <div class="step-bar mb-4">
        @php
        $steps = ['Pilih Tutor', 'Pilih Jadwal', 'Detail Les', 'Konfirmasi'];
        @endphp
        @foreach ($steps as $i => $step)
        <div class="step-item {{ $i === 0 ? 'active' : '' }}" id="step-{{ $i + 1 }}">
            <div class="step-circle">
                @if ($i === 0)
                <i class="bi bi-check2"></i>
                @else
                {{ $i + 1 }}
                @endif
            </div>
            <div class="step-label">{{ $step }}</div>
        </div>
        @endforeach
    </div>

    {{-- STEP 1: PILIH TUTOR --}}
    <div id="panel-1" class="form-section">
        <div class="form-section-title">
            <i class="bi bi-people-fill"></i> Langkah 1 — Pilih Tutor
        </div>

        {{-- Filter --}}
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <div style="position:relative;">
                    <i class="bi bi-search"
                        style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px;"></i>
                    <input type="text" class="form-control-custom" style="padding-left:36px;"
                        placeholder="Cari nama tutor…" id="searchTutor" oninput="filterTutor()" />
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-control-custom form-select-custom" id="filterMapel" onchange="filterTutor()">
                    <option value="">Semua Mata Pelajaran</option>
                    <option>Matematika</option>
                    <option>Fisika</option>
                    <option>Kimia</option>
                    <option>Biologi</option>
                    <option>Bahasa Inggris</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control-custom form-select-custom">
                    <option>Semua Mode</option>
                    <option>Online</option>
                    <option>Offline</option>
                </select>
            </div>
        </div>

        {{-- Tutor Grid --}}
        <div class="tutor-grid" id="tutorGrid">
            @forelse($tutors as $tutor)
            <div class="tutor-card" onclick="selectTutor(this)"
                data-id="{{ $tutor->id }}"
                data-name="{{ $tutor->name }}"
                data-mapel="{{ $tutor->mata_pelajaran_tutor ? implode(', ', $tutor->mata_pelajaran_tutor) : '-' }}"
                data-harga="{{ $tutor->tarif_per_sesi ?? 75000 }}"
                data-mode="{{ $tutor->mode_mengajar ?? 'Online' }}">
                <div class="tutor-avatar" style="background:var(--primary);color:#fff;">
                    {{ strtoupper(substr($tutor->name, 0, 1)) }}
                </div>
                <div class="tutor-name">{{ $tutor->name }}</div>
                <div class="tutor-mapel">
                    {{ $tutor->mata_pelajaran_tutor ? implode(', ', array_slice($tutor->mata_pelajaran_tutor, 0, 2)) : 'Semua Mata Pelajaran' }}
                </div>
                <div class="tutor-rating">
                    <i class="bi bi-star-fill" style="color:var(--accent);"></i>
                    {{ number_format(\App\Models\Ulasan::where('tutor_id', $tutor->id)->avg('bintang') ?? 0, 1) }}
                    <span style="color:var(--muted);font-weight:400;">
                        ({{ \App\Models\Ulasan::where('tutor_id', $tutor->id)->count() }} ulasan)
                    </span>
                </div>
                <div class="tutor-badge"
                    style="background:{{ str_contains($tutor->mode_mengajar ?? '', 'Offline') ? 'var(--success-soft)' : 'var(--info-soft)' }};color:{{ str_contains($tutor->mode_mengajar ?? '', 'Offline') ? 'var(--success)' : 'var(--info)' }};">
                    {{ $tutor->mode_mengajar ?? 'Online' }}
                </div>
                <div style="font-size:12px;font-weight:700;color:var(--primary);margin-top:6px;">
                    Rp {{ number_format($tutor->tarif_per_sesi ?? 75000, 0, ',', '.') }}/sesi
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px;color:var(--muted);grid-column:1/-1;">
                <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                Belum ada tutor tersedia.
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button onclick="goStep(2)" class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
                id="btnStep1">
                Lanjut: Pilih Jadwal <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- STEP 2: PILIH JADWAL --}}
    <div id="panel-2" style="display:none;" class="form-section">
        <div class="form-section-title">
            <i class="bi bi-calendar3"></i> Langkah 2 — Pilih Jadwal
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Pilih Tanggal</label>
                <input type="date" class="form-control-custom" id="tglPilih"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    onchange="updateSlots()" />
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Durasi Sesi</label>
                <select class="form-control-custom form-select-custom" id="durasi" onchange="updateHarga()">
                    <option value="60">60 Menit</option>
                    <option value="90" selected>90 Menit</option>
                    <option value="120">120 Menit</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label-custom">Pilih Waktu</label>
            <div class="slot-grid" id="slotGrid">
                @php
                $slots = [
                '07:00',
                '08:00',
                '09:00',
                '10:00',
                '11:00',
                '13:00',
                '14:00',
                '15:00',
                '16:00',
                '17:00',
                '19:00',
                '20:00',
                ];
                $taken = ['09:00', '11:00', '17:00'];
                @endphp
                @foreach ($slots as $slot)
                <div class="slot-btn {{ in_array($slot, $taken) ? 'taken' : '' }}"
                    onclick="{{ in_array($slot, $taken) ? '' : "selectSlot(this, '$slot')" }}">
                    {{ $slot }}
                    @if (in_array($slot, $taken))
                    <div style="font-size:10px;margin-top:2px;color:var(--border);">Penuh</div>
                    @else
                    <div style="font-size:10px;margin-top:2px;color:var(--muted);">Tersedia</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button onclick="goStep(1)" class="btn fw-bold px-4 py-2"
                style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </button>
            <button onclick="goStep(3)" class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                Lanjut: Detail Les <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- STEP 3: DETAIL LES --}}
    <div id="panel-3" style="display:none;" class="form-section">
        <div class="form-section-title">
            <i class="bi bi-pencil-square"></i> Langkah 3 — Detail Les
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Mata Pelajaran</label>
                <select class="form-control-custom form-select-custom" id="selectMapel">
                    <option>Matematika</option>
                    <option>Fisika</option>
                    <option>Kimia</option>
                    <option>Biologi</option>
                    <option>Bahasa Inggris</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Mode Belajar</label>
                <select class="form-control-custom form-select-custom" id="selectMode">
                    <option value="online">Online (Zoom/Google Meet)</option>
                    <option value="offline">Offline (Tatap Muka)</option>
                </select>
            </div>
            <div class="col-12" id="alamatWrap" style="display:none;">
                <label class="form-label-custom">Alamat Lengkap (untuk Offline)</label>
                <input type="text" class="form-control-custom" placeholder="Contoh: Jl. Kenanga No.5, Kediri" />
            </div>
            <div class="col-12">
                <label class="form-label-custom">Topik yang Ingin Dipelajari</label>
                <input type="text" class="form-control-custom" id="topik"
                    placeholder="Contoh: Trigonometri, Integral, Stoikiometri…" />
            </div>
            <div class="col-12">
                <label class="form-label-custom">Catatan / Permintaan Khusus</label>
                <textarea class="form-control-custom" rows="3" id="catatan"
                    placeholder="Jelaskan kesulitan belajar yang kamu hadapi agar tutor bisa mempersiapkan materi yang tepat…"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button onclick="goStep(2)" class="btn fw-bold px-4 py-2"
                style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </button>
            <button onclick="goStep(4)" class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                Lanjut: Konfirmasi <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- STEP 4: KONFIRMASI --}}
    <div id="panel-4" style="display:none;">
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-clipboard2-check-fill"></i> Konfirmasi Pesanan
                    </div>

                    {{-- Detail Pesanan --}}
                    <div style="background:var(--bg);border-radius:12px;padding:16px;margin-bottom:16px;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                style="width:48px;height:48px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;font-weight:800;">
                                <span id="konfirm-avatar">B</span>
                            </div>
                            <div>
                                <div style="font-size:15px;font-weight:700;color:var(--text);" id="konfirm-tutor">Pak
                                    Budi Santoso</div>
                                <div style="font-size:12px;color:var(--muted);" id="konfirm-mapel">Matematika</div>
                            </div>
                        </div>
                        @php
                        $konfirmRows = [
                        ['bi-calendar3', 'Jadwal', 'konfirm-jadwal', 'Selasa, 8 Apr 2026'],
                        ['bi-clock', 'Waktu', 'konfirm-waktu', '10:00 WIB · 90 Menit'],
                        ['bi-laptop', 'Mode', 'konfirm-mode', 'Online (Zoom/Google Meet)'],
                        ['bi-book', 'Topik', 'konfirm-topik', 'Trigonometri'],
                        ];
                        @endphp
                        @foreach ($konfirmRows as $kr)
                        <div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--border);">
                            <i class="bi {{ $kr[0] }}"
                                style="color:var(--primary);font-size:15px;width:20px;flex-shrink:0;margin-top:1px;"></i>
                            <div style="flex:1;">
                                <span style="font-size:12px;color:var(--muted);">{{ $kr[1] }}</span>
                                <div style="font-size:13px;font-weight:600;color:var(--text);"
                                    id="{{ $kr[2] }}">{{ $kr[3] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:10px;">Metode Pembayaran
                    </div>
                    @php
                    $payMethods = [
                    ['#003087', '#fff', 'BCA', 'Bank BCA', 'Virtual Account', true],
                    ['#00a850', '#fff', 'GP', 'GoPay', 'Dompet Digital', false],
                    ['var(--primary)', '#fff', 'SALDO', 'Saldo Al Ilmi', 'Rp 150.000 tersedia', false],
                    ];
                    @endphp
                    @foreach ($payMethods as $pm)
                    <div style="background:var(--card-bg);border:2px solid {{ $pm[5] ? 'var(--primary)' : 'var(--border)' }};border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;cursor:pointer;margin-bottom:8px;transition:all .2s;{{ $pm[5] ? 'background:#eff6ff;' : '' }}"
                        onclick="selectPayment(this)">
                        <div
                            style="width:44px;height:28px;border-radius:6px;background:{{ $pm[0] }};color:{{ $pm[1] }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;flex-shrink:0;">
                            {{ $pm[2] }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:700;color:var(--text);">{{ $pm[3] }}
                            </div>
                            <div style="font-size:11.5px;color:var(--muted);">{{ $pm[4] }}</div>
                        </div>
                        <div
                            style="width:18px;height:18px;border-radius:50%;border:2px solid {{ $pm[5] ? 'var(--primary)' : 'var(--border)' }};background:{{ $pm[5] ? 'var(--primary)' : 'transparent' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @if ($pm[5])
                            <i class="bi bi-check-lg" style="font-size:10px;color:#fff;"></i>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-between mt-4">
                        <button onclick="goStep(3)" class="btn fw-bold px-4 py-2"
                            style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </button>
                        <button onclick="openSuksesModal()" class="btn fw-bold px-4 py-2"
                            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;box-shadow:0 4px 12px rgba(30,58,95,.3);">
                            <i class="bi bi-send-fill me-1"></i> Kirim Pesanan
                        </button>
                    </div>
                </div>
            </div>

            {{-- RINGKASAN BIAYA --}}
            <div class="col-lg-5">
                <div class="summary-card">
                    <div style="font-size:14px;font-weight:800;color:#fff;margin-bottom:14px;">
                        <i class="bi bi-receipt me-2"></i>Ringkasan Biaya
                    </div>
                    <div class="sc-row">
                        <span class="sc-label">Biaya Sesi (90 mnt)</span>
                        <span class="sc-val" id="biaya-sesi">Rp 75.000</span>
                    </div>
                    <div class="sc-row">
                        <span class="sc-label">Biaya Admin</span>
                        <span class="sc-val">Rp 2.000</span>
                    </div>
                    <div class="sc-row">
                        <span class="sc-label">Diskon Member Pro</span>
                        <span class="sc-val" style="color:var(--accent);">- Rp 2.000</span>
                    </div>
                    <div class="sc-row" style="margin-top:6px;">
                        <span style="font-size:14px;font-weight:800;color:#fff;">TOTAL</span>
                        <span style="font-size:20px;font-weight:800;color:#fff;" id="biaya-total">Rp 75.000</span>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title"><i class="bi bi-shield-check-fill"></i> Jaminan Layanan</div>
                    @php
                    $jaminans = [
                    [
                    'bi-shield-fill-check',
                    'var(--success)',
                    'Pembayaran Aman',
                    'Transaksi terenkripsi SSL',
                    ],
                    [
                    'bi-arrow-repeat',
                    'var(--primary)',
                    'Reschedule Gratis',
                    'Dapat diubah 24 jam sebelum',
                    ],
                    [
                    'bi-star-fill',
                    'var(--accent)',
                    'Tutor Terverifikasi',
                    'Semua tutor sudah terverifikasi',
                    ],
                    ['bi-headset', 'var(--info)', 'Dukungan 24/7', 'CS siap membantu kapanpun'],
                    ];
                    @endphp
                    @foreach ($jaminans as $j)
                    <div
                        style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border);">
                        <i class="bi {{ $j[0] }}"
                            style="color:{{ $j[1] }};font-size:16px;width:20px;flex-shrink:0;"></i>
                        <div>
                            <div style="font-size:12.5px;font-weight:700;color:var(--text);">{{ $j[1] }}
                            </div>
                            <div style="font-size:11.5px;color:var(--muted);">{{ $j[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>{{-- /tab-pesan --}}

{{-- ══ TAB: RIWAYAT PESANAN ══ --}}
<div id="tab-riwayat" style="display:none;">

    {{-- Filter + Export --}}
    <div class="d-flex gap-2 mb-3 flex-wrap align-items-center">
        <div style="position:relative;flex:1;min-width:200px;">
            <i class="bi bi-search"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px;"></i>
            <input type="text" class="form-control-custom" style="padding-left:36px;"
                placeholder="Cari nama tutor, mata pelajaran…" />
        </div>
        <select class="form-control-custom form-select-custom" style="width:auto;">
            <option>Semua Status</option>
            <option>Menunggu Konfirmasi</option>
            <option>Dikonfirmasi</option>
            <option>Selesai</option>
            <option>Dibatalkan</option>
        </select>
        <select class="form-control-custom form-select-custom" style="width:auto;">
            <option>April 2026</option>
            <option>Maret 2026</option>
        </select>
    </div>

    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title">📋 Riwayat Pesanan Les <span>(12 pesanan)</span></div>
            <div class="d-flex gap-2">
                <button onclick="exportExcel()" class="btn btn-sm fw-bold"
                    style="background:var(--success-soft);color:var(--success);border:1.5px solid var(--success);border-radius:8px;font-size:12px;">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i> Excel
                </button>
                <button onclick="exportPDF()" class="btn btn-sm fw-bold"
                    style="background:var(--danger-soft);color:var(--danger);border:1.5px solid var(--danger);border-radius:8px;font-size:12px;">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                </button>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl" id="tabelRiwayat">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tutor</th>
                        <th>Mata Pelajaran</th>
                        <th>Jadwal</th>
                        <th>Durasi</th>
                        <th>Mode</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $pesanans = [
                    [
                    '#PES-2026-0412',
                    'Pak Budi Santoso',
                    'Matematika',
                    '8 Apr 2026, 10:00',
                    '90 mnt',
                    'Online',
                    'Rp 75.000',
                    'dikonfirmasi',
                    'var(--success-soft)',
                    'var(--success)',
                    ],
                    [
                    '#PES-2026-0398',
                    'Bu Sari Dewi',
                    'Fisika',
                    '5 Apr 2026, 14:00',
                    '90 mnt',
                    'Offline',
                    'Rp 90.000',
                    'selesai',
                    '#eff6ff',
                    'var(--primary)',
                    ],
                    [
                    '#PES-2026-0385',
                    'Pak Rizal Hakim',
                    'Kimia',
                    '2 Apr 2026, 09:00',
                    '60 mnt',
                    'Online',
                    'Rp 80.000',
                    'selesai',
                    '#eff6ff',
                    'var(--primary)',
                    ],
                    [
                    '#PES-2026-0371',
                    'Bu Anisa Putri',
                    'Biologi',
                    '28 Mar 2026, 11:00',
                    '90 mnt',
                    'Offline',
                    'Rp 85.000',
                    'selesai',
                    '#eff6ff',
                    'var(--primary)',
                    ],
                    [
                    '#PES-2026-0358',
                    'Pak Budi Santoso',
                    'Matematika',
                    '25 Mar 2026, 10:00',
                    '120 mnt',
                    'Online',
                    'Rp 150.000',
                    'selesai',
                    '#eff6ff',
                    'var(--primary)',
                    ],
                    [
                    '#PES-2026-0340',
                    'Pak Fauzan',
                    'B. Inggris',
                    '20 Mar 2026, 16:00',
                    '60 mnt',
                    'Online',
                    'Rp 70.000',
                    'dibatalkan',
                    'var(--danger-soft)',
                    'var(--danger)',
                    ],
                    ];
                    @endphp
                    @foreach ($pesanans as $p)
                    <tr>
                        <td style="font-weight:700;font-size:12px;">{{ $p[0] }}</td>
                        <td>
                            <div style="font-weight:600;color:var(--text);">{{ $p[1] }}</div>
                        </td>
                        <td>
                            <span
                                style="background:#eff6ff;color:var(--primary);font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px;">{{ $p[2] }}</span>
                        </td>
                        <td style="font-size:12.5px;color:var(--muted);">{{ $p[3] }}</td>
                        <td style="font-size:12.5px;">{{ $p[4] }}</td>
                        <td>
                            <span
                                style="background:{{ $p[5] === 'Online' ? 'var(--info-soft)' : 'var(--success-soft)' }};color:{{ $p[5] === 'Online' ? 'var(--info)' : 'var(--success)' }};font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px;">
                                {{ $p[5] }}
                            </span>
                        </td>
                        <td style="font-weight:700;">{{ $p[6] }}</td>
                        <td>
                            <span class="status-badge"
                                style="background:{{ $p[8] }};color:{{ $p[9] }};">
                                {{ ucfirst($p[7]) }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button onclick="lihatDetail('{{ $p[0] }}')"
                                    style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;">
                                    Detail
                                </button>
                                @if ($p[7] === 'dikonfirmasi')
                                <button
                                    style="border:none;background:var(--danger-soft);color:var(--danger);border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;">
                                    Batal
                                </button>
                                @endif
                                @if ($p[7] === 'selesai')
                                <button
                                    style="border:none;background:var(--accent-soft);color:var(--warning);border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;">
                                    Ulasan
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex align-items-center justify-content-between px-4 py-3"
            style="border-top:1px solid var(--border);">
            <span style="font-size:12.5px;color:var(--muted);">Menampilkan 1–6 dari 12 pesanan</span>
            <div class="d-flex gap-1">
                @foreach (['<i class="bi bi-chevron-left"></i>', '1', '2', '<i class="bi bi-chevron-right"></i>'] as $pg)
                <button
                    style="border-radius:8px;{{ $pg === '1' ? 'background:var(--primary);color:#fff;border:none;' : 'background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);' }}font-size:12px;font-weight:700;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;">{!! $pg !!}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL SUKSES ══ --}}
<div class="modal-overlay" id="modal-sukses">
    <div class="modal-box">
        <div class="modal-body-p" style="text-align:center;padding:36px 28px;">
            <div style="font-size:64px;margin-bottom:14px;">🎉</div>
            <div style="font-size:20px;font-weight:800;margin-bottom:6px;color:var(--text);">Pesanan Terkirim!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.6;">
                Pesanan les privat kamu telah terkirim ke tutor.<br />
                Tunggu konfirmasi dari tutor dalam <strong>1x24 jam</strong>.
            </div>
            <div
                style="background:var(--success-soft);border-radius:12px;padding:16px;margin-bottom:20px;text-align:left;">
                <div style="font-size:12px;color:var(--success);font-weight:700;margin-bottom:8px;">
                    <i class="bi bi-check-circle-fill me-1"></i> Detail Pesanan
                </div>
                <div style="font-size:12.5px;color:var(--success);">
                    ID: <strong>#PES-2026-0413</strong><br />
                    Tutor: <strong id="sukses-tutor">Pak Budi Santoso</strong><br />
                    Jadwal: <strong id="sukses-jadwal">8 Apr 2026 · 10:00 WIB</strong>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
                    onclick="closeModal()">Tutup</button>
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
                    onclick="closeModal();switchTab(document.querySelectorAll('.main-tab')[1],'riwayat')">
                    Lihat Riwayat
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL DETAIL ══ --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal-box">
        <div class="modal-head">
            <h5>📋 Detail Pesanan</h5>
            <button class="modal-close-btn" onclick="closeDetailModal()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-p">
            <div style="background:var(--bg);border-radius:12px;padding:16px;margin-bottom:16px;">
                <div style="font-size:13px;font-weight:700;color:var(--primary);margin-bottom:10px;" id="detail-id">
                    #PES-2026-0412</div>
                @php
                $detailRows = [
                ['bi-person-fill', 'Tutor', 'Pak Budi Santoso'],
                ['bi-book-fill', 'Mata Pelajaran', 'Matematika'],
                ['bi-calendar3', 'Jadwal', '8 April 2026'],
                ['bi-clock-fill', 'Waktu', '10:00 WIB · 90 Menit'],
                ['bi-laptop', 'Mode', 'Online (Zoom/Google Meet)'],
                ['bi-chat-text-fill', 'Topik', 'Trigonometri – Identitas & Persamaan'],
                ['bi-credit-card-fill', 'Biaya', 'Rp 75.000'],
                ['bi-shield-check-fill', 'Status', 'Dikonfirmasi'],
                ];
                @endphp
                @foreach ($detailRows as $dr)
                <div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--border);">
                    <i class="bi {{ $dr[0] }}"
                        style="color:var(--primary);font-size:14px;width:18px;flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <div style="font-size:11px;color:var(--muted);">{{ $dr[1] }}</div>
                        <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $dr[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex gap-2">
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
                    onclick="closeDetailModal()">Tutup</button>
                <button onclick="exportSinglePDF()" class="btn fw-bold flex-fill py-2"
                    style="background:var(--danger);color:#fff;border-radius:10px;border:none;font-size:13px;">
                    <i class="bi bi-printer-fill me-1"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- SheetJS untuk Excel --}}
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
{{-- jsPDF untuk PDF --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
    // ── STATE ──
    let selectedTutor = null;
    let selectedSlot = null;
    let currentStep = 1;

    // ── TABS ──
    function switchTab(el, id) {
        document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('tab-pesan').style.display = id === 'pesan' ? '' : 'none';
        document.getElementById('tab-riwayat').style.display = id === 'riwayat' ? '' : 'none';
    }

    // ── STEP ──
    function goStep(step) {
        currentStep = step;
        for (let i = 1; i <= 4; i++) {
            const panel = document.getElementById('panel-' + i);
            if (panel) panel.style.display = i === step ? '' : 'none';
            const si = document.getElementById('step-' + i);
            if (si) {
                si.classList.remove('active', 'done');
                if (i < step) si.classList.add('done');
                else if (i === step) si.classList.add('active');
            }
        }
        // Update konfirmasi di step 4
        if (step === 4) updateKonfirmasi();
    }

    // ── PILIH TUTOR ──
    // SESUDAH
    function selectTutor(el) {
        document.querySelectorAll('.tutor-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        selectedTutor = {
            id: el.dataset.id,
            name: el.dataset.name,
            mapel: el.dataset.mapel,
            harga: parseInt(el.dataset.harga),
            mode: el.dataset.mode,
            avatar: el.dataset.name.trim()[0].toUpperCase()
        };

        // Update ringkasan biaya
        document.getElementById('biaya-sesi').textContent =
            'Rp ' + parseInt(el.dataset.harga).toLocaleString('id-ID');
        document.getElementById('biaya-total').textContent =
            'Rp ' + parseInt(el.dataset.harga).toLocaleString('id-ID');
    }

    function filterTutor() {
        const q = document.getElementById('searchTutor').value.toLowerCase();
        const mapel = document.getElementById('filterMapel').value.toLowerCase();
        document.querySelectorAll('.tutor-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const mp = card.dataset.mapel.toLowerCase();
            const match = (!q || name.includes(q)) && (!mapel || mp.includes(mapel));
            card.style.display = match ? '' : 'none';
        });
    }

    // ── PILIH SLOT ──
    function selectSlot(el, slot) {
        document.querySelectorAll('.slot-btn:not(.taken)').forEach(s => s.classList.remove('selected'));
        el.classList.add('selected');
        selectedSlot = slot;
    }

    function updateSlots() {
        /* bisa dikembangkan untuk fetch slot dari server */
    }

    // ── UPDATE KONFIRMASI ──
    function updateKonfirmasi() {
        if (selectedTutor) {
            document.getElementById('konfirm-tutor').textContent = selectedTutor.name;
            document.getElementById('konfirm-mapel').textContent = selectedTutor.mapel;
            document.getElementById('konfirm-avatar').textContent = selectedTutor.avatar;
            document.getElementById('sukses-tutor').textContent = selectedTutor.name;
        }
        const tgl = document.getElementById('tglPilih')?.value;
        const dur = document.getElementById('durasi')?.value;
        if (tgl && selectedSlot) {
            const fmt = new Date(tgl).toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
            document.getElementById('konfirm-jadwal').textContent = fmt;
            document.getElementById('konfirm-waktu').textContent = selectedSlot + ' WIB · ' + (dur || 90) + ' Menit';
            document.getElementById('sukses-jadwal').textContent = fmt + ' · ' + selectedSlot + ' WIB';
        }
        const topik = document.getElementById('topik')?.value;
        if (topik) document.getElementById('konfirm-topik').textContent = topik || '–';
        const mode = document.getElementById('selectMode')?.value;
        if (mode) document.getElementById('konfirm-mode').textContent = mode === 'online' ?
            'Online (Zoom/Google Meet)' : 'Offline (Tatap Muka)';
    }

    // ── SHOW/HIDE ALAMAT ──
    document.addEventListener('DOMContentLoaded', () => {
        const modeSelect = document.getElementById('selectMode');
        if (modeSelect) {
            modeSelect.addEventListener('change', function() {
                document.getElementById('alamatWrap').style.display = this.value === 'offline' ? '' :
                    'none';
            });
        }
    });

    // ── PAYMENT SELECT ──
    function selectPayment(el) {
        document.querySelectorAll('#panel-4 [onclick="selectPayment(this)"]').forEach(c => {
            c.style.border = '2px solid var(--border)';
            c.style.background = 'var(--card-bg)';
            c.querySelector('div:last-child').style.background = 'transparent';
            c.querySelector('div:last-child').style.borderColor = 'var(--border)';
            c.querySelector('div:last-child').innerHTML = '';
        });
        el.style.border = '2px solid var(--primary)';
        el.style.background = '#eff6ff';
        const check = el.querySelector('div:last-child');
        check.style.background = 'var(--primary)';
        check.style.borderColor = 'var(--primary)';
        check.innerHTML = '<i class="bi bi-check-lg" style="font-size:10px;color:#fff;"></i>';
    }

    // ── MODAL ──
    function openSuksesModal() {
        updateKonfirmasi();
        document.getElementById('modal-sukses').classList.add('show');
    }

    function closeModal() {
        document.getElementById('modal-sukses').classList.remove('show');
    }

    function lihatDetail(id) {
        document.getElementById('detail-id').textContent = id;
        document.getElementById('modal-detail').classList.add('show');
    }

    function closeDetailModal() {
        document.getElementById('modal-detail').classList.remove('show');
    }

    // ── EXPORT EXCEL ──
    function exportExcel() {
        const rows = [
            ['ID Pesanan', 'Tutor', 'Mata Pelajaran', 'Jadwal', 'Durasi', 'Mode', 'Biaya', 'Status'],
            ['#PES-2026-0412', 'Pak Budi Santoso', 'Matematika', '8 Apr 2026, 10:00', '90 mnt', 'Online',
                'Rp 75.000', 'Dikonfirmasi'
            ],
            ['#PES-2026-0398', 'Bu Sari Dewi', 'Fisika', '5 Apr 2026, 14:00', '90 mnt', 'Offline', 'Rp 90.000',
                'Selesai'
            ],
            ['#PES-2026-0385', 'Pak Rizal Hakim', 'Kimia', '2 Apr 2026, 09:00', '60 mnt', 'Online', 'Rp 80.000',
                'Selesai'
            ],
            ['#PES-2026-0371', 'Bu Anisa Putri', 'Biologi', '28 Mar 2026, 11:00', '90 mnt', 'Offline', 'Rp 85.000',
                'Selesai'
            ],
            ['#PES-2026-0358', 'Pak Budi Santoso', 'Matematika', '25 Mar 2026, 10:00', '120 mnt', 'Online',
                'Rp 150.000', 'Selesai'
            ],
            ['#PES-2026-0340', 'Pak Fauzan', 'B. Inggris', '20 Mar 2026, 16:00', '60 mnt', 'Online', 'Rp 70.000',
                'Dibatalkan'
            ],
        ];

        const ws = XLSX.utils.aoa_to_sheet(rows);

        // Style lebar kolom
        ws['!cols'] = [{
            wch: 18
        }, {
            wch: 22
        }, {
            wch: 16
        }, {
            wch: 22
        }, {
            wch: 10
        }, {
            wch: 10
        }, {
            wch: 12
        }, {
            wch: 16
        }];

        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Riwayat Pesanan');
        XLSX.writeFile(wb, 'Riwayat_Pesanan_Les_AlIlmiCenter.xlsx');
    }

    // ── EXPORT PDF ──
    function exportPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'landscape'
        });

        // Header
        doc.setFillColor(30, 58, 95);
        doc.rect(0, 0, 297, 30, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        doc.text('Al Ilmi Center', 14, 13);
        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text('Riwayat Pesanan Jadwal Les', 14, 22);
        doc.text('Dicetak: ' + new Date().toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }), 200, 22);

        doc.setTextColor(0, 0, 0);

        doc.autoTable({
            startY: 36,
            head: [
                ['ID Pesanan', 'Tutor', 'Mata Pelajaran', 'Jadwal', 'Durasi', 'Mode', 'Biaya', 'Status']
            ],
            body: [
                ['#PES-2026-0412', 'Pak Budi Santoso', 'Matematika', '8 Apr 2026, 10:00', '90 mnt',
                    'Online', 'Rp 75.000', 'Dikonfirmasi'
                ],
                ['#PES-2026-0398', 'Bu Sari Dewi', 'Fisika', '5 Apr 2026, 14:00', '90 mnt', 'Offline',
                    'Rp 90.000', 'Selesai'
                ],
                ['#PES-2026-0385', 'Pak Rizal Hakim', 'Kimia', '2 Apr 2026, 09:00', '60 mnt', 'Online',
                    'Rp 80.000', 'Selesai'
                ],
                ['#PES-2026-0371', 'Bu Anisa Putri', 'Biologi', '28 Mar 2026, 11:00', '90 mnt', 'Offline',
                    'Rp 85.000', 'Selesai'
                ],
                ['#PES-2026-0358', 'Pak Budi Santoso', 'Matematika', '25 Mar 2026, 10:00', '120 mnt',
                    'Online', 'Rp 150.000', 'Selesai'
                ],
                ['#PES-2026-0340', 'Pak Fauzan', 'B. Inggris', '20 Mar 2026, 16:00', '60 mnt', 'Online',
                    'Rp 70.000', 'Dibatalkan'
                ],
            ],
            styles: {
                fontSize: 9,
                cellPadding: 5
            },
            headStyles: {
                fillColor: [30, 58, 95],
                textColor: [255, 255, 255],
                fontStyle: 'bold'
            },
            alternateRowStyles: {
                fillColor: [240, 246, 255]
            },
            columnStyles: {
                6: {
                    halign: 'right'
                },
                7: {
                    fontStyle: 'bold'
                }
            },
            didParseCell: function(data) {
                if (data.column.index === 7 && data.section === 'body') {
                    const val = data.cell.raw;
                    if (val === 'Dikonfirmasi') data.cell.styles.textColor = [22, 163, 74];
                    else if (val === 'Dibatalkan') data.cell.styles.textColor = [220, 38, 38];
                    else data.cell.styles.textColor = [30, 58, 95];
                }
            }
        });

        // Footer
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(8);
            doc.setTextColor(150);
            doc.text(`Halaman ${i} dari ${pageCount}`, 14, doc.internal.pageSize.height - 8);
            doc.text('Al Ilmi Center © 2026', 230, doc.internal.pageSize.height - 8);
        }

        doc.save('Riwayat_Pesanan_Les_AlIlmiCenter.pdf');
    }

    // ── CETAK DETAIL SINGLE ──
    function exportSinglePDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        doc.setFillColor(30, 58, 95);
        doc.rect(0, 0, 210, 30, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.text('Al Ilmi Center', 14, 14);
        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text('Detail Pesanan Les Privat', 14, 23);

        doc.setTextColor(0, 0, 0);
        doc.setFontSize(12);
        doc.setFont('helvetica', 'bold');
        doc.text(document.getElementById('detail-id').textContent, 14, 42);

        const details = [
            ['Tutor', 'Pak Budi Santoso'],
            ['Mata Pelajaran', 'Matematika'],
            ['Jadwal', '8 April 2026'],
            ['Waktu', '10:00 WIB · 90 Menit'],
            ['Mode', 'Online (Zoom/Google Meet)'],
            ['Topik', 'Trigonometri – Identitas & Persamaan'],
            ['Biaya', 'Rp 75.000'],
            ['Status', 'Dikonfirmasi'],
        ];

        doc.autoTable({
            startY: 48,
            body: details,
            styles: {
                fontSize: 11,
                cellPadding: 6
            },
            columnStyles: {
                0: {
                    fontStyle: 'bold',
                    fillColor: [240, 246, 255],
                    textColor: [30, 58, 95],
                    cellWidth: 55
                },
                1: {
                    cellWidth: 120
                }
            },
            theme: 'plain',
            alternateRowStyles: {
                fillColor: [248, 250, 255]
            }
        });

        doc.setFontSize(8);
        doc.setTextColor(150);
        doc.text('Dicetak oleh Al Ilmi Center · ' + new Date().toLocaleDateString('id-ID'), 14, doc.internal.pageSize
            .height - 10);

        doc.save('Detail_Pesanan_AlIlmiCenter.pdf');
        closeDetailModal();
    }
</script>
@endpush