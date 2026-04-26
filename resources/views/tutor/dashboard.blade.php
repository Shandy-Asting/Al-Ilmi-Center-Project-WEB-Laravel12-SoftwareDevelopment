@extends('layouts.app')

@section('title', 'Dashboard Tutor - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Dashboard Tutor')
@section('page-sub', 'Selamat datang kembali, Pak Budi! 👋')

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
    /* ── STAT CARDS ── */
    .stat-card{background:var(--card-bg);border-radius:16px;padding:20px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:16px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
    .stat-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;}
    .stat-val{font-size:1.7rem;font-weight:800;line-height:1;color:var(--text);}
    .stat-label{font-size:.8rem;color:var(--muted);margin-top:4px;font-weight:500;}
    .stat-change{font-size:.75rem;font-weight:600;margin-top:8px;}
    .stat-change.up{color:var(--success);}
    .stat-change.down{color:var(--danger);}

    /* ── JADWAL ── */
    .schedule-item{display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid var(--border);transition:background .15s;}
    .schedule-item:last-child{border-bottom:none;}
    .schedule-item:hover{background:#f8faff;}
    .sched-time{min-width:80px;text-align:center;padding:8px 10px;background:var(--bg);border-radius:10px;}
    .time-main{font-size:.9rem;font-weight:700;color:var(--primary);}
    .time-dur{font-size:.7rem;color:var(--muted);}
    .sched-subject{font-weight:600;font-size:.88rem;color:var(--text);}
    .sched-student{font-size:.78rem;color:var(--muted);margin-top:2px;}
    .sched-mode{font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:20px;}
    .sched-mode.online{background:var(--success-soft);color:var(--success);}
    .sched-mode.offline{background:#f5f3ff;color:#6d28d9;}
    .btn-sched{width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);font-size:.85rem;transition:all .2s;}
    .btn-sched:hover{background:var(--primary);color:#fff;border-color:var(--primary);}

    /* ── AKTIVITAS ── */
    .activity-item{display:flex;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border);}
    .activity-item:last-child{border-bottom:none;}
    .act-dot{width:10px;height:10px;border-radius:50%;margin-top:5px;flex-shrink:0;}
    .act-text{font-size:.84rem;color:var(--text);}
    .act-text strong{font-weight:600;}
    .act-meta{font-size:.73rem;color:var(--muted);margin-top:3px;}

    /* ── PROGRESS ── */
    .progress-item{padding:12px 20px;border-bottom:1px solid var(--border);}
    .progress-item:last-child{border-bottom:none;}
    .progress-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;}
    .progress-label{font-size:.83rem;font-weight:500;color:var(--text);}
    .progress-pct{font-size:.78rem;font-weight:700;color:var(--primary);}
    .progress{height:7px;border-radius:10px;background:var(--border);}
    .progress-bar{border-radius:10px;}

    /* ── KALENDER ── */
    .mini-cal{padding:16px 20px;}
    .cal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
    .cal-title{font-weight:700;font-size:.92rem;color:var(--text);}
    .cal-nav{width:28px;height:28px;border-radius:8px;border:1px solid var(--border);background:var(--card-bg);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.75rem;color:var(--muted);transition:all .2s;}
    .cal-nav:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
    .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px;text-align:center;}
    .cal-day-name{font-size:.65rem;font-weight:700;color:var(--muted);text-transform:uppercase;padding:4px 0;}
    .cal-day{font-size:.78rem;padding:6px 4px;border-radius:8px;cursor:pointer;transition:all .15s;font-weight:500;color:var(--text);}
    .cal-day:hover{background:#eff6ff;color:var(--primary);}
    .cal-day.today{background:var(--primary);color:#fff;font-weight:700;}
    .cal-day.has-event{position:relative;}
    .cal-day.has-event::after{content:'';position:absolute;bottom:2px;left:50%;transform:translateX(-50%);width:4px;height:4px;border-radius:50%;background:var(--accent);}
    .cal-day.other-month{color:var(--border);}

    /* ── BADGE ── */
    .badge-subject{font-size:.7rem;padding:3px 9px;border-radius:20px;font-weight:600;background:#eff6ff;color:var(--primary);}

    /* ── CARD BOX ── */
    .card-box{background:var(--card-bg);border-radius:16px;border:1px solid var(--border);}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:.95rem;font-weight:700;color:var(--text);}
    .card-box-title i{color:var(--primary);margin-right:6px;}
</style>
@endpush

@section('content')

{{-- GREETING --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Selamat pagi, Pak Budi 👋</h4>
        <p style="font-size:.87rem;color:var(--muted);margin:0;">Berikut ringkasan aktivitas mengajar Anda hari ini.</p>
    </div>
    <a href="/tutor/jadwal" class="btn btn-sm fw-bold px-3 py-2"
        style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
    </a>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:var(--primary);"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
                <div class="stat-val">8</div>
                <div class="stat-label">Sesi Minggu Ini</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>2 dari minggu lalu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-val">14</div>
                <div class="stat-label">Total Siswa Aktif</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>3 siswa baru</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);"><i class="bi bi-star-fill"></i></div>
            <div>
                <div class="stat-val">4.8</div>
                <div class="stat-label">Rating Rata-rata</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>0.2 poin naik</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--info-soft);color:var(--info);"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-val">24 <span style="font-size:1rem;">jam</span></div>
                <div class="stat-label">Jam Mengajar Bulan Ini</div>
                <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>6 jam lebih</div>
            </div>
        </div>
    </div>
</div>

{{-- ROW 2: JADWAL + KALENDER --}}
<div class="row g-3 mb-4">

    {{-- JADWAL HARI INI --}}
    <div class="col-lg-8">
        <div class="card-box h-100">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-calendar3"></i> Jadwal Mengajar Hari Ini</div>
                <div class="d-flex align-items-center gap-2">
                    <span class="pill p-primary" style="font-size:.72rem;">5 Apr 2026</span>
                    <a href="/tutor/jadwal" class="btn btn-sm rounded-2"
                        style="background:#eff6ff;color:var(--primary);font-size:.75rem;font-weight:600;border:none;">
                        Lihat Semua
                    </a>
                </div>
            </div>

            @php
            $jadwals = [
                ['08.00','90 mnt','Matematika – Trigonometri','SMA','Aldi Pratama','Jl. Merdeka No.12','offline'],
                ['10.30','60 mnt','Fisika – Gerak Parabola','SMA','Sinta Dewi','Via Google Meet','online'],
                ['13.00','90 mnt','Kimia – Stoikiometri','SMA','Rizky Aditya','Jl. Kenanga No.5','offline'],
                ['15.30','60 mnt','Matematika – Integral','SMA','Maya Putri','Via Zoom','online'],
                ['17.00','60 mnt','Bahasa Inggris – Grammar','SMP','Farhan Maulana','Via Google Meet','online'],
            ];
            @endphp

            @foreach($jadwals as $j)
            <div class="schedule-item">
                <div class="sched-time">
                    <div class="time-main">{{ $j[0] }}</div>
                    <div class="time-dur">{{ $j[1] }}</div>
                </div>
                <div style="flex:1;">
                    <div class="sched-subject">
                        {{ $j[2] }}
                        <span class="badge-subject ms-1">{{ $j[3] }}</span>
                    </div>
                    <div class="sched-student">
                        <i class="bi bi-person-fill me-1"></i>{{ $j[4] }} &nbsp;·&nbsp;
                        <i class="bi bi-{{ $j[6] === 'online' ? 'camera-video-fill' : 'geo-alt-fill' }} me-1"></i>{{ $j[5] }}
                    </div>
                </div>
                <span class="sched-mode {{ $j[6] }}">{{ ucfirst($j[6]) }}</span>
                <div class="d-flex gap-1">
                    <button class="btn-sched" title="Detail"><i class="bi bi-eye"></i></button>
                    <button class="btn-sched" title="Mulai"><i class="bi bi-play-fill"></i></button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- KALENDER + RATING --}}
    <div class="col-lg-4 d-flex flex-column gap-3">
        <div class="card-box">
            <div class="mini-cal">
                <div class="cal-header">
                    <button class="cal-nav"><i class="bi bi-chevron-left"></i></button>
                    <div class="cal-title">April 2026</div>
                    <button class="cal-nav"><i class="bi bi-chevron-right"></i></button>
                </div>
                <div class="cal-grid">
                    @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $d)
                    <div class="cal-day-name">{{ $d }}</div>
                    @endforeach
                    @php
                    $days = [
                        ['30','other'],['1',''],['2','event'],['3','event'],['4',''],['5','today event'],['6',''],
                        ['7',''],['8','event'],['9','event'],['10',''],['11','event'],['12',''],['13',''],
                        ['14',''],['15','event'],['16','event'],['17','event'],['18',''],['19',''],['20',''],
                        ['21',''],['22','event'],['23',''],['24',''],['25','event'],['26',''],['27',''],
                        ['28',''],['29',''],['30',''],['1','other'],['2','other'],['3','other'],['4','other'],
                    ];
                    @endphp
                    @foreach($days as $day)
                    <div class="cal-day {{ str_contains($day[1],'other') ? 'other-month' : '' }} {{ str_contains($day[1],'today') ? 'today' : '' }} {{ str_contains($day[1],'event') ? 'has-event' : '' }}">
                        {{ $day[0] }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RATING --}}
        <div class="card-box p-3 text-center">
            <div style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:6px;">RATING ANDA</div>
            <div style="font-size:2rem;font-weight:800;color:var(--primary);">4.8</div>
            <div style="color:var(--accent);font-size:.85rem;">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
            </div>
            <div style="font-size:.75rem;color:var(--muted);margin-top:4px;">dari 48 ulasan siswa</div>
            <a href="#" class="btn btn-sm w-100 mt-3"
                style="background:#eff6ff;color:var(--primary);font-size:.78rem;font-weight:600;border-radius:8px;border:none;">
                Lihat Semua Ulasan
            </a>
        </div>
    </div>
