@extends('layouts.app')

@section('title', 'Pengelolaan Paket - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Pengelolaan Paket')
@section('page-sub', 'Admin / Pengelolaan Paket')

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
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:all .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.08);}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .stat-val{font-size:1.5rem;font-weight:800;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}

    .tab-nav{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .tab-btn{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .tab-btn.active{background:var(--primary);color:#fff;}
    .tab-btn:hover:not(.active){background:var(--bg);color:var(--primary);}
    .tab-pane{display:none;}.tab-pane.active{display:block;}

    .pkg-card{background:var(--card-bg);border-radius:18px;border:2px solid var(--border);padding:24px;position:relative;overflow:hidden;transition:all .25s;display:flex;flex-direction:column;}
    .pkg-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,.1);}
    .pkg-card.popular{border-color:var(--primary);}
    .pkg-popular-badge{position:absolute;top:14px;right:-28px;background:var(--primary);color:#fff;font-size:.65rem;font-weight:700;padding:4px 36px;transform:rotate(45deg);letter-spacing:.5px;}
    .pkg-name{font-size:1.15rem;font-weight:800;margin-bottom:4px;}
    .pkg-price{font-size:1.6rem;font-weight:800;letter-spacing:-1px;line-height:1;}
    .pkg-feature{display:flex;align-items:flex-start;gap:8px;font-size:.8rem;margin-bottom:8px;color:var(--text);}
    .pkg-feature i{font-size:.85rem;margin-top:1px;flex-shrink:0;}
    .pkg-feature.off{color:var(--muted);}

    .card-box{background:var(--card-bg);border-radius:14px;border:1px solid var(--border);overflow:hidden;}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:14px;font-weight:700;color:var(--text);}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{background:#f8fafc;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;padding:10px 14px;border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:12px 14px;font-size:13px;color:var(--text);border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#fafcff;}

    .filter-bar{background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:12px 16px;display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:18px;}
    .search-wrap{flex:1;min-width:180px;position:relative;}
    .search-wrap i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--muted);}
    .search-wrap input{width:100%;padding:8px 12px 8px 34px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;outline:none;background:var(--bg);}
    .search-wrap input:focus{border-color:var(--primary);}
    .filter-select{padding:8px 28px 8px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;background:var(--bg);color:var(--text);outline:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;}

    /* MODAL */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:16px;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:100%;max-width:560px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:#fff;z-index:1;}
    .modal-head h5{font-size:15px;font-weight:800;color:var(--text);}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .form-label-c{font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;display:block;}
    .form-input-c{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;color:var(--text);outline:none;transition:border .2s;background:#fff;}
    .form-input-c:focus{border-color:var(--primary);}

    @media(max-width:767px){
        .tab-nav{overflow-x:auto;flex-wrap:nowrap;}
        .tab-btn{min-width:120px;flex:none;font-size:12px;}
    }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">📦 Pengelolaan Paket</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Kelola layanan, harga, dan fitur paket les privat</p>
    </div>
    <button onclick="document.getElementById('modal-tambah').classList.add('show')"
        style="background:var(--primary);color:#fff;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:7px;">
        <i class="bi bi-plus-lg"></i> Tambah Paket
    </button>
</div>

{{-- STAT CARDS --}}
@php
$pakets       = \App\Models\Paket::all();
$totalPaket   = $pakets->count();
$paketAktif   = $pakets->count(); // ganti dengan scope aktif jika ada
@endphp
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:var(--primary);"><i class="bi bi-box-seam-fill"></i></div>
            <div><div class="stat-val">{{ $totalPaket }}</div><div class="stat-label">Total Paket</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-check-circle-fill"></i></div>
            <div><div class="stat-val">{{ $paketAktif }}</div><div class="stat-label">Paket Aktif</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--info-soft);color:var(--info);"><i class="bi bi-people-fill"></i></div>
            <div><div class="stat-val">248</div><div class="stat-label">Total Pelanggan</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);"><i class="bi bi-cash-coin"></i></div>
            <div><div class="stat-val">Rp 89.5jt</div><div class="stat-label">Pendapatan Bulan Ini</div></div>
        </div>
    </div>
