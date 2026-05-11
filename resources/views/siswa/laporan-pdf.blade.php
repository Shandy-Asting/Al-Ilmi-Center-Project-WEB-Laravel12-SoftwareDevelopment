<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Hasil Belajar – Al Ilmi Center</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            background: linear-gradient(135deg, #1e3a5f, #2d5282);
            color: #fff;
            padding: 20px 24px;
            margin-bottom: 20px;
            border-radius: 0 0 12px 12px;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
        }

        .brand-sub {
            font-size: 10px;
            opacity: .7;
            margin-top: 2px;
        }

        .header-right {
            text-align: right;
            font-size: 10px;
            opacity: .8;
        }

        .header-title {
            text-align: center;
            margin-top: 14px;
        }

        .header-title h2 {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: .5px;
        }

        .header-title p {
            font-size: 10px;
            opacity: .75;
            margin-top: 4px;
        }

        /* ── INFO BOX ── */
        .info-box {
            background: #f1f5f9;
            border-left: 4px solid #1e3a5f;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 0 20px 16px;
            display: flex;
            gap: 40px;
        }

        .info-item {
            flex: 1;
        }

        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .info-val {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
        }

        /* ── STAT GRID ── */
        .stat-grid {
            display: flex;
            gap: 10px;
            margin: 0 20px 20px;
        }

        .stat-box {
            flex: 1;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .stat-val {
            font-size: 22px;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .s-blue {
            background: #eff6ff;
        }

        .s-blue .stat-val {
            color: #1e3a5f;
        }

        .s-green {
            background: #dcfce7;
        }

        .s-green .stat-val {
            color: #16a34a;
        }

        .s-yellow {
            background: #fef9c3;
        }

        .s-yellow .stat-val {
            color: #d97706;
        }

        .s-red {
            background: #fee2e2;
        }

        .s-red .stat-val {
            color: #dc2626;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            background: #1e3a5f;
            color: #fff;
            padding: 7px 20px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: .4px;
            margin-bottom: 0;
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl-wrap {
            margin: 0 0 20px;
            overflow: hidden;
        }

        thead th {
            background: #1e3a5f;
            color: #fff;
            padding: 8px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            color: #1e293b;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── BADGE ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 9.5px;
            font-weight: bold;
        }

        .b-success {
            background: #dcfce7;
            color: #16a34a;
        }

        .b-warning {
            background: #fef9c3;
            color: #d97706;
        }

        .b-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .b-primary {
            background: #eff6ff;
            color: #1e3a5f;
        }

        /* ── PROGRES BAR ── */
        .bar-wrap {
            width: 80px;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            display: inline-block;
            vertical-align: middle;
        }

        .bar-fill {
            height: 8px;
            border-radius: 4px;
        }

        /* ── FOOTER ── */
        .footer {
            background: #f1f5f9;
            border-top: 2px solid #1e3a5f;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 9px;
            color: #64748b;
            margin-top: 20px;
        }

        /* ── TANDA TANGAN ── */
        .ttd-wrap {
            display: flex;
            gap: 40px;
            margin: 20px 20px 0;
        }

        .ttd-box {
            flex: 1;
            text-align: center;
        }

        .ttd-line {
            border-top: 1px solid #1e293b;
            margin-top: 50px;
            padding-top: 6px;
            font-size: 10px;
            font-weight: bold;
        }

        .ttd-role {
            font-size: 9px;
            color: #64748b;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }

        /* ══ RESPONSIVE GLOBAL ══ */
        @media (max-width: 991px) {
            .row>[class*='col-lg'] {
                margin-bottom: 12px;
            }
        }

        @media (max-width: 767px) {
            h4.fw-bold {
                font-size: 1.1rem !important;
            }

            .d-flex.justify-content-between {
                flex-wrap: wrap;
                gap: 10px;
            }

            .stat-card {
                padding: 14px !important;
            }

            .stat-val {
                font-size: 1.3rem !important;
            }

            .main-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .main-tab {
                min-width: 100px;
                flex: none;
            }

            table {
                font-size: 12px !important;
            }

            table td,
            table th {
                padding: 8px 10px !important;
            }

            .card-box-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-box {
                width: 96% !important;
                margin: 10px auto;
            }
        }

        @media (max-width: 480px) {
            .stat-card {
                flex-direction: column;
                gap: 8px;
            }

            .d-flex.gap-2 {
                flex-wrap: wrap;
            }

            .btn {
                font-size: 12px !important;
                padding: 7px 12px !important;
            }
        }
    </style>
</head>

<body>

    {{-- ══ HEADER ══ --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="brand">🎓 Al Ilmi Center</div>
                <div class="brand-sub">Platform Bimbel TKA Terpercaya</div>
            </div>
            <div class="header-right">
                <div>Dicetak: {{ now()->format('d M Y H:i') }}</div>
                <div>No. Laporan: LAP-{{ now()->format('Ymd') }}-{{ str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <div class="header-title">
            <h2>LAPORAN HASIL BELAJAR SISWA</h2>
            <p>Rekap Performa Akademik & Perkembangan Belajar</p>
        </div>
    </div>

    {{-- ══ INFO SISWA ══ --}}
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
            <div class="info-val">{{ now()->format('F Y') }}</div>
        </div>
    </div>

    {{-- ══ STAT GRID ══ --}}
    <div class="stat-grid">
        @php
            $total = count($hasilLatihan ?? []);
            $avgNilai = $total > 0 ? round(collect($hasilLatihan)->avg('nilai')) : 0;
            $tertinggi = $total > 0 ? collect($hasilLatihan)->max('nilai') : 0;
            $terendah = $total > 0 ? collect($hasilLatihan)->min('nilai') : 0;
        @endphp
        <div class="stat-box s-blue">
            <div class="stat-val">{{ $total }}</div>
            <div class="stat-label">Total Latihan</div>
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

    {{-- ══ TABEL HASIL ══ --}}
    <div class="section-title">📊 Detail Hasil Latihan</div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                    <th>Benar / Total</th>
                    <th>Akurasi</th>
                    <th>Durasi</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasilLatihan ?? [] as $index => $item)
                    @php
                        $akurasi = $item->jumlah_soal > 0 ? round(($item->soal_benar / $item->jumlah_soal) * 100) : 0;
                        $ket =
                            $item->nilai >= 80
                                ? ['Baik', 'b-success']
                                : ($item->nilai >= 60
                                    ? ['Cukup', 'b-warning']
                                    : ['Perlu Belajar', 'b-danger']);
                        $barColor = $item->nilai >= 80 ? '#16a34a' : ($item->nilai >= 60 ? '#d97706' : '#dc2626');
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->mata_pelajaran }}</strong></td>
                        <td>
                            <strong style="font-size:14px;color:{{ $barColor }}">{{ $item->nilai }}</strong>
                            <div class="bar-wrap" style="margin-left:6px;">
                                <div class="bar-fill"
                                    style="width:{{ $item->nilai }}%;background:{{ $barColor }};"></div>
                            </div>
                        </td>
                        <td>{{ $item->soal_benar }} / {{ $item->jumlah_soal }}</td>
                        <td>{{ $akurasi }}%</td>
                        <td>{{ $item->durasi_menit }} mnt</td>
                        <td><span class="badge {{ $ket[1] }}">{{ $ket[0] }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;color:#94a3b8;padding:20px;">Belum ada data latihan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ══ RINGKASAN PER MAPEL ══ --}}
    @if (isset($hasilLatihan) && count($hasilLatihan) > 0)
        @php
            $perMapel = collect($hasilLatihan)->groupBy('mata_pelajaran');
        @endphp
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
                        <th>Tren</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perMapel as $mapel => $items)
                        @php
                            $avg = round($items->avg('nilai'));
                            $max = $items->max('nilai');
                            $min = $items->min('nilai');
                            $bar = $avg >= 80 ? '#16a34a' : ($avg >= 60 ? '#d97706' : '#dc2626');
                        @endphp
                        <tr>
                            <td><strong>{{ $mapel }}</strong></td>
                            <td>{{ $items->count() }} latihan</td>
                            <td>
                                <strong style="color:{{ $bar }}">{{ $avg }}</strong>
                                <div class="bar-wrap" style="margin-left:6px;">
                                    <div class="bar-fill"
                                        style="width:{{ $avg }}%;background:{{ $bar }};"></div>
                                </div>
                            </td>
                            <td style="color:#16a34a;font-weight:bold;">{{ $max }}</td>
                            <td style="color:#dc2626;font-weight:bold;">{{ $min }}</td>
                            <td>
                                <span
                                    class="badge {{ $avg >= 80 ? 'b-success' : ($avg >= 60 ? 'b-warning' : 'b-danger') }}">
                                    {{ $avg >= 80 ? '📈 Bagus' : ($avg >= 60 ? '➡️ Stabil' : '📉 Butuh Perhatian') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- ══ TANDA TANGAN ══ --}}
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

    {{-- ══ FOOTER ══ --}}
    <div class="footer">
        <div>© {{ now()->year }} Al Ilmi Center — Laporan digenerate otomatis oleh sistem</div>
        <div>{{ request()->url() }}</div>
    </div>

</body>

</html>
