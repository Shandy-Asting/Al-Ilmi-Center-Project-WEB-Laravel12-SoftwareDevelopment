@extends('layouts.app')
@section('title', 'Latihan Soal - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Latihan Soal')
@section('page-sub', 'Belajar TKA / Latihan Soal')

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

@push('styles')
    <style>
        .opsi-label {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all .2s;
            background: #fff;
        }

        .opsi-label:hover {
            border-color: #1e3a5f;
            background: #f8faff;
        }

        .opsi-label.dipilih {
            border-color: #1e3a5f;
            background: #eff6ff;
        }

        .opsi-label.dipilih .opsi-key {
            background: #1e3a5f !important;
            color: #fff !important;
        }

        .opsi-key {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            background: #f1f5f9;
            color: #64748b;
            flex-shrink: 0;
            transition: all .2s;
        }

        .nomor-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            color: #64748b;
        }

        .nomor-btn.current {
            background: #1e3a5f;
            border-color: #1e3a5f;
            color: #fff;
        }

        .nomor-btn.answered {
            background: #16a34a;
            border-color: #16a34a;
            color: #fff;
        }

        /* ══ RESPONSIVE GLOBAL ══ */
        @media (max-width: 991px) {
            .row>[class*='col-lg'] {
                margin-bottom: 12px;
            }
        }

        @media (max-width: 767px) {
            h4.fw-bold {
                font-size: 1.1rem !important;
            }

            .d-flex.justify-content-between {
                flex-wrap: wrap;
                gap: 10px;
            }

            .stat-card {
                padding: 14px !important;
            }

            .stat-val {
                font-size: 1.3rem !important;
            }

            .main-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .main-tab {
                min-width: 100px;
                flex: none;
            }

            table {
                font-size: 12px !important;
            }

            table td,
            table th {
                padding: 8px 10px !important;
            }

            .card-box-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-box {
                width: 96% !important;
                margin: 10px auto;
            }
        }

        @media (max-width: 480px) {
            .stat-card {
                flex-direction: column;
                gap: 8px;
            }

            .d-flex.gap-2 {
                flex-wrap: wrap;
            }

            .btn {
                font-size: 12px !important;
                padding: 7px 12px !important;
            }
        }
    </style>
@endpush