</div>

{{-- TABS --}}
<div class="tab-nav">
    <button class="tab-btn active" onclick="switchPaketTab(this,'privat')">
        <i class="bi bi-person-video3 me-1"></i> Paket Les Privat
    </button>
    <button class="tab-btn" onclick="switchPaketTab(this,'semua')">
        <i class="bi bi-grid me-1"></i> Semua
    </button>
</div>

{{-- TAB PRIVAT --}}
<div class="tab-pane active" id="tab-privat">
    <div class="filter-bar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="search-privat" placeholder="Cari nama paket…" oninput="filterKartu()"/>
        </div>
        <select class="filter-select" id="filter-tipe" onchange="filterKartu()">
            <option value="">Semua Jenjang</option>
            <option value="sd">SD</option>
            <option value="smp">SMP</option>
            <option value="sma">SMA</option>
        </select>
    </div>

    <div class="row g-3" id="kartu-container">
        @forelse($pakets as $p)
        <div class="col-12 col-md-6 col-xl-4 kartu-item"
             data-nama="{{ strtolower($p->nama) }}"
             data-tipe="{{ strtolower($p->tipe) }}">
            <div class="pkg-card {{ $loop->first ? 'popular' : '' }}">
                @if($loop->first)
                    <div class="pkg-popular-badge">⭐ Terpopuler</div>
                @endif

                {{-- Badge jenjang --}}
                <div style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:700;margin-bottom:12px;background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-person-video3"></i>
                    Les Privat ·
                    @switch(strtolower($p->tipe))
                        @case('sd') SD — Kelas 1-6 @break
                        @case('smp') SMP — Kelas 7-9 @break
                        @case('sma') SMA — Kelas 10-12 @break
                        @default {{ strtoupper($p->tipe) }}
                    @endswitch
                </div>

                <div class="pkg-name">{{ $p->nama }}</div>
                <div class="pkg-price" style="color:var(--primary);margin-bottom:4px;">
                    Rp {{ number_format($p->harga_min, 0, ',', '.') }}
                </div>
                <div style="font-size:12px;color:var(--muted);margin-bottom:14px;">
                    / sesi
                    @if($p->harga_max)
                        &nbsp;—&nbsp; maks Rp {{ number_format($p->harga_max, 0, ',', '.') }}
                    @endif
                </div>

                <hr style="border:none;border-top:1px dashed var(--border);margin:10px 0;"/>

                @if($p->jumlah_les)
                    <div class="pkg-feature">
                        <i class="bi bi-check-circle-fill" style="color:var(--success);"></i>
                        {{ $p->jumlah_les }} sesi les privat
                    </div>
                @endif

                @if($p->jumlah_soal)
                    <div class="pkg-feature">
                        <i class="bi bi-check-circle-fill" style="color:var(--success);"></i>
                        {{ $p->jumlah_soal }} soal latihan
                    </div>
                @endif

                @if($p->feedback_tutor)
                    <div class="pkg-feature">
                        <i class="bi bi-check-circle-fill" style="color:var(--success);"></i>
                        Feedback tutor
                    </div>
                @else
                    <div class="pkg-feature off">
                        <i class="bi bi-x-circle-fill"></i>
                        Feedback tutor
                    </div>
                @endif

                @if($p->akses_penuh)
                    <div class="pkg-feature">
                        <i class="bi bi-check-circle-fill" style="color:var(--success);"></i>
                        Akses penuh materi
                    </div>
                @endif

                <div class="d-flex gap-2 mt-auto pt-3">
                    {{-- Tombol Edit: kirim data paket ke modal --}}
                    <button
                        onclick="bukaModalEdit({{ $p->id }}, '{{ addslashes($p->nama) }}', {{ $p->harga_min }}, {{ $p->harga_max ?? 'null' }}, '{{ $p->tipe }}', {{ $p->jumlah_soal ?? 'null' }}, {{ $p->jumlah_les ?? 'null' }}, {{ $p->feedback_tutor ? 1 : 0 }}, {{ $p->akses_penuh ? 1 : 0 }})"
                        style="flex:1;padding:9px;border-radius:10px;font-size:12.5px;font-weight:700;cursor:pointer;border:1.5px solid var(--primary);background:#eff6ff;color:var(--primary);">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </button>
                    {{-- Tombol Hapus --}}
                    <form action="/admin/paket/{{ $p->id }}" method="POST"
                          onsubmit="return confirm('Hapus paket {{ addslashes($p->nama) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="padding:9px 12px;border-radius:10px;font-size:13px;cursor:pointer;border:1.5px solid var(--danger);background:var(--danger-soft);color:var(--danger);">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px dashed var(--border);">
                <i class="bi bi-box-seam" style="font-size:2.5rem;opacity:.4;display:block;margin-bottom:10px;"></i>
                Belum ada paket les privat. Klik <strong>Tambah Paket</strong> untuk mulai.
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- TAB SEMUA --}}
<div class="tab-pane" id="tab-semua">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title">Semua Paket Layanan</div>
            <span style="font-size:12px;color:var(--muted);">{{ $pakets->count() }} paket terdaftar</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Paket</th>
                        <th>Jenjang</th>
                        <th>Harga Min</th>
                        <th>Harga Max</th>
                        <th>Soal</th>
                        <th>Les</th>
                        <th>Feedback</th>
                        <th>Akses Penuh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pakets as $p)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration }}</td>
                    <td style="font-weight:700;">{{ $p->nama }}</td>
                    <td>
                        <span style="background:var(--bg);color:var(--primary);font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;">
                            {{ strtoupper($p->tipe) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($p->harga_min, 0, ',', '.') }}</td>
                    <td>{{ $p->harga_max ? 'Rp '.number_format($p->harga_max, 0, ',', '.') : '-' }}</td>
                    <td>{{ $p->jumlah_soal ?? '-' }}</td>
                    <td>{{ $p->jumlah_les ?? '-' }}</td>
                    <td>{{ $p->feedback_tutor ? '✅' : '❌' }}</td>
                    <td>{{ $p->akses_penuh ? '✅' : '❌' }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <button
                                onclick="bukaModalEdit({{ $p->id }}, '{{ addslashes($p->nama) }}', {{ $p->harga_min }}, {{ $p->harga_max ?? 'null' }}, '{{ $p->tipe }}', {{ $p->jumlah_soal ?? 'null' }}, {{ $p->jumlah_les ?? 'null' }}, {{ $p->feedback_tutor ? 1 : 0 }}, {{ $p->akses_penuh ? 1 : 0 }})"
                                style="width:30px;height:30px;border-radius:7px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--primary);"
                                title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="/admin/paket/{{ $p->id }}" method="POST"
                                  onsubmit="return confirm('Hapus paket {{ addslashes($p->nama) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="width:30px;height:30px;border-radius:7px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--danger);"
                                    title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:32px;color:var(--muted);">
                        Belum ada paket. Tambahkan melalui tombol di atas.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ==================== MODAL TAMBAH ==================== --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-plus-lg me-2" style="color:var(--primary);"></i>Tambah Paket Baru</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-tambah').classList.remove('show')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="/admin/paket" method="POST">
            @csrf
            <div style="padding:20px 22px;" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-c">Nama Paket *</label>
                    <input type="text" name="nama" class="form-input-c" placeholder="Contoh: Paket Les Privat SMA" required/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Jenjang *</label>
                    <select name="tipe" class="form-input-c" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="sd">SD (Kelas 1–6)</option>
                        <option value="smp">SMP (Kelas 7–9)</option>
                        <option value="sma">SMA (Kelas 10–12)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Harga Min (Rp) *</label>
                    <input type="number" name="harga_min" class="form-input-c" placeholder="50000" required/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Harga Max (Rp)</label>
                    <input type="number" name="harga_max" class="form-input-c" placeholder="200000"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Jumlah Soal</label>
                    <input type="number" name="jumlah_soal" class="form-input-c" placeholder="100"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Jumlah Sesi Les</label>
                    <input type="number" name="jumlah_les" class="form-input-c" placeholder="4"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Feedback Tutor</label>
                    <select name="feedback_tutor" class="form-input-c">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Akses Penuh Materi</label>
                    <select name="akses_penuh" class="form-input-c">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end pt-1">
                    <button type="button"
                        onclick="document.getElementById('modal-tambah').classList.remove('show')"
                        style="padding:9px 18px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                        Batal
                    </button>
                    <button type="submit"
                        style="padding:9px 18px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                        <i class="bi bi-plus-lg me-1"></i> Simpan Paket
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL EDIT ==================== --}}
<div class="modal-overlay" id="modal-edit">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary);"></i>Edit Paket</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-edit').classList.remove('show')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        {{-- Action diisi via JS sesuai ID paket --}}
        <form id="form-edit" action="" method="POST">
            @csrf
            @method('PUT')
            <div style="padding:20px 22px;" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-c">Nama Paket *</label>
                    <input type="text" name="nama" id="edit-nama" class="form-input-c" required/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Jenjang *</label>
                    <select name="tipe" id="edit-tipe" class="form-input-c" required>
                        <option value="sd">SD (Kelas 1–6)</option>
                        <option value="smp">SMP (Kelas 7–9)</option>
                        <option value="sma">SMA (Kelas 10–12)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Harga Min (Rp) *</label>
                    <input type="number" name="harga_min" id="edit-harga-min" class="form-input-c" required/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Harga Max (Rp)</label>
                    <input type="number" name="harga_max" id="edit-harga-max" class="form-input-c"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Jumlah Soal</label>
                    <input type="number" name="jumlah_soal" id="edit-jumlah-soal" class="form-input-c"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Jumlah Sesi Les</label>
                    <input type="number" name="jumlah_les" id="edit-jumlah-les" class="form-input-c"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Feedback Tutor</label>
                    <select name="feedback_tutor" id="edit-feedback" class="form-input-c">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-c">Akses Penuh Materi</label>
                    <select name="akses_penuh" id="edit-akses" class="form-input-c">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end pt-1">
                    <button type="button"
                        onclick="document.getElementById('modal-edit').classList.remove('show')"
                        style="padding:9px 18px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                        Batal
                    </button>
                    <button type="submit"
                        style="padding:9px 18px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Switch tab ──────────────────────────────────────────
