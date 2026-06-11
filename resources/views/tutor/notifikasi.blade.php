@extends('layouts.app')

@section('title', 'Notifikasi - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Notifikasi')
@section('page-sub', 'Dashboard / Notifikasi')

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
        /* ─────────────────────────────────────────────────────
               ROOT / TOKENS
            ───────────────────────────────────────────────────── */
        .nt-page {
            --nt-navy: #0f2342;
            --nt-blue: #1d4ed8;
            --nt-slate: #64748b;
            --nt-line: #e8ecf0;
            --nt-bg: #f5f7fa;
            --nt-card: #ffffff;
            --nt-unread: #f0f6ff;
            --nt-accent: #0f2342;
            --nt-red: #dc2626;
            --nt-green: #16a34a;
            --nt-amber: #d97706;
            --nt-info: #0284c7;
        }

        /* ─────────────────────────────────────────────────────
               PAGE HEADER
            ───────────────────────────────────────────────────── */
        .nt-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .nt-header-title {
            font-size: clamp(16px, 4vw, 20px);
            font-weight: 700;
            color: var(--nt-navy);
            line-height: 1.2;
            margin-bottom: 3px;
        }

        .nt-header-sub {
            font-size: 12px;
            color: var(--nt-slate);
        }

        .nt-header-sub span {
            color: var(--nt-blue);
            font-weight: 600;
        }

        .nt-mark-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 9px;
            border: 1.5px solid var(--nt-navy);
            background: transparent;
            color: var(--nt-navy);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all .15s;
            flex-shrink: 0;
        }

        .nt-mark-btn:hover {
            background: var(--nt-navy);
            color: #fff;
        }

        /* ─────────────────────────────────────────────────────
               ALERT
            ───────────────────────────────────────────────────── */
        .nt-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3px solid var(--nt-green);
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--nt-green);
        }

        /* ─────────────────────────────────────────────────────
               FILTER CHIPS  — scroll horizontal tanpa wrap di mobile
            ───────────────────────────────────────────────────── */
        .nt-filters {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 2px;
            /* Penting: jangan pakai flex-wrap agar tetap satu baris */
        }

        .nt-filters::-webkit-scrollbar {
            display: none;
        }

        .nt-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid var(--nt-line);
            background: var(--nt-card);
            color: var(--nt-slate);
            white-space: nowrap;
            flex-shrink: 0;
            transition: all .15s;
            user-select: none;
        }

        .nt-chip.active {
            background: var(--nt-navy);
            color: #fff;
            border-color: var(--nt-navy);
        }

        .nt-chip:hover:not(.active) {
            border-color: var(--nt-navy);
            color: var(--nt-navy);
        }

        .nt-chip-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
        }

        /* ─────────────────────────────────────────────────────
               GRUP LABEL
            ───────────────────────────────────────────────────── */
        .nt-group-label {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--nt-slate);
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 0 2px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nt-group-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--nt-line);
        }

        /* ─────────────────────────────────────────────────────
               CARD WRAPPER
            ───────────────────────────────────────────────────── */
        .nt-card {
            background: var(--nt-card);
            border: 1px solid var(--nt-line);
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        /* ─────────────────────────────────────────────────────
               NOTIF ITEM
               Layout: [icon] [konten flex-1] [aksi]
               Di mobile: aksi turun ke bawah konten (wrap)
            ───────────────────────────────────────────────────── */
        .nt-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--nt-line);
            position: relative;
            cursor: pointer;
            transition: background .15s;
        }

        .nt-item:last-child {
            border-bottom: none;
        }

        .nt-item:hover {
            background: var(--nt-bg);
        }

        /* Unread: highlight biru muda + garis kiri */
        .nt-item.unread {
            background: var(--nt-unread);
        }

        .nt-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--nt-navy);
            border-radius: 0 3px 3px 0;
        }

        /* Icon */
        .nt-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Konten tengah */
        .nt-body {
            flex: 1;
            min-width: 0;
            /* penting agar teks truncate bekerja */
        }

        .nt-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--nt-navy);
            margin-bottom: 3px;
            /* baris tunggal, tidak wrap di mobile jika terlalu panjang */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nt-desc {
            font-size: 12.5px;
            color: var(--nt-slate);
            line-height: 1.55;
            /* max 2 baris */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .nt-time {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: var(--nt-slate);
            margin-top: 6px;
        }

        /* Kolom kanan: dot + tombol */
        .nt-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
            /* Minimal lebar agar tidak geser */
            min-width: 36px;
        }

        .nt-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--nt-navy);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .nt-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 12px;
            border-radius: 7px;
            border: none;
            background: var(--nt-navy);
            color: #fff;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: opacity .15s;
        }

        .nt-action-btn:hover {
            opacity: .85;
        }

        /* ─────────────────────────────────────────────────────
               EMPTY STATE
            ───────────────────────────────────────────────────── */
        .nt-empty {
            text-align: center;
            padding: 56px 20px;
            background: var(--nt-card);
            border: 1px solid var(--nt-line);
            border-radius: 14px;
            color: var(--nt-slate);
        }

        .nt-empty-icon {
            font-size: 2.4rem;
            display: block;
            margin-bottom: 12px;
            opacity: .4;
        }

        .nt-empty-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--nt-navy);
            margin-bottom: 4px;
        }

        .nt-empty-sub {
            font-size: 13px;
        }

        /* ─────────────────────────────────────────────────────
               RESPONSIVE
            ───────────────────────────────────────────────────── */

        /* HP kecil: title bisa 2 baris, desc tetap 2 baris */
        @media (max-width: 480px) {
            .nt-item {
                padding: 12px 14px;
                gap: 10px;
            }

            .nt-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            /* Judul boleh wrap di HP kecil, jangan clip */
            .nt-title {
                white-space: normal;
                overflow: visible;
                text-overflow: unset;
                font-size: 13px;
            }

            /* Aksi (tombol) pindah ke bawah deskripsi dalam aliran normal */
            .nt-item {
                flex-wrap: wrap;
            }

            /* icon tetap di kiri, body & actions ikut flow */
            .nt-actions {
                /* Mulai dari setelah body — tapi tetap di kanan icon */
                /* Kita buat actions rata kiri supaya tidak mengambang */
                flex-direction: row;
                align-items: center;
                min-width: unset;
                width: 100%;
                padding-left: 52px;
                /* lebar icon + gap */
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 6px;
            }

            .nt-body {
                /* Biarkan body dan actions berbagi lebar dengan icon */
                /* icon sudah flex-shrink:0 jadi body otomatis mengisi sisa */
            }

            .nt-mark-btn {
                padding: 7px 12px;
                font-size: 12px;
            }

            .nt-header {
                margin-bottom: 16px;
            }
        }

        /* Layar sangat kecil */
        @media (max-width: 360px) {
            .nt-chip {
                padding: 5px 11px;
                font-size: 12px;
            }

            .nt-action-btn {
                font-size: 11px;
                padding: 4px 10px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="nt-page">

        {{-- ═══════════════ HEADER ═══════════════ --}}
        <div class="nt-header">
            <div>
                <div class="nt-header-title">🔔 Notifikasi</div>
                <div class="nt-header-sub">
                    Dashboard / <span>Notifikasi</span>
                </div>
            </div>
            <form method="POST" action="/tutor/notifikasi/tandai-semua">
                @csrf
                <button type="submit" class="nt-mark-btn">
                    <i class="bi bi-check2-all"></i>
                    <span>Tandai Semua Dibaca</span>
                </button>
            </form>
        </div>

        {{-- ═══════════════ ALERT ═══════════════ --}}
        @if (session('sukses'))
            <div class="nt-alert">
                <i class="bi bi-check-circle-fill" style="font-size:16px;flex-shrink:0;"></i>
                {{ session('sukses') }}
            </div>
        @endif

        {{-- ═══════════════ FILTER CHIPS ═══════════════ --}}
        @php
            $ikonMap = [
                'les_privat' => ['bi-person-plus-fill', '#fff1f2', '#dc2626'],
                'pembayaran' => ['bi-cash-coin', '#f0fdf4', '#16a34a'],
                'sistem' => ['bi-gear-fill', '#eff6ff', '#1d4ed8'],
                'ulasan' => ['bi-star-fill', '#fffbeb', '#d97706'],
                'jadwal' => ['bi-calendar-x-fill', '#f0f9ff', '#0284c7'],
            ];
        @endphp

        <div class="nt-filters">
            {{-- Semua --}}
            <div class="nt-chip active" onclick="filterNotif(this,'semua')">
                Semua
                @if ($jumlahBelumDibaca > 0)
                    <span class="nt-chip-badge" style="background:#dc2626;color:#fff;">{{ $jumlahBelumDibaca }}</span>
                @endif
            </div>

            {{-- Belum Dibaca --}}
            <div class="nt-chip" onclick="filterNotif(this,'belum')">
                Belum Dibaca
            </div>

            {{-- Per Tipe --}}
            @if (!in_array('les_privat', $tipeDisabled))
                <div class="nt-chip" onclick="filterNotif(this,'les_privat')">
                    Les Privat
                    @if (($perTipe['les_privat'] ?? 0) > 0)
                        <span class="nt-chip-badge"
                            style="background:#dc2626;color:#fff;">{{ $perTipe['les_privat'] }}</span>
                    @endif
                </div>
            @endif

            @if (!in_array('pembayaran', $tipeDisabled))
                <div class="nt-chip" onclick="filterNotif(this,'pembayaran')">
                    Pembayaran
                    @if (($perTipe['pembayaran'] ?? 0) > 0)
                        <span class="nt-chip-badge"
                            style="background:#16a34a;color:#fff;">{{ $perTipe['pembayaran'] }}</span>
                    @endif
                </div>
            @endif

            @if (!in_array('sistem', $tipeDisabled))
                <div class="nt-chip" onclick="filterNotif(this,'sistem')">
                    Sistem
                </div>
            @endif
        </div>

        {{-- ═══════════════ KONTEN NOTIFIKASI ═══════════════ --}}
        @if ($notifikasi->count() === 0)

            {{-- KOSONG --}}
            <div class="nt-empty">
                <i class="bi bi-bell-slash nt-empty-icon"></i>
                <div class="nt-empty-title">Tidak Ada Notifikasi</div>
                <div class="nt-empty-sub">Semua notifikasi akan muncul di sini.</div>
            </div>
        @else
            {{-- Macro/helper: render satu grup notifikasi --}}
            {{-- Kita pakai @include partial atau inline @foreach dengan variabel --}}

            @php
                $grupList = [
                    'Hari Ini' => $hariIni,
                    'Kemarin' => $kemarin,
                    'Minggu Ini' => $mingguIni,
                    'Lebih Lama' => $lebihLama,
                ];
            @endphp

            @foreach ($grupList as $grupLabel => $grupData)
                @if ($grupData->count() > 0)
                    <div class="nt-group-label">{{ $grupLabel }}</div>

                    <div class="nt-card">
                        @foreach ($grupData as $n)
                            @php
                                $ikon = $ikonMap[$n->tipe] ?? ['bi-bell-fill', '#eff6ff', '#1d4ed8'];
                                $ikonClass = $n->ikon ?: $ikon[0];
                                $ikonBg = $n->warna ?? $ikon[1];
                                $ikonFg = $ikon[2];
                                $dibaca = $n->sudah_dibaca ? '1' : '0';
                                $unread = !$n->sudah_dibaca;
                            @endphp

                            <div class="nt-item {{ $unread ? 'unread' : '' }}" data-tipe="{{ $n->tipe }}"
                                data-dibaca="{{ $dibaca }}">

                                {{-- Icon --}}
                                <div class="nt-icon" style="background:{{ $ikonBg }};color:{{ $ikonFg }};">
                                    <i class="bi {{ $ikonClass }}"></i>
                                </div>

                                {{-- Konten --}}
                                <div class="nt-body">
                                    <div class="nt-title">{{ $n->judul }}</div>
                                    <div class="nt-desc">{!! $n->pesan !!}</div>
                                    <div class="nt-time">
                                        <i class="bi bi-clock"></i>
                                        {{ $n->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                {{-- Aksi --}}
                                <div class="nt-actions">
                                    @if ($unread)
                                        <div class="nt-dot"></div>
                                    @endif

                                    @if ($n->url_aksi && $n->label_aksi)
                                        <form method="POST" action="/tutor/notifikasi/{{ $n->id }}/buka">
                                            @csrf
                                            <button type="submit" class="nt-action-btn">
                                                {{ $n->label_aksi }}
                                            </button>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach

        @endif

    </div>{{-- /nt-page --}}
@endsection

@push('scripts')
    <script>
        function filterNotif(el, tipe) {
            /* Update chip aktif */
            document.querySelectorAll('.nt-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            /* Tampilkan / sembunyikan item */
            document.querySelectorAll('.nt-item').forEach(item => {
                let show = false;

                if (tipe === 'semua') {
                    show = true;
                } else if (tipe === 'belum') {
                    show = item.dataset.dibaca === '0';
                } else {
                    show = item.dataset.tipe === tipe;
                }

                item.style.display = show ? '' : 'none';
            });

            /* Sembunyikan grup / card yang semua itemnya tersembunyi */
            document.querySelectorAll('.nt-card').forEach(card => {
                const visible = [...card.querySelectorAll('.nt-item')]
                    .some(i => i.style.display !== 'none');
                card.style.display = visible ? '' : 'none';

                /* Sembunyikan juga label di atasnya */
                const label = card.previousElementSibling;
                if (label && label.classList.contains('nt-group-label')) {
                    label.style.display = visible ? '' : 'none';
                }
            });
        }
    </script>
@endpush
