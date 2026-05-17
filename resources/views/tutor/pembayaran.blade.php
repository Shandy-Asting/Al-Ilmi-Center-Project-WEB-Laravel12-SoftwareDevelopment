@extends('layouts.app')

@section('title', 'Pembayaran - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Konfirmasi Pembayaran')
@section('page-sub', 'Dashboard / Pembayaran')

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
    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 18px;
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
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-val {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text);
    }

    .stat-label {
        font-size: .78rem;
        color: var(--muted);
        margin-top: 4px;
    }

    .main-tabs {
        display: flex;
        gap: 6px;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 5px;
        margin-bottom: 24px;
    }

    .main-tab {
        flex: 1;
        text-align: center;
        padding: 9px 8px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        color: var(--muted);
        border: none;
        background: transparent;
    }

    .main-tab.active {
        background: var(--primary);
        color: #fff;
    }

    .main-tab:hover:not(.active) {
        background: var(--bg);
        color: var(--primary);
    }

    /* BAYAR CARD */
    .bayar-card {
        background: var(--card-bg);
        border: 1.5px solid var(--border);
        border-radius: 14px;
        margin-bottom: 16px;
        overflow: hidden;
        transition: box-shadow .2s;
    }

    .bayar-card:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, .07);
    }

    .bayar-card.new {
        border-color: var(--primary);
    }

    .bc-header {
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 6px;
        border-bottom: 1px solid var(--border);
        background: #f8faff;
    }

    .bc-id {
        font-size: 11.5px;
        font-weight: 700;
        color: var(--muted);
    }

    .bc-body {
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        flex-wrap: wrap;
    }

    .bc-av {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 17px;
        color: #fff;
        flex-shrink: 0;
    }

    .bc-info {
        flex: 1;
        min-width: 180px;
    }

    .bc-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }

    .bc-sub {
        font-size: 12px;
        color: var(--muted);
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .bc-amount {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary);
        flex-shrink: 0;
    }

    .bukti-thumb {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 1.5px solid var(--border);
        cursor: pointer;
        transition: all .2s;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .bukti-thumb:hover {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    .bc-actions {
        padding: 12px 18px;
        background: var(--bg);
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-aksi {
        border: none;
        border-radius: 10px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        flex: 1;
    }

    /* TABLE */
    .tbl {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl thead th {
        padding: 10px 14px;
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        background: var(--bg);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .tbl tbody td {
        padding: 12px 14px;
        font-size: 13px;
        color: var(--text);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .tbl tbody tr:last-child td {
        border-bottom: none;
    }

    .tbl tbody tr:hover td {
        background: #f8faff;
    }

    /* MODAL */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .55);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 460px;
        max-height: 92vh;
        overflow-y: auto;
        animation: fadeUp .25s ease;
    }

    @keyframes fadeUp {
        from {
            transform: translateY(20px);
            opacity: 0
        }

        to {
            transform: translateY(0);
            opacity: 1
        }
    }

    .modal-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-head h5 {
        font-size: 15px;
        font-weight: 800;
        color: var(--text);
    }

    .modal-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: var(--bg);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: var(--muted);
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
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 13.5px;
        color: var(--text);
        outline: none;
        transition: border .2s;
        background: #fff;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
    }

    .card-box {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
    }

    .card-box-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    .card-box-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }

    .card-box-title i {
        color: var(--primary);
        margin-right: 6px;
    }

    /* LIGHTBOX */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .92);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }

    .lightbox.show {
        display: flex;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 88vh;
        border-radius: 12px;
        object-fit: contain;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .5);
    }

    @media(max-width:767px) {
        .bc-body {
            flex-direction: column;
        }

        .bc-actions {
            flex-direction: column;
        }

        .btn-aksi {
            width: 100%;
        }

        .main-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .main-tab {
            min-width: 120px;
            flex: none;
            font-size: 12px;
        }

        .tbl {
            font-size: 11px;
        }

        .tbl td,
        .tbl th {
            padding: 8px 10px !important;
        }
    }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">💰 Pembayaran</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Konfirmasi bukti pembayaran dari siswa</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-val">{{ $stats['menunggu'] }}</div>
                <div class="stat-label">Menunggu Konfirmasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-val">{{ $stats['total_dikonfirmasi'] }}</div>
                <div class="stat-label">Dikonfirmasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-cash-coin"></i></div>
            <div>
                <div class="stat-val">
                    Rp {{ $stats['penghasilan_bulan'] >= 1000000 ? round($stats['penghasilan_bulan']/1000000,1).'jt' : round($stats['penghasilan_bulan']/1000).'rb' }}
                </div>
                <div class="stat-label">Penghasilan Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <div class="stat-val">{{ $stats['total_ditolak'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
    </div>
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'menunggu')">
        <i class="bi bi-hourglass-split me-1"></i> Menunggu
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">2</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat
    </button>
</div>

{{-- ══ TAB MENUNGGU ══ --}}
<div id="tab-menunggu">

    @forelse($menunggu as $m)
    <div class="bayar-card new">
        <div class="bc-header">
            <span class="bc-id">#{{ $m->nomor_invoice }}</span>
            <span style="background:var(--accent-soft);color:var(--warning);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                <i class="bi bi-hourglass-split me-1"></i>Menunggu · {{ $m->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="bc-body">
            <div class="bc-av" style="background:var(--primary);">
                {{ strtoupper(substr($m->siswa->name ?? 'S', 0, 2)) }}
            </div>
            <div class="bc-info">
                <div class="bc-name">{{ $m->siswa->name ?? '-' }}</div>
                <div class="bc-sub"><i class="bi bi-envelope"></i>{{ $m->siswa->email ?? '-' }}</div>
                <div class="bc-sub" style="margin-top:6px;">
                    <i class="bi bi-book-fill"></i>
                    <strong>{{ $m->lesPrivat?->mata_pelajaran }}{{ $m->lesPrivat?->topik ? ' – '.$m->lesPrivat->topik : '' }}</strong>
                </div>
                <div class="bc-sub">
                    <i class="bi bi-calendar3"></i>
                    {{ $m->lesPrivat?->jadwal?->translatedFormat('l, d M Y · H:i') }} WIB
                    · {{ $m->lesPrivat?->durasi_menit }} mnt
                    · {{ $m->lesPrivat?->getModeLabel() }}
                </div>
                <div class="bc-sub"><i class="bi bi-bank"></i>Transfer ke {{ $m->bank_tujuan }} ({{ $m->nomor_rekening_tujuan }})</div>
                <div style="font-size:18px;font-weight:800;color:var(--primary);margin-top:8px;">
                    Rp {{ number_format($m->jumlah, 0, ',', '.') }}
                </div>
            </div>

            {{-- Bukti Transfer --}}
            @if($m->bukti_transfer)
            <div>
                <div style="font-size:11px;color:var(--muted);margin-bottom:4px;font-weight:600;">Bukti Transfer:</div>
                <img src="{{ $m->bukti_url }}" class="bukti-thumb" onclick="openLightbox('{{ $m->bukti_url }}')" alt="Bukti" />
                <div style="font-size:10.5px;color:var(--primary);margin-top:4px;cursor:pointer;font-weight:600;" onclick="openLightbox('{{ $m->bukti_url }}')">
                    <i class="bi bi-zoom-in me-1"></i>Perbesar
                </div>
            </div>
            @endif
        </div>
        <div class="bc-actions">
            <form method="POST" action="/tutor/pembayaran/{{ $m->id }}/tolak" style="flex:1;"
                onsubmit="return handleTolak(event, this)">
                @csrf
                <input type="hidden" name="catatan" id="catatan-{{ $m->id }}" value="">
                <button type="submit" class="btn-aksi w-100" style="background:var(--danger-soft);color:var(--danger);"
                    onclick="openModalTolak('{{ $m->id }}'); return false;">
                    <i class="bi bi-x-circle me-1"></i> Tolak
                </button>
            </form>
            <form method="POST" action="/tutor/pembayaran/{{ $m->id }}/konfirmasi" style="flex:2;">
                @csrf
                <button type="submit" class="btn-aksi w-100"
                    style="background:var(--primary);color:#fff;box-shadow:0 3px 10px rgba(30,58,95,.25);"
                    onclick="return confirm('Konfirmasi pembayaran dari {{ $m->siswa->name }}?')">
                    <i class="bi bi-check-circle-fill me-1"></i> Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
        <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;"></i>
        Tidak ada pembayaran yang menunggu konfirmasi.
    </div>
    @endforelse

</div>

{{-- ══ TAB RIWAYAT ══ --}}
<div id="tab-riwayat" style="display:none;">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-clock-history"></i> Riwayat Pembayaran</div>
            <span style="font-size:12px;color:var(--muted);">15 transaksi</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Layanan</th>
                        <th>Bank</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Konfirmasi</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:30px;height:30px;border-radius:50%;background:{{ $r->status==='dikonfirmasi'?'var(--success)':'var(--muted)' }};color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                                    {{ substr($r->siswa->name ?? 'S', 0, 1) }}
                                </div>
                                <span style="font-weight:600;">{{ $r->siswa->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:12.5px;">{{ $r->lesPrivat?->mata_pelajaran }}</div>
                            @if($r->lesPrivat?->topik)
                            <div style="font-size:11px;color:var(--muted);">– {{ $r->lesPrivat->topik }}</div>
                            @endif
                        </td>
                        <td style="font-size:12.5px;">{{ $r->bank_tujuan }}</td>
                        <td style="font-weight:700;">Rp {{ number_format($r->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if($r->status === 'dikonfirmasi')
                            <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;">
                                <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Dikonfirmasi
                            </span>
                            @else
                            <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                ❌ Ditolak
                            </span>
                            @endif
                        </td>
                        <td style="font-size:12px;color:var(--muted);">
                            {{ $r->dikonfirmasi_at ? $r->dikonfirmasi_at->format('d M Y · H:i') : $r->updated_at->format('d M Y · H:i') }}
                        </td>
                        <td>
                            @if($r->bukti_transfer)
                            <button onclick="openLightbox('{{ $r->bukti_url }}')"
                                style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:4px 10px;font-size:11.5px;font-weight:600;cursor:pointer;">
                                <i class="bi bi-image me-1"></i>Lihat
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">Belum ada riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-top:1px solid var(--border);">
            <span style="font-size:12.5px;color:var(--muted);">Menampilkan 1–6 dari 15 transaksi</span>
            <div class="d-flex gap-1">
                @foreach(['<i class="bi bi-chevron-left"></i>','1','2','3','<i class="bi bi-chevron-right"></i>'] as $pg)
                <button style="border-radius:8px;{{ $pg==='1' ? 'background:var(--primary);color:#fff;border:none;' : 'background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);' }}font-size:12px;font-weight:700;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;">{!! $pg !!}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL TOLAK ══ --}}
<div class="modal-overlay" id="modal-tolak">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-x-circle-fill me-2" style="color:var(--danger);"></i>Tolak Pembayaran</h5>
            <button class="modal-close-btn" onclick="closeModal('modal-tolak')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            <div style="background:var(--danger-soft);border-radius:10px;padding:12px 14px;margin-bottom:16px;font-size:13px;color:var(--danger);">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Pembayaran akan ditolak dan siswa akan diminta mengirim ulang bukti transfer.
            </div>
            <div class="mb-3">
                <label class="form-label-custom">ID Pembayaran</label>
                <div id="tolak-id" style="font-size:13px;font-weight:700;color:var(--primary);padding:8px 14px;background:var(--bg);border-radius:8px;">#PAY-0052</div>
            </div>
            <div class="mb-3">
                <label class="form-label-custom">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea class="form-control-custom" rows="3"
                    placeholder="Contoh: Foto bukti tidak jelas, nominal tidak sesuai, nama pengirim tidak cocok…"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn fw-bold flex-fill py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
                    onclick="closeModal('modal-tolak')">Batal</button>
                <button type="button" class="btn fw-bold flex-fill py-2"
                    onclick="tolakPembayaran()"
                    style="background:var(--danger);color:#fff;border-radius:10px;border:none;font-size:13px;">
                    <i class="bi bi-x-circle me-1"></i> Ya, Tolak
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL SUKSES KONFIRMASI ══ --}}
<div class="modal-overlay" id="modal-sukses">
    <div class="modal-box" style="max-width:420px;">
        <div style="padding:32px 28px;text-align:center;">
            <div style="font-size:60px;margin-bottom:14px;">✅</div>
            <div style="font-size:20px;font-weight:800;color:var(--text);margin-bottom:6px;">Pembayaran Dikonfirmasi!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.6;" id="sukses-pesan">
                Pembayaran dari siswa berhasil dikonfirmasi. Status les privat otomatis menjadi <strong>Lunas</strong>.
            </div>
            <div style="background:var(--success-soft);border-radius:12px;padding:14px;margin-bottom:20px;text-align:left;">
                <div style="font-size:12px;color:var(--success);font-weight:700;">
                    <i class="bi bi-check-circle-fill me-1"></i> Siswa akan mendapat notifikasi konfirmasi
                </div>
            </div>
            <button onclick="closeModal('modal-sukses')" class="btn fw-bold w-100 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                OK, Mengerti
            </button>
        </div>
    </div>
</div>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <div style="text-align:center;">
        <div style="background:#1e293b;border-radius:16px;padding:40px 60px;margin-bottom:12px;">
            <i class="bi bi-image" style="font-size:4rem;color:#64748b;display:block;margin-bottom:10px;"></i>
            <div style="color:#94a3b8;font-size:14px;">Preview Bukti Transfer</div>
            <div style="color:#64748b;font-size:12px;margin-top:4px;">(Gambar akan tampil setelah backend terhubung)</div>
        </div>
        <div style="color:#fff;font-size:13px;opacity:.7;">Klik di mana saja untuk menutup</div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(el, id) {
        document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('tab-menunggu').style.display = id === 'menunggu' ? '' : 'none';
        document.getElementById('tab-riwayat').style.display = id === 'riwayat' ? '' : 'none';
    }

    let currentTolakId = '';

    function openModalTolak(id) {
        currentTolakId = id;
        document.getElementById('tolak-id').textContent = '#' + id;
        document.getElementById('modal-tolak').classList.add('show');
    }

    function tolakPembayaran() {
        const catatan = document.querySelector('#modal-tolak textarea').value;
        if (!catatan.trim()) {
            alert('Isi alasan penolakan!');
            return;
        }

        document.getElementById('catatan-' + currentTolakId).value = catatan;
        closeModal('modal-tolak');

        // Submit form tolak
        const forms = document.querySelectorAll('form[action*="/tolak"]');
        forms.forEach(f => {
            if (f.action.includes(currentTolakId)) f.submit();
        });
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openLightbox(url) {
        const lb = document.getElementById('lightbox');
        lb.classList.add('show');
        document.body.style.overflow = 'hidden';
        // Tampilkan gambar real
        lb.innerHTML = `
        <div style="text-align:center;">
            <img src="${url}" style="max-width:90%;max-height:88vh;border-radius:12px;object-fit:contain;box-shadow:0 20px 60px rgba(0,0,0,.5);" onclick="event.stopPropagation()"/>
            <div style="color:#fff;font-size:13px;opacity:.7;margin-top:10px;">Klik di luar gambar untuk menutup</div>
        </div>`;
        lb.onclick = closeLightbox;
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('show');
        document.body.style.overflow = '';
    }
</script>
@endpush