@section('content')

    <form method="POST" action="/siswa/belajar-tka/{{ $materi->id }}/submit" id="form-latihan">
        @csrf
        <input type="hidden" name="tipe" value="latihan">
        <input type="hidden" name="durasi_menit" id="durasi_menit" value="0">

        <div class="row g-3">

            {{-- KOLOM KIRI: SOAL --}}
            <div class="col-lg-8">

                {{-- HEADER --}}
                <div
                    style="background:linear-gradient(135deg,#1e3a5f,#2d5282);border-radius:16px;padding:20px 24px;color:#fff;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:16px;font-weight:800;">{{ $materi->judul }}</div>
                        <div style="font-size:12.5px;opacity:.8;">{{ $materi->mata_pelajaran }} ·
                            {{ strtoupper($materi->jenjang) }} · {{ count($soal) }} Soal</div>
                    </div>
                    <div
                        style="background:rgba(255,255,255,.15);border-radius:10px;padding:8px 16px;text-align:center;min-width:80px;">
                        <div style="font-size:22px;font-weight:800;" id="timer">20:00</div>
                        <div style="font-size:10px;opacity:.7;">Sisa Waktu</div>
                    </div>
                </div>

                {{-- SOAL --}}
                @forelse($soal as $index => $s)
                    <div class="soal-item" id="soal-{{ $index }}"
                        style="{{ $index > 0 ? 'display:none;' : '' }}background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:24px;margin-bottom:16px;">

                        <div
                            style="font-size:11px;font-weight:700;color:#1e3a5f;text-transform:uppercase;margin-bottom:10px;">
                            SOAL {{ $index + 1 }} DARI {{ count($soal) }}
                        </div>
                        <div style="font-size:15px;line-height:1.7;margin-bottom:20px;font-weight:500;">
                            {{ $s->pertanyaan }}
                        </div>

                        @foreach (['a', 'b', 'c', 'd'] as $opsi)
                            <label class="opsi-label" id="label-{{ $s->id }}-{{ $opsi }}">
                                <input type="radio" name="jawaban[{{ $s->id }}]" value="{{ $opsi }}"
                                    style="display:none;"
                                    onchange="piliOpsi('{{ $s->id }}', '{{ $opsi }}', {{ $index }})">
                                <div class="opsi-key">{{ strtoupper($opsi) }}</div>
                                <div style="font-size:13.5px;line-height:1.5;padding-top:4px;">
                                    {{ $s->{'pilihan_' . $opsi} }}
                                </div>
                            </label>
                        @endforeach

                        <div style="display:flex;justify-content:space-between;margin-top:20px;">
                            @if ($index > 0)
                                <button type="button" onclick="gotoSoal({{ $index }}, {{ $index - 1 }})"
                                    style="border:none;border-radius:10px;padding:10px 22px;font-size:13px;font-weight:700;background:#f1f5f9;color:#64748b;cursor:pointer;">
                                    <i class="bi bi-chevron-left me-1"></i> Sebelumnya
                                </button>
                            @else
                                <div></div>
                            @endif

                            @if ($index < count($soal) - 1)
                                <button type="button" onclick="gotoSoal({{ $index }}, {{ $index + 1 }})"
                                    style="border:none;border-radius:10px;padding:10px 22px;font-size:13px;font-weight:700;background:#1e3a5f;color:#fff;cursor:pointer;">
                                    Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                                </button>
                            @else
                                <button type="button" onclick="konfirmasiKumpul()"
                                    style="border:none;border-radius:10px;padding:10px 22px;font-size:13px;font-weight:700;background:#16a34a;color:#fff;cursor:pointer;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Kumpulkan Jawaban
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:40px;background:#fff;border-radius:16px;">
                        <i class="bi bi-inbox" style="font-size:48px;color:#94a3b8;"></i>
                        <div style="font-size:15px;font-weight:600;margin-top:12px;color:#64748b;">Belum ada soal untuk
                            materi ini</div>
                        <a href="/siswa/belajar-tka"
                            style="display:inline-block;margin-top:12px;padding:8px 20px;background:#1e3a5f;color:#fff;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;">
                            Kembali
                        </a>
                    </div>
                @endforelse

            </div>

            {{-- KOLOM KANAN: NAVIGASI --}}
            <div class="col-lg-4">
                <div
                    style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:20px;position:sticky;top:20px;">
                    <div style="font-size:13px;font-weight:700;margin-bottom:12px;color:#1e3a5f;">Navigasi Soal</div>

                    {{-- GRID NOMOR SOAL --}}
                    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:6px;margin-bottom:16px;">
                        @foreach ($soal as $index => $s)
                            <button type="button" class="nomor-btn {{ $index === 0 ? 'current' : '' }}"
                                id="nomor-{{ $index }}" onclick="gotoSoal(soalAktif, {{ $index }})">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>

                    {{-- LEGENDA --}}
                    <div style="font-size:11px;color:#64748b;margin-bottom:16px;">
                        <span class="me-3">
                            <span
                                style="display:inline-block;width:10px;height:10px;background:#1e3a5f;border-radius:3px;"></span>
                            Aktif
                        </span>
                        <span class="me-3">
                            <span
                                style="display:inline-block;width:10px;height:10px;background:#16a34a;border-radius:3px;"></span>
                            Dijawab
                        </span>
                        <span>
                            <span
                                style="display:inline-block;width:10px;height:10px;background:#e2e8f0;border-radius:3px;border:1px solid #cbd5e1;"></span>
                            Belum
                        </span>
                    </div>

                    {{-- STATISTIK --}}
                    <div style="background:#f8faff;border-radius:10px;padding:12px;margin-bottom:16px;">
                        <div style="font-size:12px;font-weight:700;color:#1e3a5f;margin-bottom:8px;">Statistik</div>
                        <div class="d-flex justify-content-between">
                            <div class="text-center">
                                <div style="font-size:18px;font-weight:800;color:#16a34a;" id="stat-dijawab">0</div>
                                <div style="font-size:10px;color:#64748b;">Dijawab</div>
                            </div>
                            <div class="text-center">
                                <div style="font-size:18px;font-weight:800;color:#94a3b8;" id="stat-belum">
                                    {{ count($soal) }}</div>
                                <div style="font-size:10px;color:#64748b;">Belum</div>
                            </div>
                            <div class="text-center">
                                <div style="font-size:18px;font-weight:800;color:#1e3a5f;" id="stat-total">
                                    {{ count($soal) }}</div>
                                <div style="font-size:10px;color:#64748b;">Total</div>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL KUMPUL --}}
                    <button type="button" onclick="konfirmasiKumpul()"
                        style="width:100%;border:none;border-radius:10px;padding:12px;font-size:13px;font-weight:700;background:#16a34a;color:#fff;cursor:pointer;">
                        <i class="bi bi-check-circle-fill me-1"></i> Kumpulkan Jawaban
                    </button>

                    <a href="/siswa/belajar-tka"
                        style="display:block;text-align:center;margin-top:10px;font-size:12px;color:#64748b;text-decoration:none;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Materi
                    </a>
                </div>
            </div>

        </div>
    </form>

    {{-- MODAL KONFIRMASI --}}
    <div class="modal fade" id="modalKumpul" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
            <div class="modal-content" style="border-radius:16px;border:none;">
                <div class="modal-body text-center p-4">
                    <div
                        style="width:60px;height:60px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:#16a34a;margin:0 auto 16px;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h5 style="font-weight:700;margin-bottom:8px;">Kumpulkan Jawaban?</h5>
                    <p style="font-size:.84rem;color:#64748b;margin-bottom:4px;">
                        Kamu sudah menjawab <strong id="modal-dijawab">0</strong> dari
                        <strong>{{ count($soal) }}</strong> soal.
                    </p>
                    <p style="font-size:.8rem;color:#94a3b8;margin-bottom:20px;">Jawaban tidak bisa diubah setelah
                        dikumpulkan.</p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn rounded-2 fw-semibold flex-fill"
                            style="background:#f1f5f9;color:#64748b;border:none;font-size:.85rem;"
                            data-bs-dismiss="modal">Periksa Lagi</button>
                        <button type="button" class="btn rounded-2 fw-semibold flex-fill"
                            style="background:#16a34a;color:#fff;border:none;font-size:.85rem;" onclick="submitLatihan()">
                            <i class="bi bi-check2-circle me-1"></i> Ya, Kumpulkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let soalAktif = 0;
        let dijawab = {};
        const totalSoal = {{ count($soal) }};

        // ── TIMER ──
        let totalDetik = 20 * 60;
        let startTime = Date.now();
        const timerEl = document.getElementById('timer');
        const durasiEl = document.getElementById('durasi_menit');

        const interval = setInterval(() => {
            if (totalDetik <= 0) {
                clearInterval(interval);
                submitLatihan();
                return;
            }
            totalDetik--;
            const m = Math.floor(totalDetik / 60).toString().padStart(2, '0');
            const s = (totalDetik % 60).toString().padStart(2, '0');
            if (timerEl) timerEl.textContent = m + ':' + s;
            // Warna merah jika < 2 menit
            if (totalDetik < 120) timerEl.style.color = '#fca5a5';
        }, 1000);

        // ── PILIH OPSI ──
        function piliOpsi(soalId, opsi, index) {
            // Reset semua label di soal ini
            ['a', 'b', 'c', 'd'].forEach(o => {
                const lbl = document.getElementById('label-' + soalId + '-' + o);
                if (lbl) lbl.classList.remove('dipilih');
            });
            // Highlight yang dipilih
            const selected = document.getElementById('label-' + soalId + '-' + opsi);
            if (selected) selected.classList.add('dipilih');

            // Catat jawaban
            const sudahDijawab = dijawab[soalId] !== undefined;
            dijawab[soalId] = opsi;

            // Update nomor soal jadi hijau
            const nomorBtn = document.getElementById('nomor-' + index);
            if (nomorBtn) {
                nomorBtn.classList.remove('current');
                nomorBtn.classList.add('answered');
            }

            // Update statistik
            updateStatistik();
        }

        // ── NAVIGASI SOAL ──
        function gotoSoal(dari, ke) {
            if (ke < 0 || ke >= totalSoal) return;

            // Sembunyikan soal aktif
            document.getElementById('soal-' + dari).style.display = 'none';
            const nomorDari = document.getElementById('nomor-' + dari);
            if (nomorDari) {
                nomorDari.classList.remove('current');
                // Kalau belum dijawab, kembalikan ke default
            }

            // Tampilkan soal tujuan
            document.getElementById('soal-' + ke).style.display = '';
            const nomorKe = document.getElementById('nomor-' + ke);
            if (nomorKe) {
                nomorKe.classList.remove('answered'); // sementara hapus answered
                nomorKe.classList.add('current');
                // Kalau sudah dijawab, tambahkan keduanya tidak bisa — cukup current
            }

            soalAktif = ke;
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // ── UPDATE STATISTIK ──
        function updateStatistik() {
            const jmlDijawab = Object.keys(dijawab).length;
            const jmlBelum = totalSoal - jmlDijawab;
            document.getElementById('stat-dijawab').textContent = jmlDijawab;
            document.getElementById('stat-belum').textContent = jmlBelum;
        }

        // ── KONFIRMASI KUMPUL ──
        function konfirmasiKumpul() {
            const jmlDijawab = Object.keys(dijawab).length;
            document.getElementById('modal-dijawab').textContent = jmlDijawab;
            new bootstrap.Modal(document.getElementById('modalKumpul')).show();
        }

        // ── SUBMIT ──
        function submitLatihan() {
            const elapsed = Math.round((Date.now() - startTime) / 60000);
            durasiEl.value = elapsed;
            clearInterval(interval);
            document.getElementById('form-latihan').submit();
        }
    </script>
@endpush
