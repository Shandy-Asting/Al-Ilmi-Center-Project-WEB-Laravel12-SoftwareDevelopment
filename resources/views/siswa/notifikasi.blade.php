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
    @if($jumlahBelumDibaca > 0)
    <span class="nav-badge">{{ $jumlahBelumDibaca }}</span>
    @endif
</a>
<a href="/siswa/profil" class="nav-item-custom {{ request()->is('siswa/profil') ? 'active' : '' }}">
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
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .notif-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        flex-shrink: 0;
    }

    .notif-actions {
        margin-left: auto;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
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

    .card-box-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    .card-box-title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--text);
    }

    .grup-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 8px;
    }

    @media (max-width: 767px) {
        .notif-item {
            flex-wrap: wrap;
            padding: 12px 14px;
        }

        .notif-actions {
            width: 100%;
            flex-direction: row !important;
            justify-content: space-between;
            margin-top: 8px;
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
            padding: 6px 12px;
        }

        .notif-desc {
            font-size: 12px;
        }

        .notif-icon {
            width: 36px !important;
            height: 36px !important;
            font-size: 16px !important;
        }
    }
</style>
@endpush

@php
$tipeWarna = [
'les_privat' => ['bg' => 'var(--success-soft)', 'fg' => 'var(--success)'],
'pembayaran' => ['bg' => 'var(--accent-soft)', 'fg' => 'var(--warning)'],
'belajar' => ['bg' => '#eff6ff', 'fg' => 'var(--primary)'],
'sistem' => ['bg' => 'var(--info-soft)', 'fg' => 'var(--info)'],
'ulasan' => ['bg' => 'var(--accent-soft)', 'fg' => 'var(--warning)'],
'streak' => ['bg' => 'var(--danger-soft)', 'fg' => 'var(--danger)'],
];
@endphp

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">🔔 Notifikasi</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Notifikasi</span>
        </div>
    </div>
    <form action="/siswa/notifikasi/tandai-semua" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--bg);color:var(--primary);border-radius:10px;border:1.5px solid var(--primary);font-size:12px;">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </form>
</div>

{{-- FILTER TABS --}}
<div class="filter-tabs">
    <div class="filter-tab active" data-filter="semua">
        Semua
        @if($jumlahBelumDibaca > 0)
        <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">
            {{ $jumlahBelumDibaca }}
        </span>
        @endif
    </div>
    <div class="filter-tab" data-filter="belum">Belum Dibaca</div>
    @if($user->notif_pengingat_sesi)
    <div class="filter-tab" data-filter="les_privat">Les Privat</div>
    @endif
    @if($user->notif_pembayaran)
    <div class="filter-tab" data-filter="pembayaran">Pembayaran</div>
    @endif
    @if($user->notif_ulasan)
    <div class="filter-tab" data-filter="belajar">Belajar</div>
    @endif
    @if($user->notif_permintaan_jadwal)
    <div class="filter-tab" data-filter="sistem">Sistem</div>
    @endif
</div>

{{-- KOSONG --}}
@if($hariIni->isEmpty() && $kemarin->isEmpty() && $mingguIni->isEmpty() && $lebihLama->isEmpty())
<div class="text-center py-5" style="color:var(--muted);">
    <i class="bi bi-bell-slash" style="font-size:2.5rem;"></i>
    <p class="mt-3 fw-semibold">Tidak ada notifikasi</p>
</div>
@else

{{-- MACRO NOTIF ITEM --}}
@php
$renderNotif = function($notif) use ($tipeWarna) {
$w = $tipeWarna[$notif->tipe ?? 'sistem'] ?? ['bg' => '#eff6ff', 'fg' => 'var(--primary)'];
$bg = $notif->warna ?? $w['bg'];
$fg = $w['fg'];
return compact('bg', 'fg');
};
@endphp

