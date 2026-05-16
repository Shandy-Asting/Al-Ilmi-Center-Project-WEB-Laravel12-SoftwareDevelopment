@extends('layouts.app')

@section('title', 'Laporan - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Laporan Sistem')
@section('page-sub', 'Admin / Laporan / Ringkasan')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/admin/dashboard" class="nav-item-custom"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <div class="menu-label">Pengelolaan</div>
    <a href="/admin/pengguna" class="nav-item-custom"><i class="bi bi-people-fill"></i> Pengelolaan Pengguna</a>
    <a href="/admin/paket" class="nav-item-custom"><i class="bi bi-box-seam"></i> Pengelolaan Paket</a>
    <a href="/admin/transaksi" class="nav-item-custom"><i class="bi bi-credit-card-fill"></i> Transaksi</a>
    <a href="/admin/pembayaran" class="nav-item-custom"><i class="bi bi-cash-coin"></i> Pembayaran & Gaji</a>
    <a href="/admin/rekening" class="nav-item-custom"><i class="bi bi-bank"></i> Rekening Bank</a>
    <a href="/admin/laporan" class="nav-item-custom active"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
@endsection

@push('styles')
<style>
    .stat-card{background:var(--card-bg);border-radius:14px;padding:20px;border:1px solid var(--border);display:flex;align-items:center;gap:16px;transition:box-shadow .2s;}
    .stat-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.06);}
    .stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .stat-label{font-size:12px;color:var(--muted);font-weight:500;}
    .stat-value{font-size:22px;font-weight:800;color:var(--text);line-height:1.2;}
    .stat-sub{font-size:11.5px;color:var(--muted);margin-top:2px;}
    .stat-sub .up{color:var(--success);font-weight:600;}
    .card-box{background:var(--card-bg);border-radius:14px;border:1px solid var(--border);overflow:hidden;}
    .card-box-header{padding:18px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;}
    .card-box-title{font-size:15px;font-weight:700;color:var(--text);}
    .tab-nav{display:flex;gap:4px;background:#f1f5f9;padding:5px;border-radius:10px;width:fit-content;}
    .tab-btn{padding:6px 16px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);border:none;background:transparent;transition:all .2s;}
    .tab-btn.active{background:#fff;color:var(--primary);box-shadow:0 1px 4px rgba(0,0,0,.08);}
    .bar-chart{display:flex;align-items:flex-end;gap:6px;height:120px;padding:0 4px;}
    .bc-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;}
    .bc-bar{width:100%;border-radius:4px 4px 0 0;background:linear-gradient(180deg,var(--primary-light),var(--primary));transition:height .5s ease;}
    .bc-bar.accent{background:linear-gradient(180deg,var(--accent),#f59e0b);}
    .bc-label{font-size:10px;color:var(--muted);font-weight:500;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{background:#f8fafc;font-size:11.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;padding:11px 14px;border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:13px 14px;font-size:13.5px;color:var(--text);border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#fafcff;}
    .prog-track{height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
    .prog-fill{height:100%;border-radius:99px;}
    .rank-num{width:24px;height:24px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;}
    .rank-1{background:var(--accent);color:var(--primary);}
    .rank-2{background:#e2e8f0;color:#475569;}
    .rank-3{background:#ffedd5;color:#c2410c;}
    .rank-n{background:#f1f5f9;color:var(--muted);}
    .hm-cell{border-radius:4px;cursor:pointer;transition:transform .15s;}
    .hm-cell:hover{transform:scale(1.15);}
    .hm-0{background:#f1f5f9;}.hm-1{background:#bfdbfe;}.hm-2{background:#60a5fa;}.hm-3{background:#2563eb;}.hm-4{background:var(--primary);}
    @media(max-width:767px){.tab-nav{width:100%;}.tab-btn{flex:1;font-size:11.5px;}.bar-chart{height:80px;}}
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">📊 Laporan Sistem</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Admin / Laporan / Ringkasan</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <select style="font-size:13px;border-radius:8px;height:36px;border:1.5px solid var(--border);padding:0 10px;background:#fff;">
            <option>Mei 2026</option><option>April 2026</option><option>Maret 2026</option>
        </select>
        <button style="background:var(--primary);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;padding:7px 14px;cursor:pointer;">
            <i class="bi bi-download me-1"></i> Export PDF
        </button>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['bi-people-fill','#eff6ff','var(--primary)',\App\Models\User::count(),'Total Pengguna','↑ 18% bulan ini'],
        ['bi-book-fill','var(--success-soft)','var(--success)',\App\Models\LesPrivat::count(),'Total Les Privat','↑ 24% vs bulan lalu'],
        ['bi-patch-question-fill','var(--accent-soft)','var(--warning)',\App\Models\HasilKuis::sum('total_soal')??0,'Soal Dikerjakan','↑ 31% vs bulan lalu'],
        ['bi-clock-history','var(--info-soft)','var(--info)',round(\App\Models\AktivitasBelajar::avg('durasi_menit')??0).' mnt','Rata-rata Belajar','↑ 6 mnt per sesi'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div>
                <div class="stat-label">{{ $s[4] }}</div>
                <div class="stat-value">{{ $s[3] }}</div>
                <div class="stat-sub"><span class="up">{{ $s[5] }}</span></div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ROW 1 --}}
<div class="row g-3 mb-3">
    {{-- Grafik Aktivitas --}}
    <div class="col-12 col-xl-8">
        <div class="card-box">
            <div class="card-box-header">
                <div>
                    <div class="card-box-title">Aktivitas Pengguna — Bulan Ini</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:2px;">Pengguna aktif harian</div>
                </div>
                <div class="tab-nav">
                    <button class="tab-btn active" onclick="switchTab(this,'minggu')">Minggu</button>
                    <button class="tab-btn" onclick="switchTab(this,'bulan')">Bulan</button>
                    <button class="tab-btn" onclick="switchTab(this,'tahun')">Tahun</button>
                </div>
            </div>
            <div class="p-4">
                <div style="font-size:11px;color:var(--muted);margin-bottom:6px;font-weight:600;text-transform:uppercase;">SISWA</div>
                <div class="bar-chart" id="chartSiswa">
                    @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $i => $d)
                    <div class="bc-col"><div class="bc-bar" style="height:{{ [55,72,60,85,100,78,45][$i] }}%"></div><div class="bc-label">{{ $d }}</div></div>
                    @endforeach
                </div>
                <div style="font-size:11px;color:var(--muted);margin:12px 0 6px;font-weight:600;text-transform:uppercase;">TUTOR</div>
                <div class="bar-chart">
                    @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $i => $d)
                    <div class="bc-col"><div class="bc-bar accent" style="height:{{ [40,55,48,70,90,60,30][$i] }}%"></div><div class="bc-label">{{ $d }}</div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Feed Aktivitas --}}
    <div class="col-12 col-xl-4">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Aktivitas Terbaru</div>
                <span style="font-size:12px;color:var(--muted);">Hari ini</span>
            </div>
            @php
            $acts = [
                ['#eff6ff','var(--primary)','bi-person-plus-fill','Siswa baru mendaftar','Fajar Nugroho — SMA','5 mnt'],
                ['var(--success-soft)','var(--success)','bi-check-circle-fill','Kuis selesai dikerjakan','Matematika SMP — 92/100','12 mnt'],
                ['var(--accent-soft)','var(--warning)','bi-calendar-check-fill','Les privat dikonfirmasi','Fisika SMA — Tutor Budi','28 mnt'],
                ['var(--info-soft)','var(--info)','bi-upload','Materi baru diunggah','Kimia Kelas 11 — Bab 4','45 mnt'],
                ['#fce7f3','#be185d','bi-credit-card-fill','Pembayaran diterima','Rp 75.000 — Les Privat','1 jam'],
            ];
            @endphp
            @foreach($acts as $a)
            <div style="display:flex;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);align-items:flex-start;">
                <div style="width:34px;height:34px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:14px;background:{{ $a[0] }};color:{{ $a[1] }};"><i class="bi {{ $a[2] }}"></i></div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $a[3] }}</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:1px;">{{ $a[4] }}</div>
                </div>
                <div style="font-size:11px;color:var(--muted);white-space:nowrap;">{{ $a[5] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ROW 2: Materi + Heatmap --}}
<div class="row g-3 mb-3">
    {{-- Materi Terpopuler --}}
    <div class="col-12 col-xl-5">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Materi Terpopuler</div>
            </div>
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead><tr><th>#</th><th>Mata Pelajaran</th><th>Jenjang</th><th>Sesi</th><th>Progres</th></tr></thead>
                    <tbody>
                    @php
                    $mapels = [['Matematika','SMA',3284,100,'var(--primary)'],['Fisika','SMA',2741,83,'var(--primary-light)'],['Bahasa Inggris','SMP',2190,67,'var(--info)'],['Kimia','SMA',1854,56,'var(--accent)'],['IPA Terpadu','SMP',1623,49,'var(--success)'],];
                    $ranks = ['rank-1','rank-2','rank-3','rank-n','rank-n'];
                    @endphp
                    @foreach($mapels as $i => $m)
                    <tr>
                        <td><span class="rank-num {{ $ranks[$i] }}">{{ $i+1 }}</span></td>
                        <td style="font-weight:600;">{{ $m[0] }}</td>
                        <td><span style="background:#eff6ff;color:var(--primary);font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;">{{ $m[1] }}</span></td>
                        <td><strong>{{ number_format($m[2]) }}</strong></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <div class="prog-track" style="flex:1;"><div class="prog-fill" style="width:{{ $m[3] }}%;background:{{ $m[4] }};"></div></div>
                                <span style="font-size:12px;font-weight:700;color:var(--text);width:32px;text-align:right;">{{ $m[3] }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Heatmap + Statistik --}}
    <div class="col-12 col-xl-7">
        <div class="row g-3">
            <div class="col-12">
                <div class="card-box">
                    <div class="card-box-header">
                        <div class="card-box-title">Heatmap Aktivitas Belajar</div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-size:11px;color:var(--muted);">Rendah</span>
                            @foreach(['#f1f5f9','#bfdbfe','#60a5fa','#2563eb','var(--primary)'] as $c)
                            <div style="width:13px;height:13px;border-radius:3px;background:{{ $c }};"></div>
                            @endforeach
                            <span style="font-size:11px;color:var(--muted);">Tinggi</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="d-flex gap-2 mb-2">
                            @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $d)
                            <div style="font-size:10px;color:var(--muted);width:28px;text-align:center;font-weight:600;">{{ $d }}</div>
                            @endforeach
                        </div>
                        @php
                        $heatRows = [[2,3,2,4,4,3,1],[3,2,4,3,4,2,0],[1,3,3,4,4,3,1],[2,2,3,4,3,2,0],[3,4,4,3,4,2,1]];
                        @endphp
                        @foreach($heatRows as $row)
                        <div class="d-flex gap-1 mb-1">
                            @foreach($row as $v)
                            <div class="hm-cell hm-{{ $v }}" style="width:28px;height:28px;"></div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ROW 3: Tutor Terbaik + Nilai --}}