</div>

{{-- ROW 3: AKTIVITAS + PROGRES SISWA --}}
<div class="row g-3">

    {{-- AKTIVITAS --}}
    <div class="col-lg-6">
        <div class="card-box h-100">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-activity"></i> Ringkasan Aktivitas</div>
                <span class="pill p-success" style="font-size:.72rem;"><i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Hari Ini</span>
            </div>

            @php
            $activities = [
                ['var(--success)','Sesi selesai','Matematika dengan Aldi Pratama','09.30 · Durasi 90 menit · Selesai tepat waktu','var(--success)'],
                ['var(--primary)','Feedback diberikan','kepada Sinta Dewi (Fisika)','11.45 · Nilai tugas: 85/100','var(--muted)'],
                ['var(--accent)','Materi baru diunggah','Ringkasan Integral Tentu','12.10 · PDF · 3 halaman','var(--muted)'],
                ['#6d28d9','Jadwal dikonfirmasi','Kimia dengan Rizky Aditya','13.00 · Offline · Jl. Kenanga No.5','var(--muted)'],
                ['var(--danger)','Permintaan reschedule','dari Farhan Maulana','14.22 · Perlu tindakan','var(--danger)'],
                ['var(--success)','Ulasan baru ★★★★★','dari orang tua Maya Putri','16.05 · Penjelasannya sangat jelas','var(--muted)'],
            ];
            @endphp

            @foreach($activities as $a)
            <div class="activity-item">
                <div class="act-dot" style="background:{{ $a[0] }};"></div>
                <div>
                    <div class="act-text"><strong>{{ $a[1] }}</strong> – {{ $a[2] }}</div>
                    <div class="act-meta" style="color:{{ $a[4] }};"><i class="bi bi-clock me-1"></i>{{ $a[3] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- PROGRES MATERI SISWA --}}
    <div class="col-lg-6">
        <div class="card-box h-100">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-graph-up-arrow"></i> Progres Materi Siswa</div>
                <a href="#" style="font-size:12px;color:var(--primary);font-weight:600;text-decoration:none;">Semua →</a>
            </div>

            @php
            $progres = [
                ['Aldi Pratama','Matematika SMA','82','var(--primary)','Bab 8 dari 10 · Trigonometri selesai'],
                ['Sinta Dewi','Fisika SMA','65','#6d28d9','Bab 6 dari 10 · Sedang: Gerak Parabola'],
                ['Rizky Aditya','Kimia SMA','50','var(--accent)','Bab 5 dari 10 · Sedang: Stoikiometri'],
                ['Maya Putri','Matematika SMA','90','var(--success)','Bab 9 dari 10 · Hampir selesai 🎉'],
                ['Farhan Maulana','B. Inggris SMP','40','var(--danger)','Bab 4 dari 10 · Perlu perhatian ekstra'],
            ];
            @endphp

            @foreach($progres as $p)
            <div class="progress-item">
                <div class="progress-row">
                    <div>
                        <span class="progress-label">{{ $p[0] }}</span>
                        <span class="badge-subject ms-2" style="font-size:.68rem;">{{ $p[1] }}</span>
                    </div>
                    <span class="progress-pct" style="color:{{ $p[3] }};">{{ $p[2] }}%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width:{{ $p[2] }}%;background:{{ $p[3] }};"></div>
                </div>
                <div style="font-size:.7rem;color:var(--muted);margin-top:4px;">{{ $p[4] }}</div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection