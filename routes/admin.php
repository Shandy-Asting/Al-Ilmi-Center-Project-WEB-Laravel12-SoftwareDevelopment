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
use App\Models\Notifikasi;
use Barryvdh\DomPDF\Facade\Pdf;

// ── Helper: Buat notifikasi untuk admin ────────────────────────────────
if (!function_exists('notifAdmin')) {
    function notifAdmin(string $judul, string $pesan, string $tipe, array $opsi = []): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if (!$admin) return;

        \App\Models\Notifikasi::create([
            'user_id'        => $admin->id,
            'judul'          => $judul,
            'pesan'          => $pesan,
            'tipe'           => $tipe,
            'ikon'           => $opsi['ikon']      ?? 'bi bi-bell-fill',
            'warna'          => $opsi['warna']     ?? 'var(--info-soft)',
            'url_aksi'       => $opsi['url']       ?? null,
            'label_aksi'     => $opsi['label']     ?? null,
            'referensi_id'   => $opsi['ref_id']    ?? null,
            'referensi_tipe' => $opsi['ref_tipe']  ?? null,
        ]);
    }
}


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // ── Halaman Statis ─────────────────────────────────────────────────────
    Route::get('/dashboard', function () {
        $now = now();

        // Stat cards
        $totalPengguna  = User::count();
        $totalSiswa     = User::where('role', 'siswa')->count();
        $totalTutor     = User::where('role', 'tutor')->count();
        $totalLes       = LesPrivat::count();
        $pendapatanLes  = LesPrivat::where('status', 'selesai')->sum('harga');
        $sesiSelesai    = LesPrivat::where('status', 'selesai')->count();

        // Pembayaran pending & pesanan baru
        $pembayaranPending = Pembayaran::where('status', 'menunggu')->count();
        $pesananBaru       = LesPrivat::where('status', 'menunggu')->count();

        // Aktivitas terbaru
        $aktivitasTerbaru = collect();

        User::where('role', 'siswa')->latest()->take(2)->get()->each(function ($u) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => '#eff6ff',
                'color' => 'var(--primary)',
                'icon'  => 'bi-person-plus-fill',
                'title' => 'Siswa baru mendaftar',
                'desc'  => $u->name . ' bergabung sebagai siswa ' . strtoupper($u->jenjang ?? 'SMA'),
                'time'  => $u->created_at->diffForHumans(),
                'sort'  => $u->created_at,
            ]);
        });

        Pembayaran::with('siswa')->where('status', 'dikonfirmasi')->latest()->take(2)->get()->each(function ($p) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => 'var(--success-soft)',
                'color' => 'var(--success)',
                'icon'  => 'bi-credit-card-fill',
                'title' => 'Pembayaran dikonfirmasi',
                'desc'  => ($p->siswa->name ?? '-') . ' — Rp ' . number_format($p->jumlah, 0, ',', '.'),
                'time'  => $p->dikonfirmasi_at?->diffForHumans() ?? $p->updated_at->diffForHumans(),
                'sort'  => $p->dikonfirmasi_at ?? $p->updated_at,
            ]);
        });

        User::where('role', 'tutor')->latest()->take(1)->get()->each(function ($u) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => 'var(--accent-soft)',
                'color' => 'var(--warning)',
                'icon'  => 'bi-person-badge-fill',
                'title' => 'Tutor baru terdaftar',
                'desc'  => $u->name . ' mendaftar sebagai tutor',
                'time'  => $u->created_at->diffForHumans(),
                'sort'  => $u->created_at,
            ]);
        });

        LesPrivat::where('status', 'dibatalkan')->latest()->take(1)->get()->each(function ($l) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => 'var(--danger-soft)',
                'color' => 'var(--danger)',
                'icon'  => 'bi-x-circle-fill',
                'title' => 'Pesanan les dibatalkan',
                'desc'  => ($l->siswa->name ?? '-') . ' membatalkan sesi ' . $l->mata_pelajaran,
                'time'  => $l->updated_at->diffForHumans(),
                'sort'  => $l->updated_at,
            ]);
        });

        Materi::with('tutor')->latest()->take(1)->get()->each(function ($m) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'bg'    => 'var(--info-soft)',
                'color' => 'var(--info)',
                'icon'  => 'bi-upload',
                'title' => 'Materi baru diunggah',
                'desc'  => ($m->tutor->name ?? '-') . ' — ' . $m->mata_pelajaran . ' ' . strtoupper($m->jenjang ?? ''),
                'time'  => $m->created_at->diffForHumans(),
                'sort'  => $m->created_at,
            ]);
        });

        $aktivitasTerbaru = $aktivitasTerbaru->sortByDesc('sort')->take(6)->values();

        $penggunaTerbaru = User::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalSiswa',
            'totalTutor',
            'totalLes',
            'pendapatanLes',
            'sesiSelesai',
            'pembayaranPending',
            'pesananBaru',
            'aktivitasTerbaru',
            'penggunaTerbaru',
        ));
    });

    Route::get('/pengguna', function () {
        $pengguna = User::latest()->get();
        return view('admin.pengguna', compact('pengguna'));
    });

    Route::get('/pengguna/export', function (Request $request) {
        $role = $request->query('role', 'siswa');
        $users = User::where('role', $role)->latest()->get();

        $headers = ['Content-Type' => 'text/csv'];
        $filename = 'data-' . $role . '-' . now()->format('Y-m-d') . '.csv';

        $callback = function () use ($users, $role) {
            $file = fopen('php://output', 'w');
            if ($role === 'siswa') {
                fputcsv($file, ['Nama', 'Email', 'No HP', 'Tanggal Daftar']);
                foreach ($users as $u) {
                    fputcsv($file, [$u->name, $u->email, $u->no_hp ?? '-', $u->created_at->format('d M Y')]);
                }
            } else {
                fputcsv($file, ['Nama', 'Email', 'No HP', 'Bergabung']);
                foreach ($users as $u) {
                    fputcsv($file, [$u->name, $u->email, $u->no_hp ?? '-', $u->created_at->format('d M Y')]);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, array_merge($headers, [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]));
    });

    Route::get('/pengguna/{id}', function ($id) {
        $user = User::findOrFail($id);
        return view('admin.pengguna-detail', compact('user'));
    });

    Route::delete('/pengguna/{id}', function ($id) {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak bisa dihapus.');
        }

        $nama = $user->name;

        // Hapus data relasi dulu
        $user->lesPrivat()->delete();
        $user->notifikasi()->delete();
        $user->hasilLatihan()->delete();
        $user->aktivitasBelajar()->delete();

        $user->delete();

        return back()->with('sukses', 'Akun ' . $nama . ' berhasil dihapus.');
    });

    // Nonaktifkan user
    Route::post('/pengguna/{id}/nonaktifkan', function ($id) {
        $user = User::findOrFail($id);
        $user->update(['status' => 'nonaktif']);
        return back()->with('sukses', 'Akun ' . $user->name . ' berhasil dinonaktifkan.');
    });

    // Aktifkan kembali user
    Route::post('/pengguna/{id}/aktifkan', function ($id) {
        $user = User::findOrFail($id);
        $user->update(['status' => 'aktif']);
        return back()->with('sukses', 'Akun ' . $user->name . ' berhasil diaktifkan kembali.');
    });


    Route::get('/transaksi/export', function (Request $request) {
        $status = $request->query('status');
        $metode = $request->query('metode');
        $search = $request->query('search');

        $query = Pembayaran::with(['siswa', 'lesPrivat'])->orderBy('created_at', 'desc');

        if ($status && $status !== 'semua') {
            $map = ['berhasil' => 'dikonfirmasi', 'pending' => 'menunggu', 'gagal' => 'ditolak'];
            $query->where('status', $map[$status] ?? $status);
        }

        if ($metode && $metode !== 'semua') {
            $query->where('bank_tujuan', 'like', "%$metode%");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%$search%")
                    ->orWhereHas('siswa', fn($q2) => $q2->where('name', 'like', "%$search%"));
            });
        }

        $transaksi = $query->get();

        $filename = 'transaksi-' . now()->format('Y-m-d') . '.csv';

        $callback = function () use ($transaksi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Invoice', 'Nama Siswa', 'Email', 'Layanan', 'Metode', 'Jumlah', 'Status', 'Tanggal']);
            foreach ($transaksi as $tx) {
                $statusLabel = match ($tx->status) {
                    'dikonfirmasi' => 'Berhasil',
                    'menunggu'     => 'Pending',
                    'ditolak'      => 'Gagal',
                    default        => $tx->status,
                };
                fputcsv($file, [
                    $tx->nomor_invoice,
                    $tx->siswa->name ?? '-',
                    $tx->siswa->email ?? '-',
                    'Les Privat – ' . ($tx->lesPrivat->mata_pelajaran ?? '-'),
                    $tx->bank_tujuan ?? '-',
                    $tx->jumlah,
                    $statusLabel,
                    $tx->created_at->format('d M Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    });

    Route::get('/transaksi', function (Request $request) {
        // Stat cards
        $totalTransaksi    = Pembayaran::count();
        $totalBerhasil     = Pembayaran::where('status', 'dikonfirmasi')->count();
        $totalPending      = Pembayaran::where('status', 'menunggu')->count();
        $totalPendapatan   = Pembayaran::where('status', 'dikonfirmasi')->sum('jumlah');

        $bulanLalu         = Pembayaran::whereMonth('created_at', now()->subMonth()->month)->count();
        $berhasilBulanLalu = Pembayaran::where('status', 'dikonfirmasi')->whereMonth('created_at', now()->subMonth()->month)->count();
        $pendapatanBulanLalu = Pembayaran::where('status', 'dikonfirmasi')->whereMonth('dikonfirmasi_at', now()->subMonth()->month)->sum('jumlah');

        // Filter
        $status  = $request->query('status');
        $metode  = $request->query('metode');
        $search  = $request->query('search');

        $query = Pembayaran::with(['siswa', 'lesPrivat'])
            ->orderBy('created_at', 'desc');

        if ($status && $status !== 'semua') {
            $map = ['berhasil' => 'dikonfirmasi', 'pending' => 'menunggu', 'gagal' => 'ditolak'];
            $query->where('status', $map[$status] ?? $status);
        }

        if ($metode && $metode !== 'semua') {
            $query->where('bank_tujuan', 'like', "%$metode%");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%$search%")
                    ->orWhereHas('siswa', fn($q2) => $q2->where('name', 'like', "%$search%"));
            });
        }

        $transaksi = $query->paginate(6)->withQueryString();

        // Donut stats
        $totalSemua  = Pembayaran::count() ?: 1;
        $pctBerhasil = round($totalBerhasil / $totalSemua * 100);
        $pctPending  = round($totalPending / $totalSemua * 100);
        $totalGagal  = Pembayaran::where('status', 'ditolak')->count();
        $pctGagal    = round($totalGagal / $totalSemua * 100);

        // Pendapatan per layanan (mata pelajaran)
        $pendapatanPerLayanan = Pembayaran::with('lesPrivat')
            ->where('status', 'dikonfirmasi')
            ->get()
            ->groupBy(fn($p) => $p->lesPrivat->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => [
                'nama'   => 'Les Privat – ' . $mapel,
                'jumlah' => $list->sum('jumlah'),
            ])
            ->sortByDesc('jumlah')
            ->take(4)
            ->values();

        $maxLayanan = $pendapatanPerLayanan->max('jumlah') ?: 1;

        return view('admin.transaksi', compact(
            'totalTransaksi',
            'totalBerhasil',
            'totalPending',
            'totalPendapatan',
            'bulanLalu',
            'berhasilBulanLalu',
            'pendapatanBulanLalu',
            'transaksi',
            'pctBerhasil',
            'pctPending',
            'totalGagal',
            'pctGagal',
            'pendapatanPerLayanan',
            'maxLayanan',
        ));
    });

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

    // ── Notifikasi Admin ───────────────────────────────────────────────────

    // Muat notifikasi lebih lama (pagination) — harus di atas {id}
    Route::get('/notifikasi/lebih-lama', function (Request $request) {
        $page = $request->query('page', 1);

        $notifikasi = \App\Models\Notifikasi::where('user_id', auth()->id())
            ->where('created_at', '<', now()->subWeek())
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page);

        return response()->json($notifikasi);
    });

    // Tandai semua dibaca — harus di atas {id}
    Route::post('/notifikasi/baca-semua', function () {
        \App\Models\Notifikasi::where('user_id', auth()->id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return redirect('/admin/notifikasi')->with('sukses', 'Semua notifikasi telah ditandai dibaca.');
    });

    // Tandai satu notifikasi dibaca
    Route::post('/notifikasi/{id}/baca', function ($id) {
        $notif = \App\Models\Notifikasi::where('user_id', auth()->id())
            ->findOrFail($id);
        $notif->update(['sudah_dibaca' => true]);

        return response()->json(['sukses' => true]);
    });

    // Tampilkan halaman notifikasi — paling bawah
    Route::get('/notifikasi', function () {
        $adminId = auth()->id();

        $semuaNotifikasi = \App\Models\Notifikasi::where('user_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->get();

        $hariIni   = $semuaNotifikasi->filter(fn($n) => $n->created_at->isToday());
        $kemarin   = $semuaNotifikasi->filter(fn($n) => $n->created_at->isYesterday());
        $mingguIni = $semuaNotifikasi->filter(
            fn($n) =>
            !$n->created_at->isToday() &&
                !$n->created_at->isYesterday() &&
                $n->created_at->isCurrentWeek()
        );
        $lebihLama = $semuaNotifikasi->filter(
            fn($n) =>
            !$n->created_at->isToday() &&
                !$n->created_at->isYesterday() &&
                !$n->created_at->isCurrentWeek()
        );

        $belumDibaca = [
            'semua'      => $semuaNotifikasi->where('sudah_dibaca', false)->count(),
            'pembayaran' => $semuaNotifikasi->where('sudah_dibaca', false)->where('tipe', 'pembayaran')->count(),
            'les'        => $semuaNotifikasi->where('sudah_dibaca', false)->where('tipe', 'les_privat')->count(),
            'pengguna'   => $semuaNotifikasi->where('sudah_dibaca', false)->where('tipe', 'sistem')->count(),
            'sistem'     => $semuaNotifikasi->where('sudah_dibaca', false)->where('tipe', 'sistem')->count(),
        ];

        return view('admin.notifikasi', compact(
            'hariIni',
            'kemarin',
            'mingguIni',
            'lebihLama',
            'belumDibaca',
        ));
    });

    // ── Paket ──────────────────────────────────────────────────────────────

    // Tampilkan halaman pengelolaan paket dengan data dari DB
    Route::get('/paket', function () {
        $pakets = Paket::orderByRaw("FIELD(tipe,'sd','smp','sma')")
            ->orderBy('harga_min')
            ->get();
        return view('admin.paket', compact('pakets'));
    });

    // Tambah paket baru
    Route::post('/paket', function (Request $request) {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'tipe'           => 'required|in:sd,smp,sma',
            'harga_min'      => 'required|numeric|min:0',
            'harga_max'      => 'nullable|numeric|min:0',
            'jumlah_soal'    => 'nullable|integer|min:0',
            'jumlah_les'     => 'nullable|integer|min:0',
            'feedback_tutor' => 'nullable|boolean',
            'akses_penuh'    => 'nullable|boolean',
        ], [
            'nama.required'      => 'Nama paket wajib diisi.',
            'tipe.required'      => 'Tipe jenjang wajib dipilih.',
            'harga_min.required' => 'Harga minimum wajib diisi.',
            'harga_min.numeric'  => 'Harga minimum harus berupa angka.',
        ]);

        $data = $request->only([
            'nama',
            'tipe',
            'harga_min',
            'harga_max',
            'jumlah_soal',
            'jumlah_les',
        ]);
        $data['feedback_tutor'] = $request->boolean('feedback_tutor');
        $data['akses_penuh']    = $request->boolean('akses_penuh');

        Paket::create($data);

        return redirect('/admin/paket')->with('sukses', 'Paket berhasil ditambahkan!');
    });

    // Update paket — pakai POST /paket/{id}/update karena form HTML biasa
    Route::post('/paket/{id}/update', function (Request $request, $id) {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama'           => 'required|string|max:100',
            'tipe'           => 'required|in:sd,smp,sma',
            'harga_min'      => 'required|numeric|min:0',
            'harga_max'      => 'nullable|numeric|min:0',
            'jumlah_soal'    => 'nullable|integer|min:0',
            'jumlah_les'     => 'nullable|integer|min:0',
            'feedback_tutor' => 'nullable|boolean',
            'akses_penuh'    => 'nullable|boolean',
        ], [
            'nama.required'      => 'Nama paket wajib diisi.',
            'tipe.required'      => 'Tipe jenjang wajib dipilih.',
            'harga_min.required' => 'Harga minimum wajib diisi.',
        ]);

        $data = $request->only([
            'nama',
            'tipe',
            'harga_min',
            'harga_max',
            'jumlah_soal',
            'jumlah_les',
        ]);
        $data['feedback_tutor'] = $request->boolean('feedback_tutor');
        $data['akses_penuh']    = $request->boolean('akses_penuh');

        $paket->update($data);

        return redirect('/admin/paket')->with('sukses', 'Paket berhasil diperbarui!');
    });

    // Hapus paket
    Route::post('/paket/{id}/hapus', function ($id) {
        $paket = Paket::findOrFail($id);
        $nama  = $paket->nama;
        $paket->delete();

        return redirect('/admin/paket')->with('sukses', 'Paket "' . $nama . '" berhasil dihapus!');
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
