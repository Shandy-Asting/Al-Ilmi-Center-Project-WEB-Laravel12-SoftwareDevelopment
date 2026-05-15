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
        <div class="dropdown">
            <button class="btn btn-sm fw-bold px-3 dropdown-toggle"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:12px;"
                data-bs-toggle="dropdown">
                <i class="bi bi-download me-1"></i> Unduh Laporan
            </button>
            <ul class="dropdown-menu dropdown-menu-end"
                style="border-radius:10px;border:1px solid var(--border);padding:6px;">
                <li>
                    <a href="/siswa/hasil-progres/export-excel" class="dropdown-item"
                        style="border-radius:8px;font-size:13px;font-weight:600;">
                        <i class="bi bi-file-earmark-excel me-2" style="color:#16a34a;"></i> Download Excel
                    </a>
                </li>
                <li>
                    <a href="/siswa/hasil-progres/export-pdf" class="dropdown-item"
                        style="border-radius:8px;font-size:13px;font-weight:600;">
                        <i class="bi bi-file-earmark-pdf me-2" style="color:#dc2626;"></i> Download PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- TABS --}}
<div class="main-tabs">
    <button class="main-tab active" onclick="switchTab(this,'ringkasan')">
        <i class="bi bi-grid me-1"></i> Ringkasan
    </button>
    <button class="main-tab" onclick="switchTab(this,'nilai')">
        <i class="bi bi-trophy me-1"></i> Nilai Kuis & Latihan
    </button>
    <button class="main-tab" onclick="switchTab(this,'progres')">
        <i class="bi bi-graph-up me-1"></i> Perkembangan
    </button>
    <button class="main-tab" onclick="switchTab(this,'kemampuan')">
        <i class="bi bi-stars me-1"></i> Kemampuan
    </button>
</div>

