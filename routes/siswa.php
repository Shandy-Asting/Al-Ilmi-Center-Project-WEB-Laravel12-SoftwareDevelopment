<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\HasilBelajarExport;
use App\Models\AktivitasBelajar;
use App\Models\HasilKuis;
use App\Models\HasilLatihan;
use App\Models\LesPrivat;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\Paket;
use App\Models\User;
use App\Services\NotifikasiService;
use App\Models\Pembayaran;
use App\Models\RekeningBank;
use App\Models\Ulasan;

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {

    // ── Dashboard ──────────────────────────────────────────────────────────
    Route::get('/dashboard', function () {
        $user   = auth()->user();
        $userId = $user->id;
        $now    = now();

        $rataRataNilai    = round(HasilLatihan::where('user_id', $userId)->avg('nilai') ?? 0);
        $rataRataMingguLalu = round(HasilLatihan::where('user_id', $userId)
            ->whereBetween('created_at', [$now->copy()->subWeek()->startOfWeek(), $now->copy()->subWeek()->endOfWeek()])
            ->avg('nilai') ?? 0);
        $selisihNilai = $rataRataNilai - $rataRataMingguLalu;

        $soalDiselesaikan = HasilLatihan::where('user_id', $userId)->sum('soal_benar') ?? 0;
        $soalMingguIni    = HasilLatihan::where('user_id', $userId)
            ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
            ->sum('soal_benar') ?? 0;

        $jamBelajar    = round(AktivitasBelajar::where('user_id', $userId)->sum('durasi_menit') / 60, 1);
        $jamBulanIni   = round(AktivitasBelajar::where('user_id', $userId)->whereMonth('tanggal', $now->month)->sum('durasi_menit') / 60, 1);
        $jamBulanLalu  = round(AktivitasBelajar::where('user_id', $userId)->whereMonth('tanggal', $now->subMonth()->month)->sum('durasi_menit') / 60, 1);
        $selisihJam    = $jamBulanIni - $jamBulanLalu;

        $lesPrivat     = LesPrivat::where('user_id', $userId)->whereMonth('created_at', now()->month)->count();
        $lesPrivatLalu = LesPrivat::where('user_id', $userId)->whereMonth('created_at', now()->subMonth()->month)->count();
        $selisihLes    = $lesPrivat - $lesPrivatLalu;

        $streak = 0;
        for ($i = 0; $i < 30; $i++) {
            $tgl = now()->subDays($i)->toDateString();
            $ada = AktivitasBelajar::where('user_id', $userId)->whereDate('tanggal', $tgl)->exists();
            if ($ada) $streak++;
            else break;
        }

        $progresMapel = HasilKuis::where('user_id', $userId)->with('materi')->get()
            ->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => [
                'nama' => $mapel,
                'pct'  => min(round($list->avg('nilai')), 100),
            ])
            ->sortByDesc('pct')
            ->take(5)
            ->values();

        $hariLabel = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $aktivitasMingguan = [];
        $maxAktivitas = 1;
        for ($i = 6; $i >= 0; $i--) {
            $tgl = now()->subDays($i)->toDateString();
            $jumlah = AktivitasBelajar::where('user_id', $userId)->whereDate('tanggal', $tgl)->sum('durasi_menit');
            $aktivitasMingguan[] = ['hari' => $hariLabel[6 - $i], 'menit' => $jumlah];
            if ($jumlah > $maxAktivitas) $maxAktivitas = $jumlah;
        }

        $jadwalTerdekat = LesPrivat::where('user_id', $userId)
            ->where('status', 'dikonfirmasi')
            ->where('jadwal', '>', now())
            ->with('tutor')
            ->orderBy('jadwal', 'asc')
            ->take(3)
            ->get();

        // Rekomendasi materi (ambil 3 materi aktif terbaru)
        $rekomendasiMateri = Materi::where('status', 'aktif')
            ->withCount('soal')
            ->with('tutor')
            ->latest()
            ->take(3)
            ->get();

        // Ulasan untuk testimoni (dari semua siswa, bukan hanya siswa ini)
        $testimoni = \App\Models\Ulasan::with('siswa')
            ->whereNotNull('komentar')
            ->where('bintang', '>=', 4)
            ->latest()
            ->take(3)
            ->get();

        return view('siswa.dashboard', compact(
            'user',
            'rataRataNilai',
            'selisihNilai',
            'soalDiselesaikan',
            'soalMingguIni',
            'jamBulanIni',
            'selisihJam',
            'lesPrivat',
            'selisihLes',
            'streak',
            'progresMapel',
            'aktivitasMingguan',
            'maxAktivitas',
            'jadwalTerdekat',
            'testimoni',
            'rekomendasiMateri'
        ));
    });

    // ── Belajar TKA ────────────────────────────────────────────────────────
    Route::get('/belajar-tka', function () {
        $materi = Materi::where('status', 'aktif')
            ->withCount('soal')
            ->with('tutor')
            ->orderBy('mata_pelajaran')
            ->get();

        $perJenjang = [
            'sd'  => $materi->where('jenjang', 'sd')->count(),
            'smp' => $materi->where('jenjang', 'smp')->count(),
            'sma' => $materi->where('jenjang', 'sma')->count(),
        ];

        $daftarMapel = $materi->pluck('mata_pelajaran')->unique()->filter()->values();

        return view('siswa.belajar-tka', [
            'materi'      => $materi,
            'perJenjang'  => $perJenjang,
            'daftarMapel' => $daftarMapel,
        ]);
    });

    Route::get('/belajar-tka/{materi_id}/soal', function ($materi_id) {
        $user   = auth()->user();
        $materi = Materi::with('soal')->findOrFail($materi_id);
        $soal   = $materi->soal()->inRandomOrder()->take(15)->get();

        $hasilSebelumnya = HasilKuis::where('user_id', $user->id)
            ->where('materi_id', $materi_id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('siswa.latihan-soal', [
            'materi'          => $materi,
            'soal'            => $soal,
            'hasilSebelumnya' => $hasilSebelumnya,
        ]);
    });

    Route::post('/belajar-tka/{materi_id}/submit', function (Request $request, $materi_id) {
        $user     = auth()->user();
        $materi   = Materi::with('soal')->findOrFail($materi_id);
        $soalList = $materi->soal()->get()->keyBy('id');
        $jawaban  = $request->input('jawaban', []);

        $soalBenar     = 0;
        $soalSalah     = 0;
        $detailJawaban = [];

        foreach ($jawaban as $soalId => $jawabanSiswa) {
            $soal = $soalList->get($soalId);
            if (! $soal) continue;

            $benar = $soal->jawaban_benar === $jawabanSiswa;
            $benar ? $soalBenar++ : $soalSalah++;

            $detailJawaban[] = [
                'soal_id'       => $soalId,
                'pertanyaan'    => $soal->pertanyaan,
                'jawaban_siswa' => $jawabanSiswa,
                'jawaban_benar' => $soal->jawaban_benar,
                'benar'         => $benar,
                'pembahasan'    => $soal->pembahasan,
            ];
        }

        $totalSoal = count($jawaban);
        $nilai     = $totalSoal > 0 ? round(($soalBenar / $totalSoal) * 100) : 0;
        $durasi    = $request->input('durasi_menit', 0);
        $hasilId   = (string) Str::uuid();

        HasilKuis::insert([
            'id'           => $hasilId,
            'user_id'      => $user->id,
            'materi_id'    => $materi_id,
            'nilai'        => $nilai,
            'soal_benar'   => $soalBenar,
            'soal_salah'   => $soalSalah,
            'total_soal'   => $totalSoal,
            'durasi_menit' => $durasi,
            'tipe'         => $request->input('tipe', 'latihan'),
            'jawaban'      => json_encode($detailJawaban),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        HasilLatihan::create([
            'user_id'        => $user->id,
            'mata_pelajaran' => $materi->mata_pelajaran,
            'nilai'          => $nilai,
            'jumlah_soal'    => $totalSoal,
            'soal_benar'     => $soalBenar,
            'durasi_menit'   => $durasi,
        ]);

        AktivitasBelajar::create([
            'user_id'        => $user->id,
            'tanggal'        => now()->toDateString(),
            'durasi_menit'   => $durasi,
            'mata_pelajaran' => $materi->mata_pelajaran,
        ]);

        $hasilModel = HasilKuis::with('materi')->find($hasilId);
        app(NotifikasiService::class)->nilaiKuis($hasilModel);

        return redirect("/siswa/belajar-tka/{$materi_id}/hasil/{$hasilId}");
    });

    Route::get('/belajar-tka/{materi_id}/hasil/{hasil_id}', function ($materi_id, $hasil_id) {
        return view('siswa.hasil-kuis', [
            'materi' => Materi::findOrFail($materi_id),
            'hasil'  => HasilKuis::findOrFail($hasil_id),
        ]);
    });

    // ── Les Privat ─────────────────────────────────────────────────────────
    Route::get('/les-privat', function () {
        $pakets = Paket::orderByRaw("FIELD(tipe,'sd','smp','sma')")
            ->orderBy('harga_min', 'asc')
            ->get()
            ->groupBy('tipe');

        $tutors = User::where('role', 'tutor')->get();

        $pesananAktif = LesPrivat::where('user_id', auth()->id())
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->with('tutor')
            ->latest()
            ->get();

        $riwayat = LesPrivat::where('user_id', auth()->id())
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->with(['tutor', 'ulasan'])
            ->latest()
            ->get();

        return view('siswa.les-privat', compact('pakets', 'tutors', 'pesananAktif', 'riwayat'));
    });

    Route::post('/les-privat/pesan', function (Request $request) {
        $request->validate([
            'tutor_id'       => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'topik'          => 'nullable|string|max:255',
            'catatan'        => 'nullable|string',
            'jadwal'         => 'required|date|after:now',
            'durasi_menit'   => 'required|in:60,75,90,120',
            'mode'           => 'required|in:online,tatap_muka',
            'lokasi'         => 'nullable|string',
        ]);

        $bentrok = LesPrivat::where('tutor_id', $request->tutor_id)
            ->where('status', 'dikonfirmasi')
            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, jadwal, ?)) < durasi_menit', [$request->jadwal])
            ->exists();

        if ($bentrok) {
            return back()
                ->withErrors(['jadwal' => 'Tutor sudah memiliki sesi di waktu tersebut.'])
                ->withInput();
        }

        // Ambil harga dari paket jika ada, fallback ke durasi
        $harga = 75000;
        if ($request->filled('paket_id')) {
            $paket = Paket::find($request->paket_id);
            if ($paket) $harga = $paket->harga_min;
        } else {
            $harga = match ((int) $request->durasi_menit) {
                60      => 50000,
                75      => 60000,
                90      => 75000,
                120     => 100000,
                default => 75000,
            };
        }

        LesPrivat::create([
            'user_id'        => auth()->id(),
            'tutor_id'       => $request->tutor_id,
            'paket_id'       => $request->paket_id ?? null,
            'mata_pelajaran' => $request->mata_pelajaran,
            'topik'          => $request->topik,
            'catatan'        => $request->catatan,
            'jadwal'         => $request->jadwal,
            'durasi_menit'   => $request->durasi_menit,
            'status'         => 'menunggu',
            'mode'           => $request->mode,
            'lokasi'         => $request->mode === 'tatap_muka' ? $request->lokasi : null,
            'harga'          => $harga,
        ]);

        notifAdmin(
            '📅 Pesanan Les Privat Baru',
            '<strong>' . auth()->user()->name . '</strong> memesan les privat <strong>' . $request->mata_pelajaran . '</strong>. Menunggu konfirmasi tutor.',
            'les_privat',
            [
                'ikon'  => 'bi bi-person-video3',
                'warna' => 'var(--success-soft)',
                'url'   => '/admin/pembayaran',
                'label' => 'Lihat',
            ]
        );

        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id'    => auth()->id(),
            'judul'      => '📅 Pesanan Les Privat Terkirim',
            'pesan'      => 'Pesanan les privat <strong>' . $request->mata_pelajaran . '</strong> berhasil dikirim. Menunggu konfirmasi tutor.',
            'tipe'       => 'les_privat',
            'ikon'       => 'bi bi-person-video3',
            'warna'      => 'var(--success-soft)',
            'url_aksi'   => '/siswa/les-privat',
            'label_aksi' => 'Lihat Pesanan',
        ]);

        // Notifikasi ke tutor
        Notifikasi::create([
            'user_id'    => $request->tutor_id,
            'judul'      => '📅 Pesanan Les Privat Baru',
            'pesan'      => '<strong>' . auth()->user()->name . '</strong> memesan les privat <strong>' . $request->mata_pelajaran . '</strong>.',
            'tipe'       => 'les_privat',
            'ikon'       => 'bi bi-person-video3',
            'warna'      => 'var(--success-soft)',
            'url_aksi'   => '/tutor/les-privat',
            'label_aksi' => 'Konfirmasi',
        ]);

        return redirect('/siswa/les-privat')
            ->with('sukses', 'Pesanan les berhasil dikirim! Tunggu konfirmasi dari tutor.');
    });

    Route::post('/les-privat/{id}/batalkan', function ($id) {
        LesPrivat::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail()
            ->update(['status' => 'dibatalkan']);

        return redirect('/siswa/les-privat')
            ->with('sukses', 'Pesanan berhasil dibatalkan.');
    });

    Route::get('/les-privat/{id}', function ($id) {
        return response()->json(
            LesPrivat::where('id', $id)->where('user_id', auth()->id())->with('tutor')->firstOrFail()
        );
    });

    // ── Ulasan ─────────────────────────────────────────────────────────────
    Route::post('/ulasan', function (Request $request) {
        $request->validate([
            'les_privat_id' => 'required|exists:les_privat,id',
            'bintang'       => 'required|integer|min:1|max:5',
            'komentar'      => 'nullable|string|max:500',
        ]);

        $les = LesPrivat::where('id', $request->les_privat_id)
            ->where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->firstOrFail();

        if ($les->ulasan) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk sesi ini.');
        }

        Ulasan::create([
            'les_privat_id' => $les->id,
            'siswa_id'      => auth()->id(),
            'tutor_id'      => $les->tutor_id,
            'bintang'       => $request->bintang,
            'komentar'      => $request->komentar,
        ]);

        Notifikasi::create([
            'user_id'    => $les->tutor_id,
            'judul'      => '⭐ Ulasan Baru dari Siswa',
            'pesan'      => '<strong>' . auth()->user()->name . '</strong> memberikan ulasan <strong>' . $request->bintang . ' bintang</strong> untuk sesi <strong>' . $les->mata_pelajaran . '</strong>.',
            'tipe'       => 'sistem',
            'ikon'       => 'bi bi-star-fill',
            'warna'      => 'var(--accent-soft)',
            'url_aksi'   => '/tutor/profil',
            'label_aksi' => 'Lihat Profil',
        ]);

        return back()->with('sukses', 'Ulasan berhasil dikirim! Terima kasih.');
    });

    // ── Hasil & Progres ────────────────────────────────────────────────────
    Route::get('/hasil-progres', function () {
        $user   = auth()->user();
        $userId = $user->id;
        $now    = now();

        $rataRataNilai  = round(HasilKuis::where('user_id', $userId)->avg('nilai') ?? 0);
        $latihanSelesai = HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->count();
        $kuisDikerjakan = HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->count();
        $jamBelajar     = round(AktivitasBelajar::where('user_id', $userId)->sum('durasi_menit') / 60, 1);

        $rataRataBulanLalu = round(HasilKuis::where('user_id', $userId)->whereMonth('created_at', $now->copy()->subMonth()->month)->avg('nilai') ?? 0);
        $selisihNilai      = $rataRataNilai - $rataRataBulanLalu;
        $latihanMingguIni  = HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])->count();
        $kuisBulanLalu     = HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->whereMonth('created_at', $now->copy()->subMonth()->month)->count();
        $selisihKuis       = $kuisDikerjakan - $kuisBulanLalu;
        $jamBulanIni       = round(AktivitasBelajar::where('user_id', $userId)->whereMonth('tanggal', $now->month)->sum('durasi_menit') / 60, 1);

        $hariLabel         = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $aktivitasMingguan = [];

        for ($i = 6; $i >= 0; $i--) {
            $tgl     = $now->copy()->subDays($i)->toDateString();
            $hari    = $hariLabel[$now->copy()->subDays($i)->dayOfWeek];
            $latihan = HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->whereDate('created_at', $tgl)->count();
            $kuis    = HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->whereDate('created_at', $tgl)->count();

            $aktivitasMingguan[] = [
                'hari'    => $hari,
                'latihan' => $latihan,
                'kuis'    => $kuis,
                'total'   => $latihan + $kuis,
            ];
        }

        $totalAktivitasMinggu = array_sum(array_column($aktivitasMingguan, 'total'));
        $rataHari             = $totalAktivitasMinggu > 0 ? round($totalAktivitasMinggu / 7, 1) : 0;

        $semuaNilai = HasilKuis::where('user_id', $userId)->pluck('nilai');
        $totalHasil = $semuaNilai->count();
        $distribusi = [
            'A' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n >= 87)->count() / $totalHasil * 100) : 0,
            'B' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n >= 70 && $n < 87)->count() / $totalHasil * 100) : 0,
            'C' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n >= 55 && $n < 70)->count() / $totalHasil * 100) : 0,
            'D' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n < 55)->count() / $totalHasil * 100) : 0,
        ];

        $semuaMapel   = HasilKuis::where('user_id', $userId)->with('materi')->get()->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya');
        $progresMapel = [];

        foreach ($semuaMapel as $mapel => $hasilList) {
            $rata = round($hasilList->avg('nilai'));
            $progresMapel[$mapel] = [
                'nama'       => $mapel,
                'rata'       => $rata,
                'pct'        => min($rata, 100),
                'totalSoal'  => $hasilList->sum('total_soal'),
                'totalBenar' => $hasilList->sum('soal_benar'),
            ];
        }

        $riwayatNilai   = HasilKuis::where('user_id', $userId)->with('materi')->orderBy('created_at', 'desc')->paginate(6);
        $nilaiTertinggi = HasilKuis::where('user_id', $userId)->max('nilai') ?? 0;
        $nilaiTerendah  = HasilKuis::where('user_id', $userId)->min('nilai') ?? 0;
        $tren6Terakhir  = HasilKuis::where('user_id', $userId)->orderBy('created_at', 'desc')->take(6)->pluck('nilai')->reverse()->values();

        $trenJam = [];

        for ($i = 7; $i >= 0; $i--) {
            $start = $now->copy()->subWeeks($i)->startOfWeek();
            $end   = $now->copy()->subWeeks($i)->endOfWeek();
            $menit = AktivitasBelajar::where('user_id', $userId)->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])->sum('durasi_menit');

            $trenJam[] = [
                'label' => 'W' . (8 - $i),
                'jam'   => round($menit / 60, 1),
                'menit' => $menit,
            ];
        }

        $maxJam = max(array_column($trenJam, 'menit')) ?: 1;

        $kemampuanTopik = HasilKuis::where('user_id', $userId)->with('materi')->get()
            ->groupBy(fn($h) => $h->materi->topik ?? $h->materi->mata_pelajaran ?? 'Umum')
            ->map(fn($list) => round($list->avg('nilai')))
            ->sortDesc()
            ->take(8);

        $rekomendasiMapel = collect($progresMapel)->sortBy('rata')->first();

        return view('siswa.hasil-progres', compact(
            'rataRataNilai',
            'latihanSelesai',
            'kuisDikerjakan',
            'jamBelajar',
            'selisihNilai',
            'latihanMingguIni',
            'selisihKuis',
            'jamBulanIni',
            'aktivitasMingguan',
            'totalAktivitasMinggu',
            'rataHari',
            'distribusi',
            'progresMapel',
            'riwayatNilai',
            'nilaiTertinggi',
            'nilaiTerendah',
            'tren6Terakhir',
            'trenJam',
            'maxJam',
            'kemampuanTopik',
            'rekomendasiMapel',
            'totalHasil'
        ));
    });

    Route::get('/hasil-progres/export-excel', function (Request $request) {
        $periode  = $request->query('periode', 'bulan_ini');
        $labelMap = [
            'bulan_ini' => now()->format('M-Y'),
            '3_bulan'   => '3-Bulan-' . now()->format('M-Y'),
            '6_bulan'   => '6-Bulan-' . now()->format('M-Y'),
            'semua'     => 'Semua',
        ];

        return Excel::download(
            new HasilBelajarExport(auth()->id(), $periode),
            'laporan-hasil-belajar-' . ($labelMap[$periode] ?? now()->format('M-Y')) . '.xlsx'
        );
    });

    Route::get('/hasil-progres/export-pdf', function (Request $request) {
        $user    = auth()->user();
        $periode = $request->query('periode', 'bulan_ini');
        $endDate = now();

        [$startDate, $labelPeriode] = match ($periode) {
            '3_bulan' => [now()->subMonths(3)->startOfDay(), '3 Bulan Terakhir'],
            '6_bulan' => [now()->subMonths(6)->startOfDay(), '6 Bulan Terakhir'],
            'semua'   => [null, 'Semua Waktu'],
            default   => [now()->startOfMonth(), 'Bulan ' . now()->translatedFormat('F Y')],
        };

        $query = HasilKuis::where('user_id', $user->id)->with('materi')->orderBy('created_at', 'desc');
        if ($startDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $hasilKuis = $query->get();

        $perMapel = $hasilKuis->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn($list, $mapel) => [
                'nama'       => $mapel,
                'total'      => $list->count(),
                'rata'       => round($list->avg('nilai')),
                'tertinggi'  => $list->max('nilai'),
                'terendah'   => $list->min('nilai'),
                'totalSoal'  => $list->sum('total_soal'),
                'totalBenar' => $list->sum('soal_benar'),
            ]);

        $labelFileMap = [
            'bulan_ini' => now()->format('M-Y'),
            '3_bulan'   => '3-Bulan-' . now()->format('M-Y'),
            '6_bulan'   => '6-Bulan-' . now()->format('M-Y'),
            'semua'     => 'Semua',
        ];

        $pdf = Pdf::loadView('siswa.laporan-pdf', [
            'user'         => $user,
            'hasilKuis'    => $hasilKuis,
            'perMapel'     => $perMapel,
            'labelPeriode' => $labelPeriode,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-hasil-belajar-' . ($labelFileMap[$periode] ?? now()->format('M-Y')) . '.pdf');
    });

    // ── Notifikasi ─────────────────────────────────────────────────────────
    Route::get('/notifikasi', function () {
        $user = auth()->user();

        // Ambil SEMUA notifikasi milik user
        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->filter(function ($n) use ($user) {
                return match ($n->tipe) {
                    'pembayaran' => (bool) ($user->notif_pembayaran ?? true),
                    'les_privat' => (bool) ($user->notif_pengingat_sesi ?? true),
                    'belajar'    => (bool) ($user->notif_ulasan ?? true),
                    'sistem'     => (bool) ($user->notif_permintaan_jadwal ?? true),
                    default      => true,
                };
            });

        // Tipe aktif hanya untuk menampilkan tab filter
        $tipeAktif = $notifikasi->pluck('tipe')->unique()->values()->toArray();

        return view('siswa.notifikasi', [
            'user'              => $user,
            'jumlahBelumDibaca' => $notifikasi->where('sudah_dibaca', false)->count(),
            'tipeAktif'         => $tipeAktif,
            'hariIni'           => $notifikasi->filter(fn($n) => $n->created_at->isToday()),
            'kemarin'           => $notifikasi->filter(fn($n) => $n->created_at->isYesterday()),
            'mingguIni'         => $notifikasi->filter(
                fn($n) =>
                !$n->created_at->isToday() &&
                    !$n->created_at->isYesterday() &&
                    $n->created_at->diffInDays(now()) <= 7
            ),
            'lebihLama'         => $notifikasi->filter(
                fn($n) =>
                $n->created_at->diffInDays(now()) > 7
            ),
        ]);
    });

    Route::post('/notifikasi/tandai-semua', function () {
        Notifikasi::where('user_id', auth()->id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return back();
    });

    Route::post('/notifikasi/{id}/buka', function ($id) {
        $notif = Notifikasi::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $notif->update(['sudah_dibaca' => true]);

        return redirect($notif->url_aksi ?? '/siswa/notifikasi');
    });

    // ── Profil ─────────────────────────────────────────────────────────────
    Route::get('/profil', function () {
        $user = auth()->user();

        $rataRataNilai  = round(\App\Models\HasilKuis::where('user_id', $user->id)->avg('nilai') ?? 0);
        $soalSelesai    = \App\Models\HasilKuis::where('user_id', $user->id)->sum('total_soal');
        $sesiLes        = \App\Models\LesPrivat::where('user_id', $user->id)->where('status', 'selesai')->count();
        $aktivitasMinggu = \App\Models\AktivitasBelajar::where('user_id', $user->id)
            ->where('tanggal', '>=', now()->subDays(7))
            ->distinct('tanggal')
            ->count('tanggal');

        $achievements = [
            ['🎯', 'Pemula Aktif',   'Selesaikan 10 soal',         $soalSelesai >= 10],
            ['📚', 'Rajin Belajar',  'Belajar 7 hari berturut',    $aktivitasMinggu >= 7],
            ['⭐', 'Nilai Sempurna', 'Raih nilai 100',             \App\Models\HasilKuis::where('user_id', $user->id)->where('nilai', 100)->exists()],
            ['🎓', 'Les Pertama',    'Selesaikan 1 sesi les',      $sesiLes >= 1],
            ['🔥', 'Streak Master',  'Streak 30 hari',             $aktivitasMinggu >= 30],
            ['🏆', 'Juara Kelas',    'Nilai rata-rata di atas 90', $rataRataNilai >= 90],
        ];

        $badgeTerbuka  = collect($achievements)->where(3, true)->count();
        $badgeTerkunci = collect($achievements)->where(3, false)->count();

        $paketLesPrivat = \App\Models\Paket::orderByRaw("FIELD(tipe,'sd','smp','sma')")
            ->orderBy('harga_min', 'asc')
            ->get()
            ->groupBy('tipe')
            ->map(fn($group) => $group->first())
            ->values();

        $riwayatLes = \App\Models\LesPrivat::where('user_id', $user->id)
            ->with('tutor')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.profil', compact(
            'user',
            'rataRataNilai',
            'soalSelesai',
            'sesiLes',
            'aktivitasMinggu',
            'achievements',
            'badgeTerbuka',
            'badgeTerkunci',
            'paketLesPrivat',
            'riwayatLes',
        ));
    });

    Route::post('/profil/update-info', function (Request $request) {
        $request->validate([
            'name'           => 'required|string|max:100',
            'no_hp'          => 'nullable|string|max:20',
            'tanggal_lahir'  => 'nullable|date',
            'jenjang'        => 'nullable|in:sd,smp,sma',
            'kelas'          => 'nullable|string|max:20',
            'kota'           => 'nullable|string|max:100',
            'provinsi'       => 'nullable|string|max:100',
            'tujuan_belajar' => 'nullable|string|max:255',
            'bio'            => 'nullable|string|max:500',
        ]);

        auth()->user()->update($request->only([
            'name',
            'no_hp',
            'tanggal_lahir',
            'jenjang',
            'kelas',
            'kota',
            'provinsi',
            'tujuan_belajar',
            'bio',
        ]));

        return redirect('/siswa/profil')->with('sukses_info', 'Informasi pribadi berhasil diperbarui!');
    });

    Route::post('/profil/upload-avatar', function (Request $request) {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $request->file('avatar')->store('avatars', 'public')]);

        return redirect('/siswa/profil')->with('sukses_info', 'Foto profil berhasil diperbarui!');
    });

    Route::post('/profil/ganti-password', function (Request $request) {
        $user = auth()->user();

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        if (! Hash::check($request->password_lama, $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password saat ini salah!'])
                ->with('tab', 'keamanan');
        }

        $user->update(['password' => Hash::make($request->password_baru)]);

        return redirect('/siswa/profil')
            ->with('sukses_password', 'Password berhasil diubah!')
            ->with('tab', 'keamanan');
    });

    Route::post('/profil/simpan-notifikasi', function (Request $request) {
        auth()->user()->update([
            'notif_pembayaran'        => $request->boolean('notif_pembayaran'),
            'notif_pengingat_sesi'    => $request->boolean('notif_pengingat_sesi'),
            'notif_ulasan'            => $request->boolean('notif_ulasan'),
            'notif_permintaan_jadwal' => $request->boolean('notif_permintaan_jadwal'),
            'notif_newsletter'        => $request->boolean('notif_newsletter'),
        ]);

        return redirect('/siswa/profil')
            ->with('sukses_info', 'Pengaturan notifikasi berhasil disimpan!')
            ->with('tab', 'keamanan');
    });

    Route::delete('/profil/hapus-akun', function () {
        $user = auth()->user();

        // Hapus avatar jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Logout dulu
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Hapus user (cascade delete data terkait tergantung foreign key)
        $user->delete();

        return redirect('/login')->with('sukses', 'Akun berhasil dihapus.');
    });

    // ── Pesan Jadwal ───────────────────────────────────────────────────────
    Route::get('/pesan-jadwal', function () {
        return view('siswa.pesan-jadwal', [
            'tutors'       => User::where('role', 'tutor')->get(),
            'paketDipilih' => session('paket_dipilih'),
        ]);
    });

    Route::post('/pesan-jadwal', function (Request $request) {
        $request->validate([
            'tutor_id'       => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'jadwal'         => 'required|date',
            'mode'           => 'required|in:online,tatap_muka',
        ]);

        LesPrivat::create([
            'user_id'        => auth()->id(),
            'tutor_id'       => $request->tutor_id,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jadwal'         => $request->jadwal,
            'status'         => 'menunggu',
            'mode'           => $request->mode,
        ]);

        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id'    => auth()->id(),
            'judul'      => '📅 Pesanan Les Privat Terkirim',
            'pesan'      => 'Pesanan les privat <strong>' . $request->mata_pelajaran . '</strong> berhasil dikirim. Menunggu konfirmasi tutor.',
            'tipe'       => 'les_privat',
            'ikon'       => 'bi bi-person-video3',
            'warna'      => 'var(--success-soft)',
            'url_aksi'   => '/siswa/les-privat',
            'label_aksi' => 'Lihat Pesanan',
        ]);

        // Notifikasi ke tutor
        Notifikasi::create([
            'user_id'    => $request->tutor_id,
            'judul'      => '📅 Pesanan Les Privat Baru',
            'pesan'      => '<strong>' . auth()->user()->name . '</strong> memesan les privat <strong>' . $request->mata_pelajaran . '</strong>.',
            'tipe'       => 'les_privat',
            'ikon'       => 'bi bi-person-video3',
            'warna'      => 'var(--success-soft)',
            'url_aksi'   => '/tutor/les-privat',
            'label_aksi' => 'Konfirmasi',
        ]);

        return redirect('/siswa/les-privat')->with('sukses', 'Jadwal les berhasil dipesan!');
    });

    Route::post('/pilih-paket/{tipe}', function ($tipe) {
        session(['paket_dipilih' => Paket::where('tipe', $tipe)->firstOrFail()]);
        return redirect('/siswa/pesan-jadwal');
    });

    // ── Pembayaran ─────────────────────────────────────────────────────────
    Route::get('/pembayaran', function () {
        $user = auth()->user();

        $tagihan = LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->whereIn('pembayaran_status', ['belum', 'menunggu'])
            ->with(['tutor', 'pembayaranTerakhir'])
            ->orderBy('jadwal', 'asc')
            ->paginate(4);

        $riwayat = Pembayaran::where('siswa_id', $user->id)
            ->with(['lesPrivat.tutor'])
            ->orderBy('created_at', 'desc')
            ->get();

        $rekening = RekeningBank::where('aktif', true)->get();

        $totalTagihan = LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->whereIn('pembayaran_status', ['belum', 'menunggu'])
            ->sum('harga');

        $totalBelumBayar = LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->where('pembayaran_status', 'belum')
            ->count();

        $totalTransaksi = $riwayat->count();

        $jatuhTempoTerdekat = LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->whereIn('pembayaran_status', ['belum', 'menunggu'])
            ->orderBy('jadwal', 'asc')
            ->first()?->jadwal?->format('d M Y');

        $totalTerbayar = $riwayat->where('status', 'dikonfirmasi')->sum('jumlah');
        $totalDitolak  = $riwayat->where('status', 'ditolak')->count();

        return view('siswa.pembayaran', compact(
            'tagihan',
            'riwayat',
            'rekening',
            'totalTagihan',
            'totalBelumBayar',
            'totalTransaksi',
            'jatuhTempoTerdekat',
            'totalTerbayar',
            'totalDitolak'
        ));
    });

    Route::post('/pembayaran/{les_id}/upload-bukti', function (Request $request, $les_id) {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'bank_tujuan'    => 'required|string',
            'nomor_rekening' => 'required|string',
        ]);

        $les = LesPrivat::where('id', $les_id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->whereIn('pembayaran_status', ['belum', 'menunggu'])
            ->firstOrFail();

        $path = $request->file('bukti_transfer')->store('bukti-pembayaran', 'public');

        Pembayaran::create([
            'les_privat_id'         => $les->id,
            'siswa_id'              => auth()->id(),
            'tutor_id'              => $les->tutor_id,
            'nomor_invoice'         => Pembayaran::generateInvoice(),
            'jumlah'                => $les->harga,
            'bank_tujuan'           => $request->bank_tujuan,
            'nomor_rekening_tujuan' => $request->nomor_rekening,
            'bukti_transfer'        => $path,
            'status'                => 'menunggu',
        ]);

        $les->update(['pembayaran_status' => 'menunggu']);

        notifAdmin(
            '💳 Bukti Pembayaran Masuk',
            '<strong>' . auth()->user()->name . '</strong> mengupload bukti transfer untuk les privat <strong>' . $les->mata_pelajaran . '</strong>.',
            'pembayaran',
            [
                'ikon'  => 'bi bi-credit-card-fill',
                'warna' => 'var(--accent-soft)',
                'url'   => '/admin/pembayaran',
                'label' => 'Verifikasi',
            ]
        );

        Notifikasi::create([
            'user_id'    => auth()->id(),
            'judul'      => '💳 Bukti Pembayaran Terkirim',
            'pesan'      => 'Bukti transfer berhasil dikirim. Menunggu verifikasi dari admin.',
            'tipe'       => 'pembayaran',
            'ikon'       => 'bi bi-credit-card-fill',
            'warna'      => 'var(--accent-soft)',
            'url_aksi'   => '/siswa/pembayaran',
            'label_aksi' => 'Lihat Pembayaran',
        ]);

        // Notifikasi ke tutor
        Notifikasi::create([
            'user_id'    => $les->tutor_id,
            'judul'      => '💳 Bukti Pembayaran Diterima',
            'pesan'      => '<strong>' . auth()->user()->name . '</strong> mengupload bukti transfer untuk les privat <strong>' . $les->mata_pelajaran . '</strong>.',
            'tipe'       => 'pembayaran',
            'ikon'       => 'bi bi-credit-card-fill',
            'warna'      => 'var(--accent-soft)',
            'url_aksi'   => '/tutor/pembayaran',
            'label_aksi' => 'Verifikasi',
        ]);

        return response()->json(['sukses' => true]);
    });
});
