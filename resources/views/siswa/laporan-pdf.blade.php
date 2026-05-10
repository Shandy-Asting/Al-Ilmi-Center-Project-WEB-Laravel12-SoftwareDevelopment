<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <title>Laporan Hasil Belajar – Al Ilmi Center</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
        .header { background: linear-gradient(135deg, #1e3a5f, #2d5282); color: #fff; padding: 20px 24px; margin-bottom: 20px; border-radius: 0 0 12px 12px; }
        .header-top { display: flex; align-items: center; justify-content: space-between; }
        .brand { font-size: 20px; font-weight: bold; }
        .brand-sub { font-size: 10px; opacity: .7; margin-top: 2px; }
        .header-right { text-align: right; font-size: 10px; opacity: .8; }
        .header-title { text-align: center; margin-top: 14px; }
        .header-title h2 { font-size: 16px; font-weight: bold; letter-spacing: .5px; }
        .header-title p { font-size: 10px; opacity: .75; margin-top: 4px; }
        .info-box { background: #f1f5f9; border-left: 4px solid #1e3a5f; border-radius: 8px; padding: 12px 16px; margin: 0 20px 16px; display: flex; gap: 40px; }
        .info-item { flex: 1; }
        .info-label { font-size: 9px; text-transform: uppercase; letter-spacing: .6px; color: #64748b; font-weight: bold; margin-bottom: 3px; }
        .info-val { font-size: 12px; font-weight: bold; color: #1e293b; }
        .stat-grid { display: flex; gap: 10px; margin: 0 20px 20px; }
        .stat-box { flex: 1; border-radius: 10px; padding: 12px; text-align: center; border: 1px solid #e2e8f0; }
        .stat-val { font-size: 22px; font-weight: bold; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }
        .s-blue { background: #eff6ff; } .s-blue .stat-val { color: #1e3a5f; }
        .s-green { background: #dcfce7; } .s-green .stat-val { color: #16a34a; }
        .s-yellow { background: #fef9c3; } .s-yellow .stat-val { color: #d97706; }
        .s-red { background: #fee2e2; } .s-red .stat-val { color: #dc2626; }
        .section-title { background: #1e3a5f; color: #fff; padding: 7px 20px; font-size: 11px; font-weight: bold; letter-spacing: .4px; margin-bottom: 0; }
        table { width: 100%; border-collapse: collapse; }
        .tbl-wrap { margin: 0 0 20px; overflow: hidden; }
        thead th { background: #1e3a5f; color: #fff; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: .4px; white-space: nowrap; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 10.5px; color: #1e293b; vertical-align: middle; }
        tbody tr:nth-child(even) td { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: bold; }
        .b-success { background: #dcfce7; color: #16a34a; }
        .b-warning { background: #fef9c3; color: #d97706; }
        .b-danger  { background: #fee2e2; color: #dc2626; }
        .b-info    { background: #dbeafe; color: #1e3a5f; }
        .bar-wrap { width: 70px; height: 7px; background: #e2e8f0; border-radius: 4px; display: inline-block; vertical-align: middle; }
        .bar-fill  { height: 7px; border-radius: 4px; }
        .footer { background: #f1f5f9; border-top: 2px solid #1e3a5f; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; font-size: 9px; color: #64748b; margin-top: 20px; }
        .ttd-wrap { display: flex; gap: 40px; margin: 20px 20px 0; }
        .ttd-box { flex: 1; text-align: center; }
        .ttd-line { border-top: 1px solid #1e293b; margin-top: 50px; padding-top: 6px; font-size: 10px; font-weight: bold; }
        .ttd-role { font-size: 9px; color: #64748b; }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div class="header-top">
        <div>
            <div class="brand">🎓 Al Ilmi Center</div>
            <div class="brand-sub">Platform Bimbel TKA Terpercaya</div>
        </div>
        <div class="header-right">
            <div>Dicetak: {{ now()->format('d M Y H:i') }}</div>
            <div>No. Laporan: LAP-{{ now()->format('Ymd') }}-{{ str_pad(rand(1,999), 3, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>
    <div class="header-title">
        <h2>LAPORAN HASIL BELAJAR SISWA</h2>
        <p>Rekap Performa Akademik & Perkembangan Belajar</p>
    </div>
</div>

{{-- INFO SISWA --}}
<div class="info-box">
    <div class="info-item">
        <div class="info-label">Nama Siswa</div>
        <div class="info-val">{{ $user->name }}</div>
    </div>
    <div class="info-item">
        <div class="info-label">Email</div>
        <div class="info-val">{{ $user->email }}</div>
    </div>
    <div class="info-item">
        <div class="info-label">Role</div>
        <div class="info-val">{{ ucfirst($user->role) }}</div>
    </div>
    <div class="info-item">
        <div class="info-label">Periode Laporan</div>
        <div class="info-val">{{ $labelPeriode ?? now()->format('F Y') }}</div>
    </div>
</div>

{{-- STAT GRID --}}
@php
    $total      = $hasilKuis->count();
    $avgNilai   = $total > 0 ? round($hasilKuis->avg('nilai')) : 0;
    $tertinggi  = $total > 0 ? $hasilKuis->max('nilai') : 0;
    $terendah   = $total > 0 ? $hasilKuis->min('nilai') : 0;
    $jamBelajar = round($hasilKuis->sum('durasi_menit') / 60, 1);
@endphp
<div class="stat-grid">
    <div class="stat-box s-blue">
        <div class="stat-val">{{ $total }}</div>
        <div class="stat-label">Total Pengerjaan</div>
    </div>
    <div class="stat-box s-green">
        <div class="stat-val">{{ $avgNilai }}</div>
        <div class="stat-label">Rata-rata Nilai</div>
    </div>
    <div class="stat-box s-yellow">
        <div class="stat-val">{{ $tertinggi }}</div>
        <div class="stat-label">Nilai Tertinggi</div>
    </div>
    <div class="stat-box s-red">
        <div class="stat-val">{{ $terendah }}</div>
        <div class="stat-label">Nilai Terendah</div>
    </div>
</div>

{{-- TABEL DETAIL --}}
<div class="section-title">📊 Detail Hasil Latihan & Kuis</div>
<div class="tbl-wrap">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Judul Materi</th>
                <th>Tipe</th>
                <th>Nilai</th>
                <th>Benar/Total</th>
                <th>Akurasi</th>
                <th>Durasi</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @forelse($hasilKuis as $index => $item)
        @php
            $akurasi  = $item->total_soal > 0 ? round(($item->soal_benar / $item->total_soal) * 100) : 0;
            $ket      = $item->nilai >= 80 ? ['Baik','b-success'] : ($item->nilai >= 60 ? ['Cukup','b-warning'] : ['Perlu Belajar','b-danger']);
            $barColor = $item->nilai >= 80 ? '#16a34a' : ($item->nilai >= 60 ? '#d97706' : '#dc2626');
            $grade    = $item->nilai >= 87 ? 'A' : ($item->nilai >= 70 ? 'B' : ($item->nilai >= 55 ? 'C' : 'D'));
        @endphp
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><strong>{{ $item->materi->mata_pelajaran ?? '-' }}</strong></td>
            <td>{{ $item->materi->judul ?? '-' }}</td>
            <td>
                <span class="badge {{ $item->tipe === 'kuis' ? 'b-info' : 'b-success' }}">
                    {{ ucfirst($item->tipe) }}
                </span>
            </td>
            <td>
                <strong style="font-size:13px;color:{{ $barColor }}">{{ $item->nilai }}</strong>
                <span style="font-size:9px;font-weight:bold;color:{{ $barColor }}"> ({{ $grade }})</span>
                <div class="bar-wrap" style="margin-left:4px;">
                    <div class="bar-fill" style="width:{{ $item->nilai }}%;background:{{ $barColor }};"></div>
                </div>
            </td>
            <td>{{ $item->soal_benar }} / {{ $item->total_soal }}</td>
            <td>{{ $akurasi }}%</td>
            <td>{{ $item->durasi_menit }} mnt</td>
            <td><span class="badge {{ $ket[1] }}">{{ $ket[0] }}</span></td>
            <td>{{ $item->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="10" style="text-align:center;color:#94a3b8;padding:20px;">
                Belum ada data untuk periode ini
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- RINGKASAN PER MAPEL --}}
@if($hasilKuis->count() > 0)
<div class="section-title">📚 Ringkasan Per Mata Pelajaran</div>
<div class="tbl-wrap">
    <table>
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Total Latihan</th>
                <th>Rata-rata Nilai</th>
                <th>Tertinggi</th>
                <th>Terendah</th>
                <th>Total Soal</th>
                <th>Benar</th>
                <th>Akurasi</th>
                <th>Tren</th>
            </tr>
        </thead>
        <tbody>
        @foreach($perMapel as $mp)
        @php
            $bar      = $mp['rata'] >= 80 ? '#16a34a' : ($mp['rata'] >= 60 ? '#d97706' : '#dc2626');
            $akurasi  = $mp['totalSoal'] > 0 ? round($mp['totalBenar'] / $mp['totalSoal'] * 100) : 0;
            $tren     = $mp['rata'] >= 80 ? ['📈 Bagus','b-success'] : ($mp['rata'] >= 60 ? ['➡️ Stabil','b-warning'] : ['📉 Perhatian','b-danger']);
        @endphp
        <tr>
            <td><strong>{{ $mp['nama'] }}</strong></td>
            <td>{{ $mp['total'] }} sesi</td>
            <td>
                <strong style="color:{{ $bar }}">{{ $mp['rata'] }}</strong>
                <div class="bar-wrap" style="margin-left:4px;">
                    <div class="bar-fill" style="width:{{ $mp['rata'] }}%;background:{{ $bar }};"></div>
                </div>
            </td>
            <td style="color:#16a34a;font-weight:bold;">{{ $mp['tertinggi'] }}</td>
            <td style="color:#dc2626;font-weight:bold;">{{ $mp['terendah'] }}</td>
            <td>{{ $mp['totalSoal'] }}</td>
            <td>{{ $mp['totalBenar'] }}</td>
            <td>{{ $akurasi }}%</td>
            <td><span class="badge {{ $tren[1] }}">{{ $tren[0] }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- TANDA TANGAN --}}
<div class="ttd-wrap">
    <div class="ttd-box">
        <div class="ttd-role">Siswa</div>
        <div class="ttd-line">{{ $user->name }}</div>
    </div>
    <div class="ttd-box">
        <div class="ttd-role">Dicetak pada</div>
        <div class="ttd-line">{{ now()->format('d M Y') }}</div>
    </div>
    <div class="ttd-box">
        <div class="ttd-role">Platform</div>
        <div class="ttd-line">Al Ilmi Center</div>
    </div>
</div>

{{-- FOOTER --}}
<div class="footer">
    <div>© {{ now()->year }} Al Ilmi Center — Laporan digenerate otomatis oleh sistem</div>
    <div>Periode: {{ $labelPeriode ?? '-' }}</div>
</div>

</body>
</html>