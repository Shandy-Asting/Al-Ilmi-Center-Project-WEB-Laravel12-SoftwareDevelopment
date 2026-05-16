@extends('layouts.app')

@section('title', 'Pengelolaan Pengguna - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Pengelolaan Pengguna')
@section('page-sub', 'Admin / Pengelolaan Pengguna')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/admin/dashboard" class="nav-item-custom"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <div class="menu-label">Pengelolaan</div>
    <a href="/admin/pengguna" class="nav-item-custom active"><i class="bi bi-people-fill"></i> Pengelolaan Pengguna</a>
    <a href="/admin/paket" class="nav-item-custom"><i class="bi bi-box-seam"></i> Pengelolaan Paket</a>
    <a href="/admin/transaksi" class="nav-item-custom"><i class="bi bi-credit-card-fill"></i> Transaksi</a>
    <a href="/admin/pembayaran" class="nav-item-custom"><i class="bi bi-cash-coin"></i> Pembayaran & Gaji</a>
    <a href="/admin/rekening" class="nav-item-custom"><i class="bi bi-bank"></i> Rekening Bank</a>
    <a href="/admin/laporan" class="nav-item-custom"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
@endsection

@push('styles')
<style>
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:all .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.08);}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .stat-val{font-size:1.5rem;font-weight:800;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}
    .tab-nav{display:flex;gap:6px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .tab-btn{flex:1;text-align:center;padding:9px 8px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .tab-btn.active{background:var(--primary);color:#fff;}
    .tab-btn:hover:not(.active){background:var(--bg);color:var(--primary);}
    .tab-count{font-size:10px;background:rgba(255,255,255,.25);color:inherit;border-radius:20px;padding:1px 6px;margin-left:4px;font-weight:700;}
    .tab-btn:not(.active) .tab-count{background:var(--border);color:var(--muted);}
    .tab-pane{display:none;}.tab-pane.active{display:block;}
    .card-box{background:var(--card-bg);border-radius:14px;border:1px solid var(--border);overflow:hidden;}
    .card-box-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:14px;font-weight:700;color:var(--text);}
    .filter-bar{padding:12px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;flex-wrap:wrap;gap:10px;}
    .search-wrap{flex:1;min-width:180px;position:relative;}
    .search-wrap i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--muted);}
    .search-wrap input{width:100%;padding:8px 12px 8px 34px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;outline:none;background:var(--bg);}
    .search-wrap input:focus{border-color:var(--primary);}
    .filter-select{padding:8px 28px 8px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:12.5px;background:var(--bg);color:var(--text);outline:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{background:#f8fafc;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;padding:10px 14px;border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:12px 14px;font-size:13px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#fafcff;}
    .user-av{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#fff;flex-shrink:0;}
    .act-btn{width:30px;height:30px;border-radius:8px;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;cursor:pointer;transition:all .2s;color:var(--muted);}
    .act-btn:hover{border-color:var(--primary);color:var(--primary);background:#eff6ff;}
    .act-btn.del:hover{border-color:var(--danger);color:var(--danger);background:var(--danger-soft);}
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:16px;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:100%;max-width:520px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:#fff;z-index:1;}
    .modal-head h5{font-size:15px;font-weight:800;}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .form-label-c{font-size:13px;font-weight:600;margin-bottom:6px;display:block;}
    .form-input-c{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;outline:none;background:#fff;transition:border .2s;}
    .form-input-c:focus{border-color:var(--primary);}
    .detail-row{display:flex;gap:8px;padding:10px 0;border-bottom:1px solid var(--border);}
    .detail-row:last-child{border-bottom:none;}
    .detail-label{font-size:12px;color:var(--muted);font-weight:500;width:130px;flex-shrink:0;}
    .detail-value{font-size:13px;font-weight:600;flex:1;}
    @media(max-width:767px){.tab-nav{overflow-x:auto;flex-wrap:nowrap;}.tab-btn{min-width:100px;flex:none;}.tbl{font-size:11.5px;}.filter-bar{flex-direction:column;}.search-wrap,.filter-select{width:100%;}}
</style>
@endpush

@section('content')

<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">👥 Pengelolaan Pengguna</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Kelola data siswa dan tutor terdaftar</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $statCards = [
        ['bi-mortarboard-fill','#eff6ff','var(--primary)',\App\Models\User::where('role','siswa')->count(),'Total Siswa'],
        ['bi-person-video3','var(--info-soft)','var(--info)',\App\Models\User::where('role','tutor')->count(),'Total Tutor'],
        ['bi-person-check-fill','var(--success-soft)','var(--success)',\App\Models\User::count(),'Total Aktif'],
        ['bi-person-exclamation','var(--warning-soft)','var(--warning)','0','Verifikasi Pending'],
    ];
    @endphp
    @foreach($statCards as $s)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div><div class="stat-val">{{ $s[3] }}</div><div class="stat-label">{{ $s[4] }}</div></div>
        </div>
    </div>
    @endforeach
</div>

{{-- TABS --}}
<div class="tab-nav">
    <button class="tab-btn active" onclick="switchPenggunaTab(this,'siswa')">
        <i class="bi bi-mortarboard-fill me-1"></i> Data Siswa
        <span class="tab-count">{{ \App\Models\User::where('role','siswa')->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchPenggunaTab(this,'tutor')">
        <i class="bi bi-person-video3 me-1"></i> Data Tutor
        <span class="tab-count">{{ \App\Models\User::where('role','tutor')->count() }}</span>
    </button>
</div>

{{-- TAB SISWA --}}
<div class="tab-pane active" id="tab-siswa">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-mortarboard-fill me-2" style="color:var(--primary);"></i>Daftar Siswa</div>
            <div class="d-flex gap-2">
                <button style="padding:7px 14px;border-radius:8px;border:1.5px solid var(--border);background:var(--bg);font-size:12.5px;font-weight:600;cursor:pointer;color:var(--muted);">
                    <i class="bi bi-download me-1"></i> Export
                </button>
            </div>
        </div>
        <div class="filter-bar">
            <div class="search-wrap"><i class="bi bi-search"></i><input type="text" placeholder="Cari nama atau email…"/></div>
            <select class="filter-select"><option>Semua Status</option><option>Aktif</option><option>Tidak Aktif</option></select>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead><tr><th>Siswa</th><th>No. HP</th><th>Tanggal Daftar</th><th>Total Les</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse(\App\Models\User::where('role','siswa')->latest()->paginate(10) as $u)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div class="user-av" style="background:var(--primary);">{{ strtoupper(substr($u->name,0,1)) }}</div>
                            <div>
                                <div style="font-weight:600;font-size:13px;">{{ $u->name }}</div>
                                <div style="font-size:11px;color:var(--muted);">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12.5px;color:var(--muted);">{{ $u->no_hp ?? '-' }}</td>
                    <td style="font-size:12.5px;color:var(--muted);">{{ $u->created_at->format('d M Y') }}</td>
                    <td style="text-align:center;font-weight:700;color:var(--primary);">
                        {{ \App\Models\LesPrivat::where('user_id',$u->id)->count() }}
                    </td>
                    <td><span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;"><i class="bi bi-circle-fill" style="font-size:6px;"></i> Aktif</span></td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <button class="act-btn" onclick="openDetailSiswa('{{ $u->name }}','{{ $u->email }}','{{ $u->no_hp ?? '-' }}','{{ $u->created_at->format('d M Y') }}')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted);"><i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada siswa terdaftar</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:12px 18px;border-top:1px solid var(--border);font-size:12.5px;color:var(--muted);">
            Menampilkan {{ \App\Models\User::where('role','siswa')->count() }} siswa
        </div>
    </div>
</div>

{{-- TAB TUTOR --}}
<div class="tab-pane" id="tab-tutor">
    <div class="card-box">
        <div class="card-box-header">
            <div class="card-box-title"><i class="bi bi-person-video3 me-2" style="color:var(--info);"></i>Daftar Tutor</div>
            <div class="d-flex gap-2">
                <button style="padding:7px 14px;border-radius:8px;border:1.5px solid var(--border);background:var(--bg);font-size:12.5px;font-weight:600;cursor:pointer;color:var(--muted);">
                    <i class="bi bi-download me-1"></i> Export
                </button>
            </div>
        </div>
        <div class="filter-bar">
            <div class="search-wrap"><i class="bi bi-search"></i><input type="text" placeholder="Cari nama atau email…"/></div>
            <select class="filter-select"><option>Semua Status</option><option>Aktif</option><option>Tidak Aktif</option></select>
        </div>
        <div style="overflow-x:auto;">
            <table class="tbl">
                <thead><tr><th>Tutor</th><th>No. HP</th><th>Mata Pelajaran</th><th>Total Sesi</th><th>Sesi Selesai</th><th>Bergabung</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse(\App\Models\User::where('role','tutor')->latest()->get() as $u)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div class="user-av" style="background:var(--info);">{{ strtoupper(substr($u->name,0,1)) }}</div>
                            <div>
                                <div style="font-weight:600;font-size:13px;">{{ $u->name }}</div>
                                <div style="font-size:11px;color:var(--muted);">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12.5px;color:var(--muted);">{{ $u->no_hp ?? '-' }}</td>
                    <td>
                        @php $mapel = $u->materi()->distinct('mata_pelajaran')->pluck('mata_pelajaran')->take(2)->join(', ') ?: '-'; @endphp
                        <span style="font-size:12px;">{{ $mapel }}</span>
                    </td>
                    <td style="text-align:center;font-weight:700;color:var(--primary);">
                        {{ \App\Models\LesPrivat::where('tutor_id',$u->id)->count() }}
                    </td>
                    <td style="text-align:center;font-weight:700;color:var(--success);">
                        {{ \App\Models\LesPrivat::where('tutor_id',$u->id)->where('status','selesai')->count() }}
                    </td>
                    <td style="font-size:12.5px;color:var(--muted);">{{ $u->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <button class="act-btn" onclick="openDetailTutor('{{ $u->name }}','{{ $u->email }}','{{ $u->no_hp ?? '-' }}','{{ $mapel }}','{{ $u->created_at->format('d M Y') }}')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted);"><i class="bi bi-person-video3" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada tutor terdaftar</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:12px 18px;border-top:1px solid var(--border);font-size:12.5px;color:var(--muted);">
            Menampilkan {{ \App\Models\User::where('role','tutor')->count() }} tutor
        </div>
    </div>
</div>

{{-- MODAL DETAIL SISWA --}}
<div class="modal-overlay" id="modal-detail-siswa">
    <div class="modal-box" style="max-width:460px;">
        <div class="modal-head">
            <h5><i class="bi bi-person-circle me-2" style="color:var(--primary);"></i>Detail Siswa</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-detail-siswa').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            <div style="text-align:center;margin-bottom:18px;">
                <div id="detail-av" style="width:64px;height:64px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;margin:0 auto 8px;"></div>
                <div id="detail-nama" style="font-size:16px;font-weight:800;"></div>
                <div id="detail-email" style="font-size:12.5px;color:var(--muted);"></div>
            </div>
            <div id="detail-rows"></div>
            <button onclick="document.getElementById('modal-detail-siswa').classList.remove('show')"
                style="width:100%;margin-top:16px;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- MODAL DETAIL TUTOR --}}
<div class="modal-overlay" id="modal-detail-tutor">
    <div class="modal-box" style="max-width:460px;">
        <div class="modal-head">
            <h5><i class="bi bi-person-video3 me-2" style="color:var(--info);"></i>Detail Tutor</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-detail-tutor').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="padding:20px 22px;">
            <div style="text-align:center;margin-bottom:18px;">
                <div id="tutor-av" style="width:64px;height:64px;border-radius:50%;background:var(--info);color:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;margin:0 auto 8px;"></div>
                <div id="tutor-nama" style="font-size:16px;font-weight:800;"></div>
                <div id="tutor-email" style="font-size:12.5px;color:var(--muted);"></div>
            </div>
            <div id="tutor-rows"></div>
            <button onclick="document.getElementById('modal-detail-tutor').classList.remove('show')"
                style="width:100%;margin-top:16px;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchPenggunaTab(el, id) {
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    ['siswa','tutor'].forEach(t => {
        const el = document.getElementById('tab-'+t);
        if(el) el.classList.toggle('active', t === id);
    });
}
function openDetailSiswa(nama, email, hp, bergabung) {
    document.getElementById('detail-av').textContent = nama.charAt(0).toUpperCase();
    document.getElementById('detail-nama').textContent = nama;
    document.getElementById('detail-email').textContent = email;
    document.getElementById('detail-rows').innerHTML = `
        <div class="detail-row"><div class="detail-label">No. HP</div><div class="detail-value">${hp}</div></div>
        <div class="detail-row"><div class="detail-label">Bergabung</div><div class="detail-value">${bergabung}</div></div>
        <div class="detail-row"><div class="detail-label">Role</div><div class="detail-value"><span style="background:#eff6ff;color:var(--primary);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">Siswa</span></div></div>
    `;
    document.getElementById('modal-detail-siswa').classList.add('show');
}
function openDetailTutor(nama, email, hp, mapel, bergabung) {
    document.getElementById('tutor-av').textContent = nama.charAt(0).toUpperCase();
    document.getElementById('tutor-nama').textContent = nama;
    document.getElementById('tutor-email').textContent = email;
    document.getElementById('tutor-rows').innerHTML = `
        <div class="detail-row"><div class="detail-label">No. HP</div><div class="detail-value">${hp}</div></div>
        <div class="detail-row"><div class="detail-label">Mata Pelajaran</div><div class="detail-value">${mapel}</div></div>
        <div class="detail-row"><div class="detail-label">Bergabung</div><div class="detail-value">${bergabung}</div></div>
        <div class="detail-row"><div class="detail-label">Status</div><div class="detail-value"><span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">Aktif & Terverifikasi</span></div></div>
    `;
    document.getElementById('modal-detail-tutor').classList.add('show');
}
</script>
@endpush