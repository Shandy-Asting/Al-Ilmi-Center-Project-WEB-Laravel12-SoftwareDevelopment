@extends('layouts.app')

@section('title', 'Daftar Siswa - Al Ilmi Center')
@section('sidebar-sub', 'Portal Tutor')
@section('page-title', 'Daftar Siswa')
@section('page-sub', 'Dashboard / Daftar Siswa')

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
        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1;
            color: var(--text);
        }

        .stat-label {
            font-size: .78rem;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── SISWA CARD ── */
        .siswa-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            transition: all .2s;
            cursor: pointer;
        }

        .siswa-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 6px 20px rgba(30, 58, 95, .1);
            transform: translateY(-2px);
        }

        .siswa-av {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            margin-bottom: 12px;
        }

        .siswa-name {
            font-size: 14px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 2px;
        }

        .siswa-info {
            font-size: 12px;
            color: var(--muted);
        }

        .siswa-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-top: 12px;
        }

        .ss-item {
            background: var(--bg);
            border-radius: 8px;
            padding: 8px;
            text-align: center;
        }

        .ss-val {
            font-size: 15px;
            font-weight: 800;
            color: var(--primary);
        }

        .ss-label {
            font-size: 10px;
            color: var(--muted);
            margin-top: 2px;
        }

        .progress-bar-custom {
            height: 6px;
            border-radius: 10px;
            background: var(--border);
            margin-top: 8px;
            overflow: hidden;
        }

        .pb-fill {
            height: 100%;
            border-radius: 10px;
        }

        /* TABLE */
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead th {
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .tbl tbody td {
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .tbl tbody tr:hover td {
            background: #f8faff;
        }

        /* VIEW TOGGLE */
        .view-toggle {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .vt-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            cursor: pointer;
            color: var(--muted);
            font-size: .9rem;
            border: none;
            transition: all .2s;
        }

        .vt-btn.active {
            background: var(--primary);
            color: #fff;
        }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            width: 90%;
            max-width: 540px;
            max-height: 90vh;
            overflow-y: auto;
            animation: fadeUp .25s ease;
        }

        @keyframes fadeUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-head {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-head h5 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
        }

        .modal-close-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: none;
            background: var(--bg);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: var(--muted);
        }

        /* CARD BOX */
        .card-box {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        .card-box-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-box-title {
            font-size: .95rem;
            font-weight: 700;
            color: var(--text);
        }

        .card-box-title i {
            color: var(--primary);
            margin-right: 6px;
        }

        @media (max-width: 991px) {

            .tutor-grid,
            #view-grid .row {
                --bs-gutter-x: 12px;
            }
        }

        @media (max-width: 767px) {
            .siswa-card {
                padding: 14px;
            }

            .siswa-av {
                width: 44px !important;
                height: 44px !important;
                font-size: 16px !important;
            }

            .achieve-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            .siswa-stats {
                grid-template-columns: 1fr 1fr;
            }

            .filter-bar {
                flex-direction: column;
            }

            .filter-bar select,
            .filter-bar input {
                width: 100%;
            }

            .view-toggle {
                align-self: flex-end;
            }
        }

        @media (max-width: 480px) {
            .siswa-card {
                padding: 12px;
            }

            .modal-box {
                width: 96% !important;
            }
        }
    </style>
@endpush

