@extends('layouts.app')

@section('title', 'Pengelolaan Pengguna - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Pengelolaan Pengguna')
@section('page-sub', 'Admin / Pengelolaan Pengguna')

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
/* ─────────────────────────────────────────────────
   TOKENS
───────────────────────────────────────────────── */
.pg {
    --navy:  #0f2342;
    --blue:  #1d4ed8;
    --slate: #64748b;
    --line:  #e8ecf0;
    --bg:    #f5f7fa;
    --card:  #ffffff;
    --green: #16a34a;
    --red:   #dc2626;
    --amber: #d97706;
    --info:  #0284c7;
}

/* ─────────────────────────────────────────────────
   STAT CARDS
───────────────────────────────────────────────── */
.sc {
    background: var(--card);
    border-radius: 14px;
    padding: 16px;
    border: 1px solid var(--line);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: transform .18s, box-shadow .18s;
}
.sc:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.sc-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem; flex-shrink: 0;
}
.sc-val   { font-size: 1.4rem; font-weight: 800; color: var(--navy); line-height: 1; }
.sc-label { font-size: .76rem; color: var(--slate); margin-top: 4px; }

/* ─────────────────────────────────────────────────
   TABS
───────────────────────────────────────────────── */
.tab-nav {
    display: flex; gap: 5px;
    background: var(--card); border: 1px solid var(--line);
    border-radius: 12px; padding: 4px;
    margin-bottom: 20px;
    overflow-x: auto; scrollbar-width: none;
}
.tab-nav::-webkit-scrollbar { display: none; }

.tab-btn {
    flex: 1; min-width: 110px; text-align: center;
    padding: 9px 8px; border-radius: 8px;
    font-size: 13px; font-weight: 700; cursor: pointer;
    color: var(--slate); border: none; background: transparent;
    white-space: nowrap; transition: all .18s;
}
.tab-btn.active { background: var(--navy); color: #fff; }
.tab-btn:hover:not(.active) { background: var(--bg); color: var(--navy); }

.tab-count {
    font-size: 10px; border-radius: 20px;
    padding: 1px 6px; margin-left: 4px; font-weight: 700;
    background: rgba(255,255,255,.25); color: inherit;
}
.tab-btn:not(.active) .tab-count { background: var(--line); color: var(--slate); }

.tab-pane { display: none; }
.tab-pane.active { display: block; }

/* ─────────────────────────────────────────────────
   CARD BOX
───────────────────────────────────────────────── */
.card-box {
    background: var(--card); border-radius: 14px;
    border: 1px solid var(--line); overflow: hidden;
}
.cb-head {
    padding: 14px 18px; border-bottom: 1px solid var(--line);
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 8px;
}
.cb-title { font-size: 14px; font-weight: 700; color: var(--navy); }

/* ─────────────────────────────────────────────────
   FILTER BAR
───────────────────────────────────────────────── */
.filter-bar {
    padding: 12px 16px; border-bottom: 1px solid var(--line);
    display: flex; align-items: center; flex-wrap: wrap; gap: 8px;
}

.search-wrap { flex: 1; min-width: 160px; position: relative; }
.search-wrap i {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%); color: var(--slate); font-size: 13px;
}
.search-wrap input {
    width: 100%; padding: 8px 12px 8px 33px;
    border: 1.5px solid var(--line); border-radius: 9px;
    font-size: 13px; outline: none; background: var(--bg);
    color: var(--navy);
}
.search-wrap input:focus { border-color: var(--navy); }

.filter-sel {
    padding: 8px 28px 8px 12px;
    border: 1.5px solid var(--line); border-radius: 9px;
    font-size: 12.5px; background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 10px center;
    appearance: none; color: var(--navy); outline: none;
}
.filter-sel:focus { border-color: var(--navy); }

/* ─────────────────────────────────────────────────
   TABLE  — responsif dengan scroll horizontal
───────────────────────────────────────────────── */
.tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

.tbl { width: 100%; border-collapse: collapse; min-width: 560px; }

