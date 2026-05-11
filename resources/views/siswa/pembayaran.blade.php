@php
    // TEMPORARY DUMMY DATA - hapus setelah backend fix
    if (!isset($tagihan)) {
        $tagihan = collect([
            (object) [
                'id' => 'abc12345-xxxx',
                'mata_pelajaran' => 'Matematika',
                'topik' => 'Trigonometri',
                'jadwal' => now()->addDays(2),
                'durasi_menit' => 90,
                'harga' => 150000,
                'tutor' => (object) ['name' => 'Pak Budi'],
                'mode_label' => 'Offline', // ← ganti jadi property
            ],
        ]);
    }
    if (!isset($riwayat)) {
        $riwayat = collect([
            (object) [
                'id' => 'def67890-xxxx',
                'jumlah' => 150000,
                'status' => 'dikonfirmasi',
                'created_at' => now()->subDays(5),
                'bukti_transfer' => null,
                'catatan_tutor' => null,
                'lesPrivat' => (object) ['mata_pelajaran' => 'Fisika', 'topik' => 'Gerak Parabola'],
                'tutor' => (object) ['name' => 'Pak Budi'],
                'rekening' => (object) ['nama_bank' => 'Bank BCA', 'nomor_rekening' => '1234567890'],
            ],
        ]);
    }
    if (!isset($rekening)) {
        $rekening = collect([
            (object) [
                'id' => 1,
                'nama_bank' => 'Bank BCA',
                'nomor_rekening' => '1234567890',
                'atas_nama' => 'Al Ilmi Center',
            ],
            (object) [
                'id' => 2,
                'nama_bank' => 'Bank BRI',
                'nomor_rekening' => '0987654321',
                'atas_nama' => 'Al Ilmi Center',
            ],
        ]);
    }
@endphp

@extends('layouts.app')


