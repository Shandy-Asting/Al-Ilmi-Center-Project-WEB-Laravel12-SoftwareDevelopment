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
        .step-bar {
            display: flex;
            align-items: center;
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

        .tka-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 6px;
            overflow-x: auto;
            flex-wrap: wrap;
        }

        .tka-tab {
            flex-shrink: 0;
            padding: 9px 16px;
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

        .btn-soal-submit {
            background: var(--success);
            color: #fff;
            box-shadow: 0 4px 12px rgba(22, 163, 74, .3);
        }

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

        .section-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-box {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 20px;
        }

        /* Modal file viewer */
        .file-viewer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .7);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-viewer-box {
            background: #fff;
            border-radius: 16px;
            width: 90%;
            max-width: 900px;
            height: 85vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .file-viewer-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-viewer-body {
            flex: 1;
            overflow: hidden;
        }

        .file-viewer-body iframe {
            width: 100%;
            height: 100%;
            border: none;
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

    <div class="mb-4">
        <h4 class="fw-bold mb-1">📚 Belajar TKA</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Belajar TKA</span>
        </div>
    </div>

    {{-- STEP BAR --}}
    <div class="step-bar">
        <div class="step-item">
            <div class="step-circle active" id="sc1">1</div>
            <div class="step-label active" id="sl1">Pilih Jenjang</div>
        </div>
        <div class="step-divider" id="sd1"></div>
        <div class="step-item">
            <div class="step-circle pending" id="sc2">2</div>
            <div class="step-label pending" id="sl2">Pilih Materi</div>
        </div>
        <div class="step-divider" id="sd2"></div>
        <div class="step-item">
            <div class="step-circle pending" id="sc3">3</div>
            <div class="step-label pending" id="sl3">Latihan / Kuis</div>
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
                <div class="jenjang-card" onclick="selectJenjang(this,'sd')">
                    <div class="jenjang-icon">🏫</div>
                    <div class="jenjang-title">SD / Sederajat</div>
                    <div class="jenjang-sub">Kelas 1 – 6 Sekolah Dasar</div>
                    <span class="jenjang-badge" style="background:var(--success-soft);color:var(--success);">
                        {{ $perJenjang['sd'] }} Materi Tersedia
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jenjang-card" onclick="selectJenjang(this,'smp')">
                    <div class="jenjang-icon">🏛️</div>
                    <div class="jenjang-title">SMP / Sederajat</div>
                    <div class="jenjang-sub">Kelas 7 – 9 Sekolah Menengah Pertama</div>
                    <span class="jenjang-badge" style="background:var(--accent-soft);color:var(--warning);">
                        {{ $perJenjang['smp'] }} Materi Tersedia
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jenjang-card" onclick="selectJenjang(this,'sma')">
                    <div class="jenjang-icon">🎓</div>
                    <div class="jenjang-title">SMA / Sederajat</div>
                    <div class="jenjang-sub">Kelas 10 – 12 Sekolah Menengah Atas</div>
                    <span class="jenjang-badge" style="background:#eff6ff;color:var(--primary);">
                        {{ $perJenjang['sma'] }} Materi Tersedia
                    </span>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
                onclick="lanjutKeMateri()">
                Pilih Materi <i class="bi bi-chevron-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- ══ STEP 2: PILIH MATERI ══ --}}
    <div id="step-materi" style="display:none;">
        <div class="section-title">
            <span>📖 Pilih Materi Pembelajaran</span>
            <button onclick="kembaliKeJenjang()"
                style="font-size:12px;color:var(--muted);background:none;border:none;cursor:pointer;">
                <i class="bi bi-arrow-left me-1"></i>Ganti Jenjang
            </button>
        </div>

        <div id="info-jenjang" class="mb-3 px-3 py-2 rounded-3"
            style="background:var(--primary);color:#fff;font-size:13px;font-weight:600;display:inline-block;border-radius:10px!important;">
        </div>

        {{-- Tabs Mapel dari DB --}}
        <div class="tka-tabs mb-3">
            <button class="tka-tab active" data-mapel="semua" onclick="filterMapel(this,'semua')">Semua</button>
            @foreach ($daftarMapel as $mp)
                <button class="tka-tab" data-mapel="{{ strtolower($mp) }}"
                    onclick="filterMapel(this,'{{ strtolower($mp) }}')">{{ $mp }}</button>
            @endforeach
        </div>

        {{-- Daftar Materi dari DB --}}
        @php
            $ikonMap = [
                'matematika' => ['bi-calculator-fill', '#eff6ff', 'var(--primary)'],
                'fisika' => ['bi-lightning-charge-fill', '#dbeafe', '#2563eb'],
                'kimia' => ['bi-flask-conical-fill', 'var(--success-soft)', 'var(--success)'],
                'biologi' => ['bi-tree-fill', '#f0fdf4', '#15803d'],
                'b. inggris' => ['bi-translate', 'var(--accent-soft)', 'var(--warning)'],
                'b. indonesia' => ['bi-book-fill', 'var(--danger-soft)', 'var(--danger)'],
                'ipa' => ['bi-stars', '#f0fdf4', '#0d9488'],
                'ips' => ['bi-globe2', '#fef3c7', '#d97706'],
                'bahasa indonesia' => ['bi-book-fill', 'var(--danger-soft)', 'var(--danger)'],
                'bahasa inggris' => ['bi-translate', 'var(--accent-soft)', 'var(--warning)'],
            ];
            $def = ['bi-journal-text', '#f1f5f9', '#64748b'];
        @endphp

        @forelse($materi as $m)
            @php $ik = $ikonMap[strtolower($m->mata_pelajaran)] ?? $def; @endphp
            <div class="materi-card" data-id="{{ $m->id }}" data-jenjang="{{ strtolower($m->jenjang) }}"
                data-mapel="{{ strtolower($m->mata_pelajaran) }}" data-soal="{{ $m->soal_count }}"
                data-judul="{{ $m->judul }}" data-mapel-label="{{ $m->mata_pelajaran }}"
                data-kelas="{{ $m->kelas }}" data-file="{{ $m->file_path ? asset('storage/' . $m->file_path) : '' }}"
                data-link="{{ $m->link_video ?? '' }}" data-tipe="{{ $m->tipe }}"
                onclick="pilihMateri(this,'{{ $m->id }}',{{ $m->soal_count }})">
                <div class="materi-icon" style="background:{{ $ik[1] }};color:{{ $ik[2] }};">
                    <i class="bi {{ $ik[0] }}"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="m-title">{{ $m->judul }}</div>
                    <div class="m-sub">
                        {{ $m->mata_pelajaran }} · {{ strtoupper($m->jenjang) }} · {{ $m->kelas }}
                        @if ($m->tutor)
                            · <i class="bi bi-person-fill"></i> {{ $m->tutor->name }}
                        @endif
                    </div>
                    <div class="m-tags">
                        <span class="materi-tag" style="background:{{ $ik[1] }};color:{{ $ik[2] }};">
                            {{ $m->mata_pelajaran }}
                        </span>
                        @if ($m->topik)
                            <span class="materi-tag" style="background:#f1f5f9;color:#64748b;">{{ $m->topik }}</span>
                        @endif
                        @if ($m->tipe === 'video')
                            <span class="materi-tag" style="background:#dbeafe;color:#1d4ed8;">📹 Video</span>
                        @elseif($m->file_path)
                            <span class="materi-tag" style="background:#fee2e2;color:#dc2626;">📄
                                {{ strtoupper($m->tipe) }}</span>
                        @endif
                        @if ($m->soal_count === 0)
                            <span class="materi-tag" style="background:var(--danger-soft);color:var(--danger);">⚠ Belum
                                ada soal</span>
                        @else
                            <span class="materi-tag" style="background:var(--success-soft);color:var(--success);">✓
                                {{ $m->soal_count }} Soal</span>
                        @endif
                    </div>
                </div>
                <div class="materi-progress">
                    <div class="mp-val" style="{{ $m->soal_count === 0 ? 'color:var(--muted)' : '' }}">
                        {{ $m->soal_count }}
                    </div>
                    <div class="mp-label">Soal</div>
                </div>
            </div>
        @empty
            <div
                style="text-align:center;padding:40px;background:var(--card-bg);border-radius:14px;border:1px solid var(--border);">
                <i class="bi bi-inbox" style="font-size:2.5rem;color:var(--muted);display:block;margin-bottom:10px;"></i>
                <div style="font-size:13px;color:var(--muted);">Belum ada materi aktif tersedia.</div>
            </div>
        @endforelse

        <div id="no-materi"
            style="display:none;text-align:center;padding:30px;background:var(--card-bg);border-radius:14px;border:1px solid var(--border);">
            <i class="bi bi-search" style="font-size:2rem;color:var(--muted);display:block;margin-bottom:8px;"></i>
            <div style="font-size:13px;color:var(--muted);">Tidak ada materi untuk jenjang/mapel ini.</div>
        </div>

        {{-- Tombol aksi setelah pilih materi --}}
        <div id="tombol-aksi" style="display:none;" class="mt-3 mb-4">
            <div style="background:#eff6ff;border:1.5px solid var(--primary);border-radius:14px;padding:16px 20px;">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1">
                        <div id="label-materi-dipilih" style="font-size:14px;font-weight:700;color:var(--primary);"></div>
                        <div id="label-soal-count" style="font-size:12px;color:var(--muted);margin-top:2px;"></div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        {{-- Tombol buka materi (file/video) --}}
                        <button id="btn-buka-materi"
                            style="display:none;background:var(--info-soft);color:var(--info);border-radius:10px;border:none;padding:9px 18px;font-size:13px;font-weight:700;cursor:pointer;"
                            onclick="bukaMateriFIle()">
                            <i class="bi bi-eye me-1"></i> Buka Materi
                        </button>
                        <button class="btn btn-sm px-4 py-2 fw-bold"
                            style="background:var(--primary);color:#fff;border-radius:10px;border:none;"
                            onclick="mulaiBelajar('latihan')">
                            <i class="bi bi-pencil-fill me-1"></i> Latihan Soal
                        </button>
                        <button class="btn btn-sm px-4 py-2 fw-bold"
                            style="background:var(--accent-soft);color:var(--warning);border-radius:10px;border:none;"
                            onclick="mulaiBelajar('kuis')">
                            <i class="bi bi-lightning-fill me-1"></i> Mulai Kuis
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ STEP 3 dst → redirect ke halaman soal ══ --}}
    {{-- (step-latihan dan step-hasil tetap ada sebagai fallback tampilan) --}}
    <div id="step-latihan" style="display:none;">
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="mt-3" style="font-size:13px;color:var(--muted);">Memuat soal...</div>
        </div>
    </div>
    <div id="step-hasil" style="display:none;"></div>

    {{-- Modal Buka File Materi --}}
    <div id="fileViewerOverlay" class="file-viewer-overlay" style="display:none;" onclick="tutupFileViewer(event)">
        <div class="file-viewer-box" onclick="event.stopPropagation()">
            <div class="file-viewer-header">
                <div>
                    <div id="fv-judul" style="font-weight:700;font-size:15px;color:var(--text);"></div>
                    <div id="fv-sub" style="font-size:12px;color:var(--muted);"></div>
                </div>
                <button onclick="tutupFileViewer()"
                    style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:var(--muted);">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="file-viewer-body">
                <iframe id="fv-frame" src="" allowfullscreen></iframe>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let jenjangDipilih = '';
        let materiDipilih = '';
        let materiData = {};

        // ── Step 1 ──
        function selectJenjang(el, val) {
            document.querySelectorAll('.jenjang-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            jenjangDipilih = val;
        }

        function lanjutKeMateri() {
            if (!jenjangDipilih) {
                alert('Pilih jenjang terlebih dahulu!');
                return;
            }
            setStep(2);
            const lbl = {
                sd: '🏫 SD / Sederajat',
                smp: '🏛️ SMP / Sederajat',
                sma: '🎓 SMA / Sederajat'
            };
            document.getElementById('info-jenjang').textContent = lbl[jenjangDipilih];
            terapkanFilterJenjang(jenjangDipilih);
            document.getElementById('step-jenjang').style.display = 'none';
            document.getElementById('step-materi').style.display = '';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function kembaliKeJenjang() {
            setStep(1);
            materiDipilih = '';
            document.getElementById('tombol-aksi').style.display = 'none';
            document.getElementById('step-jenjang').style.display = '';
            document.getElementById('step-materi').style.display = 'none';
        }

        // ── Step 2 ──
        function terapkanFilterJenjang(jenjang) {
            document.querySelectorAll('.tka-tab').forEach(t => t.classList.remove('active'));
            document.querySelector('[data-mapel="semua"]').classList.add('active');
            let ada = 0;
            document.querySelectorAll('.materi-card').forEach(card => {
                const ok = card.dataset.jenjang === jenjang;
                card.style.display = ok ? '' : 'none';
                if (ok) ada++;
            });
            document.querySelectorAll('.tka-tab[data-mapel]').forEach(tab => {
                if (tab.dataset.mapel === 'semua') return;
                const punya = [...document.querySelectorAll('.materi-card')]
                    .some(c => c.dataset.jenjang === jenjang && c.dataset.mapel === tab.dataset.mapel);
                tab.style.display = punya ? '' : 'none';
            });
            document.getElementById('no-materi').style.display = ada === 0 ? '' : 'none';
        }

        function filterMapel(el, mapel) {
            document.querySelectorAll('.tka-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            materiDipilih = '';
            document.getElementById('tombol-aksi').style.display = 'none';
            let ada = 0;
            document.querySelectorAll('.materi-card').forEach(card => {
                const ok = card.dataset.jenjang === jenjangDipilih &&
                    (mapel === 'semua' || card.dataset.mapel === mapel);
                card.style.display = ok ? '' : 'none';
                card.classList.remove('selected');
                if (ok) ada++;
            });
            document.getElementById('no-materi').style.display = ada === 0 ? '' : 'none';
        }

        function pilihMateri(el, id, soalCount) {
            document.querySelectorAll('.materi-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            materiDipilih = id;

            // Simpan data materi untuk file viewer
            materiData = {
                judul: el.dataset.judul,
                mapel: el.dataset.mapelLabel,
                kelas: el.dataset.kelas,
                file: el.dataset.file,
                link: el.dataset.link,
                tipe: el.dataset.tipe,
            };

            if (soalCount === 0) {
                // Kalau tidak ada soal, hanya bisa buka materi
                document.getElementById('tombol-aksi').style.display = '';
                document.getElementById('label-materi-dipilih').textContent = '📚 ' + materiData.judul;
                document.getElementById('label-soal-count').textContent = 'Belum ada soal · Bisa buka materi saja';
                // Sembunyikan tombol latihan/kuis
                document.querySelectorAll('[onclick="mulaiBelajar(\'latihan\')"], [onclick="mulaiBelajar(\'kuis\')"]')
                    .forEach(b => b.style.display = 'none');
            } else {
                document.getElementById('tombol-aksi').style.display = '';
                document.getElementById('label-materi-dipilih').textContent = '✅ ' + materiData.judul;
                document.getElementById('label-soal-count').textContent = soalCount + ' soal tersedia · Siap dimulai!';
                document.querySelectorAll('[onclick="mulaiBelajar(\'latihan\')"], [onclick="mulaiBelajar(\'kuis\')"]')
                    .forEach(b => b.style.display = '');
            }

            // Tampilkan tombol buka materi kalau ada file/video
            const btnBuka = document.getElementById('btn-buka-materi');
            if (materiData.file || materiData.link) {
                btnBuka.style.display = '';
            } else {
                btnBuka.style.display = 'none';
            }

            setTimeout(() => {
                document.getElementById('tombol-aksi').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 150);
        }

        // ── Buka File / Video Materi ──
        function bukaMateriFIle() {
            if (!materiData.file && !materiData.link) return;

            document.getElementById('fv-judul').textContent = materiData.judul;
            document.getElementById('fv-sub').textContent = materiData.mapel + ' · ' + materiData.kelas;

            let src = '';
            if (materiData.tipe === 'video' || materiData.link) {
                // Konversi YouTube link ke embed
                src = materiData.link;
                if (src.includes('youtube.com/watch?v=')) {
                    src = src.replace('watch?v=', 'embed/');
                } else if (src.includes('youtu.be/')) {
                    const vid = src.split('youtu.be/')[1];
                    src = 'https://www.youtube.com/embed/' + vid;
                }
            } else if (materiData.file) {
                src = materiData.file;
                // PDF bisa langsung di iframe
            }

            document.getElementById('fv-frame').src = src;
            document.getElementById('fileViewerOverlay').style.display = 'flex';
        }

        function tutupFileViewer(e) {
            if (!e || e.target === document.getElementById('fileViewerOverlay') || !e.target) {
                document.getElementById('fv-frame').src = '';
                document.getElementById('fileViewerOverlay').style.display = 'none';
            }
        }

        // ── Mulai Belajar ──
        function mulaiBelajar(tipe) {
            if (!materiDipilih) {
                alert('Pilih materi terlebih dahulu!');
                return;
            }
            window.location.href = '/siswa/belajar-tka/' + materiDipilih + '/soal?tipe=' + tipe;
        }

        // ── Step Bar ──
        function setStep(step) {
            for (let i = 1; i <= 3; i++) {
                const c = document.getElementById('sc' + i);
                const l = document.getElementById('sl' + i);
                const d = document.getElementById('sd' + i);
                if (!c) continue;
                if (i < step) {
                    c.className = 'step-circle done';
                    c.innerHTML = '<i class="bi bi-check-lg"></i>';
                    l.className = 'step-label done';
                    if (d) d.className = 'step-divider done';
                } else if (i === step) {
                    c.className = 'step-circle active';
                    c.innerHTML = i;
                    l.className = 'step-label active';
                } else {
                    c.className = 'step-circle pending';
                    c.innerHTML = i;
                    l.className = 'step-label pending';
                }
            }
        }

        function pilihOpsi(el, key) {
            document.querySelectorAll('.opsi-item').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
        }

        function showPembahasan() {
            const pb = document.getElementById('pembahasan-box');
            if (pb) pb.style.display = pb.style.display === 'none' ? '' : 'none';
        }
    </script>
@endpush
