@extends('layouts.app')

@section('title', 'Detail Pengguna - ' . $user->name)
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Detail Pengguna')
@section('page-sub', 'Informasi lengkap pengguna')

@section('sidebar-menu')
<div class="menu-label">Utama</div>
<a href="/admin/dashboard" class="nav-item-custom">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<div class="menu-label">Pengelolaan</div>
<a href="/admin/pengguna" class="nav-item-custom active">
    <i class="bi bi-people-fill"></i> Pengelolaan Pengguna
</a>
<a href="/admin/paket" class="nav-item-custom"><i class="bi bi-box-seam"></i> Pengelolaan Paket</a>
<a href="/admin/pembayaran" class="nav-item-custom"><i class="bi bi-cash-coin"></i> Pembayaran & Gaji</a>
<a href="/admin/rekening" class="nav-item-custom"><i class="bi bi-bank"></i> Rekening Bank</a>
<a href="/admin/laporan" class="nav-item-custom"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
@endsection

@section('content')

{{-- BACK BUTTON --}}
<a href="/admin/pengguna" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:var(--muted);text-decoration:none;margin-bottom:20px;">
    <i class="bi bi-arrow-left"></i> Kembali ke Pengelolaan Pengguna
</a>

{{-- PROFILE CARD --}}
<div style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:24px;margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
    <div style="width:64px;height:64px;border-radius:14px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;flex-shrink:0;">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
    <div style="flex:1;">
        <div style="font-size:18px;font-weight:800;color:var(--text);">{{ $user->name }}</div>
        <div style="font-size:13px;color:var(--muted);margin-top:2px;">{{ $user->email }}</div>
        <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;">
            <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;background:{{ $user->role === 'admin' ? 'var(--danger-soft)' : ($user->role === 'tutor' ? 'var(--warning-soft)' : '#eff6ff') }};color:{{ $user->role === 'admin' ? 'var(--danger)' : ($user->role === 'tutor' ? 'var(--warning)' : 'var(--primary)') }};">
                {{ ucfirst($user->role) }}
            </span>
            <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;background:var(--success-soft);color:var(--success);">
                <i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif
            </span>
        </div>
    </div>
    <div style="font-size:12px;color:var(--muted);">
        Bergabung: <strong>{{ $user->created_at->format('d M Y') }}</strong>
    </div>
</div>

{{-- INFO GRID --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

    {{-- Info Pribadi --}}
    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:20px;">
        <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:16px;"><i class="bi bi-person-fill" style="color:var(--primary);margin-right:6px;"></i> Informasi Pribadi</div>
        @foreach([
        ['No. HP', $user->no_hp ?? '-'],
        ['Tanggal Lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : '-'],
        ['Kota', $user->kota ?? '-'],
        ['Provinsi', $user->provinsi ?? '-'],
        ] as [$label, $val])
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;">
            <span style="color:var(--muted);">{{ $label }}</span>
            <span style="font-weight:600;color:var(--text);">{{ $val }}</span>
        </div>
        @endforeach
    </div>

    {{-- Info Akademik / Tutor --}}
    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:20px;">
        <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:16px;"><i class="bi bi-mortarboard-fill" style="color:var(--info);margin-right:6px;"></i> Info {{ $user->role === 'tutor' ? 'Tutor' : 'Akademik' }}</div>
        @if($user->role === 'tutor')
        @foreach([
        ['Pendidikan', $user->pendidikan ?? '-'],
        ['Jurusan', $user->jurusan ?? '-'],
        ['Tahun Mengajar', $user->tahun_mengajar ?? '-'],
        ['Mode Mengajar', $user->mode_mengajar ?? '-'],
        ] as [$label, $val])
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;">
            <span style="color:var(--muted);">{{ $label }}</span>
            <span style="font-weight:600;color:var(--text);">{{ $val }}</span>
        </div>
        @endforeach
        @else
        @foreach([
        ['Jenjang', strtoupper($user->jenjang ?? '-')],
        ['Kelas', $user->kelas ?? '-'],
        ['Tujuan Belajar', $user->tujuan_belajar ?? '-'],
        ['Bio', $user->bio ?? '-'],
        ] as [$label, $val])
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;">
            <span style="color:var(--muted);">{{ $label }}</span>
            <span style="font-weight:600;color:var(--text);">{{ $val }}</span>
        </div>
        @endforeach
        @endif
    </div>

</div>

{{-- Riwayat Les --}}
<div style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;overflow:hidden;margin-bottom:20px;">
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);font-size:14px;font-weight:700;color:var(--text);">
        <i class="bi bi-journal-text" style="color:var(--primary);margin-right:6px;"></i> Riwayat Les
    </div>
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr>
                    @foreach(['Mata Pelajaran','Tutor','Jadwal','Status','Harga'] as $h)
                    <th style="background:#f8fafc;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;padding:10px 14px;border-bottom:1px solid var(--border);white-space:nowrap;">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($user->lesPrivat()->with('tutor')->latest()->take(10)->get() as $les)
                <tr>
                    <td style="padding:12px 14px;font-size:13px;font-weight:600;color:var(--text);">{{ $les->mata_pelajaran }}</td>
                    <td style="padding:12px 14px;font-size:13px;color:var(--muted);">{{ $les->tutor->name ?? '-' }}</td>
                    <td style="padding:12px 14px;font-size:12px;color:var(--muted);">{{ $les->jadwal ? \Carbon\Carbon::parse($les->jadwal)->format('d M Y') : '-' }}</td>
                    <td style="padding:12px 14px;">
                        <span style="padding:3px 9px;border-radius:20px;font-size:11.5px;font-weight:600;background:{{ $les->status === 'selesai' ? 'var(--success-soft)' : ($les->status === 'dibatalkan' ? 'var(--danger-soft)' : 'var(--warning-soft)') }};color:{{ $les->status === 'selesai' ? 'var(--success)' : ($les->status === 'dibatalkan' ? 'var(--danger)' : 'var(--warning)') }};">
                            {{ ucfirst($les->status) }}
                        </span>
                    </td>
                    <td style="padding:12px 14px;font-size:13px;color:var(--text);">Rp {{ number_format($les->harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:32px;color:var(--muted);font-size:13px;">Belum ada riwayat les</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection