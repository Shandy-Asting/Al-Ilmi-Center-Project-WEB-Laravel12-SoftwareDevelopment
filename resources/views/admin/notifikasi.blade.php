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
        <h4 class="fw-bold mb-1">🔔 Notifikasi Admin</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Pantau semua aktivitas sistem Al Ilmi Center</p>
    </div>
    <form method="POST" action="/admin/notifikasi/baca-semua">
        @csrf
        <button type="submit" style="background:var(--bg);color:var(--primary);border:1.5px solid var(--primary);border-radius:10px;font-size:12px;font-weight:700;padding:8px 14px;cursor:pointer;">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </form>
</div>

{{-- FILTER TABS --}}
<div class="filter-tabs">
    <div class="filter-tab active" onclick="filterNotif(this,'semua')">
        Semua
        @if($belumDibaca['semua'] > 0)
        <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">
            {{ $belumDibaca['semua'] }}
        </span>
        @endif
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'pembayaran')">
        💰 Pembayaran
        @if($belumDibaca['pembayaran'] > 0)
        <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">
            {{ $belumDibaca['pembayaran'] }}
        </span>
        @endif
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'les')">
        🎓 Les Privat
        @if($belumDibaca['les'] > 0)
        <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">
            {{ $belumDibaca['les'] }}
        </span>
        @endif
    </div>
    <div class="filter-tab" onclick="filterNotif(this,'pengguna')">👥 Pengguna Baru</div>
    <div class="filter-tab" onclick="filterNotif(this,'sistem')">
        ⚙️ Sistem
        @if($belumDibaca['sistem'] > 0)
        <span style="background:var(--danger);color:#fff;border-radius:20px;font-size:10px;padding:1px 6px;margin-left:4px;">
            {{ $belumDibaca['sistem'] }}
        </span>
        @endif
    </div>
</div>

{{-- FLASH --}}
@if(session('sukses'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:600;color:var(--success);">
    <i class="bi bi-check-circle-fill me-1"></i> {{ session('sukses') }}
</div>
@endif

{{-- HELPER: render satu item notifikasi --}}
@php
function renderNotifItem($n) {
$unread = !$n->sudah_dibaca;
$tipeMap = [
'les_privat' => 'les',
'pembayaran' => 'pembayaran',
'sistem' => 'sistem',
'belajar' => 'sistem',
'ulasan' => 'sistem',
'streak' => 'sistem',
];
$dataType = $tipeMap[$n->tipe] ?? 'sistem';
return ['unread' => $unread, 'dataType' => $dataType];
}
@endphp


{{-- HARI INI --}}
@if($hariIni->count() > 0)
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Hari Ini</div>
<div class="card-box mb-3">
    @foreach($hariIni as $n)
    @php $r = renderNotifItem($n); @endphp
    <div class="notif-item {{ $r['unread'] ? 'unread' : '' }}"
        data-type="{{ $r['dataType'] }}"
        onclick="tandaiBaca('{{ $n->id }}', this)">
        <div class="notif-icon" style="background:{{ $n->warna ?? 'var(--success-soft)' }};color:var(--success);">
            <i class="{{ $n->ikon ?? 'bi bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{!! $n->pesan !!}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> {{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if($r['unread'])<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <a href="{{ $n->url_aksi }}"
                style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                {{ $n->label_aksi }}
            </a>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- KEMARIN --}}
@if($kemarin->count() > 0)
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Kemarin</div>
<div class="card-box mb-3">
    @foreach($kemarin as $n)
    @php $r = renderNotifItem($n); @endphp
    <div class="notif-item {{ $r['unread'] ? 'unread' : '' }}"
        data-type="{{ $r['dataType'] }}"
        onclick="tandaiBaca('{{ $n->id }}', this)">
        <div class="notif-icon" style="background:{{ $n->warna ?? 'var(--success-soft)' }};color:var(--success);">
            <i class="{{ $n->ikon ?? 'bi bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{!! $n->pesan !!}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> {{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if($r['unread'])<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <a href="{{ $n->url_aksi }}"
                style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                {{ $n->label_aksi }}
            </a>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- MINGGU INI --}}
@if($mingguIni->count() > 0)
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Minggu Ini</div>
<div class="card-box mb-3">
    @foreach($mingguIni as $n)
    @php $r = renderNotifItem($n); @endphp
    <div class="notif-item {{ $r['unread'] ? 'unread' : '' }}"
        data-type="{{ $r['dataType'] }}"
        onclick="tandaiBaca('{{ $n->id }}', this)">
        <div class="notif-icon" style="background:{{ $n->warna ?? 'var(--success-soft)' }};color:var(--success);">
            <i class="{{ $n->ikon ?? 'bi bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{!! $n->pesan !!}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> {{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if($r['unread'])<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <a href="{{ $n->url_aksi }}"
                style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                {{ $n->label_aksi }}
            </a>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- LEBIH LAMA --}}
