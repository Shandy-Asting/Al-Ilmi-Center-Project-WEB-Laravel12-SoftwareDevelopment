@extends('layouts.app')

@section('title', 'Jadwal Mengajar - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Jadwal Mengajar')
@section('page-sub', 'Dashboard / Jadwal Mengajar')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/tutor/dashboard" class="nav-item-custom {{ request()->is('tutor/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
    <a href="/tutor/jadwal" class="nav-item-custom {{ request()->is('tutor/jadwal') ? 'active' : '' }}">
        <i class="bi bi-calendar3"></i> Jadwal Mengajar
        <span class="nav-badge">3</span>
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
        <span class="nav-badge">2</span>
    </a>
    <div class="menu-label">Akun</div>
    <a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
<style>
    /* ── SIDEBAR TUTOR ── */
    .tutor-sidebar-menu { list-style: none; }

    /* ── TABS ── */
    .main-tabs{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .main-tab{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .main-tab.active{background:var(--primary);color:#fff;box-shadow:0 3px 10px rgba(30,58,95,.25);}
    .main-tab:hover:not(.active){background:var(--bg);color:var(--primary);}

    /* ── KALENDER ── */
    .cal-wrap{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;}
    .cal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
    .cal-title{font-size:16px;font-weight:800;color:var(--text);}
    .cal-nav{width:32px;height:32px;border-radius:8px;border:1.5px solid var(--border);background:var(--card-bg);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;color:var(--muted);transition:all .2s;}
    .cal-nav:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
    .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:4px;text-align:center;}
    .cal-day-name{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;padding:6px 0;}
    .cal-day{font-size:13px;padding:8px 4px;border-radius:10px;cursor:pointer;transition:all .15s;font-weight:500;color:var(--text);position:relative;}
    .cal-day:hover{background:#eff6ff;color:var(--primary);}
    .cal-day.today{background:var(--primary);color:#fff;font-weight:700;}
    .cal-day.has-sesi{font-weight:700;}
    .cal-day.has-sesi::after{content:'';position:absolute;bottom:3px;left:50%;transform:translateX(-50%);width:5px;height:5px;border-radius:50%;background:var(--accent);}
    .cal-day.today.has-sesi::after{background:#fff;}
    .cal-day.other-month{color:var(--border);}
    .cal-day.selected{background:var(--accent);color:var(--primary);font-weight:700;}

    /* ── JADWAL ITEM ── */
    .jadwal-item{display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid var(--border);transition:background .15s;cursor:pointer;}
    .jadwal-item:last-child{border-bottom:none;}
    .jadwal-item:hover{background:#f8faff;}
    .jadwal-item.sedang{background:linear-gradient(90deg,#eff6ff,#f8faff);border-left:3px solid var(--primary);}
    .sched-time{min-width:76px;text-align:center;padding:8px 10px;background:var(--bg);border-radius:10px;}
    .time-main{font-size:.9rem;font-weight:700;color:var(--primary);}
    .time-dur{font-size:.7rem;color:var(--muted);}
    .sched-info{flex:1;}
    .sched-subject{font-weight:700;font-size:.88rem;color:var(--text);}
    .sched-student{font-size:.78rem;color:var(--muted);margin-top:3px;}
    .sched-mode{font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:20px;}
    .sched-mode.online{background:var(--success-soft);color:var(--success);}
    .sched-mode.offline{background:#f5f3ff;color:#6d28d9;}
    .btn-sched{width:32px;height:32px;border-radius:8px;border:1.5px solid var(--border);background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);font-size:.85rem;transition:all .2s;}
    .btn-sched:hover{background:var(--primary);color:#fff;border-color:var(--primary);}

    /* ── PERMINTAAN CARD ── */
    .request-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:14px;padding:16px 18px;margin-bottom:12px;transition:box-shadow .2s;}
    .request-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.07);}
    .request-card.new{border-color:var(--primary);background:#f8faff;}
    .rc-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
    .rc-id{font-size:11.5px;font-weight:700;color:var(--muted);}
    .rc-body{display:flex;align-items:center;gap:12px;}
    .rc-av{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;color:#fff;flex-shrink:0;}
    .rc-name{font-size:13.5px;font-weight:700;color:var(--text);}
    .rc-sub{font-size:12px;color:var(--muted);}
    .rc-actions{display:flex;gap:8px;margin-top:12px;}
    .btn-rc{border:none;border-radius:8px;padding:7px 16px;font-size:12.5px;font-weight:700;cursor:pointer;flex:1;transition:all .2s;}

    /* ── STAT CARDS ── */
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .stat-val{font-size:1.5rem;font-weight:800;line-height:1;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}

    /* ── CARD BOX ── */
    .card-box{background:var(--card-bg);border-radius:16px;border:1px solid var(--border);}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:.95rem;font-weight:700;color:var(--text);}
    .card-box-title i{color:var(--primary);margin-right:6px;}

    /* ── MODAL ── */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:90%;max-width:480px;max-height:90vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0;}to{transform:translateY(0);opacity:1;}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-head h5{font-size:15px;font-weight:800;color:var(--text);}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .modal-body-p{padding:20px 22px;}
    .form-label-custom{font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;display:block;}
    .form-control-custom{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;color:var(--text);outline:none;transition:border .2s;background:#fff;}
    .form-control-custom:focus{border-color:var(--primary);}
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">📅 Jadwal Mengajar</h4>
        <div style="font-size:13px;color:var(--muted);">
            Dashboard / <span style="color:var(--primary);font-weight:600;">Jadwal Mengajar</span>
        </div>
    </div>
    <button class="btn btn-sm fw-bold px-3 py-2"
        style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
        onclick="openModalTambah()">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
    </button>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['bi-calendar-check-fill','#eff6ff','var(--primary)','5','Sesi Hari Ini'],
        ['bi-calendar-week-fill','var(--success-soft)','var(--success)','18','Sesi Minggu Ini'],
        ['bi-people-fill','var(--info-soft)','var(--info)','14','Siswa Aktif'],
        ['bi-hourglass-split','var(--accent-soft)','var(--warning)','3','Permintaan Baru'],
    ];
    @endphp
    @foreach($stats as $s)
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

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'hari-ini')">
        <i class="bi bi-sun me-1"></i> Hari Ini
    </button>
    <button class="main-tab" onclick="switchTab(this,'kalender')">
        <i class="bi bi-calendar3 me-1"></i> Kalender
    </button>
    <button class="main-tab" onclick="switchTab(this,'permintaan')">
        <i class="bi bi-inbox-fill me-1"></i> Permintaan
        <span style="background:var(--danger);color:#fff;font-size:10px;padding:1px 5px;border-radius:20px;margin-left:4px;">3</span>
    </button>
    <button class="main-tab" onclick="switchTab(this,'semua')">
        <i class="bi bi-list-ul me-1"></i> Semua Jadwal
    </button>
</div>

{{-- ══ TAB: HARI INI ══ --}}
<div id="tab-hari-ini">
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card-box">
                <div class="card-box-header">
                    <div class="card-box-title">
                        <i class="bi bi-calendar-day-fill"></i> Jadwal Hari Ini
                        <span style="font-size:12px;font-weight:500;color:var(--muted);margin-left:4px;">Rabu, 29 April 2026</span>
                    </div>
                    <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                        5 Sesi
                    </span>
                </div>

                @php
                $jadwals = [
                    ['08.00','90 mnt','Matematika – Trigonometri','SMA','Aldi Pratama','Jl. Merdeka No.12','offline','selesai'],
                    ['10.30','60 mnt','Fisika – Gerak Parabola','SMA','Sinta Dewi','Via Google Meet','online','selesai'],
                    ['13.00','90 mnt','Kimia – Stoikiometri','SMA','Rizky Aditya','Jl. Kenanga No.5','offline','sedang'],
                    ['15.30','60 mnt','Matematika – Integral','SMA','Maya Putri','Via Zoom','online','akan-datang'],
                    ['17.00','60 mnt','Bahasa Inggris – Grammar','SMP','Farhan Maulana','Via Google Meet','online','akan-datang'],
                ];
                @endphp

                @foreach($jadwals as $j)
                <div class="jadwal-item {{ $j[7] === 'sedang' ? 'sedang' : '' }}">
                    <div class="sched-time">
                        <div class="time-main">{{ $j[0] }}</div>
                        <div class="time-dur">{{ $j[1] }}</div>
                    </div>
                    <div class="sched-info">
                        <div class="sched-subject">
                            {{ $j[2] }}
                            <span style="background:#eff6ff;color:var(--primary);font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:20px;margin-left:6px;">{{ $j[3] }}</span>
                            @if($j[7] === 'sedang')
                            <span style="background:var(--danger-soft);color:var(--danger);font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:20px;margin-left:4px;">🔴 Sedang Berlangsung</span>
                            @elseif($j[7] === 'selesai')
                            <span style="background:var(--success-soft);color:var(--success);font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:20px;margin-left:4px;">✅ Selesai</span>
                            @endif
                        </div>
                        <div class="sched-student">
                            <i class="bi bi-person-fill me-1"></i>{{ $j[4] }} &nbsp;·&nbsp;
                            <i class="bi bi-{{ $j[6] === 'online' ? 'camera-video-fill' : 'geo-alt-fill' }} me-1"></i>{{ $j[5] }}
                        </div>
                    </div>
                    <span class="sched-mode {{ $j[6] }}">{{ ucfirst($j[6]) }}</span>
                    <div class="d-flex gap-1">
                        <button class="btn-sched" title="Detail" onclick="openModalDetail()"><i class="bi bi-eye"></i></button>
                        @if($j[7] === 'akan-datang' || $j[7] === 'sedang')
                        <button class="btn-sched" title="Mulai/Lanjut" style="background:var(--primary);color:#fff;border-color:var(--primary);"><i class="bi bi-play-fill"></i></button>
                        @endif
                        @if($j[7] === 'selesai')
                        <button class="btn-sched" title="Beri Catatan"><i class="bi bi-pencil-fill"></i></button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- RINGKASAN HARI INI --}}
        <div class="col-lg-4">
            <div class="card-box mb-3" style="overflow:visible;">
                <div class="card-box-header">
                    <div class="card-box-title"><i class="bi bi-pie-chart-fill"></i> Ringkasan Hari Ini</div>
                </div>
                <div class="p-3">
                    @php
                    $ringkasan = [
                        ['Selesai','2','var(--success-soft)','var(--success)','bi-check-circle-fill'],
                        ['Sedang Berlangsung','1','var(--danger-soft)','var(--danger)','bi-circle-fill'],
                        ['Akan Datang','2','var(--accent-soft)','var(--warning)','bi-clock-fill'],
                        ['Total Durasi','4 jam','#eff6ff','var(--primary)','bi-hourglass-fill'],
                        ['Penghasilan Hari Ini','Rp 300rb','var(--success-soft)','var(--success)','bi-cash-coin'],
                    ];
                    @endphp
                    @foreach($ringkasan as $r)
                    <div style="display:flex;align-items:center;gap:10px;padding:10px;background:{{ $r[2] }};border-radius:10px;margin-bottom:8px;">
                        <i class="bi {{ $r[4] }}" style="color:{{ $r[3] }};font-size:18px;width:24px;flex-shrink:0;"></i>
                        <div style="flex:1;">
                            <div style="font-size:12px;color:var(--muted);">{{ $r[0] }}</div>
                        </div>
                        <div style="font-size:15px;font-weight:800;color:{{ $r[3] }};">{{ $r[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- COUNTDOWN SESI BERIKUTNYA --}}
            <div style="background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:16px;padding:18px;color:#fff;">
                <div style="font-size:11px;font-weight:700;opacity:.75;margin-bottom:6px;text-transform:uppercase;letter-spacing:.06em;">Sesi Berikutnya</div>
                <div style="font-size:16px;font-weight:800;margin-bottom:4px;">Matematika – Integral</div>
                <div style="font-size:12px;opacity:.75;margin-bottom:12px;"><i class="bi bi-person-fill me-1"></i> Maya Putri · 15:30 WIB</div>
                <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:10px;text-align:center;">
                    <div style="font-size:10px;opacity:.75;margin-bottom:4px;">Dimulai dalam</div>
                    <div style="font-size:24px;font-weight:800;" id="countdown-sesi">02:28:00</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ TAB: KALENDER ══ --}}
<div id="tab-kalender" style="display:none;">
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="cal-wrap">
                <div class="cal-header">
                    <button class="cal-nav" onclick="changeMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                    <div class="cal-title" id="cal-month-title">April 2026</div>
                    <button class="cal-nav" onclick="changeMonth(1)"><i class="bi bi-chevron-right"></i></button>
                </div>
                <div class="cal-grid">
                    @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $d)
                    <div class="cal-day-name">{{ $d }}</div>
                    @endforeach
                    @php
                    $days = [
                        ['30','other'],['1',''],['2','sesi'],['3','sesi'],['4',''],['5','sesi'],['6',''],
                        ['7',''],['8','sesi'],['9','sesi'],['10',''],['11','sesi'],['12',''],['13',''],
                        ['14',''],['15','sesi'],['16','sesi'],['17','sesi'],['18',''],['19',''],['20',''],
                        ['21',''],['22','sesi'],['23',''],['24',''],['25','sesi'],['26',''],['27',''],
                        ['28',''],['29','sesi today'],['30',''],['1','other'],['2','other'],['3','other'],['4','other'],
                    ];
                    @endphp
                    @foreach($days as $day)
                    <div class="cal-day {{ str_contains($day[1],'other') ? 'other-month' : '' }} {{ str_contains($day[1],'today') ? 'today' : '' }} {{ str_contains($day[1],'sesi') ? 'has-sesi' : '' }}"
                        onclick="selectCalDay(this)">
                        {{ $day[0] }}
                    </div>
                    @endforeach
                </div>
                <div style="display:flex;gap:12px;margin-top:14px;font-size:11.5px;color:var(--muted);">
                    <span><span style="width:10px;height:10px;border-radius:50%;background:var(--primary);display:inline-block;margin-right:4px;"></span> Hari Ini</span>
                    <span><span style="width:8px;height:8px;border-radius:50%;background:var(--accent);display:inline-block;margin-right:4px;"></span> Ada Sesi</span>
                </div>
            </div>
        </div>

        {{-- DETAIL TANGGAL TERPILIH --}}
        <div class="col-lg-4">
            <div class="card-box">
                <div class="card-box-header">
                    <div class="card-box-title"><i class="bi bi-calendar-event-fill"></i> Rabu, 29 Apr 2026</div>
                    <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">5 Sesi</span>
                </div>
                @foreach([['08.00','Matematika','Aldi','online'],['10.30','Fisika','Sinta','online'],['13.00','Kimia','Rizky','offline'],['15.30','Matematika','Maya','online'],['17.00','B. Inggris','Farhan','online']] as $j)
                <div style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-bottom:1px solid var(--border);">
                    <div style="font-size:12px;font-weight:700;color:var(--primary);min-width:44px;">{{ $j[0] }}</div>
                    <div style="flex:1;">
                        <div style="font-size:12.5px;font-weight:600;color:var(--text);">{{ $j[1] }}</div>
                        <div style="font-size:11px;color:var(--muted);">{{ $j[2] }}</div>
                    </div>
                    <span style="background:{{ $j[3] === 'online' ? 'var(--success-soft)' : '#f5f3ff' }};color:{{ $j[3] === 'online' ? 'var(--success)' : '#6d28d9' }};font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;">{{ ucfirst($j[3]) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ══ TAB: PERMINTAAN ══ --}}
<div id="tab-permintaan" style="display:none;">
    <div class="row g-3">
        <div class="col-lg-8">
            <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:14px;">
                🔔 Permintaan Masuk <span style="font-size:12px;color:var(--muted);font-weight:500;">(3 permintaan baru)</span>
            </div>

            @php
            $requests = [
                ['#REQ-0421','A','var(--primary)','Andi Pratama','Matematika – Integral','Jumat, 1 Mei 2026','14:00 WIB · 90 mnt','Online','new'],
                ['#REQ-0420','S','var(--success)','Siti Rahma','Fisika – Gelombang','Sabtu, 2 Mei 2026','10:00 WIB · 60 mnt','Offline','new'],
                ['#REQ-0419','B','var(--warning)','Budi Kurnia','Matematika – Statistika','Senin, 4 Mei 2026','15:00 WIB · 90 mnt','Online','new'],
            ];
            @endphp

            @foreach($requests as $r)
            <div class="request-card {{ $r[8] === 'new' ? 'new' : '' }}">
                <div class="rc-header">
                    <span class="rc-id">{{ $r[0] }}</span>
                    @if($r[8] === 'new')
                    <span style="background:var(--danger-soft);color:var(--danger);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                        <i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Baru
                    </span>
                    @endif
                </div>
                <div class="rc-body">
                    <div class="rc-av" style="background:{{ $r[2] }};">{{ $r[1] }}</div>
                    <div style="flex:1;">
                        <div class="rc-name">{{ $r[3] }}</div>
                        <div class="rc-sub"><i class="bi bi-book-fill me-1"></i>{{ $r[4] }}</div>
                        <div class="rc-sub mt-1">
                            <i class="bi bi-calendar3 me-1"></i>{{ $r[5] }} · {{ $r[6] }}
                            &nbsp;·&nbsp;
                            <span style="background:{{ $r[7] === 'Online' ? 'var(--success-soft)' : 'var(--info-soft)' }};color:{{ $r[7] === 'Online' ? 'var(--success)' : 'var(--info)' }};font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">{{ $r[7] }}</span>
                        </div>
                    </div>
                    <div style="font-size:15px;font-weight:800;color:var(--primary);flex-shrink:0;">Rp 75rb</div>
                </div>
                <div class="rc-actions">
                    <button class="btn-rc" style="background:var(--danger-soft);color:var(--danger);">
                        <i class="bi bi-x-circle me-1"></i> Tolak
                    </button>
                    <button class="btn-rc" style="background:var(--primary);color:#fff;box-shadow:0 3px 10px rgba(30,58,95,.25);">
                        <i class="bi bi-check-circle-fill me-1"></i> Terima Jadwal
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card-box p-3">
                <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:12px;">📊 Statistik Permintaan</div>
                @php
                $reqStats = [
                    ['Permintaan Masuk Bulan Ini','12','var(--primary)'],
                    ['Diterima','9','var(--success)'],
                    ['Ditolak','2','var(--danger)'],
                    ['Menunggu Respons','3','var(--warning)'],
                ];
                @endphp
                @foreach($reqStats as $rs)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);">
                    <span style="font-size:13px;color:var(--muted);">{{ $rs[0] }}</span>
                    <span style="font-size:16px;font-weight:800;color:{{ $rs[2] }};">{{ $rs[1] }}</span>
                </div>
                @endforeach
                <div style="margin-top:12px;padding:10px;background:var(--success-soft);border-radius:10px;text-align:center;">
                    <div style="font-size:11px;color:var(--success);font-weight:700;">Tingkat Penerimaan</div>
                    <div style="font-size:24px;font-weight:800;color:var(--success);">75%</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ TAB: SEMUA JADWAL ══ --}}
<div id="tab-semua" style="display:none;">
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <div style="position:relative;flex:1;min-width:200px;">
            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);"></i>
            <input type="text" style="border:1.5px solid var(--border);border-radius:10px;padding:9px 12px 9px 36px;font-size:13px;width:100%;outline:none;" placeholder="Cari nama siswa, mata pelajaran…"/>
        </div>
        <select style="border:1.5px solid var(--border);border-radius:10px;padding:9px 14px;font-size:13px;outline:none;background:var(--card-bg);">
            <option>Semua Status</option>
            <option>Akan Datang</option>
            <option>Selesai</option>
        </select>
        <select style="border:1.5px solid var(--border);border-radius:10px;padding:9px 14px;font-size:13px;outline:none;background:var(--card-bg);">
            <option>April 2026</option>
            <option>Maret 2026</option>
        </select>
    </div>

    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-table"></i> Semua Jadwal</div>
            <span style="font-size:12px;color:var(--muted);">38 sesi ditemukan</span>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg);">
                        @foreach(['Tanggal & Waktu','Siswa','Mata Pelajaran','Durasi','Mode','Status','Aksi'] as $h)
                        <th style="padding:10px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border);white-space:nowrap;">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @php
                $semuaJadwal = [
                    ['29 Apr · 08.00','Aldi Pratama','Matematika','90 mnt','Offline','selesai'],
                    ['29 Apr · 13.00','Rizky Aditya','Kimia','90 mnt','Offline','sedang'],
                    ['29 Apr · 15.30','Maya Putri','Matematika','60 mnt','Online','akan-datang'],
                    ['30 Apr · 09.00','Sinta Dewi','Fisika','90 mnt','Online','akan-datang'],
                    ['1 Mei · 14.00','Andi Pratama','Matematika','90 mnt','Online','akan-datang'],
                    ['2 Mei · 10.00','Siti Rahma','Fisika','60 mnt','Offline','akan-datang'],
                ];
                @endphp
                @foreach($semuaJadwal as $sj)
                <tr onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background=''">
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);font-size:12.5px;font-weight:700;color:var(--primary);">{{ $sj[0] }}</td>
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);font-size:13px;font-weight:600;">{{ $sj[1] }}</td>
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);">
                        <span style="background:#eff6ff;color:var(--primary);font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">{{ $sj[2] }}</span>
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);font-size:12.5px;color:var(--muted);">{{ $sj[3] }}</td>
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);">
                        <span style="background:{{ $sj[4] === 'Online' ? 'var(--success-soft)' : 'var(--info-soft)' }};color:{{ $sj[4] === 'Online' ? 'var(--success)' : 'var(--info)' }};font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">{{ $sj[4] }}</span>
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);">
                        @php
                        $stColors = ['selesai'=>['var(--success-soft)','var(--success)','Selesai'],'sedang'=>['var(--danger-soft)','var(--danger)','Sedang'],'akan-datang'=>['var(--accent-soft)','var(--warning)','Akan Datang']];
                        $sc = $stColors[$sj[5]];
                        @endphp
                        <span style="background:{{ $sc[0] }};color:{{ $sc[1] }};font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">{{ $sc[2] }}</span>
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid var(--border);">
                        <button onclick="openModalDetail()"
                            style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 12px;font-size:12px;font-weight:700;cursor:pointer;">
                            Detail
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══ MODAL TAMBAH JADWAL ══ --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-plus-circle-fill me-2" style="color:var(--primary);"></i>Tambah Jadwal</h5>
            <button class="modal-close-btn" onclick="closeModal('modal-tambah')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-p">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Siswa <span class="text-danger">*</span></label>
                    <select class="form-control-custom">
                        <option value="">-- Pilih Siswa --</option>
                        <option>Aldi Pratama</option>
                        <option>Sinta Dewi</option>
                        <option>Maya Putri</option>
                        <option>Rizky Aditya</option>
                        <option>Farhan Maulana</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Mata Pelajaran <span class="text-danger">*</span></label>
                    <select class="form-control-custom">
                        <option>Matematika</option>
                        <option>Fisika</option>
                        <option>Kimia</option>
                        <option>Biologi</option>
                        <option>Bahasa Inggris</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control-custom" value="{{ date('Y-m-d', strtotime('+1 day')) }}"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Waktu Mulai <span class="text-danger">*</span></label>
                    <input type="time" class="form-control-custom" value="09:00"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Durasi</label>
                    <select class="form-control-custom">
                        <option>60 Menit</option>
                        <option selected>90 Menit</option>
                        <option>120 Menit</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Mode</label>
                    <select class="form-control-custom">
                        <option>Online</option>
                        <option>Offline</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label-custom">Topik / Materi</label>
                    <input type="text" class="form-control-custom" placeholder="Contoh: Trigonometri – Identitas"/>
                </div>
                <div class="col-12">
                    <label class="form-label-custom">Catatan</label>
                    <textarea class="form-control-custom" rows="2" placeholder="Catatan untuk siswa…"></textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);"
                    onclick="closeModal('modal-tambah')">Batal</button>
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;border:none;">
                    <i class="bi bi-check2 me-1"></i> Simpan Jadwal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ MODAL DETAIL SESI ══ --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-calendar-event-fill me-2" style="color:var(--primary);"></i>Detail Sesi</h5>
            <button class="modal-close-btn" onclick="closeModal('modal-detail')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body-p">
            <div style="background:var(--bg);border-radius:12px;padding:16px;margin-bottom:16px;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                    <div style="width:48px;height:48px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;color:#fff;">A</div>
                    <div>
                        <div style="font-size:15px;font-weight:800;color:var(--text);">Aldi Pratama</div>
                        <div style="font-size:12px;color:var(--muted);">Siswa SMA</div>
                    </div>
                    <span style="background:var(--success-soft);color:var(--success);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;margin-left:auto;">Dikonfirmasi</span>
                </div>
                @php
                $detailRows = [
                    ['bi-book-fill','Mata Pelajaran','Matematika – Trigonometri'],
                    ['bi-calendar3','Jadwal','Rabu, 29 April 2026'],
                    ['bi-clock-fill','Waktu','08:00 WIB · 90 Menit'],
                    ['bi-laptop','Mode','Offline · Jl. Merdeka No.12'],
                    ['bi-cash-coin','Biaya','Rp 75.000'],
                ];
                @endphp
                @foreach($detailRows as $dr)
                <div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--border);">
                    <i class="bi {{ $dr[0] }}" style="color:var(--primary);font-size:14px;width:18px;flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <div style="font-size:11px;color:var(--muted);">{{ $dr[1] }}</div>
                        <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $dr[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label class="form-label-custom">Catatan Sesi</label>
                <textarea class="form-control-custom" rows="3" placeholder="Tambahkan catatan atau rekap sesi ini…"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--bg);color:var(--muted);border-radius:10px;border:1.5px solid var(--border);"
                    onclick="closeModal('modal-detail')">Tutup</button>
                <button class="btn fw-bold flex-fill py-2"
                    style="background:var(--success);color:#fff;border-radius:10px;border:none;">
                    <i class="bi bi-check2-circle me-1"></i> Tandai Selesai
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(el, id) {
        document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        ['hari-ini','kalender','permintaan','semua'].forEach(t => {
            document.getElementById('tab-'+t).style.display = t === id ? '' : 'none';
        });
    }
    function openModalTambah() { document.getElementById('modal-tambah').classList.add('show'); }
    function openModalDetail() { document.getElementById('modal-detail').classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }
    function selectCalDay(el) {
        document.querySelectorAll('.cal-day').forEach(d => d.classList.remove('selected'));
        if(!el.classList.contains('today')) el.classList.add('selected');
    }
    function changeMonth(dir) { /* bisa dikembangkan */ }

    // Countdown sesi berikutnya
    let sesiSec = 2*3600 + 28*60;
    setInterval(() => {
        if(sesiSec <= 0) return;
        sesiSec--;
        const h = Math.floor(sesiSec/3600).toString().padStart(2,'0');
        const m = Math.floor((sesiSec%3600)/60).toString().padStart(2,'0');
        const s = (sesiSec%60).toString().padStart(2,'0');
        const el = document.getElementById('countdown-sesi');
        if(el) el.textContent = h+':'+m+':'+s;
    }, 1000);
</script>
@endpush