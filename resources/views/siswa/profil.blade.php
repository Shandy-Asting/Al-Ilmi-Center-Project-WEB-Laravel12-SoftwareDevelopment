@extends('layouts.app')

@section('title', 'Profil Saya - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Profil Saya')
@section('page-sub', 'Dashboard / Profil')

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
    /* ── PROFILE HEADER ── */
    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 60%, #3b6fa0 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
    }

    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: 40px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .04);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 800;
        color: var(--primary);
        border: 3px solid rgba(255, 255, 255, .3);
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .profile-name {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }

    .profile-role {
        font-size: 13px;
        opacity: .75;
        color: #fff;
    }

    .profile-stats {
        display: flex;
        gap: 24px;
        margin-top: 16px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .ps-item {
        text-align: center;
    }

    .ps-val {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .ps-label {
        font-size: 11px;
        opacity: .7;
        color: #fff;
        margin-top: 2px;
    }

    /* ── SECTION TABS ── */
    .section-tabs {
        display: flex;
        gap: 4px;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 5px;
        margin-bottom: 24px;
    }

    .section-tab {
        flex: 1;
        text-align: center;
        padding: 8px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        color: var(--muted);
        border: none;
        background: transparent;
    }

    .section-tab.active {
        background: var(--primary);
        color: #fff;
    }

    .section-tab:hover:not(.active) {
        background: var(--bg);
        color: var(--primary);
    }

    /* ── FORM ── */
    .form-section {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
    }

    .form-section-title {
        font-size: 14px;
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

    .form-control-custom:disabled {
        background: var(--bg);
        color: var(--muted);
    }

    .form-control-custom.select {
        cursor: pointer;
    }

    /* ── ACHIEVEMENT ── */
    .achieve-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .achieve-card {
        background: var(--bg);
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        transition: transform .2s;
    }

    .achieve-card:hover {
        transform: translateY(-2px);
    }

    .achieve-card.unlocked {
        background: linear-gradient(135deg, var(--accent-soft), #fffbeb);
        border: 1px solid var(--accent);
    }

    .achieve-card.locked {
        opacity: .45;
        filter: grayscale(1);
    }

    .achieve-icon {
        font-size: 28px;
        margin-bottom: 6px;
    }

    .achieve-title {
        font-size: 11.5px;
        font-weight: 700;
        color: var(--text);
    }

    .achieve-sub {
        font-size: 10px;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ── PAKET CARD ── */
    .paket-aktif {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 16px;
        padding: 20px;
        color: #fff;
        margin-bottom: 16px;
    }

    .pa-label {
        font-size: 11px;
        opacity: .7;
        margin-bottom: 4px;
    }

    .pa-name {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .pa-period {
        font-size: 12px;
        opacity: .7;
    }

    .pa-features {
        margin-top: 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .pa-feature {
        font-size: 12px;
        opacity: .85;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ── DANGER ZONE ── */
    .danger-zone {
        background: var(--danger-soft);
        border: 1.5px solid var(--danger);
        border-radius: 16px;
        padding: 20px;
    }

    .dz-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--danger);
        margin-bottom: 8px;
    }

    .dz-desc {
        font-size: 12.5px;
        color: #7f1d1d;
        margin-bottom: 14px;
        line-height: 1.5;
    }

    /* CARD BOX */
    .card-box {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
    }

    /* ══ RESPONSIVE GLOBAL ══ */
    @media (max-width: 767px) {
        .profile-header {
            padding: 18px 16px !important;
            border-radius: 14px !important;
        }

        .profile-header .d-flex {
            flex-direction: column;
            align-items: center !important;
            text-align: center;
        }

        .profile-avatar {
            margin: 0 auto 12px !important;
        }

        .profile-stats {
            justify-content: center;
            gap: 16px;
        }

        .section-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .section-tab {
            min-width: 100px;
            flex: none;
            font-size: 12px;
        }

        .achieve-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .form-section {
            padding: 16px !important;
        }

        .paket-aktif {
            padding: 16px !important;
        }
    }

    @media (max-width: 480px) {
        .profile-stats {
            gap: 12px;
        }

        .ps-val {
            font-size: 18px !important;
        }

        .achieve-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .section-tabs {
            gap: 3px;
        }

        .section-tab {
            padding: 7px 6px !important;
            font-size: 11px !important;
        }
    }
</style>
@endpush

@section('content')

{{-- FLASH MESSAGE --}}
@if(session('sukses_info'))
<div class="alert alert-success rounded-3 mb-3 d-flex align-items-center gap-2" style="font-size:.85rem;" id="flash-sukses">
    <i class="bi bi-check-circle-fill"></i> {{ session('sukses_info') }}
</div>
@endif
@if(session('sukses_password'))
<div class="alert alert-success rounded-3 mb-3 d-flex align-items-center gap-2" style="font-size:.85rem;" id="flash-sukses">
    <i class="bi bi-check-circle-fill"></i> {{ session('sukses_password') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger rounded-3 mb-3" style="font-size:.85rem;">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
</div>
@endif

{{-- PROFILE HEADER --}}
<div class="profile-header">
    <div class="d-flex align-items-center gap-4" style="position:relative;z-index:1;">
        {{-- Avatar --}}
        <div class="profile-avatar" style="{{ $user->avatar ? 'padding:0;overflow:hidden;' : '' }}">
            @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar"
                style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
            @else
            {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div style="flex:1;">
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-role">
                Siswa
                @if($user->jenjang) · {{ strtoupper($user->jenjang) }} {{ $user->kelas }} @endif
                @if($user->kota) · {{ $user->kota }}, {{ $user->provinsi }} @endif
            </div>
            <div style="margin-top:8px;">
                <span style="background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;">
                    <i class="bi bi-star-fill me-1" style="color:var(--accent);"></i> Paket Pro
                </span>
                <span style="background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;margin-left:6px;">
                    <i class="bi bi-fire me-1"></i> {{ $aktivitasMinggu }} Hari Streak
                </span>
            </div>
        </div>
        {{-- Tombol Ganti Foto --}}
        <form method="POST" action="/siswa/profil/upload-avatar" enctype="multipart/form-data" id="formAvatar">
            @csrf
            <input type="file" id="inputAvatar" name="avatar" accept="image/*" style="display:none;"
                onchange="document.getElementById('formAvatar').submit()" />
            <button type="button" onclick="document.getElementById('inputAvatar').click()"
                class="btn btn-sm fw-bold"
                style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:10px;font-size:12px;white-space:nowrap;position:relative;z-index:1;">
                <i class="bi bi-camera-fill me-1"></i> Ganti Foto
            </button>
        </form>
    </div>
    <div class="profile-stats">
        <div class="ps-item">
            <div class="ps-val">{{ $rataRataNilai }}</div>
            <div class="ps-label">Rata-rata Nilai</div>
        </div>
        <div class="ps-item">
            <div class="ps-val">{{ $soalSelesai }}</div>
            <div class="ps-label">Soal Selesai</div>
        </div>
        <div class="ps-item">
            <div class="ps-val">{{ $sesiLes }}</div>
            <div class="ps-label">Sesi Les</div>
        </div>
        <div class="ps-item">
            <div class="ps-val">{{ $badgeTerbuka }}</div>
            <div class="ps-label">Badge</div>
        </div>
    </div>
</div>

{{-- SECTION TABS --}}
<div class="section-tabs">
    <button class="section-tab active" onclick="switchSection(this,'info')">
        <i class="bi bi-person me-1"></i> Info Pribadi
    </button>
    <button class="section-tab" onclick="switchSection(this,'keamanan')">
        <i class="bi bi-shield-lock me-1"></i> Keamanan
    </button>
    <button class="section-tab" onclick="switchSection(this,'paket')">
        <i class="bi bi-star me-1"></i> Paket & Langganan
    </button>
    <button class="section-tab" onclick="switchSection(this,'pencapaian')">
        <i class="bi bi-trophy me-1"></i> Pencapaian
    </button>
</div>

{{-- ══ SECTION: INFO PRIBADI ══ --}}
<div id="section-info">
    <div class="form-section">
        <div class="form-section-title">
            <i class="bi bi-person-fill"></i> Informasi Pribadi
        </div>
        <form method="POST" action="/siswa/profil/update-info">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control-custom"
                        value="{{ old('name', $user->name) }}" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Email</label>
                    <input type="email" class="form-control-custom"
                        value="{{ $user->email }}" disabled />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">No. HP</label>
                    <input type="text" name="no_hp" class="form-control-custom"
                        value="{{ old('no_hp', $user->no_hp) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control-custom"
                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Jenjang Pendidikan</label>
                    <select name="jenjang" class="form-control-custom select">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="sd" {{ old('jenjang', $user->jenjang) === 'sd' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="smp" {{ old('jenjang', $user->jenjang) === 'smp' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="sma" {{ old('jenjang', $user->jenjang) === 'sma' ? 'selected' : '' }}>SMA / Sederajat</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kelas</label>
                    <select name="kelas" class="form-control-custom select">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach(['Kelas 1','Kelas 2','Kelas 3','Kelas 4','Kelas 5','Kelas 6','Kelas 7','Kelas 8','Kelas 9','Kelas 10','Kelas 11','Kelas 12'] as $k)
                        <option value="{{ $k }}" {{ old('kelas', $user->kelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kota / Kabupaten</label>
                    <input type="text" name="kota" class="form-control-custom"
                        value="{{ old('kota', $user->kota) }}" placeholder="Contoh: Kediri" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control-custom"
                        value="{{ old('provinsi', $user->provinsi) }}" placeholder="Contoh: Jawa Timur" />
                </div>
                <div class="col-12">
                    <label class="form-label-custom">Tujuan Belajar</label>
                    <select name="tujuan_belajar" class="form-control-custom select">
                        <option value="">-- Pilih Tujuan --</option>
                        @foreach(['Persiapan TKA (Naik Jenjang)','Belajar Biasa','Persiapan Olimpiade','Remedial / Perbaikan Nilai'] as $t)
                        <option value="{{ $t }}" {{ old('tujuan_belajar', $user->tujuan_belajar) === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label-custom">Tentang Saya</label>
                    <textarea name="bio" class="form-control-custom" rows="3"
                        style="resize:vertical;" placeholder="Ceritakan sedikit tentang dirimu…">{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn fw-bold px-4 py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                    <i class="bi bi-check2 me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ SECTION: KEAMANAN ══ --}}
<div id="section-keamanan" style="display:none;">
    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-key-fill"></i> Ubah Password</div>
        <form method="POST" action="/siswa/profil/ganti-password">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label-custom">Password Saat Ini</label>
                    <div style="position:relative;">
                        <input type="password" name="password_lama" id="passLama"
                            class="form-control-custom {{ $errors->has('password_lama') ? 'border-danger' : '' }}"
                            placeholder="Masukkan password saat ini" style="padding-right:40px;" required />
                        <i class="bi bi-eye" id="toggleLama" onclick="togglePass('passLama','toggleLama')"
                            style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                    </div>
                    @error('password_lama')
                    <div style="font-size:.78rem;color:var(--danger);margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" name="password_baru" id="passBaru"
                            class="form-control-custom"
                            placeholder="Minimal 8 karakter" style="padding-right:40px;" required />
                        <i class="bi bi-eye" id="toggleBaru" onclick="togglePass('passBaru','toggleBaru')"
                            style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Konfirmasi Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" name="password_baru_confirmation" id="passKonfirm"
                            class="form-control-custom"
                            placeholder="Ulangi password baru" style="padding-right:40px;" required />
                        <i class="bi bi-eye" id="toggleKonfirm" onclick="togglePass('passKonfirm','toggleKonfirm')"
                            style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn fw-bold px-4 py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                    <i class="bi bi-shield-check me-1"></i> Ubah Password
                </button>
            </div>
        </form>
    </div>

    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-bell-fill"></i> Pengaturan Notifikasi</div>
        <div class="d-flex flex-column gap-3">
            @php
                $notifSettings = [
                    ['Notifikasi Tagihan & Pembayaran', 'Dapatkan pengingat jatuh tempo tagihan', true],
                    ['Notifikasi Jadwal Les', 'Pengingat sesi les privat yang akan datang', true],
                    ['Notifikasi Nilai & Progres', 'Update nilai kuis dan perkembangan belajar', true],
                    ['Notifikasi Materi Baru', 'Pemberitahuan saat tutor mengunggah materi baru', false],
                    ['Email Marketing', 'Promo dan penawaran spesial dari Al Ilmi Center', false],
                ];
            @endphp
            @foreach($notifSettings as $ns)
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                style="background:var(--bg);">
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $ns[0] }}</div>
                    <div style="font-size:11.5px;color:var(--muted);">{{ $ns[1] }}</div>
                </div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" {{ $ns[2] ? 'checked' : '' }}
                        style="width:40px;height:22px;cursor:pointer;" />
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                <i class="bi bi-check2 me-1"></i> Simpan Pengaturan
            </button>
        </div>
    </div>

    <div class="danger-zone">
        <div class="dz-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Zona Berbahaya</div>
        <div class="dz-desc">
            Menghapus akun akan menghapus semua data termasuk riwayat belajar, nilai, dan transaksi secara permanen.
            Tindakan ini tidak dapat dibatalkan.
        </div>
        <button class="btn fw-bold px-4 py-2"
            style="background:var(--danger);color:#fff;border-radius:10px;border:none;font-size:13px;">
            <i class="bi bi-trash3-fill me-1"></i> Hapus Akun Saya
        </button>
    </div>
</div>

{{-- ══ SECTION: PAKET ══ --}}
<div id="section-paket" style="display:none;">
    <div class="paket-aktif">
        <div class="pa-label">Paket Aktif</div>
        <div class="pa-name">Paket Pro ⭐</div>
        <div class="pa-period">Periode: 1 – 30 April 2026 · Perpanjang Otomatis</div>
        <div class="pa-features">
            <div class="pa-feature"><i class="bi bi-check-circle-fill" style="color:var(--accent);"></i> Akses Materi TKA Penuh</div>
            <div class="pa-feature"><i class="bi bi-check-circle-fill" style="color:var(--accent);"></i> Soal Latihan Tak Terbatas</div>
            <div class="pa-feature"><i class="bi bi-check-circle-fill" style="color:var(--accent);"></i> 4x Les Privat Online</div>
            <div class="pa-feature"><i class="bi bi-check-circle-fill" style="color:var(--accent);"></i> Feedback Tutor Langsung</div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        @php
        $pakets = [
            ['Starter','Rp 99K','/ bulan',false,['Akses Materi TKA','50 Soal/Hari','1x Les Privat Online'],'var(--bg)','var(--primary)','Pilih Paket'],
            ['Pro','Rp 199K','/ bulan',true,['Akses Materi Penuh','Soal Tak Terbatas','4x Les Privat Online','Feedback Tutor'],'var(--primary)','#fff','Paket Aktif'],
            ['Premium','Rp 349K','/ bulan',false,['Semua Fitur Pro','8x Les Online/Offline','Konsultasi Karir','Laporan Mingguan'],'var(--bg)','var(--primary)','Upgrade'],
        ];
        @endphp
        @foreach($pakets as $p)
        <div class="col-md-4">
            <div class="card-box text-center" style="{{ $p[3] ? 'border-color:var(--primary);border-width:2px;' : '' }}">
                @if($p[3])
                <div style="background:var(--accent);color:var(--primary);font-size:10px;font-weight:700;padding:3px 12px;border-radius:20px;display:inline-block;margin-bottom:8px;">Paket Aktif</div>
                @endif
                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;">{{ $p[0] }}</div>
                <div style="font-size:26px;font-weight:800;color:{{ $p[3] ? 'var(--primary)' : 'var(--text)' }};margin:8px 0 2px;">{{ $p[1] }}</div>
                <div style="font-size:12px;color:var(--muted);margin-bottom:14px;">{{ $p[2] }}</div>
                <ul style="list-style:none;padding:0;text-align:left;margin-bottom:16px;">
                    @foreach($p[4] as $f)
                    <li style="font-size:12.5px;padding:4px 0;display:flex;align-items:center;gap:6px;color:var(--text);">
                        <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:13px;"></i> {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <button class="btn fw-bold w-100"
                    style="background:{{ $p[5] }};color:{{ $p[6] }};border-radius:10px;border:{{ $p[3] ? 'none' : '1.5px solid var(--border)' }};font-size:13px;"
                    {{ $p[3] ? 'disabled' : '' }}>
                    {{ $p[7] }}
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card-box">
        <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:12px;">📋 Riwayat Langganan</div>
        @php
        $langganan = [
            ['Paket Pro','April 2026','Rp 199.000','var(--success-soft)','var(--success)','Aktif'],
            ['Paket Pro','Maret 2026','Rp 199.000','var(--success-soft)','var(--success)','Lunas'],
            ['Paket Starter','Februari 2026','Rp 99.000','var(--success-soft)','var(--success)','Lunas'],
        ];
        @endphp
        @foreach($langganan as $l)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);">
            <div>
                <div style="font-size:13px;font-weight:700;color:var(--text);">{{ $l[0] }}</div>
                <div style="font-size:12px;color:var(--muted);">Periode: {{ $l[1] }}</div>
            </div>
            <div class="text-end">
                <div style="font-size:13px;font-weight:700;color:var(--text);">{{ $l[2] }}</div>
                <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:6px;background:{{ $l[3] }};color:{{ $l[4] }};">{{ $l[5] }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ══ SECTION: PENCAPAIAN ══ --}}
<div id="section-pencapaian" style="display:none;">
    <div class="row g-3 mb-3">
        <div class="col-md-3 col-6">
            <div class="card-box text-center">
                <div style="font-size:32px;font-weight:800;color:var(--primary);">{{ $badgeTerbuka }}</div>
                <div style="font-size:12px;color:var(--muted);">Badge Terbuka</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card-box text-center">
                <div style="font-size:32px;font-weight:800;color:var(--muted);">{{ $badgeTerkunci }}</div>
                <div style="font-size:12px;color:var(--muted);">Badge Terkunci</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card-box text-center">
                <div style="font-size:32px;font-weight:800;color:var(--accent);">🔥 {{ $aktivitasMinggu }}</div>
                <div style="font-size:12px;color:var(--muted);">Hari Streak</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card-box text-center">
                <div style="font-size:32px;font-weight:800;color:var(--success);">{{ $rataRataNilai }}</div>
                <div style="font-size:12px;color:var(--muted);">Rata-rata Nilai</div>
            </div>
        </div>
    </div>

    <div class="card-box">
        <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:16px;">🏆 Semua Pencapaian</div>
        <div class="achieve-grid">
            @foreach($achievements as $a)
            <div class="achieve-card {{ $a[3] ? 'unlocked' : 'locked' }}">
                <div class="achieve-icon">{{ $a[0] }}</div>
                <div class="achieve-title">{{ $a[1] }}</div>
                <div class="achieve-sub">{{ $a[2] }}</div>
                @if($a[3])
                <div style="margin-top:6px;font-size:10px;color:var(--success);font-weight:700;">✅ Terbuka</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchSection(el, id) {
        document.querySelectorAll('.section-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        ['info', 'keamanan', 'paket', 'pencapaian'].forEach(s => {
            document.getElementById('section-' + s).style.display = s === id ? '' : 'none';
        });
    }

    // Toggle show/hide password
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    // Auto-hide flash message
    setTimeout(() => {
        const el = document.getElementById('flash-sukses');
        if (el) {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }
    }, 3000);

    // Buka tab keamanan jika ada error password
    @if(session('tab') === 'keamanan' || $errors->has('password_lama'))
    document.addEventListener('DOMContentLoaded', () => {
        const tab = document.querySelector('[onclick*="keamanan"]');
        if (tab) tab.click();
    });
    @endif
</script>
@endpush