<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body{font-family:Arial,sans-serif;font-size:13px;color:#1e293b;margin:0;padding:20px;}
        h1{font-size:20px;font-weight:800;margin-bottom:4px;}
        p{margin:0;color:#64748b;font-size:12px;}
        .section{margin-top:24px;}
        .section-title{font-size:14px;font-weight:700;border-bottom:2px solid #1e3a5f;padding-bottom:6px;margin-bottom:12px;color:#1e3a5f;}
        .stat-grid{display:flex;gap:12px;margin-bottom:16px;}
        .stat-box{flex:1;border:1px solid #e2e8f0;border-radius:8px;padding:12px;text-align:center;}
        .stat-val{font-size:22px;font-weight:800;color:#1e3a5f;}
        .stat-label{font-size:11px;color:#64748b;margin-top:2px;}
        table{width:100%;border-collapse:collapse;margin-top:8px;}
        thead th{background:#1e3a5f;color:#fff;font-size:11px;padding:8px 10px;text-align:left;}
        tbody td{padding:8px 10px;font-size:12px;border-bottom:1px solid #f1f5f9;}
        tbody tr:last-child td{border-bottom:none;}
        .footer{margin-top:30px;padding-top:12px;border-top:1px solid #e2e8f0;font-size:11px;color:#94a3b8;text-align:center;}
    </style>
</head>
<body>
    <h1>Laporan Sistem Al Ilmi Center</h1>
    <p>Periode: {{ $labelPeriode }} &nbsp;|&nbsp; Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>

    <div class="section">
        <div class="section-title">Ringkasan</div>
        <div class="stat-grid">
            <div class="stat-box"><div class="stat-val">{{ $totalPengguna }}</div><div class="stat-label">Total Pengguna</div></div>
            <div class="stat-box"><div class="stat-val">{{ $totalLesPrivat }}</div><div class="stat-label">Les Privat Bulan Ini</div></div>
            <div class="stat-box"><div class="stat-val">{{ number_format($soalDikerjakan) }}</div><div class="stat-label">Soal Dikerjakan</div></div>
            <div class="stat-box"><div class="stat-val">{{ $rataRataBelajar }} mnt</div><div class="stat-label">Rata-rata Belajar</div></div>
            <div class="stat-box"><div class="stat-val">Rp {{ $totalPembayaran >= 1000000 ? round($totalPembayaran/1000000,1).'jt' : round($totalPembayaran/1000).'rb' }}</div><div class="stat-label">Total Pembayaran</div></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Materi Terpopuler</div>
        <table>
            <thead><tr><th>#</th><th>Mata Pelajaran</th><th>Sesi</th></tr></thead>
            <tbody>
            @foreach($materiTerpopuler as $i => $m)
            <tr><td>{{ $i+1 }}</td><td>{{ $m['nama'] }}</td><td>{{ $m['sesi'] }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Tutor Terbaik Bulan Ini</div>
        <table>
            <thead><tr><th>#</th><th>Nama Tutor</th><th>Sesi Selesai</th></tr></thead>
            <tbody>
            @foreach($tutorTerbaik as $i => $t)
            <tr><td>{{ $i+1 }}</td><td>{{ $t['tutor']->name }}</td><td>{{ $t['sesi'] }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Rata-rata Nilai Kuis per Mata Pelajaran</div>
        <table>
            <thead><tr><th>Mata Pelajaran</th><th>Rata-rata Nilai</th></tr></thead>
            <tbody>
            @foreach($nilaiPerMapel as $n)
            <tr><td>{{ $n['nama'] }}</td><td>{{ $n['rata'] }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">Al Ilmi Center &mdash; Laporan otomatis dibuat oleh sistem &mdash; {{ now()->translatedFormat('d F Y') }}</div>
</body>
</html>