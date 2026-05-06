@extends('layouts.app')

@section('title', 'Les Privat - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Les Privat')
@section('page-sub', 'Dashboard / Les Privat')

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
        @if($menunggu->count() > 0)
        <span class="nav-badge">{{ $menunggu->count() }}</span>
        @endif
    </a>
    <div class="menu-label">Akun</div>
    <a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
<style>
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .stat-val{font-size:1.5rem;font-weight:800;line-height:1;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}
    .main-tabs{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .main-tab{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .main-tab.active{background:var(--primary);color:#fff;}
    .main-tab:hover:not(.active){background:var(--bg);color:var(--primary);}
    .request-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:14px;padding:18px 20px;margin-bottom:12px;transition:box-shadow .2s;}
    .request-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.07);}
    .request-card.new-req{border-color:var(--primary);background:#f8faff;}
    .rc-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
    .rc-id{font-size:11.5px;font-weight:700;color:var(--muted);}
    .rc-body{display:flex;align-items:center;gap:12px;}
    .rc-av{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;color:#fff;flex-shrink:0;}
    .rc-name{font-size:13.5px;font-weight:700;color:var(--text);}
    .rc-sub{font-size:12px;color:var(--muted);margin-top:2px;}
    .rc-actions{display:flex;gap:8px;margin-top:12px;}
    .btn-rc{border:none;border-radius:8px;padding:8px 18px;font-size:12.5px;font-weight:700;cursor:pointer;flex:1;transition:all .2s;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{padding:10px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;background:var(--bg);border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:12px 14px;font-size:13px;color:var(--text);border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#f8faff;}
    .card-box{background:var(--card-bg);border-radius:16px;border:1px solid var(--border);}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:.95rem;font-weight:700;color:var(--text);}
    .card-box-title i{color:var(--primary);margin-right:6px;}
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
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">🎓 Les Privat</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Les Privat</span>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--danger-soft);color:var(--danger);"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-val">{{ $stats['menunggu'] }}</div>
                <div class="stat-label">Menunggu Respons</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
                <div class="stat-val">{{ $stats['bulan_ini'] }}</div>
                <div class="stat-label">Sesi Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:var(--primary);"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-val">{{ $stats['total_siswa'] }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-cash-coin"></i></div>
            <div>
                <div class="stat-val">Rp {{ number_format($stats['penghasilan'] / 1000, 0) }}rb</div>
                <div class="stat-label">Penghasilan Bulan Ini</div>
            </div>
        </div>
    </div>
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'menunggu')">
        <i class="bi bi-hourglass-split me-1"></i> Menunggu
        @if($menunggu->count() > 0)
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 6px;border-radius:20px;margin-left:4px;">{{ $menunggu->count() }}</span>
        @endif
    </button>
    <button class="main-tab" onclick="switchTab(this,'dikonfirmasi')">
        <i class="bi bi-check-circle me-1"></i> Dikonfirmasi
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat
    </button>
</div>

{{-- ══ TAB: MENUNGGU ══ --}}
<div id="tab-menunggu">
    @forelse($menunggu as $m)
    <div class="request-card new-req">
        <div class="rc-header">
            <span class="rc-id">#{{ strtoupper(substr($m->id, 0, 8)) }}</span>
            <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                <i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Baru · {{ $m->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="rc-body">
            <div class="rc-av" style="background:var(--primary);">
                {{ strtoupper(substr($m->siswa->name ?? 'S', 0, 2)) }}
            </div>
            <div style="flex:1;">
                <div class="rc-name">{{ $m->siswa->name ?? '-' }}</div>
                <div class="rc-sub">
                    <i class="bi bi-book-fill me-1"></i>
                    {{ $m->mata_pelajaran }}{{ $m->topik ? ' – '.$m->topik : '' }}
                </div>
                <div class="rc-sub mt-1">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $m->jadwal->translatedFormat('l, d M Y · H:i') }} WIB
                    · {{ $m->durasi_menit }} mnt
                    &nbsp;·&nbsp;
                    <span style="background:{{ $m->mode === 'online' ? 'var(--success-soft)' : 'var(--info-soft)' }};color:{{ $m->mode === 'online' ? 'var(--success)' : 'var(--info)' }};font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">
                        {{ $m->getModeLabel() }}
                    </span>
                </div>
                @if($m->catatan)
                <div class="rc-sub mt-1" style="background:var(--bg);border-radius:8px;padding:6px 10px;">
                    <i class="bi bi-chat-text me-1"></i> {{ $m->catatan }}
                </div>
                @endif
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-size:16px;font-weight:800;color:var(--primary);">Rp {{ number_format($m->harga, 0, ',', '.') }}</div>
                <div style="font-size:11px;color:var(--muted);">{{ $m->durasi_menit }} menit</div>
            </div>
        </div>
        <div class="rc-actions">
            <form method="POST" action="/tutor/les-privat/{{ $m->id }}/tolak"
                onsubmit="return confirm('Tolak pesanan dari {{ $m->siswa->name ?? 'siswa' }}?')">
                @csrf
                <button type="submit" class="btn-rc" style="background:var(--danger-soft);color:var(--danger);">
                    <i class="bi bi-x-circle me-1"></i> Tolak
                </button>
            </form>
            <form method="POST" action="/tutor/les-privat/{{ $m->id }}/terima" style="flex:2;">
                @csrf
                <button type="submit" class="btn-rc w-100" style="background:var(--primary);color:#fff;box-shadow:0 3px 10px rgba(30,58,95,.25);">
                    <i class="bi bi-check-circle-fill me-1"></i> Terima & Konfirmasi
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
        <i class="bi bi-inbox" style="font-size:2.5rem;margin-bottom:10px;display:block;"></i>
        Tidak ada pesanan yang menunggu konfirmasi.
    </div>
    @endforelse
</div>

{{-- ══ TAB: DIKONFIRMASI ══ --}}
<div id="tab-dikonfirmasi" style="display:none;">
    @forelse($dikonfirmasi as $d)
    <div class="request-card">
        <div class="rc-header">
            <span class="rc-id">#{{ strtoupper(substr($d->id, 0, 8)) }}</span>
            <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                <i class="bi bi-check-circle-fill"></i> Dikonfirmasi
            </span>
        </div>
        <div class="rc-body">
            <div class="rc-av" style="background:var(--success);">
                {{ strtoupper(substr($d->siswa->name ?? 'S', 0, 2)) }}
            </div>
            <div style="flex:1;">
                <div class="rc-name">{{ $d->siswa->name ?? '-' }}</div>
                <div class="rc-sub">
                    <i class="bi bi-book-fill me-1"></i>
                    {{ $d->mata_pelajaran }}{{ $d->topik ? ' – '.$d->topik : '' }}
                </div>
                <div class="rc-sub mt-1">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $d->jadwal->translatedFormat('l, d M Y · H:i') }} WIB
                    · {{ $d->durasi_menit }} mnt
                    @if($d->mode === 'online' && $d->link_meeting)
                    &nbsp;·&nbsp;
                    <a href="{{ $d->link_meeting }}" target="_blank" style="color:var(--primary);font-weight:600;font-size:11.5px;">
                        <i class="bi bi-camera-video-fill me-1"></i>Link Meeting
                    </a>
                    @endif
                </div>
                @if($d->mode === 'tatap_muka' && $d->lokasi)
                <div class="rc-sub mt-1">
                    <i class="bi bi-geo-alt-fill me-1"></i>{{ $d->lokasi }}
                </div>
                @endif
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-size:16px;font-weight:800;color:var(--primary);">Rp {{ number_format($d->harga, 0, ',', '.') }}</div>
                <div style="font-size:11px;color:{{ $d->pembayaran_status === 'lunas' ? 'var(--success)' : 'var(--warning)' }};">
                    {{ $d->pembayaran_status === 'lunas' ? '✅ Lunas' : '⏳ Belum Bayar' }}
                </div>
            </div>
        </div>
        <div class="rc-actions">
            <form method="POST" action="/tutor/les-privat/{{ $d->id }}/selesai"
                onsubmit="return confirm('Tandai sesi ini sebagai selesai?')">
                @csrf
                <button type="submit" class="btn-rc w-100" style="background:var(--success);color:#fff;">
                    <i class="bi bi-check2-all me-1"></i> Tandai Selesai
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
        <i class="bi bi-calendar-check" style="font-size:2.5rem;margin-bottom:10px;display:block;"></i>
        Tidak ada sesi yang sedang dikonfirmasi.
    </div>
    @endforelse
</div>

{{-- ══ TAB: RIWAYAT ══ --}}
<div id="tab-riwayat" style="display:none;">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-clock-history"></i> Riwayat Semua Sesi</div>
            <span style="font-size:12px;color:var(--muted);">{{ $riwayat->count() }} sesi</span>
        </div>
        @if($riwayat->count() > 0)
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Jadwal</th>
                        <th>Durasi</th>
                        <th>Mode</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($riwayat as $r)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:30px;height:30px;border-radius:50%;background:{{ $r->status === 'selesai' ? 'var(--success)' : 'var(--muted)' }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">
                                {{ strtoupper(substr($r->siswa->name ?? 'S', 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $r->siswa->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <span style="background:#eff6ff;color:var(--primary);font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">{{ $r->mata_pelajaran }}</span>
                        @if($r->topik)
                        <div style="font-size:11px;color:var(--muted);">{{ $r->topik }}</div>
                        @endif
                    </td>
                    <td style="font-size:12.5px;color:var(--muted);">{{ $r->jadwal->format('d M Y · H:i') }} WIB</td>
                    <td style="font-size:12.5px;">{{ $r->durasi_menit }} mnt</td>
                    <td>
                        <span style="background:{{ $r->mode === 'online' ? 'var(--success-soft)' : 'var(--info-soft)' }};color:{{ $r->mode === 'online' ? 'var(--success)' : 'var(--info)' }};font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">
                            {{ $r->getModeLabel() }}
                        </span>
                    </td>
                    <td style="font-weight:700;">Rp {{ number_format($r->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($r->status === 'selesai')
                        <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Selesai</span>
                        @else
                        <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">Dibatalkan</span>
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
            Belum ada riwayat sesi.
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(el, id) {
        document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        ['menunggu','dikonfirmasi','riwayat'].forEach(t => {
            document.getElementById('tab-'+t).style.display = t === id ? '' : 'none';
        });
    }
</script>
@endpush