@extends('layouts.app')

@section('title', 'Pengelolaan Soal - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Bank Soal')
@section('page-sub', 'Dashboard / Akademik / Bank Soal')

@section('sidebar-menu')
<div class="menu-label">Utama</div>
<a href="/tutor/dashboard" class="nav-item-custom {{ request()->is('tutor/dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid-1x2-fill"></i> Dashboard
</a>
<a href="/tutor/jadwal" class="nav-item-custom {{ request()->is('tutor/jadwal') ? 'active' : '' }}">
    <i class="bi bi-calendar3"></i> Jadwal Mengajar
    <span class="nav-badge">3</span>
</a>
<a href="#" class="nav-item-custom">
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
    <span class="nav-badge">2</span>
</a>
<div class="menu-label">Akun</div>
<a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> Profil Saya
</a>
@endsection

@push('styles')
<style>
    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 18px 20px;
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
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-val {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        color: var(--text);
    }

    .stat-label {
        font-size: .78rem;
        color: var(--muted);
        margin-top: 4px;
    }

    .filter-bar {
        background: var(--card-bg);
        border-radius: 14px;
        border: 1px solid var(--border);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .search-wrap {
        flex: 1;
        min-width: 220px;
        position: relative;
    }

    .search-wrap i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: .9rem;
    }

    .search-wrap input {
        width: 100%;
        padding: 9px 12px 9px 36px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: .85rem;
        background: var(--bg);
        color: var(--text);
        outline: none;
        transition: border .2s;
    }

    .search-wrap input:focus {
        border-color: var(--primary);
        background: #fff;
    }

    .filter-select {
        padding: 9px 32px 9px 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: .83rem;
        background: var(--bg);
        color: var(--text);
        outline: none;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .table-soal {
        width: 100%;
        border-collapse: collapse;
    }

    .table-soal thead th {
        padding: 11px 16px;
        font-size: .73rem;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        background: var(--bg);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .table-soal tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .table-soal tbody tr:last-child {
        border-bottom: none;
    }

    .table-soal tbody tr:hover {
        background: #f8faff;
    }

    .table-soal tbody td {
        padding: 13px 16px;
        font-size: .84rem;
        vertical-align: middle;
        color: var(--text);
    }

    .soal-num {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #eff6ff;
        color: var(--primary);
        font-weight: 700;
        font-size: .82rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .soal-preview {
        font-size: .86rem;
        font-weight: 500;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 380px;
        color: var(--text);
    }

    .soal-sub {
        font-size: .73rem;
        color: var(--muted);
        margin-top: 3px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .badge-jenjang {
        font-size: .67rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
    }

    .badge-mapel {
        font-size: .67rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        background: #eff6ff;
        color: var(--primary);
    }

    .badge-tipe-soal {
        font-size: .67rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 6px;
    }

    .badge-tipe-soal.pg {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-sulit {
        font-size: .67rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .badge-sulit.mudah {
        background: var(--success-soft);
        color: var(--success);
    }

    .badge-sulit.sedang {
        background: var(--accent-soft);
        color: var(--warning);
    }

    .badge-sulit.sulit {
        background: var(--danger-soft);
        color: var(--danger);
    }

    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--muted);
        font-size: .82rem;
        transition: all .2s;
    }

    .btn-action:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .btn-action.del:hover {
        background: var(--danger);
        color: #fff;
        border-color: var(--danger);
    }

    .btn-action.suc:hover {
        background: var(--success);
        color: #fff;
        border-color: var(--success);
    }

    .modal-custom .modal-content {
        border-radius: 18px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
    }

    .form-label-custom {
        font-size: .82rem;
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
        font-size: .85rem;
        color: var(--text);
        outline: none;
        transition: border .2s;
        background: #fff;
        resize: vertical;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
    }

    .option-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .option-label {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: var(--bg);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .82rem;
        flex-shrink: 0;
        color: var(--muted);
    }

    .option-input {
        flex: 1;
        padding: 8px 12px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: .84rem;
        outline: none;
        transition: border .2s;
        color: var(--text);
    }

    .option-input:focus {
        border-color: var(--primary);
    }

    .pembahasan-box {
        background: var(--success-soft);
        border: 1px solid #a7f3d0;
        border-radius: 12px;
        padding: 14px 16px;
    }

    .pembahasan-label {
        font-size: .78rem;
        font-weight: 700;
        color: var(--success);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .card-box {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border);
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

    .card-box-title i {
        color: var(--primary);
        margin-right: 6px;
    }

    .opsi-detail {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 9px;
        margin-bottom: 6px;
        background: #fff;
        border: 1px solid var(--border);
        color: var(--muted);
    }

    .opsi-detail.benar {
        background: var(--success-soft);
        border: 1px solid #a7f3d0;
        font-weight: 600;
        color: #065f46;
    }

    .opsi-detail-key {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .72rem;
        font-weight: 700;
        background: var(--border);
        color: var(--muted);
        flex-shrink: 0;
    }

    .opsi-detail.benar .opsi-detail-key {
        background: var(--success);
        color: #fff;
    }
</style>
@endpush

@section('content')

{{-- FLASH MESSAGE --}}
@if(session('sukses'))
<div id="flash-sukses" class="alert alert-success rounded-3 mb-3 d-flex align-items-center gap-2" style="font-size:.85rem;">
    <i class="bi bi-check-circle-fill"></i> {{ session('sukses') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger rounded-3 mb-3" style="font-size:.85rem;">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
</div>
@endif

{{-- HEADER --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-0">Bank Soal</h4>
        <p style="font-size:.85rem;color:var(--muted);margin:0;">Buat, kelola, dan atur soal latihan serta kuis untuk siswa Anda.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--bg);color:var(--primary);border-radius:10px;border:1.5px solid var(--primary);font-size:13px;"
            data-bs-toggle="modal" data-bs-target="#modalImport">
            <i class="bi bi-upload me-1"></i> Import Soal
        </button>
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
            data-bs-toggle="modal" data-bs-target="#modalBuat">
            <i class="bi bi-plus-lg me-1"></i> Buat Soal
        </button>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $statsData = [
    ['bi-patch-question-fill', '#eff6ff', 'var(--primary)', $soal->count(), 'Total Soal'],
    ['bi-ui-radios', '#dbeafe', '#1d4ed8', $soal->where('tingkat_kesulitan','mudah')->count(), 'Mudah'],
    ['bi-pencil-fill', '#f5f3ff', '#6d28d9', $soal->where('tingkat_kesulitan','sedang')->count(), 'Sedang'],
    ['bi-check2-square', '#f0fdfa', '#0d9488', $soal->where('tingkat_kesulitan','sulit')->count(), 'Sulit'],
    ];
    @endphp
    @foreach($statsData as $s)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div>
                <div class="stat-val">{{ $s[3] }}</div>
                <div class="stat-label">{{ $s[4] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- FILTER BAR --}}
<div class="filter-bar mb-4">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Cari pertanyaan atau topik…" />
    </div>
    <select class="filter-select" id="filterJenjang">
        <option value="">Semua Jenjang</option>
        <option value="sd">SD</option>
        <option value="smp">SMP</option>
        <option value="sma">SMA</option>
    </select>
    <select class="filter-select" id="filterMapel">
        <option value="">Semua Mapel</option>
        @foreach($materi->pluck('mata_pelajaran')->unique() as $mp)
        <option value="{{ strtolower($mp) }}">{{ $mp }}</option>
        @endforeach
    </select>
    <select class="filter-select" id="filterTingkat">
        <option value="">Semua Tingkat</option>
        <option value="mudah">Mudah</option>
        <option value="sedang">Sedang</option>
        <option value="sulit">Sulit</option>
    </select>
</div>

{{-- TABLE --}}
<div class="card-box mb-4">
    <div class="card-box-header">
        <div class="card-box-title"><i class="bi bi-list-check"></i> Daftar Soal</div>
        <span style="font-size:.8rem;color:var(--muted);" id="filterInfo">Total {{ $soal->count() }} soal</span>
    </div>

    <div class="table-responsive">
        <table class="table-soal" id="tableSoal">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Materi</th>
                    <th>Jenjang</th>
                    <th>Mata Pelajaran</th>
                    <th>Tingkat</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($soal as $i => $s)
                <tr
                    data-jenjang="{{ strtolower($s->materi->jenjang ?? '') }}"
                    data-mapel="{{ strtolower($s->materi->mata_pelajaran ?? '') }}"
                    data-tingkat="{{ $s->tingkat_kesulitan }}"
                    data-pertanyaan="{{ strtolower($s->pertanyaan) }}">
                    <td>
                        <div class="soal-num">{{ $i + 1 }}</div>
                    </td>
                    <td>
                        <div class="soal-preview">{{ $s->pertanyaan }}</div>
                        <div class="soal-sub">
                            <span><i class="bi bi-folder2"></i>{{ $s->materi->judul ?? '-' }}</span>
                            <span><i class="bi bi-calendar3"></i>{{ $s->created_at->format('d M Y') }}</span>
                        </div>
                    </td>
                    <td style="font-size:.8rem;font-weight:600;color:var(--text);">{{ $s->materi->judul ?? '-' }}</td>
                    <td>
                        <span class="badge-jenjang" style="background:#dbeafe;color:#1d4ed8;">
                            {{ strtoupper($s->materi->jenjang ?? '-') }}
                        </span>
                    </td>
                    <td><span class="badge-mapel">{{ $s->materi->mata_pelajaran ?? '-' }}</span></td>
                    <td><span class="badge-sulit {{ $s->tingkat_kesulitan }}">{{ ucfirst($s->tingkat_kesulitan) }}</span></td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            {{-- Tombol Lihat Detail --}}
                            <button type="button" class="btn-action suc" title="Lihat Detail"
                                onclick="bukaDetail(
        '{{ addslashes($s->pertanyaan) }}',
        '{{ addslashes($s->pilihan_a) }}',
        '{{ addslashes($s->pilihan_b) }}',
        '{{ addslashes($s->pilihan_c) }}',
        '{{ addslashes($s->pilihan_d) }}',
        '{{ $s->jawaban_benar }}',
        '{{ addslashes($s->pembahasan ?? "-") }}',
        '{{ strtoupper($s->materi->jenjang ?? "-") }}',
        '{{ $s->materi->mata_pelajaran ?? "-" }}',
        '{{ $s->tingkat_kesulitan }}',
        '{{ $s->materi->judul ?? "-" }}'
    )">
                                <i class="bi bi-eye"></i>
                            </button>

                            {{-- Tombol Edit --}}
                            <button type="button" class="btn-action" title="Edit"
                                onclick="bukaEdit(
        '{{ $s->id }}',
        '{{ addslashes($s->pertanyaan) }}',
        '{{ addslashes($s->pilihan_a) }}',
        '{{ addslashes($s->pilihan_b) }}',
        '{{ addslashes($s->pilihan_c) }}',
        '{{ addslashes($s->pilihan_d) }}',
        '{{ $s->jawaban_benar }}',
        '{{ addslashes($s->pembahasan ?? "") }}',
        '{{ $s->tingkat_kesulitan }}'
    )">
                                <i class="bi bi-pencil"></i>
                            </button>
                            {{-- Tombol Hapus --}}
                            <button type="button" class="btn-action del" title="Hapus"
                                onclick="bukaHapus('{{ $s->id }}', '{{ addslashes(Str::limit($s->pertanyaan, 80)) }}')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="7" class="text-center py-5" style="color:var(--muted);font-size:.85rem;">
                        <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.4;"></i>
                        Belum ada soal. Klik <strong>Buat Soal</strong> untuk menambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 d-flex justify-content-end" style="border-top:1px solid var(--border);">
        <button class="btn btn-sm rounded-2 fw-semibold" style="background:#eff6ff;border:none;color:var(--primary);font-size:.78rem;">
            <i class="bi bi-download me-1"></i> Export
        </button>
    </div>
</div>

{{-- ══ TABEL PERKEMBANGAN SISWA PER SOAL/MATERI ══ --}}
<div class="card-box mb-4">
    <div class="card-box-header">
        <div class="card-box-title">
            <i class="bi bi-people-fill"></i> Perkembangan Siswa
        </div>
        <select class="filter-select" id="filterMateriSiswa" style="font-size:.8rem;padding:6px 28px 6px 10px;">
            <option value="">Semua Materi</option>
            @foreach($materi as $m)
            <option value="{{ $m->id }}">{{ $m->judul }}</option>
            @endforeach
        </select>
    </div>

    <div class="table-responsive">
        <table class="table-soal" id="tableSiswa">
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Materi</th>
                    <th>Nilai</th>
                    <th>Benar</th>
                    <th>Salah</th>
                    <th>Total Soal</th>
                    <th>Durasi</th>
                    <th>Tipe</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasilSiswa as $h)
                <tr data-materi="{{ $h->materi_id }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">
                                {{ strtoupper(substr($h->siswa->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:.84rem;">{{ $h->siswa->name ?? '-' }}</div>
                                <div style="font-size:.72rem;color:var(--muted);">{{ $h->siswa->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.82rem;font-weight:600;">{{ $h->materi->judul ?? '-' }}</td>
                    <td>
                        <span style="font-size:.88rem;font-weight:800;color:{{ $h->nilai >= 80 ? 'var(--success)' : ($h->nilai >= 60 ? 'var(--warning)' : 'var(--danger)') }};">
                            {{ $h->nilai }}
                        </span>
                    </td>
                    <td><span style="color:var(--success);font-weight:700;">{{ $h->soal_benar }}</span></td>
                    <td><span style="color:var(--danger);font-weight:700;">{{ $h->soal_salah }}</span></td>
                    <td style="font-size:.82rem;">{{ $h->total_soal }}</td>
                    <td style="font-size:.8rem;color:var(--muted);">{{ $h->durasi_menit }} mnt</td>
                    <td>
                        <span style="font-size:.7rem;font-weight:700;padding:3px 8px;border-radius:6px;background:{{ $h->tipe === 'kuis' ? '#dbeafe' : '#f0fdf4' }};color:{{ $h->tipe === 'kuis' ? '#1d4ed8' : '#15803d' }};">
                            {{ ucfirst($h->tipe) }}
                        </span>
                    </td>
                    <td style="font-size:.78rem;color:var(--muted);">{{ $h->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4" style="color:var(--muted);font-size:.84rem;">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                        Belum ada siswa yang mengerjakan soal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($hasilSiswa->count() > 0)
    {{-- Ringkasan Statistik --}}
    <div class="row g-3 p-3" style="border-top:1px solid var(--border);">
        <div class="col-6 col-md-3 text-center">
            <div style="font-size:1.4rem;font-weight:800;color:var(--primary);">{{ $hasilSiswa->count() }}</div>
            <div style="font-size:.75rem;color:var(--muted);">Total Pengerjaan</div>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div style="font-size:1.4rem;font-weight:800;color:var(--success);">{{ round($hasilSiswa->avg('nilai')) }}</div>
            <div style="font-size:.75rem;color:var(--muted);">Rata-rata Nilai</div>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div style="font-size:1.4rem;font-weight:800;color:var(--warning);">{{ $hasilSiswa->pluck('user_id')->unique()->count() }}</div>
            <div style="font-size:.75rem;color:var(--muted);">Siswa Unik</div>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div style="font-size:1.4rem;font-weight:800;color:var(--danger);">{{ $hasilSiswa->where('nilai','<',60)->count() }}</div>
            <div style="font-size:.75rem;color:var(--muted);">Perlu Perhatian (&lt;60)</div>
        </div>
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MODAL BUAT SOAL                                            --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="modal fade modal-custom" id="modalBuat" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle-fill me-2" style="color:var(--primary);"></i>Buat Soal Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="/tutor/soal" id="formBuat">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Kolom Kiri --}}
                        <div class="col-lg-8">

                            <div class="p-3 rounded-3 mb-3" style="background:var(--bg);border:1px solid var(--border);">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Materi <span class="text-danger">*</span></label>
                                        <select name="materi_id" class="form-control-custom" required>
                                            <option value="">-- Pilih Materi --</option>
                                            @foreach($materi as $m)
                                            <option value="{{ $m->id }}">
                                                {{ $m->judul }} ({{ strtoupper($m->jenjang) }} · {{ $m->mata_pelajaran }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @if($materi->isEmpty())
                                        <div style="font-size:.75rem;color:var(--danger);margin-top:4px;">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Belum ada materi. <a href="/tutor/materi" style="color:var(--primary);">Buat materi dulu</a>.
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-custom">Tingkat Kesulitan</label>
                                        <select name="tingkat_kesulitan" class="form-control-custom">
                                            <option value="mudah">Mudah</option>
                                            <option value="sedang" selected>Sedang</option>
                                            <option value="sulit">Sulit</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-custom">Jawaban Benar <span class="text-danger">*</span></label>
                                        <select name="jawaban_benar" class="form-control-custom" required>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="d">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-custom">Teks Pertanyaan <span class="text-danger">*</span></label>
                                <textarea name="pertanyaan" class="form-control-custom" rows="4"
                                    placeholder="Tuliskan pertanyaan di sini…" required></textarea>
                            </div>

                            <label class="form-label-custom">Opsi Jawaban</label>
                            @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                            <div class="option-row">
                                <div class="option-label">{{ $label }}</div>
                                <input type="text" name="pilihan_{{ $key }}" class="option-input"
                                    placeholder="Opsi {{ $label }}" required />
                            </div>
                            @endforeach

                            <div class="mt-3">
                                <label class="form-label-custom">Pembahasan / Kunci Jawaban</label>
                                <div class="pembahasan-box">
                                    <div class="pembahasan-label"><i class="bi bi-lightbulb-fill"></i> Pembahasan Jawaban</div>
                                    <textarea name="pembahasan" class="form-control-custom" rows="3"
                                        style="background:transparent;border-color:#a7f3d0;"
                                        placeholder="Tuliskan pembahasan atau cara penyelesaian soal ini…"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-lg-4">
                            <div class="card-box p-3">
                                <div style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:10px;">
                                    <i class="bi bi-info-circle me-1" style="color:var(--primary);"></i> Panduan
                                </div>
                                <div style="font-size:.8rem;color:var(--muted);line-height:1.8;">
                                    <p class="mb-2"><i class="bi bi-1-circle-fill me-1" style="color:var(--primary);"></i> Pilih materi yang sudah dibuat.</p>
                                    <p class="mb-2"><i class="bi bi-2-circle-fill me-1" style="color:var(--primary);"></i> Tulis pertanyaan dengan jelas.</p>
                                    <p class="mb-2"><i class="bi bi-3-circle-fill me-1" style="color:var(--primary);"></i> Isi semua opsi A, B, C, D.</p>
                                    <p class="mb-2"><i class="bi bi-4-circle-fill me-1" style="color:var(--primary);"></i> Pilih jawaban yang benar.</p>
                                    <p class="mb-0"><i class="bi bi-5-circle-fill me-1" style="color:var(--primary);"></i> Tambahkan pembahasan agar siswa bisa belajar.</p>
                                </div>
                                <hr style="border-color:var(--border);">
                                <div style="font-size:.76rem;color:var(--muted);">
                                    <i class="bi bi-collection me-1"></i>
                                    Soal otomatis tersedia di halaman latihan siswa sesuai materi yang dipilih.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn rounded-2 fw-semibold"
                        style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn rounded-2 fw-semibold"
                        style="background:var(--primary);color:#fff;font-size:.85rem;border:none;">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Soal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MODAL DETAIL                                               --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="modal fade modal-custom" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-eye-fill me-2" style="color:var(--success);"></i>Detail Soal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge-jenjang" id="detail_jenjang" style="background:#dbeafe;color:#1d4ed8;"></span>
                    <span class="badge-mapel" id="detail_mapel"></span>
                    <span class="badge-tipe-soal pg">Pil. Ganda</span>
                    <span class="badge-sulit" id="detail_tingkat"></span>
                    <span class="ms-auto" style="font-size:.75rem;color:var(--muted);">
                        <i class="bi bi-folder2 me-1"></i><span id="detail_materi"></span>
                    </span>
                </div>

                <div style="background:var(--bg);border-radius:12px;padding:16px;border:1px solid var(--border);margin-bottom:16px;">
                    <div style="font-size:.73rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">Pertanyaan</div>
                    <div id="detail_pertanyaan" style="font-size:.9rem;font-weight:500;line-height:1.6;color:var(--text);"></div>
                </div>

                <div class="mb-4">
                    <div style="font-size:.73rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">Opsi Jawaban</div>
                    @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $k => $lbl)
                    <div class="opsi-detail" id="detail_opsi_{{ $k }}">
                        <div class="opsi-detail-key">{{ $lbl }}</div>
                        <span id="detail_teks_{{ $k }}"></span>
                        <span class="ms-auto detail-benar-label" style="font-size:.75rem;display:none;">
                            <i class="bi bi-check-circle-fill text-success"></i> Jawaban Benar
                        </span>
                    </div>
                    @endforeach
                </div>

                <div class="pembahasan-box">
                    <div class="pembahasan-label"><i class="bi bi-lightbulb-fill"></i> Pembahasan</div>
                    <p id="detail_pembahasan" style="font-size:.84rem;margin:0;line-height:1.7;color:var(--text);"></p>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn rounded-2 fw-semibold"
                    style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                    data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MODAL EDIT                                                 --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="modal fade modal-custom" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-2" style="color:var(--warning);"></i>Edit Soal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="formEdit" action="">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label-custom">Teks Pertanyaan <span class="text-danger">*</span></label>
                        <textarea name="pertanyaan" id="edit_pertanyaan"
                            class="form-control-custom" rows="4" required></textarea>
                    </div>

                    <label class="form-label-custom">Opsi Jawaban</label>
                    @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                    <div class="option-row">
                        <div class="option-label">{{ $label }}</div>
                        <input type="text" name="pilihan_{{ $key }}"
                            id="edit_pilihan_{{ $key }}"
                            class="option-input" required />
                    </div>
                    @endforeach

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label-custom">Jawaban Benar <span class="text-danger">*</span></label>
                            <select name="jawaban_benar" id="edit_jawaban_benar" class="form-control-custom" required>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Tingkat Kesulitan</label>
                            <select name="tingkat_kesulitan" id="edit_tingkat" class="form-control-custom">
                                <option value="mudah">Mudah</option>
                                <option value="sedang">Sedang</option>
                                <option value="sulit">Sulit</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label-custom">Pembahasan</label>
                        <div class="pembahasan-box">
                            <div class="pembahasan-label"><i class="bi bi-lightbulb-fill"></i> Pembahasan</div>
                            <textarea name="pembahasan" id="edit_pembahasan"
                                class="form-control-custom" rows="3"
                                style="background:transparent;border-color:#a7f3d0;"
                                placeholder="Tuliskan pembahasan…"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn rounded-2 fw-semibold"
                        style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn rounded-2 fw-semibold"
                        style="background:var(--warning);color:#fff;font-size:.85rem;border:none;">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MODAL HAPUS                                                --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="modal fade modal-custom" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-body text-center p-4">

                <div style="width:64px;height:64px;border-radius:50%;background:var(--danger-soft);display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--danger);margin:0 auto 16px;">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color:var(--text);">Hapus Soal?</h5>
                <p style="font-size:.86rem;color:var(--muted);margin-bottom:12px;">
                    Soal ini akan dihapus secara permanen dan tidak bisa dikembalikan.
                </p>
                <div class="p-3 rounded-3 mb-4 text-start" style="background:var(--danger-soft);border:1px solid #fecaca;">
                    <div style="font-size:.78rem;color:var(--danger);font-weight:600;margin-bottom:4px;">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Soal yang akan dihapus:
                    </div>
                    <div id="hapus_preview" style="font-size:.77rem;color:#7f1d1d;font-style:italic;line-height:1.5;"></div>
                </div>

                <form method="POST" id="formHapus" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2">
                        <button type="button" class="btn rounded-2 fw-semibold flex-fill"
                            style="background:#f1f5f9;color:var(--muted);border:none;font-size:.85rem;"
                            data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn rounded-2 fw-semibold flex-fill"
                            style="background:var(--danger);color:#fff;border:none;font-size:.85rem;">
                            <i class="bi bi-trash3 me-1"></i> Ya, Hapus
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MODAL IMPORT                                               --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="modal fade modal-custom" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-upload me-2" style="color:var(--primary);"></i>Import Soal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p style="font-size:.84rem;color:var(--muted);margin-bottom:16px;">Upload file soal dalam format yang didukung.</p>
                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <span style="font-size:.67rem;font-weight:700;padding:8px 12px;border-radius:10px;background:#dbeafe;color:#1d4ed8;">Excel (.xlsx)</span>
                    <span style="font-size:.67rem;font-weight:700;padding:8px 12px;border-radius:10px;background:#f5f3ff;color:#6d28d9;">Word (.docx)</span>
                    <span style="font-size:.67rem;font-weight:700;padding:8px 12px;border-radius:10px;background:#f0fdfa;color:#0d9488;">JSON</span>
                </div>
                <div style="border:2px dashed var(--border);border-radius:12px;padding:28px;text-align:center;background:var(--bg);cursor:pointer;">
                    <div style="font-size:2rem;color:var(--muted);margin-bottom:8px;"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                    <div style="font-size:.84rem;color:var(--muted);">
                        <strong style="color:var(--primary);">Klik untuk pilih file</strong> atau drag & drop<br />
                        <span style="font-size:.76rem;">xlsx, docx, json – Maks. 10 MB</span>
                    </div>
                </div>
                <div class="mt-3 p-3 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div style="font-size:.78rem;font-weight:700;color:var(--primary);margin-bottom:4px;">
                        <i class="bi bi-info-circle me-1"></i>Panduan Format
                    </div>
                    <div style="font-size:.75rem;color:#1e40af;">
                        Download <a href="#" style="color:var(--primary);font-weight:600;">template Excel</a> untuk memastikan format file sesuai.
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn rounded-2 fw-semibold"
                    style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;"
                    data-bs-dismiss="modal">Batal</button>
                <button class="btn rounded-2 fw-semibold"
                    style="background:var(--primary);color:#fff;font-size:.85rem;border:none;">
                    <i class="bi bi-upload me-1"></i> Import Sekarang
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── FLASH AUTO HIDE ──
    @if(session('sukses'))
    setTimeout(() => {
        const el = document.getElementById('flash-sukses');
        if (el) {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }
    }, 3000);
    @endif

    // ── BUKA MODAL DETAIL ──
    function bukaDetail(pertanyaan, a, b, c, d, jawaban, pembahasan, jenjang, mapel, tingkat, materi) {
        document.getElementById('detail_pertanyaan').textContent = pertanyaan;
        document.getElementById('detail_jenjang').textContent = jenjang;
        document.getElementById('detail_mapel').textContent = mapel;
        document.getElementById('detail_materi').textContent = materi;
        document.getElementById('detail_pembahasan').textContent = pembahasan;

        const badgeTingkat = document.getElementById('detail_tingkat');
        badgeTingkat.className = 'badge-sulit ' + tingkat;
        badgeTingkat.textContent = tingkat.charAt(0).toUpperCase() + tingkat.slice(1);

        const opsiMap = {
            a,
            b,
            c,
            d
        };
        ['a', 'b', 'c', 'd'].forEach(k => {
            const row = document.getElementById('detail_opsi_' + k);
            const teks = document.getElementById('detail_teks_' + k);
            const label = row.querySelector('.detail-benar-label');
            const key = row.querySelector('.opsi-detail-key');
            teks.textContent = opsiMap[k];
            if (k === jawaban) {
                row.className = 'opsi-detail benar';
                key.style.background = 'var(--success)';
                key.style.color = '#fff';
                label.style.display = '';
            } else {
                row.className = 'opsi-detail';
                key.style.background = '';
                key.style.color = '';
                label.style.display = 'none';
            }
        });

        new bootstrap.Modal(document.getElementById('modalDetail')).show();
    }

    // ── BUKA MODAL EDIT ──
    function bukaEdit(id, pertanyaan, a, b, c, d, jawaban, pembahasan, tingkat) {
        document.getElementById('edit_pertanyaan').value = pertanyaan;
        document.getElementById('edit_pilihan_a').value = a;
        document.getElementById('edit_pilihan_b').value = b;
        document.getElementById('edit_pilihan_c').value = c;
        document.getElementById('edit_pilihan_d').value = d;
        document.getElementById('edit_jawaban_benar').value = jawaban;
        document.getElementById('edit_pembahasan').value = pembahasan;
        document.getElementById('edit_tingkat').value = tingkat;
        document.getElementById('formEdit').action = '/tutor/soal/' + id;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    // ── BUKA MODAL HAPUS ──
    function bukaHapus(id, preview) {
        document.getElementById('formHapus').action = '/tutor/soal/' + id;
        document.getElementById('hapus_preview').textContent = '"' + preview + '…"';
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }

    // ── FILTER CLIENT-SIDE REAL-TIME ──
    function applyFilter() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const jenjang = document.getElementById('filterJenjang').value;
        const mapel = document.getElementById('filterMapel').value;
        const tingkat = document.getElementById('filterTingkat').value;

        let visible = 0;
        document.querySelectorAll('#tableSoal tbody tr').forEach(row => {
            if (row.id === 'emptyRow') return;
            const okSearch = !search || row.dataset.pertanyaan.includes(search);
            const okJenjang = !jenjang || row.dataset.jenjang === jenjang;
            const okMapel = !mapel || row.dataset.mapel === mapel;
            const okTingkat = !tingkat || row.dataset.tingkat === tingkat;
            const show = okSearch && okJenjang && okMapel && okTingkat;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        const info = document.getElementById('filterInfo');
        if (info) info.textContent = 'Menampilkan ' + visible + ' soal';
    }

    document.getElementById('searchInput').addEventListener('input', applyFilter);
    document.getElementById('filterJenjang').addEventListener('change', applyFilter);
    document.getElementById('filterMapel').addEventListener('change', applyFilter);
    document.getElementById('filterTingkat').addEventListener('change', applyFilter);
    // Filter tabel siswa berdasarkan materi
    document.getElementById('filterMateriSiswa').addEventListener('change', function() {
        const val = this.value;
        document.querySelectorAll('#tableSiswa tbody tr').forEach(row => {
            if (!row.dataset.materi) return;
            row.style.display = (!val || row.dataset.materi === val) ? '' : 'none';
        });
    });
</script>
@endpush