function switchPaketTab(el, id) {
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    ['privat', 'semua'].forEach(t => {
        const pane = document.getElementById('tab-' + t);
        if (pane) pane.classList.toggle('active', t === id);
    });
}

// ── Buka modal edit & isi data ──────────────────────────
function bukaModalEdit(id, nama, hargaMin, hargaMax, tipe, jumlahSoal, jumlahLes, feedback, akses) {
    document.getElementById('form-edit').action = '/admin/paket/' + id;
    document.getElementById('edit-nama').value         = nama;
    document.getElementById('edit-tipe').value         = tipe;
    document.getElementById('edit-harga-min').value    = hargaMin;
    document.getElementById('edit-harga-max').value    = hargaMax ?? '';
    document.getElementById('edit-jumlah-soal').value  = jumlahSoal ?? '';
    document.getElementById('edit-jumlah-les').value   = jumlahLes ?? '';
    document.getElementById('edit-feedback').value     = feedback;
    document.getElementById('edit-akses').value        = akses;
    document.getElementById('modal-edit').classList.add('show');
}

// ── Filter kartu (pencarian + jenjang) ─────────────────
function filterKartu() {
    const keyword = document.getElementById('search-privat').value.toLowerCase();
    const tipe    = document.getElementById('filter-tipe').value.toLowerCase();
    document.querySelectorAll('.kartu-item').forEach(el => {
        const cocokNama = el.dataset.nama.includes(keyword);
        const cocokTipe = tipe === '' || el.dataset.tipe === tipe;
        el.style.display = (cocokNama && cocokTipe) ? '' : 'none';
    });
}

// ── Tutup modal klik di luar ───────────────────────────
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('show');
    });
});
</script>
@endpush