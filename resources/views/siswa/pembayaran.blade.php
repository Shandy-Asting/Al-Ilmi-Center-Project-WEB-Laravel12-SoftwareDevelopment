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
        @if (($jumlahNotifBelumDibaca ?? 0) > 0)
            <span class="nav-badge">{{ $jumlahNotifBelumDibaca }}</span>
        @endif
    </a>
    <a href="/siswa/profil" class="nav-item-custom {{ request()->is('siswa/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
    <style>
        /* ───────────────────────────────
           ROOT / RESET
        ─────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        /* ───────────────────────────────
           PAGE HEADER
        ─────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .page-header h4 {
            font-size: clamp(16px, 4vw, 20px);
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--text);
            line-height: 1.2;
        }

        .page-header p {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
        }

        .btn-print {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            border: 1.5px solid var(--danger);
            background: var(--danger-soft);
            color: var(--danger);
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
        }

        .btn-print:hover {
            background: var(--danger);
            color: #fff;
        }

        /* ───────────────────────────────
           STAT GRID
        ─────────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        @media (max-width: 767px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 12px;
            text-align: center;
        }

        .stat-val {
            font-size: clamp(18px, 4vw, 22px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 5px;
            word-break: break-word;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            font-weight: 600;
            line-height: 1.3;
        }

        /* ───────────────────────────────
           TABS
        ─────────────────────────────── */
        .main-tabs {
            display: flex;
            gap: 6px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 5px;
            margin-bottom: 20px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .main-tabs::-webkit-scrollbar {
            display: none;
        }

        .main-tab {
            flex: 1;
            min-width: 120px;
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
            white-space: nowrap;
        }

        .main-tab.active {
            background: var(--primary);
            color: #fff;
        }

        .main-tab:hover:not(.active) {
            background: var(--bg);
            color: var(--primary);
        }

        .tab-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 20px;
            margin-left: 4px;
        }

        /* ───────────────────────────────
           TAGIHAN CARD
        ─────────────────────────────── */
        .tagihan-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 14px;
            transition: box-shadow .2s;
        }

        .tagihan-card:hover {
            box-shadow: 0 6px 24px rgba(0, 0, 0, .08);
        }

        .tagihan-card.urgent {
            border-color: #fca5a5;
        }

        /* Header */
        .th-header {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
            border-bottom: 1px solid var(--border);
        }

        .th-header.urgent {
            background: #fef2f2;
        }

        .th-header.normal {
            background: #f8faff;
        }

        .th-id {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .urgency-badge {
            background: var(--danger-soft);
            color: var(--danger);
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Body */
        .th-body {
            padding: 14px 16px;
        }

        .th-row {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .th-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            background: #eff6ff;
            color: var(--primary);
        }

        .th-info {
            flex: 1;
            min-width: 0;
        }

        .th-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.3;
            word-break: break-word;
        }

        .th-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .th-sub i {
            flex-shrink: 0;
        }

        /* Amount — always below info on mobile */
        .th-amount {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
        }

        .amount-val {
            font-size: 20px;
            font-weight: 800;
        }

        .amount-label {
            font-size: 11px;
            color: var(--muted);
        }

        /* Desktop: amount on right */
        @media (min-width: 576px) {
            .th-row {
                align-items: flex-start;
            }

            .th-amount-desktop {
                text-align: right;
                flex-shrink: 0;
                margin-left: auto;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            .th-amount-mobile {
                display: none;
            }

            .th-amount-desktop {
                display: flex;
            }
        }

        @media (max-width: 575px) {
            .th-amount-desktop {
                display: none;
            }

            .th-amount-mobile {
                display: flex;
            }
        }

        /* Footer */
        .th-footer {
            padding: 10px 16px;
            background: var(--bg);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .th-footer-hint {
            font-size: 11.5px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 5px;
            flex: 1;
            min-width: 0;
        }

        .btn-bayar {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            background: var(--primary);
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 58, 95, .25);
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-bayar:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .waiting-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--warning);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 2.5rem;
            color: var(--success);
            margin-bottom: 10px;
        }

        .empty-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .empty-sub {
            font-size: 13px;
        }

        /* ───────────────────────────────
           PAGINATION
        ─────────────────────────────── */
        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 4px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pagination-info {
            font-size: 12px;
            color: var(--muted);
        }

        .pagination-btns {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .pg-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--card-bg);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all .15s;
        }

        .pg-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .pg-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .pg-btn.disabled {
            opacity: .4;
            pointer-events: none;
        }

        /* ───────────────────────────────
           RIWAYAT STATS
        ─────────────────────────────── */
        .riwayat-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 480px) {
            .riwayat-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .riwayat-stats .stat-val {
                font-size: 15px;
            }

            .riwayat-stats .stat-label {
                font-size: 10px;
            }
        }

        /* ───────────────────────────────
           CARD BOX (RIWAYAT TABLE)
        ─────────────────────────────── */
        .card-box {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
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
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .card-box-title i {
            color: var(--primary);
        }

        /* Table wrapper */
        .table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tbl-riwayat {
            width: 100%;
            border-collapse: collapse;
            min-width: 620px;
        }

        .tbl-riwayat thead th {
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

        .tbl-riwayat tbody td {
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .tbl-riwayat tbody tr:last-child td {
            border-bottom: none;
        }

        .tbl-riwayat tbody tr:hover td {
            background: #f8faff;
        }

        .tbl-empty {
            text-align: center;
            padding: 32px 14px;
            color: var(--muted);
        }

        /* Status pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .pill-success {
            background: var(--success-soft);
            color: var(--success);
        }

        .pill-warning {
            background: var(--accent-soft);
            color: var(--warning);
        }

        .pill-danger {
            background: var(--danger-soft);
            color: var(--danger);
        }

        /* Bukti button */
        .btn-bukti {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-bukti:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Table footer */
        .card-box-footer {
            padding: 10px 18px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--muted);
        }

        /* ───────────────────────────────
           MODAL
        ─────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 9999;
            align-items: flex-end;
            justify-content: center;
            padding: 0;
        }

        @media (min-width: 576px) {
            .modal-overlay {
                align-items: center;
                padding: 16px;
            }
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px 20px 0 0;
            width: 100%;
            max-width: 100%;
            max-height: 92vh;
            overflow-y: auto;
            animation: slideUp .25s ease;
            -webkit-overflow-scrolling: touch;
        }

        @media (min-width: 576px) {
            .modal-box {
                border-radius: 20px;
                max-width: 500px;
                animation: fadeUp .25s ease;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
            padding: 16px 20px;
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
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close {
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
            transition: all .15s;
        }

        .modal-close:hover {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .modal-body {
            padding: 18px 20px;
        }

        /* Tagihan info box */
        .tagihan-info-box {
            background: var(--bg);
            border-left: 4px solid var(--primary);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
        }

        .tagihan-info-box .info-label {
            font-size: 10.5px;
            color: var(--muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 6px;
        }

        .tagihan-info-box .info-layanan {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .tagihan-info-box .info-tutor {
            font-size: 12.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        .tagihan-info-box .info-jumlah {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
            margin-top: 8px;
        }

        /* Step label */
        .step-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        /* Rekening cards */
        .rek-card {
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 8px;
        }

        .rek-card:hover {
            border-color: var(--primary-light);
        }

        .rek-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .rek-logo {
            width: 48px;
            height: 30px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .rek-info {
            flex: 1;
            min-width: 0;
        }

        .rek-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .rek-norek {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .rek-an {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
        }

        .btn-copy {
            border: none;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 6px;
            padding: 2px 7px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-copy:hover {
            background: var(--primary);
            color: #fff;
        }

        .rek-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .2s;
        }

        .rek-card.selected .rek-check {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .rek-empty {
            text-align: center;
            padding: 16px;
            color: var(--muted);
            font-size: 13px;
        }

        /* Instruksi */
        .instruksi-box {
            background: var(--accent-soft);
            border: 1px solid var(--accent);
            border-radius: 10px;
            padding: 12px 14px;
            margin: 14px 0;
            font-size: 12.5px;
            color: #92400e;
        }

        .instruksi-box .ins-title {
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .instruksi-box ol {
            margin: 0;
            padding-left: 16px;
            line-height: 2;
        }

        /* Upload zone */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 24px 16px;
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

        .upload-icon {
            font-size: 2rem;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .upload-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--primary);
        }

        .upload-hint {
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* Preview */
        .preview-wrap {
            display: none;
            margin-top: 10px;
            text-align: center;
        }

        .preview-wrap img {
            max-width: 100%;
            max-height: 160px;
            border-radius: 10px;
            border: 2px solid var(--success);
            object-fit: contain;
        }

        .preview-name {
            font-size: 12px;
            color: var(--success);
            font-weight: 600;
            margin-top: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        /* Modal actions */
        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-actions .btn {
            flex: 1;
            padding: 10px 0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .2s;
        }

        .btn-cancel {
            background: var(--bg);
            color: var(--muted);
            border: 1.5px solid var(--border) !important;
        }

        .btn-cancel:hover {
            background: var(--border);
        }

        .btn-kirim {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(30, 58, 95, .25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-kirim:hover {
            opacity: .88;
        }

        /* ───────────────────────────────
           MODAL BUKTI
        ─────────────────────────────── */
        #modal-bukti .modal-box {
            max-width: 400px;
        }

        .bukti-img-wrap {
            text-align: center;
            padding: 20px 20px;
        }

        .bukti-img-wrap img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 12px;
            border: 2px solid var(--border);
        }

        /* ───────────────────────────────
           MODAL SUKSES
        ─────────────────────────────── */
        #modal-sukses .modal-box {
            max-width: 420px;
        }

        .sukses-body {
            padding: 32px 24px;
            text-align: center;
        }

        .sukses-emoji {
            font-size: 56px;
            margin-bottom: 12px;
        }

        .sukses-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }

        .sukses-sub {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .sukses-info {
            background: var(--success-soft);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 18px;
            text-align: left;
        }

        .sukses-info-title {
            font-size: 12px;
            color: var(--success);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 4px;
        }

        .sukses-info-sub {
            font-size: 12px;
            color: var(--success);
        }

        .btn-ok {
            width: 100%;
            padding: 11px 0;
            border-radius: 10px;
            border: none;
            background: var(--primary);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-ok:hover {
            opacity: .88;
        }

        /* ───────────────────────────────
           PRINT
        ─────────────────────────────── */
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

            .modal-overlay {
                display: none !important;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="page-header no-print">
        <div>
            <h4>💳 Pembayaran</h4>
            <p>Kelola tagihan dan riwayat pembayaran les privat kamu</p>
        </div>
        <button onclick="window.print()" class="btn-print">
            <i class="bi bi-printer-fill"></i> Cetak
        </button>
    </div>

    {{-- ══ STAT GRID ══ --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-val" style="color:var(--danger);">{{ $totalBelumBayar }}</div>
            <div class="stat-label">Tagihan Belum Bayar</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color:var(--primary);">
                Rp
                {{ $totalTagihan >= 1000000 ? round($totalTagihan / 1000000, 1) . 'jt' : round($totalTagihan / 1000) . 'rb' }}
            </div>
            <div class="stat-label">Total Tagihan Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color:var(--success);">{{ $totalTransaksi }}</div>
            <div class="stat-label">Riwayat Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color:var(--warning);">{{ $jatuhTempoTerdekat ?? '-' }}</div>
            <div class="stat-label">Jatuh Tempo Terdekat</div>
        </div>
    </div>

    {{-- ══ TABS ══ --}}
    <div class="main-tabs no-print">
        <button class="main-tab active" onclick="switchTab(this,'tagihan')">
            <i class="bi bi-receipt me-1"></i> Tagihan
            @if ($totalBelumBayar > 0)
                <span class="tab-badge">{{ $totalBelumBayar }}</span>
            @endif
        </button>
        <button class="main-tab" onclick="switchTab(this,'riwayat')">
            <i class="bi bi-clock-history me-1"></i> Riwayat
        </button>
    </div>

    {{-- ══════════════════════════════════
     TAB TAGIHAN
══════════════════════════════════ --}}
    <div id="tab-tagihan">
        @forelse($tagihan as $t)
            @php
                $isUrgent = $t->jadwal->isPast();
                $sudahUpload = $t->pembayaran_status === 'menunggu';
                $invoiceNo = $t->pembayaranTerakhir?->nomor_invoice ?? 'INV-' . strtoupper(substr($t->id, 0, 8));
                $layanan = $t->mata_pelajaran . ($t->topik ? ' – ' . $t->topik : '');
            @endphp

            <div class="tagihan-card {{ $isUrgent ? 'urgent' : '' }}">

                {{-- Header --}}
                <div class="th-header {{ $isUrgent ? 'urgent' : 'normal' }}">
                    <span class="th-id">#{{ $invoiceNo }}</span>
                    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                        @if ($isUrgent && !$sudahUpload)
                            <span class="urgency-badge">
                                <i class="bi bi-alarm-fill"></i> Segera!
                            </span>
                        @endif
                        <span class="status-badge"
                            style="background:{{ $sudahUpload ? 'var(--accent-soft)' : 'var(--danger-soft)' }};color:{{ $sudahUpload ? 'var(--warning)' : 'var(--danger)' }};">
                            <i class="bi bi-clock-fill" style="font-size:10px;"></i>
                            {{ $sudahUpload ? 'Menunggu Verifikasi' : 'Belum Dibayar' }}
                        </span>
                    </div>
                </div>

                {{-- Body --}}
                <div class="th-body">
                    <div class="th-row">
                        <div class="th-icon">
                            <i class="bi bi-person-video3"></i>
                        </div>
                        <div class="th-info">
                            <div class="th-title">Les Privat – {{ $layanan }}</div>
                            <div class="th-sub"><i class="bi bi-person-fill"></i> {{ $t->tutor->name ?? '-' }}</div>
                            <div class="th-sub">
                                <i class="bi bi-calendar3"></i>
                                {{ $t->jadwal->translatedFormat('l, d M Y · H:i') }} WIB
                            </div>
                            <div class="th-sub">
                                <i class="bi bi-clock"></i>
                                {{ $t->durasi_menit }} mnt · {{ $t->getModeLabel() }}
                            </div>
                            <div class="th-sub"
                                style="color:{{ $isUrgent ? 'var(--danger)' : 'var(--warning)' }};font-weight:600;">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Jatuh tempo: {{ $t->jadwal->format('d M Y') }}
                            </div>
                        </div>
                        {{-- Amount: desktop right --}}
                        <div class="th-amount-desktop">
                            <div class="amount-val" style="color:{{ $isUrgent ? 'var(--danger)' : 'var(--primary)' }};">
                                Rp {{ number_format($t->harga, 0, ',', '.') }}
                            </div>
                            <div class="amount-label">{{ $sudahUpload ? 'Menunggu Verifikasi' : 'Belum Lunas' }}</div>
                        </div>
                    </div>

                    {{-- Amount: mobile bottom --}}
                    <div class="th-amount th-amount-mobile">
                        <div>
                            <div class="amount-val" style="color:{{ $isUrgent ? 'var(--danger)' : 'var(--primary)' }};">
                                Rp {{ number_format($t->harga, 0, ',', '.') }}
                            </div>
                            <div class="amount-label">{{ $sudahUpload ? 'Menunggu Verifikasi' : 'Belum Lunas' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                @php
                    $hargaFormatted = 'Rp ' . number_format($t->harga, 0, ',', '.');
                    $layananEsc = addslashes($layanan);
                    $tutorEsc = addslashes($t->tutor->name ?? '');
                @endphp
                <div class="th-footer">
                    <div class="th-footer-hint">
                        <i class="bi bi-shield-check" style="flex-shrink:0;"></i>
                        <span>Transfer ke rekening Al Ilmi Center lalu upload bukti</span>
                    </div>
                    @if (!$sudahUpload)
                        <button class="btn-bayar"
                            onclick="openModalBayar(
                '{{ $t->id }}',
                '{{ $layananEsc }}',
                '{{ $hargaFormatted }}',
                '{{ $tutorEsc }}'
            )">
                            <i class="bi bi-send-fill"></i> Bayar Sekarang
                        </button>
                    @else
                        <span class="waiting-label">
                            <i class="bi bi-hourglass-split"></i> Menunggu konfirmasi tutor
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-check-circle"></i></div>
                <div class="empty-title">Tidak Ada Tagihan</div>
                <div class="empty-sub">Semua pembayaran sudah lunas 🎉</div>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($tagihan->total() > 0)
            <div class="pagination-wrap">
                <span class="pagination-info">
                    Menampilkan {{ $tagihan->firstItem() }}–{{ $tagihan->lastItem() }} dari {{ $tagihan->total() }}
                    tagihan
                </span>
                <div class="pagination-btns">
                    <a href="{{ $tagihan->previousPageUrl() }}"
                        class="pg-btn {{ !$tagihan->onFirstPage() ? '' : 'disabled' }}">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    @foreach ($tagihan->getUrlRange(1, $tagihan->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="pg-btn {{ $page == $tagihan->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    <a href="{{ $tagihan->nextPageUrl() }}"
                        class="pg-btn {{ $tagihan->hasMorePages() ? '' : 'disabled' }}">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════
     TAB RIWAYAT
══════════════════════════════════ --}}
    <div id="tab-riwayat" style="display:none;">

        {{-- Stats --}}
        <div class="riwayat-stats">
            <div class="stat-card">
                <div class="stat-val" style="color:var(--success);">
                    Rp
                    {{ $totalTerbayar >= 1000000 ? round($totalTerbayar / 1000000, 1) . 'jt' : round($totalTerbayar / 1000) . 'rb' }}
                </div>
                <div class="stat-label">Total Terbayar</div>
            </div>
            <div class="stat-card">
                <div class="stat-val" style="color:var(--primary);">{{ $totalTransaksi }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-card">
                <div class="stat-val" style="color:var(--danger);">{{ $totalDitolak }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">
                    <i class="bi bi-clock-history"></i> Riwayat Pembayaran
                </div>
                <button onclick="window.print()"
                    style="display:inline-flex;align-items:center;gap:5px;background:var(--danger-soft);color:var(--danger);border:1.5px solid var(--danger);border-radius:8px;font-size:12px;font-weight:600;padding:5px 12px;cursor:pointer;">
                    <i class="bi bi-printer-fill"></i> Cetak
                </button>
            </div>

            <div class="table-scroll">
                <table class="tbl-riwayat">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Layanan</th>
                            <th>Tutor</th>
                            <th>Bank</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                            <tr>
                                <td style="font-weight:700;font-size:12px;color:var(--primary);">
                                    #{{ $r->nomor_invoice }}
                                </td>
                                <td>
                                    <div style="font-weight:600;">{{ $r->lesPrivat?->mata_pelajaran }}</div>
                                    @if ($r->lesPrivat?->topik)
                                        <div style="font-size:11px;color:var(--muted);">– {{ $r->lesPrivat->topik }}</div>
                                    @endif
                                </td>
                                <td style="font-size:12.5px;white-space:nowrap;">
                                    {{ $r->lesPrivat?->tutor?->name ?? '-' }}
                                </td>
                                <td style="font-size:12.5px;white-space:nowrap;">
                                    {{ $r->bank_tujuan }}
                                </td>
                                <td style="font-weight:700;white-space:nowrap;">
                                    Rp {{ number_format($r->jumlah, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($r->status === 'dikonfirmasi')
                                        <span class="pill pill-success">
                                            <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Lunas
                                        </span>
                                    @elseif($r->status === 'menunggu')
                                        <span class="pill pill-warning">⏳ Menunggu</span>
                                    @else
                                        <span class="pill pill-danger">❌ Ditolak</span>
                                    @endif
                                </td>
                                <td style="font-size:12px;color:var(--muted);white-space:nowrap;">
                                    {{ $r->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    @if ($r->bukti_transfer)
                                        <button class="btn-bukti" onclick="openModalBuktiUrl('{{ $r->bukti_url }}')">
                                            <i class="bi bi-image"></i> Bukti
                                        </button>
                                    @else
                                        <span style="font-size:12px;color:var(--muted);">–</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="tbl-empty">Belum ada riwayat transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-box-footer">
                Total {{ $riwayat->count() }} transaksi
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════
     MODAL BAYAR
══════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-bayar">
        <div class="modal-box">
            <div class="modal-head">
                <h5><i class="bi bi-credit-card-fill" style="color:var(--primary);"></i> Bayar Tagihan</h5>
                <button class="modal-close" onclick="closeModal('modal-bayar')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">

                {{-- Info tagihan --}}
                <div class="tagihan-info-box">
                    <div class="info-label">Detail Tagihan</div>
                    <div class="info-layanan" id="modal-layanan">-</div>
                    <div class="info-tutor" id="modal-tutor">-</div>
                    <div class="info-jumlah" id="modal-jumlah">-</div>
                </div>

                {{-- Step 1 --}}
                <div class="step-label">
                    <div class="step-num">1</div>
                    <div class="step-text">Pilih Rekening Tujuan Transfer</div>
                </div>

                @forelse($rekening as $idx => $rek)
                    <div class="rek-card {{ $idx === 0 ? 'selected' : '' }}" onclick="selectRek(this)"
                        data-bank="{{ $rek->nama_bank }}" data-norek="{{ $rek->nomor_rekening }}">
                        <div class="rek-logo" style="background:var(--primary);">
                            {{ strtoupper(substr($rek->nama_bank, 5, 3)) }}
                        </div>
                        <div class="rek-info">
                            <div class="rek-name">{{ $rek->nama_bank }}</div>
                            <div class="rek-norek">
                                <span>{{ $rek->nomor_rekening }}</span>
                                <button type="button" class="btn-copy"
                                    onclick="event.stopPropagation();copyText('{{ $rek->nomor_rekening }}',this)">
                                    <i class="bi bi-clipboard"></i> Salin
                                </button>
                            </div>
                            <div class="rek-an">a.n. {{ $rek->atas_nama }}</div>
                        </div>
                        <div class="rek-check">
                            @if ($idx === 0)
                                <i class="bi bi-check-lg" style="font-size:11px;color:#fff;"></i>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rek-empty">Belum ada rekening tersedia. Hubungi admin.</div>
                @endforelse

                {{-- Instruksi --}}
                <div class="instruksi-box">
                    <div class="ins-title"><i class="bi bi-info-circle-fill"></i> Cara Pembayaran:</div>
                    <ol>
                        <li>Pilih rekening tujuan di atas</li>
                        <li>Transfer tepat sesuai jumlah tagihan</li>
                        <li>Ambil foto / screenshot bukti transfer</li>
                        <li>Upload bukti di bawah lalu klik <strong>Kirim</strong></li>
                        <li>Tunggu konfirmasi tutor (maks 1×24 jam)</li>
                    </ol>
                </div>

                {{-- Step 2 --}}
                <div class="step-label">
                    <div class="step-num">2</div>
                    <div class="step-text">Upload Bukti Transfer</div>
                </div>

                <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                    <div class="upload-icon" id="uploadIcon">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                    <div id="uploadText">
                        <div class="upload-title">Klik untuk pilih foto</div>
                        <div class="upload-hint">JPG, PNG — Maks. 2MB</div>
                    </div>
                    <input type="file" id="fileInput" accept="image/*" style="display:none;"
                        onchange="previewUpload(this)" />
                </div>

                <div class="preview-wrap" id="previewWrap">
                    <img id="previewImg" alt="Preview bukti transfer" />
                    <div class="preview-name">
                        <i class="bi bi-check-circle-fill"></i>
                        <span id="previewName"></span>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('modal-bayar')">Batal</button>
                    <button type="button" class="btn btn-kirim" onclick="kirimPembayaran()">
                        <i class="bi bi-send-fill"></i> Kirim Bukti Bayar
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════
     MODAL BUKTI
══════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-bukti">
        <div class="modal-box" style="max-width:400px;">
            <div class="modal-head">
                <h5><i class="bi bi-image" style="color:var(--primary);"></i> Bukti Pembayaran</h5>
                <button class="modal-close" onclick="closeModal('modal-bukti')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="bukti-img-wrap">
                <img id="bukti-img" src="" alt="Bukti Transfer" />
                <button onclick="closeModal('modal-bukti')" class="btn-ok" style="margin-top:14px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════
     MODAL SUKSES
══════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-sukses">
        <div class="modal-box" style="max-width:420px;">
            <div class="sukses-body">
                <div class="sukses-emoji">🎉</div>
                <div class="sukses-title">Bukti Terkirim!</div>
                <div class="sukses-sub">
                    Bukti pembayaran berhasil dikirim.<br />
                    Menunggu konfirmasi dari tutor dalam <strong>1×24 jam</strong>.
                </div>
                <div class="sukses-info">
                    <div class="sukses-info-title">
                        <i class="bi bi-check-circle-fill"></i> Status: Menunggu Verifikasi Tutor
                    </div>
                    <div class="sukses-info-sub">Kamu akan mendapat notifikasi setelah dikonfirmasi.</div>
                </div>
                <button onclick="closeModal('modal-sukses')" class="btn-ok">OK, Mengerti</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let currentLesId = '';

        /* ── TABS ── */
        function switchTab(el, id) {
            document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('tab-tagihan').style.display = id === 'tagihan' ? '' : 'none';
            document.getElementById('tab-riwayat').style.display = id === 'riwayat' ? '' : 'none';
        }

        /* ── MODAL BAYAR ── */
        function openModalBayar(id, layanan, jumlah, tutor) {
            currentLesId = id;
            document.getElementById('modal-layanan').textContent = 'Les Privat – ' + layanan;
            document.getElementById('modal-tutor').textContent = 'Tutor: ' + tutor;
            document.getElementById('modal-jumlah').textContent = jumlah;
            // reset upload
            document.getElementById('previewWrap').style.display = 'none';
            document.getElementById('fileInput').value = '';
            const zone = document.getElementById('uploadZone');
            zone.classList.remove('has-file');
            document.getElementById('uploadIcon').innerHTML = '<i class="bi bi-cloud-arrow-up-fill"></i>';
            document.getElementById('uploadText').innerHTML =
                '<div class="upload-title">Klik untuk pilih foto</div>' +
                '<div class="upload-hint">JPG, PNG — Maks. 2MB</div>';
            document.getElementById('modal-bayar').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
            document.body.style.overflow = '';
        }

        /* Close on overlay click */
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        /* ── REKENING SELECT ── */
        function selectRek(el) {
            document.querySelectorAll('.rek-card').forEach(c => {
                c.classList.remove('selected');
                const chk = c.querySelector('.rek-check');
                if (chk) {
                    chk.style.background = '';
                    chk.style.borderColor = 'var(--border)';
                    chk.innerHTML = '';
                }
            });
            el.classList.add('selected');
            const chk = el.querySelector('.rek-check');
            if (chk) {
                chk.style.background = 'var(--primary)';
                chk.style.borderColor = 'var(--primary)';
                chk.innerHTML = '<i class="bi bi-check-lg" style="font-size:11px;color:#fff;"></i>';
            }
        }

        /* ── COPY ── */
        function copyText(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check"></i> Tersalin!';
                btn.style.background = 'var(--success)';
                btn.style.color = '#fff';
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.style.background = '';
                    btn.style.color = '';
                }, 2000);
            });
        }

        /* ── UPLOAD PREVIEW ── */
        function previewUpload(input) {
            const file = input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('previewName').textContent = file.name;
                document.getElementById('previewWrap').style.display = '';
                const zone = document.getElementById('uploadZone');
                zone.classList.add('has-file');
                document.getElementById('uploadIcon').innerHTML =
                    '<i class="bi bi-check-circle-fill" style="color:var(--success);font-size:2rem;"></i>';
                document.getElementById('uploadText').innerHTML =
                    '<div class="upload-title" style="color:var(--success);">File siap dikirim</div>' +
                    '<div class="upload-hint">Klik untuk ganti foto</div>';
            };
            reader.readAsDataURL(file);
        }

        /* ── KIRIM ── */
        function kirimPembayaran() {
            const file = document.getElementById('fileInput').files[0];
            if (!file) {
                alert('Harap upload bukti transfer terlebih dahulu!');
                return;
            }
            const selectedRek = document.querySelector('.rek-card.selected');
            if (!selectedRek) {
                alert('Pilih rekening tujuan!');
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('bukti_transfer', file);
            formData.append('bank_tujuan', selectedRek.dataset.bank);
            formData.append('nomor_rekening', selectedRek.dataset.norek);

            fetch('/siswa/pembayaran/' + currentLesId + '/upload-bukti', {
                    method: 'POST',
                    body: formData
                })
                .then(res => {
                    if (res.ok || res.status === 302 || res.redirected) {
                        closeModal('modal-bayar');
                        setTimeout(() => document.getElementById('modal-sukses').classList.add('show'), 300);
                        setTimeout(() => window.location.reload(), 2500);
                    } else {
                        return res.text().then(text => {
                            console.error('Error:', res.status, text);
                            alert('Gagal mengirim bukti. Coba lagi. (Error ' + res.status + ')');
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi. Coba lagi.');
                });
        }

        /* ── BUKTI PREVIEW ── */
        function openModalBuktiUrl(url) {
            document.getElementById('bukti-img').src = url;
            document.getElementById('modal-bukti').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    </script>
@endpush