.tbl thead th {
    background: #f8fafc; font-size: 11px; font-weight: 700;
    color: var(--slate); text-transform: uppercase; letter-spacing: .3px;
    padding: 10px 14px; border-bottom: 1px solid var(--line); white-space: nowrap;
}
.tbl tbody td {
    padding: 12px 14px; font-size: 13px;
    border-bottom: 1px solid #f1f5f9; vertical-align: middle;
}
.tbl tbody tr:last-child td { border-bottom: none; }
.tbl tbody tr:hover td { background: #f8fbff; }

/* Avatar */
.u-av {
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
}

/* Aksi tombol */
.act-btn {
    width: 30px; height: 30px; border-radius: 8px;
    border: 1.5px solid var(--line); background: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; transition: all .15s; color: var(--slate);
}
.act-btn:hover { border-color: var(--navy); color: var(--navy); background: #eff6ff; }

/* Badge */
.badge-status {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11.5px; font-weight: 700; white-space: nowrap;
}

/* Table footer info */
.tbl-foot {
    padding: 11px 18px; border-top: 1px solid var(--line);
    font-size: 12.5px; color: var(--slate);
}

/* ─────────────────────────────────────────────────
   EXPORT BUTTON  (dengan loading state)
───────────────────────────────────────────────── */
.exp-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 9px;
    border: 1.5px solid var(--line); background: var(--bg);
    font-size: 12.5px; font-weight: 600; cursor: pointer;
    color: var(--slate); text-decoration: none;
    transition: all .15s; white-space: nowrap;
}
.exp-btn:hover { border-color: var(--navy); color: var(--navy); }

/* Spinner kecil di dalam tombol */
.exp-btn .btn-spin {
    display: none;
    width: 13px; height: 13px;
    border: 2px solid rgba(100,116,139,.3);
    border-top-color: var(--slate);
    border-radius: 50%;
    animation: spin .7s linear infinite;
    flex-shrink: 0;
}
.exp-btn.loading .btn-spin  { display: block; }
.exp-btn.loading .btn-icon  { display: none; }
.exp-btn.loading            { pointer-events: none; opacity: .75; }

@keyframes spin { to { transform: rotate(360deg); } }

/* ─────────────────────────────────────────────────
   TOAST NOTIFIKASI (muncul di bawah layar)
───────────────────────────────────────────────── */
.dl-toast {
    position: fixed; bottom: 24px; left: 50%;
    transform: translateX(-50%) translateY(20px);
    z-index: 9100; display: flex; align-items: center; gap: 10px;
    background: var(--navy); color: #fff;
    border-radius: 999px; padding: 10px 18px;
    font-size: 13px; font-weight: 600; white-space: nowrap;
    box-shadow: 0 8px 28px rgba(0,0,0,.2);
    opacity: 0; pointer-events: none;
    transition: opacity .25s, transform .25s;
}
.dl-toast.show {
    opacity: 1; transform: translateX(-50%) translateY(0);
    pointer-events: auto;
}
.dl-toast.success { background: #15803d; }

.toast-spin {
    width: 15px; height: 15px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff; border-radius: 50%;
    animation: spin .7s linear infinite; flex-shrink: 0;
}
.dl-toast.success .toast-spin { display: none; }

/* ─────────────────────────────────────────────────
   MODAL
───────────────────────────────────────────────── */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.45); z-index: 9999;
    align-items: center; justify-content: center; padding: 16px;
}
.modal-overlay.show { display: flex; }

.modal-box {
    background: #fff; border-radius: 18px;
    width: 100%; max-width: 460px; max-height: 92vh;
    overflow-y: auto; animation: fadeUp .22s ease;
}
@keyframes fadeUp {
    from { transform: translateY(18px); opacity: 0; }
    to   { transform: translateY(0);   opacity: 1; }
}

.modal-head {
    padding: 16px 20px; border-bottom: 1px solid var(--line);
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; background: #fff; z-index: 1;
}
.modal-head h5 { font-size: 15px; font-weight: 800; color: var(--navy); margin: 0; }

.modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    border: none; background: var(--bg); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: var(--slate);
}
.modal-close:hover { background: #fee2e2; color: var(--red); }

/* Avatar besar di modal */
.modal-av {
    width: 64px; height: 64px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; font-weight: 700; color: #fff;
    margin: 0 auto 8px;
}

/* Detail rows */
.detail-row {
    display: flex; gap: 10px; padding: 10px 0;
    border-bottom: 1px solid var(--line);
}
.detail-row:last-child { border-bottom: none; }
.detail-lbl {
    font-size: 12px; color: var(--slate); font-weight: 500;
    width: 130px; flex-shrink: 0;
}
.detail-val { font-size: 13px; font-weight: 600; flex: 1; color: var(--navy); }

/* Modal tutup btn */
.modal-close-full {
    width: 100%; margin-top: 16px; padding: 10px;
    border-radius: 10px; border: 1.5px solid var(--line);
    background: var(--bg); font-size: 13px; font-weight: 600;
    cursor: pointer; color: var(--slate);
}
.modal-close-full:hover { border-color: var(--navy); color: var(--navy); }

/* ─────────────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────────────── */
@media (max-width: 576px) {
    .sc { padding: 13px; }
    .sc-icon { width: 38px; height: 38px; font-size: 1rem; }
    .sc-val { font-size: 1.25rem; }
    .filter-bar { flex-direction: column; }
    .search-wrap { min-width: 0; }
    .filter-sel { width: 100%; }
    .cb-head { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')
<div class="pg">

{{-- ════════════ TOAST ════════════ --}}
<div id="dl-toast" class="dl-toast">
    <span class="toast-spin"></span>
    <span id="dl-toast-txt">Menyiapkan file…</span>
</div>

{{-- ════════════ HEADER ════════════ --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1" style="color:var(--navy);">👥 Pengelolaan Pengguna</h4>
        <p style="font-size:13px;color:var(--slate);margin:0;">Kelola data siswa dan tutor terdaftar</p>
    </div>
</div>

{{-- ════════════ STAT CARDS ════════════ --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['bi-mortarboard-fill', '#eff6ff',           '#1d4ed8',
         \App\Models\User::where('role','siswa')->count(), 'Total Siswa'],
        ['bi-person-video3',   '#f0f9ff',            '#0284c7',
         \App\Models\User::where('role','tutor')->count(), 'Total Tutor'],
        ['bi-person-check-fill','#f0fdf4',           '#16a34a',
         \App\Models\User::count(), 'Total Aktif'],
        ['bi-person-exclamation','#fffbeb',          '#d97706',
         0, 'Verifikasi Pending'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-md-3">
        <div class="sc">
            <div class="sc-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div>
                <div class="sc-val">{{ $s[3] }}</div>
                <div class="sc-label">{{ $s[4] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ════════════ TABS ════════════ --}}
<div class="tab-nav">
    <button class="tab-btn active" onclick="switchTab(this,'siswa')">
        <i class="bi bi-mortarboard-fill me-1"></i> Siswa
        <span class="tab-count">{{ \App\Models\User::where('role','siswa')->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchTab(this,'tutor')">
        <i class="bi bi-person-video3 me-1"></i> Tutor
        <span class="tab-count">{{ \App\Models\User::where('role','tutor')->count() }}</span>
    </button>
</div>

{{-- ════════════ TAB SISWA ════════════ --}}
<div class="tab-pane active" id="tab-siswa">
    <div class="card-box">
        <div class="cb-head">
            <div class="cb-title">
                <i class="bi bi-mortarboard-fill me-2" style="color:#1d4ed8;"></i>Daftar Siswa
            </div>
            {{--
                EXPORT BUTTON — Teknik: cookie polling
                1. Klik → tombol jadi loading state + toast muncul
                2. window.location.href buka URL download
                3. Server set cookie "download_done" setelah file siap
                4. JS polling cek cookie setiap 500ms
                5. Kalau cookie ada → sembunyikan loading, hapus cookie
            --}}
            <button class="exp-btn" onclick="startExport(this,'/admin/pengguna/export?role=siswa')">
                <span class="btn-spin"></span>
                <i class="bi bi-download btn-icon"></i>
                <span class="btn-label">Export</span>
            </button>
        </div>

        <div class="filter-bar">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="search-siswa" placeholder="Cari nama atau email…"
                       oninput="filterTable('tbl-siswa', this.value)">
            </div>
            <select class="filter-sel" onchange="filterTableStatus('tbl-siswa', this.value)">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        <div class="tbl-wrap">
            <table class="tbl" id="tbl-siswa">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>No. HP</th>
                        <th>Tanggal Daftar</th>
                        <th>Total Les</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\User::where('role','siswa')->latest()->paginate(10) as $u)
                    @php $totalLes = \App\Models\LesPrivat::where('user_id',$u->id)->count(); @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div class="u-av" style="background:#1d4ed8;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <div style="min-width:0;">
                                    <div style="font-weight:600;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">{{ $u->name }}</div>
                                    <div style="font-size:11px;color:var(--slate);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12.5px;color:var(--slate);">{{ $u->no_hp ?? '-' }}</td>
                        <td style="font-size:12.5px;color:var(--slate);white-space:nowrap;">{{ $u->created_at->format('d M Y') }}</td>
                        <td style="text-align:center;font-weight:700;color:#1d4ed8;">{{ $totalLes }}</td>
                        <td>
                            <span class="badge-status" style="background:#f0fdf4;color:#16a34a;" data-status="Aktif">
                                <i class="bi bi-circle-fill" style="font-size:6px;"></i> Aktif
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <button class="act-btn"
                                    title="Lihat Detail"
                                    onclick="openModal('siswa','{{ addslashes($u->name) }}','{{ $u->email }}','{{ $u->no_hp ?? '-' }}','{{ $u->created_at->format('d M Y') }}')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:36px;color:var(--slate);">
                            <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                            Belum ada siswa terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="tbl-foot">
            Menampilkan {{ \App\Models\User::where('role','siswa')->count() }} siswa
        </div>
    </div>
</div>

{{-- ════════════ TAB TUTOR ════════════ --}}
<div class="tab-pane" id="tab-tutor">
    <div class="card-box">
        <div class="cb-head">
            <div class="cb-title">
                <i class="bi bi-person-video3 me-2" style="color:#0284c7;"></i>Daftar Tutor
            </div>
            <button class="exp-btn" onclick="startExport(this,'/admin/pengguna/export?role=tutor')">
                <span class="btn-spin"></span>
                <i class="bi bi-download btn-icon"></i>
                <span class="btn-label">Export</span>
            </button>
        </div>

        <div class="filter-bar">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="search-tutor" placeholder="Cari nama atau email…"
                       oninput="filterTable('tbl-tutor', this.value)">
            </div>
            <select class="filter-sel" onchange="filterTableStatus('tbl-tutor', this.value)">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        <div class="tbl-wrap">
            <table class="tbl" id="tbl-tutor">
                <thead>
                    <tr>
                        <th>Tutor</th>
                        <th>No. HP</th>
                        <th>Mata Pelajaran</th>
                        <th>Total Sesi</th>
                        <th>Selesai</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\User::where('role','tutor')->latest()->get() as $u)
                    @php
                        $mapel     = $u->materi()->distinct('mata_pelajaran')->pluck('mata_pelajaran')->take(2)->join(', ') ?: '-';
                        $totalSesi = \App\Models\LesPrivat::where('tutor_id',$u->id)->count();
                        $selesai   = \App\Models\LesPrivat::where('tutor_id',$u->id)->where('status','selesai')->count();
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div class="u-av" style="background:#0284c7;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <div style="min-width:0;">
                                    <div style="font-weight:600;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;">{{ $u->name }}</div>
                                    <div style="font-size:11px;color:var(--slate);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12.5px;color:var(--slate);">{{ $u->no_hp ?? '-' }}</td>
                        <td style="font-size:12px;max-width:120px;">
                            <span style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $mapel }}</span>
                        </td>
                        <td style="text-align:center;font-weight:700;color:#1d4ed8;">{{ $totalSesi }}</td>
                        <td style="text-align:center;font-weight:700;color:#16a34a;">{{ $selesai }}</td>
                        <td style="font-size:12.5px;color:var(--slate);white-space:nowrap;">{{ $u->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <button class="act-btn"
                                    title="Lihat Detail"
                                    onclick="openModal('tutor','{{ addslashes($u->name) }}','{{ $u->email }}','{{ $u->no_hp ?? '-' }}','{{ $u->created_at->format('d M Y') }}','{{ addslashes($mapel) }}')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:36px;color:var(--slate);">
                            <i class="bi bi-person-video3" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                            Belum ada tutor terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="tbl-foot">
            Menampilkan {{ \App\Models\User::where('role','tutor')->count() }} tutor
        </div>
    </div>
</div>

{{-- ════════════ MODAL DETAIL ════════════ --}}
<div class="modal-overlay" id="modal-detail" onclick="if(event.target===this)closeModal()">
    <div class="modal-box">
        <div class="modal-head">
            <h5 id="modal-title">Detail Pengguna</h5>
            <button class="modal-close" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            {{-- Avatar & nama --}}
            <div style="text-align:center;margin-bottom:18px;">
                <div id="modal-av" class="modal-av"></div>
                <div id="modal-nama" style="font-size:16px;font-weight:800;color:var(--navy);margin-bottom:3px;"></div>
                <div id="modal-email" style="font-size:12.5px;color:var(--slate);"></div>
            </div>
            {{-- Rows --}}
            <div id="modal-rows"></div>
            <button class="modal-close-full" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

</div>{{-- /pg --}}
@endsection

@push('scripts')
<script>
/* ═══════════════════════════════════════════
   TAB SWITCHER
═══════════════════════════════════════════ */
function switchTab(el, id) {
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    ['siswa','tutor'].forEach(t => {
        document.getElementById('tab-'+t).classList.toggle('active', t === id);
    });
}

/* ═══════════════════════════════════════════
   LIVE SEARCH & FILTER
═══════════════════════════════════════════ */
function filterTable(tblId, query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('#' + tblId + ' tbody tr').forEach(row => {
        const txt = row.textContent.toLowerCase();
        row.style.display = (q === '' || txt.includes(q)) ? '' : 'none';
    });
}

function filterTableStatus(tblId, status) {
    document.querySelectorAll('#' + tblId + ' tbody tr').forEach(row => {
        if (!status) { row.style.display = ''; return; }
        const badge = row.querySelector('[data-status]');
        row.style.display = (badge && badge.dataset.status === status) ? '' : 'none';
    });
}

/* ═══════════════════════════════════════════
   MODAL
═══════════════════════════════════════════ */
function openModal(role, nama, email, hp, bergabung, mapel) {
    // Header & avatar
    const isSiswa = role === 'siswa';
    document.getElementById('modal-title').innerHTML =
        isSiswa
        ? '<i class="bi bi-mortarboard-fill me-2" style="color:#1d4ed8;"></i>Detail Siswa'
        : '<i class="bi bi-person-video3 me-2" style="color:#0284c7;"></i>Detail Tutor';

    const av = document.getElementById('modal-av');
    av.textContent = nama.charAt(0).toUpperCase();
    av.style.background = isSiswa ? '#1d4ed8' : '#0284c7';

    document.getElementById('modal-nama').textContent  = nama;
    document.getElementById('modal-email').textContent = email;

    // Rows
    let rows = `
        <div class="detail-row">
            <div class="detail-lbl">No. HP</div>
            <div class="detail-val">${hp}</div>
        </div>`;

    if (!isSiswa && mapel) {
        rows += `
        <div class="detail-row">
            <div class="detail-lbl">Mata Pelajaran</div>
            <div class="detail-val">${mapel}</div>
        </div>`;
    }

    rows += `
        <div class="detail-row">
            <div class="detail-lbl">Bergabung</div>
            <div class="detail-val">${bergabung}</div>
        </div>
        <div class="detail-row">
            <div class="detail-lbl">Role</div>
            <div class="detail-val">
                <span style="background:${isSiswa?'#eff6ff':'#f0f9ff'};color:${isSiswa?'#1d4ed8':'#0284c7'};font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">
                    ${isSiswa ? 'Siswa' : 'Tutor'}
                </span>
            </div>
        </div>
        <div class="detail-row">
            <div class="detail-lbl">Status</div>
            <div class="detail-val">
                <span style="background:#f0fdf4;color:#16a34a;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">
                    ✓ Aktif
                </span>
            </div>
        </div>`;

    document.getElementById('modal-rows').innerHTML = rows;
    document.getElementById('modal-detail').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modal-detail').classList.remove('show');
    document.body.style.overflow = '';
}

/* ═══════════════════════════════════════════
   EXPORT DENGAN COOKIE POLLING
   ─────────────────────────────────────────
   Cara kerja:
   1. Klik → btn loading + toast muncul
   2. Buka URL download via window.location.href
   3. Server wajib set cookie: "download_done=1; path=/"
      setelah file selesai dikirim ke browser.
      Contoh di Controller Laravel:
        Cookie::queue('download_done', '1', 1, '/');
        return response()->download($path)->withCookie(...);
      Atau pakai header manual:
        header('Set-Cookie: download_done=1; path=/');
   4. JS polling setiap 500ms cek cookie tsb.
   5. Kalau ketemu → reset btn + sembunyikan toast.
   6. Fallback timeout 3 detik agar tidak loading selamanya.
═══════════════════════════════════════════ */
let _exportTimer   = null;   // fallback timeout
let _exportPoller  = null;   // interval polling

function startExport(btn, url) {
    // Bersihkan polling lama kalau ada
    clearTimeout(_exportTimer);
    clearInterval(_exportPoller);

    // State loading
    btn.classList.add('loading');
    btn.querySelector('.btn-label').textContent = 'Memproses…';

    // Tampilkan toast
    showToast('Menyiapkan file, mohon tunggu…', false);

    // Hapus cookie lama dulu (jika ada sisa)
    deleteCookie('download_done');

    // Trigger download
    window.location.href = url;

    // Polling: cek cookie setiap 500ms
    _exportPoller = setInterval(() => {
        if (getCookie('download_done') === '1') {
            finishExport(btn);
        }
    }, 500);

    // Fallback: 3 detik paksa selesai
    _exportTimer = setTimeout(() => {
        finishExport(btn, true);
    }, 3000);
}

function finishExport(btn, isTimeout = false) {
    clearInterval(_exportPoller);
    clearTimeout(_exportTimer);
    deleteCookie('download_done');

    // Reset tombol
    btn.classList.remove('loading');
    btn.querySelector('.btn-label').textContent = 'Export';

    if (isTimeout) {
        // Timeout — mungkin sudah selesai, mungkin error
        showToast('Download selesai (atau cek folder unduhan)', true);
    } else {
        showToast('✓ File berhasil diunduh!', true);
    }

    // Sembunyikan toast sukses setelah 3 detik
    setTimeout(() => hideToast(), 3000);
}

/* ─── Cookie helpers ─── */
function getCookie(name) {
    const match = document.cookie.match(new RegExp('(?:^|;\\s*)' + name + '=([^;]*)'));
    return match ? decodeURIComponent(match[1]) : null;
}

function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

/* ─── Toast helpers ─── */
function showToast(msg, success) {
    const t = document.getElementById('dl-toast');
    document.getElementById('dl-toast-txt').textContent = msg;
    t.classList.toggle('success', !!success);
    t.classList.add('show');
}

function hideToast() {
    document.getElementById('dl-toast').classList.remove('show');
}
</script>
@endpush