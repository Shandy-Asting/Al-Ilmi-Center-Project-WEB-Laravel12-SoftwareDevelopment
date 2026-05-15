@extends('layouts.app')

@section('title', 'Pembayaran - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Pembayaran')
@section('page-sub', 'Dashboard / Pembayaran')

@section('sidebar-menu')
    <div class="menu-label">Menu Utama</div>
    <a href="/siswa/dashboard" class="nav-item-custom {{ request()->is('siswa/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="/siswa/belajar-tka" class="nav-item-custom {{ request()->is('siswa/belajar-tka') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Belajar TKA
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
        <span class="nav-badge">3</span>
    </a>
    <a href="/siswa/profil" class="nav-item-custom {{ request()->is('siswa/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
<style>
    /* TABS */
    .main-tabs{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .main-tab{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .main-tab.active{background:var(--primary);color:#fff;}
    .main-tab:hover:not(.active){background:var(--bg);color:var(--primary);}

    /* STAT MINI */
    .stat-mini{background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:16px;text-align:center;}
    .stat-mini-val{font-size:1.4rem;font-weight:800;line-height:1;margin-bottom:4px;}
    .stat-mini-label{font-size:12px;color:var(--muted);}

    /* TAGIHAN CARD */
    .tagihan-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:16px;overflow:hidden;margin-bottom:16px;transition:box-shadow .2s;}
    .tagihan-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);}
    .tagihan-card.urgent{border-color:#fca5a5;}
    .th-header{padding:12px 18px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;border-bottom:1px solid var(--border);}
    .th-header.urgent{background:#fef2f2;}
    .th-header.normal{background:#f8faff;}
    .th-id{font-size:11.5px;font-weight:700;color:var(--muted);}
    .status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:700;}
    .th-body{padding:16px 18px;}
    .th-row{display:flex;align-items:flex-start;gap:14px;}
    .th-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
    .th-info{flex:1;min-width:0;}
    .th-title{font-size:14px;font-weight:700;color:var(--text);}
    .th-sub{font-size:12px;color:var(--muted);margin-top:3px;display:flex;align-items:center;gap:4px;}
    .th-amount{text-align:right;flex-shrink:0;}
    .amount-val{font-size:20px;font-weight:800;}
    .th-footer{padding:12px 18px;background:var(--bg);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}

    /* REKENING CARD */
    .rek-card{background:var(--card-bg);border:2px solid var(--border);border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;cursor:pointer;transition:all .2s;margin-bottom:10px;}
    .rek-card:hover{border-color:var(--primary-light);transform:translateX(3px);}
    .rek-card.selected{border-color:var(--primary);background:#eff6ff;}
    .rek-logo{width:52px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;}
    .rek-name{font-size:13px;font-weight:700;color:var(--text);}
    .rek-norek{font-size:12px;color:var(--muted);margin-top:2px;display:flex;align-items:center;gap:6px;}
    .btn-copy{border:none;background:#eff6ff;color:var(--primary);border-radius:6px;padding:2px 8px;font-size:11px;font-weight:600;cursor:pointer;transition:all .2s;}
    .btn-copy:hover{background:var(--primary);color:#fff;}
    .rek-check{margin-left:auto;width:22px;height:22px;border-radius:50%;border:2px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .2s;}
    .rek-card.selected .rek-check{background:var(--primary);border-color:var(--primary);color:#fff;}

    /* UPLOAD ZONE */
    .upload-zone{border:2px dashed var(--border);border-radius:12px;padding:28px;text-align:center;cursor:pointer;transition:all .2s;background:var(--bg);}
    .upload-zone:hover{border-color:var(--primary);background:#eff6ff;}
    .upload-zone.has-file{border-color:var(--success);background:var(--success-soft);}

    /* RIWAYAT TABLE */
    .tbl-riwayat{width:100%;border-collapse:collapse;}
    .tbl-riwayat thead th{padding:10px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;background:var(--bg);border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl-riwayat tbody td{padding:12px 14px;font-size:13px;color:var(--text);border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl-riwayat tbody tr:last-child td{border-bottom:none;}
    .tbl-riwayat tbody tr:hover td{background:#f8faff;}

    /* MODAL */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;padding:16px;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:100%;max-width:500px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:#fff;z-index:1;}
    .modal-head h5{font-size:15px;font-weight:800;color:var(--text);}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .form-label-custom{font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;display:block;}
    .card-box{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;}
    .card-box-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:14px;font-weight:700;color:var(--text);}
    .card-box-title i{color:var(--primary);margin-right:6px;}

    /* PRINT */
    @media print{
        .sidebar,.topbar,.main-tabs,.no-print{display:none!important;}
        .main-wrap{margin-left:0!important;}
        .content{padding:0!important;}
    }

    /* RESPONSIVE */
    @media(max-width:767px){
        .main-tabs{overflow-x:auto;flex-wrap:nowrap;}
        .main-tab{min-width:110px;flex:none;font-size:12px;}
        .th-row{flex-wrap:wrap;}
        .th-amount{width:100%;text-align:left!important;margin-top:6px;}
        .th-footer{flex-direction:column;align-items:flex-start;}
        .tbl-riwayat{font-size:11px;}
        .tbl-riwayat td,.tbl-riwayat th{padding:8px 10px!important;}
    }
    @media(max-width:480px){
        .modal-box{border-radius:14px;}
        .rek-card{flex-wrap:wrap;}
    }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-3 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">💳 Pembayaran</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">
            Kelola tagihan dan riwayat pembayaran les privat kamu
        </p>
    </div>
    <button onclick="window.print()" class="btn btn-sm fw-bold px-3 py-2 no-print"
        style="background:var(--danger-soft);color:var(--danger);border-radius:10px;border:1.5px solid var(--danger);font-size:12px;">
        <i class="bi bi-printer-fill me-1"></i> Cetak
    </button>
</div>

{{-- STAT MINI --}}
<div class="row g-3 mb-4">
    @php
    $statMinis = [
        ['2','Tagihan Belum Bayar','var(--danger)'],
        ['Rp 274rb','Total Tagihan Aktif','var(--primary)'],
        ['8','Riwayat Transaksi','var(--success)'],
        ['8 Apr','Jatuh Tempo Terdekat','var(--warning)'],
    ];
    @endphp
    @foreach($statMinis as $s)
    <div class="col-6 col-md-3">
        <div class="stat-mini">
            <div class="stat-mini-val" style="color:{{ $s[2] }};">{{ $s[0] }}</div>
            <div class="stat-mini-label">{{ $s[1] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- TABS --}}
<div class="main-tabs no-print">
    <button class="main-tab active" onclick="switchTab(this,'tagihan')">
        <i class="bi bi-receipt me-1"></i> Tagihan
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:3px;">2</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'riwayat')">
        <i class="bi bi-clock-history me-1"></i> Riwayat
    </button>
</div>

{{-- ══ TAB TAGIHAN ══ --}}
<div id="tab-tagihan">

    @php
    $tagihanList = [
        [
            'id'       => 'INV-2026-0412',
            'urgent'   => true,
            'status'   => 'Belum Dibayar',
            'tutor'    => 'Pak Budi Santoso',
            'mapel'    => 'Matematika – Integral',
            'jadwal'   => 'Selasa, 8 Apr 2026 · 10:00 WIB',
            'durasi'   => '90 mnt · Online',
            'harga'    => 'Rp 75.000',
            'harga_raw'=> 75000,
            'jatuh'    => 'Jatuh tempo: 8 Apr 2026',
            'urgent_label' => true,
        ],
        [
            'id'       => 'INV-2026-0418',
            'urgent'   => false,
            'status'   => 'Menunggu Bayar',
            'tutor'    => 'Bu Sari Dewi',
            'mapel'    => 'Fisika – Gerak Parabola',
            'jadwal'   => 'Kamis, 10 Apr 2026 · 14:00 WIB',
            'durasi'   => '60 mnt · Offline',
            'harga'    => 'Rp 50.000',
            'harga_raw'=> 50000,
            'jatuh'    => 'Jatuh tempo: 15 Apr 2026',
            'urgent_label' => false,
        ],
    ];
    @endphp

    @foreach($tagihanList as $t)
    <div class="tagihan-card {{ $t['urgent'] ? 'urgent' : '' }}">
        <div class="th-header {{ $t['urgent'] ? 'urgent' : 'normal' }}">
            <span class="th-id">#{{ $t['id'] }}</span>
            <div class="d-flex align-items-center gap-2">
                @if($t['urgent_label'])
                <span style="background:var(--danger-soft);color:var(--danger);font-size:10.5px;font-weight:700;padding:3px 8px;border-radius:20px;">
                    <i class="bi bi-alarm-fill me-1"></i>Segera!
                </span>
                @endif
                <span class="status-badge" style="background:var(--danger-soft);color:var(--danger);">
                    <i class="bi bi-clock-fill"></i> {{ $t['status'] }}
                </span>
            </div>
        </div>
        <div class="th-body">
            <div class="th-row">
                <div class="th-icon" style="background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-person-video3"></i>
                </div>
                <div class="th-info">
                    <div class="th-title">Les Privat – {{ $t['mapel'] }}</div>
                    <div class="th-sub"><i class="bi bi-person-fill"></i> {{ $t['tutor'] }}</div>
                    <div class="th-sub"><i class="bi bi-calendar3"></i> {{ $t['jadwal'] }}</div>
                    <div class="th-sub"><i class="bi bi-clock"></i> {{ $t['durasi'] }}</div>
                    <div class="th-sub" style="color:{{ $t['urgent'] ? 'var(--danger)' : 'var(--warning)' }};font-weight:600;">
                        <i class="bi bi-exclamation-circle-fill"></i> {{ $t['jatuh'] }}
                    </div>
                </div>
                <div class="th-amount">
                    <div class="amount-val" style="color:{{ $t['urgent'] ? 'var(--danger)' : 'var(--primary)' }};">{{ $t['harga'] }}</div>
                    <div style="font-size:11px;color:var(--muted);">Belum Lunas</div>
                </div>
            </div>
        </div>
        <div class="th-footer">
            <div style="font-size:12px;color:var(--muted);">
                <i class="bi bi-shield-check me-1"></i>Transfer ke rekening Al Ilmi Center lalu upload bukti
            </div>
            <button
                onclick="openModalBayar('{{ $t['id'] }}','{{ $t['mapel'] }}','{{ $t['harga'] }}','{{ $t['tutor'] }}')"
                class="btn btn-sm fw-bold"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;padding:8px 20px;box-shadow:0 4px 12px rgba(30,58,95,.3);">
                <i class="bi bi-send-fill me-1"></i> Bayar Sekarang
            </button>
        </div>
    </div>
    @endforeach

</div>

{{-- ══ TAB RIWAYAT ══ --}}
<div id="tab-riwayat" style="display:none;">

    {{-- Stat Riwayat --}}
    <div class="row g-3 mb-4">
        @php
        $rwStats = [
            ['Rp 520rb','Total Terbayar','var(--success)'],
            ['8','Total Transaksi','var(--primary)'],
            ['1','Ditolak','var(--danger)'],
        ];
        @endphp
        @foreach($rwStats as $rs)
        <div class="col-4">
            <div class="stat-mini">
                <div class="stat-mini-val" style="color:{{ $rs[2] }};">{{ $rs[0] }}</div>
                <div class="stat-mini-label">{{ $rs[1] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-clock-history"></i> Riwayat Pembayaran</div>
            <button onclick="window.print()"
                style="background:var(--danger-soft);color:var(--danger);border:1.5px solid var(--danger);border-radius:8px;font-size:12px;font-weight:600;padding:5px 12px;cursor:pointer;">
                <i class="bi bi-printer-fill me-1"></i> Cetak
            </button>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl-riwayat">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Layanan</th>
                        <th>Tutor</th>
                        <th>Bank</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php
                $riwayats = [
                    ['PAY-0041','Matematika – Trigonometri','Pak Budi Santoso','Bank BCA','Rp 75.000','dikonfirmasi','29 Mar 2026','bukti ada'],
                    ['PAY-0038','Fisika – Hukum Newton','Bu Sari Dewi','Bank BRI','Rp 50.000','dikonfirmasi','22 Mar 2026','bukti ada'],
                    ['PAY-0035','Kimia – Stoikiometri','Pak Rizal Hakim','Bank Mandiri','Rp 75.000','dikonfirmasi','15 Mar 2026','bukti ada'],
                    ['PAY-0031','Matematika – Integral','Pak Budi Santoso','Bank BCA','Rp 100.000','dikonfirmasi','8 Mar 2026','bukti ada'],
                    ['PAY-0028','B. Inggris – Grammar','Pak Fauzan','Bank BCA','Rp 50.000','ditolak','1 Mar 2026','bukti ada'],
                    ['PAY-0025','Fisika – Gerak Parabola','Bu Sari Dewi','Bank BRI','Rp 75.000','dikonfirmasi','22 Feb 2026','bukti ada'],
                    ['PAY-0021','Matematika – Statistika','Pak Budi Santoso','Bank BCA','Rp 75.000','dikonfirmasi','15 Feb 2026','bukti ada'],
                    ['PAY-0018','Kimia – Termokimia','Pak Rizal Hakim','Bank Mandiri','Rp 50.000','dikonfirmasi','8 Feb 2026','bukti ada'],
                ];
                @endphp
                @foreach($riwayats as $r)
                <tr>
                    <td style="font-weight:700;font-size:12px;color:var(--primary);">#{{ $r[0] }}</td>
                    <td>
                        <div style="font-weight:600;">{{ explode('–',$r[1])[0] }}</div>
                        <div style="font-size:11px;color:var(--muted);">{{ isset(explode('–',$r[1])[1]) ? '– '.trim(explode('–',$r[1])[1]) : '' }}</div>
                    </td>
                    <td style="font-size:12.5px;">{{ $r[2] }}</td>
                    <td style="font-size:12.5px;">{{ $r[3] }}</td>
                    <td style="font-weight:700;">{{ $r[4] }}</td>
                    <td>
                        @if($r[5] === 'dikonfirmasi')
                        <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;">
                            <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Lunas
                        </span>
                        @elseif($r[5] === 'menunggu')
                        <span style="background:var(--accent-soft);color:var(--warning);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                            ⏳ Menunggu
                        </span>
                        @else
                        <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                            ❌ Ditolak
                        </span>
                        @endif
                    </td>
                    <td style="font-size:12px;color:var(--muted);">{{ $r[6] }}</td>
                    <td>
                        <button onclick="openModalBukti()"
                            style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:4px 10px;font-size:11.5px;font-weight:600;cursor:pointer;">
                            <i class="bi bi-image me-1"></i>Bukti
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-top:1px solid var(--border);">
            <span style="font-size:12.5px;color:var(--muted);">Menampilkan 1–8 dari 8 transaksi</span>
            <div class="d-flex gap-1">
                @foreach(['<i class="bi bi-chevron-left"></i>','1','2','<i class="bi bi-chevron-right"></i>'] as $pg)
                <button style="border-radius:8px;{{ $pg==='1' ? 'background:var(--primary);color:#fff;border:none;' : 'background:var(--card-bg);border:1.5px solid var(--border);color:var(--muted);' }}font-size:12px;font-weight:700;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;">{!! $pg !!}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL BAYAR ══ --}}
<div class="modal-overlay" id="modal-bayar">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-credit-card-fill me-2" style="color:var(--primary);"></i>Bayar Tagihan</h5>
            <button class="modal-close-btn" onclick="closeModal('modal-bayar')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">

            {{-- Info Tagihan --}}
            <div style="background:var(--bg);border-radius:12px;padding:14px 16px;margin-bottom:20px;border-left:4px solid var(--primary);">
                <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">Detail Tagihan</div>
                <div style="font-size:14px;font-weight:700;color:var(--text);" id="modal-layanan">Les Privat – Matematika</div>
                <div style="font-size:12.5px;color:var(--muted);margin-top:2px;" id="modal-tutor">Tutor: Pak Budi Santoso</div>
                <div style="font-size:20px;font-weight:800;color:var(--primary);margin-top:8px;" id="modal-jumlah">Rp 75.000</div>
            </div>

            {{-- STEP 1: Pilih Rekening --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <div style="width:24px;height:24px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">1</div>
                <div style="font-size:13px;font-weight:700;color:var(--text);">Pilih Rekening Tujuan Transfer</div>
            </div>

            @php
            $rekeningDummy = [
                ['#003087','BCA','Bank BCA','1234567890','Al Ilmi Center'],
                ['#004ea8','BRI','Bank BRI','0987654321','Al Ilmi Center'],
                ['#005e97','MDR','Bank Mandiri','1122334455','Al Ilmi Center'],
            ];
            @endphp

            @foreach($rekeningDummy as $idx => $rek)
            <div class="rek-card {{ $idx === 0 ? 'selected' : '' }}" onclick="selectRek(this)">
                <div class="rek-logo" style="background:{{ $rek[0] }};">{{ $rek[1] }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="rek-name">{{ $rek[2] }}</div>
                    <div class="rek-norek">
                        <span id="norek-{{ $idx }}">{{ $rek[3] }}</span>
                        <button type="button" class="btn-copy" onclick="event.stopPropagation();copyText('{{ $rek[3] }}',this)">
                            <i class="bi bi-clipboard me-1"></i>Salin
                        </button>
                    </div>
                    <div style="font-size:11px;color:var(--muted);">a.n. {{ $rek[4] }}</div>
                </div>
                <div class="rek-check">
                    @if($idx === 0)<i class="bi bi-check-lg" style="font-size:11px;color:#fff;"></i>@endif
                </div>
            </div>
            @endforeach

            {{-- Instruksi --}}
            <div style="background:var(--accent-soft);border:1px solid var(--accent);border-radius:10px;padding:12px 14px;margin:16px 0;font-size:12.5px;color:#92400e;">
                <div style="font-weight:700;margin-bottom:6px;"><i class="bi bi-info-circle-fill me-1"></i>Cara Pembayaran:</div>
                <ol style="margin:0;padding-left:16px;line-height:1.9;">
                    <li>Pilih rekening tujuan di atas</li>
                    <li>Transfer tepat sesuai jumlah tagihan</li>
                    <li>Ambil foto/screenshot bukti transfer</li>
                    <li>Upload bukti di bawah lalu klik <strong>Kirim</strong></li>
                    <li>Tunggu konfirmasi tutor (maks 1×24 jam)</li>
                </ol>
            </div>

            {{-- STEP 2: Upload --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <div style="width:24px;height:24px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">2</div>
                <div style="font-size:13px;font-weight:700;color:var(--text);">Upload Bukti Transfer</div>
            </div>

            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                <div id="uploadIcon" style="font-size:2.2rem;color:var(--muted);margin-bottom:8px;">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                </div>
                <div id="uploadText">
                    <div style="font-size:13.5px;font-weight:700;color:var(--primary);">Klik untuk pilih foto</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:4px;">JPG, PNG — Maks. 2MB</div>
                </div>
                <input type="file" id="fileInput" accept="image/*" style="display:none;" onchange="previewUpload(this)"/>
            </div>

            {{-- Preview --}}
            <div id="previewWrap" style="display:none;margin-top:10px;text-align:center;">
                <img id="previewImg" style="max-width:100%;max-height:180px;border-radius:10px;border:2px solid var(--success);"/>
                <div style="font-size:12px;color:var(--success);font-weight:600;margin-top:6px;">
                    <i class="bi bi-check-circle-fill me-1"></i><span id="previewName"></span>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn fw-bold flex-fill py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;"
                    onclick="closeModal('modal-bayar')">Batal</button>
                <button type="button" class="btn fw-bold flex-fill py-2"
                    onclick="kirimPembayaran()"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;box-shadow:0 4px 12px rgba(30,58,95,.3);">
                    <i class="bi bi-send-fill me-1"></i> Kirim Bukti Bayar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL BUKTI ══ --}}
<div class="modal-overlay" id="modal-bukti">
    <div class="modal-box" style="max-width:400px;">
        <div class="modal-head">
            <h5><i class="bi bi-image me-2" style="color:var(--primary);"></i>Bukti Pembayaran</h5>
            <button class="modal-close-btn" onclick="closeModal('modal-bukti')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;text-align:center;">
            {{-- Placeholder bukti --}}
            <div style="background:var(--bg);border-radius:12px;padding:40px;margin-bottom:14px;border:2px dashed var(--border);">
                <i class="bi bi-image" style="font-size:3rem;color:var(--muted);display:block;margin-bottom:8px;"></i>
                <div style="font-size:13px;color:var(--muted);">Bukti Transfer</div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:4px;">#PAY-0041 · 29 Mar 2026</div>
            </div>
            <div style="background:var(--success-soft);border-radius:10px;padding:10px 14px;font-size:12.5px;color:var(--success);font-weight:600;">
                <i class="bi bi-check-circle-fill me-1"></i> Pembayaran Dikonfirmasi Lunas
            </div>
            <button onclick="closeModal('modal-bukti')" class="btn fw-bold w-100 mt-3"
                style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);font-size:13px;">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- ══ MODAL SUKSES ══ --}}
<div class="modal-overlay" id="modal-sukses">
    <div class="modal-box" style="max-width:420px;">
        <div style="padding:32px 28px;text-align:center;">
            <div style="font-size:64px;margin-bottom:14px;">🎉</div>
            <div style="font-size:20px;font-weight:800;color:var(--text);margin-bottom:6px;">Bukti Terkirim!</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.6;">
                Bukti pembayaran berhasil dikirim.<br/>
                Menunggu konfirmasi dari tutor dalam <strong>1×24 jam</strong>.
            </div>
            <div style="background:var(--success-soft);border-radius:12px;padding:14px;margin-bottom:20px;text-align:left;">
                <div style="font-size:12px;color:var(--success);font-weight:700;">
                    <i class="bi bi-check-circle-fill me-1"></i> Status: Menunggu Verifikasi Tutor
                </div>
                <div style="font-size:12px;color:var(--success);margin-top:4px;">
                    Kamu akan mendapat notifikasi setelah dikonfirmasi.
                </div>
            </div>
            <button onclick="closeModal('modal-sukses')" class="btn fw-bold w-100 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                OK, Mengerti
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(el, id) {
    document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('tab-tagihan').style.display = id === 'tagihan' ? '' : 'none';
    document.getElementById('tab-riwayat').style.display = id === 'riwayat'  ? '' : 'none';
}

function openModalBayar(id, layanan, jumlah, tutor) {
    document.getElementById('modal-layanan').textContent = 'Les Privat – ' + layanan;
    document.getElementById('modal-tutor').textContent   = 'Tutor: ' + tutor;
    document.getElementById('modal-jumlah').textContent  = jumlah;
    // Reset upload
    document.getElementById('previewWrap').style.display = 'none';
    document.getElementById('fileInput').value = '';
    document.getElementById('uploadZone').classList.remove('has-file');
    document.getElementById('uploadIcon').innerHTML = '<i class="bi bi-cloud-arrow-up-fill"></i>';
    document.getElementById('uploadText').innerHTML = '<div style="font-size:13.5px;font-weight:700;color:var(--primary);">Klik untuk pilih foto</div><div style="font-size:12px;color:var(--muted);margin-top:4px;">JPG, PNG — Maks. 2MB</div>';
    document.getElementById('modal-bayar').classList.add('show');
}

function openModalBukti() {
    document.getElementById('modal-bukti').classList.add('show');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

function selectRek(el) {
    document.querySelectorAll('.rek-card').forEach(c => {
        c.classList.remove('selected');
        const check = c.querySelector('.rek-check');
        if(check){ check.style.background=''; check.style.borderColor='var(--border)'; check.innerHTML=''; }
    });
    el.classList.add('selected');
    const check = el.querySelector('.rek-check');
    if(check){
        check.style.background = 'var(--primary)';
        check.style.borderColor = 'var(--primary)';
        check.innerHTML = '<i class="bi bi-check-lg" style="font-size:11px;color:#fff;"></i>';
    }
}

function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Tersalin!';
        btn.style.background = 'var(--success)';
        btn.style.color = '#fff';
        setTimeout(() => { btn.innerHTML = orig; btn.style.background=''; btn.style.color=''; }, 2000);
    });
}

function previewUpload(input) {
    const file = input.files[0];
    if(!file) return;
    if(file.size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB!');
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewName').textContent = file.name;
        document.getElementById('previewWrap').style.display = '';
        document.getElementById('uploadZone').classList.add('has-file');
        document.getElementById('uploadIcon').innerHTML = '<i class="bi bi-check-circle-fill" style="color:var(--success);"></i>';
        document.getElementById('uploadText').innerHTML = '<div style="font-size:13px;font-weight:700;color:var(--success);">File siap dikirim</div><div style="font-size:11.5px;color:var(--muted);margin-top:3px;">Klik untuk ganti foto</div>';
    };
    reader.readAsDataURL(file);
}

function kirimPembayaran() {
    // Validasi file sudah diupload
    const file = document.getElementById('fileInput').files[0];
    if(!file) {
        alert('Harap upload bukti transfer terlebih dahulu!');
        return;
    }
    // Simulasi pengiriman (FE only)
    closeModal('modal-bayar');
    setTimeout(() => {
        document.getElementById('modal-sukses').classList.add('show');
    }, 300);
}
</script>
@endpush