{{-- HARI INI --}}
@if($hariIni->isNotEmpty())
<div class="grup-label">Hari Ini</div>
<div class="card-box mb-3">
    @foreach($hariIni as $notif)
    @php $w = $renderNotif($notif); @endphp
    <div class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}"
        data-tipe="{{ $notif->tipe }}"
        data-baca="{{ $notif->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
            <i class="bi {{ $notif->ikon ?? 'bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $notif->judul }}</div>
            <div class="notif-desc">{!! $notif->pesan !!}</div>
            <div class="notif-time">
                <i class="bi bi-clock me-1"></i> {{ $notif->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="notif-actions">
            @if(!$notif->sudah_dibaca)
            <div class="notif-dot"></div>
            @endif
            @if($notif->url_aksi && $notif->label_aksi)
            <form action="/siswa/notifikasi/{{ $notif->id }}/buka" method="POST">
                @csrf
                <button type="submit" class="btn-notif"
                    style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
                    {{ $notif->label_aksi }}
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- KEMARIN --}}
@if($kemarin->isNotEmpty())
<div class="grup-label">Kemarin</div>
<div class="card-box mb-3">
    @foreach($kemarin as $notif)
    @php $w = $renderNotif($notif); @endphp
    <div class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}"
        data-tipe="{{ $notif->tipe }}"
        data-baca="{{ $notif->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
            <i class="bi {{ $notif->ikon ?? 'bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $notif->judul }}</div>
            <div class="notif-desc">{!! $notif->pesan !!}</div>
            <div class="notif-time">
                <i class="bi bi-clock me-1"></i> {{ $notif->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="notif-actions">
            @if(!$notif->sudah_dibaca)
            <div class="notif-dot"></div>
            @endif
            @if($notif->url_aksi && $notif->label_aksi)
            <form action="/siswa/notifikasi/{{ $notif->id }}/buka" method="POST">
                @csrf
                <button type="submit" class="btn-notif"
                    style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
                    {{ $notif->label_aksi }}
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- MINGGU INI --}}
@if($mingguIni->isNotEmpty())
<div class="grup-label">Minggu Ini</div>
<div class="card-box mb-3">
    @foreach($mingguIni as $notif)
    @php $w = $renderNotif($notif); @endphp
    <div class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}"
        data-tipe="{{ $notif->tipe }}"
        data-baca="{{ $notif->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
            <i class="bi {{ $notif->ikon ?? 'bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $notif->judul }}</div>
            <div class="notif-desc">{!! $notif->pesan !!}</div>
            <div class="notif-time">
                <i class="bi bi-clock me-1"></i> {{ $notif->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="notif-actions">
            @if(!$notif->sudah_dibaca)
            <div class="notif-dot"></div>
            @endif
            @if($notif->url_aksi && $notif->label_aksi)
            <form action="/siswa/notifikasi/{{ $notif->id }}/buka" method="POST">
                @csrf
                <button type="submit" class="btn-notif"
                    style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
                    {{ $notif->label_aksi }}
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- LEBIH LAMA --}}
@if($lebihLama->isNotEmpty())
<div class="grup-label">Lebih Lama</div>
<div class="card-box mb-4">
    @foreach($lebihLama as $notif)
    @php $w = $renderNotif($notif); @endphp
    <div class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}"
        data-tipe="{{ $notif->tipe }}"
        data-baca="{{ $notif->sudah_dibaca ? '1' : '0' }}">
        <div class="notif-icon" style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
            <i class="bi {{ $notif->ikon ?? 'bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $notif->judul }}</div>
            <div class="notif-desc">{!! $notif->pesan !!}</div>
            <div class="notif-time">
                <i class="bi bi-clock me-1"></i> {{ $notif->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="notif-actions">
            @if(!$notif->sudah_dibaca)
            <div class="notif-dot"></div>
            @endif
            @if($notif->url_aksi && $notif->label_aksi)
            <form action="/siswa/notifikasi/{{ $notif->id }}/buka" method="POST">
                @csrf
                <button type="submit" class="btn-notif"
                    style="background:{{ $w['bg'] }};color:{{ $w['fg'] }};">
                    {{ $notif->label_aksi }}
                </button>
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
    // ── Filter tab ──
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            document.querySelectorAll('.notif-item').forEach(item => {
                if (filter === 'semua') {
                    item.style.display = '';
                } else if (filter === 'belum') {
                    item.style.display = item.dataset.baca === '0' ? '' : 'none';
                } else {
                    item.style.display = item.dataset.tipe === filter ? '' : 'none';
                }
            });

            // Sembunyikan grup label jika semua item tersembunyi
            document.querySelectorAll('.card-box').forEach(box => {
                const visible = [...box.querySelectorAll('.notif-item')].some(i => i.style.display !== 'none');
                const label = box.previousElementSibling;
                box.style.display = visible ? '' : 'none';
                if (label && label.classList.contains('grup-label')) {
                    label.style.display = visible ? '' : 'none';
                }
            });
        });
    });
</script>
@endpush