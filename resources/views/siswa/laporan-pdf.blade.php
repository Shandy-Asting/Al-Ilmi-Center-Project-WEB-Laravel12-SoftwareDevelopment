<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <title>Rapor Hasil Belajar – Al Ilmi Center</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.5pt;
            color: #0f172a;
            background: #ffffff;
            line-height: 1.4;
        }

        .cover-top {
            width: 100%;
            border-collapse: collapse;
            background-color: #0f172a;
        }

        .brand {
            font-size: 18pt;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 0.3px;
        }

        .brand-sub {
            font-size: 8.5pt;
            color: #94a3b8;
            margin-top: 3px;
        }

        .cover-meta {
            text-align: right;
            font-size: 8pt;
            color: #94a3b8;
            line-height: 1.9;
        }

        .cover-meta strong { color: #e2e8f0; }

        .accent-bar {
            height: 4px;
            background-color: #3b82f6;
            width: 100%;
        }

        .cover-title-wrap {
            background-color: #1e293b;
            text-align: center;
            padding: 12px 24px 16px;
        }

        .cover-title {
            font-size: 13pt;
            font-weight: bold;
            color: #f1f5f9;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .cover-subtitle {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 4px;
        }

        .accent-bar-bottom {
            height: 3px;
            background-color: #f59e0b;
        }

        .section    { padding: 16px 24px; }
        .section-sm { padding: 12px 24px; }

        .sec-heading {
            font-size: 7.5pt;
            font-weight: bold;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
            border-left: 3px solid #3b82f6;
            padding-left: 8px;
        }

        .divider-dark {
            height: 1px;
            background-color: #e2e8f0;
            margin: 0 24px;
        }

        /* ── IDENTITAS ── */
        .id-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e8ecf0;
        }

        .id-table td {
            padding: 9px 14px;
            font-size: 10pt;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .id-table tr:last-child td { border-bottom: none; }

        .id-lbl {
            font-size: 7.5pt;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 20%;
        }

        .id-sep { width: 2%; color: #cbd5e1; }

        .id-val {
            font-weight: bold;
            color: #0f172a;
            font-size: 10.5pt;
        }

        .id-divider { border-left: 1px solid #e2e8f0 !important; }

        /* ── STAT BOXES ── */
        .stat-row {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
        }

        .stat-box {
            width: 25%;
            text-align: center;
            padding: 16px 10px 14px;
            border-radius: 10px;
            vertical-align: middle;
        }

        .stat-num {
            font-size: 28pt;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-lbl {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
        }

        .stat-box-blue  { background-color: #eff6ff; border: 1.5px solid #bfdbfe; }
        .stat-box-blue  .stat-num { color: #1d4ed8; }
        .stat-box-green { background-color: #f0fdf4; border: 1.5px solid #bbf7d0; }
        .stat-box-green .stat-num { color: #15803d; }
        .stat-box-amber { background-color: #fffbeb; border: 1.5px solid #fde68a; }
        .stat-box-amber .stat-num { color: #b45309; }
        .stat-box-red   { background-color: #fff1f2; border: 1.5px solid #fecdd3; }
        .stat-box-red   .stat-num { color: #be123c; }

        /* ── TABLE BAR ── */
        .tbl-bar {
            background-color: #1e293b;
            color: #e2e8f0;
            font-size: 9.5pt;
            font-weight: bold;
            padding: 8px 18px;
            letter-spacing: 0.3px;
        }

        /* ── MAIN TABLE ── */
        .main-tbl { width: 100%; border-collapse: collapse; }

        .main-tbl thead th {
            padding: 8px 10px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            background-color: #f8fafc;
            border-bottom: 1.5px solid #cbd5e1;
            border-top: 1px solid #e2e8f0;
            text-align: left;
            white-space: nowrap;
        }

        .main-tbl tbody td {
            padding: 8px 10px;
            font-size: 9.5pt;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }

        .main-tbl tbody tr.r-odd  td { background-color: #ffffff; }
        .main-tbl tbody tr.r-even td { background-color: #f8fafc; }
        .main-tbl tbody tr:last-child td { border-bottom: 1.5px solid #e2e8f0; }

        /* ── PROGRESS BAR ── */
        .bar-wrap {
            display: inline-block;
            width: 50px;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 4px;
            vertical-align: middle;
            overflow: hidden;
        }

        .bar-fill { height: 6px; border-radius: 4px; display: block; }

        /* ── BADGE ── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 99px;
            font-size: 7.5pt;
            font-weight: bold;
            white-space: nowrap;
        }

        .b-ok   { background-color: #dcfce7; color: #15803d; }
        .b-warn { background-color: #fef9c3; color: #b45309; }
        .b-bad  { background-color: #ffe4e6; color: #be123c; }
        .b-info { background-color: #dbeafe; color: #1d4ed8; }
        .b-gray { background-color: #f1f5f9; color: #475569; }
        .b-a    { background-color: #1d4ed8; color: #ffffff; }
        .b-b    { background-color: #0284c7; color: #ffffff; }
        .b-c    { background-color: #d97706; color: #ffffff; }
        .b-d    { background-color: #be123c; color: #ffffff; }

        .score-big { font-size: 13pt; font-weight: bold; line-height: 1; }

        /* ── MAPEL TABLE ── */
        .mapel-tbl { width: 100%; border-collapse: collapse; }

        .mapel-tbl thead th {
            padding: 8px 10px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            background-color: #f8fafc;
            border-bottom: 1.5px solid #cbd5e1;
            border-top: 1px solid #e2e8f0;
        }

        .mapel-tbl tbody td {
            padding: 9px 10px;
            font-size: 9.5pt;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .mapel-tbl tbody tr.r-odd  td { background-color: #ffffff; }
        .mapel-tbl tbody tr.r-even td { background-color: #f8fafc; }
        .mapel-tbl tbody tr:last-child td { border-bottom: 1.5px solid #e2e8f0; }

        .mapel-dot {
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 5px;
        }

        /* ── REKOMENDASI ── */
        .rekom-outer {
            margin: 0 24px 16px;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            background-color: #fffbeb;
            padding: 14px 18px;
        }

        .rekom-title {
            font-size: 10pt;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 6px;
        }

        .rekom-text { font-size: 9.5pt; color: #78350f; line-height: 1.65; }

        /* ── CATATAN & TTD ── */
        .note-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 9.5pt;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .ttd-tbl { width: 100%; border-collapse: collapse; }
        .ttd-tbl td { width: 33.33%; text-align: center; padding: 8px 12px; vertical-align: top; }
        .ttd-role { font-size: 8pt; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 40px; }
        .ttd-line { border-top: 1px solid #cbd5e1; padding-top: 5px; font-size: 9.5pt; font-weight: bold; color: #1e293b; }

        /* ── FOOTER ── */
        .footer-tbl { width: 100%; border-collapse: collapse; background-color: #0f172a; }
        .footer-tbl td { padding: 8px 16px; font-size: 8pt; color: #475569; vertical-align: middle; }

        .page-break { page-break-before: always; }
        .spacer-sm  { height: 12px; }
        .spacer-md  { height: 20px; }
    </style>
</head>
<body>

{{-- ════ HEADER ════ --}}
<table class="cover-top" width="100%">
    <tr>
        <td style="padding:22px 28px;vertical-align:middle;background-color:#0f172a;">
            <div class="brand">Al Ilmi Center</div>
            <div class="brand-sub">Platform Bimbel &amp; Persiapan TKA Terpercaya</div>
        </td>
        <td style="padding:22px 28px;vertical-align:middle;text-align:right;background-color:#0f172a;">
            <div class="cover-meta">
                Dicetak &nbsp;<strong>{{ now()->format('d M Y, H:i') }}</strong><br/>
                No. Laporan &nbsp;<strong>LAP-{{ now()->format('Ymd') }}-{{ str_pad(rand(1,999),3,'0',STR_PAD_LEFT) }}</strong><br/>
                Periode &nbsp;<strong>{{ $labelPeriode ?? now()->format('F Y') }}</strong>
            </div>
        </td>
    </tr>
</table>
<div class="accent-bar"></div>
<div class="cover-title-wrap">
    <div class="cover-title">Rapor Hasil Belajar Siswa</div>
    <div class="cover-subtitle">Rekap Performa Akademik &amp; Perkembangan Belajar</div>
</div>
<div class="accent-bar-bottom"></div>

{{-- ════ IDENTITAS ════ --}}
<div class="section" style="padding-bottom:10px;">
    <span class="sec-heading">A. Identitas Siswa</span>
    <table class="id-table" width="100%">
        <tr>
            <td class="id-lbl">Nama Lengkap</td>
            <td class="id-sep">:</td>
            <td class="id-val">{{ $user->name }}</td>
            <td class="id-lbl id-divider">Periode</td>
            <td class="id-sep">:</td>
            <td class="id-val">{{ $labelPeriode ?? now()->format('F Y') }}</td>
        </tr>
        <tr>
            <td class="id-lbl">Email</td>
            <td class="id-sep">:</td>
            <td class="id-val" style="font-size:9.5pt;">{{ $user->email }}</td>
            <td class="id-lbl id-divider">Status</td>
            <td class="id-sep">:</td>
            <td class="id-val">{{ ucfirst($user->role) }}</td>
        </tr>
    </table>
</div>

<div class="divider-dark"></div>

{{-- ════ STATISTIK ════ --}}
@php
    $total      = $hasilKuis->count();
    $avgNilai   = $total > 0 ? round($hasilKuis->avg('nilai')) : 0;
    $tertinggi  = $total > 0 ? $hasilKuis->max('nilai') : 0;
    $terendah   = $total > 0 ? $hasilKuis->min('nilai') : 0;
    $jamBelajar = round($hasilKuis->sum('durasi_menit') / 60, 1);
@endphp

<div class="section" style="padding-bottom:10px;">
    <span class="sec-heading">B. Statistik Keseluruhan</span>
    <table class="stat-row" width="100%">
        <tr>
            <td class="stat-box stat-box-blue">
                <div class="stat-num">{{ $total }}</div>
                <div class="stat-lbl">Total Pengerjaan</div>
            </td>
            <td class="stat-box stat-box-green">
                <div class="stat-num">{{ $avgNilai }}</div>
                <div class="stat-lbl">Rata-rata Nilai</div>
            </td>
            <td class="stat-box stat-box-amber">
                <div class="stat-num">{{ $tertinggi }}</div>
                <div class="stat-lbl">Nilai Tertinggi</div>
            </td>
            <td class="stat-box stat-box-red">
                <div class="stat-num">{{ $terendah }}</div>
                <div class="stat-lbl">Nilai Terendah</div>
            </td>
        </tr>
    </table>
</div>

<div class="divider-dark"></div>

{{-- ════ TABEL DETAIL NILAI ════ --}}
<div class="section-sm" style="padding-bottom:0;">
    <span class="sec-heading">C. Detail Hasil Latihan &amp; Kuis</span>
</div>
<div class="tbl-bar">Riwayat Pengerjaan Lengkap &mdash; {{ $total }} sesi</div>

<table class="main-tbl" width="100%">
    <thead>
        <tr>
            <th style="width:24px;text-align:center;">#</th>
            <th style="width:14%;">Mata Pelajaran</th>
            <th style="width:22%;">Judul Materi</th>
            <th style="width:7%;">Tipe</th>
            <th style="width:12%;">Nilai</th>
            <th style="width:8%;">Akurasi</th>
            <th style="width:7%;">Durasi</th>
            <th style="width:6%;text-align:center;">Grade</th>
            <th style="width:10%;">Status</th>
            <th style="width:10%;">Tanggal</th>
        </tr>
    </thead>
    <tbody>
    @php $rowNo = 0; @endphp
    @forelse($hasilKuis as $item)
    @php
        $rowNo++;
        $akurasi   = $item->total_soal > 0 ? round(($item->soal_benar / $item->total_soal) * 100) : 0;
        $grade     = $item->nilai >= 87 ? 'A' : ($item->nilai >= 70 ? 'B' : ($item->nilai >= 55 ? 'C' : 'D'));
        $barColor  = $item->nilai >= 80 ? '#16a34a' : ($item->nilai >= 60 ? '#d97706' : '#dc2626');
        $gradeCls  = $item->nilai >= 87 ? 'b-a' : ($item->nilai >= 70 ? 'b-b' : ($item->nilai >= 55 ? 'b-c' : 'b-d'));
        $statusCls = $item->nilai >= 80 ? 'b-ok' : ($item->nilai >= 60 ? 'b-warn' : 'b-bad');
        $statusTxt = $item->nilai >= 80 ? 'Baik' : ($item->nilai >= 60 ? 'Cukup' : 'Perlu Latihan');
        $tipeCls   = $item->tipe === 'kuis' ? 'b-info' : 'b-gray';
        $rowCls    = $rowNo % 2 !== 0 ? 'r-odd' : 'r-even';
    @endphp
    <tr class="{{ $rowCls }}">
        <td style="color:#94a3b8;font-size:8pt;text-align:center;font-weight:bold;">{{ $rowNo }}</td>
        <td style="font-weight:600;">{{ $item->materi->mata_pelajaran ?? '-' }}</td>
        <td style="font-size:9pt;color:#475569;">{{ Str::limit($item->materi->judul ?? '-', 28) }}</td>
        <td><span class="badge {{ $tipeCls }}">{{ ucfirst($item->tipe) }}</span></td>
        <td>
            <span class="score-big" style="color:{{ $barColor }};">{{ $item->nilai }}</span>
            &nbsp;
            <span class="bar-wrap"><span class="bar-fill" style="width:{{ $item->nilai }}%;background-color:{{ $barColor }};"></span></span>
        </td>
        <td style="font-weight:bold;color:{{ $barColor }};">{{ $akurasi }}%</td>
        <td style="color:#64748b;font-size:9pt;">{{ $item->durasi_menit }}mnt</td>
        <td style="text-align:center;"><span class="badge {{ $gradeCls }}">{{ $grade }}</span></td>
        <td><span class="badge {{ $statusCls }}">{{ $statusTxt }}</span></td>
        <td style="color:#64748b;font-size:9pt;white-space:nowrap;">{{ $item->created_at->format('d/m/Y') }}</td>
    </tr>
    @empty
    <tr class="r-odd">
        <td colspan="10" style="text-align:center;color:#94a3b8;padding:24px;font-style:italic;font-size:9pt;">
            Belum ada data untuk periode ini
        </td>
    </tr>
    @endforelse
    </tbody>
</table>

{{-- ════ RINGKASAN PER MAPEL ════ --}}
@if($hasilKuis->count() > 0)

<div class="spacer-md"></div>
<div class="section-sm" style="padding-bottom:0;">
    <span class="sec-heading">D. Ringkasan Per Mata Pelajaran</span>
</div>
<div class="tbl-bar">Performa Akademik per Bidang Studi</div>

@php
    $dotColors = ['#1d4ed8','#16a34a','#0284c7','#d97706','#dc2626','#7c3aed','#0891b2','#0d9488'];
    $di   = 0;
    $mpNo = 0;
@endphp

<table class="mapel-tbl" width="100%">
    <thead>
        <tr>
            <th style="width:22%;">Mata Pelajaran</th>
            <th style="width:7%;text-align:center;">Sesi</th>
            <th style="width:20%;">Rata-rata</th>
            <th style="width:9%;text-align:center;">Tertinggi</th>
            <th style="width:9%;text-align:center;">Terendah</th>
            <th style="width:10%;text-align:center;">Akurasi</th>
            <th style="width:11%;text-align:center;">Total Soal</th>
            <th style="width:12%;">Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($perMapel as $mp)
    @php
        $mpNo++;
        $mpColor = $mp['rata'] >= 80 ? '#15803d' : ($mp['rata'] >= 60 ? '#b45309' : '#b91c1c');
        $barC    = $mp['rata'] >= 80 ? '#16a34a' : ($mp['rata'] >= 60 ? '#d97706' : '#dc2626');
        $akurasi = $mp['totalSoal'] > 0 ? round($mp['totalBenar'] / $mp['totalSoal'] * 100) : 0;
        $trenCls = $mp['rata'] >= 80 ? 'b-ok' : ($mp['rata'] >= 60 ? 'b-warn' : 'b-bad');
        $trenTxt = $mp['rata'] >= 80 ? 'Bagus' : ($mp['rata'] >= 60 ? 'Stabil' : 'Perhatian');
        $rowCls  = $mpNo % 2 !== 0 ? 'r-odd' : 'r-even';
        $dot     = $dotColors[$di % count($dotColors)];
        $di++;
    @endphp
    <tr class="{{ $rowCls }}">
        <td>
            <span class="mapel-dot" style="background-color:{{ $dot }};"></span>
            <strong>{{ $mp['nama'] }}</strong>
        </td>
        <td style="text-align:center;font-weight:bold;">{{ $mp['total'] }}</td>
        <td>
            <strong style="font-size:12pt;color:{{ $mpColor }};">{{ $mp['rata'] }}</strong>
            &nbsp;
            <span class="bar-wrap" style="width:65px;">
                <span class="bar-fill" style="width:{{ $mp['rata'] }}%;background-color:{{ $barC }};"></span>
            </span>
        </td>
        <td style="text-align:center;font-weight:bold;color:#15803d;">{{ $mp['tertinggi'] }}</td>
        <td style="text-align:center;font-weight:bold;color:#be123c;">{{ $mp['terendah'] }}</td>
        <td style="text-align:center;font-weight:bold;color:{{ $mpColor }};">{{ $akurasi }}%</td>
        <td style="text-align:center;font-size:9pt;color:#475569;">{{ $mp['totalSoal'] }} soal</td>
        <td><span class="badge {{ $trenCls }}">{{ $trenTxt }}</span></td>
    </tr>
    @endforeach
    </tbody>
</table>

@endif

{{-- ════ REKOMENDASI ════ --}}
@php
    $rekMapel = null;
    if(isset($perMapel) && count($perMapel) > 0){
        $rekMapel = collect($perMapel)->sortBy('rata')->first();
    }
@endphp

@if($rekMapel && $rekMapel['rata'] < 80)
<div class="spacer-md"></div>
<div class="section-sm" style="padding-bottom:6px;">
    <span class="sec-heading">E. Rekomendasi Belajar</span>
</div>
<div class="rekom-outer">
    <div class="rekom-title">Rekomendasi untuk {{ $user->name }}</div>
    <div class="rekom-text">
        Berdasarkan analisis data, mata pelajaran <strong>{{ $rekMapel['nama'] }}</strong> memerlukan perhatian lebih.
        Rata-rata nilai saat ini <strong>{{ $rekMapel['rata'] }}</strong> — di bawah target minimal 80.
        Disarankan untuk memperbanyak latihan soal pada bidang ini dan mengulang materi yang belum dikuasai.
        Manfaatkan fitur <em>Belajar TKA</em> di platform untuk akses soal latihan lebih banyak.
    </div>
</div>
@endif

{{-- ════ CATATAN & TTD ════ --}}
<div class="spacer-sm"></div>
<div class="divider-dark"></div>

<div class="section" style="padding-top:16px;padding-bottom:8px;">
    <span class="sec-heading">F. Catatan &amp; Pengesahan</span>
    <div class="note-box">
        Laporan ini digenerate secara otomatis oleh sistem <strong style="color:#1e293b;">Al Ilmi Center</strong>
        berdasarkan data aktivitas belajar siswa selama periode
        <strong style="color:#1d4ed8;">{{ $labelPeriode ?? now()->format('F Y') }}</strong>.
        Nilai yang tertera merupakan akumulasi hasil latihan dan kuis yang telah diselesaikan.
        Laporan bersifat resmi dan dapat digunakan sebagai referensi perkembangan akademik.
    </div>

    <table class="ttd-tbl" width="100%">
        <tr>
            <td>
                <div class="ttd-role">Siswa</div>
                <div class="ttd-line">{{ $user->name }}</div>
            </td>
            <td>
                <div class="ttd-role">Tanggal Cetak</div>
                <div class="ttd-line">{{ now()->format('d M Y') }}</div>
            </td>
            <td>
                <div class="ttd-role">Diterbitkan oleh</div>
                <div class="ttd-line">Al Ilmi Center</div>
            </td>
        </tr>
    </table>
</div>

{{-- ════ FOOTER ════ --}}
<table class="footer-tbl" width="100%">
    <tr>
        <td style="color:#475569;font-size:8pt;width:40%;">
            &copy; {{ now()->year }} Al Ilmi Center. Dokumen resmi sistem.
        </td>
        <td style="text-align:center;width:20%;font-weight:bold;color:#64748b;font-size:8pt;">
            RAHASIA SISWA
        </td>
        <td style="text-align:right;width:40%;color:#475569;font-size:8pt;">
            Periode: {{ $labelPeriode ?? '-' }}
        </td>
    </tr>
</table>

</body>
</html>