<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Belajar</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1e3a5f; padding-bottom: 10px; }
        .header h2 { color: #1e3a5f; margin: 0; font-size: 18px; }
        .header p { margin: 4px 0; color: #64748b; }
        .info-box { background: #f1f5f9; border-radius: 8px; padding: 12px; margin-bottom: 16px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 16px; }
        .stat-box { background: #eff6ff; border-radius: 8px; padding: 10px; text-align: center; }
        .stat-val { font-size: 20px; font-weight: bold; color: #1e3a5f; }
        .stat-label { font-size: 10px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1e3a5f; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 7px 8px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h2>🎓 Al Ilmi Center</h2>
        <p>Laporan Hasil Belajar Siswa</p>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="info-box">
        <table style="border:none;">
            <tr>
                <td style="border:none;font-weight:bold;">Nama Siswa</td>
                <td style="border:none;">: {{ $user->name }}</td>
                <td style="border:none;font-weight:bold;">Email</td>
                <td style="border:none;">: {{ $user->email }}</td>
            </tr>
            <tr>
                <td style="border:none;font-weight:bold;">Role</td>
                <td style="border:none;">: {{ ucfirst($user->role) }}</td>
                <td style="border:none;font-weight:bold;">Periode</td>
                <td style="border:none;">: {{ now()->format('M Y') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
            <th>Jumlah Soal</th>
            <th>Soal Benar</th>
            <th>Durasi (menit)</th>
            <th>Tanggal</th>
        </tr>
        @foreach($hasilLatihan as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->mata_pelajaran }}</td>
            <td><strong>{{ $item->nilai }}</strong></td>
            <td>{{ $item->jumlah_soal }}</td>
            <td>{{ $item->soal_benar }}</td>
            <td>{{ $item->durasi_menit }}</td>
            <td>{{ $item->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="footer">
        <p>© {{ now()->year }} Al Ilmi Center - Laporan ini digenerate secara otomatis</p>
    </div>
</body>
</html>