@extends('layouts.app')

@section('title', 'Pengelolaan Materi - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Pengelolaan Materi')
@section('page-sub', 'Dashboard / Materi Ajar')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/tutor/dashboard" class="nav-item-custom {{ request()->is('tutor/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
    <a href="/tutor/jadwal" class="nav-item-custom {{ request()->is('tutor/jadwal') ? 'active' : '' }}">
        <i class="bi bi-calendar3"></i> Jadwal Mengajar
    </a>
    <a href="/tutor/daftar-siswa" class="nav-item-custom {{ request()->is('tutor/daftar-siswa') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Daftar Siswa
    </a>
    <a href="/tutor/materi" class="nav-item-custom {{ request()->is('tutor/materi') ? 'active' : '' }}">
        <i class="bi bi-journal-text"></i> Materi Ajar
    </a>
    <div class="menu-label">Akademik</div>
    <a href="/tutor/soal" class="nav-item-custom {{ request()->is('tutor/soal') ? 'active' : '' }}">
        <i class="bi bi-patch-question-fill"></i> Bank Soal
    </a>
    <a href="/tutor/les-privat" class="nav-item-custom {{ request()->is('tutor/les-privat') ? 'active' : '' }}">
        <i class="bi bi-person-video3"></i> Les Privat
    </a>
    <a href="/tutor/pembayaran" class="nav-item-custom {{ request()->is('tutor/pembayaran') ? 'active' : '' }}">
        <i class="bi bi-cash-coin"></i> Pembayaran
        <span class="nav-badge">2</span>
    </a>
    <div class="menu-label">Akun</div>
    <a href="/tutor/notifikasi" class="nav-item-custom {{ request()->is('tutor/notifikasi') ? 'active' : '' }}">
        <i class="bi bi-bell-fill"></i> Notifikasi
    </a>
    <a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
    <style>
        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 18px 20px;
            border: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-val {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1;
            color: var(--text);
        }

        .stat-label {
            font-size: .78rem;
            color: var(--muted);
            margin-top: 4px;
            font-weight: 500;
        }

        /* ── FILTER BAR ── */
        .filter-bar {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .search-wrap {
            flex: 1;
            min-width: 220px;
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .9rem;
        }

        .search-wrap input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: .85rem;
            background: var(--bg);
            color: var(--text);
            outline: none;
            transition: border .2s;
        }

        .search-wrap input:focus {
            border-color: var(--primary);
            background: #fff;
        }

        .filter-select {
            padding: 9px 32px 9px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: .83rem;
            background: var(--bg);
            color: var(--text);
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        .filter-select:focus {
            border-color: var(--primary);
        }

        .view-toggle {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .view-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            cursor: pointer;
            color: var(--muted);
            font-size: .9rem;
            border: none;
            transition: all .2s;
        }

        .view-btn.active {
            background: var(--primary);
            color: #fff;
        }

        /* ── TABLE ── */
        .table-materi {
            width: 100%;
            border-collapse: collapse;
        }

        .table-materi thead th {
            padding: 12px 16px;
            font-size: .73rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table-materi tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }

        .table-materi tbody tr:last-child {
            border-bottom: none;
        }

        .table-materi tbody tr:hover {
            background: #f8faff;
        }

        .table-materi tbody td {
            padding: 14px 16px;
            font-size: .85rem;
            vertical-align: middle;
            color: var(--text);
        }

        .materi-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .materi-title {
            font-weight: 600;
            font-size: .88rem;
            color: var(--text);
        }

        .materi-desc {
            font-size: .75rem;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── BADGES ── */
        .badge-jenjang {
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .badge-mapel {
            font-size: .68rem;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            background: #eff6ff;
            color: var(--primary);
        }

        .badge-tipe {
            font-size: .68rem;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 6px;
        }

        .badge-tipe.pdf {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .badge-tipe.video {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-tipe.doc {
            background: var(--info-soft);
            color: var(--info);
        }

        .badge-tipe.ppt {
            background: var(--accent-soft);
            color: var(--warning);
        }

        .badge-tipe.quiz {
            background: var(--success-soft);
            color: var(--success);
        }

        .badge-status {
            font-size: .7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        .badge-status.aktif {
            background: var(--success-soft);
            color: var(--success);
        }

        .badge-status.draft {
            background: var(--accent-soft);
            color: var(--warning);
        }

        .badge-status.arsip {
            background: #f1f5f9;
            color: #94a3b8;
        }

        /* ── ACTION BUTTONS ── */
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
            font-size: .85rem;
            transition: all .2s;
        }

        .btn-action:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .btn-action.del:hover {
            background: var(--danger);
            color: #fff;
            border-color: var(--danger);
        }

        .btn-action.suc:hover {
            background: var(--success);
            color: #fff;
            border-color: var(--success);
        }

        /* ── GRID CARDS ── */
        .materi-card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            display: flex;
            flex-direction: column;
        }

        .materi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, .1);
        }

        .materi-card-thumb {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            position: relative;
        }

        .materi-card-body {
            padding: 14px 16px;
            flex: 1;
        }

        .materi-card-title {
            font-weight: 700;
            font-size: .88rem;
            color: var(--text);
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .materi-card-meta {
            font-size: .73rem;
            color: var(--muted);
        }

        .materi-card-footer {
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── PAGINATION ── */
        .page-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: .82rem;
            font-weight: 600;
            color: var(--muted);
            transition: all .2s;
            text-decoration: none;
        }

        .page-btn:hover {
            background: #eff6ff;
            color: var(--primary);
            border-color: var(--primary);
        }

        .page-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .page-btn.disabled {
            opacity: .4;
            pointer-events: none;
        }

        /* ── MODAL ── */
        .modal-custom .modal-content {
            border-radius: 18px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
        }

        .form-label-custom {
            font-size: .82rem;
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
            font-size: .85rem;
            color: var(--text);
            outline: none;
            transition: border .2s;
            background: #fff;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
        }

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

        /* ── CARD BOX ── */
        .card-box {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
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
            font-size: .95rem;
            font-weight: 700;
            color: var(--text);
        }

        .card-box-title i {
            color: var(--primary);
            margin-right: 6px;
        }

        @media (max-width: 767px) {
            .filter-bar {
                gap: 8px;
            }

            .filter-select {
                width: 100% !important;
            }

            .search-wrap {
                min-width: 100% !important;
            }

            .table-responsive {
                font-size: 12px;
            }

            .materi-title {
                font-size: .82rem;
            }

            .view-toggle {
                margin-left: 0 !important;
            }

            .card-box-header .d-flex {
                flex-direction: column;
                width: 100%;
            }

            .materi-icon-wrap {
                width: 32px !important;
                height: 32px !important;
            }

            .tutor-grid {
                grid-template-columns: 1fr 1fr !important;
            }
        }

        @media (max-width: 480px) {
            .tutor-grid {
                grid-template-columns: 1fr !important;
            }

            .achieve-grid {
                grid-template-columns: 1fr 1fr !important;
            }
        }

        /* MODAL RESPONSIVE FIX */
        @media(max-width:767px) {
            .modal {
                padding: 8px !important;
            }

            .modal-dialog {
                margin: 0 !important;
                max-width: 100% !important;
            }

            .modal-content {
                border-radius: 14px !important;
            }

            .modal-body {
                padding: 16px !important;
            }

            .modal-footer {
                padding: 12px 16px !important;
                position: sticky;
                bottom: 0;
                background: #fff;
                border-top: 1px solid var(--border);
            }
        }

        /* FORM UPLOAD ZONE */
        .upload-drop {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 28px 16px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: var(--bg);
        }

        .upload-drop:hover {
            border-color: var(--primary);
            background: #eff6ff;
        }
    </style>
@endpush

@section('content')

    {{-- ── FLASH MESSAGE ── --}}
    @if (session('sukses'))
        <div id="flash-sukses" class="alert alert-success rounded-3 mb-3 d-flex align-items-center gap-2"
            style="font-size:.85rem;">
            <i class="bi bi-check-circle-fill"></i> {{ session('sukses') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-3" style="font-size:.85rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    {{-- ── HEADER ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-0">Materi Ajar</h4>
            <p style="font-size:.85rem;color:var(--muted);margin:0;">Kelola semua materi pembelajaran yang Anda buat.</p>
        </div>
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
            data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Materi
        </button>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="row g-3 mb-4">
        @php
            $statCards = [
                ['bi-journal-richtext', '#eff6ff', 'var(--primary)', $stats['total'], 'Total Materi'],
                ['bi-check-circle-fill', 'var(--success-soft)', 'var(--success)', $stats['aktif'], 'Aktif / Terbit'],
                ['bi-pencil-square', 'var(--accent-soft)', 'var(--warning)', $stats['draft'], 'Draft'],
                ['bi-archive-fill', '#f1f5f9', '#94a3b8', $stats['arsip'], 'Diarsipkan'],
            ];
        @endphp
        @foreach ($statCards as $s)
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i
                            class="bi {{ $s[0] }}"></i></div>
                    <div>
                        <div class="stat-val">{{ $s[3] }}</div>
                        <div class="stat-label">{{ $s[4] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── FILTER BAR ── --}}
    <div class="filter-bar mb-4">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari judul materi, topik, atau kata kunci…" />
        </div>
        <select class="filter-select" id="filterJenjang">
            <option value="">Semua Jenjang</option>
            <option value="sd">SD</option>
            <option value="smp">SMP</option>
            <option value="sma">SMA</option>
        </select>
        <select class="filter-select" id="filterMapel">
            <option value="">Semua Mata Pelajaran</option>
            <option value="matematika">Matematika</option>
            <option value="fisika">Fisika</option>
            <option value="kimia">Kimia</option>
            <option value="biologi">Biologi</option>
            <option value="b. inggris">B. Inggris</option>
        </select>
        <select class="filter-select" id="filterTipe">
            <option value="">Semua Tipe</option>
            <option value="pdf">PDF</option>
            <option value="video">Video</option>
            <option value="doc">Dokumen</option>
            <option value="ppt">Presentasi</option>
            <option value="quiz">Kuis</option>
        </select>
        <select class="filter-select" id="filterStatus">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="draft">Draft</option>
            <option value="arsip">Arsip</option>
        </select>
        <div class="view-toggle ms-auto">
            <button class="view-btn active" id="btnTable" title="Tabel"><i class="bi bi-list-ul"></i></button>
            <button class="view-btn" id="btnGrid" title="Grid"><i class="bi bi-grid-3x3-gap-fill"></i></button>
        </div>
    </div>

    {{-- ══════════════════════════════════════ --}}
    {{-- TABLE VIEW                             --}}
    {{-- ══════════════════════════════════════ --}}
    <div id="tableView">
        <div class="card-box mb-4">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-table"></i> Daftar Materi</div>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size:.8rem;color:var(--muted);">Menampilkan {{ $materi->count() }} materi</span>
                    <select class="filter-select" style="padding:6px 28px 6px 10px;font-size:.8rem;">
                        <option>8 per halaman</option>
                        <option>16 per halaman</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table-materi">
                    <thead>
                        <tr>
                            <th style="width:40px;"><input type="checkbox" class="form-check-input" /></th>
                            <th>Materi</th>
                            <th>Jenjang</th>
                            <th>Mata Pelajaran</th>
                            <th>Tipe</th>
                            <th>Ukuran / Durasi</th>
                            <th>Status</th>
                            <th>Terakhir Diubah</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materi as $m)
                            <tr data-jenjang="{{ strtolower($m->jenjang) }}"
                                data-mapel="{{ strtolower($m->mata_pelajaran) }}" data-tipe="{{ $m->tipe }}"
                                data-status="{{ $m->status }}" data-judul="{{ strtolower($m->judul) }}">
                                <td><input type="checkbox" class="form-check-input" value="{{ $m->id }}" /></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="materi-icon-wrap" style="background:{{ $m->warna_bg }};"><i
                                                class="bi {{ $m->ikon }}" style="color:{{ $m->warna_ikon }};"></i>
                                        </div>
                                        <div>
                                            <div class="materi-title">{{ $m->judul }}</div>
                                            <div class="materi-desc">{{ $m->deskripsi ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-jenjang" style="background:#dbeafe;color:#1d4ed8;">
                                        {{ strtoupper($m->jenjang) }}
                                    </span>
                                </td>
                                <td><span class="badge-mapel">{{ $m->mata_pelajaran }}</span></td>
                                <td><span class="badge-tipe {{ $m->tipe }}">{{ strtoupper($m->tipe) }}</span></td>
                                <td style="font-size:.8rem;color:var(--muted);">
                                    {{ $m->file_size ?? ($m->link_video ? 'Link Video' : '-') }}
                                </td>
                                <td><span class="badge-status {{ $m->status }}">{{ ucfirst($m->status) }}</span></td>
                                <td style="font-size:.8rem;color:var(--muted);">{{ $m->updated_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn-action suc" title="Lihat"
                                            onclick="bukaDetail('{{ $m->id }}')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn-action" title="Ubah"
                                            onclick="bukaEdit('{{ $m->id }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn-action del" title="Hapus"
                                            onclick="bukaHapus('{{ $m->id }}', '{{ addslashes($m->judul) }}')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5" style="color:var(--muted);font-size:.85rem;">
                                    <i class="bi bi-inbox"
                                        style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.4;"></i>
                                    Belum ada materi. Klik <strong>Tambah Materi</strong> untuk mulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Bulk Action + Pagination --}}
            <div class="d-flex align-items-center justify-content-between px-4 py-3 flex-wrap gap-2"
                style="border-top:1px solid var(--border);">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm rounded-2 fw-semibold"
                        style="background:var(--danger-soft);color:var(--danger);border:none;font-size:.78rem;"
                        onclick="bukaHapusMassal()">
                        <i class="bi bi-trash3 me-1"></i> Hapus Terpilih
                    </button>
                    <button class="btn btn-sm rounded-2 fw-semibold"
                        style="background:#f1f5f9;border:none;color:var(--muted);font-size:.78rem;">
                        <i class="bi bi-archive me-1"></i> Arsipkan
                    </button>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span style="font-size:.78rem;color:var(--muted);">Halaman 1 dari 5</span>
                    <div class="d-flex gap-1">
                        <a href="#" class="page-btn disabled"><i class="bi bi-chevron-left"></i></a>
                        <a href="#" class="page-btn active">1</a>
                        <a href="#" class="page-btn">2</a>
                        <a href="#" class="page-btn">3</a>
                        <span class="page-btn" style="cursor:default;">…</span>
                        <a href="#" class="page-btn">5</a>
                        <a href="#" class="page-btn"><i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>{{-- /.card-box --}}
    </div>{{-- /#tableView --}}

    {{-- ══════════════════════════════════════ --}}
    {{-- GRID VIEW                              --}}
    {{-- ══════════════════════════════════════ --}}
    <div id="gridView" style="display:none;">
        <div class="row g-3 mb-4">
            @forelse($materi as $m)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="materi-card">
                        <div class="materi-card-thumb" style="background:{{ $m->warna_bg }};">
                            <i class="bi {{ $m->ikon }}" style="color:{{ $m->warna_ikon }};"></i>
                            <div style="position:absolute;top:10px;right:10px;">
                                <span class="badge-status {{ $m->status }}">{{ ucfirst($m->status) }}</span>
                            </div>
                        </div>
                        <div class="materi-card-body">
                            <div class="materi-card-title">{{ $m->judul }}</div>
                            <div class="materi-card-meta mb-2">{{ $m->deskripsi ?? '-' }}</div>
                            <div class="d-flex gap-1 flex-wrap">
                                <span class="badge-jenjang"
                                    style="background:#dbeafe;color:#1d4ed8;">{{ strtoupper($m->jenjang) }}</span>
                                <span class="badge-mapel">{{ $m->mata_pelajaran }}</span>
                                <span class="badge-tipe {{ $m->tipe }}">{{ strtoupper($m->tipe) }}</span>
                            </div>
                        </div>
                        <div class="materi-card-footer">
                            <span style="font-size:.72rem;color:var(--muted);">
                                {{ $m->file_size ?? ($m->link_video ? 'Link Video' : '-') }}
                            </span>
                            <div class="d-flex gap-1">
                                <button class="btn-action suc" title="Lihat"
                                    onclick="bukaDetail('{{ $m->id }}')">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn-action" title="Ubah" onclick="bukaEdit('{{ $m->id }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-action del" title="Hapus"
                                    onclick="bukaHapus('{{ $m->id }}', '{{ addslashes($m->judul) }}')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5" style="color:var(--muted);font-size:.85rem;">
                    <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.4;"></i>
                    Belum ada materi.
                </div>
            @endforelse
        </div>
    </div>{{-- /#gridView --}}


    {{-- ══════════════════════════════════════ --}}
    {{-- MODAL TAMBAH                           --}}
    {{-- ══════════════════════════════════════ --}}
    <div class="modal fade modal-custom" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-plus-circle-fill me-2" style="color:var(--primary);"></i>Tambah Materi Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="/tutor/materi" id="formTambah" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="padding:20px 22px;max-height:70vh;overflow-y:auto;">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold" style="font-size:13px;">Judul Materi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control"
                                    placeholder="Contoh: Trigonometri – Dasar dan Penerapan" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold" style="font-size:13px;">Deskripsi Singkat</label>
                                <textarea name="deskripsi" class="form-control" rows="2" placeholder="Jelaskan isi materi secara singkat…"></textarea>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size:13px;">Jenjang <span
                                        class="text-danger">*</span></label>
                                <select name="jenjang" class="form-select" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size:13px;">Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="mata_pelajaran" class="form-control"
                                    placeholder="Contoh: Matematika" required />
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size:13px;">Kelas <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="kelas" class="form-control" placeholder="Contoh: Kelas 10"
                                    required />
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size:13px;">Status Publikasi</label>
                                <select name="status" class="form-select">
                                    <option value="aktif">Aktif (Publik)</option>
                                    <option value="nonaktif">Draft (Belum Dipublikasi)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-2 fw-semibold"
                            style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-2 fw-semibold"
                            onclick="document.getElementById('tambah_status').value='draft'"
                            style="background:var(--bg);color:var(--primary);font-size:.85rem;border:1px solid var(--primary);">
                            <i class="bi bi-floppy me-1"></i> Simpan Draft
                        </button>
                        <button type="submit" class="btn rounded-2 fw-semibold"
                            onclick="document.getElementById('tambah_status').value='aktif'"
                            style="background:var(--primary);color:#fff;font-size:.85rem;border:none;">
                            <i class="bi bi-check2-circle me-1"></i> Simpan & Terbitkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>{{-- /#modalTambah --}}


    {{-- ══════════════════════════════════════ --}}
    {{-- MODAL DETAIL                           --}}
    {{-- ══════════════════════════════════════ --}}
    <div class="modal fade modal-custom" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-eye-fill me-2" style="color:var(--success);"></i>Detail Materi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Header Info --}}
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4"
                        style="background:var(--bg);border:1px solid var(--border);">
                        <div id="detail_ikon_wrap" class="materi-icon-wrap"
                            style="width:52px;height:52px;border-radius:14px;font-size:1.4rem;flex-shrink:0;">
                            <i id="detail_ikon"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div id="detail_judul" style="font-weight:700;font-size:1rem;color:var(--text);"></div>
                            <div id="detail_deskripsi" style="font-size:.78rem;color:var(--muted);margin-top:3px;"></div>
                        </div>
                        <span id="detail_status" class="badge-status"></span>
                    </div>
                    {{-- Grid Info --}}
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Jenjang</div>
                            <span id="detail_jenjang" class="badge-jenjang"
                                style="background:#dbeafe;color:#1d4ed8;font-size:.75rem;"></span>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Mata Pelajaran</div>
                            <span id="detail_mapel" class="badge-mapel" style="font-size:.75rem;"></span>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Kelas</div>
                            <div id="detail_kelas" style="font-size:.84rem;font-weight:600;color:var(--text);"></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Tipe</div>
                            <span id="detail_tipe" class="badge-tipe" style="font-size:.75rem;"></span>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Topik / Bab</div>
                            <div id="detail_topik" style="font-size:.84rem;color:var(--text);"></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Ukuran</div>
                            <div id="detail_ukuran" style="font-size:.84rem;color:var(--text);"></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                Dibuat</div>
                            <div id="detail_tanggal" style="font-size:.84rem;color:var(--text);"></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="font-size:.7rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:4px;">
                                File / Link</div>
                            <div id="detail_link_wrap"></div>
                        </div>
                    </div>
                    {{-- Catatan --}}
                    <div class="p-3 rounded-3" style="background:var(--success-soft);border:1px solid #a7f3d0;">
                        <div style="font-size:.73rem;font-weight:700;color:var(--success);margin-bottom:6px;">
                            <i class="bi bi-chat-left-text-fill me-1"></i> Catatan untuk Siswa
                        </div>
                        <div id="detail_catatan" style="font-size:.84rem;color:var(--text);line-height:1.6;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn rounded-2 fw-semibold"
                        style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>{{-- /#modalDetail --}}


    {{-- ══════════════════════════════════════ --}}
    {{-- MODAL UBAH                             --}}
    {{-- ══════════════════════════════════════ --}}
    <div class="modal fade modal-custom" id="modalUbah" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2" style="color:var(--warning);"></i>Ubah Materi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="formEdit" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label-custom">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="edit_judul" class="form-control-custom"
                                    required />
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Deskripsi</label>
                                <textarea name="deskripsi" id="edit_deskripsi" class="form-control-custom" rows="2"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Jenjang <span class="text-danger">*</span></label>
                                <select name="jenjang" id="edit_jenjang" class="form-control-custom" required>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Mata Pelajaran <span class="text-danger">*</span></label>
                                <input type="text" name="mata_pelajaran" id="edit_mapel" class="form-control-custom"
                                    required />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Kelas <span class="text-danger">*</span></label>
                                <input type="text" name="kelas" id="edit_kelas" class="form-control-custom"
                                    required />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Tipe <span class="text-danger">*</span></label>
                                <select name="tipe" id="edit_tipe" class="form-control-custom" required>
                                    <option value="pdf">PDF</option>
                                    <option value="video">Video</option>
                                    <option value="doc">Dokumen</option>
                                    <option value="ppt">Presentasi</option>
                                    <option value="quiz">Kuis</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Topik</label>
                                <input type="text" name="topik" id="edit_topik" class="form-control-custom" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Status <span class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-control-custom" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="draft">Draft</option>
                                    <option value="arsip">Arsip</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Link Video</label>
                                <input type="url" name="link_video" id="edit_link_video" class="form-control-custom"
                                    placeholder="https://youtube.com/..." />
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Ganti File (opsional)</label>
                                <input type="file" name="file" class="form-control-custom"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4" />
                                <div id="edit_file_info" style="font-size:.75rem;color:var(--success);margin-top:4px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Catatan untuk Siswa</label>
                                <textarea name="catatan" id="edit_catatan" class="form-control-custom" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-2 fw-semibold"
                            style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-2 fw-semibold"
                            style="background:var(--warning);color:#fff;font-size:.85rem;border:none;">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>{{-- /#modalUbah --}}


    {{-- ══════════════════════════════════════ --}}
    {{-- MODAL HAPUS                            --}}
    {{-- ══════════════════════════════════════ --}}
    <div class="modal fade modal-custom" id="modalHapus" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 text-center">
                <h5 class="fw-bold mb-2" style="color:var(--text);">Hapus Materi?</h5>
                <p style="color:var(--muted);font-size:.86rem;margin-bottom:4px;">Anda akan menghapus materi:</p>
                <p id="hapus_judul" class="fw-semibold mb-3" style="font-size:.9rem;color:var(--text);"></p>
                <div class="p-3 rounded-3 mb-3 text-start"
                    style="background:var(--danger-soft);border:1px solid #fecaca;">
                    <div style="font-size:.78rem;color:var(--danger);font-weight:600;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Peringatan
                    </div>
                    <div style="font-size:.77rem;color:#7f1d1d;margin-top:4px;">
                        Materi yang dihapus tidak dapat dikembalikan. File terkait juga akan dihapus permanen.
                    </div>
                </div>
                <form id="formHapus" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2">
                        <button type="button" class="btn rounded-2 fw-semibold flex-fill"
                            style="background:#f1f5f9;color:var(--muted);border:none;font-size:.85rem;"
                            data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn rounded-2 fw-semibold flex-fill"
                            style="background:var(--danger);color:#fff;border:none;font-size:.85rem;">
                            <i class="bi bi-trash3 me-1"></i> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>{{-- /#modalHapus --}}

@endsection

@push('scripts')
    <script>
        // ── Toggle Table / Grid View ──
        const btnTable = document.getElementById('btnTable');
        const btnGrid = document.getElementById('btnGrid');
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');

        btnTable.addEventListener('click', () => {
            tableView.style.display = 'block';
            gridView.style.display = 'none';
            btnTable.classList.add('active');
            btnGrid.classList.remove('active');
        });
        btnGrid.addEventListener('click', () => {
            tableView.style.display = 'none';
            gridView.style.display = 'block';
            btnGrid.classList.add('active');
            btnTable.classList.remove('active');
        });

        // ── Flash auto-hide ──
        @if (session('sukses'))
            setTimeout(() => {
                const el = document.getElementById('flash-sukses');
                if (el) {
                    el.style.transition = 'opacity .5s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                }
            }, 3000);
        @endif

        // ── Filter client-side real-time ──
        function applyFilter() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const jenjang = document.getElementById('filterJenjang').value.toLowerCase();
            const mapel = document.getElementById('filterMapel').value.toLowerCase();
            const tipe = document.getElementById('filterTipe').value.toLowerCase();
            const status = document.getElementById('filterStatus').value.toLowerCase();

            document.querySelectorAll('#tableView tbody tr').forEach(row => {
                if (!row.dataset.judul) return;
                const ok =
                    (!search || row.dataset.judul.includes(search)) &&
                    (!jenjang || row.dataset.jenjang === jenjang) &&
                    (!mapel || row.dataset.mapel === mapel) &&
                    (!tipe || row.dataset.tipe === tipe) &&
                    (!status || row.dataset.status === status);
                row.style.display = ok ? '' : 'none';
            });
        }
        document.getElementById('searchInput').addEventListener('input', applyFilter);
        ['filterJenjang', 'filterMapel', 'filterTipe', 'filterStatus'].forEach(id => {
            document.getElementById(id).addEventListener('change', applyFilter);
        });

        // ── Buka Modal Detail ──
        function bukaDetail(id) {
            fetch('/tutor/materi/' + id + '/json')
                .then(r => r.json())
                .then(m => {
                    const ikonMap = {
                        pdf: {
                            ikon: 'bi-file-earmark-pdf-fill',
                            bg: '#fee2e2',
                            warna: '#dc2626'
                        },
                        video: {
                            ikon: 'bi-camera-video-fill',
                            bg: '#dbeafe',
                            warna: '#2563eb'
                        },
                        doc: {
                            ikon: 'bi-file-earmark-word-fill',
                            bg: '#e0f2fe',
                            warna: '#0369a1'
                        },
                        ppt: {
                            ikon: 'bi-file-earmark-slides-fill',
                            bg: '#fef3c7',
                            warna: '#d97706'
                        },
                        quiz: {
                            ikon: 'bi-patch-question-fill',
                            bg: '#dcfce7',
                            warna: '#16a34a'
                        },
                    };
                    const ti = ikonMap[m.tipe] || {
                        ikon: 'bi-file-earmark',
                        bg: '#f1f5f9',
                        warna: '#64748b'
                    };

                    document.getElementById('detail_ikon').className = 'bi ' + ti.ikon;
                    document.getElementById('detail_ikon_wrap').style.background = ti.bg;
                    document.getElementById('detail_ikon').style.color = ti.warna;
                    document.getElementById('detail_judul').textContent = m.judul;
                    document.getElementById('detail_deskripsi').textContent = m.deskripsi ?? '-';
                    document.getElementById('detail_jenjang').textContent = m.jenjang.toUpperCase();
                    document.getElementById('detail_mapel').textContent = m.mata_pelajaran;
                    document.getElementById('detail_kelas').textContent = m.kelas;
                    document.getElementById('detail_tipe').textContent = m.tipe.toUpperCase();
                    document.getElementById('detail_tipe').className = 'badge-tipe ' + m.tipe;
                    document.getElementById('detail_topik').textContent = m.topik ?? '-';
                    document.getElementById('detail_catatan').textContent = m.catatan ?? '-';
                    document.getElementById('detail_status').textContent = m.status.charAt(0).toUpperCase() + m.status
                        .slice(1);
                    document.getElementById('detail_status').className = 'badge-status ' + m.status;
                    document.getElementById('detail_ukuran').textContent = m.file_size ?? (m.link_video ? 'Link Video' :
                        '-');

                    const tgl = new Date(m.created_at);
                    document.getElementById('detail_tanggal').textContent =
                        tgl.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });

                    const linkWrap = document.getElementById('detail_link_wrap');
                    if (m.file_path) {
                        linkWrap.innerHTML = `<a href="/storage/${m.file_path}" target="_blank"
                            class="btn btn-sm rounded-2 fw-semibold"
                            style="background:#eff6ff;color:var(--primary);border:1px solid var(--primary);font-size:.8rem;">
                            <i class="bi bi-download me-1"></i> Download File
                        </a>`;
                    } else if (m.link_video) {
                        linkWrap.innerHTML = `<a href="${m.link_video}" target="_blank"
                            class="btn btn-sm rounded-2 fw-semibold"
                            style="background:#dbeafe;color:#1d4ed8;border:none;font-size:.8rem;">
                            <i class="bi bi-play-circle me-1"></i> Buka Video
                        </a>`;
                    } else {
                        linkWrap.innerHTML = `<span style="font-size:.8rem;color:var(--muted);">Tidak ada file</span>`;
                    }

                    new bootstrap.Modal(document.getElementById('modalDetail')).show();
                });
        }

        // ── Buka Modal Edit ──
        function bukaEdit(id) {
            fetch('/tutor/materi/' + id + '/json')
                .then(r => r.json())
                .then(m => {
                    document.getElementById('edit_judul').value = m.judul;
                    document.getElementById('edit_deskripsi').value = m.deskripsi ?? '';
                    document.getElementById('edit_jenjang').value = m.jenjang;
                    document.getElementById('edit_mapel').value = m.mata_pelajaran;
                    document.getElementById('edit_kelas').value = m.kelas;
                    document.getElementById('edit_tipe').value = m.tipe ?? 'pdf';
                    document.getElementById('edit_topik').value = m.topik ?? '';
                    document.getElementById('edit_status').value = m.status;
                    document.getElementById('edit_link_video').value = m.link_video ?? '';
                    document.getElementById('edit_catatan').value = m.catatan ?? '';
                    document.getElementById('edit_file_info').textContent =
                        m.file_path ?
                        '📎 File saat ini: ' + m.file_path.split('/').pop() + (m.file_size ? ' (' + m.file_size + ')' :
                            '') :
                        '';
                    document.getElementById('formEdit').action = '/tutor/materi/' + id;
                    new bootstrap.Modal(document.getElementById('modalUbah')).show();
                });
        }

        // ── Buka Modal Hapus ──
        function bukaHapus(id, judul) {
            document.getElementById('hapus_judul').textContent = '"' + judul + '"';
            document.getElementById('formHapus').action = '/tutor/materi/' + id;
            new bootstrap.Modal(document.getElementById('modalHapus')).show();
        }
    </script>
@endpush
