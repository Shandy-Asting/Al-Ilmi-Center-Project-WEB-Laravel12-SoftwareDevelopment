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
/* ════════════════════════════════════════
   RESET
════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

/* ════════════════════════════════════════
   PROFILE HEADER
════════════════════════════════════════ */
.profile-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light, #2563eb) 55%, #3b6fa0 100%);
    border-radius: 16px;
    padding: 22px 24px 18px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 18px;
}
.profile-header::before,
.profile-header::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.profile-header::before { top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,.05); }
.profile-header::after  { bottom:-60px; left:20px; width:160px; height:160px; background:rgba(255,255,255,.04); }

/* ── top row: avatar + info + tombol ── */
.ph-top {
    position: relative; z-index: 1;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
}
.ph-avatar {
    width: 72px; height: 72px; flex-shrink: 0;
    border-radius: 50%;
    background: var(--accent, #f59e0b);
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; font-weight: 800; color: var(--primary);
    border: 3px solid rgba(255,255,255,.3);
    overflow: hidden;
}
.ph-avatar img { width: 100%; height: 100%; object-fit: cover; }

.ph-info { flex: 1; min-width: 0; }
.ph-name  { font-size: 1.1rem; font-weight: 800; color: #fff; margin: 0 0 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ph-role  { font-size: .78rem; color: rgba(255,255,255,.75); margin: 0 0 8px; }
.ph-badges { display: flex; gap: 5px; flex-wrap: wrap; }
.ph-badge {
    background: rgba(255,255,255,.15);
    color: #fff; padding: 3px 10px;
    border-radius: 20px; font-size: .68rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: 4px;
}

.btn-ganti-foto {
    align-self: flex-start; flex-shrink: 0;
    background: rgba(255,255,255,.15);
    color: #fff; border: 1px solid rgba(255,255,255,.3);
    border-radius: 9px; font-size: .75rem; font-weight: 700;
    padding: 7px 13px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px;
    transition: background .2s; white-space: nowrap;
}
.btn-ganti-foto:hover { background: rgba(255,255,255,.25); }

/* ── stats row ── */
.ph-stats {
    position: relative; z-index: 1;
    display: flex; flex-wrap: wrap;
    gap: 0;
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid rgba(255,255,255,.15);
}
.ph-stat {
    flex: 1; min-width: 70px;
    padding: 0 12px;
    border-right: 1px solid rgba(255,255,255,.15);
    text-align: center;
}
.ph-stat:first-child { padding-left: 0; }
.ph-stat:last-child  { border-right: none; }
.ph-stat-val   { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
.ph-stat-label { font-size: .67rem; color: rgba(255,255,255,.7); margin-top: 2px; }

/* mobile: stack tombol di bawah avatar+info */
@media (max-width: 480px) {
    .ph-top { gap: 12px; }
    .ph-avatar { width: 60px; height: 60px; font-size: 22px; }
    .ph-name { font-size: 1rem; }
    .btn-ganti-foto { width: 100%; justify-content: center; align-self: auto; }
    .ph-stats { gap: 0; }
    .ph-stat { min-width: 60px; padding: 0 8px; }
    .ph-stat-val { font-size: 1.1rem; }
}

/* ════════════════════════════════════════
   FLASH
════════════════════════════════════════ */
.flash-ok  { background: var(--success-soft); border: 1px solid var(--success); color: var(--success); border-radius: 10px; padding: 10px 14px; font-size: .81rem; font-weight: 600; margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }
.flash-err { background: var(--danger-soft);  border: 1px solid var(--danger);  color: var(--danger);  border-radius: 10px; padding: 10px 14px; font-size: .81rem; margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }

/* ════════════════════════════════════════
   SECTION TABS
════════════════════════════════════════ */
.section-tabs {
    display: flex;
    gap: 4px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 4px;
    margin-bottom: 18px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.section-tabs::-webkit-scrollbar { display: none; }

.section-tab {
    flex: 1;
    min-width: 90px;
    text-align: center;
    padding: 9px 8px;
    border-radius: 8px;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    color: var(--muted);
    border: none;
    background: transparent;
    white-space: nowrap;
    transition: all .18s;
    line-height: 1.3;
}
.section-tab i { display: block; font-size: 1rem; margin-bottom: 2px; }
.section-tab.active { background: var(--primary); color: #fff; }
.section-tab:hover:not(.active) { background: var(--bg); color: var(--primary); }

@media (max-width: 400px) {
    .section-tab { min-width: 72px; font-size: .7rem; padding: 8px 4px; }
    .section-tab i { font-size: .9rem; }
}

/* ════════════════════════════════════════
   FORM CARD
════════════════════════════════════════ */
.form-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 14px;
}
.form-card-title {
    font-size: .86rem; font-weight: 700; color: var(--text);
    margin-bottom: 14px; padding-bottom: 11px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 7px;
}
.form-card-title i { color: var(--primary); }

@media (max-width: 480px) {
    .form-card { padding: 14px 15px; }
}

/* ════════════════════════════════════════
   FORM CONTROLS
════════════════════════════════════════ */
.f-label {
    font-size: .77rem; font-weight: 600; color: var(--text);
    display: block; margin-bottom: 5px;
}
.f-input {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid var(--border);
    border-radius: 9px;
    font-size: .83rem; color: var(--text);
    background: #fff;
    outline: none;
    transition: border-color .18s, box-shadow .18s;
    /* Penting: cegah zoom di iOS saat font < 16px */
    font-size: 16px;
}
/* scale down font setelah antialiasing trickery tidak diperlukan di desktop */
@media (min-width: 576px) { .f-input { font-size: .83rem; } }

.f-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(30,58,95,.09);
}
.f-input:disabled { background: var(--bg); color: var(--muted); cursor: not-allowed; }

/* prefix wrapper (Rp / icon) */
.f-prefix-wrap { position: relative; }
.f-prefix {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    font-weight: 700; color: var(--muted); font-size: .82rem; pointer-events: none;
    /* line up dengan font-size 16px input */
}
.f-prefix + .f-input { padding-left: 36px; }

/* eye icon */
.f-eye {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    cursor: pointer; color: var(--muted); font-size: .9rem;
    padding: 4px; /* larger tap target */
}
.f-input.has-eye { padding-right: 38px; }

/* error hint */
.f-err { font-size: .73rem; color: var(--danger); margin-top: 4px; }

/* ════════════════════════════════════════
   FORM GRID — 2 kolom / 1 kolom di mobile
════════════════════════════════════════ */
.fg {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 13px;
}
.fg .s2 { grid-column: 1 / 3; }   /* span full */
.fg .s1 { grid-column: span 1; }  /* normal */

@media (max-width: 575px) {
    .fg { grid-template-columns: 1fr; gap: 11px; }
    .fg .s2 { grid-column: 1; }
}

/* save button */
.btn-save {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--primary); color: #fff;
    border: none; border-radius: 9px;
    font-size: .8rem; font-weight: 700;
    padding: 9px 20px; cursor: pointer;
    transition: opacity .18s;
    min-height: 38px;
}
.btn-save:hover { opacity: .87; }
.btn-save:active { opacity: .75; }
.save-row {
    display: flex;
    justify-content: flex-end;
    margin-top: 14px;
}
/* Di mobile tombol simpan full width */
@media (max-width: 480px) {
    .save-row { justify-content: stretch; }
    .btn-save { width: 100%; justify-content: center; }
}

/* ════════════════════════════════════════
   BADGE TOGGLE (Mapel & Jenjang)
════════════════════════════════════════ */
.badge-group { display: flex; gap: 7px; flex-wrap: wrap; }
.badge-toggle { cursor: pointer; margin: 0; }
.badge-toggle input { display: none; }
.badge-lbl {
    display: inline-block;
    font-size: .75rem; font-weight: 700;
    padding: 5px 13px; border-radius: 20px;
    cursor: pointer; transition: all .18s;
    border: 1.5px solid transparent;
    user-select: none;
    /* tap-friendly size */
    min-height: 30px; line-height: 1.6;
}

/* ════════════════════════════════════════
   KETERSEDIAAN HARI / SLOT
════════════════════════════════════════ */
.hari-row {
    display: flex; align-items: flex-start;
    gap: 10px; padding: 10px 0;
    border-bottom: 1px solid var(--border);
}
.hari-row:last-child { border-bottom: none; }
.hari-label {
    width: 60px; flex-shrink: 0;
    font-size: .77rem; font-weight: 700;
    color: var(--text); padding-top: 5px;
}
.slot-wrap { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
.slot-chip {
    font-size: .7rem; font-weight: 700;
    padding: 5px 11px; border-radius: 20px;
    cursor: pointer; transition: all .18s;
    user-select: none;
    min-height: 28px; /* tap-friendly */
    display: inline-flex; align-items: center;
}
.slot-chip.on  { background: var(--primary); color: #fff; }
.slot-chip.off {
    background: var(--bg); color: var(--muted);
    border: 1px solid var(--border);
}
.slot-chip.off:hover { border-color: var(--primary); color: var(--primary); }

@media (max-width: 400px) {
    .hari-label { width: 50px; font-size: .72rem; }
    .slot-chip  { font-size: .67rem; padding: 4px 9px; }
}

/* ════════════════════════════════════════
   NOTIFIKASI ROWS
════════════════════════════════════════ */
.notif-row {
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; padding: 11px 13px; border-radius: 10px;
    background: var(--bg); margin-bottom: 7px;
}
.notif-row:last-child { margin-bottom: 0; }
.notif-title { font-size: .81rem; font-weight: 600; color: var(--text); }
.notif-sub   { font-size: .71rem; color: var(--muted); margin-top: 1px; }
/* toggle lebih gampang ditekan */
.notif-row .form-check-input { width: 40px !important; height: 22px !important; cursor: pointer; flex-shrink: 0; }

/* ════════════════════════════════════════
   DANGER ZONE
════════════════════════════════════════ */
.danger-zone {
    background: var(--danger-soft, #fef2f2);
    border: 1.5px solid var(--danger, #ef4444);
    border-radius: 13px;
    padding: 18px 20px;
    margin-top: 4px;
}
.danger-zone-title {
    font-size: .86rem; font-weight: 700;
    color: var(--danger); margin-bottom: 6px;
    display: flex; align-items: center; gap: 7px;
}
.danger-zone-desc {
    font-size: .78rem; color: #7f1d1d;
    line-height: 1.6; margin-bottom: 14px;
}
.btn-danger {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--danger); color: #fff;
    border: none; border-radius: 9px;
    font-size: .79rem; font-weight: 700;
    padding: 9px 18px; cursor: pointer;
    transition: opacity .18s;
}
.btn-danger:hover { opacity: .87; }

@media (max-width: 480px) {
    .btn-danger { width: 100%; justify-content: center; }
}

/* ════════════════════════════════════════
   MODAL
════════════════════════════════════════ */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.48);
    z-index: 9999;
    align-items: flex-end; /* bottom sheet di mobile */
    justify-content: center;
    padding: 0;
}
.modal-overlay.open { display: flex; }

.modal-box {
    background: var(--card-bg, #fff);
    border-radius: 20px 20px 0 0; /* bottom sheet */
    padding: 24px 20px 28px;
    width: 100%;
    max-width: 100%;
    box-shadow: 0 -8px 40px rgba(0,0,0,.18);
    animation: sheetUp .24s cubic-bezier(.32,1,.23,1);
}
@keyframes sheetUp {
    from { transform: translateY(60px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

/* Desktop: modal tengah biasa */
@media (min-width: 520px) {
    .modal-overlay { align-items: center; padding: 16px; }
    .modal-box {
        border-radius: 16px;
        max-width: 440px;
        animation: modalIn .22s ease;
    }
    @keyframes modalIn {
        from { transform: scale(.94); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }
}

.modal-handle {
    width: 36px; height: 4px;
    background: var(--border);
    border-radius: 4px;
    margin: 0 auto 18px;
}
/* hide handle di desktop */
@media (min-width: 520px) { .modal-handle { display: none; } }

.modal-icon {
    width: 50px; height: 50px;
    background: var(--danger-soft, #fef2f2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; color: var(--danger);
    margin: 0 auto 12px;
}
.modal-title   { font-size: .98rem; font-weight: 800; color: var(--text); text-align: center; margin-bottom: 7px; }
.modal-desc    { font-size: .8rem; color: var(--muted); text-align: center; line-height: 1.55; margin-bottom: 5px; }
.modal-warning { font-size: .76rem; font-weight: 700; color: var(--danger); text-align: center; margin-bottom: 18px; }

.modal-confirm-lbl   { font-size: .77rem; font-weight: 600; color: var(--text); display: block; margin-bottom: 4px; }
.modal-email-display {
    display: block; background: var(--bg);
    border-radius: 7px; padding: 6px 10px;
    font-family: monospace; font-size: .77rem;
    color: var(--text); margin-bottom: 7px;
    word-break: break-all;
}
.modal-confirm-field { margin-bottom: 16px; }

.modal-actions { display: flex; gap: 9px; }
.modal-actions > * { flex: 1; }
.btn-m-cancel {
    padding: 11px 10px; border-radius: 9px;
    font-size: .81rem; font-weight: 700;
    background: var(--bg); color: var(--text);
    border: 1px solid var(--border); cursor: pointer;
    transition: background .18s;
    min-height: 42px;
}
.btn-m-cancel:hover { background: var(--border); }
.btn-m-danger {
    padding: 11px 10px; border-radius: 9px;
    font-size: .81rem; font-weight: 700;
    background: var(--danger); color: #fff;
    border: none; cursor: pointer;
    transition: opacity .18s;
    min-height: 42px;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.btn-m-danger:hover   { opacity: .87; }
.btn-m-danger:disabled { opacity: .4; cursor: not-allowed; }

/* ════════════════════════════════════════
   ULASAN
════════════════════════════════════════ */
.ulasan-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 14px;
    align-items: start;
}
@media (max-width: 767px) {
    .ulasan-layout { grid-template-columns: 1fr; }
}

.ulasan-summary {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 14px; padding: 18px; text-align: center;
}
/* Di mobile tampilkan summary sebagai row compact */
@media (max-width: 767px) {
    .ulasan-summary {
        display: flex; gap: 16px; align-items: flex-start;
        text-align: left; padding: 14px 16px;
    }
    .ulasan-sum-left { flex-shrink: 0; min-width: 100px; text-align: center; }
    .ulasan-sum-right { flex: 1; }
    .rating-bars { margin-top: 0; }
}
.ulasan-big-val { font-size: 2.8rem; font-weight: 800; color: var(--primary); line-height: 1; }
.ulasan-stars   { color: var(--accent, #f59e0b); font-size: .95rem; margin: 5px 0 3px; }
.ulasan-cnt     { font-size: .72rem; color: var(--muted); }
.rating-bars    { margin-top: 12px; }
.rb-row { display: flex; align-items: center; gap: 5px; margin-bottom: 4px; }
.rb-num { font-size: .68rem; font-weight: 700; width: 9px; text-align: right; }
.rb-bar-wrap { flex: 1; height: 5px; border-radius: 10px; background: var(--border); overflow: hidden; }
.rb-bar-fill { height: 100%; border-radius: 10px; background: var(--accent, #f59e0b); }
.rb-pct { font-size: .68rem; color: var(--muted); width: 24px; text-align: right; }

.ulasan-list-box {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 14px; padding: 16px 18px;
}
.ulasan-list-title { font-size: .86rem; font-weight: 700; color: var(--text); margin-bottom: 10px; }

.ulasan-item { padding: 11px 0; border-bottom: 1px solid var(--border); }
.ulasan-item:last-child { border-bottom: none; }

.ulasan-top {
    display: flex; align-items: flex-start; gap: 10px; margin-bottom: 5px;
    flex-wrap: nowrap;
}
.ulasan-ava {
    width: 30px; height: 30px; border-radius: 50%;
    background: var(--primary); color: #fff; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .78rem;
}
.ulasan-meta-wrap { flex: 1; min-width: 0; }
.ulasan-name  { font-size: .81rem; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ulasan-mapel { font-size: .7rem; color: var(--muted); }
.ulasan-bintang { flex-shrink: 0; color: var(--accent, #f59e0b); font-size: .76rem; white-space: nowrap; }
.ulasan-komentar { font-size: .79rem; color: var(--text); line-height: 1.5; margin-bottom: 3px; }
.ulasan-waktu { font-size: .7rem; color: var(--muted); }

.empty-box { text-align: center; padding: 28px 16px; color: var(--muted); }
.empty-box i { font-size: 2rem; display: block; margin-bottom: 8px; opacity: .35; }
.empty-box strong { font-size: .86rem; }
.empty-box p { font-size: .78rem; margin: 4px 0 0; }
</style>
@endpush

@section('content')

{{-- ════ PROFILE HEADER ════ --}}
<div class="profile-header">
    <div class="ph-top">

        <div class="ph-avatar">
            @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>

        <div class="ph-info">
            <p class="ph-name">{{ $user->name }}</p>
            <p class="ph-role">Tutor{{ $user->kota ? ' · '.$user->kota : '' }}</p>
            <div class="ph-badges">
                <span class="ph-badge"><i class="bi bi-star-fill" style="color:var(--accent,#f59e0b);"></i> Tutor Aktif</span>
                <span class="ph-badge"><i class="bi bi-shield-check-fill"></i> Terverifikasi</span>
            </div>
        </div>

        <form method="POST" action="/tutor/profil/upload-avatar"
              enctype="multipart/form-data" id="formAvatar">
            @csrf
            <input type="file" id="inputAvatar" name="avatar" accept="image/*" style="display:none;"
                   onchange="document.getElementById('formAvatar').submit()">
            <button type="button" class="btn-ganti-foto"
                    onclick="document.getElementById('inputAvatar').click()">
                <i class="bi bi-camera-fill"></i> Ganti Foto
            </button>
        </form>

    </div>

    <div class="ph-stats">
        <div class="ph-stat">
            <div class="ph-stat-val">{{ $totalSiswa }}</div>
            <div class="ph-stat-label">Siswa</div>
        </div>
        <div class="ph-stat">
            <div class="ph-stat-val">{{ $totalSesi }}</div>
            <div class="ph-stat-label">Sesi</div>
        </div>
        <div class="ph-stat">
            <div class="ph-stat-val">{{ $pengalaman > 0 ? $pengalaman.'th' : '-' }}</div>
            <div class="ph-stat-label">Pengalaman</div>
        </div>
        <div class="ph-stat">
            <div class="ph-stat-val">{{ $ratingRata ?: '-' }}</div>
            <div class="ph-stat-label">Rating</div>
        </div>
    </div>
</div>

{{-- ════ FLASH ════ --}}
@if(session('sukses_info'))
    <div class="flash-ok"><i class="bi bi-check-circle-fill"></i> {{ session('sukses_info') }}</div>
@endif
@if(session('sukses_password'))
    <div class="flash-ok"><i class="bi bi-check-circle-fill"></i> {{ session('sukses_password') }}</div>
@endif
@if(session('sukses_keahlian'))
    <div class="flash-ok"><i class="bi bi-check-circle-fill"></i> {{ session('sukses_keahlian') }}</div>
@endif
@if(session('sukses_ketersediaan'))
    <div class="flash-ok"><i class="bi bi-check-circle-fill"></i> {{ session('sukses_ketersediaan') }}</div>
@endif
@if(session('sukses_notifikasi'))
    <div class="flash-ok"><i class="bi bi-check-circle-fill"></i> {{ session('sukses_notifikasi') }}</div>
@endif
@if($errors->any())
    <div class="flash-err"><i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}</div>
@endif

{{-- ════ TABS ════ --}}
<div class="section-tabs" id="sectionTabs">
    <button class="section-tab" data-target="info" onclick="switchSection(this,'info')">
        <i class="bi bi-person"></i> Info
    </button>
    <button class="section-tab" data-target="keahlian" onclick="switchSection(this,'keahlian')">
        <i class="bi bi-book"></i> Keahlian
    </button>
    <button class="section-tab" data-target="keamanan" onclick="switchSection(this,'keamanan')">
        <i class="bi bi-shield-lock"></i> Keamanan
    </button>
    <button class="section-tab" data-target="ulasan" onclick="switchSection(this,'ulasan')">
        <i class="bi bi-star"></i> Ulasan
    </button>
</div>

{{-- ════════════════════════════════
     TAB 1 — INFO PRIBADI
════════════════════════════════ --}}
<div id="section-info" class="tab-pane" style="display:none;">
    <form method="POST" action="/tutor/profil/update-info">
        @csrf
        <div class="form-card">
            <div class="form-card-title"><i class="bi bi-person-fill"></i> Informasi Pribadi</div>

            <div class="fg">
                <div class="s1">
                    <label class="f-label">Nama Lengkap</label>
                    <input type="text" name="name" class="f-input"
                           value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="s1">
                    <label class="f-label">Email</label>
                    <input type="email" class="f-input" value="{{ $user->email }}" disabled>
                </div>
                <div class="s1">
                    <label class="f-label">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="f-input"
                           value="{{ old('no_hp', $user->no_hp) }}"
                           placeholder="08xx-xxxx-xxxx">
                </div>
                <div class="s1">
                    <label class="f-label">Kota Domisili</label>
                    <input type="text" name="kota" class="f-input"
                           value="{{ old('kota', $user->kota) }}"
                           placeholder="Contoh: Surabaya">
                </div>
                <div class="s1">
                    <label class="f-label">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="f-input">
                        @foreach(['D3','S1','S2','S3'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan', $user->pendidikan) === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="s1">
                    <label class="f-label">Jurusan / Program Studi</label>
                    <input type="text" name="jurusan" class="f-input"
                           value="{{ old('jurusan', $user->jurusan) }}"
                           placeholder="Contoh: Pendidikan Matematika">
                </div>
                <div class="s1">
                    <label class="f-label">Tahun Mulai Mengajar</label>
                    <input type="number" name="tahun_mengajar" class="f-input"
                           value="{{ old('tahun_mengajar', $user->tahun_mengajar) }}"
                           min="1990" max="{{ date('Y') }}" placeholder="{{ date('Y') - 3 }}">
                </div>
                <div class="s1">
                    <label class="f-label">Mode Mengajar</label>
                    <select name="mode_mengajar" class="f-input">
                        @foreach(['Online Saja','Online & Offline','Offline Saja'] as $m)
                            <option value="{{ $m }}" {{ old('mode_mengajar', $user->mode_mengajar) === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="s2">
                    <label class="f-label">Bio / Deskripsi Singkat</label>
                    <textarea name="bio" class="f-input" rows="3"
                              placeholder="Ceritakan pengalaman dan keahlian mengajar Anda..."
                              style="resize:vertical;">{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>

            <div class="save-row">
                <button type="submit" class="btn-save">
                    <i class="bi bi-check2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- ════════════════════════════════
     TAB 2 — KEAHLIAN & JADWAL
════════════════════════════════ --}}
<div id="section-keahlian" class="tab-pane" style="display:none;">

    {{-- Mata Pelajaran & Tarif --}}
    <form method="POST" action="/tutor/profil/simpan-keahlian">
        @csrf
        <div class="form-card">
            <div class="form-card-title"><i class="bi bi-mortarboard-fill"></i> Mata Pelajaran & Keahlian</div>

            <div class="fg">
                <div class="s2">
                    <label class="f-label">Mata Pelajaran yang Diajarkan</label>
                    <div class="badge-group">
                        @foreach(['Matematika','Fisika','Kalkulus','Aljabar','Trigonometri','Statistika','UTBK/TKA'] as $mapel)
                            @php $aktif = in_array($mapel, $user->mata_pelajaran_tutor ?? []); @endphp
                            <label class="badge-toggle">
                                <input type="checkbox" name="mata_pelajaran[]" value="{{ $mapel }}"
                                       {{ $aktif ? 'checked' : '' }}
                                       onchange="toggleBadge(this,'primary')">
                                <span class="badge-lbl" style="
                                    background:{{ $aktif ? 'var(--primary)' : '#eff6ff' }};
                                    color:{{ $aktif ? '#fff' : 'var(--primary)' }};
                                    border-color:{{ $aktif ? 'var(--primary)' : '#eff6ff' }};">
                                    {{ $mapel }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="s2">
                    <label class="f-label">Jenjang yang Diajar</label>
                    <div class="badge-group">
                        @foreach(['smp'=>'SMP','sma'=>'SMA','perguruan_tinggi'=>'Perguruan Tinggi'] as $val=>$lbl)
                            @php $aktif = in_array($val, $user->jenjang_tutor ?? []); @endphp
                            <label class="badge-toggle">
                                <input type="checkbox" name="jenjang[]" value="{{ $val }}"
                                       {{ $aktif ? 'checked' : '' }}
                                       onchange="toggleBadge(this,'success')">
                                <span class="badge-lbl" style="
                                    background:{{ $aktif ? 'var(--success)' : 'var(--bg)' }};
                                    color:{{ $aktif ? '#fff' : 'var(--muted)' }};
                                    border-color:{{ $aktif ? 'var(--success)' : 'var(--border)' }};">
                                    {{ $lbl }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="s1">
                    <label class="f-label">Tarif per Sesi (60 menit)</label>
                    <div class="f-prefix-wrap">
                        <span class="f-prefix">Rp</span>
                        <input type="number" name="tarif_per_sesi" class="f-input"
                               value="{{ $user->tarif_per_sesi ?? 75000 }}"
                               min="0" step="5000">
                    </div>
                </div>

                <div class="s1">
                    <label class="f-label">Maks. Siswa per Hari</label>
                    <input type="number" name="maks_siswa_per_hari" class="f-input"
                           value="{{ $user->maks_siswa_per_hari ?? 5 }}" min="1" max="20">
                </div>
            </div>

            <div class="save-row">
                <button type="submit" class="btn-save">
                    <i class="bi bi-check2"></i> Simpan Keahlian
                </button>
            </div>
        </div>
    </form>

    {{-- Ketersediaan Waktu --}}
    <form method="POST" action="/tutor/profil/simpan-ketersediaan" id="formKetersediaan">
        @csrf
        <input type="hidden" name="slots_json" id="slotsJson">
        <div class="form-card">
            <div class="form-card-title"><i class="bi bi-clock-fill"></i> Ketersediaan Waktu</div>

            @php
            $hariData = [
                ['Senin',   ['07:00','08:00','09:00','13:00','14:00'], ['07:00','09:00','13:00']],
                ['Selasa',  ['07:00','08:00','10:00','13:00','15:00'], ['08:00','10:00','15:00']],
                ['Rabu',    ['07:00','08:00','09:00','13:00'],         ['07:00','13:00']],
                ['Kamis',   ['07:00','09:00','13:00','15:00','17:00'], ['09:00','15:00']],
                ['Jumat',   ['07:00','08:00','13:00'],                 []],
                ['Sabtu',   ['07:00','09:00','11:00','13:00'],         ['07:00','09:00','11:00']],
                ['Minggu',  [],                                        []],
            ];
            @endphp

            @foreach($hariData as $h)
            <div class="hari-row">
                <div class="hari-label">{{ $h[0] }}</div>
                <div class="slot-wrap">
                    @if(count($h[1]) > 0)
                        @foreach($h[1] as $slot)
                            <span class="slot-chip {{ in_array($slot, $h[2]) ? 'on' : 'off' }}"
                                  data-hari="{{ $h[0] }}" data-slot="{{ $slot }}"
                                  onclick="toggleSlot(this)">{{ $slot }}</span>
                        @endforeach
                    @else
                        <span style="font-size:.74rem;color:var(--muted);">Tidak tersedia</span>
                    @endif
                </div>
            </div>
            @endforeach

            <div class="save-row">
                <button type="button" class="btn-save" onclick="submitKetersediaan()">
                    <i class="bi bi-check2"></i> Simpan Ketersediaan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- ════════════════════════════════
     TAB 3 — KEAMANAN
════════════════════════════════ --}}
<div id="section-keamanan" class="tab-pane" style="display:none;">

    {{-- Ubah Password --}}
    <form method="POST" action="/tutor/profil/ganti-password">
        @csrf
        <div class="form-card">
            <div class="form-card-title"><i class="bi bi-key-fill"></i> Ubah Password</div>

            <div class="fg">
                <div class="s2">
                    <label class="f-label">Password Saat Ini</label>
                    <div class="f-prefix-wrap">
                        <input type="password" name="password_lama" id="passLama"
                               class="f-input has-eye {{ $errors->has('password_lama') ? '' : '' }}"
                               style="{{ $errors->has('password_lama') ? 'border-color:var(--danger);' : '' }}"
                               placeholder="Masukkan password saat ini">
                        <i class="bi bi-eye f-eye" id="icoLama"
                           onclick="togglePass('passLama','icoLama')"></i>
                    </div>
                    @error('password_lama')
                        <div class="f-err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="s1">
                    <label class="f-label">Password Baru</label>
                    <div class="f-prefix-wrap">
                        <input type="password" name="password_baru" id="passBaru"
                               class="f-input has-eye"
                               placeholder="Minimal 8 karakter">
                        <i class="bi bi-eye f-eye" id="icoBaru"
                           onclick="togglePass('passBaru','icoBaru')"></i>
                    </div>
                </div>

                <div class="s1">
                    <label class="f-label">Konfirmasi Password</label>
                    <div class="f-prefix-wrap">
                        <input type="password" name="password_baru_confirmation" id="passKonfirm"
                               class="f-input has-eye"
                               placeholder="Ulangi password baru">
                        <i class="bi bi-eye f-eye" id="icoKonfirm"
                           onclick="togglePass('passKonfirm','icoKonfirm')"></i>
                    </div>
                </div>
            </div>

            <div class="save-row">
                <button type="submit" class="btn-save">
                    <i class="bi bi-shield-check"></i> Ubah Password
                </button>
            </div>
        </div>
    </form>

    {{-- Notifikasi --}}
    <form method="POST" action="/tutor/profil/simpan-notifikasi" id="formNotif">
        @csrf
        <div class="form-card">
            <div class="form-card-title"><i class="bi bi-bell-fill"></i> Pengaturan Notifikasi</div>

            @php
            $notifs = [
                ['notif_permintaan_jadwal', 'Les Privat',       'Permintaan jadwal dan konfirmasi sesi'],
                ['notif_pengingat_sesi',    'Pengingat Sesi',   'Pengingat 1 jam sebelum sesi dimulai'],
                ['notif_pembayaran',        'Pembayaran',       'Update status pembayaran sesi'],
                ['notif_ulasan',            'Ulasan & Sistem',  'Notifikasi ulasan dan pemberitahuan sistem'],
                ['notif_newsletter',        'Email Newsletter', 'Informasi dan tips mengajar'],
            ];
            @endphp

            @foreach($notifs as $n)
            <div class="notif-row">
                <div>
                    <div class="notif-title">{{ $n[1] }}</div>
                    <div class="notif-sub">{{ $n[2] }}</div>
                </div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox"
                           name="{{ $n[0] }}" {{ $user->{$n[0]} ? 'checked' : '' }}
                           onchange="scheduleNotifSave()">
                </div>
            </div>
            @endforeach

            <div class="save-row">
                <button type="submit" class="btn-save" id="btnSaveNotif">
                    <i class="bi bi-check2"></i> Simpan Notifikasi
                </button>
            </div>
        </div>
    </form>

    {{-- Danger Zone --}}
    <div class="danger-zone">
        <div class="danger-zone-title">
            <i class="bi bi-exclamation-triangle-fill"></i> Zona Berbahaya
        </div>
        <div class="danger-zone-desc">
            Menonaktifkan akun akan <strong>menghentikan semua jadwal aktif</strong> dan profil Anda tidak
            akan tampil kepada calon siswa. Data tidak akan dihapus — akun bisa diaktifkan kembali
            melalui admin.
        </div>
        <button type="button" class="btn-danger" onclick="bukaModal()">
            <i class="bi bi-x-circle-fill"></i> Nonaktifkan Akun
        </button>
    </div>
</div>

{{-- ════════════════════════════════
     TAB 4 — ULASAN SISWA
════════════════════════════════ --}}
<div id="section-ulasan" class="tab-pane" style="display:none;">
    <div class="ulasan-layout">

        {{-- Ringkasan --}}
        <div class="ulasan-summary">
            {{-- wrapper agar mobile bisa flex row --}}
            <div class="ulasan-sum-left">
                <div class="ulasan-big-val">{{ $ratingRata ?: '-' }}</div>
                <div class="ulasan-stars">
                    @for($i=1;$i<=5;$i++)
                        <i class="bi bi-star{{ $i<=floor($ratingRata)?'-fill':'' }}"></i>
                    @endfor
                </div>
                <div class="ulasan-cnt">{{ $totalUlasan }} ulasan</div>
            </div>
            <div class="ulasan-sum-right">
                <div class="rating-bars">
                    @foreach([5,4,3,2,1] as $b)
                    <div class="rb-row">
                        <span class="rb-num">{{ $b }}</span>
                        <i class="bi bi-star-fill" style="font-size:.55rem;color:var(--accent,#f59e0b);"></i>
                        <div class="rb-bar-wrap">
                            <div class="rb-bar-fill" style="width:{{ $distribusi[$b] ?? 0 }}%;"></div>
                        </div>
                        <span class="rb-pct">{{ $distribusi[$b] ?? 0 }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Daftar --}}
        <div class="ulasan-list-box">
            <div class="ulasan-list-title">Ulasan Terbaru</div>

            @forelse($ulasanList->take(10) as $u)
            <div class="ulasan-item">
                <div class="ulasan-top">
                    <div class="ulasan-ava">{{ strtoupper(substr($u->siswa->name ?? 'S',0,1)) }}</div>
                    <div class="ulasan-meta-wrap">
                        <div class="ulasan-name">{{ $u->siswa->name ?? '-' }}</div>
                        <div class="ulasan-mapel">{{ $u->mata_pelajaran ?? '-' }}</div>
                    </div>
                    <div class="ulasan-bintang">
                        @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star{{ $i<=$u->bintang?'-fill':'' }}"></i>
                        @endfor
                    </div>
                </div>
                @if($u->komentar)
                    <div class="ulasan-komentar">{{ $u->komentar }}</div>
                @endif
                <div class="ulasan-waktu">
                    <i class="bi bi-clock me-1"></i>{{ $u->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="empty-box">
                <i class="bi bi-star"></i>
                <strong>Belum ada ulasan</strong>
                <p>Ulasan dari siswa akan muncul setelah sesi selesai.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

{{-- ════════════════════════════════════════
     MODAL — KONFIRMASI NONAKTIFKAN AKUN
════════════════════════════════════════ --}}
<div class="modal-overlay" id="modalNonaktif" onclick="cekKlikBackdrop(event)">
    <div class="modal-box" id="modalBox">
        <div class="modal-handle"></div>

        <div class="modal-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div class="modal-title">Nonaktifkan Akun?</div>
        <div class="modal-desc">
            Semua jadwal aktif akan dihentikan dan profil Anda tidak akan tampil kepada calon siswa.
            Akun dapat diaktifkan kembali melalui admin.
        </div>
        <div class="modal-warning">
            <i class="bi bi-shield-exclamation me-1"></i>
            Tindakan ini tidak dapat langsung dibatalkan.
        </div>

        <div class="modal-confirm-field">
            <label class="modal-confirm-lbl">Ketik email Anda untuk konfirmasi:</label>
            <code class="modal-email-display">{{ $user->email }}</code>
            <input type="email" id="konfirmasiEmail" class="f-input"
                   placeholder="{{ $user->email }}"
                   oninput="cekEmail()" autocomplete="off">
            <div id="emailErr" class="f-err" style="display:none;">Email tidak cocok.</div>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn-m-cancel" onclick="tutupModal()">Batal</button>
            <form method="POST" action="/tutor/profil/nonaktifkan"
                  style="flex:1;display:flex;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-m-danger" id="btnKonfirmasi"
                        style="width:100%;" disabled>
                    <i class="bi bi-x-circle-fill"></i> Ya, Nonaktifkan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

{{-- ════════════════════════════════
     PHP: tentukan tab awal
════════════════════════════════ --}}
@php
$bukaTabKeamanan = $errors->has('password_lama') || session('tab') === 'keamanan';
$defaultTab = 'info';
if ($bukaTabKeamanan)              $defaultTab = 'keamanan';
if (session('tab') === 'keahlian') $defaultTab = 'keahlian';
if (session('tab') === 'ulasan')   $defaultTab = 'ulasan';
@endphp

@push('scripts')
<script>
/* ═══════════════════════════════════════
   KONSTANTA
═══════════════════════════════════════ */
const TABS      = ['info','keahlian','keamanan','ulasan'];
const USER_EMAIL = @json($user->email);

/* ═══════════════════════════════════════
   TAB SWITCHER
═══════════════════════════════════════ */
function switchSection(btnEl, id) {
    document.querySelectorAll('.section-tab').forEach(b => b.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');
    TABS.forEach(t => {
        const el = document.getElementById('section-' + t);
        if (el) el.style.display = (t === id) ? '' : 'none';
    });
    history.replaceState(null, '', '#' + id);
}

/* Inisialisasi tab saat halaman dimuat */
document.addEventListener('DOMContentLoaded', () => {
    let start = '{{ $defaultTab }}';
    const hash = location.hash.replace('#', '');
    if (TABS.includes(hash)) start = hash;
    const btn = document.querySelector(`.section-tab[data-target="${start}"]`);
    switchSection(btn, start);
});

/* ═══════════════════════════════════════
   SLOT KETERSEDIAAN
═══════════════════════════════════════ */
function toggleSlot(el) {
    el.classList.toggle('on');
    el.classList.toggle('off');
}

function submitKetersediaan() {
    const data = {};
    document.querySelectorAll('.slot-chip.on').forEach(c => {
        const h = c.dataset.hari, s = c.dataset.slot;
        if (!data[h]) data[h] = [];
        data[h].push(s);
    });
    document.getElementById('slotsJson').value = JSON.stringify(data);
    document.getElementById('formKetersediaan').submit();
}

/* ═══════════════════════════════════════
   BADGE TOGGLE (mapel / jenjang)
═══════════════════════════════════════ */
function toggleBadge(cb, warna) {
    const sp = cb.nextElementSibling;
    const p  = warna === 'primary';
    if (cb.checked) {
        sp.style.background  = p ? 'var(--primary)' : 'var(--success)';
        sp.style.color       = '#fff';
        sp.style.borderColor = p ? 'var(--primary)' : 'var(--success)';
    } else {
        sp.style.background  = p ? '#eff6ff'       : 'var(--bg)';
        sp.style.color       = p ? 'var(--primary)': 'var(--muted)';
        sp.style.borderColor = p ? '#eff6ff'       : 'var(--border)';
    }
}

/* ═══════════════════════════════════════
   TOGGLE SHOW/HIDE PASSWORD
═══════════════════════════════════════ */
function togglePass(inputId, iconId) {
    const inp  = document.getElementById(inputId);
    const ico  = document.getElementById(iconId);
    const show = inp.type === 'password';
    inp.type       = show ? 'text'              : 'password';
    ico.className  = show ? 'bi bi-eye-slash f-eye' : 'bi bi-eye f-eye';
}

/* ═══════════════════════════════════════
   NOTIFIKASI — debounce 700 ms
═══════════════════════════════════════ */
let notifTimer = null;
function scheduleNotifSave() {
    clearTimeout(notifTimer);
    notifTimer = setTimeout(() => document.getElementById('formNotif').submit(), 700);
}

/* ═══════════════════════════════════════
   MODAL NONAKTIFKAN
═══════════════════════════════════════ */
function bukaModal() {
    document.getElementById('konfirmasiEmail').value = '';
    document.getElementById('btnKonfirmasi').disabled = true;
    document.getElementById('emailErr').style.display = 'none';
    document.getElementById('modalNonaktif').classList.add('open');
    setTimeout(() => document.getElementById('konfirmasiEmail').focus(), 150);

    /* Cegah scroll halaman di belakang modal */
    document.body.style.overflow = 'hidden';
}

function tutupModal() {
    document.getElementById('modalNonaktif').classList.remove('open');
    document.body.style.overflow = '';
}

function cekKlikBackdrop(e) {
    if (e.target === document.getElementById('modalNonaktif')) tutupModal();
}

function cekEmail() {
    const val  = document.getElementById('konfirmasiEmail').value.trim();
    const sama = val === USER_EMAIL;
    document.getElementById('btnKonfirmasi').disabled = !sama;
    document.getElementById('emailErr').style.display =
        (val.length > 0 && !sama) ? 'block' : 'none';
}

/* Tutup dengan ESC */
document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupModal(); });
</script>
@endpush