@if($lebihLama->count() > 0)
<div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Lebih Lama</div>
<div class="card-box mb-3" id="container-lama">
    @foreach($lebihLama->take(5) as $n)
    @php $r = renderNotifItem($n); @endphp
    <div class="notif-item {{ $r['unread'] ? 'unread' : '' }}"
        data-type="{{ $r['dataType'] }}"
        onclick="tandaiBaca('{{ $n->id }}', this)">
        <div class="notif-icon" style="background:{{ $n->warna ?? 'var(--success-soft)' }};color:var(--success);">
            <i class="{{ $n->ikon ?? 'bi bi-bell-fill' }}"></i>
        </div>
        <div style="flex:1;">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-desc">{!! $n->pesan !!}</div>
            <div class="notif-time"><i class="bi bi-clock me-1"></i> {{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            @if($r['unread'])<div class="notif-dot"></div>@endif
            @if($n->url_aksi && $n->label_aksi)
            <a href="{{ $n->url_aksi }}"
                style="background:#eff6ff;color:var(--primary);border:none;border-radius:8px;padding:5px 10px;font-size:11.5px;font-weight:700;cursor:pointer;text-decoration:none;">
                {{ $n->label_aksi }}
            </a>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Jika tidak ada notifikasi sama sekali --}}
@if($hariIni->count() === 0 && $kemarin->count() === 0 && $mingguIni->count() === 0 && $lebihLama->count() === 0)
<div class="card-box mb-3">
    <div style="text-align:center;padding:48px;color:var(--muted);">
        <i class="bi bi-bell-slash" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.4;"></i>
        <div style="font-size:15px;font-weight:700;margin-bottom:4px;">Belum ada notifikasi</div>
        <div style="font-size:13px;">Aktivitas sistem akan muncul di sini</div>
    </div>
</div>
@endif

{{-- Tombol muat lebih --}}
@if($lebihLama->count() > 5)
<div class="text-center mb-4">
    <button onclick="muatLebihBanyak()"
        id="btn-muat-lagi"
        style="background:var(--card-bg);border:1.5px solid var(--border);border-radius:10px;font-size:13px;color:var(--muted);padding:10px 24px;cursor:pointer;font-weight:600;">
        <i class="bi bi-arrow-down me-1"></i> Muat Notifikasi Lebih Lama
    </button>
</div>
@endif

@endsection

@push('scripts')
<script>
    // ── Filter tab ─────────────────────────────────────────
    function filterNotif(el, type) {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        if (type === 'semua') {
            document.querySelectorAll('.notif-item').forEach(n => n.style.display = '');
            return;
        }
        document.querySelectorAll('.notif-item').forEach(n => {
            n.style.display = n.dataset.type === type ? '' : 'none';
        });
    }

    // ── Tandai satu notifikasi dibaca via AJAX ─────────────
    function tandaiBaca(id, el) {
        if (!el.classList.contains('unread')) return;

        fetch('/admin/notifikasi/' + id + '/baca', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        }).then(() => {
            el.classList.remove('unread');
            const dot = el.querySelector('.notif-dot');
            if (dot) dot.remove();

            // Update badge jumlah di tab
            const badge = document.querySelector('.filter-tab.active span');
            if (badge) {
                const jumlah = parseInt(badge.textContent) - 1;
                if (jumlah <= 0) badge.remove();
                else badge.textContent = jumlah;
            }
        });
    }

    // ── Muat lebih banyak notifikasi lama ─────────────────
    let halamanLama = 2;

    function muatLebihBanyak() {
        const btn = document.getElementById('btn-muat-lagi');
        btn.textContent = 'Memuat...';
        btn.disabled = true;

        fetch('/admin/notifikasi/lebih-lama?page=' + halamanLama, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('container-lama');
                data.data.forEach(n => {
                    container.insertAdjacentHTML('beforeend', `
                <div class="notif-item ${!n.sudah_dibaca ? 'unread' : ''}"
                    data-type="sistem"
                    onclick="tandaiBaca('${n.id}', this)">
                    <div class="notif-icon" style="background:${n.warna ?? 'var(--success-soft)'};color:var(--success);">
                        <i class="${n.ikon ?? 'bi bi-bell-fill'}"></i>
                    </div>
                    <div style="flex:1;">
                        <div class="notif-title">${n.judul}</div>
                        <div class="notif-desc">${n.pesan}</div>
                        <div class="notif-time"><i class="bi bi-clock me-1"></i> ${n.created_at}</div>
                    </div>
                    ${!n.sudah_dibaca ? '<div style="flex-shrink:0;"><div class="notif-dot"></div></div>' : ''}
                </div>
            `);
                });

                halamanLama++;

                if (!data.next_page_url) {
                    btn.parentElement.remove(); // sembunyikan tombol jika sudah habis
                } else {
                    btn.textContent = 'Muat Notifikasi Lebih Lama';
                    btn.disabled = false;
                }
            });
    }
</script>
@endpush