@section('content')

    {{-- HEADER --}}
    <div class="d-flex align-items-start justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">👨‍🎓 Daftar Siswa</h4>
            <div style="font-size:13px;color:var(--muted);">
                Dashboard / <span style="color:var(--primary);font-weight:600;">Daftar Siswa</span>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['bi-people-fill', '#eff6ff', 'var(--primary)', '14', 'Total Siswa Aktif'],
                ['bi-person-check-fill', 'var(--success-soft)', 'var(--success)', '9', 'Progres Baik (>70%)'],
                ['bi-person-exclamation-fill', 'var(--danger-soft)', 'var(--danger)', '3', 'Perlu Perhatian (<60%)'],
                ['bi-star-fill', 'var(--accent-soft)', 'var(--warning)', '4.8', 'Rating Rata-rata'],
            ];
        @endphp
        @foreach ($stats as $s)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s[1] }};color:{{ $s[2] }};"><i class="bi {{ $s[0] }}"></i></div>
            <div>
                <div class="stat-val">{{ $s[3] }}</div>
                <div class="stat-label">{{ $s[4] }}</div>
            </div>
        </div>
    </div> @endforeach
    </div>

    {{-- FILTER BAR --}}
    <div
        style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:14px 18px;display:flex;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <div style="position:relative;flex:1;min-width:220px;">
            <i class="bi bi-search"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);"></i>
            <input type="text"
                style="width:100%;padding:9px 12px 9px 36px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;outline:none;"
                placeholder="Cari nama siswa…" id="searchSiswa" oninput="filterSiswa()" />
        </div>
        <select
            style="padding:9px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;outline:none;background:var(--card-bg);">
            <option>Semua Mapel</option>
            <option>Matematika</option>
            <option>Fisika</option>
            <option>Kimia</option>
        </select>
        <select
            style="padding:9px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;outline:none;background:var(--card-bg);">
            <option>Semua Jenjang</option>
            <option>SMP</option>
            <option>SMA</option>
        </select>
        <div class="view-toggle ms-auto">
            <button class="vt-btn active" id="btnGrid2" onclick="toggleView('grid')"><i
                    class="bi bi-grid-3x3-gap-fill"></i></button>
            <button class="vt-btn" id="btnTable2" onclick="toggleView('table')"><i class="bi bi-list-ul"></i></button>
        </div>
    </div>

    {{-- GRID VIEW --}}
    <div id="view-grid">
        <div class="row g-3 mb-4">
            @forelse($siswaList as $siswa)
                <div class="col-6 col-sm-6 col-lg-4 col-xl-3 siswa-card-wrap">
                    <div class="siswa-card" onclick="openModalSiswa('{{ $siswa->name }}')">
                        <div class="siswa-av" style="background:var(--primary);">
                            {{ strtoupper(substr($siswa->name, 0, 2)) }}
                        </div>
                        <div class="siswa-name">{{ $siswa->name }}</div>
                        <div class="siswa-info">{{ $siswa->email }}</div>
                        <div class="siswa-info" style="margin-top:3px;">
                            @php
                                $mapelSiswa = \App\Models\LesPrivat::where('user_id', $siswa->id)
                                    ->where('tutor_id', auth()->id())
                                    ->distinct('mata_pelajaran')
                                    ->pluck('mata_pelajaran')
                                    ->join(', ');
                            @endphp
                            <span
                                style="background:#eff6ff;color:var(--primary);font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">
                                {{ $mapelSiswa ?: '-' }}
                            </span>
                        </div>
                        <div class="siswa-stats">
                            <div class="ss-item">
                                <div class="ss-val">
                                    {{ \App\Models\LesPrivat::where('user_id', $siswa->id)->where('tutor_id', auth()->id())->count() }}
                                </div>
                                <div class="ss-label">Total Sesi</div>
                            </div>
                            <div class="ss-item">
                                <div class="ss-val">
                                    {{ \App\Models\LesPrivat::where('user_id', $siswa->id)->where('tutor_id', auth()->id())->where('status', 'selesai')->count() }}
                                </div>
                                <div class="ss-label">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div
                        style="text-align:center;padding:48px;color:var(--muted);background:var(--card-bg);border-radius:16px;border:1px solid var(--border);">
                        <i class="bi bi-people" style="font-size:2.5rem;display:block;margin-bottom:10px;"></i>
                        Belum ada siswa yang pernah les dengan kamu.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- TABLE VIEW --}}
    <div id="view-table" style="display:none;">
        <div class="card-box mb-4">
            <div class="card-box-header">
                <div class="card-box-title"><i class="bi bi-table"></i> Daftar Siswa</div>
                <span style="font-size:12px;color:var(--muted);">14 siswa aktif</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Jenjang</th>
                            <th>Mata Pelajaran</th>
                            <th>Rata-rata Nilai</th>
                            <th>Total Sesi</th>
                            <th>Progres</th>
                            <th>Status</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $siswasTable = [
                                [
                                    'A',
                                    'var(--primary)',
                                    'Aldi Pratama',
                                    'SMA 12',
                                    'Matematika',
                                    '82',
                                    '14',
                                    'Bab 8/10',
                                    'baik',
                                ],
                                [
                                    'S',
                                    'var(--success)',
                                    'Sinta Dewi',
                                    'SMA 11',
                                    'Fisika',
                                    '65',
                                    '9',
                                    'Bab 6/10',
                                    'cukup',
                                ],
                                [
                                    'R',
                                    'var(--warning)',
                                    'Rizky Aditya',
                                    'SMA 12',
                                    'Kimia',
                                    '50',
                                    '11',
                                    'Bab 5/10',
                                    'perhatian',
                                ],
                                ['M', '#6d28d9', 'Maya Putri', 'SMA 12', 'Matematika', '90', '18', 'Bab 9/10', 'baik'],
                                [
                                    'F',
                                    'var(--danger)',
                                    'Farhan Maulana',
                                    'SMP 9',
                                    'B. Inggris',
                                    '40',
                                    '7',
                                    'Bab 4/10',
                                    'perhatian',
                                ],
                                ['D', 'var(--info)', 'Dina Sari', 'SMA 10', 'Biologi', '75', '12', 'Bab 7/10', 'baik'],
                            ];
                        @endphp
                        @foreach ($siswasTable as $st)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div
                                            style="width:34px;height:34px;border-radius:50%;background:{{ $st[1] }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ $st[0] }}</div>
                                        <div>
                                            <div style="font-weight:600;color:var(--text);">{{ $st[2] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:var(--muted);font-size:12.5px;">{{ $st[3] }}</td>
                                <td><span
                                        style="background:#eff6ff;color:var(--primary);font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">{{ $st[4] }}</span>
                                </td>
                                <td>
                                    <span
                                        style="font-size:15px;font-weight:800;color:{{ $st[5] >= 70 ? 'var(--success)' : ($st[5] >= 60 ? 'var(--warning)' : 'var(--danger)') }};">{{ $st[5] }}</span>
                                </td>
                                <td style="font-size:12.5px;">{{ $st[6] }} sesi</td>
                                <td>
                                    <div style="font-size:11.5px;color:var(--muted);margin-bottom:4px;">{{ $st[7] }}
                                    </div>
                                    <div
                                        style="height:5px;border-radius:10px;background:var(--border);width:80px;overflow:hidden;">
                                        <div
                                            style="height:100%;border-radius:10px;width:{{ $st[5] }}%;background:{{ $st[5] >= 70 ? 'var(--success)' : ($st[5] >= 60 ? 'var(--warning)' : 'var(--danger)') }};">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php $stLabel = ['baik'=>['var(--success-soft)','var(--success)','Baik'],'cukup'=>['var(--accent-soft)','var(--warning)','Cukup'],'perhatian'=>['var(--danger-soft)','var(--danger)','Perhatian']]; @endphp
                                    <span
                                        style="background:{{ $stLabel[$st[8]][0] }};color:{{ $stLabel[$st[8]][1] }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">{{ $stLabel[$st[8]][2] }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <button onclick="openModalSiswa('{{ $st[2] }}')"
                                        style="border:none;background:#eff6ff;color:var(--primary);border-radius:8px;padding:5px 12px;font-size:12px;font-weight:700;cursor:pointer;">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══ MODAL DETAIL SISWA ══ --}}
    <div class="modal-overlay" id="modal-siswa">
        <div class="modal-box">
            <div class="modal-head">
                <h5><i class="bi bi-person-fill me-2" style="color:var(--primary);"></i>Detail Siswa</h5>
                <button class="modal-close-btn" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div style="padding:20px 22px;">
                {{-- Profile --}}
                <div
                    style="display:flex;align-items:center;gap:14px;padding:14px;background:var(--bg);border-radius:12px;margin-bottom:16px;">
                    <div
                        style="width:56px;height:56px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:22px;color:#fff;flex-shrink:0;">
                        A</div>
                    <div style="flex:1;">
                        <div style="font-size:15px;font-weight:800;color:var(--text);" id="modal-siswa-name">Aldi Pratama
                        </div>
                        <div style="font-size:12px;color:var(--muted);">SMA Kelas 12 · Matematika</div>
                        <div style="margin-top:6px;display:flex;gap:6px;">
                            <span
                                style="background:var(--success-soft);color:var(--success);font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">Aktif</span>
                            <span
                                style="background:#eff6ff;color:var(--primary);font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">14
                                Sesi</span>
                        </div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:24px;font-weight:800;color:var(--success);">82</div>
                        <div style="font-size:10px;color:var(--muted);">Rata-rata</div>
                    </div>
                </div>

                {{-- Progres per topik --}}
                <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:10px;">📊 Progres Belajar</div>
                @php
                    $topiks = [
                        ['Trigonometri', '100', 'var(--success)'],
                        ['Kalkulus', '82', 'var(--primary)'],
                        ['Aljabar', '90', 'var(--primary-light)'],
                        ['Statistika', '65', 'var(--warning)'],
                        ['Integral', 'Sedang', 'var(--accent)'],
                    ];
                @endphp
                @foreach ($topiks as $t)
                    <div style="margin-bottom:8px;">
                        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:3px;">
                            <span style="font-weight:600;color:var(--text);">{{ $t[0] }}</span>
                            <span
                                style="font-weight:700;color:{{ $t[2] }};">{{ $t[1] === 'Sedang' ? '🔵 Sedang' : $t[1] . '%' }}</span>
                        </div>
                        @if ($t[1] !== 'Sedang')
                            <div style="height:6px;border-radius:10px;background:var(--border);overflow:hidden;">
                                <div
                                    style="height:100%;border-radius:10px;width:{{ $t[1] }}%;background:{{ $t[2] }};">
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Sesi terakhir --}}
                <div style="font-size:13px;font-weight:700;color:var(--text);margin:14px 0 10px;">🕐 Sesi Terakhir</div>
                @foreach ([['29 Apr 2026', 'Trigonometri', '90 mnt', 'Offline'], ['22 Apr 2026', 'Kalkulus', '90 mnt', 'Online']] as $sesi)
                    <div
                        style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border);">
                        <div style="font-size:11px;color:var(--muted);min-width:70px;">{{ $sesi[0] }}</div>
                        <div style="flex:1;font-size:12.5px;font-weight:600;color:var(--text);">{{ $sesi[1] }}</div>
                        <div style="font-size:11px;color:var(--muted);">{{ $sesi[2] }} · {{ $sesi[3] }}</div>
                    </div>
                @endforeach

                <div class="d-flex gap-2 mt-4">
                    <button
                        style="flex:1;padding:10px;border-radius:10px;border:1.5px solid var(--border);background:var(--bg);color:var(--muted);font-size:13px;font-weight:700;cursor:pointer;"
                        onclick="closeModal()">Tutup</button>
                    <a href="/tutor/jadwal"
                        style="flex:1;padding:10px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-size:13px;font-weight:700;cursor:pointer;text-align:center;text-decoration:none;">
                        <i class="bi bi-calendar-plus me-1"></i> Jadwal Sesi
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function toggleView(view) {
            document.getElementById('view-grid').style.display = view === 'grid' ? '' : 'none';
            document.getElementById('view-table').style.display = view === 'table' ? '' : 'none';
            document.getElementById('btnGrid2').classList.toggle('active', view === 'grid');
            document.getElementById('btnTable2').classList.toggle('active', view === 'table');
        }

        function openModalSiswa(name) {
            document.getElementById('modal-siswa-name').textContent = name;
            document.getElementById('modal-siswa').classList.add('show');
        }

        function closeModal() {
            document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
        }

        function filterSiswa() {
            const q = document.getElementById('searchSiswa').value.toLowerCase();
            document.querySelectorAll('.siswa-card-wrap').forEach(card => {
                const name = card.querySelector('.siswa-name').textContent.toLowerCase();
                card.style.display = name.includes(q) ? '' : 'none';
            });
        }
    </script>
@endpush
