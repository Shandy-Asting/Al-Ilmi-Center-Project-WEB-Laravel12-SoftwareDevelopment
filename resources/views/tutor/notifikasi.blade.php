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
        .filter-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            border: 1.5px solid var(--border);
            background: var(--card-bg);
            color: var(--muted);
        }

        .filter-tab.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .filter-tab:hover:not(.active) {
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .notif-item {
            display: flex;
            gap: 14px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            transition: background .15s;
            cursor: pointer;
            position: relative;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: #f8faff;
        }

        .notif-item.unread {
            background: #f0f6ff;
        }

        .notif-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary);
            border-radius: 0 3px 3px 0;
        }

        .notif-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .notif-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .notif-desc {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.5;
        }

        .notif-time {
            font-size: 11px;
            color: var(--muted);
            margin-top: 6px;
        }

        .notif-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            flex-shrink: 0;
            margin-top: 6px;
        }

        .btn-notif {
            border: none;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .card-box {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        @media(max-width:767px) {
            .notif-item {
                flex-wrap: wrap;
                padding: 12px 14px;
            }

            .filter-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 4px;
            }

            .filter-tab {
                min-width: auto;
                flex: none;
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">🔔 Notifikasi</h4>
            <div style="font-size:13px;color:var(--muted);">
                Dashboard / <span style="color:var(--primary);font-weight:600;">Notifikasi</span>
            </div>
        </div>
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--bg);color:var(--primary);border-radius:10px;border:1.5px solid var(--primary);font-size:12px;">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </div>

    <div class="filter-tabs">
        <div class="filter-tab active">Semua <span
                style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">4</span>
        </div>
        <div class="filter-tab">Belum Dibaca</div>
        <div class="filter-tab">Les Privat</div>
        <div class="filter-tab">Pembayaran</div>
        <div class="filter-tab">Sistem</div>
    </div>

    {{-- HARI INI --}}
    <div
        style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">
        Hari Ini</div>
    <div class="card-box mb-3">

        <div class="notif-item unread">
            <div class="notif-icon" style="background:var(--danger-soft);color:var(--danger);">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <div style="flex:1;">
                <div class="notif-title">📥 Pesanan Les Baru!</div>
                <div class="notif-desc">
                    <strong>Andi Pratama</strong> memesan sesi les privat
                    <strong>Matematika – Integral</strong> untuk
                    <strong>Jumat, 2 Mei 2026 · 14:00 WIB</strong> (90 menit, Online).
                    Segera konfirmasi!
                </div>
                <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 jam yang lalu</div>
            </div>
            <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
                <div class="notif-dot"></div>
                <a href="/tutor/les-privat" class="btn-notif" style="background:var(--primary);color:#fff;">Lihat
                    Pesanan</a>
            </div>
        </div>

        <div class="notif-item unread">
            <div class="notif-icon" style="background:var(--success-soft);color:var(--success);">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div style="flex:1;">
                <div class="notif-title">💰 Bukti Pembayaran Diterima</div>
                <div class="notif-desc">
                    <strong>Siti Rahma</strong> telah mengunggah bukti pembayaran untuk sesi
                    <strong>Fisika – Gelombang</strong> senilai <strong>Rp 75.000</strong>.
                    Silakan cek dan konfirmasi pembayaran.
                </div>
                <div class="notif-time"><i class="bi bi-clock me-1"></i> 3 jam yang lalu</div>
            </div>
            <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
                <div class="notif-dot"></div>
                <a href="/tutor/les-privat" class="btn-notif" style="background:var(--success);color:#fff;">Konfirmasi</a>
            </div>
        </div>

        <div class="notif-item unread">
            <div class="notif-icon" style="background:var(--accent-soft);color:var(--warning);">
                <i class="bi bi-star-fill"></i>
            </div>
            <div style="flex:1;">
                <div class="notif-title">⭐ Ulasan Baru dari Siswa</div>
                <div class="notif-desc">
                    <strong>Maya Putri</strong> memberikan ulasan bintang 5:
                    "Pak Budi sangat sabar dan penjelasannya mudah dipahami. Nilai Matematika saya naik!"
                </div>
                <div class="notif-time"><i class="bi bi-clock me-1"></i> 5 jam yang lalu</div>
            </div>
            <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
                <div class="notif-dot"></div>
                <button class="btn-notif" style="background:#eff6ff;color:var(--primary);">Lihat</button>
            </div>
        </div>

        <div class="notif-item unread">
            <div class="notif-icon" style="background:var(--info-soft);color:var(--info);">
                <i class="bi bi-calendar-x-fill"></i>
            </div>
            <div style="flex:1;">
                <div class="notif-title">❌ Siswa Membatalkan Pesanan</div>
                <div class="notif-desc">
                    <strong>Farhan Maulana</strong> membatalkan pesanan sesi
                    <strong>B. Inggris – Grammar</strong> untuk
                    <strong>Senin, 4 Mei 2026 · 15:00 WIB</strong>.
                </div>
                <div class="notif-time"><i class="bi bi-clock me-1"></i> 6 jam yang lalu</div>
            </div>
            <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
                <div class="notif-dot"></div>
            </div>
        </div>
    </div>

    {{-- KEMARIN --}}
    <div
        style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">
        Kemarin</div>
    <div class="card-box mb-4">

        <div class="notif-item">
            <div class="notif-icon" style="background:var(--success-soft);color:var(--success);">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div style="flex:1;">
                <div class="notif-title">✅ Sesi Selesai Dikonfirmasi</div>
                <div class="notif-desc">
                    Sesi <strong>Matematika – Trigonometri</strong> dengan <strong>Aldi Pratama</strong>
                    telah selesai dan pembayaran <strong>Rp 75.000</strong> dikonfirmasi lunas.
                </div>
                <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
            </div>
        </div>

        <div class="notif-item">
            <div class="notif-icon" style="background:var(--primary-light,#eff6ff);color:var(--primary);">
                <i class="bi bi-gear-fill"></i>
            </div>
            <div style="flex:1;">
                <div class="notif-title">⚙️ Update Sistem</div>
                <div class="notif-desc">
                    Al Ilmi Center telah diperbarui. Fitur baru: konfirmasi pembayaran via foto bukti transfer
                    dan notifikasi real-time untuk pesanan masuk.
                </div>
                <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
            </div>
        </div>

    </div>

    <div class="text-center mb-4">
        <button class="btn fw-bold px-4 py-2"
            style="background:var(--card-bg);border:1.5px solid var(--border);border-radius:10px;font-size:13px;color:var(--muted);">
            <i class="bi bi-arrow-down me-1"></i> Muat Notifikasi Lebih Lama
        </button>
    </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
@endpush
