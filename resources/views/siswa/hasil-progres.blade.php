@extends('layouts.app')

@section('title', 'Hasil & Progres - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Hasil & Progres Belajar')
@section('page-sub', 'Dashboard / Hasil & Progres')

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
    <a href="#" class="nav-item-custom">
        <i class="bi bi-bell-fill"></i> Notifikasi
        <span class="nav-badge">3</span>
    </a>
    <a href="/siswa/profil" class="nav-item-custom {{ request()->is('siswa/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
    <style>
        /* ── TABS ── */
        .main-tabs {
            display: flex;
            gap: 6px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 6px;
            margin: 20px 0;
        }

        .main-tab {
            flex: 1;
            text-align: center;
            padding: 9px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            color: var(--muted);
            border: none;
            background: transparent;
        }

        .main-tab.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 3px 10px rgba(30, 58, 95, .25);
        }

        .main-tab:hover:not(.active) {
            background: var(--bg);
            color: var(--primary);
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            height: 100%;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .stat-val {
            font-size: 26px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
            color: var(--text);
        }

        .stat-label {
            font-size: 12.5px;
            color: var(--muted);
        }

        .stat-change {
            font-size: 11.5px;
            font-weight: 600;
            margin-top: 8px;
        }

        .stat-change.up {
            color: var(--success);
        }

        .stat-change.down {
            color: var(--danger);
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title a {
            font-size: 12px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        /* ── CARD BOX ── */
        .card-box {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
        }

        /* ── MAPEL PROGRES ── */
        .mapel-row {
            margin-bottom: 14px;
        }

        .mapel-row:last-child {
            margin-bottom: 0;
        }

        .mapel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .mapel-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .mapel-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mapel-pct {
            font-size: 13px;
            font-weight: 800;
        }

        .mapel-trend {
            font-size: 11px;
            font-weight: 700;
        }

        .custom-bar {
            height: 8px;
            border-radius: 10px;
            background: var(--bg);
            overflow: hidden;
        }

        .custom-bar-fill {
            height: 100%;
            border-radius: 10px;
        }

        .mapel-detail {
            display: flex;
            gap: 12px;
            margin-top: 5px;
        }

        .mapel-detail span {
            font-size: 11px;
            color: var(--muted);
        }

        .mapel-detail strong {
            color: var(--text);
        }

        /* ── KUIS ROW ── */
        .kuis-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .kuis-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .kuis-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .ki-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .ki-sub {
            font-size: 11.5px;
            color: var(--muted);
        }

        .kuis-score {
            margin-left: auto;
            text-align: right;
            flex-shrink: 0;
        }

        .ks-val {
            font-size: 18px;
            font-weight: 800;
        }

        .ks-grade {
            font-size: 11px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 8px;
        }

        .ks-date {
            font-size: 10.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── KEMAMPUAN ── */
        .kemampuan-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .kemampuan-item {
            background: var(--bg);
            border-radius: 12px;
            padding: 12px 14px;
        }

        .ki-label {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
            color: var(--text);
        }

        .ki-label span {
            font-weight: 800;
            color: var(--primary);
        }

        .ki-bar {
            height: 6px;
            border-radius: 10px;
            background: var(--border);
            overflow: hidden;
        }

        .ki-bar-fill {
            height: 100%;
            border-radius: 10px;
        }

        /* ── ACHIEVEMENT ── */
        .achieve-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .achieve-card {
            background: var(--bg);
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            transition: transform .2s;
        }

        .achieve-card:hover {
            transform: translateY(-2px);
        }

        .achieve-card.unlocked {
            background: linear-gradient(135deg, var(--accent-soft), #fffbeb);
            border: 1px solid var(--accent);
        }

        .achieve-card.locked {
            opacity: .45;
            filter: grayscale(1);
        }

        .achieve-icon {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .achieve-title {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text);
        }

        .achieve-sub {
            font-size: 10px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── COMPARE ── */
        .compare-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .compare-label {
            font-size: 12.5px;
            font-weight: 600;
            min-width: 100px;
            color: var(--text);
        }

        .c-bar {
            height: 18px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            padding-left: 6px;
            font-size: 10.5px;
            font-weight: 700;
            color: #fff;
            transition: width .8s;
        }
    </style>
@endpush

@section('content')

    {{-- PAGE HEADER --}}
    <div class="d-flex align-items-start justify-content-between mb-1">
        <div>
            <h4 class="fw-bold mb-1">📊 Hasil & Progres Belajar</h4>
            <div style="font-size:13px;color:var(--muted);">
                Dashboard / <span style="color:var(--primary);font-weight:600;">Hasil & Progres</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm fw-bold"
                style="border-radius:10px;font-size:12px;border:1.5px solid var(--border);">
                <option>Bulan Ini</option>
                <option>3 Bulan Terakhir</option>
                <option>6 Bulan Terakhir</option>
            </select>
            <button class="btn btn-sm fw-bold px-3"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:12px;">
                <i class="bi bi-download me-1"></i> Unduh Laporan
            </button>
        </div>
    </div>

    {{-- TABS --}}
    <div class="main-tabs">
        <button class="main-tab active" onclick="switchTab(this,'ringkasan')"><i class="bi bi-grid me-1"></i>
            Ringkasan</button>
        <button class="main-tab" onclick="switchTab(this,'nilai')"><i class="bi bi-trophy me-1"></i> Nilai Kuis &
            Latihan</button>
        <button class="main-tab" onclick="switchTab(this,'progres')"><i class="bi bi-graph-up me-1"></i>
            Perkembangan</button>
        <button class="main-tab" onclick="switchTab(this,'kemampuan')"><i class="bi bi-stars me-1"></i> Kemampuan</button>
    </div>

    {{-- ══════ TAB: RINGKASAN ══════ --}}
    <div id="tab-ringkasan">

        {{-- STAT CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#eff6ff;color:var(--primary);"><i
                            class="bi bi-trophy-fill"></i></div>
                    <div class="stat-val">87</div>
                    <div class="stat-label">Rata-rata Nilai</div>
                    <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+5 dari bulan lalu</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background:var(--success-soft);color:var(--success);"><i
                            class="bi bi-check-circle-fill"></i></div>
                    <div class="stat-val">42</div>
                    <div class="stat-label">Latihan Selesai</div>
                    <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+12 minggu ini</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background:var(--info-soft);color:var(--info);"><i
                            class="bi bi-lightning-charge-fill"></i></div>
                    <div class="stat-val">18</div>
                    <div class="stat-label">Kuis Dikerjakan</div>
                    <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+4 dari bulan lalu</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);"><i
                            class="bi bi-clock-fill"></i></div>
                    <div class="stat-val">8.5<small style="font-size:14px;font-weight:500;">j</small></div>
                    <div class="stat-label">Total Jam Belajar</div>
                    <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+2j bulan ini</div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            {{-- GRAFIK AKTIVITAS --}}
            <div class="col-lg-8">
                <div class="card-box h-100">
                    <div class="section-title">
                        <span>📈 Aktivitas Belajar Mingguan</span>
                        <div class="d-flex gap-2">
                            <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                                <span
                                    style="width:10px;height:10px;border-radius:3px;background:var(--primary);display:inline-block;"></span>
                                Latihan
                            </span>
                            <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                                <span
                                    style="width:10px;height:10px;border-radius:3px;background:var(--accent);display:inline-block;"></span>
                                Kuis
                            </span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-end;gap:6px;height:150px;padding:0 4px;">
                        @php
                            $days = [
                                ['Sen', '3', '60px', '24px'],
                                ['Sel', '5', '90px', '30px'],
                                ['Rab', '2', '45px', '12px'],
                                ['Kam', '6', '105px', '30px'],
                                ['Jum', '4', '72px', '24px'],
                                ['Sab', '3', '54px', '18px'],
                                ['Min', '1', '18px', '6px'],
                            ];
                        @endphp
                        @foreach ($days as $day)
                            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;">
                                <span style="font-size:10px;font-weight:700;color:var(--muted);">{{ $day[1] }}</span>
                                <div style="width:100%;display:flex;flex-direction:column;align-items:center;gap:2px;">
                                    <div
                                        style="width:100%;height:{{ $day[2] }};background:var(--primary);border-radius:6px 6px 0 0;opacity:{{ $loop->last ? '.4' : '.85' }};">
                                    </div>
                                    <div
                                        style="width:100%;height:{{ $day[3] }};background:var(--accent);border-radius:0 0 6px 6px;opacity:{{ $loop->last ? '.4' : '.85' }};">
                                    </div>
                                </div>
                                <span style="font-size:10px;color:var(--muted);">{{ $day[0] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div style="text-align:center;font-size:11px;color:var(--muted);margin-top:8px;">Total 24 aktivitas
                        minggu ini · Rata-rata 3.4/hari</div>
                </div>
            </div>

            {{-- DISTRIBUSI NILAI --}}
            <div class="col-lg-4">
                <div class="card-box h-100">
                    <div class="section-title"><span>🎯 Distribusi Nilai</span></div>
                    <div class="text-center mb-3" style="position:relative;">
                        <svg viewBox="0 0 120 120" width="120" height="120" style="transform:rotate(-90deg);">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--border)"
                                stroke-width="16" />
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--primary)"
                                stroke-width="16" stroke-dasharray="126 188" stroke-linecap="round" />
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--info)"
                                stroke-width="16" stroke-dasharray="110 204" stroke-dashoffset="-126"
                                stroke-linecap="round" />
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--success)"
                                stroke-width="16" stroke-dasharray="47 267" stroke-dashoffset="-236"
                                stroke-linecap="round" />
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--accent)"
                                stroke-width="16" stroke-dasharray="31 283" stroke-dashoffset="-283"
                                stroke-linecap="round" />
                        </svg>
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                            <div style="font-size:20px;font-weight:800;color:var(--primary);">87</div>
                            <div style="font-size:10px;color:var(--muted);">Rata-rata</div>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                            <span
                                style="width:10px;height:10px;border-radius:3px;background:var(--primary);flex-shrink:0;"></span>
                            <span>Nilai A (87–100)</span><strong style="margin-left:auto;">40%</strong>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                            <span
                                style="width:10px;height:10px;border-radius:3px;background:var(--info);flex-shrink:0;"></span>
                            <span>Nilai B (70–86)</span><strong style="margin-left:auto;">35%</strong>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                            <span
                                style="width:10px;height:10px;border-radius:3px;background:var(--success);flex-shrink:0;"></span>
                            <span>Nilai C (55–69)</span><strong style="margin-left:auto;">15%</strong>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                            <span
                                style="width:10px;height:10px;border-radius:3px;background:var(--accent);flex-shrink:0;"></span>
                            <span>Nilai D (&lt;55)</span><strong style="margin-left:auto;">10%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PROGRES MAPEL + ACHIEVEMENT --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-7">
                <div class="card-box">
                    <div class="section-title"><span>📚 Progres per Mata Pelajaran</span></div>
                    @php
                        $mapels = [
                            [
                                '🔢 Matematika',
                                '82%',
                                '82',
                                'var(--primary)',
                                'linear-gradient(90deg,var(--primary),var(--primary-light))',
                                '+8%',
                                'up',
                                '156',
                                '128',
                                '88',
                            ],
                            [
                                '⚡ Fisika',
                                '68%',
                                '68',
                                'var(--info)',
                                'linear-gradient(90deg,var(--info),#67E8F9)',
                                '+5%',
                                'up',
                                '98',
                                '67',
                                '74',
                            ],
                            [
                                '🧪 Kimia',
                                '75%',
                                '75',
                                'var(--success)',
                                'linear-gradient(90deg,var(--success),#6EE7B7)',
                                '+3%',
                                'up',
                                '112',
                                '84',
                                '80',
                            ],
                            [
                                '🌿 Biologi',
                                '90%',
                                '90',
                                'var(--accent)',
                                'linear-gradient(90deg,var(--accent),#FCD34D)',
                                '+12%',
                                'up',
                                '134',
                                '121',
                                '92',
                            ],
                            [
                                '📝 B. Indonesia',
                                '55%',
                                '55',
                                'var(--danger)',
                                'linear-gradient(90deg,var(--danger),#FCA5A5)',
                                '-2%',
                                'down',
                                '76',
                                '42',
                                '61',
                            ],
                        ];
                    @endphp
                    @foreach ($mapels as $m)
                        <div class="mapel-row">
                            <div class="mapel-head">
                                <span class="mapel-name">{{ $m[0] }}</span>
                                <div class="mapel-right">
                                    <span class="mapel-trend {{ $m[6] }}"
                                        style="color:{{ $m[6] === 'up' ? 'var(--success)' : 'var(--danger)' }};">
                                        <i class="bi bi-arrow-{{ $m[6] }}-short"></i>{{ $m[5] }}
                                    </span>
                                    <span class="mapel-pct"
                                        style="color:{{ $m[3] }};">{{ $m[1] }}</span>
                                </div>
                            </div>
                            <div class="custom-bar">
                                <div class="custom-bar-fill"
                                    style="width:{{ $m[2] }}%;background:{{ $m[4] }};"></div>
                            </div>
                            <div class="mapel-detail">
                                <span>Soal: <strong>{{ $m[7] }}</strong></span>
                                <span>Benar: <strong>{{ $m[8] }}</strong></span>
                                <span>Rata-rata: <strong>{{ $m[9] }}</strong></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ACHIEVEMENT --}}
            <div class="col-lg-5">
                <div class="card-box">
                    <div class="section-title"><span>🏆 Pencapaian</span><a href="#">Lihat Semua</a></div>
                    <div class="achieve-grid">
                        <div class="achieve-card unlocked">
                            <div class="achieve-icon">🔥</div>
                            <div class="achieve-title">Streak 5 Hari</div>
                            <div class="achieve-sub">Belajar 5 hari berturut</div>
                        </div>
                        <div class="achieve-card unlocked">
                            <div class="achieve-icon">⭐</div>
                            <div class="achieve-title">Nilai Sempurna</div>
                            <div class="achieve-sub">Skor 100 di kuis</div>
                        </div>
                        <div class="achieve-card unlocked">
                            <div class="achieve-icon">📚</div>
                            <div class="achieve-title">Kutu Buku</div>
                            <div class="achieve-sub">Selesai 5 materi</div>
                        </div>
                        <div class="achieve-card unlocked">
                            <div class="achieve-icon">⚡</div>
                            <div class="achieve-title">Kilat!</div>
                            <div class="achieve-sub">Kuis &lt; 10 menit</div>
                        </div>
                        <div class="achieve-card locked">
                            <div class="achieve-icon">🥇</div>
                            <div class="achieve-title">Juara Mapel</div>
                            <div class="achieve-sub">Rata-rata 95+ semua</div>
                        </div>
                        <div class="achieve-card locked">
                            <div class="achieve-icon">🌙</div>
                            <div class="achieve-title">Belajar Malam</div>
                            <div class="achieve-sub">Latihan &gt; 22:00</div>
                        </div>
                    </div>
                    <div
                        style="text-align:center;font-size:12px;color:var(--muted);margin-top:12px;padding-top:10px;border-top:1px solid var(--border);">
                        4 dari 12 pencapaian terbuka ·
                        <span style="color:var(--primary);font-weight:700;cursor:pointer;">Lihat semua →</span>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /tab-ringkasan --}}

    {{-- ══════ TAB: NILAI ══════ --}}
    <div id="tab-nilai" style="display:none;">
        <div class="d-flex gap-2 mb-3 flex-wrap">
            <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
                <option>Semua Mapel</option>
                <option>Matematika</option>
                <option>Fisika</option>
                <option>Kimia</option>
            </select>
            <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
                <option>Semua Jenis</option>
                <option>Kuis</option>
                <option>Latihan Soal</option>
            </select>
            <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
                <option>Terbaru</option>
                <option>Nilai Tertinggi</option>
                <option>Nilai Terendah</option>
            </select>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="card-box">
                    <div class="section-title">
                        <span>📋 Riwayat Nilai</span>
                        <span style="font-size:12px;color:var(--muted);">18 hasil ditemukan</span>
                    </div>

                    @php
                        $riwayat = [
                            [
                                '#eff6ff',
                                'var(--primary)',
                                'bi-calculator-fill',
                                'Integral Tak Tentu & Tentu',
                                'Matematika · Latihan Soal · 15 soal · 18 menit',
                                '87',
                                'var(--primary)',
                                '#eff6ff',
                                'A',
                                '5 Apr 2026',
                            ],
                            [
                                'var(--success-soft)',
                                'var(--success)',
                                'bi-lightning-fill',
                                'Hukum Newton – Kuis Cepat',
                                'Fisika · Kuis · 10 soal · 8 menit',
                                '100',
                                'var(--success)',
                                'var(--success-soft)',
                                'A+',
                                '3 Apr 2026',
                            ],
                            [
                                'var(--info-soft)',
                                'var(--info)',
                                'bi-flask-fill',
                                'Laju Reaksi & Kesetimbangan',
                                'Kimia · Latihan Soal · 20 soal · 25 menit',
                                '73',
                                'var(--info)',
                                'var(--info-soft)',
                                'B',
                                '1 Apr 2026',
                            ],
                            [
                                'var(--accent-soft)',
                                'var(--warning)',
                                'bi-flower1',
                                'Sistem Reproduksi Manusia',
                                'Biologi · Kuis · 12 soal · 11 menit',
                                '92',
                                'var(--warning)',
                                'var(--accent-soft)',
                                'A',
                                '29 Mar 2026',
                            ],
                            [
                                'var(--danger-soft)',
                                'var(--danger)',
                                'bi-journal-text',
                                'Teks Argumentasi & Eksposisi',
                                'B. Indonesia · Latihan Soal · 15 soal · 20 menit',
                                '58',
                                'var(--danger)',
                                'var(--danger-soft)',
                                'C',
                                '27 Mar 2026',
                            ],
                            [
                                '#eff6ff',
                                'var(--primary)',
                                'bi-diagram-3-fill',
                                'Statistika & Peluang',
                                'Matematika · Latihan Soal · 25 soal · 30 menit',
                                '81',
                                'var(--primary)',
                                '#eff6ff',
                                'B+',
                                '25 Mar 2026',
                            ],
                        ];
                    @endphp

                    @foreach ($riwayat as $r)
                        <div class="kuis-row">
                            <div class="kuis-icon" style="background:{{ $r[0] }};color:{{ $r[1] }};"><i
                                    class="bi {{ $r[2] }}"></i></div>
                            <div>
                                <div class="ki-title">{{ $r[3] }}</div>
                                <div class="ki-sub">{{ $r[4] }}</div>
                            </div>
                            <div class="kuis-score">
                                <div class="ks-val" style="color:{{ $r[6] }};">{{ $r[5] }}</div>
                                <span class="ks-grade"
                                    style="background:{{ $r[7] }};color:{{ $r[6] }};">{{ $r[8] }}</span>
                                <div class="ks-date">{{ $r[9] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button class="btn btn-sm"
                        style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;"><i
                            class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-sm"
                        style="border-radius:8px;background:var(--primary);color:#fff;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:none;">1</button>
                    <button class="btn btn-sm"
                        style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;">2</button>
                    <button class="btn btn-sm"
                        style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;">3</button>
                    <button class="btn btn-sm"
                        style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;"><i
                            class="bi bi-chevron-right"></i></button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-box mb-3">
                    <div class="section-title mb-3"><span>📊 Statistik Nilai</span></div>
                    @php
                        $stats = [
                            ['Nilai Tertinggi', '100', 'var(--success)'],
                            ['Nilai Terendah', '52', 'var(--danger)'],
                            ['Nilai Rata-rata', '87', 'var(--primary)'],
                            ['Median', '85', 'var(--text)'],
                        ];
                    @endphp
                    @foreach ($stats as $s)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size:13px;color:var(--muted);">{{ $s[0] }}</span>
                            <span
                                style="font-size:16px;font-weight:800;color:{{ $s[2] }};">{{ $s[1] }}</span>
                        </div>
                    @endforeach
                    <div style="background:var(--bg);border-radius:10px;padding:10px 12px;margin-top:8px;">
                        <div style="font-size:11px;color:var(--muted);margin-bottom:8px;">Tren Nilai 6 Latihan Terakhir
                        </div>
                        <div style="display:flex;align-items:flex-end;gap:6px;height:50px;">
                            @php $bars = ['65','85','73','92','58','81']; @endphp
                            @foreach ($bars as $b)
                                <div
                                    style="flex:1;background:{{ $b == max($bars) ? 'var(--primary)' : 'var(--primary-light)' }};border-radius:4px 4px 0 0;height:{{ round(($b / 100) * 50) }}px;opacity:.85;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-box"
                    style="background:linear-gradient(135deg,var(--accent-soft),#fffbeb);border-color:var(--accent);">
                    <div style="font-size:13px;font-weight:800;color:var(--warning);margin-bottom:8px;">💡 Rekomendasi
                    </div>
                    <div style="font-size:12.5px;color:#78350F;line-height:1.6;">
                        Nilai <strong>Bahasa Indonesia</strong> kamu masih 58. Coba kerjakan lebih banyak latihan soal teks
                        dan minta sesi les privat dengan tutor.
                    </div>
                    <button class="btn btn-sm mt-2 fw-bold"
                        style="background:var(--warning);color:#fff;border-radius:8px;border:none;font-size:12px;">
                        <i class="bi bi-arrow-right me-1"></i> Mulai Latihan
                    </button>
                </div>
            </div>
        </div>
    </div>{{-- /tab-nilai --}}

    {{-- ══════ TAB: PERKEMBANGAN ══════ --}}
    <div id="tab-progres" style="display:none;">
        <div class="row g-3 mb-4">

            {{-- TREN NILAI --}}
            <div class="col-lg-8">
                <div class="card-box">
                    <div class="section-title">
                        <span>📈 Tren Nilai Bulanan</span>
                        <select class="form-select form-select-sm" style="width:auto;font-size:12px;border-radius:8px;">
                            <option>Matematika</option>
                            <option>Fisika</option>
                            <option>Kimia</option>
                        </select>
                    </div>
                    <div style="position:relative;height:140px;padding:0 8px;">
                        <svg viewBox="0 0 460 130" preserveAspectRatio="none" style="width:100%;height:100%;">
                            <line x1="0" y1="26" x2="460" y2="26" stroke="var(--border)"
                                stroke-width="1" />
                            <line x1="0" y1="52" x2="460" y2="52" stroke="var(--border)"
                                stroke-width="1" />
                            <line x1="0" y1="78" x2="460" y2="78" stroke="var(--border)"
                                stroke-width="1" />
                            <line x1="0" y1="104" x2="460" y2="104" stroke="var(--border)"
                                stroke-width="1" />
                            <path
                                d="M30,88 C80,80 130,72 180,70 C230,68 280,58 330,52 C380,46 430,36 450,32 L450,114 L30,114 Z"
                                fill="#1e3a5f" opacity="0.08" />
                            <path d="M30,88 C80,80 130,72 180,70 C230,68 280,58 330,52 C380,46 430,36 450,32"
                                fill="none" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" />
                            <circle cx="30" cy="88" r="4" fill="var(--primary)" />
                            <circle cx="107" cy="80" r="4" fill="var(--primary)" />
                            <circle cx="184" cy="70" r="4" fill="var(--primary)" />
                            <circle cx="261" cy="64" r="4" fill="var(--primary)" />
                            <circle cx="338" cy="52" r="4" fill="var(--primary)" />
                            <circle cx="450" cy="32" r="5" fill="#fff" stroke="var(--primary)"
                                stroke-width="2.5" />
                            <text x="22" y="126" font-size="9" fill="#94A3B8">Nov</text>
                            <text x="99" y="126" font-size="9" fill="#94A3B8">Des</text>
                            <text x="176" y="126" font-size="9" fill="#94A3B8">Jan</text>
                            <text x="253" y="126" font-size="9" fill="#94A3B8">Feb</text>
                            <text x="330" y="126" font-size="9" fill="#94A3B8">Mar</text>
                            <text x="438" y="126" font-size="9" fill="var(--primary)" font-weight="bold">Apr</text>
                            <text x="16" y="84" font-size="8" fill="var(--primary)">65</text>
                            <text x="93" y="76" font-size="8" fill="var(--primary)">70</text>
                            <text x="170" y="66" font-size="8" fill="var(--primary)">76</text>
                            <text x="247" y="60" font-size="8" fill="var(--primary)">79</text>
                            <text x="324" y="48" font-size="8" fill="var(--primary)">84</text>
                            <text x="434" y="28" font-size="8" fill="var(--primary)" font-weight="bold">87</text>
                        </svg>
                    </div>
                    <div style="text-align:center;font-size:11.5px;color:var(--muted);margin-top:4px;">
                        Peningkatan nilai Matematika: <strong style="color:var(--success);">+22 poin</strong> dalam 6 bulan
                        🎉
                    </div>
                </div>
            </div>

            {{-- PERBANDINGAN MAPEL --}}
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="section-title mb-3"><span>🆚 Perbandingan Mapel</span></div>
                    @php
                        $compares = [
                            ['Matematika', '82', 'var(--primary)', 'var(--primary-light)'],
                            ['Biologi', '90', 'var(--accent)', '#FCD34D'],
                            ['Kimia', '75', 'var(--success)', '#6EE7B7'],
                            ['Fisika', '68', 'var(--info)', '#67E8F9'],
                            ['B. Indonesia', '55', 'var(--danger)', '#FCA5A5'],
                        ];
                    @endphp
                    @foreach ($compares as $c)
                        <div class="compare-row">
                            <span class="compare-label">{{ $c[0] }}</span>
                            <div style="flex:1;">
                                <div class="c-bar"
                                    style="width:{{ $c[1] }}%;background:linear-gradient(90deg,{{ $c[2] }},{{ $c[3] }});">
                                    {{ $c[1] }}%</div>
                            </div>
                        </div>
                    @endforeach
                    <div style="margin-top:14px;padding:10px 12px;background:var(--bg);border-radius:10px;">
                        <div style="font-size:11.5px;color:var(--muted);">⚠️ <strong>Perlu Perhatian:</strong> B. Indonesia
                            masih di bawah target 70%.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JAM BELAJAR --}}
        <div class="card-box mb-4">
            <div class="section-title">
                <span>⏱️ Tren Jam Belajar per Minggu</span>
                <span style="font-size:12px;color:var(--muted);">Total: 8.5 jam bulan ini</span>
            </div>
            <div style="display:flex;align-items:flex-end;gap:10px;height:100px;padding:0 4px;">
                @php
                    $weeks = [
                        ['W1', '1.5j', '30'],
                        ['W2', '2j', '40'],
                        ['W3', '1.8j', '36'],
                        ['W4', '3.2j', '64'],
                        ['W5', '2.5j', '50'],
                        ['W6', '4j', '80'],
                        ['W7', '3.5j', '70'],
                        ['W8', '5j', '100'],
                    ];
                @endphp
                @foreach ($weeks as $w)
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <span
                            style="font-size:10px;color:{{ $loop->last ? 'var(--primary)' : 'var(--muted)' }};font-weight:{{ $loop->last ? '700' : '400' }};">{{ $w[1] }}</span>
                        <div
                            style="width:100%;height:{{ $w[2] }}%;background:{{ $loop->last ? 'linear-gradient(180deg,var(--primary),var(--primary-light))' : 'var(--primary-light)' }};border-radius:6px 6px 0 0;min-height:6px;opacity:{{ $loop->last ? '1' : '.7' }};">
                        </div>
                        <span
                            style="font-size:10px;color:{{ $loop->last ? 'var(--primary)' : 'var(--muted)' }};font-weight:{{ $loop->last ? '700' : '400' }};">{{ $w[0] }}</span>
                    </div>
                @endforeach
            </div>
            <div style="text-align:center;font-size:11px;color:var(--muted);margin-top:8px;">Minggu ke-8 adalah yang
                tertinggi bulan ini (5 jam)</div>
        </div>
    </div>{{-- /tab-progres --}}

    {{-- ══════ TAB: KEMAMPUAN ══════ --}}
    <div id="tab-kemampuan" style="display:none;">
        <div class="row g-3 mb-4">

            {{-- RADAR --}}
            <div class="col-lg-5">
                <div class="card-box text-center">
                    <div class="section-title justify-content-center mb-3"><span>🧠 Peta Kemampuan</span></div>
                    <svg viewBox="0 0 200 200" width="200" height="200" style="margin:0 auto;display:block;">
                        <polygon points="100,20 170,60 170,140 100,180 30,140 30,60" fill="none"
                            stroke="var(--border)" stroke-width="1" />
                        <polygon points="100,40 154,70 154,130 100,160 46,130 46,70" fill="none"
                            stroke="var(--border)" stroke-width="1" />
                        <polygon points="100,60 138,80 138,120 100,140 62,120 62,80" fill="none"
                            stroke="var(--border)" stroke-width="1" />
                        <polygon points="100,80 122,90 122,110 100,120 78,110 78,90" fill="none"
                            stroke="var(--border)" stroke-width="1" />
                        <line x1="100" y1="20" x2="100" y2="180" stroke="var(--border)"
                            stroke-width="1" />
                        <line x1="30" y1="60" x2="170" y2="140" stroke="var(--border)"
                            stroke-width="1" />
                        <line x1="170" y1="60" x2="30" y2="140" stroke="var(--border)"
                            stroke-width="1" />
                        <polygon points="100,38 150,78 138,118 100,131 62,122 55,75" fill="#1e3a5f" fill-opacity="0.15"
                            stroke="var(--primary)" stroke-width="2" />
                        <text x="100" y="14" font-size="9" fill="var(--text)" text-anchor="middle"
                            font-weight="bold">Matematika 82%</text>
                        <text x="178" y="58" font-size="9" fill="var(--text)" text-anchor="start"
                            font-weight="bold">Fisika 68%</text>
                        <text x="178" y="148" font-size="9" fill="var(--text)" text-anchor="start"
                            font-weight="bold">Kimia 75%</text>
                        <text x="100" y="196" font-size="9" fill="var(--text)" text-anchor="middle"
                            font-weight="bold">Biologi 90%</text>
                        <text x="22" y="148" font-size="9" fill="var(--text)" text-anchor="end"
                            font-weight="bold">B.Indo 55%</text>
                    </svg>
                </div>
            </div>

            {{-- DETAIL KEMAMPUAN --}}
            <div class="col-lg-7">
                <div class="card-box">
                    <div class="section-title"><span>🎯 Detail Kemampuan per Topik</span></div>
                    <div class="kemampuan-grid">
                        @php
                            $kemampuans = [
                                ['Kalkulus', '82', 'var(--primary)', 'var(--primary-light)'],
                                ['Aljabar', '90', 'var(--success)', '#6EE7B7'],
                                ['Trigonometri', '70', 'var(--info)', '#67E8F9'],
                                ['Statistika', '78', 'var(--primary-light)', '#C7D2FE'],
                                ['Mekanika', '65', 'var(--warning)', '#FCD34D'],
                                ['Termodinamika', '58', 'var(--accent)', '#FED7AA'],
                                ['Stoikiometri', '80', 'var(--success)', '#6EE7B7'],
                                ['Teks & Bacaan', '48', 'var(--danger)', '#FCA5A5'],
                            ];
                        @endphp
                        @foreach ($kemampuans as $k)
                            <div class="kemampuan-item">
                                <div class="ki-label">{{ $k[0] }} <span>{{ $k[1] }}%</span></div>
                                <div class="ki-bar">
                                    <div class="ki-bar-fill"
                                        style="width:{{ $k[1] }}%;background:linear-gradient(90deg,{{ $k[2] }},{{ $k[3] }});">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 p-3 rounded-3" style="background:var(--accent-soft);border:1px solid var(--accent);">
                        <div style="font-size:13px;font-weight:800;color:var(--warning);margin-bottom:6px;">🎯 Fokus
                            Belajar Minggu Ini</div>
                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <div style="font-size:12.5px;color:#78350F;display:flex;align-items:center;gap:8px;">
                                <span
                                    style="background:var(--danger);color:#fff;border-radius:6px;padding:1px 8px;font-size:11px;font-weight:700;">1</span>
                                Teks & Bacaan (B. Indonesia) – hanya 48%
                            </div>
                            <div style="font-size:12.5px;color:#78350F;display:flex;align-items:center;gap:8px;">
                                <span
                                    style="background:var(--warning);color:#fff;border-radius:6px;padding:1px 8px;font-size:11px;font-weight:700;">2</span>
                                Termodinamika (Fisika) – masih 58%
                            </div>
                            <div style="font-size:12.5px;color:#78350F;display:flex;align-items:center;gap:8px;">
                                <span
                                    style="background:var(--accent);color:var(--primary);border-radius:6px;padding:1px 8px;font-size:11px;font-weight:700;">3</span>
                                Mekanika (Fisika) – perlu ditingkatkan ke 70%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- /tab-kemampuan --}}

@endsection

@push('scripts')
    <script>
        function switchTab(el, id) {
            document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            ['ringkasan', 'nilai', 'progres', 'kemampuan'].forEach(t => {
                document.getElementById('tab-' + t).style.display = t === id ? '' : 'none';
            });
        }
    </script>
@endpush
