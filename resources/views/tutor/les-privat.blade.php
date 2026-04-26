@extends('layouts.app')

@section('title', 'Les Privat - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Les Privat')
@section('page-sub', 'Dashboard / Les Privat')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/tutor/dashboard" class="nav-item-custom {{ request()->is('tutor/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="/tutor/jadwal" class="nav-item-custom {{ request()->is('tutor/jadwal') ? 'active' : '' }}">
        <i class="bi bi-calendar3"></i> Jadwal Mengajar
    </a>
    <a href="/tutor/les-privat" class="nav-item-custom {{ request()->is('tutor/les-privat') ? 'active' : '' }}">
        <i class="bi bi-person-video3"></i> Les Privat
    </a>
    <div class="menu-label">Akademik</div>
    <a href="/tutor/materi" class="nav-item-custom {{ request()->is('tutor/materi') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Materi Ajar
    </a>
    <a href="/tutor/soal" class="nav-item-custom {{ request()->is('tutor/soal') ? 'active' : '' }}">
        <i class="bi bi-patch-question-fill"></i> Bank Soal
    </a>
    <div class="menu-label">Akun</div>
    <a href="/tutor/profil" class="nav-item-custom {{ request()->is('tutor/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil Saya
    </a>
@endsection

@section('content')

    @if(session('sukses'))
        <div style="background:#dcfce7;color:#16a34a;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;">
            ✅ {{ session('sukses') }}
        </div>
    @endif

    <div style="font-size:18px;font-weight:800;margin-bottom:20px;">📋 Pesanan Les Privat</div>

    @if($pesanan->isEmpty())
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:40px;text-align:center;color:#64748b;">
            <i class="bi bi-inbox" style="font-size:48px;"></i>
            <div style="margin-top:12px;font-size:15px;font-weight:600;">Belum ada pesanan masuk</div>
            <div style="font-size:13px;margin-top:4px;">Pesanan dari siswa akan muncul di sini</div>
        </div>
    @else
        @foreach($pesanan as $item)
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:20px;margin-bottom:12px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                    <div style="font-size:13px;font-weight:700;color:#64748b;">#{{ strtoupper(substr($item->id, 0, 8)) }}</div>
                    @if($item->status === 'menunggu')
                        <span style="background:#fef9c3;color:#ca8a04;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;">⏳ Menunggu</span>
                    @elseif($item->status === 'dikonfirmasi')
                        <span style="background:#dcfce7;color:#16a34a;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;">✅ Dikonfirmasi</span>
                    @else
                        <span style="background:#fee2e2;color:#dc2626;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;">❌ Ditolak</span>
                    @endif
                </div>

                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <div>
                        <div style="font-size:11px;color:#64748b;">Siswa</div>
                        <div style="font-size:13px;font-weight:700;">{{ $item->siswa->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:#64748b;">Mata Pelajaran</div>
                        <div style="font-size:13px;font-weight:700;">{{ $item->mata_pelajaran }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:#64748b;">Jadwal</div>
                        <div style="font-size:13px;font-weight:700;">{{ \Carbon\Carbon::parse($item->jadwal)->format('d M Y H:i') }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:#64748b;">Mode</div>
                        <div style="font-size:13px;font-weight:700;">{{ $item->mode === 'online' ? 'Online' : 'Tatap Muka' }}</div>
                    </div>
                </div>

                @if($item->status === 'menunggu')
                    <div style="display:flex;gap:8px;margin-top:16px;">
                        <form method="POST" action="/tutor/les-privat/{{ $item->id }}/terima">
                            @csrf
                            <button type="submit" style="padding:8px 20px;border:none;border-radius:8px;background:#16a34a;color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                                ✅ Terima
                            </button>
                        </form>
                        <form method="POST" action="/tutor/les-privat/{{ $item->id }}/tolak">
                            @csrf
                            <button type="submit" style="padding:8px 20px;border:none;border-radius:8px;background:#dc2626;color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                                ❌ Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

@endsection