<div class="row g-3">
    {{-- Tutor Terbaik --}}
    <div class="col-12 col-xl-6">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Tutor Terbaik Bulan Ini</div>
                <span style="font-size:12px;color:var(--muted);">Berdasarkan sesi selesai</span>
            </div>
            <table class="tbl">
                <thead><tr><th>#</th><th>Tutor</th><th>Mata Pelajaran</th><th>Sesi</th><th>Rating</th></tr></thead>
                <tbody>
                @php
                $tutors = \App\Models\User::where('role','tutor')->take(4)->get();
                $ranks2 = ['rank-1','rank-2','rank-3','rank-n'];
                @endphp
                @forelse($tutors as $i => $t)
                <tr>
                    <td><span class="rank-num {{ $ranks2[$i] ?? 'rank-n' }}">{{ $i+1 }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:32px;height:32px;border-radius:8px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">
                                {{ strtoupper(substr($t->name,0,1)) }}
                            </div>
                            <div style="font-weight:600;font-size:13px;">{{ $t->name }}</div>
                        </div>
                    </td>
                    <td>
                        @php $mapelTutor = $t->materi()->distinct('mata_pelajaran')->pluck('mata_pelajaran')->first() ?? 'Umum'; @endphp
                        <span style="background:#eff6ff;color:var(--primary);font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;">{{ $mapelTutor }}</span>
                    </td>
                    <td><strong>{{ $t->lesPrivat()->where('tutor_id',$t->id)->where('status','selesai')->count() }}</strong></td>
                    <td><span style="color:var(--accent);font-weight:700;">★ 4.{{ 8 + $i * 0 }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--muted);">Belum ada data tutor</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Nilai Rata-rata --}}
    <div class="col-12 col-xl-6">
        <div class="card-box">
            <div class="card-box-header">
                <div class="card-box-title">Rata-rata Nilai Kuis</div>
                <span style="font-size:12px;color:var(--muted);">Semua latihan soal</span>
            </div>
            <div class="p-4 d-flex flex-column gap-3">
                @php
                $nilaiData = [['Matematika',78,'var(--primary)'],['Bahasa Inggris',82,'var(--info)'],['Fisika',72,'var(--warning)'],['Kimia',66,'var(--danger)'],['Biologi',80,'var(--success)']];
                @endphp
                @foreach($nilaiData as $n)
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:13px;font-weight:600;">{{ $n[0] }}</span>
                        <span style="font-size:13px;font-weight:700;color:{{ $n[2] }};">{{ $n[1] }}</span>
                    </div>
                    <div class="prog-track"><div class="prog-fill" style="width:{{ $n[1] }}%;background:{{ $n[2] }};"></div></div>
                </div>
                @endforeach
                <div style="background:#f8fafc;border-radius:10px;padding:12px 16px;display:flex;justify-content:space-between;margin-top:4px;">
                    <div style="text-align:center;"><div style="font-size:20px;font-weight:800;color:var(--primary);">77.3</div><div style="font-size:11px;color:var(--muted);">Rata-rata</div></div>
                    <div style="width:1px;background:var(--border);"></div>
                    <div style="text-align:center;"><div style="font-size:20px;font-weight:800;color:var(--success);">92%</div><div style="font-size:11px;color:var(--muted);">Kelulusan</div></div>
                    <div style="width:1px;background:var(--border);"></div>
                    <div style="text-align:center;"><div style="font-size:20px;font-weight:800;color:var(--accent);">4.8</div><div style="font-size:11px;color:var(--muted);">Avg Rating</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(el, period) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    const data = { minggu:[55,72,60,85,100,78,45], bulan:[60,65,70,75,80,72,68], tahun:[50,58,65,70,85,90,95] };
    document.querySelectorAll('#chartSiswa .bc-bar').forEach((bar,i) => { bar.style.height = data[period][i] + '%'; });
}
</script>
@endpush