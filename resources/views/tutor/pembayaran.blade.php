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
        @if($menunggu->count() > 0)
        <span class="nav-badge">{{ $menunggu->count() }}</span>
        @endif
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
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .stat-val{font-size:1.5rem;font-weight:800;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}
    .main-tabs{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .main-tab{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .main-tab.active{background:var(--primary);color:#fff;}
    .main-tab:hover:not(.active){background:var(--bg);color:var(--primary);}
    .bayar-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:14px;margin-bottom:14px;overflow:hidden;transition:box-shadow .2s;}
    .bayar-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.07);}
    .bayar-card.urgent{border-color:var(--primary);}
    .bc-header{padding:12px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);background:#f8faff;}
    .bc-id{font-size:11.5px;font-weight:700;color:var(--muted);}
    .bc-body{padding:16px 18px;}
    .bc-row{display:flex;align-items:flex-start;gap:14px;flex-wrap:wrap;}
    .bc-av{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;color:#fff;flex-shrink:0;}
    .bc-info{flex:1;min-width:160px;}
    .bc-name{font-size:14px;font-weight:700;color:var(--text);}
    .bc-sub{font-size:12px;color:var(--muted);margin-top:3px;}
    .bc-actions{padding:12px 18px;background:var(--bg);border-top:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
    .btn-konfirm{border:none;border-radius:10px;padding:9px 20px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;}
    .bukti-img{width:80px;height:60px;border-radius:8px;object-fit:cover;border:1.5px solid var(--border);cursor:pointer;transition:all .2s;flex-shrink:0;}
    .bukti-img:hover{border-color:var(--primary);transform:scale(1.05);}
    .card-box{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;}
    .card-box-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:14px;font-weight:700;color:var(--text);}
    .card-box-title i{color:var(--primary);margin-right:6px;}
    /* MODAL */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:90%;max-width:460px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0;}to{transform:translateY(0);opacity:1;}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-head h5{font-size:15px;font-weight:800;color:var(--text);}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .form-label-custom{font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;display:block;}
    .form-control-custom{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;color:var(--text);outline:none;transition:border .2s;background:#fff;}
    .form-control-custom:focus{border-color:var(--primary);}
    /* LIGHTBOX */
    .lightbox{display:none;position:fixed;inset:0;background:rgba(0,0,0,.9);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;}
    .lightbox.show{display:flex;}
    .lightbox img{max-width:90%;max-height:90vh;border-radius:12px;object-fit:contain;}
    @media(max-width:767px){
        .bc-row{flex-direction:column;}
        .bc-actions{flex-direction:column;align-items:flex-start;}
        .btn-konfirm{width:100%;}
        .main-tabs{overflow-x:auto;flex-wrap:nowrap;}
        .main-tab{min-width:110px;flex:none;font-size:12px;}
    }
</style>
@endpush

@section('content')

{{-- ALERT --}}
@if(session('sukses'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
    <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:18px;"></i>
    <span style="font-size:13px;font-weight:600;color:var(--success);">{{ session('sukses') }}</span>
</div>
@endif

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">💰 Pembayaran</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Pembayaran</span>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $totalKonfirmasi = $riwayat->where('status','dikonfirmasi')->sum('jumlah');
    @endphp
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-val">{{ $menunggu->count() }}</div>
                <div class="stat-label">Menunggu Konfirmasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-val">{{ $riwayat->where('status','dikonfirmasi')->count() }}</div>
                <div class="stat-label">Terkonfirmasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-cash-coin"></i></div>
            <div>
                <div class="stat-val">Rp {{ number_format($totalKonfirmasi/1000,0) }}rb</div>
                <div class="stat-label">Total Terkonfirmasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <div class="stat-val">{{ $riwayat->where('status','ditolak')->count() }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
    </div>
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'menunggu')">
        <i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi
        @if($menunggu->count() > 0)
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">{{ $menunggu->count() }}</span>
        @endif
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat
    </button>
</div>

{{-- ══ TAB MENUNGGU ══ --}}
<div id="tab-menunggu">
    @forelse($menunggu as $m)
    <div class="bayar-card urgent">
        <div class="bc-header">
            <span class="bc-id">#PAY-{{ strtoupper(substr($m->id,0,8)) }}</span>
            <span style="background:var(--accent-soft);color:var(--warning);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                <i class="bi bi-hourglass-split"></i> Menunggu · {{ $m->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="bc-body">
            <div class="bc-row">
                <div class="bc-av" style="background:var(--primary);">
                    {{ strtoupper(substr($m->siswa->name ?? 'S', 0, 2)) }}
                </div>
                <div class="bc-info">
                    <div class="bc-name">{{ $m->siswa->name ?? '-' }}</div>
                    <div class="bc-sub">
                        <i class="bi bi-envelope me-1"></i>{{ $m->siswa->email ?? '-' }}
                    </div>
                    <div class="bc-sub mt-1">
                        <i class="bi bi-book-fill me-1"></i>
                        Les {{ $m->lesPrivat->mata_pelajaran ?? '-' }}
                        {{ $m->lesPrivat->topik ? '– '.$m->lesPrivat->topik : '' }}
                        · {{ $m->lesPrivat->jadwal->format('d M Y H:i') ?? '' }} WIB
                    </div>
                    <div class="bc-sub mt-1">
                        <i class="bi bi-bank me-1"></i>
                        Transfer ke {{ $m->rekening->nama_bank ?? '-' }}
                        ({{ $m->rekening->nomor_rekening ?? '' }})
                    </div>
                    <div style="font-size:16px;font-weight:800;color:var(--primary);margin-top:8px;">
                        Rp {{ number_format($m->jumlah, 0, ',', '.') }}
                    </div>
                </div>

                {{-- BUKTI TRANSFER --}}
                @if($m->bukti_transfer)
                <div>
                    <div style="font-size:11px;color:var(--muted);margin-bottom:4px;">Bukti Transfer:</div>
                    <img src="{{ asset('storage/'.$m->bukti_transfer) }}"
                        class="bukti-img"
                        alt="Bukti Transfer"
                        onclick="openLightbox('{{ asset('storage/'.$m->bukti_transfer) }}')"/>
                    <div style="font-size:10.5px;color:var(--primary);margin-top:3px;cursor:pointer;"
                        onclick="openLightbox('{{ asset('storage/'.$m->bukti_transfer) }}')">
                        <i class="bi bi-zoom-in me-1"></i>Perbesar
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="bc-actions">
            {{-- TOLAK --}}
            <button onclick="openModalTolak('{{ $m->id }}')"
                class="btn-konfirm"
                style="background:var(--danger-soft);color:var(--danger);flex:1;">
                <i class="bi bi-x-circle me-1"></i> Tolak
            </button>
            {{-- KONFIRMASI --}}
            <form method="POST" action="/tutor/pembayaran/{{ $m->id }}/konfirmasi"
                onsubmit="return confirm('Konfirmasi pembayaran dari {{ $m->siswa->name ?? 'siswa' }}? Tindakan ini menandai sesi sebagai LUNAS.')"
                style="flex:2;">
                @csrf
                <button type="submit" class="btn-konfirm w-100"
                    style="background:var(--primary);color:#fff;box-shadow:0 3px 10px rgba(30,58,95,.25);">
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
        </div>
        @if($riwayat->count() > 0)
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg);">
                        @foreach(['Siswa','Layanan','Bank','Jumlah','Status','Tanggal','Bukti']) as $h)
                        <th style="padding:10px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border);white-space:nowrap;">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($riwayat as $r)
                <tr onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background=''">
                    <td style="padding:11px 14px;border-bottom:1px solid var(--border);">
                        <div style="font-weight:600;font-size:13px;">{{ $r->siswa->name ?? '-' }}</div>
                        <div style="font-size:11px;color:var(--muted);">{{ $r->siswa->email ?? '' }}</div>
                    </td>
                    <td style="padding:11px 14px;font-size:13px;border-bottom:1px solid var(--border);">
                        {{ $r->lesPrivat->mata_pelajaran ?? '-' }}
                        @if($r->lesPrivat->topik ?? false)
                        <div style="font-size:11px;color:var(--muted);">{{ $r->lesPrivat->topik }}</div>
                        @endif
                    </td>
                    <td style="padding:11px 14px;font-size:12.5px;border-bottom:1px solid var(--border);">
                        {{ $r->rekening->nama_bank ?? '-' }}
                    </td>
                    <td style="padding:11px 14px;font-size:13px;font-weight:700;border-bottom:1px solid var(--border);">
                        Rp {{ number_format($r->jumlah, 0, ',', '.') }}
                    </td>
                    <td style="padding:11px 14px;border-bottom:1px solid var(--border);">
                        @if($r->status === 'dikonfirmasi')
                        <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">✅ Lunas</span>
                        @else
                        <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">❌ Ditolak</span>
                        @endif
                    </td>
                    <td style="padding:11px 14px;font-size:12px;color:var(--muted);border-bottom:1px solid var(--border);">
                        {{ $r->created_at->format('d M Y') }}
                        @if($r->dikonfirmasi_at)
                        <div style="font-size:10.5px;color:var(--success);">Konfirmasi: {{ $r->dikonfirmasi_at->format('d M Y H:i') }}</div>
                        @endif
                    </td>
                    <td style="padding:11px 14px;border-bottom:1px solid var(--border);">
                        @if($r->bukti_transfer)
                        <img src="{{ asset('storage/'.$r->bukti_transfer) }}"
                            style="width:50px;height:38px;border-radius:6px;object-fit:cover;cursor:pointer;border:1px solid var(--border);"
                            onclick="openLightbox('{{ asset('storage/'.$r->bukti_transfer) }}')"
                            alt="Bukti"/>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align:center;padding:40px;color:var(--muted);">
            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
            Belum ada riwayat pembayaran.
        </div>
        @endif
    </div>
</div>

{{-- MODAL TOLAK --}}
<div class="modal-overlay" id="modal-tolak">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-x-circle-fill me-2" style="color:var(--danger);"></i>Tolak Pembayaran</h5>
            <button class="modal-close-btn" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            <div style="background:var(--danger-soft);border-radius:10px;padding:12px;margin-bottom:14px;font-size:13px;color:var(--danger);">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Pembayaran akan ditolak dan siswa diminta upload ulang bukti transfer.
            </div>
            <form method="POST" id="form-tolak">
                @csrf
                <div class="mb-3">
                    <label class="form-label-custom">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea name="catatan" class="form-control-custom" rows="3" required
                        placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai, dll…"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn fw-bold flex-fill py-2"
                        style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
                        onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn fw-bold flex-fill py-2"
                        style="background:var(--danger);color:#fff;border-radius:10px;border:none;font-size:13px;">
                        <i class="bi bi-x-circle me-1"></i> Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img" src="" alt="Bukti Transfer"/>
</div>

@endsection

@push('scripts')
<script>
function switchTab(el, id) {
    document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('tab-menunggu').style.display = id === 'menunggu' ? '' : 'none';
    document.getElementById('tab-riwayat').style.display  = id === 'riwayat'  ? '' : 'none';
}

function openModalTolak(id) {
    document.getElementById('form-tolak').action = '/tutor/pembayaran/' + id + '/tolak';
    document.getElementById('modal-tolak').classList.add('show');
}
function closeModal() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
}
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('show');
    document.body.style.overflow = '';
}
</script>
@endpush