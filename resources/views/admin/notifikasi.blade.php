@extends('layouts.app')

@section('title', 'Notifikasi Admin - Al Ilmi Center')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Notifikasi')
@section('page-sub', 'Admin / Notifikasi')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/admin/dashboard" class="nav-item-custom {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <div class="menu-label">Pengelolaan</div>
    <a href="/admin/pengguna" class="nav-item-custom {{ request()->is('admin/pengguna') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Pengelolaan Pengguna
        <span class="nav-badge">12</span>
    </a>
    <a href="/admin/paket" class="nav-item-custom {{ request()->is('admin/paket') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Pengelolaan Paket
    </a>
    <a href="/admin/pembayaran" class="nav-item-custom {{ request()->is('admin/pembayaran') ? 'active' : '' }}">
        <i class="bi bi-cash-coin"></i> Pembayaran & Gaji
    </a>
    <a href="/admin/rekening" class="nav-item-custom {{ request()->is('admin/rekening') ? 'active' : '' }}">
        <i class="bi bi-bank"></i> Rekening Bank
    </a>
    <a href="/admin/laporan" class="nav-item-custom {{ request()->is('admin/laporan') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line-fill"></i> Laporan
    </a>
@endsection

@push('styles')
<style>
    .filter-tabs{display:flex;gap:6px;margin-bottom:20px;flex-wrap:wrap;}
    .filter-tab{padding:7px 16px;border-radius:20px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;border:1.5px solid var(--border);background:var(--card-bg);color:var(--muted);}
    .filter-tab.active{background:var(--primary);color:#fff;border-color:var(--primary);}
    .filter-tab:hover:not(.active){border-color:var(--primary-light);color:var(--primary);}
    .notif-item{display:flex;gap:14px;padding:16px 20px;border-bottom:1px solid var(--border);transition:background .15s;cursor:pointer;position:relative;}
    .notif-item:last-child{border-bottom:none;}
    .notif-item:hover{background:#f8faff;}
    .notif-item.unread{background:#f0f6ff;}
    .notif-item.unread::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--primary);border-radius:0 3px 3px 0;}
    .notif-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
    .notif-title{font-size:13.5px;font-weight:700;color:var(--text);margin-bottom:4px;}
    .notif-desc{font-size:12.5px;color:var(--muted);line-height:1.5;}
    .notif-time{font-size:11px;color:var(--muted);margin-top:6px;}
    .notif-dot{width:8px;height:8px;border-radius:50%;background:var(--primary);flex-shrink:0;margin-top:6px;}
    .card-box{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;overflow:hidden;}
    @media(max-width:767px){
        .notif-item{flex-wrap:wrap;padding:12px 14px;}
        .filter-tabs{overflow-x:auto;flex-wrap:nowrap;padding-bottom:4px;}
        .filter-tab{min-width:auto;flex:none;font-size:12px;}
    }
</style>
@endpush

@section('content')

<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">🔔 Notifikasi Admin</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Pantau semua aktivitas sistem Al Ilmi Center</p>
    </div>
    <button style="background:var(--bg);color:var(--primary);border:1.5px solid var(--primary);border-radius:10px;font-size:12px;font-weight:700;padding:8px 14px;cursor:pointer;">
        <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
    </button>
</div>

{{-- FILTER TABS --}}
<div class="filter-tabs">
    <div class="filter-tab active" onclick="filterNotif(this,'semua')">
        Semua <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">6</span>
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'pembayaran')">💰 Pembayaran</div>
    <div class="filter-tab" onclick="filterNotif(this,'les')">🎓 Les Privat</div>
    <div class="filter-tab" onclick="filterNotif(this,'pengguna')">👥 Pengguna Baru</div>
    <div class="filter-tab" onclick="filterNotif(this,'sistem')">⚙️ Sistem</div>
</div>

{{-- HARI INI --}}
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Hari Ini</div>
<div class="card-box mb-3">

    {{-- Pembayaran masuk --}}
    <div class="notif-item unread" data-type="pembayaran">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-cash-coin"></i></div>
        <div style="flex:1;">
            <div class="notif-title">💰 Bukti Pembayaran Dikirim Siswa</div>
            <div class="notif-desc">
                <strong>Andi Pratama</strong> mengirim bukti pembayaran untuk sesi
                <strong>Matematika – Pak Budi Santoso</strong> sebesar <strong>Rp 75.000</strong>.
                Menunggu konfirmasi tutor.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 30 menit yang lalu</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <div class="notif-dot"></div>
            <a href="/admin/pembayaran" style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                Lihat
            </a>
        </div>
    </div>

    {{-- Pengguna baru --}}
    <div class="notif-item unread" data-type="pengguna">
        <div class="notif-icon" style="background:#eff6ff;color:var(--primary);"><i class="bi bi-person-plus-fill"></i></div>
        <div style="flex:1;">
            <div class="notif-title">👤 Siswa Baru Mendaftar</div>
            <div class="notif-desc">
                <strong>Fajar Nugroho</strong> baru saja mendaftar sebagai siswa SMA.
                Akun sudah aktif dan siap digunakan.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 jam yang lalu</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <div class="notif-dot"></div>
            <a href="/admin/pengguna" style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                Lihat
            </a>
        </div>
    </div>

    {{-- Tutor baru --}}
    <div class="notif-item unread" data-type="pengguna">
        <div class="notif-icon" style="background:var(--accent-soft);color:var(--warning);"><i class="bi bi-person-badge-fill"></i></div>
        <div style="flex:1;">
            <div class="notif-title">🎓 Tutor Baru Terdaftar</div>
            <div class="notif-desc">
                <strong>Dina Amalia, S.Pd</strong> mendaftar sebagai tutor Kimia SMA.
                Silakan verifikasi dokumen dan aktifkan akun.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 2 jam yang lalu</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <div class="notif-dot"></div>
            <a href="/admin/pengguna" style="background:var(--accent-soft);color:var(--warning);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                Verifikasi
            </a>
        </div>
    </div>

    {{-- Gaji tutor --}}
    <div class="notif-item unread" data-type="pembayaran">
        <div class="notif-icon" style="background:var(--warning-soft);color:var(--warning);"><i class="bi bi-wallet2"></i></div>
        <div style="flex:1;">
            <div class="notif-title">💼 Gaji Tutor Menunggu Konfirmasi</div>
            <div class="notif-desc">
                <strong>Pak Budi Santoso</strong> — 3 sesi selesai bulan ini, gaji sebesar
                <strong>Rp 180.000</strong> menunggu konfirmasi transfer dari admin.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 3 jam yang lalu</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <div class="notif-dot"></div>
            <a href="/admin/pembayaran" style="background:var(--warning-soft);color:var(--warning);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                Konfirmasi
            </a>
        </div>
    </div>

    {{-- Les privat baru --}}
    <div class="notif-item unread" data-type="les">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-person-video3"></i></div>
        <div style="flex:1;">
            <div class="notif-title">📅 Pesanan Les Privat Baru</div>
            <div class="notif-desc">
                <strong>Siti Rahayu</strong> memesan les privat
                <strong>Fisika SMA – Bu Sari Dewi</strong> pada
                <strong>Sabtu, 17 Mei 2026 · 14:00 WIB</strong>.
                Menunggu konfirmasi tutor.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 4 jam yang lalu</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <div class="notif-dot"></div>
        </div>
    </div>

</div>

{{-- KEMARIN --}}
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Kemarin</div>
<div class="card-box mb-3">

    <div class="notif-item" data-type="pembayaran">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-check-circle-fill"></i></div>
        <div style="flex:1;">
            <div class="notif-title">✅ Pembayaran Dikonfirmasi Tutor</div>
            <div class="notif-desc">
                Pembayaran dari <strong>Aldi Pratama</strong> untuk sesi
                <strong>Matematika – Trigonometri</strong> sebesar <strong>Rp 75.000</strong>
                telah dikonfirmasi oleh <strong>Pak Budi Santoso</strong>.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
    </div>

    <div class="notif-item" data-type="sistem">
        <div class="notif-icon" style="background:var(--warning-soft);color:var(--warning);"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div style="flex:1;">
            <div class="notif-title">⚠️ Peringatan: Storage Hampir Penuh</div>
            <div class="notif-desc">
                Penggunaan storage server telah mencapai <strong>84%</strong> dari kapasitas total.
                Segera lakukan pembersihan file yang tidak diperlukan.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
        <div style="flex-shrink:0;">
            <span style="background:var(--warning-soft);color:var(--warning);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">Perlu Tindakan</span>
        </div>
    </div>

    <div class="notif-item" data-type="les">
        <div class="notif-icon" style="background:var(--danger-soft);color:var(--danger);"><i class="bi bi-calendar-x-fill"></i></div>
        <div style="flex:1;">
            <div class="notif-title">❌ Sesi Les Dibatalkan Siswa</div>
            <div class="notif-desc">
                <strong>Farhan Maulana</strong> membatalkan sesi
                <strong>Bahasa Inggris – Grammar</strong> dengan <strong>Pak Fauzan</strong>
                yang dijadwalkan pada Senin, 12 Mei 2026.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
    </div>

    <div class="notif-item" data-type="sistem">
        <div class="notif-icon" style="background:#f0fdf4;color:var(--success);"><i class="bi bi-shield-check"></i></div>
        <div style="flex:1;">
            <div class="notif-title">🔒 Backup Database Berhasil</div>
            <div class="notif-desc">
                Backup otomatis harian selesai dengan ukuran <strong>2.4 GB</strong>.
                Disimpan di server backup sekunder. Semua data aman.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 1 hari yang lalu</div>
        </div>
    </div>

</div>

{{-- MINGGU INI --}}
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Minggu Ini</div>
<div class="card-box mb-4">

    <div class="notif-item" data-type="sistem">
        <div class="notif-icon" style="background:#eff6ff;color:var(--primary);"><i class="bi bi-gear-fill"></i></div>
        <div style="flex:1;">
            <div class="notif-title">⚙️ Pembaruan Sistem</div>
            <div class="notif-desc">
                Al Ilmi Center diperbarui ke versi terbaru. Fitur baru:
                konfirmasi pembayaran via foto bukti transfer, gaji tutor otomatis,
                dan halaman admin rekening bank.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 3 hari yang lalu</div>
        </div>
    </div>

    <div class="notif-item" data-type="pembayaran">
        <div class="notif-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-bank"></i></div>
        <div style="flex:1;">
            <div class="notif-title">🏦 Rekening Bank Baru Ditambahkan</div>
            <div class="notif-desc">
                Rekening <strong>Bank Mandiri (1122334455)</strong> a.n. Al Ilmi Center
                berhasil ditambahkan dan diaktifkan. Rekening ini akan tampil di halaman pembayaran siswa.
            </div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> 4 hari yang lalu</div>
        </div>
    </div>

</div>

<div class="text-center mb-4">
    <button style="background:var(--card-bg);border:1.5px solid var(--border);border-radius:10px;font-size:13px;color:var(--muted);padding:10px 24px;cursor:pointer;font-weight:600;">
        <i class="bi bi-arrow-down me-1"></i>Muat Notifikasi Lebih Lama
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

function filterNotif(el, type) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    if(type === 'semua') {
        document.querySelectorAll('.notif-item').forEach(n => n.style.display = '');
        return;
    }
    document.querySelectorAll('.notif-item').forEach(n => {
        n.style.display = n.dataset.type === type ? '' : 'none';
    });
}
</script>
@endpush