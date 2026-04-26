@extends('layouts.app')

@section('title', 'Pengelolaan Soal - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Bank Soal')
@section('page-sub', 'Dashboard / Akademik / Bank Soal')

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
    .stat-card{background:var(--card-bg);border-radius:16px;padding:18px 20px;border:1px solid var(--border);display:flex;align-items:flex-start;gap:14px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
    .stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;}
    .stat-val{font-size:1.6rem;font-weight:800;line-height:1;color:var(--text);}
    .stat-label{font-size:.78rem;color:var(--muted);margin-top:4px;}

    /* ── FILTER BAR ── */
    .filter-bar{background:var(--card-bg);border-radius:14px;border:1px solid var(--border);padding:16px 20px;display:flex;align-items:center;flex-wrap:wrap;gap:12px;}
    .search-wrap{flex:1;min-width:220px;position:relative;}
    .search-wrap i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.9rem;}
    .search-wrap input{width:100%;padding:9px 12px 9px 36px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;background:var(--bg);color:var(--text);outline:none;transition:border .2s;}
    .search-wrap input:focus{border-color:var(--primary);background:#fff;}
    .filter-select{padding:9px 32px 9px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.83rem;background:var(--bg);color:var(--text);outline:none;cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;}

    /* ── TABEL SOAL ── */
    .table-soal{width:100%;border-collapse:collapse;}
    .table-soal thead th{padding:11px 16px;font-size:.73rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;background:var(--bg);border-bottom:1px solid var(--border);white-space:nowrap;}
    .table-soal tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
    .table-soal tbody tr:last-child{border-bottom:none;}
    .table-soal tbody tr:hover{background:#f8faff;}
    .table-soal tbody td{padding:13px 16px;font-size:.84rem;vertical-align:middle;color:var(--text);}

    .soal-num{width:32px;height:32px;border-radius:8px;background:#eff6ff;color:var(--primary);font-weight:700;font-size:.82rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .soal-preview{font-size:.86rem;font-weight:500;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;max-width:380px;color:var(--text);}
    .soal-sub{font-size:.73rem;color:var(--muted);margin-top:3px;display:flex;gap:10px;flex-wrap:wrap;}

    /* Badges */
    .badge-jenjang{font-size:.67rem;font-weight:700;padding:3px 8px;border-radius:20px;}
    .badge-mapel{font-size:.67rem;font-weight:600;padding:3px 8px;border-radius:20px;background:#eff6ff;color:var(--primary);}
    .badge-tipe-soal{font-size:.67rem;font-weight:700;padding:3px 9px;border-radius:6px;}
    .badge-tipe-soal.pg{background:#dbeafe;color:#1d4ed8;}
    .badge-tipe-soal.esai{background:#f5f3ff;color:#6d28d9;}
    .badge-tipe-soal.bs{background:#f0fdfa;color:#0d9488;}
    .badge-tipe-soal.isian{background:var(--accent-soft);color:var(--warning);}
    .badge-sulit{font-size:.67rem;font-weight:700;padding:3px 9px;border-radius:20px;}
    .badge-sulit.mudah{background:var(--success-soft);color:var(--success);}
    .badge-sulit.sedang{background:var(--accent-soft);color:var(--warning);}
    .badge-sulit.sulit{background:var(--danger-soft);color:var(--danger);}
    .badge-status{font-size:.68rem;font-weight:700;padding:4px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;}
    .badge-status::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;}
    .badge-status.aktif{background:var(--success-soft);color:var(--success);}
    .badge-status.draft{background:var(--accent-soft);color:var(--warning);}

    .btn-action{width:30px;height:30px;border-radius:8px;border:1px solid var(--border);background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);font-size:.82rem;transition:all .2s;}
    .btn-action:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
    .btn-action.del:hover{background:var(--danger);color:#fff;border-color:var(--danger);}
    .btn-action.suc:hover{background:var(--success);color:#fff;border-color:var(--success);}

    /* ── PAGINATION ── */
    .page-btn{width:34px;height:34px;border-radius:8px;border:1px solid var(--border);background:var(--card-bg);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.82rem;font-weight:600;color:var(--muted);transition:all .2s;text-decoration:none;}
    .page-btn:hover{background:#eff6ff;color:var(--primary);border-color:var(--primary);}
    .page-btn.active{background:var(--primary);color:#fff;border-color:var(--primary);}
    .page-btn.disabled{opacity:.4;pointer-events:none;}

    /* ── MODAL ── */
    .modal-custom .modal-content{border-radius:18px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15);}
    .form-label-custom{font-size:.82rem;font-weight:600;color:var(--text);margin-bottom:6px;display:block;}
    .form-control-custom{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;color:var(--text);outline:none;transition:border .2s;background:#fff;resize:vertical;}
    .form-control-custom:focus{border-color:var(--primary);}

    /* Opsi jawaban */
    .option-row{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
    .option-label{width:30px;height:30px;border-radius:8px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.82rem;flex-shrink:0;color:var(--muted);}
    .option-label.correct{background:var(--success-soft);border-color:var(--success);color:var(--success);}
    .option-input{flex:1;padding:8px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:.84rem;outline:none;transition:border .2s;color:var(--text);}
    .option-input:focus{border-color:var(--primary);}
    .option-input.correct-input{border-color:var(--success);background:var(--success-soft);}
    .btn-add-option{width:100%;padding:8px;border:1.5px dashed var(--border);border-radius:9px;background:transparent;color:var(--muted);font-size:.82rem;cursor:pointer;transition:all .2s;}
    .btn-add-option:hover{border-color:var(--primary);color:var(--primary);background:#eff6ff;}

    .pembahasan-box{background:var(--success-soft);border:1px solid #a7f3d0;border-radius:12px;padding:14px 16px;}
    .pembahasan-label{font-size:.78rem;font-weight:700;color:var(--success);margin-bottom:6px;display:flex;align-items:center;gap:6px;}

    /* CARD BOX */
    .card-box{background:var(--card-bg);border-radius:16px;border:1px solid var(--border);}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .card-box-title{font-size:.95rem;font-weight:700;color:var(--text);}
    .card-box-title i{color:var(--primary);margin-right:6px;}
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-0">Bank Soal</h4>
        <p style="font-size:.85rem;color:var(--muted);margin:0;">Buat, kelola, dan atur soal latihan serta kuis untuk siswa Anda.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--bg);color:var(--primary);border-radius:10px;border:1.5px solid var(--primary);font-size:13px;"
            data-bs-toggle="modal" data-bs-target="#modalImport">
            <i class="bi bi-upload me-1"></i> Import Soal
        </button>
        <button class="btn btn-sm fw-bold px-3 py-2"
            style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;"
            data-bs-toggle="modal" data-bs-target="#modalBuat">
            <i class="bi bi-plus-lg me-1"></i> Buat Soal
        </button>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $stats = [
        ['bi-patch-question-fill','#eff6ff','var(--primary)','142','Total Soal'],
        ['bi-ui-radios','#dbeafe','#1d4ed8','98','Pilihan Ganda'],
        ['bi-pencil-fill','#f5f3ff','#6d28d9','31','Esai / Uraian'],
        ['bi-check2-square','#f0fdfa','#0d9488','13','Benar/Salah + Isian'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div>
                <div class="stat-val">{{ $s[3] }}</div>
                <div class="stat-label">{{ $s[4] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- FILTER BAR --}}
<div class="filter-bar mb-4">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Cari pertanyaan, topik, atau kata kunci…"/>
    </div>
    <select class="filter-select">
        <option>Semua Jenjang</option>
        <option>SD</option><option>SMP</option><option>SMA</option>
    </select>
    <select class="filter-select">
        <option>Semua Mapel</option>
        <option>Matematika</option><option>Fisika</option>
        <option>Kimia</option><option>Biologi</option><option>B. Inggris</option>
    </select>
    <select class="filter-select">
        <option>Semua Tipe</option>
        <option>Pilihan Ganda</option><option>Esai / Uraian</option>
        <option>Benar / Salah</option><option>Isian Singkat</option>
    </select>
    <select class="filter-select">
        <option>Semua Tingkat</option>
        <option>Mudah</option><option>Sedang</option><option>Sulit</option>
    </select>
    <select class="filter-select">
        <option>Semua Status</option>
        <option>Aktif</option><option>Draft</option>
    </select>
</div>

{{-- TABLE --}}
<div class="card-box mb-4">
    <div class="card-box-header">
        <div class="card-box-title"><i class="bi bi-list-check"></i> Daftar Soal</div>
        <div class="d-flex align-items-center gap-2">
            <span style="font-size:.8rem;color:var(--muted);">Menampilkan 1–10 dari 142 soal</span>
            <select class="filter-select" style="padding:6px 28px 6px 10px;font-size:.8rem;">
                <option>10 per halaman</option>
                <option>20 per halaman</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-soal">
            <thead>
                <tr>
                    <th style="width:36px;"><input type="checkbox" class="form-check-input"/></th>
                    <th style="width:48px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Jenjang</th>
                    <th>Mata Pelajaran</th>
                    <th>Tipe</th>
                    <th>Tingkat</th>
                    <th>Status</th>
                    <th>Digunakan</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php
            $soals = [
                ['Tentukan nilai dari sin 30° + cos 60° – tan 45°. Nyatakan hasilnya dalam bentuk pecahan paling sederhana.','Trigonometri','3 Apr 2026','SMA','#dbeafe','#1d4ed8','Matematika','','pg','sedang','aktif','3 kuis'],
                ['Sebuah bola dilempar horizontal dari ketinggian 20 m dengan kecepatan awal 10 m/s. Berapa jarak horizontal yang ditempuh?','Gerak Parabola','3 Apr 2026','SMA','#dbeafe','#1d4ed8','Fisika','var(--info-soft);color:var(--info)','pg','sulit','aktif','2 kuis'],
                ['Jelaskan perbedaan antara reaksi eksoterm dan endoterm. Berikan masing-masing dua contoh dalam kehidupan sehari-hari!','Termokimia','1 Apr 2026','SMA','#dbeafe','#1d4ed8','Kimia','var(--accent-soft);color:var(--warning)','esai','sedang','aktif','1 kuis'],
                ['Pernyataan berikut benar atau salah: "Gaya aksi dan reaksi bekerja pada benda yang sama."','Hukum Newton','4 Apr 2026','SMA','#dbeafe','#1d4ed8','Fisika','var(--info-soft);color:var(--info)','bs','mudah','aktif','4 kuis'],
                ['Hasil dari ∫(3x² + 2x – 5) dx adalah …','Integral','5 Apr 2026','SMA','#dbeafe','#1d4ed8','Matematika','','pg','sedang','draft','–'],
                ['Diketahui deret aritmetika dengan suku pertama 3 dan beda 5. Tentukan suku ke-20!','Barisan & Deret','2 Apr 2026','SMP','#f0fdf4','#16a34a','Matematika','','isian','mudah','aktif','2 kuis'],
                ['Rearrange the words: "always / she / early / comes / to / school"','Grammar','28 Mar 2026','SMP','#f0fdf4','#16a34a','B. Inggris','var(--success-soft);color:var(--success)','isian','mudah','aktif','1 kuis'],
                ['Berapa massa 2 mol air (H₂O)? (Ar H = 1, Ar O = 16)','Stoikiometri','1 Apr 2026','SMA','#dbeafe','#1d4ed8','Kimia','var(--accent-soft);color:var(--warning)','pg','sedang','aktif','3 kuis'],
                ['Pernyataan berikut benar atau salah: "Sel eukariotik tidak memiliki membran inti."','Biologi Sel','30 Mar 2026','SMA','#dbeafe','#1d4ed8','Biologi','#ecfdf5;color:#059669','bs','mudah','aktif','2 kuis'],
                ['Uraikan langkah-langkah metode eliminasi untuk menyelesaikan SPLDV: 2x + 3y = 12 dan x – y = 1.','SPLDV','2 Apr 2026','SMP','#f0fdf4','#16a34a','Matematika','','esai','sulit','draft','–'],
            ];
            @endphp

            @foreach($soals as $i => $s)
            <tr>
                <td><input type="checkbox" class="form-check-input"/></td>
                <td><div class="soal-num">{{ $i + 1 }}</div></td>
                <td>
                    <div class="soal-preview">{{ $s[0] }}</div>
                    <div class="soal-sub">
                        <span><i class="bi bi-folder2"></i>{{ $s[1] }}</span>
                        <span><i class="bi bi-calendar3"></i>{{ $s[2] }}</span>
                    </div>
                </td>
                <td><span class="badge-jenjang" style="background:{{ $s[4] }};color:{{ $s[5] }};">{{ $s[3] }}</span></td>
                <td><span class="badge-mapel">{{ $s[6] }}</span></td>
                <td><span class="badge-tipe-soal {{ $s[8] }}">{{ strtoupper($s[8]) === 'PG' ? 'Pil. Ganda' : ($s[8] === 'esai' ? 'Esai' : ($s[8] === 'bs' ? 'Benar/Salah' : 'Isian')) }}</span></td>
                <td><span class="badge-sulit {{ $s[9] }}">{{ ucfirst($s[9]) }}</span></td>
                <td><span class="badge-status {{ $s[10] }}">{{ ucfirst($s[10]) }}</span></td>
                <td style="font-size:.8rem;color:var(--muted);">{{ $s[11] }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn-action suc" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetail"><i class="bi bi-eye"></i></button>
                        <button class="btn-action" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>
                        <button class="btn-action" title="Duplikat"><i class="bi bi-copy"></i></button>
                        <button class="btn-action del" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapus"><i class="bi bi-trash3"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="d-flex align-items-center justify-content-between px-4 py-3 flex-wrap gap-2" style="border-top:1px solid var(--border);">
        <div class="d-flex gap-2">
            <button class="btn btn-sm rounded-2 fw-semibold" style="background:var(--danger-soft);color:var(--danger);border:none;font-size:.78rem;" data-bs-toggle="modal" data-bs-target="#modalHapus">
                <i class="bi bi-trash3 me-1"></i> Hapus Terpilih
            </button>
            <button class="btn btn-sm rounded-2 fw-semibold" style="background:#f1f5f9;border:none;color:var(--muted);font-size:.78rem;">
                <i class="bi bi-copy me-1"></i> Duplikat
            </button>
            <button class="btn btn-sm rounded-2 fw-semibold" style="background:#eff6ff;border:none;color:var(--primary);font-size:.78rem;">
                <i class="bi bi-download me-1"></i> Export
            </button>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:.78rem;color:var(--muted);">Halaman 1 dari 15</span>
            <div class="d-flex gap-1">
                <a href="#" class="page-btn disabled"><i class="bi bi-chevron-left"></i></a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <span class="page-btn" style="cursor:default;">…</span>
                <a href="#" class="page-btn">15</a>
                <a href="#" class="page-btn"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- MODAL BUAT SOAL --}}
<div class="modal fade modal-custom" id="modalBuat" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:700;">
                    <i class="bi bi-plus-circle-fill me-2" style="color:var(--primary);"></i>Buat Soal Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="p-3 rounded-3 mb-3" style="background:var(--bg);border:1px solid var(--border);">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label-custom">Jenjang <span class="text-danger">*</span></label>
                                    <select class="form-control-custom"><option value="">-- Pilih --</option><option>SD</option><option>SMP</option><option>SMA</option></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select class="form-control-custom"><option value="">-- Pilih --</option><option>Matematika</option><option>Fisika</option><option>Kimia</option></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom">Topik / Bab</label>
                                    <input type="text" class="form-control-custom" placeholder="Contoh: Trigonometri"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom">Tipe Soal <span class="text-danger">*</span></label>
                                    <select class="form-control-custom">
                                        <option value="">-- Pilih --</option>
                                        <option>Pilihan Ganda</option>
                                        <option>Esai / Uraian</option>
                                        <option>Benar / Salah</option>
                                        <option>Isian Singkat</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom">Tingkat Kesulitan</label>
                                    <select class="form-control-custom"><option>Mudah</option><option selected>Sedang</option><option>Sulit</option></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom">Bobot Nilai</label>
                                    <input type="number" class="form-control-custom" value="10"/>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Teks Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control-custom" rows="4" placeholder="Tuliskan pertanyaan di sini…"></textarea>
                        </div>

                        <label class="form-label-custom">Opsi Jawaban</label>
                        @foreach(['A','B','C','D'] as $opt)
                        <div class="option-row">
                            <div class="option-label {{ $opt === 'A' ? 'correct' : '' }}">{{ $opt }}</div>
                            <input type="text" class="option-input {{ $opt === 'A' ? 'correct-input' : '' }}" placeholder="Opsi {{ $opt }}"/>
                            <button type="button" class="btn-action"><i class="bi bi-x"></i></button>
                        </div>
                        @endforeach
                        <button type="button" class="btn-add-option mt-1">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Opsi
                        </button>

                        <div class="mt-3">
                            <label class="form-label-custom">Pembahasan / Kunci Jawaban</label>
                            <div class="pembahasan-box">
                                <div class="pembahasan-label"><i class="bi bi-lightbulb-fill"></i> Pembahasan Jawaban</div>
                                <textarea class="form-control-custom" rows="3" style="background:transparent;border-color:#a7f3d0;" placeholder="Tuliskan pembahasan atau cara penyelesaian soal ini…"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card-box p-3 mb-3">
                            <div style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:10px;">
                                <i class="bi bi-gear me-1" style="color:var(--primary);"></i> Pengaturan
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Waktu Pengerjaan</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="number" class="form-control-custom" value="2" style="width:70px;"/>
                                    <span style="font-size:.82rem;color:var(--muted);">menit</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Masuk ke Kuis</label>
                                <select class="form-control-custom">
                                    <option>– Tidak ditambahkan –</option>
                                    <option>Kuis Trigonometri SMA</option>
                                    <option>Latihan UTBK Matematika</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label-custom">Status</label>
                                <select class="form-control-custom">
                                    <option>Draft</option>
                                    <option>Aktif (terbit)</option>
                                </select>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" checked/>
                                <label class="form-check-label" style="font-size:.83rem;">Acak urutan opsi jawaban</label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" checked/>
                                <label class="form-check-label" style="font-size:.83rem;">Tampilkan pembahasan setelah kuis</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn rounded-2 fw-semibold" style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;" data-bs-dismiss="modal">Batal</button>
                <button class="btn rounded-2 fw-semibold" style="background:var(--bg);color:var(--primary);font-size:.85rem;border:1px solid var(--primary);">
                    <i class="bi bi-floppy me-1"></i> Simpan Draft
                </button>
                <button class="btn rounded-2 fw-semibold" style="background:var(--primary);color:#fff;font-size:.85rem;border:none;">
                    <i class="bi bi-check2-circle me-1"></i> Simpan & Terbitkan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade modal-custom" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:700;">
                    <i class="bi bi-eye-fill me-2" style="color:var(--success);"></i>Detail Soal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge-jenjang" style="background:#dbeafe;color:#1d4ed8;">SMA</span>
                    <span class="badge-mapel">Matematika</span>
                    <span class="badge-tipe-soal pg">Pil. Ganda</span>
                    <span class="badge-sulit sedang">Sedang</span>
                    <span class="badge-status aktif">Aktif</span>
                    <span class="ms-auto" style="font-size:.75rem;color:var(--muted);"><i class="bi bi-folder2 me-1"></i>Trigonometri</span>
                </div>
                <div style="background:var(--bg);border-radius:12px;padding:16px;border:1px solid var(--border);margin-bottom:16px;">
                    <div style="font-size:.73rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">Pertanyaan</div>
                    <div style="font-size:.9rem;font-weight:500;line-height:1.6;color:var(--text);">
                        Tentukan nilai dari <strong>sin 30° + cos 60° – tan 45°</strong>. Nyatakan hasilnya dalam bentuk pecahan paling sederhana.
                    </div>
                </div>
                <div class="mb-4">
                    <div style="font-size:.73rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">Opsi Jawaban</div>
                    @php
                    $opts = [['A','½',true],['B','¾',false],['C','1',false],['D','¼',false]];
                    @endphp
                    @foreach($opts as $o)
                    <div style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;margin-bottom:6px;{{ $o[2] ? 'background:var(--success-soft);border:1px solid #a7f3d0;font-weight:600;color:#065f46;' : 'background:#fff;border:1px solid var(--border);color:var(--muted);' }}">
                        <div style="width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;background:{{ $o[2] ? 'var(--success)' : 'var(--border)' }};color:{{ $o[2] ? '#fff' : 'var(--muted)' }};flex-shrink:0;">{{ $o[0] }}</div>
                        {{ $o[1] }}
                        @if($o[2])<span class="ms-auto" style="font-size:.75rem;"><i class="bi bi-check-circle-fill text-success"></i> Jawaban Benar</span>@endif
                    </div>
                    @endforeach
                </div>
                <div class="pembahasan-box mb-4">
                    <div class="pembahasan-label"><i class="bi bi-lightbulb-fill"></i> Pembahasan</div>
                    <p style="font-size:.84rem;margin:0;line-height:1.7;color:var(--text);">
                        sin 30° = ½ | cos 60° = ½ | tan 45° = 1<br/>
                        Substitusi: ½ + ½ – 1 = <strong>0</strong>
                    </p>
                </div>
                <div class="row g-3">
                    <div class="col-4 text-center">
                        <div style="font-size:1.4rem;font-weight:800;color:var(--primary);">3</div>
                        <div style="font-size:.75rem;color:var(--muted);">Kuis menggunakan</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size:1.4rem;font-weight:800;color:var(--success);">78%</div>
                        <div style="font-size:.75rem;color:var(--muted);">Tingkat kebenaran</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size:1.4rem;font-weight:800;color:var(--accent);">42</div>
                        <div style="font-size:.75rem;color:var(--muted);">Dijawab siswa</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn rounded-2 fw-semibold" style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;" data-bs-dismiss="modal">Tutup</button>
                <button class="btn rounded-2 fw-semibold" style="background:var(--warning);color:#fff;font-size:.85rem;border:none;" data-bs-toggle="modal" data-bs-target="#modalEdit" data-bs-dismiss="modal">
                    <i class="bi bi-pencil me-1"></i> Edit Soal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade modal-custom" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:700;">
                    <i class="bi bi-pencil-square me-2" style="color:var(--warning);"></i>Edit Soal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background:var(--accent-soft);border:1px solid var(--accent);">
                    <div class="soal-num">1</div>
                    <div>
                        <div style="font-weight:600;font-size:.86rem;color:var(--text);">Trigonometri – Pilihan Ganda</div>
                        <div style="font-size:.73rem;color:var(--muted);">SMA · Matematika · Sedang · Digunakan di 3 kuis</div>
                    </div>
                    <span class="badge-status aktif ms-auto">Aktif</span>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Teks Pertanyaan</label>
                    <textarea class="form-control-custom" rows="4">Tentukan nilai dari sin 30° + cos 60° – tan 45°. Nyatakan hasilnya dalam bentuk pecahan paling sederhana.</textarea>
                </div>
                <label class="form-label-custom">Opsi Jawaban</label>
                @php $editOpts = [['A','½',true],['B','¾',false],['C','1',false],['D','¼',false]]; @endphp
                @foreach($editOpts as $o)
                <div class="option-row">
                    <div class="option-label {{ $o[2] ? 'correct' : '' }}">{{ $o[0] }}</div>
                    <input type="text" class="option-input {{ $o[2] ? 'correct-input' : '' }}" value="{{ $o[1] }}"/>
                    <button type="button" class="btn-action"><i class="bi bi-x"></i></button>
                </div>
                @endforeach
                <div class="mt-3">
                    <label class="form-label-custom">Pembahasan</label>
                    <div class="pembahasan-box">
                        <div class="pembahasan-label"><i class="bi bi-lightbulb-fill"></i> Pembahasan</div>
                        <textarea class="form-control-custom" rows="3" style="background:transparent;border-color:#a7f3d0;">sin 30° = ½, cos 60° = ½, tan 45° = 1. Maka ½ + ½ – 1 = 0.</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn rounded-2 fw-semibold" style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;" data-bs-dismiss="modal">Batal</button>
                <button class="btn rounded-2 fw-semibold" style="background:var(--warning);color:#fff;font-size:.85rem;border:none;">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade modal-custom" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div style="width:64px;height:64px;border-radius:50%;background:var(--danger-soft);display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--danger);margin:0 auto 16px;">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <h5 style="font-weight:700;margin-bottom:8px;color:var(--text);">Hapus Soal?</h5>
                <p style="font-size:.86rem;color:var(--muted);margin-bottom:4px;">Anda akan menghapus soal ini secara permanen.</p>
                <div class="p-3 rounded-3 mb-3 text-start" style="background:var(--danger-soft);border:1px solid #fecaca;">
                    <div style="font-size:.78rem;color:var(--danger);font-weight:600;"><i class="bi bi-exclamation-triangle-fill me-1"></i> Perhatian</div>
                    <div style="font-size:.77rem;color:#7f1d1d;margin-top:4px;">Soal ini digunakan di <strong>3 kuis aktif</strong>. Menghapusnya akan otomatis menghapus dari semua kuis tersebut.</div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn rounded-2 fw-semibold flex-fill" style="background:#f1f5f9;color:var(--muted);border:none;font-size:.85rem;" data-bs-dismiss="modal">Batalkan</button>
                    <button class="btn rounded-2 fw-semibold flex-fill" style="background:var(--danger);color:#fff;border:none;font-size:.85rem;"><i class="bi bi-trash3 me-1"></i> Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT --}}
<div class="modal fade modal-custom" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:700;">
                    <i class="bi bi-upload me-2" style="color:var(--primary);"></i>Import Soal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:.84rem;color:var(--muted);margin-bottom:16px;">Upload file soal dalam format yang didukung.</p>
                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <span class="badge-tipe-soal pg py-2 px-3" style="border-radius:10px;">Excel (.xlsx)</span>
                    <span class="badge-tipe-soal esai py-2 px-3" style="border-radius:10px;">Word (.docx)</span>
                    <span class="badge-tipe-soal bs py-2 px-3" style="border-radius:10px;">JSON</span>
                </div>
                <div style="border:2px dashed var(--border);border-radius:12px;padding:28px;text-align:center;background:var(--bg);cursor:pointer;transition:all .2s;">
                    <div style="font-size:2rem;color:var(--muted);margin-bottom:8px;"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                    <div style="font-size:.84rem;color:var(--muted);">
                        <strong style="color:var(--primary);">Klik untuk pilih file</strong> atau drag & drop<br/>
                        <span style="font-size:.76rem;">xlsx, docx, json – Maks. 10 MB</span>
                    </div>
                </div>
                <div class="mt-3 p-3 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div style="font-size:.78rem;font-weight:700;color:var(--primary);margin-bottom:4px;"><i class="bi bi-info-circle me-1"></i>Panduan Format</div>
                    <div style="font-size:.75rem;color:#1e40af;">
                        Download <a href="#" style="color:var(--primary);font-weight:600;">template Excel</a> atau <a href="#" style="color:var(--primary);font-weight:600;">template Word</a> untuk memastikan format file sesuai.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn rounded-2 fw-semibold" style="background:#f1f5f9;color:var(--muted);font-size:.85rem;border:none;" data-bs-dismiss="modal">Batal</button>
                <button class="btn rounded-2 fw-semibold" style="background:var(--primary);color:#fff;font-size:.85rem;border:none;"><i class="bi bi-upload me-1"></i> Import Sekarang</button>
            </div>
        </div>
    </div>
</div>

@endsection