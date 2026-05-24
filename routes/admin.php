<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Paket;
use App\Models\RekeningBank;
use App\Models\Pembayaran;
use App\Models\GajiTutor;
use App\Models\User;
use App\Models\LesPrivat;
use App\Models\HasilKuis;
use App\Models\AktivitasBelajar;
use App\Models\Materi;
use Barryvdh\DomPDF\Facade\Pdf;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // ── Halaman Statis ─────────────────────────────────────────────────────
    Route::get('/dashboard',  fn() => view('admin.dashboard'));
    Route::get('/pengguna',   fn() => view('admin.pengguna'));
    Route::get('/transaksi',  fn() => view('admin.transaksi'));

    Route::get('/pembayaran', function () {

        // Tab Pembayaran Siswa — semua pembayaran dari DB
        $pembayaranSiswa = Pembayaran::with(['siswa', 'tutor', 'lesPrivat'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tab Gaji Tutor — hitung per tutor berdasarkan les selesai & pembayaran lunas
        $gajiTutor = User::where('role', 'tutor')
            ->get()
            ->map(function ($tutor) {
                $periode = now()->translatedFormat('M Y');

                $sesiSelesai = LesPrivat::where('tutor_id', $tutor->id)
                    ->where('status', 'selesai')
                    ->where('pembayaran_status', 'lunas')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->get();

                if ($sesiSelesai->count() === 0) return null;

                $totalPendapatan = $sesiSelesai->sum('harga');
                $komisi          = (int) ($totalPendapatan * 0.20);
                $totalDiterima   = $totalPendapatan - $komisi;

                // Cek apakah sudah ada record gaji bulan ini
                $gajiRecord = GajiTutor::where('tutor_id', $tutor->id)
                    ->where('periode', $periode)
                    ->first();

                return [
                    'tutor'            => $tutor,
                    'total_sesi'       => $sesiSelesai->count(),
                    'total_pendapatan' => $totalPendapatan,
                    'komisi'           => $komisi,
                    'total_diterima'   => $totalDiterima,
                    'periode'          => $periode,
                    'status'           => $gajiRecord?->status ?? 'menunggu',
                    'gaji_id'          => $gajiRecord?->id,
                ];
            })
            ->filter()
            ->values();

        // Tab Riwayat
        $riwayatPembayaran = Pembayaran::with(['siswa', 'tutor', 'lesPrivat'])
            ->whereIn('status', ['dikonfirmasi', 'ditolak'])
            ->orderBy('dikonfirmasi_at', 'desc')
            ->get();

        $riwayatGaji = GajiTutor::with('tutor')
            ->where('status', 'dikonfirmasi')
            ->orderBy('dikonfirmasi_at', 'desc')
            ->get();

        // Statistik
        $stats = [
            'menunggu'        => Pembayaran::where('status', 'menunggu')->count(),
            'dikonfirmasi'    => Pembayaran::where('status', 'dikonfirmasi')->count(),
            'total_dikonfirmasi' => Pembayaran::where('status', 'dikonfirmasi')->sum('jumlah'),
            'gaji_belum_cair' => $gajiTutor->where('status', 'menunggu')->count(),
        ];

        return view('admin.pembayaran', compact(
            'pembayaranSiswa',
            'gajiTutor',
            'riwayatPembayaran',
            'riwayatGaji',
            'stats'
        ));
    });

    Route::post('/pembayaran/gaji/{tutor_id}/konfirmasi', function ($tutor_id) {
        $periode = now()->translatedFormat('M Y');
        $tutor   = User::findOrFail($tutor_id);

        $sesiSelesai = LesPrivat::where('tutor_id', $tutor_id)
            ->where('status', 'selesai', 'dikonfirmasi')
            ->where('pembayaran_status', 'lunas')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->get();

        $totalPendapatan = $sesiSelesai->sum('harga');
        $komisi          = (int) ($totalPendapatan * 0.20);
        $totalDiterima   = $totalPendapatan - $komisi;

        GajiTutor::updateOrCreate(
            ['tutor_id' => $tutor_id, 'periode' => $periode],
            [
                'total_sesi'       => $sesiSelesai->count(),
                'total_pendapatan' => $totalPendapatan,
                'komisi_platform'  => $komisi,
                'total_diterima'   => $totalDiterima,
                'status'           => 'dikonfirmasi',
                'dikonfirmasi_at'  => now(),
            ]
        );

        return back()->with('sukses', 'Gaji ' . $tutor->name . ' berhasil dikonfirmasi!');
    });

    Route::post('/pembayaran/gaji/{tutor_id}/tunda', function (Request $request, $tutor_id) {
        $periode = now()->translatedFormat('M Y');
        $tutor   = User::findOrFail($tutor_id);

        $sesiSelesai     = LesPrivat::where('tutor_id', $tutor_id)->where('status', 'selesai')->where('pembayaran_status', 'lunas')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->get();
        $totalPendapatan = $sesiSelesai->sum('harga');
        $komisi          = (int) ($totalPendapatan * 0.20);

        GajiTutor::updateOrCreate(
            ['tutor_id' => $tutor_id, 'periode' => $periode],
            [
                'total_sesi'       => $sesiSelesai->count(),
                'total_pendapatan' => $totalPendapatan,
                'komisi_platform'  => $komisi,
                'total_diterima'   => $totalPendapatan - $komisi,
                'status'           => 'ditunda',
                'catatan'          => $request->input('catatan', ''),
            ]
        );

        return back()->with('sukses', 'Gaji ' . $tutor->name . ' berhasil ditunda.');
    });


    Route::get('/laporan', function () {
        $now = now();

        // ── Stat Cards ──────────────────────────────────────────────────────
        $totalPengguna   = User::count();
        $totalLesPrivat  = LesPrivat::count();
        $soalDikerjakan  = HasilKuis::sum('total_soal') ?? 0;
        $rataRataBelajar = round(AktivitasBelajar::avg('durasi_menit') ?? 0);

        // ── Aktivitas Harian (7 hari terakhir) ──────────────────────────────
        $hariLabel = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $aktivitasSiswa = [];
        $aktivitasTutor = [];

        for ($i = 6; $i >= 0; $i--) {
            $tgl = $now->copy()->subDays($i)->toDateString();
            $hari = $hariLabel[$now->copy()->subDays($i)->dayOfWeek === 0 ? 6 : $now->copy()->subDays($i)->dayOfWeek - 1];

            $siswaAktif = AktivitasBelajar::whereDate('tanggal', $tgl)->distinct('user_id')->count();
            $tutorAktif = LesPrivat::whereDate('jadwal', $tgl)->where('status', 'dikonfirmasi')->distinct('tutor_id')->count();

            $aktivitasSiswa[] = ['hari' => $hari, 'nilai' => $siswaAktif];
            $aktivitasTutor[] = ['hari' => $hari, 'nilai' => $tutorAktif];
        }

        $maxSiswa = max(array_column($aktivitasSiswa, 'nilai')) ?: 1;
        $maxTutor = max(array_column($aktivitasTutor, 'nilai')) ?: 1;

        // ── Aktivitas Terbaru ────────────────────────────────────────────────
        $aktivitasTerbaru = collect();

        // Siswa baru
        User::where('role', 'siswa')->latest()->take(2)->get()->each(function ($u) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => '#eff6ff',
                'color' => 'var(--primary)',
                'icon'  => 'bi-person-plus-fill',
                'judul' => 'Siswa baru mendaftar',
                'sub'   => $u->name . ' — ' . strtoupper($u->jenjang ?? 'SMA'),
                'waktu' => $u->created_at->diffForHumans(),
                'sort'  => $u->created_at,
            ]);
        });

        // Kuis selesai
        HasilKuis::with('siswa')->latest()->take(2)->get()->each(function ($k) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => 'var(--success-soft)',
                'color' => 'var(--success)',
                'icon'  => 'bi-check-circle-fill',
                'judul' => 'Kuis selesai dikerjakan',
                'sub'   => ($k->materi->mata_pelajaran ?? 'Kuis') . ' — ' . $k->nilai . '/100',
                'waktu' => $k->created_at->diffForHumans(),
                'sort'  => $k->created_at,
            ]);
        });

        // Les dikonfirmasi
        LesPrivat::with(['siswa', 'tutor'])->where('status', 'dikonfirmasi')->latest()->take(2)->get()->each(function ($l) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => 'var(--accent-soft)',
                'color' => 'var(--warning)',
                'icon'  => 'bi-calendar-check-fill',
                'judul' => 'Les privat dikonfirmasi',
                'sub'   => $l->mata_pelajaran . ' — Tutor ' . ($l->tutor->name ?? '-'),
                'waktu' => $l->updated_at->diffForHumans(),
                'sort'  => $l->updated_at,
            ]);
        });

        // Pembayaran diterima
        Pembayaran::with('siswa')->where('status', 'dikonfirmasi')->latest()->take(2)->get()->each(function ($p) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => '#fce7f3',
                'color' => '#be185d',
                'icon'  => 'bi-credit-card-fill',
                'judul' => 'Pembayaran diterima',
                'sub'   => 'Rp ' . number_format($p->jumlah, 0, ',', '.') . ' — Les Privat',
                'waktu' => $p->dikonfirmasi_at?->diffForHumans() ?? $p->updated_at->diffForHumans(),
                'sort'  => $p->dikonfirmasi_at ?? $p->updated_at,
            ]);
        });

        $aktivitasTerbaru = $aktivitasTerbaru->sortByDesc('sort')->take(5)->values();

        // ── Materi Terpopuler ────────────────────────────────────────────────
        $materiTerpopuler = HasilKuis::with('materi')
            ->get()
            ->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => [
                'nama'    => $mapel,
                'jenjang' => $list->first()->materi->jenjang ?? 'SMA',
                'sesi'    => $list->count(),
            ])
            ->sortByDesc('sesi')
            ->take(5)
            ->values();

        $maxSesi = $materiTerpopuler->max('sesi') ?: 1;

        // ── Heatmap (5 minggu x 7 hari) ─────────────────────────────────────
        $heatmap = [];
        for ($w = 4; $w >= 0; $w--) {
            $row = [];
            for ($d = 0; $d <= 6; $d++) {
                $tgl   = $now->copy()->subWeeks($w)->startOfWeek()->addDays($d)->toDateString();
                $count = AktivitasBelajar::whereDate('tanggal', $tgl)->count();
                $row[] = $count === 0 ? 0 : ($count <= 2 ? 1 : ($count <= 5 ? 2 : ($count <= 10 ? 3 : 4)));
            }
            $heatmap[] = $row;
        }

        // ── Tutor Terbaik ────────────────────────────────────────────────────
        $tutorTerbaik = User::where('role', 'tutor')
            ->get()
            ->map(fn($t) => [
                'tutor'      => $t,
                'sesi'       => LesPrivat::where('tutor_id', $t->id)->where('status', 'selesai')->whereMonth('jadwal', $now->month)->count(),
                'mapel'      => $t->materi()->distinct('mata_pelajaran')->pluck('mata_pelajaran')->first() ?? 'Umum',
            ])
            ->sortByDesc('sesi')
            ->take(4)
            ->values();

        // ── Rata-rata Nilai per Mapel ────────────────────────────────────────
        $nilaiPerMapel = HasilKuis::with('materi')
            ->get()
            ->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => [
                'nama'  => $mapel,
                'rata'  => round($list->avg('nilai')),
            ])
            ->sortByDesc('rata')
            ->take(5)
            ->values();

        $colors = ['var(--primary)', 'var(--info)', 'var(--warning)', 'var(--danger)', 'var(--success)'];

        $rataRataTotal   = $nilaiPerMapel->avg('rata') ? round($nilaiPerMapel->avg('rata'), 1) : 0;
        $totalLulus      = HasilKuis::where('nilai', '>=', 60)->count();
        $totalHasil      = HasilKuis::count();
        $persenLulus     = $totalHasil > 0 ? round($totalLulus / $totalHasil * 100) : 0;

        return view('admin.laporan', compact(
            'totalPengguna',
            'totalLesPrivat',
            'soalDikerjakan',
            'rataRataBelajar',
            'aktivitasSiswa',
            'aktivitasTutor',
            'maxSiswa',
            'maxTutor',
            'aktivitasTerbaru',
            'materiTerpopuler',
            'maxSesi',
            'heatmap',
            'tutorTerbaik',
            'nilaiPerMapel',
            'colors',
            'rataRataTotal',
            'persenLulus'
        ));
    });

    Route::get('/laporan/export-pdf', function (Request $request) {
        $periode = $request->query('periode', now()->format('Y-m'));

        [$tahun, $bulan] = explode('-', $periode);

        $totalPengguna   = User::count();
        $totalLesPrivat  = LesPrivat::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->count();
        $soalDikerjakan  = HasilKuis::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->sum('total_soal') ?? 0;
        $rataRataBelajar = round(AktivitasBelajar::avg('durasi_menit') ?? 0);

        $materiTerpopuler = HasilKuis::with('materi')
            ->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)
            ->get()
            ->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => ['nama' => $mapel, 'sesi' => $list->count()])
            ->sortByDesc('sesi')->take(5)->values();

        $tutorTerbaik = User::where('role', 'tutor')->get()
            ->map(fn($t) => [
                'tutor' => $t,
                'sesi'  => LesPrivat::where('tutor_id', $t->id)->where('status', 'selesai')
                    ->whereYear('jadwal', $tahun)->whereMonth('jadwal', $bulan)->count(),
            ])
            ->sortByDesc('sesi')->take(5)->values();

        $nilaiPerMapel = HasilKuis::with('materi')
            ->get()
            ->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => ['nama' => $mapel, 'rata' => round($list->avg('nilai'))])
            ->sortByDesc('rata')->take(5)->values();

        $totalPembayaran = Pembayaran::where('status', 'dikonfirmasi')
            ->whereYear('dikonfirmasi_at', $tahun)->whereMonth('dikonfirmasi_at', $bulan)->sum('jumlah');

        $labelPeriode = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        $pdf = Pdf::loadView('admin.laporan-pdf', compact(
            'totalPengguna',
            'totalLesPrivat',
            'soalDikerjakan',
            'rataRataBelajar',
            'materiTerpopuler',
            'tutorTerbaik',
            'nilaiPerMapel',
            'totalPembayaran',
            'labelPeriode'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-' . $periode . '.pdf');
    });

    Route::get('/notifikasi', function () {
        return view('admin.notifikasi');
    });

    // ── Paket ──────────────────────────────────────────────────────────────
    Route::get('/paket', fn() => view('admin.paket'));

    Route::post('/paket', function (Request $request) {
        $request->validate([
            'nama'     => 'required',
            'tipe'     => 'required|in:sd,smp,sma',
            'harga_min' => 'required|numeric',
        ]);

        Paket::create($request->only([
            'nama',
            'tipe',
            'harga_min',
            'harga_max',
            'jumlah_soal',
            'jumlah_les',
            'feedback_tutor',
            'akses_penuh',
        ]));

        return redirect('/admin/paket')->with('sukses', 'Paket berhasil ditambahkan!');
    });

    // ── Rekening Bank ──────────────────────────────────────────────────────
    Route::get('/rekening', function () {
        return view('admin.rekening', [
            'rekening' => RekeningBank::orderBy('created_at', 'desc')->get(),
        ]);
    });

    Route::post('/rekening', function (Request $request) {
        $request->validate([
            'nama_bank'       => 'required',
            'nomor_rekening'  => 'required',
            'atas_nama'       => 'required',
        ]);

        RekeningBank::create($request->only(['nama_bank', 'nomor_rekening', 'atas_nama']));

        return redirect('/admin/rekening')->with('sukses', 'Rekening berhasil ditambahkan!');
    });

    Route::post('/rekening/{id}/update', function (Request $request, $id) {
        RekeningBank::findOrFail($id)->update(
            $request->only(['nama_bank', 'nomor_rekening', 'atas_nama'])
        );

        return redirect('/admin/rekening')->with('sukses', 'Rekening berhasil diperbarui!');
    });

    Route::post('/rekening/{id}/toggle', function ($id) {
        $rek = RekeningBank::findOrFail($id);
        $rek->update(['aktif' => ! $rek->aktif]);

        return redirect('/admin/rekening')->with('sukses', 'Status rekening diperbarui!');
    });

    Route::delete('/rekening/{id}', function ($id) {
        RekeningBank::findOrFail($id)->delete();

        return redirect('/admin/rekening')->with('sukses', 'Rekening berhasil dihapus!');
    });
});
