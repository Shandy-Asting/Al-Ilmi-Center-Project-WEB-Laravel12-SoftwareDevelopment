@extends('layouts.app')

@section('title', 'Profil Tutor - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Profil Saya')
@section('page-sub', 'Dashboard / Profil')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/tutor/dashboard" class="nav-item-custom {{ request()->is('tutor/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
    <a href="/tutor/jadwal" class="nav-item-custom {{ request()->is('tutor/jadwal') ? 'active' : '' }}">
        <i class="bi bi-calendar3"></i> Jadwal Mengajar
        <span class="nav-badge">3</span>
    </a>
    <a href="/tutor/daftar-siswa" class="nav-item-custom {{ request()->is('tutor/daftar-siswa') ? 'active' : '' }}">
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
    </a>
    <div class="menu-label">Akun</div>
    <a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@push('styles')
<style>
    /* ── PROFILE HEADER ── */
    .profile-header{background:linear-gradient(135deg,var(--primary) 0%,var(--primary-light) 60%,#3b6fa0 100%);border-radius:20px;padding:28px 32px;color:#fff;position:relative;overflow:hidden;margin-bottom:24px;}
    .profile-header::before{content:'';position:absolute;top:-60px;right:-60px;width:250px;height:250px;border-radius:50%;background:rgba(255,255,255,.05);}
    .profile-header::after{content:'';position:absolute;bottom:-80px;left:40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.04);}
    .profile-avatar{width:80px;height:80px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:var(--primary);border:3px solid rgba(255,255,255,.3);flex-shrink:0;position:relative;z-index:1;}
    .profile-name{font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;}
    .profile-role{font-size:13px;opacity:.75;color:#fff;}
    .profile-stats{display:flex;gap:24px;margin-top:16px;position:relative;z-index:1;flex-wrap:wrap;}
    .ps-val{font-size:22px;font-weight:800;color:#fff;line-height:1;}
    .ps-label{font-size:11px;opacity:.7;color:#fff;margin-top:2px;}

    /* ── SECTION TABS ── */
    .section-tabs{display:flex;gap:4px;background:var(--card-bg);border:1px solid var(--border);border-radius:12px;padding:5px;margin-bottom:24px;}
    .section-tab{flex:1;text-align:center;padding:8px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;color:var(--muted);border:none;background:transparent;}
    .section-tab.active{background:var(--primary);color:#fff;}
    .section-tab:hover:not(.active){background:var(--bg);color:var(--primary);}

    /* ── FORM ── */
    .form-section{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:24px;margin-bottom:16px;}
    .form-section-title{font-size:14px;font-weight:700;color:var(--text);margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
    .form-section-title i{color:var(--primary);}
    .form-label-custom{font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;display:block;}
    .form-control-custom{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;color:var(--text);background:#fff;transition:all .2s;outline:none;}
    .form-control-custom:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(30,58,95,.08);}
    .form-control-custom:disabled{background:var(--bg);color:var(--muted);}

    /* ── KETERSEDIAAN ── */
    .hari-row{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);}
    .hari-row:last-child{border-bottom:none;}
    .hari-label{width:80px;font-size:13px;font-weight:600;color:var(--text);}
    .slot-available{display:flex;gap:6px;flex-wrap:wrap;}
    .slot-chip{font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:20px;cursor:pointer;transition:all .2s;}
    .slot-chip.on{background:var(--primary);color:#fff;}
    .slot-chip.off{background:var(--bg);color:var(--muted);border:1px solid var(--border);}

    /* ── ULASAN ── */
    .ulasan-item{padding:14px 0;border-bottom:1px solid var(--border);}
    .ulasan-item:last-child{border-bottom:none;}
    .ulasan-stars{color:var(--accent);font-size:12px;}
    .ulasan-text{font-size:13px;color:var(--text);margin-top:4px;line-height:1.5;}
    .ulasan-from{font-size:11.5px;color:var(--muted);margin-top:4px;}

    /* DANGER ZONE */
    .danger-zone{background:var(--danger-soft);border:1.5px solid var(--danger);border-radius:16px;padding:20px;}
</style>
@endpush

@section('content')

{{-- PROFILE HEADER --}}
<div class="profile-header">
    <div class="d-flex align-items-center gap-4" style="position:relative;z-index:1;">
        <div class="profile-avatar">B</div>
        <div style="flex:1;">
            <div class="profile-name">Budi Santoso, S.Pd</div>
            <div class="profile-role">Tutor · Matematika & Fisika · Kediri, Jawa Timur</div>
            <div style="margin-top:8px;">
                <span style="background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;">
                    <i class="bi bi-star-fill me-1" style="color:var(--accent);"></i> Rating 4.8
                </span>
                <span style="background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;margin-left:6px;">
                    <i class="bi bi-shield-check-fill me-1"></i> Terverifikasi
                </span>
            </div>
        </div>
        <button class="btn btn-sm fw-bold"
            style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:10px;font-size:12px;white-space:nowrap;position:relative;z-index:1;">
            <i class="bi bi-camera-fill me-1"></i> Ganti Foto
        </button>
    </div>
    <div class="profile-stats">
        <div><div class="ps-val">14</div><div class="ps-label">Siswa Aktif</div></div>
        <div><div class="ps-val">128</div><div class="ps-label">Total Sesi</div></div>
        <div><div class="ps-val">48</div><div class="ps-label">Ulasan</div></div>
        <div><div class="ps-val">4.8</div><div class="ps-label">Rating</div></div>
        <div><div class="ps-val">6 th</div><div class="ps-label">Pengalaman</div></div>
    </div>
</div>

{{-- SECTION TABS --}}
<div class="section-tabs">
    <button class="section-tab active" onclick="switchSection(this,'info')">
        <i class="bi bi-person me-1"></i> Info Pribadi
    </button>
    <button class="section-tab" onclick="switchSection(this,'keahlian')">
        <i class="bi bi-book me-1"></i> Keahlian & Jadwal
    </button>
    <button class="section-tab" onclick="switchSection(this,'keamanan')">
        <i class="bi bi-shield-lock me-1"></i> Keamanan
    </button>
    <button class="section-tab" onclick="switchSection(this,'ulasan')">
        <i class="bi bi-star me-1"></i> Ulasan Siswa
    </button>
</div>

{{-- ══ INFO PRIBADI ══ --}}
<div id="section-info">
    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-person-fill"></i> Informasi Pribadi</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-custom">Nama Lengkap</label>
                <input type="text" class="form-control-custom" value="Budi Santoso, S.Pd"/>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Email</label>
                <input type="email" class="form-control-custom" value="budi.santoso@gmail.com" disabled/>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">No. HP</label>
                <input type="text" class="form-control-custom" value="08123456789"/>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Kota Domisili</label>
                <input type="text" class="form-control-custom" value="Kediri"/>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Pendidikan Terakhir</label>
                <select class="form-control-custom">
                    <option>D3</option>
                    <option selected>S1</option>
                    <option>S2</option>
                    <option>S3</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Jurusan / Program Studi</label>
                <input type="text" class="form-control-custom" value="Pendidikan Matematika"/>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Tahun Mulai Mengajar</label>
                <input type="number" class="form-control-custom" value="2018"/>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Mode Mengajar</label>
                <select class="form-control-custom">
                    <option>Online Saja</option>
                    <option selected>Online & Offline</option>
                    <option>Offline Saja</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label-custom">Bio / Deskripsi Singkat</label>
                <textarea class="form-control-custom" rows="3">Tutor Matematika dan Fisika berpengalaman 6 tahun. Spesialisasi TKA/UTBK, Olimpiade, dan bimbingan kelas reguler SMP-SMA. Metode pengajaran mengutamakan pemahaman konsep, bukan hafalan.</textarea>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                <i class="bi bi-check2 me-1"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>

{{-- ══ KEAHLIAN & JADWAL ══ --}}
<div id="section-keahlian" style="display:none;">
    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-mortarboard-fill"></i> Mata Pelajaran & Keahlian</div>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label-custom">Mata Pelajaran yang Diajarkan</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach(['Matematika','Fisika','Kalkulus','Aljabar','Trigonometri','Statistika','UTBK/TKA'] as $mapel)
                    <span style="background:{{ in_array($mapel,['Matematika','Fisika','UTBK/TKA']) ? 'var(--primary)' : '#eff6ff' }};color:{{ in_array($mapel,['Matematika','Fisika','UTBK/TKA']) ? '#fff' : 'var(--primary)' }};font-size:12.5px;font-weight:700;padding:5px 14px;border-radius:20px;cursor:pointer;border:1.5px solid {{ in_array($mapel,['Matematika','Fisika','UTBK/TKA']) ? 'var(--primary)' : '#eff6ff' }};">
                        {{ $mapel }}
                    </span>
                    @endforeach
                    <span style="background:var(--bg);color:var(--muted);font-size:12.5px;font-weight:700;padding:5px 14px;border-radius:20px;cursor:pointer;border:1.5px dashed var(--border);">
                        <i class="bi bi-plus me-1"></i> Tambah
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Jenjang yang Diajar</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach(['SMP','SMA','Perguruan Tinggi'] as $j)
                    <span style="background:{{ in_array($j,['SMP','SMA']) ? 'var(--success)' : 'var(--bg)' }};color:{{ in_array($j,['SMP','SMA']) ? '#fff' : 'var(--muted)' }};font-size:12px;font-weight:700;padding:5px 12px;border-radius:20px;cursor:pointer;border:1.5px solid {{ in_array($j,['SMP','SMA']) ? 'var(--success)' : 'var(--border)' }};">
                        {{ $j }}
                    </span>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Tarif per Sesi (60 mnt)</label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-weight:700;color:var(--muted);">Rp</span>
                    <input type="number" class="form-control-custom" value="75000" style="padding-left:40px;"/>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Maks. Siswa per Hari</label>
                <input type="number" class="form-control-custom" value="5"/>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-clock-fill"></i> Ketersediaan Waktu</div>
        @php
        $haris = [
            ['Senin',   ['07:00','08:00','09:00','13:00','14:00'],['07:00','09:00','13:00']],
            ['Selasa',  ['07:00','08:00','10:00','13:00','15:00'],['08:00','10:00','15:00']],
            ['Rabu',    ['07:00','08:00','09:00','13:00'],['07:00','13:00']],
            ['Kamis',   ['07:00','09:00','13:00','15:00','17:00'],['09:00','15:00']],
            ['Jumat',   ['07:00','08:00','13:00'],['']],
            ['Sabtu',   ['07:00','09:00','11:00','13:00'],['07:00','09:00','11:00']],
            ['Minggu',  [],['']],
        ];
        @endphp
        @foreach($haris as $h)
        <div class="hari-row">
            <div class="hari-label">{{ $h[0] }}</div>
            <div class="slot-available">
                @if(count($h[1]) > 0)
                    @foreach($h[1] as $slot)
                    <span class="slot-chip {{ in_array($slot, $h[2]) ? 'on' : 'off' }}" onclick="toggleSlot(this)">{{ $slot }}</span>
                    @endforeach
                @else
                    <span style="font-size:12px;color:var(--muted);">Tidak tersedia</span>
                @endif
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-end mt-3">
            <button class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                <i class="bi bi-check2 me-1"></i> Simpan Ketersediaan
            </button>
        </div>
    </div>
</div>

{{-- ══ KEAMANAN ══ --}}
<div id="section-keamanan" style="display:none;">
    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-key-fill"></i> Ubah Password</div>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label-custom">Password Saat Ini</label>
                <div style="position:relative;" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-control-custom" placeholder="Masukkan password saat ini" style="padding-right:40px;"/>
                    <i class="bi input-toggle" :class="show ? 'bi-eye-slash' : 'bi-eye'" @click="show=!show" style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Password Baru</label>
                <div style="position:relative;" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-control-custom" placeholder="Minimal 8 karakter" style="padding-right:40px;"/>
                    <i class="bi input-toggle" :class="show ? 'bi-eye-slash' : 'bi-eye'" @click="show=!show" style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label-custom">Konfirmasi Password</label>
                <div style="position:relative;" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-control-custom" placeholder="Ulangi password baru" style="padding-right:40px;"/>
                    <i class="bi input-toggle" :class="show ? 'bi-eye-slash' : 'bi-eye'" @click="show=!show" style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);font-size:15px;"></i>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn fw-bold px-4 py-2"
                style="background:var(--primary);color:#fff;border-radius:10px;border:none;font-size:13px;">
                <i class="bi bi-shield-check me-1"></i> Ubah Password
            </button>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-title"><i class="bi bi-bell-fill"></i> Pengaturan Notifikasi</div>
        @php
        $notifs = [
            ['Notifikasi Permintaan Jadwal Baru','Pemberitahuan saat siswa minta sesi baru',true],
            ['Pengingat Sesi','Pengingat 1 jam sebelum sesi dimulai',true],
            ['Notifikasi Pembayaran','Update status pembayaran sesi',true],
            ['Ulasan Baru dari Siswa','Pemberitahuan ulasan masuk',true],
            ['Email Newsletter','Informasi dan tips mengajar',false],
        ];
        @endphp
        <div class="d-flex flex-column gap-3">
            @foreach($notifs as $n)
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:var(--bg);">
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $n[0] }}</div>
                    <div style="font-size:11.5px;color:var(--muted);">{{ $n[1] }}</div>
                </div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" {{ $n[2] ? 'checked' : '' }} style="width:40px;height:22px;cursor:pointer;"/>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="danger-zone">
        <div style="font-size:14px;font-weight:700;color:var(--danger);margin-bottom:8px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>Zona Berbahaya
        </div>
        <div style="font-size:12.5px;color:#7f1d1d;margin-bottom:14px;line-height:1.5;">
            Menonaktifkan akun akan menghentikan semua jadwal aktif dan siswa tidak bisa memesan sesi baru dengan Anda.
        </div>
        <button class="btn fw-bold px-4 py-2"
            style="background:var(--danger);color:#fff;border-radius:10px;border:none;font-size:13px;">
            <i class="bi bi-x-circle-fill me-1"></i> Nonaktifkan Akun
        </button>
    </div>
</div>

{{-- ══ ULASAN SISWA ══ --}}
<div id="section-ulasan" style="display:none;">
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:24px;text-align:center;">
                <div style="font-size:48px;font-weight:800;color:var(--primary);">4.8</div>
                <div style="color:var(--accent);font-size:18px;margin-bottom:4px;">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                </div>
                <div style="font-size:12px;color:var(--muted);">dari 48 ulasan</div>
                <div style="margin-top:14px;">
                    @foreach([[5,75],[4,18],[3,5],[2,1],[1,1]] as $r)
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <span style="font-size:11px;font-weight:700;width:14px;text-align:right;">{{ $r[0] }}</span>
                        <i class="bi bi-star-fill" style="font-size:10px;color:var(--accent);"></i>
                        <div style="flex:1;height:6px;border-radius:10px;background:var(--border);overflow:hidden;">
                            <div style="height:100%;border-radius:10px;background:var(--accent);width:{{ $r[1] }}%;"></div>
                        </div>
                        <span style="font-size:11px;color:var(--muted);width:24px;">{{ $r[1] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;">
                <div style="font-size:14px;font-weight:700;margin-bottom:14px;color:var(--text);">Ulasan Terbaru</div>
                @php
                $ulasans = [
                    ['M','var(--primary)','Maya Putri',5,'Pak Budi sangat sabar dan penjelasannya mudah dipahami. Nilai Matematika saya naik dari 60 ke 85!','2 hari yang lalu'],
                    ['A','var(--success)','Aldi Pratama',5,'Materi UTBK Trigonometri jadi lebih jelas. Sangat recommended!','5 hari yang lalu'],
                    ['S','var(--warning)','Sinta Dewi',4,'Penjelasan bagus, tapi kadang terlalu cepat untuk materi baru. Overall sangat membantu.','1 minggu yang lalu'],
                    ['R','#6d28d9','Rizky Aditya',5,'Metode belajar Pak Budi berbeda dari guru sekolah, lebih ke pemahaman. Suka!','2 minggu yang lalu'],
                ];
                @endphp
                @foreach($ulasans as $u)
                <div class="ulasan-item">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:{{ $u[1] }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">{{ $u[0] }}</div>
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:700;color:var(--text);">{{ $u[2] }}</div>
                        </div>
                        <div class="ulasan-stars">
                            @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star{{ $i <= $u[3] ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="ulasan-text">{{ $u[4] }}</div>
                    <div class="ulasan-from"><i class="bi bi-clock me-1"></i>{{ $u[5] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchSection(el, id) {
        document.querySelectorAll('.section-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        ['info','keahlian','keamanan','ulasan'].forEach(s => {
            document.getElementById('section-'+s).style.display = s === id ? '' : 'none';
        });
    }
    function toggleSlot(el) {
        el.classList.toggle('on');
        el.classList.toggle('off');
    }
</script>
@endpush