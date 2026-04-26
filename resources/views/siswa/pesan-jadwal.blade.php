@extends('layouts.app')

@section('title', 'Pesan Jadwal Les - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Pesan Jadwal Les')
@section('page-sub', 'Dashboard / Pesan Jadwal Les')

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
    <a href="/siswa/profil" class="nav-item-custom {{ request()->is('siswa/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@section('content')

    @if(session('sukses'))
        <div style="background:#dcfce7;color:#16a34a;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;">
            ✅ {{ session('sukses') }}
        </div>
    @endif

    @if($paketDipilih)
        <div style="background:#eff6ff;color:#1e3a5f;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;">
            📦 Paket dipilih: <strong>{{ $paketDipilih['nama'] }}</strong> - Rp {{ number_format($paketDipilih['harga_min'], 0, ',', '.') }}
        </div>
    @endif

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:28px;">
        <div style="font-size:18px;font-weight:800;margin-bottom:20px;">📋 Form Pesan Jadwal Les</div>

        <form method="POST" action="/siswa/pesan-jadwal">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Pilih Tutor</label>
                    <select name="tutor_id" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;">
                        <option value="">-- Pilih Tutor --</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                        @endforeach
                    </select>
                    @error('tutor_id') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Mata Pelajaran</label>
                    <select name="mata_pelajaran" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <option value="Matematika">Matematika</option>
                        <option value="Fisika">Fisika</option>
                        <option value="Kimia">Kimia</option>
                        <option value="Biologi">Biologi</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    </select>
                    @error('mata_pelajaran') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Jadwal</label>
                    <input type="datetime-local" name="jadwal" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;"/>
                    @error('jadwal') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Mode Belajar</label>
                    <select name="mode" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;">
                        <option value="">-- Pilih Mode --</option>
                        <option value="online">Online (Zoom)</option>
                        <option value="tatap_muka">Tatap Muka</option>
                    </select>
                    @error('mode') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="col-12">
                    <button type="submit" style="width:100%;padding:12px;border:none;border-radius:10px;background:#1e3a5f;color:#fff;font-size:14px;font-weight:700;cursor:pointer;">
                        <i class="bi bi-send-fill me-2"></i> Kirim Pesanan ke Tutor
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection