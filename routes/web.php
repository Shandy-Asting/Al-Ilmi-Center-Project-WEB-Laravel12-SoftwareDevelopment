<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('landing.index');
});

// ── AUTH (Livewire) ──
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
Route::post('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// ── SISWA ──
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $rataRataNilai = round(\App\Models\HasilLatihan::where('user_id', $user->id)->avg('nilai') ?? 0);
        $soalDiselesaikan = \App\Models\HasilLatihan::where('user_id', $user->id)->sum('soal_benar') ?? 0;
        $jamBelajar = round(\App\Models\AktivitasBelajar::where('user_id', $user->id)->sum('durasi_menit') / 60, 1) ?? 0;
        $lesPrivat = \App\Models\LesPrivat::where('user_id', $user->id)->whereMonth('created_at', now()->month)->count() ?? 0;

        return view('siswa.dashboard', [
            'namaUser'        => $user->name,
            'rataRataNilai'   => $rataRataNilai,
            'soalDiselesaikan' => $soalDiselesaikan,
            'jamBelajar'      => $jamBelajar,
            'lesPrivat'       => $lesPrivat,
        ]);
    });

    Route::get('/belajar-tka', function () {
        $materi = \App\Models\Materi::where('status', 'aktif')
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
        $user = auth()->user();
        $materi = \App\Models\Materi::with('soal')->findOrFail($materi_id);
        $soal = $materi->soal()->inRandomOrder()->take(15)->get();
        $hasilSebelumnya = \App\Models\HasilKuis::where('user_id', $user->id)
            ->where('materi_id', $materi_id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('siswa.latihan-soal', [
            'materi'          => $materi,
            'soal'            => $soal,
            'hasilSebelumnya' => $hasilSebelumnya,
        ]);
    });

    // Submit jawaban ── notifikasi nilai kuis
    Route::post('/belajar-tka/{materi_id}/submit', function (\Illuminate\Http\Request $request, $materi_id) {
        $user = auth()->user();
        $materi = \App\Models\Materi::with('soal')->findOrFail($materi_id);
        $soalList = $materi->soal()->get()->keyBy('id');

        $jawaban = $request->input('jawaban', []);
        $soalBenar = 0;
        $soalSalah = 0;
        $detailJawaban = [];

        foreach ($jawaban as $soalId => $jawabanSiswa) {
            $soal = $soalList->get($soalId);
            if (!$soal) continue;

            $benar = $soal->jawaban_benar === $jawabanSiswa;
            if ($benar) $soalBenar++;
            else $soalSalah++;

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
        $hasilId   = (string) \Illuminate\Support\Str::uuid();

        \App\Models\HasilKuis::insert([
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

        \App\Models\HasilLatihan::create([
            'user_id'        => $user->id,
            'mata_pelajaran' => $materi->mata_pelajaran,
            'nilai'          => $nilai,
            'jumlah_soal'    => $totalSoal,
            'soal_benar'     => $soalBenar,
            'durasi_menit'   => $durasi,
        ]);

        \App\Models\AktivitasBelajar::create([
            'user_id'        => $user->id,
            'tanggal'        => now()->toDateString(),
            'durasi_menit'   => $durasi,
            'mata_pelajaran' => $materi->mata_pelajaran,
        ]);

        // ✅ Notifikasi nilai kuis
        $hasilModel = \App\Models\HasilKuis::with('materi')->find($hasilId);
        app(\App\Services\NotifikasiService::class)->nilaiKuis($hasilModel);

        return redirect('/siswa/belajar-tka/' . $materi_id . '/hasil/' . $hasilId);
    });

    Route::get('/belajar-tka/{materi_id}/hasil/{hasil_id}', function ($materi_id, $hasil_id) {
        $materi = \App\Models\Materi::findOrFail($materi_id);
        $hasil  = \App\Models\HasilKuis::findOrFail($hasil_id);
        return view('siswa.hasil-kuis', [
            'materi' => $materi,
            'hasil'  => $hasil,
        ]);
    });

    // ── LES PRIVAT SISWA ──
    Route::get('/les-privat', function () {
        $user = auth()->user();

        $pesananAktif = \App\Models\LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->with('tutor')
            ->orderBy('jadwal', 'asc')
            ->get();

        $riwayat = \App\Models\LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->with('tutor')
            ->orderBy('jadwal', 'desc')
            ->take(10)
            ->get();

        $tutors = \App\Models\User::where('role', 'tutor')->get();

        return view('siswa.les-privat', [
            'pesananAktif' => $pesananAktif,
            'riwayat'      => $riwayat,
            'tutors'       => $tutors,
        ]);
    });

    Route::post('/les-privat/pesan', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'tutor_id'       => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'topik'          => 'nullable|string|max:255',
            'catatan'        => 'nullable|string',
            'jadwal'         => 'required|date|after:now',
            'durasi_menit'   => 'required|in:60,90,120',
            'mode'           => 'required|in:online,tatap_muka',
            'lokasi'         => 'nullable|string',
        ]);

        $bentrok = \App\Models\LesPrivat::where('tutor_id', $request->tutor_id)
            ->where('status', 'dikonfirmasi')
            ->whereRaw("ABS(TIMESTAMPDIFF(MINUTE, jadwal, ?)) < durasi_menit", [$request->jadwal])
            ->exists();

        if ($bentrok) {
            return back()->withErrors(['jadwal' => 'Tutor sudah memiliki sesi di waktu tersebut.'])->withInput();
        }

        $harga = match ((int)$request->durasi_menit) {
            60  => 50000,
            90  => 75000,
            120 => 100000,
            default => 75000,
        };

        \App\Models\LesPrivat::create([
            'user_id'        => auth()->id(),
            'tutor_id'       => $request->tutor_id,
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

        return redirect('/siswa/les-privat')
            ->with('sukses', 'Pesanan les berhasil dikirim! Tunggu konfirmasi dari tutor.');
    });

    Route::post('/les-privat/{id}/batalkan', function ($id) {
        $les = \App\Models\LesPrivat::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $les->update(['status' => 'dibatalkan']);

        return redirect('/siswa/les-privat')
            ->with('sukses', 'Pesanan berhasil dibatalkan.');
    });

    Route::get('/les-privat/{id}', function ($id) {
        $les = \App\Models\LesPrivat::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('tutor')
            ->firstOrFail();

        return response()->json($les);
    });

    Route::get('/hasil-progres/export-excel', function (\Illuminate\Http\Request $request) {
        $user    = auth()->user();
        $periode = $request->query('periode', 'bulan_ini');
        $labelMap = [
            'bulan_ini' => now()->format('M-Y'),
            '3_bulan'   => '3-Bulan-' . now()->format('M-Y'),
            '6_bulan'   => '6-Bulan-' . now()->format('M-Y'),
            'semua'     => 'Semua',
        ];
        return Excel::download(
            new \App\Exports\HasilBelajarExport($user->id, $periode),
            'laporan-hasil-belajar-' . ($labelMap[$periode] ?? now()->format('M-Y')) . '.xlsx'
        );
    });

    Route::get('/hasil-progres/export-pdf', function (\Illuminate\Http\Request $request) {
        $user    = auth()->user();
        $periode = $request->query('periode', 'bulan_ini');
        $endDate = now();
        switch ($periode) {
            case '3_bulan':
                $startDate = now()->subMonths(3)->startOfDay();
                $labelPeriode = '3 Bulan Terakhir';
                break;
            case '6_bulan':
                $startDate = now()->subMonths(6)->startOfDay();
                $labelPeriode = '6 Bulan Terakhir';
                break;
            case 'semua':
                $startDate = null;
                $labelPeriode = 'Semua Waktu';
                break;
            default:
                $startDate = now()->startOfMonth();
                $labelPeriode = 'Bulan ' . now()->translatedFormat('F Y');
                break;
        }

        $query = \App\Models\HasilKuis::where('user_id', $user->id)->with('materi')->orderBy('created_at', 'desc');
        if ($startDate) $query->whereBetween('created_at', [$startDate, $endDate]);
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

        $labelFileMap = ['bulan_ini' => now()->format('M-Y'), '3_bulan' => '3-Bulan-' . now()->format('M-Y'), '6_bulan' => '6-Bulan-' . now()->format('M-Y'), 'semua' => 'Semua'];

        $pdf = Pdf::loadView('siswa.laporan-pdf', [
            'user'         => $user,
            'hasilKuis'    => $hasilKuis,
            'perMapel'     => $perMapel,
            'labelPeriode' => $labelPeriode,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-hasil-belajar-' . ($labelFileMap[$periode] ?? now()->format('M-Y')) . '.pdf');
    });

    Route::get('/hasil-progres', function () {
        $user    = auth()->user();
        $userId  = $user->id;
        $now     = now();

        $rataRataNilai     = round(\App\Models\HasilKuis::where('user_id', $userId)->avg('nilai') ?? 0);
        $latihanSelesai    = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->count();
        $kuisDikerjakan    = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->count();
        $totalMenit        = \App\Models\AktivitasBelajar::where('user_id', $userId)->sum('durasi_menit');
        $jamBelajar        = round($totalMenit / 60, 1);
        $rataRataBulanLalu = round(\App\Models\HasilKuis::where('user_id', $userId)->whereMonth('created_at', $now->copy()->subMonth()->month)->avg('nilai') ?? 0);
        $selisihNilai      = $rataRataNilai - $rataRataBulanLalu;
        $latihanMingguIni  = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])->count();
        $kuisBulanLalu     = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->whereMonth('created_at', $now->copy()->subMonth()->month)->count();
        $selisihKuis       = $kuisDikerjakan - $kuisBulanLalu;
        $jamBulanIni       = round(\App\Models\AktivitasBelajar::where('user_id', $userId)->whereMonth('tanggal', $now->month)->sum('durasi_menit') / 60, 1);

        $aktivitasMingguan = [];
        $hariLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        for ($i = 6; $i >= 0; $i--) {
            $tgl     = $now->copy()->subDays($i)->toDateString();
            $hari    = $hariLabel[$now->copy()->subDays($i)->dayOfWeek];
            $latihan = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->whereDate('created_at', $tgl)->count();
            $kuis    = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->whereDate('created_at', $tgl)->count();
            $aktivitasMingguan[] = ['hari' => $hari, 'latihan' => $latihan, 'kuis' => $kuis, 'total' => $latihan + $kuis];
        }
        $totalAktivitasMinggu = array_sum(array_column($aktivitasMingguan, 'total'));
        $rataHari = $totalAktivitasMinggu > 0 ? round($totalAktivitasMinggu / 7, 1) : 0;

        $semuaNilai = \App\Models\HasilKuis::where('user_id', $userId)->pluck('nilai');
        $totalHasil = $semuaNilai->count();
        $distribusi = [
            'A' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n >= 87)->count() / $totalHasil * 100) : 0,
            'B' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n >= 70 && $n < 87)->count() / $totalHasil * 100) : 0,
            'C' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n >= 55 && $n < 70)->count() / $totalHasil * 100) : 0,
            'D' => $totalHasil > 0 ? round($semuaNilai->filter(fn($n) => $n < 55)->count() / $totalHasil * 100) : 0,
        ];

        $semuaMapel   = \App\Models\HasilKuis::where('user_id', $userId)->with('materi')->get()->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya');
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

        $riwayatNilai   = \App\Models\HasilKuis::where('user_id', $userId)->with('materi')->orderBy('created_at', 'desc')->paginate(6);
        $nilaiTertinggi = \App\Models\HasilKuis::where('user_id', $userId)->max('nilai') ?? 0;
        $nilaiTerendah  = \App\Models\HasilKuis::where('user_id', $userId)->min('nilai') ?? 0;
        $tren6Terakhir  = \App\Models\HasilKuis::where('user_id', $userId)->orderBy('created_at', 'desc')->take(6)->pluck('nilai')->reverse()->values();

        $trenJam = [];
        for ($i = 7; $i >= 0; $i--) {
            $start = $now->copy()->subWeeks($i)->startOfWeek();
            $end   = $now->copy()->subWeeks($i)->endOfWeek();
            $menit = \App\Models\AktivitasBelajar::where('user_id', $userId)->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])->sum('durasi_menit');
            $trenJam[] = ['label' => 'W' . (8 - $i), 'jam' => round($menit / 60, 1), 'menit' => $menit];
        }
        $maxJam = max(array_column($trenJam, 'menit')) ?: 1;

        $kemampuanTopik   = \App\Models\HasilKuis::where('user_id', $userId)->with('materi')->get()
            ->groupBy(fn($h) => $h->materi->topik ?? $h->materi->mata_pelajaran ?? 'Umum')
            ->map(fn($list) => round($list->avg('nilai')))->sortDesc()->take(8);
        $rekomendasiMapel = collect($progresMapel)->sortBy('rata')->first();

        return view('siswa.hasil-progres', [
            'rataRataNilai'        => $rataRataNilai,
            'latihanSelesai'       => $latihanSelesai,
            'kuisDikerjakan'       => $kuisDikerjakan,
            'jamBelajar'           => $jamBelajar,
            'selisihNilai'         => $selisihNilai,
            'latihanMingguIni'     => $latihanMingguIni,
            'selisihKuis'          => $selisihKuis,
            'jamBulanIni'          => $jamBulanIni,
            'aktivitasMingguan'    => $aktivitasMingguan,
            'totalAktivitasMinggu' => $totalAktivitasMinggu,
            'rataHari'             => $rataHari,
            'distribusi'           => $distribusi,
            'progresMapel'         => $progresMapel,
            'riwayatNilai'         => $riwayatNilai,
            'nilaiTertinggi'       => $nilaiTertinggi,
            'nilaiTerendah'        => $nilaiTerendah,
            'tren6Terakhir'        => $tren6Terakhir,
            'trenJam'              => $trenJam,
            'maxJam'               => $maxJam,
            'kemampuanTopik'       => $kemampuanTopik,
            'rekomendasiMapel'     => $rekomendasiMapel,
            'totalHasil'           => $totalHasil,
        ]);
    });

    // ── NOTIFIKASI ──
    Route::get('/notifikasi', function () {
        $userId = auth()->id();

        $notifikasi = \App\Models\Notifikasi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $jumlahBelumDibaca = $notifikasi->where('sudah_dibaca', false)->count();

        $hariIni   = $notifikasi->filter(fn($n) => $n->created_at->isToday());
        $kemarin   = $notifikasi->filter(fn($n) => $n->created_at->isYesterday());
        $mingguIni = $notifikasi->filter(fn($n) => !$n->created_at->isToday() && !$n->created_at->isYesterday() && $n->created_at->diffInDays(now()) <= 7);
        $lebihLama = $notifikasi->filter(fn($n) => $n->created_at->diffInDays(now()) > 7);

        return view('siswa.notifikasi', [
            'jumlahBelumDibaca' => $jumlahBelumDibaca,
            'hariIni'           => $hariIni,
            'kemarin'           => $kemarin,
            'mingguIni'         => $mingguIni,
            'lebihLama'         => $lebihLama,
        ]);
    });

    // Tandai semua dibaca
    Route::post('/notifikasi/tandai-semua', function () {
        \App\Models\Notifikasi::where('user_id', auth()->id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);
        return back();
    });

    // Tandai dibaca + redirect ke url aksi
    Route::post('/notifikasi/{id}/buka', function ($id) {
        $notif = \App\Models\Notifikasi::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $notif->update(['sudah_dibaca' => true]);
        return redirect($notif->url_aksi ?? '/siswa/notifikasi');
    });

    Route::get('/pembayaran', fn() => view('siswa.pembayaran'));
    // GET - Tampilkan halaman profil
    Route::get('/profil', function () {
        $user   = auth()->user();
        $userId = $user->id;

        // Stat untuk profile header (dari DB)
        $rataRataNilai  = round(\App\Models\HasilKuis::where('user_id', $userId)->avg('nilai') ?? 0);
        $soalSelesai    = \App\Models\HasilKuis::where('user_id', $userId)->sum('total_soal');
        $sesiLes        = \App\Models\LesPrivat::where('user_id', $userId)->where('status', 'selesai')->count();

        // Pencapaian
        $totalHasil     = \App\Models\HasilKuis::where('user_id', $userId)->count();
        $latihanSelesai = \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->count();
        $aktivitasMinggu = \App\Models\HasilKuis::where('user_id', $userId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $achievements = [
            ['🔥', 'Streak 5 Hari',    'Belajar 5 hari berturut',   $aktivitasMinggu >= 5],
            ['⭐', 'Nilai Sempurna',    'Skor 100 di kuis',           \App\Models\HasilKuis::where('user_id', $userId)->where('nilai', 100)->exists()],
            ['📚', 'Kutu Buku',         'Selesai 5 materi',           $latihanSelesai >= 5],
            ['⚡', 'Kilat!',            'Kuis < 10 menit',            \App\Models\HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->where('durasi_menit', '<', 10)->where('durasi_menit', '>', 0)->exists()],
            ['🥇', 'Juara Mapel',       'Rata-rata 95+ semua',        $rataRataNilai >= 95],
            ['🌙', 'Belajar Malam',     'Latihan > 22:00',            \App\Models\HasilKuis::where('user_id', $userId)->whereTime('created_at', '>=', '22:00:00')->exists()],
            ['💯', 'Perfectionist',     '10 kuis sempurna',           \App\Models\HasilKuis::where('user_id', $userId)->where('nilai', 100)->count() >= 10],
            ['🎯', 'Fokus',             'Streak 30 hari',             $aktivitasMinggu >= 30],
            ['🚀', 'Top Siswa',         'Masuk peringkat 10',         false],
            ['📖', 'Pelajar Tekun',     '500 soal selesai',           $soalSelesai >= 500],
            ['🎓', 'Siap TKA',          'Progres 100% semua',         false],
            ['👑', 'Legend',            'Raih semua badge',           false],
        ];

        $badgeTerbuka  = collect($achievements)->filter(fn($a) => $a[3])->count();
        $badgeTerkunci = count($achievements) - $badgeTerbuka;

        return view('siswa.profil', [
            'user'          => $user,
            'rataRataNilai' => $rataRataNilai,
            'soalSelesai'   => $soalSelesai,
            'sesiLes'       => $sesiLes,
            'badgeTerbuka'  => $badgeTerbuka,
            'badgeTerkunci' => $badgeTerkunci,
            'achievements'  => $achievements,
            'aktivitasMinggu' => $aktivitasMinggu,
        ]);
    });

    // POST - Update info pribadi
    Route::post('/profil/update-info', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();

        $request->validate([
            'name'          => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenjang'       => 'nullable|in:sd,smp,sma',
            'kelas'         => 'nullable|string|max:20',
            'kota'          => 'nullable|string|max:100',
            'provinsi'      => 'nullable|string|max:100',
            'tujuan_belajar' => 'nullable|string|max:255',
            'bio'           => 'nullable|string|max:500',
        ]);

        $user->update([
            'name'           => $request->name,
            'no_hp'          => $request->no_hp,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'jenjang'        => $request->jenjang,
            'kelas'          => $request->kelas,
            'kota'           => $request->kota,
            'provinsi'       => $request->provinsi,
            'tujuan_belajar' => $request->tujuan_belajar,
            'bio'            => $request->bio,
        ]);

        return redirect('/siswa/profil')->with('sukses_info', 'Informasi pribadi berhasil diperbarui!');
    });

    // POST - Upload avatar
    Route::post('/profil/upload-avatar', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        // Hapus avatar lama
        if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect('/siswa/profil')->with('sukses_info', 'Foto profil berhasil diperbarui!');
    });

    // POST - Ganti password
    Route::post('/profil/ganti-password', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();

        $request->validate([
            'password_lama'     => 'required',
            'password_baru'     => 'required|min:8|confirmed',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password saat ini salah!'])->with('tab', 'keamanan');
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password_baru),
        ]);

        return redirect('/siswa/profil')->with('sukses_password', 'Password berhasil diubah!')->with('tab', 'keamanan');
    });

    Route::get('/pesan-jadwal', function () {
        $tutors       = \App\Models\User::where('role', 'tutor')->get();
        $paketDipilih = session('paket_dipilih');
        return view('siswa.pesan-jadwal', [
            'tutors'       => $tutors,
            'paketDipilih' => $paketDipilih,
        ]);
    });

    Route::post('/pesan-jadwal', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'tutor_id'       => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'jadwal'         => 'required|date',
            'mode'           => 'required|in:online,tatap_muka',
        ]);
        \App\Models\LesPrivat::create([
            'user_id'        => auth()->user()->id,
            'tutor_id'       => $request->tutor_id,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jadwal'         => $request->jadwal,
            'status'         => 'menunggu',
            'mode'           => $request->mode,
        ]);
        return redirect('/siswa/les-privat')->with('sukses', 'Jadwal les berhasil dipesan!');
    });

    Route::post('/pilih-paket/{tipe}', function ($tipe) {
        $paket = \App\Models\Paket::where('tipe', $tipe)->firstOrFail();
        session(['paket_dipilih' => $paket]);
        return redirect('/siswa/pesan-jadwal');
    });
});

// ── TUTOR ──
Route::middleware(['auth', 'role:tutor'])->prefix('tutor')->group(function () {

    // Dashboard (tidak berubah, biarkan seperti semula)
    Route::get('/dashboard', function () {
        $user  = auth()->user();
        $today = now()->toDateString();
        $totalSiswa    = \App\Models\LesPrivat::where('tutor_id', $user->id)->distinct('user_id')->count();
        $sesiMingguIni = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->whereBetween('jadwal', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'dikonfirmasi')->count();
        $totalMateri   = \App\Models\Materi::where('tutor_id', $user->id)->count();
        $totalSoal     = \App\Models\Soal::where('tutor_id', $user->id)->count();
        $jadwalHariIni = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->whereDate('jadwal', $today)->where('status', 'dikonfirmasi')
            ->with('siswa')->orderBy('jadwal', 'asc')->get();
        return view('tutor.dashboard', [
            'namaUser'       => $user->name,
            'totalSiswa'     => $totalSiswa,
            'sesiMingguIni'  => $sesiMingguIni,
            'totalMateri'    => $totalMateri,
            'totalSoal'      => $totalSoal,
            'jadwalHariIni'  => $jadwalHariIni,
            'tanggalHariIni' => now()->translatedFormat('d M Y'),
        ]);
    });

    // ══════════════════════════════════════════════
    // MATERI
    // ══════════════════════════════════════════════

    // GET - Tampilkan halaman materi (stat dari DB, bukan hardcode)
    Route::get('/materi', function () {
        $tutorId = auth()->id();
        $materi  = \App\Models\Materi::where('tutor_id', $tutorId)
            ->withCount('soal')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $materi->count(),
            'aktif' => $materi->where('status', 'aktif')->count(),
            'draft' => $materi->where('status', 'draft')->count(),
            'arsip' => $materi->where('status', 'arsip')->count(),
        ];

        $daftarMapel = $materi->pluck('mata_pelajaran')->unique()->filter()->values();

        return view('tutor.materi', [
            'materi'      => $materi,
            'stats'       => $stats,
            'daftarMapel' => $daftarMapel,
        ]);
    });

    // POST - Simpan materi baru
    Route::post('/materi', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'jenjang'        => 'required|in:sd,smp,sma',
            'mata_pelajaran' => 'required|string|max:100',
            'kelas'          => 'required|string|max:50',
            'tipe'           => 'required|in:pdf,video,doc,ppt,quiz',
            'topik'          => 'nullable|string|max:255',
            'status'         => 'required|in:aktif,draft,arsip',
            'link_video'     => 'nullable|url|max:500',
            'catatan'        => 'nullable|string',
            'file'           => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4|max:51200',
        ]);

        $filePath = null;
        $fileSize = null;

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filePath = $file->store('materi', 'public');
            $sizeKb   = $file->getSize() / 1024;
            $fileSize = $sizeKb >= 1024
                ? round($sizeKb / 1024, 1) . ' MB'
                : round($sizeKb, 0) . ' KB';
        }

        \App\Models\Materi::create([
            'tutor_id'       => auth()->id(),
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'jenjang'        => $request->jenjang,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas'          => $request->kelas,
            'tipe'           => $request->tipe,
            'topik'          => $request->topik,
            'status'         => $request->status,
            'file_path'      => $filePath,
            'file_size'      => $fileSize,
            'link_video'     => $request->link_video,
            'catatan'        => $request->catatan,
        ]);

        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil ditambahkan!');
    });

    // PUT - Update materi
    Route::put('/materi/{id}', function (\Illuminate\Http\Request $request, $id) {
        $materi = \App\Models\Materi::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'judul'          => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'jenjang'        => 'required|in:sd,smp,sma',
            'mata_pelajaran' => 'required|string|max:100',
            'kelas'          => 'required|string|max:50',
            'tipe'           => 'required|in:pdf,video,doc,ppt,quiz',
            'topik'          => 'nullable|string|max:255',
            'status'         => 'required|in:aktif,draft,arsip',
            'link_video'     => 'nullable|url|max:500',
            'catatan'        => 'nullable|string',
            'file'           => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4|max:51200',
        ]);

        $data = [
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'jenjang'        => $request->jenjang,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas'          => $request->kelas,
            'tipe'           => $request->tipe,
            'topik'          => $request->topik,
            'status'         => $request->status,
            'link_video'     => $request->link_video,
            'catatan'        => $request->catatan,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($materi->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($materi->file_path);
            }
            $file              = $request->file('file');
            $data['file_path'] = $file->store('materi', 'public');
            $sizeKb            = $file->getSize() / 1024;
            $data['file_size'] = $sizeKb >= 1024
                ? round($sizeKb / 1024, 1) . ' MB'
                : round($sizeKb, 0) . ' KB';
        }

        $materi->update($data);

        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil diperbarui!');
    });

    // DELETE - Hapus materi
    Route::delete('/materi/{id}', function ($id) {
        $materi = \App\Models\Materi::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->firstOrFail();

        if ($materi->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil dihapus!');
    });

    // GET JSON - Ambil data 1 materi untuk modal Edit (AJAX)
    Route::get('/materi/{id}/json', function ($id) {
        $materi = \App\Models\Materi::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->firstOrFail();
        return response()->json($materi);
    });

    // ══════════════════════════════════════════════
    // SOAL
    // ══════════════════════════════════════════════

    // GET - Tampilkan bank soal
    Route::get('/soal', function () {
        $tutorId = auth()->id();

        $soal = \App\Models\Soal::where('tutor_id', $tutorId)
            ->with('materi')
            ->orderBy('created_at', 'desc')
            ->get();

        $materi = \App\Models\Materi::where('tutor_id', $tutorId)->get();

        // Ambil hasil kuis siswa untuk semua materi milik tutor ini
        $materiIds  = $materi->pluck('id');
        $hasilSiswa = \App\Models\HasilKuis::whereIn('materi_id', $materiIds)
            ->with(['siswa', 'materi'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tutor.soal', [
            'soal'        => $soal,
            'materi'      => $materi,
            'hasilSiswa'  => $hasilSiswa,
        ]);
    });

    // POST - Simpan soal baru
    Route::post('/soal', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'materi_id'         => 'required|exists:materi,id',
            'pertanyaan'        => 'required|string',
            'pilihan_a'         => 'required|string',
            'pilihan_b'         => 'required|string',
            'pilihan_c'         => 'required|string',
            'pilihan_d'         => 'required|string',
            'jawaban_benar'     => 'required|in:a,b,c,d',
            'pembahasan'        => 'nullable|string',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
        ]);

        \App\Models\Soal::create([
            'materi_id'         => $request->materi_id,
            'tutor_id'          => auth()->id(),
            'pertanyaan'        => $request->pertanyaan,
            'pilihan_a'         => $request->pilihan_a,
            'pilihan_b'         => $request->pilihan_b,
            'pilihan_c'         => $request->pilihan_c,
            'pilihan_d'         => $request->pilihan_d,
            'jawaban_benar'     => $request->jawaban_benar,
            'pembahasan'        => $request->pembahasan,
            'tingkat_kesulitan' => $request->tingkat_kesulitan,
        ]);

        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil ditambahkan!');
    });

    // PUT - Update soal
    Route::put('/soal/{id}', function (\Illuminate\Http\Request $request, $id) {
        $request->validate([
            'pertanyaan'        => 'required|string',
            'pilihan_a'         => 'required|string',
            'pilihan_b'         => 'required|string',
            'pilihan_c'         => 'required|string',
            'pilihan_d'         => 'required|string',
            'jawaban_benar'     => 'required|in:a,b,c,d',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'pembahasan'        => 'nullable|string',
        ]);

        $soal = \App\Models\Soal::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->firstOrFail();

        $soal->update([
            'pertanyaan'        => $request->pertanyaan,
            'pilihan_a'         => $request->pilihan_a,
            'pilihan_b'         => $request->pilihan_b,
            'pilihan_c'         => $request->pilihan_c,
            'pilihan_d'         => $request->pilihan_d,
            'jawaban_benar'     => $request->jawaban_benar,
            'tingkat_kesulitan' => $request->tingkat_kesulitan,
            'pembahasan'        => $request->pembahasan,
        ]);

        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil diperbarui!');
    });

    // DELETE - Hapus soal
    Route::delete('/soal/{id}', function ($id) {
        \App\Models\Soal::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->firstOrFail()
            ->delete();
        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil dihapus!');
    });

    // Route lainnya (tidak berubah)
    Route::get('/jadwal', fn() => view('tutor.jadwal'));

    Route::get('/les-privat', function () {
        $user = auth()->user();
        $menunggu = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->where('status', 'menunggu')->with('siswa')->orderBy('created_at', 'desc')->get();
        $dikonfirmasi = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->where('status', 'dikonfirmasi')->with('siswa')->orderBy('jadwal', 'asc')->get();
        $riwayat = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->whereIn('status', ['selesai', 'dibatalkan'])->with('siswa')
            ->orderBy('jadwal', 'desc')->take(20)->get();
        $stats = [
            'total_siswa' => \App\Models\LesPrivat::where('tutor_id', $user->id)->distinct('user_id')->count(),
            'bulan_ini'   => \App\Models\LesPrivat::where('tutor_id', $user->id)
                ->whereMonth('jadwal', now()->month)->where('status', '!=', 'dibatalkan')->count(),
            'menunggu'    => $menunggu->count(),
            'penghasilan' => \App\Models\LesPrivat::where('tutor_id', $user->id)
                ->where('status', 'selesai')->whereMonth('jadwal', now()->month)->sum('harga'),
        ];
        return view('tutor.les-privat', compact('menunggu', 'dikonfirmasi', 'riwayat', 'stats'));
    });

    Route::post('/les-privat/{id}/terima', function ($id) {
        $les = \App\Models\LesPrivat::where('id', $id)->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')->firstOrFail();
        $les->update([
            'status'       => 'dikonfirmasi',
            'link_meeting' => $les->mode === 'online'
                ? 'https://meet.google.com/alilmi-' . strtolower(substr(str_replace(' ', '', auth()->user()->name), 0, 6))
                : null,
        ]);
        return redirect('/tutor/les-privat')->with('sukses', 'Pesanan berhasil dikonfirmasi!');
    });

    Route::post('/les-privat/{id}/tolak', function ($id) {
        \App\Models\LesPrivat::where('id', $id)->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')->firstOrFail()->update(['status' => 'dibatalkan']);
        return redirect('/tutor/les-privat')->with('sukses', 'Pesanan berhasil ditolak.');
    });

    Route::post('/les-privat/{id}/selesai', function ($id) {
        \App\Models\LesPrivat::where('id', $id)->where('tutor_id', auth()->id())
            ->where('status', 'dikonfirmasi')->firstOrFail()->update(['status' => 'selesai']);
        return redirect('/tutor/les-privat')->with('sukses', 'Sesi berhasil ditandai selesai!');
    });

    Route::get('/daftar-siswa', function () {
        $user = auth()->user();
        $siswaList = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->with('siswa')
            ->select('user_id')
            ->distinct()
            ->get()
            ->pluck('siswa')
            ->filter();

        return view('tutor.daftar-siswa', ['siswaList' => $siswaList]);
    });

    Route::get('/notifikasi', function () {
        return view('tutor.notifikasi');
    });

    Route::get('/profil', fn() => view('tutor.profil'));
});

// ── ADMIN ──
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('/pengguna', function () {
        return view('admin.pengguna');
    });
    Route::get('/paket', function () {
        return view('admin.paket');
    });
    Route::get('/transaksi', function () {
        return view('admin.transaksi');
    });
    Route::get('/laporan', function () {
        return view('admin.laporan');
    });
});
