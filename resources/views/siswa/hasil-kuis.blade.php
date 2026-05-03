@extends('layouts.app')
@section('title', 'Hasil Kuis - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Hasil Latihan')
@section('page-sub', 'Belajar TKA / Hasil')

@section('sidebar-menu')
    <div class="menu-label">Menu Utama</div>
    <a href="/siswa/dashboard" class="nav-item-custom"><i class="bi bi-grid-fill"></i> Dashboard</a>
    <a href="/siswa/belajar-tka" class="nav-item-custom active"><i class="bi bi-book-fill"></i> Belajar TKA</a>
    <a href="/siswa/les-privat" class="nav-item-custom"><i class="bi bi-person-video3"></i> Les Privat</a>
    <a href="/siswa/hasil-progres" class="nav-item-custom"><i class="bi bi-bar-chart-line-fill"></i> Hasil & Progres</a>
    <div class="menu-label">Akun</div>
    <a href="/siswa/pembayaran" class="nav-item-custom"><i class="bi bi-credit-card-fill"></i> Pembayaran</a>
    <a href="/siswa/profil" class="nav-item-custom"><i class="bi bi-person-circle"></i> Profil Saya</a>
@endsection

@section('content')

    {{-- BANNER HASIL --}}
    <div style="background:linear-gradient(135deg,#1e3a5f,#2d5282);border-radius:20px;padding:30px 32px;color:#fff;text-align:center;margin-bottom:20px;">
        <div style="font-size:14px;font-weight:600;opacity:.8;margin-bottom:8px;">🎉 Latihan Selesai!</div>
        <div style="font-size:64px;font-weight:800;line-height:1;">{{ $hasil->nilai }}<span style="font-size:22px;">/100</span></div>
        <div style="font-size:18px;font-weight:700;margin-top:6px;opacity:.9;">
            @if($hasil->nilai >= 90) Nilai: A – Sangat Baik! 🏆
            @elseif($hasil->nilai >= 80) Nilai: B – Baik! 👍
            @elseif($hasil->nilai >= 70) Nilai: C – Cukup 😊
            @else Nilai: D – Perlu Belajar Lagi 💪
            @endif
        </div>
        <div style="font-size:13px;opacity:.75;margin-top:4px;">{{ $materi->judul }} · {{ $materi->mata_pelajaran }}</div>
        <div style="display:flex;justify-content:center;gap:32px;margin-top:20px;">
            <div style="text-align:center;">
                <div style="font-size:22px;font-weight:800;">{{ $hasil->soal_benar }}</div>
                <div style="font-size:11px;opacity:.7;">Soal Benar</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:22px;font-weight:800;">{{ $hasil->soal_salah }}</div>
                <div style="font-size:11px;opacity:.7;">Soal Salah</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:22px;font-weight:800;">{{ $hasil->durasi_menit }}m</div>
                <div style="font-size:11px;opacity:.7;">Waktu</div>
            </div>
        </div>
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="/siswa/belajar-tka/{{ $materi->id }}/soal" style="display:block;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;text-align:center;text-decoration:none;transition:all .2s;">
                <i class="bi bi-arrow-repeat" style="font-size:28px;color:#1e3a5f;"></i>
                <div style="font-size:13px;font-weight:700;margin-top:10px;color:#1e293b;">Ulangi Latihan</div>
                <div style="font-size:12px;color:#64748b;margin-bottom:14px;">Kerjakan ulang soal yang sama</div>
                <div style="background:#f1f5f9;color:#1e3a5f;border-radius:8px;padding:6px;font-size:12px;font-weight:700;">Ulangi</div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/siswa/hasil-progres" style="display:block;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;text-align:center;text-decoration:none;transition:all .2s;">
                <i class="bi bi-bar-chart-line-fill" style="font-size:28px;color:#16a34a;"></i>
                <div style="font-size:13px;font-weight:700;margin-top:10px;color:#1e293b;">Lihat Progres</div>
                <div style="font-size:12px;color:#64748b;margin-bottom:14px;">Pantau perkembangan belajarmu</div>
                <div style="background:#dcfce7;color:#16a34a;border-radius:8px;padding:6px;font-size:12px;font-weight:700;">Lihat</div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/siswa/belajar-tka" style="display:block;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;text-align:center;text-decoration:none;transition:all .2s;">
                <i class="bi bi-book-fill" style="font-size:28px;color:#f59e0b;"></i>
                <div style="font-size:13px;font-weight:700;margin-top:10px;color:#1e293b;">Materi Lain</div>
                <div style="font-size:12px;color:#64748b;margin-bottom:14px;">Lanjut ke topik berikutnya</div>
                <div style="background:#fef9c3;color:#f59e0b;border-radius:8px;padding:6px;font-size:12px;font-weight:700;">Pilih Materi</div>
            </a>
        </div>
    </div>

    {{-- PEMBAHASAN --}}
    @if($hasil->jawaban)
    <div style="font-size:15px;font-weight:800;margin-bottom:14px;">📋 Review Jawaban</div>
    @foreach($hasil->jawaban as $index => $detail)
    <div style="background:#fff;border:1px solid {{ $detail['benar'] ? '#a7f3d0' : '#fca5a5' }};border-radius:14px;padding:20px;margin-bottom:12px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <div style="font-size:11px;font-weight:700;color:#64748b;">SOAL {{ $index + 1 }}</div>
            @if($detail['benar'])
            <span style="background:#dcfce7;color:#16a34a;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;">✅ Benar</span>
            @else
            <span style="background:#fee2e2;color:#dc2626;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;">❌ Salah</span>
            @endif
        </div>
        <div style="font-size:14px;font-weight:600;margin-bottom:12px;">{{ $detail['pertanyaan'] }}</div>
        <div style="font-size:12.5px;margin-bottom:6px;">
            <span style="color:#64748b;">Jawaban kamu:</span>
            <strong style="color:{{ $detail['benar'] ? '#16a34a' : '#dc2626' }};">{{ strtoupper($detail['jawaban_siswa']) }}</strong>
        </div>
        @if(!$detail['benar'])
        <div style="font-size:12.5px;margin-bottom:6px;">
            <span style="color:#64748b;">Jawaban benar:</span>
            <strong style="color:#16a34a;">{{ strtoupper($detail['jawaban_benar']) }}</strong>
        </div>
        @endif
        @if($detail['pembahasan'])
        <div style="background:#f0fdf4;border-left:3px solid #16a34a;border-radius:8px;padding:10px 14px;margin-top:10px;font-size:12.5px;color:#1e293b;">
            <strong>Pembahasan:</strong> {{ $detail['pembahasan'] }}
        </div>
        @endif
    </div>
    @endforeach
    @endif

@endsection