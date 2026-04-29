@extends('layouts.app')

@section('title', 'Notifikasi - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Notifikasi')
@section('page-sub', 'Dashboard / Notifikasi')

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
    /* ── FILTER TABS ── */
    .filter-tabs{display:flex;gap:6px;margin-bottom:20px;flex-wrap:wrap;}
    .filter-tab{padding:7px 16px;border-radius:20px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;border:1.5px solid var(--border);background:var(--card-bg);color:var(--muted);}
    .filter-tab.active{background:var(--primary);color:#fff;border-color:var(--primary);}
    .filter-tab:hover:not(.active){border-color:var(--primary-light);color:var(--primary);}

    /* ── NOTIF ITEM ── */
    .notif-item{display:flex;gap:14px;padding:16px 20px;border-bottom:1px solid var(--border);transition:background .15s;cursor:pointer;position:relative;}
    .notif-item:last-child{border-bottom:none;}
    .notif-item:hover{background:#f8faff;}
    .notif-item.unread{background:#f0f6ff;}
    .notif-item.unread::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--primary);border-radius:0 3px 3px 0;}
    .notif-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
    .notif-title{font-size:13.5px;font-weight:700;color:var(--text);margin-bottom:4px;}
    .notif-desc{font-size:12.5px;color:var(--muted);line-height:1.5;}
    .notif-time{font-size:11px;color:var(--muted);margin-top:6px;display:flex;align-items:center;gap:4px;}
    .notif-dot{width:8px;height:8px;border-radius:50%;background:var(--primary);flex-shrink:0;}
    .notif-actions{margin-left:auto;flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;}
    .btn-notif{border:none;border-radius:8px;padding:5px 12px;font-size:11.5px;font-weight:600;cursor:pointer;white-space:nowrap;}

    /* CARD BOX */
    .card-box{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;overflow:hidden;}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:.95rem;font-weight:700;color:var(--text);}
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4">
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

{{-- FILTER TABS --}}
<div class="filter-tabs">
    <div class="filter-tab active">Semua <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">3</span></div>
    <div class="filter-tab">Belum Dibaca</div>
    <div class="filter-tab">Les Privat</div>
    <div class="filter-tab">Pembayaran</div>
    <div class="filter-tab">Belajar</div>
    <div class="filter-tab">Sistem</div>
</div>

{{-- NOTIFIKASI HARI INI --}}
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Hari Ini</div>
<div class="card-box mb-3">

    {{-- Notif 1 - Unread --}}
    <div class="notif-item unread">
        <div class="notif-icon" style="background:var(--danger-soft);color:var(--danger);">
            <i class="bi bi-alarm-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">⚠️ Tagihan Segera Jatuh Tempo!</div>
            <div class="notif-desc">
                Tagihan les privat Matematika dengan Pak Budi Santoso (#INV-2026-0412) senilai
                <strong>Rp 75.000</strong> akan jatuh tempo pada <strong>8 April 2026 pukul 13:00 WIB</strong>.
                Segera lakukan pembayaran!
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 2 jam yang lalu</div>
        </div>
        <div class="notif-actions">
            <div class="notif-dot"></div>
            <button class="btn-notif" style="background:var(--danger);color:#fff;">Bayar Sekarang</button>
        </div>
    </div>

    {{-- Notif 2 - Unread --}}
    <div class="notif-item unread">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">✅ Jadwal Les Dikonfirmasi</div>
            <div class="notif-desc">
                Les privat Fisika dengan <strong>Bu Sari Dewi</strong> pada
                <strong>Selasa, 8 April 2026 · 14:00 WIB</strong> telah dikonfirmasi.
                Siapkan dirimu ya!
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 3 jam yang lalu</div>
        </div>
        <div class="notif-actions">
            <div class="notif-dot"></div>
            <button class="btn-notif" style="background:#eff6ff;color:var(--primary);">Lihat Detail</button>
        </div>
    </div>

    {{-- Notif 3 - Unread --}}
    <div class="notif-item unread">
        <div class="notif-icon" style="background:#eff6ff;color:var(--primary);">
            <i class="bi bi-book-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">📚 Materi Baru Tersedia!</div>
            <div class="notif-desc">
                Tutor <strong>Pak Budi Santoso</strong> baru saja mengunggah materi
                <strong>"Integral Tak Tentu & Tentu – Ringkasan"</strong> (PDF, 18 halaman).
                Yuk mulai belajar!
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 5 jam yang lalu</div>
        </div>
        <div class="notif-actions">
            <div class="notif-dot"></div>
            <button class="btn-notif" style="background:#eff6ff;color:var(--primary);">Buka Materi</button>
        </div>
    </div>

</div>

{{-- NOTIFIKASI KEMARIN --}}
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Kemarin</div>
<div class="card-box mb-3">

    <div class="notif-item">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);">
            <i class="bi bi-trophy-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">🏆 Nilai Kuis Diterbitkan</div>
            <div class="notif-desc">
                Hasil kuis <strong>"Hukum Newton – Kuis Cepat"</strong> telah tersedia.
                Kamu mendapat nilai <strong style="color:var(--success);">100/100</strong> — Sempurna! 🎉
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
        <div class="notif-actions">
            <button class="btn-notif" style="background:var(--success-soft);color:var(--success);">Lihat Hasil</button>
        </div>
    </div>

    <div class="notif-item">
        <div class="notif-icon" style="background:var(--accent-soft);color:var(--warning);">
            <i class="bi bi-star-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">⭐ Beri Ulasan Sesi Belajar</div>
            <div class="notif-desc">
                Bagaimana sesi Matematika dengan <strong>Pak Budi Santoso</strong> kemarin?
                Berikan ulasan untuk membantu tutor berkembang!
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
        <div class="notif-actions">
            <button class="btn-notif" style="background:var(--accent-soft);color:var(--warning);">Beri Ulasan</button>
        </div>
    </div>

    <div class="notif-item">
        <div class="notif-icon" style="background:var(--info-soft);color:var(--info);">
            <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">⚡ Streak Belajar 5 Hari!</div>
            <div class="notif-desc">
                Keren! Kamu sudah belajar <strong>5 hari berturut-turut</strong>.
                Pertahankan streak-mu dan dapatkan badge "Rajin Belajar"!
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
        <div class="notif-actions">
            <button class="btn-notif" style="background:var(--info-soft);color:var(--info);">Lihat Badge</button>
        </div>
    </div>

</div>

{{-- NOTIFIKASI MINGGU INI --}}
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Minggu Ini</div>
<div class="card-box mb-4">

    <div class="notif-item">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">✅ Pembayaran Berhasil</div>
            <div class="notif-desc">
                Pembayaran <strong>Rp 120.000</strong> untuk les privat Fisika
                dengan Bu Sari Dewi (#INV-2026-0398) telah berhasil diproses via OVO.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 3 hari yang lalu</div>
        </div>
        <div class="notif-actions">
            <button class="btn-notif" style="background:var(--success-soft);color:var(--success);">Lihat Invoice</button>
        </div>
    </div>

    <div class="notif-item">
        <div class="notif-icon" style="background:#eff6ff;color:var(--primary);">
            <i class="bi bi-person-check-fill"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">👋 Selamat Datang di Al Ilmi Center!</div>
            <div class="notif-desc">
                Akun kamu berhasil diverifikasi. Mulai perjalanan belajarmu sekarang —
                latihan soal TKA, les privat, dan pantau progresmu!
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 5 hari yang lalu</div>
        </div>
        <div class="notif-actions">
            <button class="btn-notif" style="background:#eff6ff;color:var(--primary);">Mulai Belajar</button>
        </div>
    </div>

</div>

{{-- LOAD MORE --}}
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