{{-- ══════ TAB: RINGKASAN ══════ --}}
<div id="tab-ringkasan">

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="stat-val">{{ $rataRataNilai }}</div>
                <div class="stat-label">Rata-rata Nilai</div>
                <div class="stat-change {{ $selisihNilai >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $selisihNilai >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ $selisihNilai >= 0 ? '+' : '' }}{{ $selisihNilai }} dari bulan lalu
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--success-soft);color:var(--success);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-val">{{ $latihanSelesai }}</div>
                <div class="stat-label">Latihan Selesai</div>
                <div class="stat-change up">
                    <i class="bi bi-arrow-up-short"></i>+{{ $latihanMingguIni }} minggu ini
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--info-soft);color:var(--info);">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div class="stat-val">{{ $kuisDikerjakan }}</div>
                <div class="stat-label">Kuis Dikerjakan</div>
                <div class="stat-change {{ $selisihKuis >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ $selisihKuis >= 0 ? 'up' : 'down' }}-short"></i>
                    {{ $selisihKuis >= 0 ? '+' : '' }}{{ $selisihKuis }} dari bulan lalu
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--accent-soft);color:var(--warning);">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="stat-val">{{ $jamBelajar }}<small style="font-size:14px;font-weight:500;">j</small></div>
                <div class="stat-label">Total Jam Belajar</div>
                <div class="stat-change up">
                    <i class="bi bi-arrow-up-short"></i>+{{ $jamBulanIni }}j bulan ini
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- GRAFIK AKTIVITAS MINGGUAN --}}
        <div class="col-lg-8">
            <div class="card-box h-100">
                <div class="section-title">
                    <span>📈 Aktivitas Belajar Mingguan</span>
                    <div class="d-flex gap-2">
                        <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                            <span style="width:10px;height:10px;border-radius:3px;background:var(--primary);display:inline-block;"></span> Latihan
                        </span>
                        <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                            <span style="width:10px;height:10px;border-radius:3px;background:var(--accent);display:inline-block;"></span> Kuis
                        </span>
                    </div>
                </div>
                @php
                $maxAktivitas = max(array_map(fn($d) => max($d['latihan'] + $d['kuis'], 1), $aktivitasMingguan));
                @endphp
                <div style="display:flex;align-items:flex-end;gap:6px;height:150px;padding:0 4px;">
                    @foreach($aktivitasMingguan as $idx => $day)
                    @php
                    $totalH = $day['latihan'] + $day['kuis'];
                    $pctL = $maxAktivitas > 0 ? round(($day['latihan'] / $maxAktivitas) * 120) : 0;
                    $pctK = $maxAktivitas > 0 ? round(($day['kuis'] / $maxAktivitas) * 120) : 0;
                    $isLast = $idx === count($aktivitasMingguan) - 1;
                    @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;">
                        <span style="font-size:10px;font-weight:700;color:var(--muted);">{{ $totalH > 0 ? $totalH : '' }}</span>
                        <div style="width:100%;display:flex;flex-direction:column;align-items:center;gap:2px;">
                            <div style="width:100%;height:{{ max($pctL, 4) }}px;background:var(--primary);border-radius:6px 6px 0 0;opacity:{{ $isLast ? '.4' : '.85' }};"></div>
                            <div style="width:100%;height:{{ max($pctK, 2) }}px;background:var(--accent);border-radius:0 0 6px 6px;opacity:{{ $isLast ? '.4' : '.85' }};"></div>
                        </div>
                        <span style="font-size:10px;color:var(--muted);">{{ $day['hari'] }}</span>
                    </div>
                    @endforeach
                </div>
                <div style="text-align:center;font-size:11px;color:var(--muted);margin-top:8px;">
                    Total {{ $totalAktivitasMinggu }} aktivitas minggu ini · Rata-rata {{ $rataHari }}/hari
                </div>
            </div>
        </div>

        {{-- DISTRIBUSI NILAI --}}
        <div class="col-lg-4">
            <div class="card-box h-100">
                <div class="section-title"><span>🎯 Distribusi Nilai</span></div>
                @php
                // Hitung dasharray untuk SVG donut (keliling r=50 → 314)
                $keliling = 314;
                $offsetA = 0;
                $dashA = round($distribusi['A'] / 100 * $keliling);
                $offsetB = -$dashA;
                $dashB = round($distribusi['B'] / 100 * $keliling);
                $offsetC = -($dashA + $dashB);
                $dashC = round($distribusi['C'] / 100 * $keliling);
                $offsetD = -($dashA + $dashB + $dashC);
                $dashD = round($distribusi['D'] / 100 * $keliling);
                @endphp
                <div class="text-center mb-3" style="position:relative;">
                    <svg viewBox="0 0 120 120" width="120" height="120" style="transform:rotate(-90deg);">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--border)" stroke-width="16" />
                        @if($distribusi['A'] > 0)
                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--primary)" stroke-width="16"
                            stroke-dasharray="{{ $dashA }} {{ $keliling - $dashA }}" stroke-linecap="round" />
                        @endif
                        @if($distribusi['B'] > 0)
                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--info)" stroke-width="16"
                            stroke-dasharray="{{ $dashB }} {{ $keliling - $dashB }}"
                            stroke-dashoffset="{{ $offsetB }}" stroke-linecap="round" />
                        @endif
                        @if($distribusi['C'] > 0)
                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--success)" stroke-width="16"
                            stroke-dasharray="{{ $dashC }} {{ $keliling - $dashC }}"
                            stroke-dashoffset="{{ $offsetC }}" stroke-linecap="round" />
                        @endif
                        @if($distribusi['D'] > 0)
                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--accent)" stroke-width="16"
                            stroke-dasharray="{{ $dashD }} {{ $keliling - $dashD }}"
                            stroke-dashoffset="{{ $offsetD }}" stroke-linecap="round" />
                        @endif
                    </svg>
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                        <div style="font-size:20px;font-weight:800;color:var(--primary);">{{ $rataRataNilai }}</div>
                        <div style="font-size:10px;color:var(--muted);">Rata-rata</div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                        <span style="width:10px;height:10px;border-radius:3px;background:var(--primary);flex-shrink:0;"></span>
                        <span>Nilai A (87–100)</span><strong style="margin-left:auto;">{{ $distribusi['A'] }}%</strong>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                        <span style="width:10px;height:10px;border-radius:3px;background:var(--info);flex-shrink:0;"></span>
                        <span>Nilai B (70–86)</span><strong style="margin-left:auto;">{{ $distribusi['B'] }}%</strong>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                        <span style="width:10px;height:10px;border-radius:3px;background:var(--success);flex-shrink:0;"></span>
                        <span>Nilai C (55–69)</span><strong style="margin-left:auto;">{{ $distribusi['C'] }}%</strong>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;">
                        <span style="width:10px;height:10px;border-radius:3px;background:var(--accent);flex-shrink:0;"></span>
                        <span>Nilai D (&lt;55)</span><strong style="margin-left:auto;">{{ $distribusi['D'] }}%</strong>
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
                $warnaMapel = [
                'matematika' => ['var(--primary)', 'linear-gradient(90deg,var(--primary),var(--primary-light))'],
                'fisika' => ['var(--info)', 'linear-gradient(90deg,var(--info),#67E8F9)'],
                'kimia' => ['var(--success)', 'linear-gradient(90deg,var(--success),#6EE7B7)'],
                'biologi' => ['var(--accent)', 'linear-gradient(90deg,var(--accent),#FCD34D)'],
                'b. indonesia' => ['var(--danger)', 'linear-gradient(90deg,var(--danger),#FCA5A5)'],
                'bahasa indonesia'=> ['var(--danger)', 'linear-gradient(90deg,var(--danger),#FCA5A5)'],
                'b. inggris' => ['var(--warning)', 'linear-gradient(90deg,var(--warning),#FCD34D)'],
                'bahasa inggris' => ['var(--warning)', 'linear-gradient(90deg,var(--warning),#FCD34D)'],
                ];
                $defaultWarna = ['var(--primary-light)', 'linear-gradient(90deg,var(--primary-light),#C7D2FE)'];
                $emojiMapel = [
                'matematika' => '🔢', 'fisika' => '⚡', 'kimia' => '🧪',
                'biologi' => '🌿', 'b. indonesia' => '📝', 'bahasa indonesia' => '📝',
                'b. inggris' => '🌍', 'bahasa inggris' => '🌍',
                ];
                @endphp
                @forelse($progresMapel as $namaMapel => $data)
                @php
                $key = strtolower($namaMapel);
                $warna = $warnaMapel[$key] ?? $defaultWarna;
                $emoji = $emojiMapel[$key] ?? '📖';
                $trend = rand(-5, 12); // bisa diganti dengan perhitungan real
                @endphp
                <div class="mapel-row">
                    <div class="mapel-head">
                        <span class="mapel-name">{{ $emoji }} {{ $namaMapel }}</span>
                        <div class="mapel-right">
                            <span class="mapel-pct" style="color:{{ $warna[0] }};">{{ $data['pct'] }}%</span>
                        </div>
                    </div>
                    <div class="custom-bar">
                        <div class="custom-bar-fill" style="width:{{ $data['pct'] }}%;background:{{ $warna[1] }};"></div>
                    </div>
                    <div class="mapel-detail">
                        <span>Soal: <strong>{{ $data['totalSoal'] }}</strong></span>
                        <span>Benar: <strong>{{ $data['totalBenar'] }}</strong></span>
                        <span>Rata-rata: <strong>{{ $data['rata'] }}</strong></span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:30px;color:var(--muted);font-size:13px;">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    Belum ada data. Mulai kerjakan latihan soal!
                </div>
                @endforelse
            </div>
        </div>

        {{-- ACHIEVEMENT --}}
        <div class="col-lg-5">
            <div class="card-box">
                <div class="section-title"><span>🏆 Pencapaian</span></div>
                @php
                $achievements = [
                ['🔥', 'Streak 5 Hari', 'Belajar 5 hari berturut', $totalAktivitasMinggu >= 5],
                ['⭐', 'Nilai Sempurna', 'Skor 100 di kuis', \App\Models\HasilKuis::where('user_id', auth()->id())->where('nilai', 100)->exists()],
                ['📚', 'Kutu Buku', 'Selesai 5 materi', $latihanSelesai >= 5],
                ['⚡', 'Kilat!', 'Kuis < 10 menit', \App\Models\HasilKuis::where('user_id', auth()->id())->where('tipe','kuis')->where('durasi_menit','<',10)->where('durasi_menit','>',0)->exists()],
                        ['🥇', 'Juara Mapel', 'Rata-rata 95+ semua', $rataRataNilai >= 95],
                        ['🌙', 'Belajar Malam', 'Latihan > 22:00', \App\Models\HasilKuis::where('user_id', auth()->id())->whereTime('created_at','>=','22:00:00')->exists()],
                        ];
                        $unlocked = collect($achievements)->filter(fn($a) => $a[3])->count();
                        @endphp
                        <div class="achieve-grid">
                            @foreach($achievements as $a)
                            <div class="achieve-card {{ $a[3] ? 'unlocked' : 'locked' }}">
                                <div class="achieve-icon">{{ $a[0] }}</div>
                                <div class="achieve-title">{{ $a[1] }}</div>
                                <div class="achieve-sub">{{ $a[2] }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div style="text-align:center;font-size:12px;color:var(--muted);margin-top:12px;padding-top:10px;border-top:1px solid var(--border);">
                            {{ $unlocked }} dari {{ count($achievements) }} pencapaian terbuka
                        </div>
            </div>
        </div>
    </div>
</div>{{-- /tab-ringkasan --}}

{{-- ══════ TAB: NILAI ══════ --}}
<div id="tab-nilai" style="display:none;">
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card-box">
                <div class="section-title">
                    <span>📋 Riwayat Nilai</span>
                    <span style="font-size:12px;color:var(--muted);">{{ $riwayatNilai->total() }} hasil ditemukan</span>
                </div>
                @php
                $ikonMapelNilai = [
                'matematika' => ['bi-calculator-fill', '#eff6ff', 'var(--primary)'],
                'fisika' => ['bi-lightning-fill', 'var(--info-soft)', 'var(--info)'],
                'kimia' => ['bi-flask-fill', 'var(--success-soft)','var(--success)'],
                'biologi' => ['bi-flower1', 'var(--accent-soft)', 'var(--warning)'],
                'b. indonesia' => ['bi-journal-text', 'var(--danger-soft)', 'var(--danger)'],
                'bahasa indonesia'=> ['bi-journal-text', 'var(--danger-soft)', 'var(--danger)'],
                ];
                $defIkon = ['bi-book-fill','#f1f5f9','#64748b'];
                @endphp
                @forelse($riwayatNilai as $h)
                @php
                $mapelKey = strtolower($h->materi->mata_pelajaran ?? '');
                $ik = $ikonMapelNilai[$mapelKey] ?? $defIkon;
                $grade = $h->nilai >= 87 ? 'A' : ($h->nilai >= 70 ? 'B' : ($h->nilai >= 55 ? 'C' : 'D'));
                $gradeColor = $h->nilai >= 87 ? 'var(--primary)' : ($h->nilai >= 70 ? 'var(--info)' : ($h->nilai >= 55 ? 'var(--warning)' : 'var(--danger)'));
                $gradeBg = $h->nilai >= 87 ? '#eff6ff' : ($h->nilai >= 70 ? 'var(--info-soft)' : ($h->nilai >= 55 ? 'var(--accent-soft)' : 'var(--danger-soft)'));
                @endphp
                <div class="kuis-row">
                    <div class="kuis-icon" style="background:{{ $ik[1] }};color:{{ $ik[2] }};">
                        <i class="bi {{ $ik[0] }}"></i>
                    </div>
                    <div>
                        <div class="ki-title">{{ $h->materi->judul ?? 'Materi Dihapus' }}</div>
                        <div class="ki-sub">
                            {{ $h->materi->mata_pelajaran ?? '-' }} ·
                            {{ ucfirst($h->tipe) }} ·
                            {{ $h->total_soal }} soal ·
                            {{ $h->durasi_menit }} menit
                        </div>
                    </div>
                    <div class="kuis-score">
                        <div class="ks-val" style="color:{{ $gradeColor }};">{{ $h->nilai }}</div>
                        <span class="ks-grade" style="background:{{ $gradeBg }};color:{{ $gradeColor }};">{{ $grade }}</span>
                        <div class="ks-date">{{ $h->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:30px;color:var(--muted);font-size:13px;">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    Belum ada riwayat nilai.
                </div>
                @endforelse

                {{-- PAGINATION --}}
                @if($riwayatNilai->hasPages())
                <div class="d-flex justify-content-center gap-2 mt-3">
                    @if($riwayatNilai->onFirstPage())
                    <button class="btn btn-sm" style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;" disabled>
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    @else
                    <a href="{{ $riwayatNilai->previousPageUrl() }}#tab-nilai" class="btn btn-sm" style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    @endif
                    @foreach($riwayatNilai->getUrlRange(1, $riwayatNilai->lastPage()) as $page => $url)
                    <a href="{{ $url }}#tab-nilai" class="btn btn-sm" style="border-radius:8px;{{ $page == $riwayatNilai->currentPage() ? 'background:var(--primary);color:#fff;border:none;' : 'border:1.5px solid var(--border);background:#fff;color:var(--muted);' }}width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                        {{ $page }}
                    </a>
                    @endforeach
                    @if($riwayatNilai->hasMorePages())
                    <a href="{{ $riwayatNilai->nextPageUrl() }}#tab-nilai" class="btn btn-sm" style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    @else
                    <button class="btn btn-sm" style="border-radius:8px;border:1.5px solid var(--border);background:#fff;color:var(--muted);width:32px;height:32px;display:flex;align-items:center;justify-content:center;" disabled>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-box mb-3">
                <div class="section-title mb-3"><span>📊 Statistik Nilai</span></div>
                @php
                $statsNilai = [
                ['Nilai Tertinggi', $nilaiTertinggi, 'var(--success)'],
                ['Nilai Terendah', $nilaiTerendah, 'var(--danger)'],
                ['Nilai Rata-rata', $rataRataNilai, 'var(--primary)'],
                ['Total Dikerjakan',$totalHasil, 'var(--text)'],
                ];
                @endphp
                @foreach($statsNilai as $s)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span style="font-size:13px;color:var(--muted);">{{ $s[0] }}</span>
                    <span style="font-size:16px;font-weight:800;color:{{ $s[2] }};">{{ $s[1] }}</span>
                </div>
                @endforeach
                <div style="background:var(--bg);border-radius:10px;padding:10px 12px;margin-top:8px;">
                    <div style="font-size:11px;color:var(--muted);margin-bottom:8px;">Tren Nilai 6 Terakhir</div>
                    @php $maxTren = $tren6Terakhir->max() ?: 100; @endphp
                    <div style="display:flex;align-items:flex-end;gap:6px;height:50px;">
                        @forelse($tren6Terakhir as $b)
                        <div style="flex:1;background:{{ $b == $maxTren ? 'var(--primary)' : 'var(--primary-light)' }};border-radius:4px 4px 0 0;height:{{ round(($b/$maxTren)*50) }}px;opacity:.85;" title="{{ $b }}"></div>
                        @empty
                        <div style="flex:1;font-size:11px;color:var(--muted);text-align:center;align-self:center;">Belum ada data</div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($rekomendasiMapel)
            <div class="card-box" style="background:linear-gradient(135deg,var(--accent-soft),#fffbeb);border-color:var(--accent);">
                <div style="font-size:13px;font-weight:800;color:var(--warning);margin-bottom:8px;">💡 Rekomendasi</div>
                <div style="font-size:12.5px;color:#78350F;line-height:1.6;">
                    Nilai <strong>{{ $rekomendasiMapel['nama'] }}</strong> kamu masih {{ $rekomendasiMapel['rata'] }}.
                    Coba kerjakan lebih banyak latihan soal!
                </div>
                <a href="/siswa/belajar-tka" class="btn btn-sm mt-2 fw-bold"
                    style="background:var(--warning);color:#fff;border-radius:8px;border:none;font-size:12px;">
                    <i class="bi bi-arrow-right me-1"></i> Mulai Latihan
                </a>
            </div>
            @endif
        </div>
    </div>
</div>{{-- /tab-nilai --}}

{{-- ══════ TAB: PERKEMBANGAN ══════ --}}
<div id="tab-progres" style="display:none;">
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card-box">
                <div class="section-title">
                    <span>📈 Tren Nilai per Pengerjaan</span>
                </div>
                @php
                $trenNilai = \App\Models\HasilKuis::where('user_id', auth()->id())
                ->orderBy('created_at','asc')->take(10)
                ->pluck('nilai')->values();
                $maxTrenNilai = $trenNilai->max() ?: 100;
                $svgW = 460; $svgH = 130;
                $points = [];
                $count = $trenNilai->count();
                foreach($trenNilai as $idx => $val) {
                $x = $count > 1 ? round(30 + ($idx / ($count-1)) * ($svgW-60)) : $svgW/2;
                $y = round($svgH - 20 - (($val/$maxTrenNilai) * ($svgH-40)));
                $points[] = "$x,$y";
                }
                $polyline = implode(' ', $points);
                @endphp
                @if($trenNilai->count() >= 2)
                <div style="position:relative;height:140px;padding:0 8px;">
                    <svg viewBox="0 0 {{ $svgW }} {{ $svgH }}" preserveAspectRatio="none" style="width:100%;height:100%;">
                        <line x1="0" y1="26" x2="{{ $svgW }}" y2="26" stroke="var(--border)" stroke-width="1" />
                        <line x1="0" y1="52" x2="{{ $svgW }}" y2="52" stroke="var(--border)" stroke-width="1" />
                        <line x1="0" y1="78" x2="{{ $svgW }}" y2="78" stroke="var(--border)" stroke-width="1" />
                        <line x1="0" y1="104" x2="{{ $svgW }}" y2="104" stroke="var(--border)" stroke-width="1" />
                        <polyline points="{{ $polyline }}" fill="none" stroke="var(--primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        @foreach($trenNilai as $idx => $val)
                        @php
                        $px = $count > 1 ? round(30 + ($idx / ($count-1)) * ($svgW-60)) : $svgW/2;
                        $py = round($svgH - 20 - (($val/$maxTrenNilai) * ($svgH-40)));
                        @endphp
                        <circle cx="{{ $px }}" cy="{{ $py }}" r="{{ $loop->last ? 5 : 4 }}" fill="{{ $loop->last ? '#fff' : 'var(--primary)' }}" stroke="var(--primary)" stroke-width="2" />
                        <text x="{{ $px }}" y="{{ $py - 8 }}" font-size="8" fill="var(--primary)" text-anchor="middle">{{ $val }}</text>
                        @endforeach
                    </svg>
                </div>
                @else
                <div style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">
                    Kerjakan minimal 2 latihan untuk melihat tren nilai.
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-box">
                <div class="section-title mb-3"><span>🆚 Perbandingan Mapel</span></div>
                @php
                $warnaBar = ['var(--primary)','var(--accent)','var(--success)','var(--info)','var(--danger)'];
                $idx = 0;
                @endphp
                @forelse($progresMapel as $nm => $data)
                <div class="compare-row">
                    <span class="compare-label">{{ Str::limit($nm, 12) }}</span>
                    <div style="flex:1;">
                        <div class="c-bar" style="width:{{ $data['pct'] }}%;background:{{ $warnaBar[$idx % count($warnaBar)] }};">
                            {{ $data['pct'] }}%
                        </div>
                    </div>
                </div>
                @php $idx++; @endphp
                @empty
                <div style="font-size:13px;color:var(--muted);text-align:center;padding:20px;">Belum ada data.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- JAM BELAJAR --}}
    <div class="card-box mb-4">
        <div class="section-title">
            <span>⏱️ Tren Jam Belajar per Minggu</span>
            <span style="font-size:12px;color:var(--muted);">Total: {{ $jamBelajar }} jam</span>
        </div>
        <div style="display:flex;align-items:flex-end;gap:10px;height:100px;padding:0 4px;">
            @foreach($trenJam as $w)
            @php
            $pct = $maxJam > 0 ? round(($w['menit'] / $maxJam) * 90) : 6;
            $isLast = $loop->last;
            @endphp
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                <span style="font-size:10px;color:{{ $isLast ? 'var(--primary)' : 'var(--muted)' }};font-weight:{{ $isLast ? '700' : '400' }};">{{ $w['jam'] }}j</span>
                <div style="width:100%;height:{{ max($pct, 6) }}px;background:{{ $isLast ? 'linear-gradient(180deg,var(--primary),var(--primary-light))' : 'var(--primary-light)' }};border-radius:6px 6px 0 0;min-height:6px;opacity:{{ $isLast ? '1' : '.7' }};"></div>
                <span style="font-size:10px;color:{{ $isLast ? 'var(--primary)' : 'var(--muted)' }};font-weight:{{ $isLast ? '700' : '400' }};">{{ $w['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>{{-- /tab-progres --}}

{{-- ══════ TAB: KEMAMPUAN ══════ --}}
<div id="tab-kemampuan" style="display:none;">
    <div class="row g-3 mb-4">
        <div class="col-lg-5">
            <div class="card-box text-center">
                <div class="section-title justify-content-center mb-3"><span>🧠 Peta Kemampuan</span></div>
                @php
                $mapelList = collect($progresMapel)->take(6)->values();
                $total6 = $mapelList->count();
                $radarPoints = [];
                $cx = 100; $cy = 100; $r = 70;
                for ($i = 0; $i
                < $total6; $i++) {
                    $angle=deg2rad(-90 + ($i * 360 / max($total6, 1)));
                    $val=($mapelList[$i]['pct'] ?? 0) / 100;
                    $radarPoints[]=round($cx + $r * $val * cos($angle)) . ',' . round($cy + $r * $val * sin($angle));
                    }
                    $radarPoly=implode(' ', $radarPoints);
                @endphp
                <svg viewBox="0 0 200 200" width="200" height="200" style="margin:0 auto;display:block;">
                    @for($ring = 4; $ring >= 1; $ring--)
                    @php
                        $rPts = [];
                        for ($i = 0; $i < max($total6,1); $i++) {
                            $angle = deg2rad(-90 + ($i * 360 / max($total6,1)));
                            $rPts[] = round($cx + ($r * $ring/4) * cos($angle)) . ' ,' . round($cy + ($r * $ring/4) * sin($angle));
                    }
                    @endphp
                    <polygon points="{{ implode(' ', $rPts) }}" fill="none" stroke="var(--border)" stroke-width="1" />
                @endfor
                @for($i = 0; $i
                < $total6; $i++)
                    @php
                    $angle=deg2rad(-90 + ($i * 360 / max($total6,1)));
                    $ex=round($cx + $r * cos($angle));
                    $ey=round($cy + $r * sin($angle));
                    @endphp
                    <line x1="{{ $cx }}" y1="{{ $cy }}" x2="{{ $ex }}" y2="{{ $ey }}" stroke="var(--border)" stroke-width="1" />
                @endfor
                @if(count($radarPoints) >= 3)
                <polygon points="{{ $radarPoly }}" fill="#1e3a5f" fill-opacity="0.15" stroke="var(--primary)" stroke-width="2" />
                @endif
                @foreach($mapelList as $i => $mp)
                @php
                $angle = deg2rad(-90 + ($i * 360 / max($total6,1)));
                $lx = round($cx + ($r + 18) * cos($angle));
                $ly = round($cy + ($r + 18) * sin($angle));
                @endphp
                <text x="{{ $lx }}" y="{{ $ly }}" font-size="7" fill="var(--text)" text-anchor="middle" font-weight="bold">{{ Str::limit($mp['nama'],8) }} {{ $mp['pct'] }}%</text>
                @endforeach
                </svg>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card-box">
                <div class="section-title"><span>🎯 Detail Kemampuan per Mata Pelajaran</span></div>
                @php
                $warnaKemampuan = [
                ['var(--primary)', 'var(--primary-light)'],
                ['var(--success)', '#6EE7B7'],
                ['var(--info)', '#67E8F9'],
                ['var(--accent)', '#FCD34D'],
                ['var(--danger)', '#FCA5A5'],
                ['var(--warning)', '#FED7AA'],
                ['var(--primary-light)', '#C7D2FE'],
                ['#0d9488', '#6EE7B7'],
                ];
                $ki = 0;
                @endphp
                <div class="kemampuan-grid">
                    @forelse($kemampuanTopik as $topik => $nilai)
                    @php $wk = $warnaKemampuan[$ki % count($warnaKemampuan)]; $ki++; @endphp
                    <div class="kemampuan-item">
                        <div class="ki-label">{{ Str::limit($topik, 18) }} <span>{{ $nilai }}%</span></div>
                        <div class="ki-bar">
                            <div class="ki-bar-fill" style="width:{{ $nilai }}%;background:linear-gradient(90deg,{{ $wk[0] }},{{ $wk[1] }});"></div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column:span 2;text-align:center;padding:20px;color:var(--muted);font-size:13px;">
                        Belum ada data kemampuan.
                    </div>
                    @endforelse
                </div>

                @if($rekomendasiMapel)
                <div class="mt-3 p-3 rounded-3" style="background:var(--accent-soft);border:1px solid var(--accent);">
                    <div style="font-size:13px;font-weight:800;color:var(--warning);margin-bottom:6px;">🎯 Fokus Belajar</div>
                    <div style="font-size:12.5px;color:#78350F;">
                        Prioritas: <strong>{{ $rekomendasiMapel['nama'] }}</strong> – rata-rata {{ $rekomendasiMapel['rata'] }}. Perlu ditingkatkan!
                    </div>
                </div>
                @endif
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

    // Buka tab yang benar jika ada anchor #tab-nilai di URL
    document.addEventListener('DOMContentLoaded', () => {
        if (window.location.hash === '#tab-nilai') {
            document.querySelectorAll('.main-tab')[1].click();
        }
    });
</script>
@endpush