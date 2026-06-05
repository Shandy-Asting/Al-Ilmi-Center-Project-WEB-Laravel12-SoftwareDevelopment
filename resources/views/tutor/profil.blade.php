@extends('layouts.app')

@section('title', 'Profil Tutor - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Profil Saya')
@section('page-sub', 'Dashboard / Profil')

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

    .hari-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
    }

    .hari-row:last-child {
        border-bottom: none;
    }

    .hari-label {
        width: 80px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .slot-available {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .slot-chip {
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        cursor: pointer;
        transition: all .2s;
    }

    .slot-chip.on {
        background: var(--primary);
        color: #fff;
    }

    .slot-chip.off {
        background: var(--bg);
        color: var(--muted);
        border: 1px solid var(--border);
    }

    .ulasan-item {
        padding: 14px 0;
        border-bottom: 1px solid var(--border);
    }

    .ulasan-item:last-child {
        border-bottom: none;
    }

    .ulasan-stars {
        color: var(--accent);
        font-size: 12px;
    }

    .ulasan-text {
        font-size: 13px;
        color: var(--text);
        margin-top: 4px;
        line-height: 1.5;
    }

    .ulasan-from {
        font-size: 11.5px;
        color: var(--muted);
        margin-top: 4px;
    }

    .danger-zone {
        background: var(--danger-soft);
        border: 1.5px solid var(--danger);
        border-radius: 16px;
        padding: 20px;
    }

    @media (max-width: 767px) {
        .profile-header {
            padding: 16px !important;
            border-radius: 14px !important;
        }

        .profile-header>.d-flex {
            flex-direction: column;
            align-items: center !important;
            text-align: center;
            gap: 12px !important;
        }

        .profile-stats {
            justify-content: center;
            gap: 14px !important;
        }

        .section-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .section-tab {
            min-width: 90px;
            flex: none;
            font-size: 11.5px;
        }

        .hari-row {
            flex-wrap: wrap;
        }

        .slot-available {
            flex-wrap: wrap;
        }

        .form-section {
            padding: 14px !important;
        }

        .ulasan-item .d-flex {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')

{{-- PROFILE HEADER --}}
<div class="profile-header">
    <div class="d-flex align-items-center gap-4" style="position:relative;z-index:1;">
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
                Tutor @if($user->kota) · {{ $user->kota }} @endif
            </div>
            <div style="margin-top:8px;">
                <span style="background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;">
                    <i class="bi bi-star-fill me-1" style="color:var(--accent);"></i> Tutor Aktif
                </span>
                <span style="background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;margin-left:6px;">
                    <i class="bi bi-shield-check-fill me-1"></i> Terverifikasi
                </span>
            </div>
        </div>
        <form method="POST" action="/tutor/profil/upload-avatar" enctype="multipart/form-data" id="formAvatar">
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
        <div>
            <div class="ps-val">{{ $totalSiswa }}</div>
            <div class="ps-label">Siswa Aktif</div>
        </div>
        <div>
            <div class="ps-val">{{ $totalSesi }}</div>
            <div class="ps-label">Total Sesi</div>
        </div>
        <div>
            <div class="ps-val">{{ $pengalaman > 0 ? $pengalaman.' th' : '-' }}</div>
            <div class="ps-label">Pengalaman</div>
        </div>
    </div>
</div>

{{-- FLASH MESSAGES --}}
@if(session('sukses_info'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:600;color:var(--success);">
    <i class="bi bi-check-circle-fill me-1"></i> {{ session('sukses_info') }}
</div>
@endif
@if(session('sukses_password'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:600;color:var(--success);">
    <i class="bi bi-check-circle-fill me-1"></i> {{ session('sukses_password') }}
</div>
@endif
@if($errors->any())
<div style="background:var(--danger-soft);border:1px solid var(--danger);border-radius:12px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:var(--danger);">
    <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
</div>
@endif

{{-- SECTION TABS --}}
<div class="section-tabs">
    <button class="section-tab active" onclick="switchSection(this,'info')">
        <i class="bi bi-person me-1"></i> Info Pribadi
    </button>
    <button class="section-tab" onclick="switchSection(this,'keahlian')">
        <i class="bi bi-book me-1"></i> Keahlian & Jadwal
    </button>
    <button class="section-tab" onclick="switchSection(this,'keamanan')">
        <i class="bi bi-shield-lock me-1"></i> Keamanan
    </button>
    <button class="section-tab" onclick="switchSection(this,'ulasan')">
        <i class="bi bi-star me-1"></i> Ulasan Siswa
    </button>
</div>

{{-- ══ TAB: INFO PRIBADI ══ --}}
<div id="section-info">
    <form method="POST" action="/tutor/profil/update-info">
        @csrf
        <div class="form-section">
            <div class="form-section-title"><i class="bi bi-person-fill"></i> Informasi Pribadi</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Email</label>
                    <input type="email" class="form-control-custom" value="{{ $user->email }}" disabled />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">No. HP</label>
                    <input type="text" name="no_hp" class="form-control-custom" value="{{ old('no_hp', $user->no_hp) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kota Domisili</label>
                    <input type="text" name="kota" class="form-control-custom" value="{{ old('kota', $user->kota) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="form-control-custom">
                        @foreach(['D3','S1','S2','S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan', $user->pendidikan) === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Jurusan / Program Studi</label>
                    <input type="text" name="jurusan" class="form-control-custom" value="{{ old('jurusan', $user->jurusan) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Tahun Mulai Mengajar</label>
                    <input type="number" name="tahun_mengajar" class="form-control-custom" value="{{ old('tahun_mengajar', $user->tahun_mengajar) }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Mode Mengajar</label>
                    <select name="mode_mengajar" class="form-control-custom">
                        @foreach(['Online Saja','Online & Offline','Offline Saja'] as $m)
                        <option value="{{ $m }}" {{ old('mode_mengajar', $user->mode_mengajar) === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label-custom">Bio / Deskripsi Singkat</label>
                    <textarea name="bio" class="form-control-custom" rows="3">{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn fw-bold px-4 py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                    <i class="bi bi-check2 me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<form method="POST" action="/tutor/profil/simpan-keahlian">
    @csrf
    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-mortarboard-fill"></i> Mata Pelajaran & Keahlian</div>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label-custom">Mata Pelajaran yang Diajarkan</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach(['Matematika','Fisika','Kalkulus','Aljabar','Trigonometri','Statistika','UTBK/TKA'] as $mapel)
                    @php $aktif = in_array($mapel, $user->mata_pelajaran_tutor ?? []); @endphp
                    <label style="cursor:pointer;margin:0;">
                        <input type="checkbox" name="mata_pelajaran[]" value="{{ $mapel }}"
                            {{ $aktif ? 'checked' : '' }} style="display:none;"
                            onchange="toggleBadge(this)">
                        <span style="background:{{ $aktif ? 'var(--primary)' : '#eff6ff' }};color:{{ $aktif ? '#fff' : 'var(--primary)' }};font-size:12.5px;font-weight:700;padding:5px 14px;border-radius:20px;border:1.5px solid {{ $aktif ? 'var(--primary)' : '#eff6ff' }};display:inline-block;">
                            {{ $mapel }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Jenjang yang Diajar</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach(['smp' => 'SMP', 'sma' => 'SMA', 'perguruan_tinggi' => 'Perguruan Tinggi'] as $val => $label)
                    @php $aktif = in_array($val, $user->jenjang_tutor ?? []); @endphp
                    <label style="cursor:pointer;margin:0;">
                        <input type="checkbox" name="jenjang[]" value="{{ $val }}"
                            {{ $aktif ? 'checked' : '' }} style="display:none;"
                            onchange="toggleBadge(this)">
                        <span style="background:{{ $aktif ? 'var(--success)' : 'var(--bg)' }};color:{{ $aktif ? '#fff' : 'var(--muted)' }};font-size:12px;font-weight:700;padding:5px 12px;border-radius:20px;border:1.5px solid {{ $aktif ? 'var(--success)' : 'var(--border)' }};display:inline-block;">
                            {{ $label }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Tarif per Sesi (60 mnt)</label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-weight:700;color:var(--muted);">Rp</span>
                    <input type="number" name="tarif_per_sesi" class="form-control-custom"
                        value="{{ $user->tarif_per_sesi ?? 75000 }}" style="padding-left:40px;" />
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Maks. Siswa per Hari</label>
                <input type="number" name="maks_siswa_per_hari" class="form-control-custom"
                    value="{{ $user->maks_siswa_per_hari ?? 5 }}" />
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                <i class="bi bi-check2 me-1"></i> Simpan Keahlian
            </button>
        </div>
    </div>
</form>

<div class="form-section">
    <div class="form-section-title"><i class="bi bi-clock-fill"></i> Ketersediaan Waktu</div>
    @php
    $haris = [
    ['Senin', ['07:00','08:00','09:00','13:00','14:00'], ['07:00','09:00','13:00']],
    ['Selasa', ['07:00','08:00','10:00','13:00','15:00'], ['08:00','10:00','15:00']],
    ['Rabu', ['07:00','08:00','09:00','13:00'], ['07:00','13:00']],
    ['Kamis', ['07:00','09:00','13:00','15:00','17:00'], ['09:00','15:00']],
    ['Jumat', ['07:00','08:00','13:00'], ['']],
    ['Sabtu', ['07:00','09:00','11:00','13:00'], ['07:00','09:00','11:00']],
    ['Minggu', [], ['']],
    ];
    @endphp
    @foreach ($haris as $h)
    <div class="hari-row">
        <div class="hari-label">{{ $h[0] }}</div>
        <div class="slot-available">
            @if(count($h[1]) > 0)
            @foreach ($h[1] as $slot)
            <span class="slot-chip {{ in_array($slot, $h[2]) ? 'on' : 'off' }}" onclick="toggleSlot(this)">{{ $slot }}</span>
            @endforeach
            @else
            <span style="font-size:12px;color:var(--muted);">Tidak tersedia</span>
            @endif
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-end mt-3">
        <button class="btn fw-bold px-4 py-2"
            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
            <i class="bi bi-check2 me-1"></i> Simpan Ketersediaan
        </button>
    </div>
</div>
</div>

{{-- ══ TAB: KEAMANAN ══ --}}
<div id="section-keamanan" style="display:none;">
    <form method="POST" action="/tutor/profil/ganti-password">
        @csrf
        <div class="form-section">
            <div class="form-section-title"><i class="bi bi-key-fill"></i> Ubah Password</div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label-custom">Password Saat Ini</label>
                    <div style="position:relative;">
                        <input type="password" name="password_lama" id="passLama"
                            class="form-control-custom {{ $errors->has('password_lama') ? 'border-danger' : '' }}"
                            placeholder="Masukkan password saat ini" style="padding-right:40px;" />
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
                            class="form-control-custom" placeholder="Minimal 8 karakter" style="padding-right:40px;" />
                        <i class="bi bi-eye" id="toggleBaru" onclick="togglePass('passBaru','toggleBaru')"
                            style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Konfirmasi Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password_baru_confirmation" id="passKonfirm"
                            class="form-control-custom" placeholder="Ulangi password baru" style="padding-right:40px;" />
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
        </div>
    </form>

    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-bell-fill"></i> Pengaturan Notifikasi</div>
        <form method="POST" action="/tutor/profil/simpan-notifikasi">
            @csrf
            <div class="d-flex flex-column gap-3">
                @php
                $notifs = [
                ['notif_permintaan_jadwal', 'Les Privat', 'Notifikasi permintaan jadwal dan konfirmasi sesi'],
                ['notif_pengingat_sesi', 'Pengingat Sesi', 'Pengingat 1 jam sebelum sesi dimulai'],
                ['notif_pembayaran', 'Pembayaran', 'Update status pembayaran sesi'],
                ['notif_ulasan', 'Sistem', 'Notifikasi ulasan dan pemberitahuan sistem'],
                ['notif_newsletter', 'Email Newsletter', 'Informasi dan tips mengajar'],
                ];
                @endphp
                @foreach ($notifs as $n)
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:var(--bg);">
                    <div>
                        <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $n[1] }}</div>
                        <div style="font-size:11.5px;color:var(--muted);">{{ $n[2] }}</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="{{ $n[0] }}"
                            {{ $user->{$n[0]} ? 'checked' : '' }}
                            style="width:40px;height:22px;cursor:pointer;"
                            onchange="this.form.submit()" />
                    </div>
                </div>
                @endforeach
            </div>
        </form>
    </div>
</div>

<div class="danger-zone">
    <div style="font-size:14px;font-weight:700;color:var(--danger);margin-bottom:8px;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>Zona Berbahaya
    </div>
    <div style="font-size:12.5px;color:#7f1d1d;margin-bottom:14px;line-height:1.5;">
        Menonaktifkan akun akan menghentikan semua jadwal aktif dan siswa tidak bisa memesan sesi baru dengan Anda.
    </div>
    <button class="btn fw-bold px-4 py-2"
        style="background:var(--danger);color:#fff;border-radius:10px;border:none;font-size:13px;">
        <i class="bi bi-x-circle-fill me-1"></i> Nonaktifkan Akun
    </button>
</div>
</div>

{{-- ══ ULASAN SISWA ══ --}}
<div id="section-ulasan" style="display:none;">
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:24px;text-align:center;">
                <div style="font-size:48px;font-weight:800;color:var(--primary);">
                    {{ $ratingRata ?: '-' }}
                </div>
                <div style="color:var(--accent);font-size:18px;margin-bottom:4px;">
                    @for($i=1;$i<=5;$i++)
                        <i class="bi bi-star{{ $i <= floor($ratingRata) ? '-fill' : '' }}"></i>
                        @endfor
                </div>
                <div style="font-size:12px;color:var(--muted);">dari {{ $totalUlasan }} ulasan</div>
                <div style="margin-top:14px;">
                    @foreach([5,4,3,2,1] as $b)
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <span style="font-size:11px;font-weight:700;width:14px;text-align:right;">{{ $b }}</span>
                        <i class="bi bi-star-fill" style="font-size:10px;color:var(--accent);"></i>
                        <div style="flex:1;height:6px;border-radius:10px;background:var(--border);overflow:hidden;">
                            <div style="height:100%;border-radius:10px;background:var(--accent);width:{{ $distribusi[$b] }}%;"></div>
                        </div>
                        <span style="font-size:11px;color:var(--muted);width:24px;">{{ $distribusi[$b] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;">
                <div style="font-size:14px;font-weight:700;margin-bottom:14px;color:var(--text);">Ulasan Terbaru</div>
                @forelse($ulasanList->take(10) as $u)
                <div class="ulasan-item">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                            {{ strtoupper(substr($u->siswa->name ?? 'S', 0, 1)) }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:700;color:var(--text);">
                                {{ $u->siswa->name ?? '-' }}
                            </div>
                        </div>
                        <div class="ulasan-stars">
                            @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i <= $u->bintang ? '-fill' : '' }}"></i>
                                @endfor
                        </div>
                    </div>
                    @if($u->komentar)
                    <div class="ulasan-text">{{ $u->komentar }}</div>
                    @endif
                    <div class="ulasan-from">
                        <i class="bi bi-clock me-1"></i>{{ $u->created_at->diffForHumans() }}
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:32px;color:var(--muted);">
                    <i class="bi bi-star" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    <div style="font-size:14px;font-weight:700;margin-bottom:4px;">Belum ada ulasan</div>
                    <div style="font-size:13px;">Ulasan dari siswa akan muncul di sini setelah sesi selesai</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@php $bukaTabKeamanan = $errors->has('password_lama') || session('tab') === 'keamanan'; @endphp

@push('scripts')
<script>
    function switchSection(el, id) {
        document.querySelectorAll('.section-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        ['info', 'keahlian', 'keamanan', 'ulasan'].forEach(s => {
            document.getElementById('section-' + s).style.display = s === id ? '' : 'none';
        });
    }

    function toggleSlot(el) {
        el.classList.toggle('on');
        el.classList.toggle('off');
    }

    function toggleBadge(checkbox) {
        const span = checkbox.nextElementSibling;
        const isMapel = checkbox.name === 'mata_pelajaran[]';
        if (checkbox.checked) {
            span.style.background = isMapel ? 'var(--primary)' : 'var(--success)';
            span.style.color = '#fff';
            span.style.borderColor = isMapel ? 'var(--primary)' : 'var(--success)';
        } else {
            span.style.background = isMapel ? '#eff6ff' : 'var(--bg)';
            span.style.color = isMapel ? 'var(--primary)' : 'var(--muted)';
            span.style.borderColor = isMapel ? '#eff6ff' : 'var(--border)';
        }
    }

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

    @if($bukaTabKeamanan)
    document.addEventListener('DOMContentLoaded', () => {
        const tab = document.querySelector('[onclick*="keamanan"]');
        if (tab) tab.click();
    });
    @endif
</script>
@endpush