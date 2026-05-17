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
    <form method="POST" action="/tutor/notifikasi/tandai-semua">
        @csrf
        <button type="submit" class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--bg);color:var(--primary);border-radius:10px;border:1.5px solid var(--primary);font-size:12px;">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </form>
</div>

{{-- ALERT --}}
@if(session('sukses'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
    <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:18px;"></i>
    <span style="font-size:13px;font-weight:600;color:var(--success);">{{ session('sukses') }}</span>
</div>
@endif

{{-- FILTER TABS --}}
<div class="filter-tabs">
    <div class="filter-tab active" onclick="filterNotif(this,'semua')">
        Semua
        @if($jumlahBelumDibaca > 0)
        <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">{{ $jumlahBelumDibaca }}</span>
        @endif
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'belum')">Belum Dibaca</div>
    <div class="filter-tab" onclick="filterNotif(this,'les_privat')">
        Les Privat
        @if($perTipe['les_privat'] > 0)
        <span style="background:var(--primary);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">{{ $perTipe['les_privat'] }}</span>
        @endif
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'pembayaran')">
        Pembayaran
        @if($perTipe['pembayaran'] > 0)
        <span style="background:var(--success);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">{{ $perTipe['pembayaran'] }}</span>
        @endif
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'sistem')">Sistem</div>
</div>

@php
$ikonMap = [
'les_privat' => ['bi-person-plus-fill', 'var(--danger-soft)', 'var(--danger)'],
'pembayaran' => ['bi-cash-coin', 'var(--success-soft)', 'var(--success)'],
'sistem' => ['bi-gear-fill', '#eff6ff', 'var(--primary)'],
'ulasan' => ['bi-star-fill', 'var(--accent-soft)', 'var(--warning)'],
'jadwal' => ['bi-calendar-x-fill', 'var(--info-soft)', 'var(--info)'],
];
@endphp

@if($notifikasi->count() === 0)

{{-- KOSONG --}}
<div style="text-align:center;padding:60px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
    <i class="bi bi-bell-slash" style="font-size:2.5rem;display:block;margin-bottom:10px;"></i>
    <div style="font-size:15px;font-weight:700;">Tidak Ada Notifikasi</div>
    <div style="font-size:13px;margin-top:4px;">Semua notifikasi akan muncul di sini.</div>
</div>

@else

{{-- HARI INI --}}
@if($hariIni->count() > 0)
<div class="grup-label">Hari Ini</div>
<div class="card-box mb-3">
    @foreach($hariIni as $n)
    @php $ikon = $ikonMap[$n->tipe] ?? ['bi-bell-fill','#eff6ff','var(--primary)']; @endphp
    <div class="notif-item {{ !$n->sudah_dibaca ? 'unread' : '' }}" data-tipe="{{ $n->tipe }}" data-dibaca="{{ $n->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $ikon[1] }};color:{{ $ikon[2] }};"><i class="bi {{ $n->ikon ?: $ikon[0] }}"></i></div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{{ $n->pesan }}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i>{{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if(!$n->sudah_dibaca)<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <form method="POST" action="/tutor/notifikasi/{{ $n->id }}/buka">
                @csrf
                <button type="submit" class="btn-notif" style="background:var(--primary);color:#fff;">{{ $n->label_aksi }}</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- KEMARIN --}}
@if($kemarin->count() > 0)
<div class="grup-label">Kemarin</div>
<div class="card-box mb-3">
    @foreach($kemarin as $n)
    @php $ikon = $ikonMap[$n->tipe] ?? ['bi-bell-fill','#eff6ff','var(--primary)']; @endphp
    <div class="notif-item {{ !$n->sudah_dibaca ? 'unread' : '' }}" data-tipe="{{ $n->tipe }}" data-dibaca="{{ $n->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $ikon[1] }};color:{{ $ikon[2] }};"><i class="bi {{ $n->ikon ?: $ikon[0] }}"></i></div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{{ $n->pesan }}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i>{{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if(!$n->sudah_dibaca)<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <form method="POST" action="/tutor/notifikasi/{{ $n->id }}/buka">
                @csrf
                <button type="submit" class="btn-notif" style="background:var(--primary);color:#fff;">{{ $n->label_aksi }}</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- MINGGU INI --}}
@if($mingguIni->count() > 0)
<div class="grup-label">Minggu Ini</div>
<div class="card-box mb-3">
    @foreach($mingguIni as $n)
    @php $ikon = $ikonMap[$n->tipe] ?? ['bi-bell-fill','#eff6ff','var(--primary)']; @endphp
    <div class="notif-item {{ !$n->sudah_dibaca ? 'unread' : '' }}" data-tipe="{{ $n->tipe }}" data-dibaca="{{ $n->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $ikon[1] }};color:{{ $ikon[2] }};"><i class="bi {{ $n->ikon ?: $ikon[0] }}"></i></div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{{ $n->pesan }}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i>{{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if(!$n->sudah_dibaca)<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <form method="POST" action="/tutor/notifikasi/{{ $n->id }}/buka">
                @csrf
                <button type="submit" class="btn-notif" style="background:var(--primary);color:#fff;">{{ $n->label_aksi }}</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- LEBIH LAMA --}}
@if($lebihLama->count() > 0)
<div class="grup-label">Lebih Lama</div>
<div class="card-box mb-3">
    @foreach($lebihLama as $n)
    @php $ikon = $ikonMap[$n->tipe] ?? ['bi-bell-fill','#eff6ff','var(--primary)']; @endphp
    <div class="notif-item {{ !$n->sudah_dibaca ? 'unread' : '' }}" data-tipe="{{ $n->tipe }}" data-dibaca="{{ $n->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $ikon[1] }};color:{{ $ikon[2] }};"><i class="bi {{ $n->ikon ?: $ikon[0] }}"></i></div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{{ $n->pesan }}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i>{{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if(!$n->sudah_dibaca)<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <form method="POST" action="/tutor/notifikasi/{{ $n->id }}/buka">
                @csrf
                <button type="submit" class="btn-notif" style="background:var(--primary);color:#fff;">{{ $n->label_aksi }}</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

@endif

@endsection

@push('scripts')
<script>
    function filterNotif(el, tipe) {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');

        document.querySelectorAll('.notif-item').forEach(item => {
            if (tipe === 'semua') {
                item.style.display = '';
            } else if (tipe === 'belum') {
                item.style.display = item.dataset.dibaca === '0' ? '' : 'none';
            } else {
                item.style.display = item.dataset.tipe === tipe ? '' : 'none';
            }
        });
    }
</script>
@endpush