@section('title', 'Pembayaran - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Pembayaran')
@section('page-sub', 'Dashboard / Pembayaran')

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

        /* ── TAGIHAN CARD ── */
        .tagihan-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 16px;
            transition: box-shadow .2s;
        }

        .tagihan-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, .07);
        }

        .tagihan-card.urgent {
            border-color: #fca5a5;
        }

        .th-header {
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
        }

        .th-header.urgent {
            background: #fef2f2;
        }

        .th-header.normal {
            background: #f8faff;
        }

        .th-id {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
        }

        .th-body {
            padding: 16px 18px;
        }

        .th-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            flex-wrap: wrap;
        }

        .th-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .th-info {
            flex: 1;
            min-width: 160px;
        }

        .th-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .th-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        .th-amount {
            text-align: right;
            flex-shrink: 0;
        }

        .th-amount .amount-val {
            font-size: 20px;
            font-weight: 800;
        }

        .th-footer {
            padding: 12px 18px;
            background: var(--bg);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
        }

        /* ── REKENING CARD ── */
        .rek-card {
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 10px;
        }

        .rek-card:hover {
            border-color: var(--primary-light);
        }

        .rek-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .rek-logo {
            width: 52px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .rek-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .rek-norek {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .btn-copy {
            border: none;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 6px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .rek-check {
            margin-left: auto;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .rek-card.selected .rek-check {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* ── UPLOAD ZONE ── */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: var(--bg);
        }

        .upload-zone:hover {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .upload-zone.has-file {
            border-color: var(--success);
            background: var(--success-soft);
        }

        /* ── RIWAYAT ── */
        .riwayat-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .riwayat-item:last-child {
            border-bottom: none;
        }

        .ri-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .ri-val {
            font-size: 15px;
            font-weight: 800;
        }

        .ri-status {
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            margin-top: 3px;
            display: inline-block;
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
            max-width: 500px;
            max-height: 92vh;
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
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .form-label-custom {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            color: var(--text);
            outline: none;
            transition: border .2s;
            background: #fff;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
        }

        /* CARD BOX */
        .card-box {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
        }

        .card-box-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-box-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .card-box-title i {
            color: var(--primary);
            margin-right: 6px;
        }

        /* PRINT */
        @media print {

            .sidebar,
            .topbar,
            .main-tabs,
            .no-print {
                display: none !important;
            }

            .main-wrap {
                margin-left: 0 !important;
            }

            .content {
                padding: 0 !important;
            }

            .card-box,
            .tagihan-card {
                break-inside: avoid;
            }
        }

        /* RESPONSIVE */
        @media(max-width:767px) {
            .main-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .main-tab {
                min-width: 110px;
                flex: none;
                font-size: 12px;
            }

            .th-row {
                flex-direction: column;
            }

            .th-amount {
                text-align: left;
                width: 100%;
            }

            .th-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .riwayat-item {
                flex-wrap: wrap;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ALERT --}}
    @if (session('sukses'))
        <div
            style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
            <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:18px;"></i>
            <span style="font-size:13px;font-weight:600;color:var(--success);">{{ session('sukses') }}</span>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex align-items-start justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">💳 Pembayaran</h4>
            <div style="font-size:13px;color:var(--muted);">
                Dashboard / <span style="color:var(--primary);font-weight:600;">Pembayaran</span>
            </div>
        </div>
        <button onclick="window.print()" class="btn btn-sm fw-bold px-3 py-2 no-print"
            style="background:var(--danger-soft);color:var(--danger);border-radius:10px;border:1.5px solid var(--danger);font-size:12px;">
            <i class="bi bi-printer-fill me-1"></i> Cetak
        </button>
    </div>

    {{-- TABS --}}
    <div class="main-tabs no-print">
        <button class="main-tab active" onclick="switchTab(this,'tagihan')">
            <i class="bi bi-receipt me-1"></i> Tagihan
            @if ($tagihan->count() > 0)
                <span
                    style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">{{ $tagihan->count() }}</span>
            @endif
        </button>
        <button class="main-tab" onclick="switchTab(this,'riwayat')">
            <i class="bi bi-clock-history me-1"></i> Riwayat
        </button>
    </div>

    {{-- ══ TAB TAGIHAN ══ --}}
    <div id="tab-tagihan">

        @forelse($tagihan as $t)
            <div class="tagihan-card {{ now()->diffInHours($t->jadwal) < 24 ? 'urgent' : '' }}">
                <div class="th-header {{ now()->diffInHours($t->jadwal) < 24 ? 'urgent' : 'normal' }}">
                    <span class="th-id">#LES-{{ strtoupper(substr($t->id, 0, 8)) }}</span>
                    <span class="status-badge" style="background:var(--danger-soft);color:var(--danger);">
                        <i class="bi bi-clock-fill"></i> Belum Dibayar
                    </span>
                </div>
                <div class="th-body">
                    <div class="th-row">
                        <div class="th-icon" style="background:#eff6ff;color:var(--primary);">
                            <i class="bi bi-person-video3"></i>
                        </div>
                        <div class="th-info">
                            <div class="th-title">
                                Les Privat – {{ $t->mata_pelajaran }}
                                {{ $t->topik ? '(' . $t->topik . ')' : '' }}
                            </div>
                            <div class="th-sub">
                                <i class="bi bi-person-fill me-1"></i>{{ $t->tutor->name ?? '-' }}
                            </div>
                            <div class="th-sub">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $t->jadwal->translatedFormat('l, d M Y · H:i') }} WIB
                                {{-- · {{ $t->durasi_menit }} mnt · {{ $t->getModeLabel() }} --}}
                                · {{ $t->durasi_menit }} mnt ·
                                {{ method_exists($t, 'getModeLabel') ? $t->getModeLabel() : $t->mode_label ?? 'Offline' }}
                            </div>
                        </div>
                        <div class="th-amount">
                            <div class="amount-val" style="color:var(--danger);">Rp
                                {{ number_format($t->harga, 0, ',', '.') }}</div>
                            <div style="font-size:11px;color:var(--muted);">Belum Lunas</div>
                        </div>
                    </div>
                </div>
                <div class="th-footer">
                    <div style="font-size:12px;color:var(--muted);">
                        <i class="bi bi-shield-check me-1"></i> Bayar via transfer bank ke rekening Al Ilmi Center
                    </div>
                    <button
                        onclick="openModalBayar('{{ $t->id }}','{{ $t->mata_pelajaran }}','{{ number_format($t->harga, 0, ',', '.') }}','{{ $t->tutor->name ?? '' }}')"
                        class="btn btn-sm fw-bold"
                        style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;padding:8px 20px;box-shadow:0 4px 12px rgba(30,58,95,.3);">
                        <i class="bi bi-send-fill me-1"></i> Bayar Sekarang
                    </button>
                </div>
            </div>
        @empty
            <div
                style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
                <i class="bi bi-check-circle"
                    style="font-size:2.5rem;color:var(--success);display:block;margin-bottom:10px;"></i>
                <div style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:4px;">Semua Tagihan Lunas! 🎉
                </div>
                <div style="font-size:13px;">Tidak ada tagihan yang perlu dibayar saat ini.</div>
            </div>
        @endforelse
    </div>

    {{-- ══ TAB RIWAYAT ══ --}}
    <div id="tab-riwayat" style="display:none;">

        {{-- STAT RINGKASAN --}}
        <div class="row g-3 mb-4">
            @php
                $totalLunas = $riwayat->where('status', 'dikonfirmasi')->sum('jumlah');
                $totalDitolak = $riwayat->where('status', 'ditolak')->count();
                $totalMenunggu = $riwayat->where('status', 'menunggu_verifikasi')->count();
            @endphp
            <div class="col-6 col-md-4">
                <div
                    style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:16px;text-align:center;">
                    <div style="font-size:1.4rem;font-weight:800;color:var(--success);">Rp
                        {{ number_format($totalLunas / 1000, 0) }}rb</div>
                    <div style="font-size:12px;color:var(--muted);">Total Terbayar</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div
                    style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:16px;text-align:center;">
                    <div style="font-size:1.4rem;font-weight:800;color:var(--primary);">{{ $riwayat->count() }}</div>
                    <div style="font-size:12px;color:var(--muted);">Total Transaksi</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div
                    style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:16px;text-align:center;">
                    <div style="font-size:1.4rem;font-weight:800;color:var(--danger);">{{ $totalDitolak }}</div>
                    <div style="font-size:12px;color:var(--muted);">Ditolak</div>
                </div>
            </div>
        </div>

        {{-- TABEL RIWAYAT --}}
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-clock-history"></i> Riwayat Pembayaran</div>
                <button onclick="window.print()" class="btn btn-sm no-print"
                    style="background:var(--danger-soft);color:var(--danger);border:1.5px solid var(--danger);border-radius:8px;font-size:12px;font-weight:600;">
                    <i class="bi bi-printer-fill me-1"></i> Cetak
                </button>
            </div>

            @if ($riwayat->count() > 0)
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:var(--bg);">
                                @foreach (['ID', 'Layanan', 'Tutor', 'Bank', 'Jumlah', 'Status', 'Tanggal', 'Aksi'] as $h)
                                    <th
                                        style="padding:10px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border);white-space:nowrap;">
                                        {{ $h }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayat as $r)
                                <tr onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background=''">
                                    <td
                                        style="padding:11px 14px;font-size:12px;font-weight:700;border-bottom:1px solid var(--border);color:var(--primary);">
                                        #{{ strtoupper(substr($r->id, 0, 8)) }}
                                    </td>
                                    <td style="padding:11px 14px;font-size:13px;border-bottom:1px solid var(--border);">
                                        {{ $r->lesPrivat->mata_pelajaran ?? '-' }}
                                        @if ($r->lesPrivat->topik ?? false)
                                            <div style="font-size:11px;color:var(--muted);">{{ $r->lesPrivat->topik }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding:11px 14px;font-size:13px;border-bottom:1px solid var(--border);">
                                        {{ $r->tutor->name ?? '-' }}
                                    </td>
                                    <td style="padding:11px 14px;font-size:12.5px;border-bottom:1px solid var(--border);">
                                        {{ $r->rekening->nama_bank ?? '-' }}<br />
                                        <span
                                            style="color:var(--muted);font-size:11px;">{{ $r->rekening->nomor_rekening ?? '' }}</span>
                                    </td>
                                    <td
                                        style="padding:11px 14px;font-size:13px;font-weight:700;border-bottom:1px solid var(--border);">
                                        Rp {{ number_format($r->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td style="padding:11px 14px;border-bottom:1px solid var(--border);">
                                        @if ($r->status === 'dikonfirmasi')
                                            <span
                                                style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;">
                                                <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Lunas
                                            </span>
                                        @elseif($r->status === 'menunggu_verifikasi')
                                            <span
                                                style="background:var(--accent-soft);color:var(--warning);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                                ⏳ Menunggu
                                            </span>
                                        @else
                                            <span
                                                style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        style="padding:11px 14px;font-size:12px;color:var(--muted);border-bottom:1px solid var(--border);">
                                        {{ $r->created_at->format('d M Y') }}
                                    </td>
                                    <td style="padding:11px 14px;border-bottom:1px solid var(--border);">
                                        @if ($r->bukti_transfer)
                                            <a href="{{ asset('storage/' . $r->bukti_transfer) }}" target="_blank"
                                                style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:600;cursor:pointer;text-decoration:none;">
                                                <i class="bi bi-image me-1"></i>Bukti
                                            </a>
                                        @endif
                                        @if ($r->status === 'ditolak' && $r->catatan_tutor)
                                            <div style="font-size:11px;color:var(--danger);margin-top:3px;">
                                                <i class="bi bi-info-circle me-1"></i>{{ $r->catatan_tutor }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center;padding:40px;color:var(--muted);">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                    Belum ada riwayat pembayaran.
                </div>
            @endif
        </div>
    </div>

    {{-- ══ MODAL BAYAR ══ --}}
    <div class="modal-overlay" id="modal-bayar">
        <div class="modal-box">
            <div class="modal-head">
                <h5><i class="bi bi-credit-card-fill me-2" style="color:var(--primary);"></i>Bayar Tagihan</h5>
                <button class="modal-close-btn" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div style="padding:20px 22px;">

                {{-- Detail tagihan --}}
                <div style="background:var(--bg);border-radius:12px;padding:14px 16px;margin-bottom:18px;">
                    <div style="font-size:12px;color:var(--muted);margin-bottom:6px;">Detail Tagihan</div>
                    <div style="font-size:14px;font-weight:700;color:var(--text);" id="modal-layanan">-</div>
                    <div style="font-size:12.5px;color:var(--muted);" id="modal-tutor">-</div>
                    <div style="font-size:18px;font-weight:800;color:var(--primary);margin-top:8px;" id="modal-jumlah">-
                    </div>
                </div>

                <form action="/siswa/pembayaran/kirim" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="les_privat_id" id="modal-les-id" />

                    {{-- PILIH REKENING --}}
                    <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:10px;">
                        1️⃣ Pilih Rekening Tujuan Transfer
                    </div>

                    @foreach ($rekening as $rek)
                        <label style="display:block;cursor:pointer;">
                            <input type="radio" name="rekening_id" value="{{ $rek->id }}" style="display:none;"
                                required class="rek-radio" />
                            <div class="rek-card" onclick="selectRek(this)">
                                <div class="rek-logo"
                                    style="background:{{ $rek->nama_bank === 'Bank BCA' ? '#003087' : ($rek->nama_bank === 'Bank BRI' ? '#004ea8' : '#005e97') }};color:#fff;">
                                    {{ strtoupper(str_replace(['Bank ', 'bank '], '', $rek->nama_bank)) }}
                                </div>
                                <div style="flex:1;">
                                    <div class="rek-name">{{ $rek->nama_bank }}</div>
                                    <div class="rek-norek">
                                        {{ $rek->nomor_rekening }}
                                        <button type="button" class="btn-copy"
                                            onclick="event.stopPropagation();copyText('{{ $rek->nomor_rekening }}')">
                                            <i class="bi bi-clipboard me-1"></i>Salin
                                        </button>
                                    </div>
                                    <div style="font-size:11px;color:var(--muted);">a.n. {{ $rek->atas_nama }}</div>
                                </div>
                                <div class="rek-check">
                                    <i class="bi bi-check-lg" style="font-size:11px;display:none;"></i>
                                </div>
                            </div>
                        </label>
                    @endforeach

                    {{-- INSTRUKSI --}}
                    <div
                        style="background:var(--accent-soft);border:1px solid var(--accent);border-radius:10px;padding:12px 14px;margin:14px 0;font-size:12.5px;color:#92400e;">
                        <div style="font-weight:700;margin-bottom:4px;"><i class="bi bi-info-circle me-1"></i>Cara
                            Pembayaran:</div>
                        <ol style="margin:0;padding-left:16px;line-height:1.8;">
                            <li>Pilih rekening tujuan transfer di atas</li>
                            <li>Transfer sesuai jumlah tagihan (pastikan nominal tepat)</li>
                            <li>Foto/screenshot bukti transfer</li>
                            <li>Upload bukti di bawah lalu klik Kirim</li>
                            <li>Tunggu konfirmasi dari tutor (maks 1x24 jam)</li>
                        </ol>
                    </div>

                    {{-- UPLOAD BUKTI --}}
                    <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:10px;">
                        2️⃣ Upload Bukti Transfer
                    </div>
                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('buktiFile').click()">
                        <div style="font-size:2rem;color:var(--muted);margin-bottom:8px;" id="uploadIcon">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                        </div>
                        <div style="font-size:13px;" id="uploadText">
                            <strong style="color:var(--primary);">Klik untuk upload foto</strong><br />
                            <span style="font-size:12px;color:var(--muted);">JPG, PNG – Maks. 2MB</span>
                        </div>
                        <input type="file" id="buktiFile" name="bukti_transfer"
                            accept="image/jpg,image/jpeg,image/png" style="display:none;" required
                            onchange="previewFile(this)" />
                    </div>

                    {{-- PREVIEW --}}
                    <div id="previewWrap" style="display:none;margin-top:10px;text-align:center;">
                        <img id="previewImg"
                            style="max-width:100%;max-height:200px;border-radius:10px;border:1.5px solid var(--success);" />
                        <div style="font-size:12px;color:var(--success);margin-top:4px;">
                            <i class="bi bi-check-circle-fill me-1"></i><span id="previewName"></span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn fw-bold flex-fill py-2"
                            style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
                            onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn fw-bold flex-fill py-2"
                            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;box-shadow:0 4px 12px rgba(30,58,95,.3);">
                            <i class="bi bi-send-fill me-1"></i> Kirim Bukti Bayar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function switchTab(el, id) {
            document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('tab-tagihan').style.display = id === 'tagihan' ? '' : 'none';
            document.getElementById('tab-riwayat').style.display = id === 'riwayat' ? '' : 'none';
        }

        function openModalBayar(lesId, layanan, jumlah, tutor) {
            document.getElementById('modal-les-id').value = lesId;
            document.getElementById('modal-layanan').textContent = 'Les Privat – ' + layanan;
            document.getElementById('modal-tutor').textContent = 'Tutor: ' + tutor;
            document.getElementById('modal-jumlah').textContent = 'Rp ' + jumlah;
            document.getElementById('modal-bayar').classList.add('show');
        }

        function closeModal() {
            document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
        }

        function selectRek(el) {
            document.querySelectorAll('.rek-card').forEach(c => {
                c.classList.remove('selected');
                const icon = c.querySelector('.rek-check i');
                if (icon) icon.style.display = 'none';
                const rc = c.querySelector('.rek-check');
                if (rc) {
                    rc.style.background = '';
                    rc.style.borderColor = 'var(--border)';
                }
            });
            el.classList.add('selected');
            const check = el.querySelector('.rek-check');
            if (check) {
                check.style.background = 'var(--primary)';
                check.style.borderColor = 'var(--primary)';
                const icon = check.querySelector('i');
                if (icon) icon.style.display = '';
            }
            // Centang radio
            const label = el.closest('label');
            if (label) {
                const radio = label.querySelector('.rek-radio');
                if (radio) radio.checked = true;
            }
        }

        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = event.target.closest('.btn-copy');
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check me-1"></i>Tersalin!';
                btn.style.background = 'var(--success-soft)';
                btn.style.color = 'var(--success)';
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.style.background = '';
                    btn.style.color = '';
                }, 2000);
            });
        }

        function previewFile(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('previewName').textContent = file.name;
                    document.getElementById('previewWrap').style.display = '';
                    document.getElementById('uploadZone').classList.add('has-file');
                    document.getElementById('uploadIcon').innerHTML =
                        '<i class="bi bi-check-circle-fill" style="color:var(--success);"></i>';
                    document.getElementById('uploadText').innerHTML =
                        '<strong style="color:var(--success);">File siap dikirim</strong><br/><span style="font-size:12px;color:var(--muted);">Klik untuk ganti foto</span>';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
