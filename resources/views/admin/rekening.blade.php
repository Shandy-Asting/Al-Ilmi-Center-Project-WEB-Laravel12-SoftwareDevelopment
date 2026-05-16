@extends('layouts.app')

@section('title', 'Rekening Bank - Al Ilmi Center Admin')
@section('sidebar-sub', 'Panel Admin')
@section('page-title', 'Kelola Rekening Bank')
@section('page-sub', 'Admin / Rekening Bank')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="/admin/dashboard" class="nav-item-custom"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <div class="menu-label">Pengelolaan</div>
    <a href="/admin/pengguna" class="nav-item-custom"><i class="bi bi-people-fill"></i> Pengelolaan Pengguna</a>
    <a href="/admin/paket" class="nav-item-custom"><i class="bi bi-box-seam"></i> Pengelolaan Paket</a>
    <a href="/admin/transaksi" class="nav-item-custom"><i class="bi bi-credit-card-fill"></i> Transaksi</a>
    <a href="/admin/pembayaran" class="nav-item-custom"><i class="bi bi-cash-coin"></i> Pembayaran & Gaji</a>
    <a href="/admin/rekening" class="nav-item-custom active"><i class="bi bi-bank"></i> Rekening Bank</a>
    <a href="/admin/laporan" class="nav-item-custom"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
@endsection

@push('styles')
<style>
    .rek-card{background:var(--card-bg);border:1.5px solid var(--border);border-radius:16px;padding:20px;transition:all .2s;}
    .rek-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);}
    .rek-card.aktif{border-color:var(--success);}
    .rek-card.nonaktif{opacity:.7;}
    .rek-logo{width:56px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#fff;flex-shrink:0;}
    .rek-bank{font-size:15px;font-weight:700;color:var(--text);}
    .rek-norek{font-size:14px;font-weight:600;color:var(--primary);font-family:monospace;letter-spacing:1px;}
    .rek-atas-nama{font-size:12px;color:var(--muted);}
    .card-box{background:var(--card-bg);border:1px solid var(--border);border-radius:14px;overflow:hidden;}
    .card-box-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead th{background:#f8fafc;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;padding:10px 14px;border-bottom:1px solid var(--border);white-space:nowrap;}
    .tbl tbody td{padding:12px 14px;font-size:13px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tbl tbody tr:last-child td{border-bottom:none;}
    .tbl tbody tr:hover td{background:#fafcff;}
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;padding:16px;}
    .modal-overlay.show{display:flex;}
    .modal-box{background:#fff;border-radius:20px;width:100%;max-width:480px;max-height:92vh;overflow-y:auto;animation:fadeUp .25s ease;}
    @keyframes fadeUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:#fff;z-index:1;}
    .modal-head h5{font-size:15px;font-weight:800;}
    .modal-close-btn{width:30px;height:30px;border-radius:8px;border:none;background:var(--bg);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--muted);}
    .form-label-c{font-size:13px;font-weight:600;margin-bottom:6px;display:block;}
    .form-input-c{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;outline:none;background:#fff;transition:border .2s;}
    .form-input-c:focus{border-color:var(--primary);}
    @media(max-width:767px){.row .col-md-4{margin-bottom:14px;}}
</style>
@endpush

@section('content')

{{-- ALERT --}}
@if(session('sukses'))
<div style="background:var(--success-soft);border:1px solid var(--success);border-radius:12px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
    <i class="bi bi-check-circle-fill" style="color:var(--success);font-size:18px;"></i>
    <span style="font-size:13px;font-weight:600;color:var(--success);">{{ session('sukses') }}</span>
</div>
@endif

{{-- HEADER --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">🏦 Kelola Rekening Bank</h4>
        <p style="font-size:13px;color:var(--muted);margin:0;">Rekening ini digunakan siswa untuk melakukan pembayaran les privat</p>
    </div>
    <button onclick="document.getElementById('modal-tambah-rek').classList.add('show')"
        style="background:var(--primary);color:#fff;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:7px;">
        <i class="bi bi-plus-lg"></i> Tambah Rekening
    </button>
</div>

{{-- INFO BOX --}}
<div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:flex-start;gap:12px;">
    <i class="bi bi-shield-check-fill" style="color:var(--primary);font-size:18px;flex-shrink:0;"></i>
    <div>
        <div style="font-size:13.5px;font-weight:700;color:var(--text);margin-bottom:3px;">Rekening Aktif Ditampilkan ke Siswa</div>
        <div style="font-size:12.5px;color:var(--muted);">
            Hanya rekening dengan status <strong>Aktif</strong> yang akan muncul di halaman pembayaran siswa.
            Pastikan nomor rekening dan nama pemilik sudah benar sebelum mengaktifkan.
        </div>
    </div>
</div>

{{-- REKENING CARDS --}}
<div class="row g-3 mb-4">
    @forelse(\App\Models\RekeningBank::all() as $rek)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="rek-card {{ $rek->aktif ? 'aktif' : 'nonaktif' }}">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <div class="rek-logo" style="background:{{ $rek->nama_bank==='Bank BCA'?'#003087':($rek->nama_bank==='Bank BRI'?'#004ea8':'#005e97') }};">
                    {{ strtoupper(str_replace(['Bank ','bank '],'',$rek->nama_bank)) }}
                </div>
                <div style="display:flex;gap:6px;align-items:center;">
                    @if($rek->aktif)
                    <span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">
                        <i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif
                    </span>
                    @else
                    <span style="background:var(--bg);color:var(--muted);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">
                        ○ Nonaktif
                    </span>
                    @endif
                </div>
            </div>
            <div class="rek-bank">{{ $rek->nama_bank }}</div>
            <div class="rek-norek">{{ $rek->nomor_rekening }}</div>
            <div class="rek-atas-nama">a.n. {{ $rek->atas_nama }}</div>
            <div style="display:flex;gap:8px;margin-top:14px;">
                <button onclick="openEditRek('{{ $rek->id }}','{{ $rek->nama_bank }}','{{ $rek->nomor_rekening }}','{{ $rek->atas_nama }}')"
                    style="flex:1;padding:8px;border-radius:9px;font-size:12.5px;font-weight:700;cursor:pointer;border:1.5px solid var(--primary);background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <form method="POST" action="/admin/rekening/{{ $rek->id }}/toggle" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;padding:8px;border-radius:9px;font-size:12.5px;font-weight:700;cursor:pointer;border:1.5px solid {{ $rek->aktif ? 'var(--warning)' : 'var(--success)' }};background:{{ $rek->aktif ? 'var(--warning-soft)' : 'var(--success-soft)' }};color:{{ $rek->aktif ? 'var(--warning)' : 'var(--success)' }};">
                        {{ $rek->aktif ? '⏸ Nonaktifkan' : '▶ Aktifkan' }}
                    </button>
                </form>
                <form method="POST" action="/admin/rekening/{{ $rek->id }}" onsubmit="return confirm('Hapus rekening {{ $rek->nama_bank }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding:8px 12px;border-radius:9px;font-size:13px;cursor:pointer;border:1.5px solid var(--danger);background:var(--danger-soft);color:var(--danger);">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    {{-- Dummy jika belum ada data --}}
    @php
    $dummyRek = [
        ['Bank BCA','1234567890','Al Ilmi Center','#003087','BCA',true],
        ['Bank BRI','0987654321','Al Ilmi Center','#004ea8','BRI',true],
        ['Bank Mandiri','1122334455','Al Ilmi Center','#005e97','MDR',false],
    ];
    @endphp
    @foreach($dummyRek as $dr)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="rek-card {{ $dr[5] ? 'aktif' : 'nonaktif' }}">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <div class="rek-logo" style="background:{{ $dr[3] }};">{{ $dr[4] }}</div>
                @if($dr[5])
                <span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif</span>
                @else
                <span style="background:var(--bg);color:var(--muted);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">○ Nonaktif</span>
                @endif
            </div>
            <div class="rek-bank">{{ $dr[0] }}</div>
            <div class="rek-norek">{{ $dr[1] }}</div>
            <div class="rek-atas-nama">a.n. {{ $dr[2] }}</div>
            <div style="display:flex;gap:8px;margin-top:14px;">
                <button onclick="document.getElementById('modal-edit-rek').classList.add('show')"
                    style="flex:1;padding:8px;border-radius:9px;font-size:12.5px;font-weight:700;cursor:pointer;border:1.5px solid var(--primary);background:#eff6ff;color:var(--primary);">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <button style="flex:1;padding:8px;border-radius:9px;font-size:12.5px;font-weight:700;cursor:pointer;border:1.5px solid {{ $dr[5]?'var(--warning)':'var(--success)' }};background:{{ $dr[5]?'var(--warning-soft)':'var(--success-soft)' }};color:{{ $dr[5]?'var(--warning)':'var(--success)' }};">
                    {{ $dr[5] ? '⏸ Nonaktifkan' : '▶ Aktifkan' }}
                </button>
                <button style="padding:8px 12px;border-radius:9px;font-size:13px;cursor:pointer;border:1.5px solid var(--danger);background:var(--danger-soft);color:var(--danger);">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
    @endforelse
</div>

{{-- TABEL --}}
<div class="card-box">
    <div class="card-box-header">
        <div style="font-size:14px;font-weight:700;color:var(--text);"><i class="bi bi-table me-2" style="color:var(--primary);"></i>Semua Rekening Terdaftar</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead><tr><th>Bank</th><th>Nomor Rekening</th><th>Atas Nama</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse(\App\Models\RekeningBank::all() as $rek)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:32px;height:22px;border-radius:5px;background:{{ $rek->nama_bank==='Bank BCA'?'#003087':($rek->nama_bank==='Bank BRI'?'#004ea8':'#005e97') }};color:#fff;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;flex-shrink:0;">
                            {{ strtoupper(str_replace(['Bank ','bank '],'',$rek->nama_bank)) }}
                        </div>
                        <span style="font-weight:600;">{{ $rek->nama_bank }}</span>
                    </div>
                </td>
                <td style="font-family:monospace;font-weight:600;letter-spacing:1px;color:var(--primary);">{{ $rek->nomor_rekening }}</td>
                <td>{{ $rek->atas_nama }}</td>
                <td>
                    @if($rek->aktif)
                    <span style="background:var(--success-soft);color:var(--success);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:3px;"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif</span>
                    @else
                    <span style="background:var(--bg);color:var(--muted);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">Nonaktif</span>
                    @endif
                </td>
                <td style="font-size:12px;color:var(--muted);">{{ $rek->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display:flex;gap:5px;">
                        <button onclick="openEditRek('{{ $rek->id }}','{{ $rek->nama_bank }}','{{ $rek->nomor_rekening }}','{{ $rek->atas_nama }}')"
                            style="width:30px;height:30px;border-radius:7px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--warning);">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="POST" action="/admin/rekening/{{ $rek->id }}/toggle">
                            @csrf
                            <button type="submit" style="width:30px;height:30px;border-radius:7px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;color:{{ $rek->aktif?'var(--warning)':'var(--success)' }};">
                                <i class="bi bi-toggle-{{ $rek->aktif?'on':'off' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="/admin/rekening/{{ $rek->id }}" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="width:30px;height:30px;border-radius:7px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--danger);">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted);">Belum ada rekening. Tambahkan dengan tombol di atas atau jalankan Tinker.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal-overlay" id="modal-tambah-rek">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-bank me-2" style="color:var(--primary);"></i>Tambah Rekening Bank</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-tambah-rek').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="/admin/rekening" method="POST">
            @csrf
            <div style="padding:20px 22px;" class="row g-3">
                <div class="col-12">
                    <label class="form-label-c">Nama Bank <span style="color:var(--danger);">*</span></label>
                    <select name="nama_bank" class="form-input-c" required>
                        <option value="">-- Pilih Bank --</option>
                        @foreach(['Bank BCA','Bank BRI','Bank Mandiri','Bank BNI','Bank CIMB Niaga','Bank Danamon','Bank Permata','Bank Syariah Indonesia (BSI)','Bank Jatim'] as $b)
                        <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label-c">Nomor Rekening <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="nomor_rekening" class="form-input-c" placeholder="Contoh: 1234567890" required/>
                </div>
                <div class="col-12">
                    <label class="form-label-c">Atas Nama (Sesuai Buku Tabungan) <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="atas_nama" class="form-input-c" placeholder="Contoh: Al Ilmi Center" required/>
                </div>
                <div class="col-12">
                    <div style="background:var(--accent-soft);border-radius:10px;padding:12px 14px;font-size:12.5px;color:#92400e;">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Rekening baru otomatis berstatus <strong>Aktif</strong> dan langsung tampil di halaman pembayaran siswa.
                    </div>
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end">
                    <button type="button" onclick="document.getElementById('modal-tambah-rek').classList.remove('show')"
                        style="padding:10px 18px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">Batal</button>
                    <button type="submit"
                        style="padding:10px 18px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                        <i class="bi bi-plus-lg me-1"></i> Simpan Rekening
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-overlay" id="modal-edit-rek">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-pencil me-2" style="color:var(--primary);"></i>Edit Rekening Bank</h5>
            <button class="modal-close-btn" onclick="document.getElementById('modal-edit-rek').classList.remove('show')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-edit-rek" action="" method="POST">
            @csrf @method('PUT')
            <div style="padding:20px 22px;" class="row g-3">
                <div class="col-12">
                    <label class="form-label-c">Nama Bank</label>
                    <select name="nama_bank" id="edit-nama-bank" class="form-input-c">
                        @foreach(['Bank BCA','Bank BRI','Bank Mandiri','Bank BNI','Bank CIMB Niaga','Bank Danamon','Bank Permata','Bank Syariah Indonesia (BSI)','Bank Jatim'] as $b)
                        <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label-c">Nomor Rekening</label>
                    <input type="text" name="nomor_rekening" id="edit-norek" class="form-input-c"/>
                </div>
                <div class="col-12">
                    <label class="form-label-c">Atas Nama</label>
                    <input type="text" name="atas_nama" id="edit-atas-nama" class="form-input-c"/>
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end">
                    <button type="button" onclick="document.getElementById('modal-edit-rek').classList.remove('show')"
                        style="padding:10px 18px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);">Batal</button>
                    <button type="submit"
                        style="padding:10px 18px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditRek(id, namaBank, norek, atasNama) {
    document.getElementById('form-edit-rek').action = '/admin/rekening/' + id;
    document.getElementById('edit-nama-bank').value = namaBank;
    document.getElementById('edit-norek').value = norek;
    document.getElementById('edit-atas-nama').value = atasNama;
    document.getElementById('modal-edit-rek').classList.add('show');
}
</script>
@endpush