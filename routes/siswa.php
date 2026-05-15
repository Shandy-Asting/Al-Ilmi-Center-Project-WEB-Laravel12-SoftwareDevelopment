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

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {

    // ── Dashboard ──────────────────────────────────────────────────────────
    Route::get('/dashboard', function () {
        $user = auth()->user();

        $rataRataNilai    = round(HasilLatihan::where('user_id', $user->id)->avg('nilai') ?? 0);
        $soalDiselesaikan = HasilLatihan::where('user_id', $user->id)->sum('soal_benar') ?? 0;
        $jamBelajar       = round(AktivitasBelajar::where('user_id', $user->id)->sum('durasi_menit') / 60, 1) ?? 0;
        $lesPrivat        = LesPrivat::where('user_id', $user->id)->whereMonth('created_at', now()->month)->count() ?? 0;

        return view('siswa.dashboard', [
            'namaUser'         => $user->name,
            'rataRataNilai'    => $rataRataNilai,
            'soalDiselesaikan' => $soalDiselesaikan,
            'jamBelajar'       => $jamBelajar,
            'lesPrivat'        => $lesPrivat,
        ]);
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
        $user = auth()->user();

        $pesananAktif = LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->with('tutor')
            ->orderBy('jadwal', 'asc')
            ->get();

        $riwayat = LesPrivat::where('user_id', $user->id)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->with('tutor')
            ->orderBy('jadwal', 'desc')
            ->take(10)
            ->get();

        return view('siswa.les-privat', [
            'pesananAktif' => $pesananAktif,
            'riwayat'      => $riwayat,
            'tutors'       => User::where('role', 'tutor')->get(),
        ]);
    });

    Route::post('/les-privat/pesan', function (Request $request) {
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

        $bentrok = LesPrivat::where('tutor_id', $request->tutor_id)
            ->where('status', 'dikonfirmasi')
            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, jadwal, ?)) < durasi_menit', [$request->jadwal])
            ->exists();

        if ($bentrok) {
            return back()
                ->withErrors(['jadwal' => 'Tutor sudah memiliki sesi di waktu tersebut.'])
                ->withInput();
        }

        $harga = match ((int) $request->durasi_menit) {
            60      => 50000,
            90      => 75000,
            120     => 100000,
            default => 75000,
        };

        LesPrivat::create([
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

    // ── Hasil & Progres ────────────────────────────────────────────────────
    Route::get('/hasil-progres', function () {
        $user   = auth()->user();
        $userId = $user->id;
        $now    = now();

        // Statistik utama
        $rataRataNilai  = round(HasilKuis::where('user_id', $userId)->avg('nilai') ?? 0);
        $latihanSelesai = HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->count();
        $kuisDikerjakan = HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->count();
        $jamBelajar     = round(AktivitasBelajar::where('user_id', $userId)->sum('durasi_menit') / 60, 1);

        // Perbandingan bulan lalu
        $rataRataBulanLalu = round(HasilKuis::where('user_id', $userId)->whereMonth('created_at', $now->copy()->subMonth()->month)->avg('nilai') ?? 0);
        $selisihNilai      = $rataRataNilai - $rataRataBulanLalu;
        $latihanMingguIni  = HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])->count();
        $kuisBulanLalu     = HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->whereMonth('created_at', $now->copy()->subMonth()->month)->count();
        $selisihKuis       = $kuisDikerjakan - $kuisBulanLalu;
        $jamBulanIni       = round(AktivitasBelajar::where('user_id', $userId)->whereMonth('tanggal', $now->month)->sum('durasi_menit') / 60, 1);

        // Aktivitas mingguan (7 hari terakhir)
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

        // Distribusi nilai
        $semuaNilai = HasilKuis::where('user_id', $userId)->pluck('nilai');
        $totalHasil = $semuaNilai->count();
        $distribusi = [
            'A' => $totalHasil > 0 ? round($semuaNilai->filter(fn ($n) => $n >= 87)->count() / $totalHasil * 100) : 0,
            'B' => $totalHasil > 0 ? round($semuaNilai->filter(fn ($n) => $n >= 70 && $n < 87)->count() / $totalHasil * 100) : 0,
            'C' => $totalHasil > 0 ? round($semuaNilai->filter(fn ($n) => $n >= 55 && $n < 70)->count() / $totalHasil * 100) : 0,
            'D' => $totalHasil > 0 ? round($semuaNilai->filter(fn ($n) => $n < 55)->count() / $totalHasil * 100) : 0,
        ];

        // Progres per mata pelajaran
        $semuaMapel   = HasilKuis::where('user_id', $userId)->with('materi')->get()->groupBy(fn ($h) => $h->materi->mata_pelajaran ?? 'Lainnya');
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

        // Riwayat & statistik nilai
        $riwayatNilai   = HasilKuis::where('user_id', $userId)->with('materi')->orderBy('created_at', 'desc')->paginate(6);
        $nilaiTertinggi = HasilKuis::where('user_id', $userId)->max('nilai') ?? 0;
        $nilaiTerendah  = HasilKuis::where('user_id', $userId)->min('nilai') ?? 0;
        $tren6Terakhir  = HasilKuis::where('user_id', $userId)->orderBy('created_at', 'desc')->take(6)->pluck('nilai')->reverse()->values();

        // Tren jam belajar (8 minggu terakhir)
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

        // Kemampuan per topik & rekomendasi
        $kemampuanTopik   = HasilKuis::where('user_id', $userId)->with('materi')->get()
            ->groupBy(fn ($h) => $h->materi->topik ?? $h->materi->mata_pelajaran ?? 'Umum')
            ->map(fn ($list) => round($list->avg('nilai')))
            ->sortDesc()
            ->take(8);

        $rekomendasiMapel = collect($progresMapel)->sortBy('rata')->first();

        return view('siswa.hasil-progres', compact(
            'rataRataNilai', 'latihanSelesai', 'kuisDikerjakan', 'jamBelajar',
            'selisihNilai', 'latihanMingguIni', 'selisihKuis', 'jamBulanIni',
            'aktivitasMingguan', 'totalAktivitasMinggu', 'rataHari',
            'distribusi', 'progresMapel', 'riwayatNilai',
            'nilaiTertinggi', 'nilaiTerendah', 'tren6Terakhir',
            'trenJam', 'maxJam', 'kemampuanTopik', 'rekomendasiMapel', 'totalHasil'
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

        $perMapel = $hasilKuis->groupBy(fn ($h) => $h->materi->mata_pelajaran ?? 'Lainnya')
            ->map(fn ($list, $mapel) => [
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
        $notifikasi = Notifikasi::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('siswa.notifikasi', [
            'jumlahBelumDibaca' => $notifikasi->where('sudah_dibaca', false)->count(),
            'hariIni'           => $notifikasi->filter(fn ($n) => $n->created_at->isToday()),
            'kemarin'           => $notifikasi->filter(fn ($n) => $n->created_at->isYesterday()),
            'mingguIni'         => $notifikasi->filter(fn ($n) => ! $n->created_at->isToday() && ! $n->created_at->isYesterday() && $n->created_at->diffInDays(now()) <= 7),
            'lebihLama'         => $notifikasi->filter(fn ($n) => $n->created_at->diffInDays(now()) > 7),
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
        $user   = auth()->user();
        $userId = $user->id;

        $rataRataNilai   = round(HasilKuis::where('user_id', $userId)->avg('nilai') ?? 0);
        $soalSelesai     = HasilKuis::where('user_id', $userId)->sum('total_soal');
        $sesiLes         = LesPrivat::where('user_id', $userId)->where('status', 'selesai')->count();
        $latihanSelesai  = HasilKuis::where('user_id', $userId)->where('tipe', 'latihan')->count();
        $aktivitasMinggu = HasilKuis::where('user_id', $userId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $achievements = [
            ['🔥', 'Streak 5 Hari',  'Belajar 5 hari berturut', $aktivitasMinggu >= 5],
            ['⭐', 'Nilai Sempurna',  'Skor 100 di kuis',         HasilKuis::where('user_id', $userId)->where('nilai', 100)->exists()],
            ['📚', 'Kutu Buku',       'Selesai 5 materi',         $latihanSelesai >= 5],
            ['⚡', 'Kilat!',          'Kuis < 10 menit',          HasilKuis::where('user_id', $userId)->where('tipe', 'kuis')->whereBetween('durasi_menit', [1, 9])->exists()],
            ['🥇', 'Juara Mapel',     'Rata-rata 95+ semua',      $rataRataNilai >= 95],
            ['🌙', 'Belajar Malam',   'Latihan > 22:00',          HasilKuis::where('user_id', $userId)->whereTime('created_at', '>=', '22:00:00')->exists()],
            ['💯', 'Perfectionist',   '10 kuis sempurna',         HasilKuis::where('user_id', $userId)->where('nilai', 100)->count() >= 10],
            ['🎯', 'Fokus',           'Streak 30 hari',           $aktivitasMinggu >= 30],
            ['🚀', 'Top Siswa',       'Masuk peringkat 10',       false],
            ['📖', 'Pelajar Tekun',   '500 soal selesai',         $soalSelesai >= 500],
            ['🎓', 'Siap TKA',        'Progres 100% semua',       false],
            ['👑', 'Legend',          'Raih semua badge',         false],
        ];

        $badgeTerbuka  = collect($achievements)->filter(fn ($a) => $a[3])->count();
        $badgeTerkunci = count($achievements) - $badgeTerbuka;

        return view('siswa.profil', compact(
            'user', 'rataRataNilai', 'soalSelesai', 'sesiLes',
            'badgeTerbuka', 'badgeTerkunci', 'achievements', 'aktivitasMinggu'
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
            'name', 'no_hp', 'tanggal_lahir', 'jenjang',
            'kelas', 'kota', 'provinsi', 'tujuan_belajar', 'bio',
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

        return redirect('/siswa/les-privat')->with('sukses', 'Jadwal les berhasil dipesan!');
    });

    Route::post('/pilih-paket/{tipe}', function ($tipe) {
        session(['paket_dipilih' => Paket::where('tipe', $tipe)->firstOrFail()]);
        return redirect('/siswa/pesan-jadwal');
    });

    // ── Pembayaran ─────────────────────────────────────────────────────────
    Route::get('/pembayaran', fn () => view('siswa.pembayaran'));
});