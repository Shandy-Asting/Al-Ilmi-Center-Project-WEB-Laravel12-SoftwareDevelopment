<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Models\HasilKuis;
use App\Models\LesPrivat;
use App\Models\Materi;
use App\Models\Soal;
use App\Models\Pembayaran;
use App\Models\Notifikasi;
use App\Models\Ulasan;


Route::middleware(['auth', 'role:tutor'])->prefix('tutor')->group(function () {

    // ── Dashboard ──────────────────────────────────────────────────────────
    Route::get('/dashboard', function () {
        $user  = auth()->user();
        $today = now()->toDateString();

        // Stat cards
        $sesiMingguIni = LesPrivat::where('tutor_id', $user->id)
            ->whereBetween('jadwal', [now()->startOfWeek(), now()->endOfWeek()])
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->count();

        $sesiMingguLalu = LesPrivat::where('tutor_id', $user->id)
            ->whereBetween('jadwal', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->count();

        $totalSiswa = LesPrivat::where('tutor_id', $user->id)
            ->distinct('user_id')->count();

        $siswaBulanLalu = LesPrivat::where('tutor_id', $user->id)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->distinct('user_id')->count();

        $jamBulanIni = round(
            LesPrivat::where('tutor_id', $user->id)
                ->whereIn('status', ['dikonfirmasi', 'selesai'])
                ->whereMonth('jadwal', now()->month)
                ->sum('durasi_menit') / 60,
            1
        );

        $jamBulanLalu = round(
            LesPrivat::where('tutor_id', $user->id)
                ->whereIn('status', ['dikonfirmasi', 'selesai'])
                ->whereMonth('jadwal', now()->subMonth()->month)
                ->sum('durasi_menit') / 60,
            1
        );

        // Rating dari ulasan DB
        $ulasanList  = \App\Models\Ulasan::where('tutor_id', $user->id)->get();
        $ratingRata  = $ulasanList->count() > 0 ? round($ulasanList->avg('bintang'), 1) : 0;
        $totalUlasan = $ulasanList->count();

        // Jadwal hari ini dari DB
        $jadwalHariIni = LesPrivat::where('tutor_id', $user->id)
            ->whereDate('jadwal', $today)
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->with('siswa')
            ->orderBy('jadwal', 'asc')
            ->get();

        // Progres siswa — rata-rata nilai HasilKuis per siswa
        $progresMapel = LesPrivat::where('tutor_id', $user->id)
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->with('siswa')
            ->get()
            ->unique('user_id')
            ->take(5)
            ->map(function ($les) {
                $rata = \App\Models\HasilKuis::where('user_id', $les->user_id)->avg('nilai') ?? 0;
                return [
                    'nama'  => $les->siswa->name ?? '-',
                    'mapel' => $les->mata_pelajaran,
                    'pct'   => min(round($rata), 100),
                ];
            })->values();

        // Kalender — hari yang ada sesi bulan ini
        $hariAdaSesi = LesPrivat::where('tutor_id', $user->id)
            ->whereMonth('jadwal', now()->month)
            ->whereYear('jadwal', now()->year)
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->get()
            ->map(fn($l) => $l->jadwal->day)
            ->unique()->values()->toArray();

        return view('tutor.dashboard', compact(
            'user',
            'sesiMingguIni',
            'sesiMingguLalu',
            'totalSiswa',
            'siswaBulanLalu',
            'jamBulanIni',
            'jamBulanLalu',
            'ratingRata',
            'totalUlasan',
            'jadwalHariIni',
            'progresMapel',
            'hariAdaSesi',
        ));
    });

    // ── Materi ─────────────────────────────────────────────────────────────
    Route::get('/materi', function () {
        $tutorId = auth()->id();
        $materi  = Materi::where('tutor_id', $tutorId)
            ->withCount('soal')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tutor.materi', [
            'materi'      => $materi,
            'stats'       => [
                'total' => $materi->count(),
                'aktif' => $materi->where('status', 'aktif')->count(),
                'draft' => $materi->where('status', 'draft')->count(),
                'arsip' => $materi->where('status', 'arsip')->count(),
            ],
            'daftarMapel' => $materi->pluck('mata_pelajaran')->unique()->filter()->values(),
        ]);
    });

    Route::post('/materi', function (Request $request) {
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
            $fileSize = $sizeKb >= 1024 ? round($sizeKb / 1024, 1) . ' MB' : round($sizeKb, 0) . ' KB';
        }

        Materi::create([
            ...$request->only(['judul', 'deskripsi', 'jenjang', 'mata_pelajaran', 'kelas', 'tipe', 'topik', 'status', 'link_video', 'catatan']),
            'tutor_id'  => auth()->id(),
            'file_path' => $filePath,
            'file_size' => $fileSize,
        ]);

        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil ditambahkan!');
    });

    Route::put('/materi/{id}', function (Request $request, $id) {
        $materi = Materi::where('id', $id)->where('tutor_id', auth()->id())->firstOrFail();

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

        $data = $request->only(['judul', 'deskripsi', 'jenjang', 'mata_pelajaran', 'kelas', 'tipe', 'topik', 'status', 'link_video', 'catatan']);

        if ($request->hasFile('file')) {
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $file              = $request->file('file');
            $data['file_path'] = $file->store('materi', 'public');
            $sizeKb            = $file->getSize() / 1024;
            $data['file_size'] = $sizeKb >= 1024 ? round($sizeKb / 1024, 1) . ' MB' : round($sizeKb, 0) . ' KB';
        }

        $materi->update($data);

        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil diperbarui!');
    });

    Route::delete('/materi/{id}', function ($id) {
        $materi = Materi::where('id', $id)->where('tutor_id', auth()->id())->firstOrFail();

        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil dihapus!');
    });

    Route::get('/materi/{id}/json', function ($id) {
        return response()->json(
            Materi::where('id', $id)->where('tutor_id', auth()->id())->firstOrFail()
        );
    });

    // ── Soal ───────────────────────────────────────────────────────────────
    Route::get('/soal', function () {
        $tutorId   = auth()->id();
        $materi    = Materi::where('tutor_id', $tutorId)->get();
        $materiIds = $materi->pluck('id');

        return view('tutor.soal', [
            'soal'       => Soal::where('tutor_id', $tutorId)->with('materi')->orderBy('created_at', 'desc')->get(),
            'materi'     => $materi,
            'hasilSiswa' => HasilKuis::whereIn('materi_id', $materiIds)->with(['siswa', 'materi'])->orderBy('created_at', 'desc')->get(),
        ]);
    });

    Route::post('/soal', function (Request $request) {
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

        Soal::create([
            ...$request->only(['materi_id', 'pertanyaan', 'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'jawaban_benar', 'pembahasan', 'tingkat_kesulitan']),
            'tutor_id' => auth()->id(),
        ]);

        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil ditambahkan!');
    });

    Route::get('/soal/template-import', function () {
        $filePath = public_path('templates/template-import-soal.xlsx');

        if (!file_exists($filePath)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return response()->download($filePath, 'template-import-soal.xlsx');
    });

    Route::put('/soal/{id}', function (Request $request, $id) {
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

        Soal::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->firstOrFail()
            ->update($request->only(['pertanyaan', 'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'jawaban_benar', 'tingkat_kesulitan', 'pembahasan']));

        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil diperbarui!');
    });

    Route::delete('/soal/{id}', function ($id) {
        Soal::where('id', $id)->where('tutor_id', auth()->id())->firstOrFail()->delete();
        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil dihapus!');
    });

    // ── Les Privat ─────────────────────────────────────────────────────────
    Route::get('/les-privat', function () {
        $user = auth()->user();

        $menunggu     = LesPrivat::where('tutor_id', $user->id)->where('status', 'menunggu')->with('siswa')->orderBy('created_at', 'desc')->get();
        $dikonfirmasi = LesPrivat::where('tutor_id', $user->id)->where('status', 'dikonfirmasi')->with('siswa')->orderBy('jadwal', 'asc')->get();
        $riwayat      = LesPrivat::where('tutor_id', $user->id)->whereIn('status', ['selesai', 'dibatalkan'])->with('siswa')->orderBy('jadwal', 'desc')->take(20)->get();

        return view('tutor.les-privat', [
            'menunggu'     => $menunggu,
            'dikonfirmasi' => $dikonfirmasi,
            'riwayat'      => $riwayat,
            'stats'        => [
                'total_siswa' => LesPrivat::where('tutor_id', $user->id)->distinct('user_id')->count(),
                'bulan_ini'   => LesPrivat::where('tutor_id', $user->id)->whereMonth('jadwal', now()->month)->where('status', '!=', 'dibatalkan')->count(),
                'menunggu'    => $menunggu->count(),
                'penghasilan' => LesPrivat::where('tutor_id', $user->id)->where('status', 'selesai')->whereMonth('jadwal', now()->month)->sum('harga'),
            ],
        ]);
    });

    Route::post('/les-privat/{id}/terima', function ($id) {
        $les = LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $les->update([
            'status'       => 'dikonfirmasi',
            'link_meeting' => $les->mode === 'online'
                ? 'https://meet.google.com/alilmi-' . strtolower(substr(str_replace(' ', '', auth()->user()->name), 0, 6))
                : null,
        ]);

        return redirect('/tutor/les-privat')->with('sukses', 'Pesanan berhasil dikonfirmasi!');
    });

    Route::post('/les-privat/{id}/tolak', function ($id) {
        LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail()
            ->update(['status' => 'dibatalkan']);

        return redirect('/tutor/les-privat')->with('sukses', 'Pesanan berhasil ditolak.');
    });

    Route::post('/les-privat/{id}/selesai', function ($id) {
        $les = LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'dikonfirmasi')
            ->firstOrFail();

        $les->update(['status' => 'selesai']);

        // Jika pembayaran belum dikonfirmasi, otomatis konfirmasi saat selesai
        if ($les->pembayaran_status === 'menunggu') {
            $les->pembayaran()->where('status', 'menunggu')->update([
                'status'          => 'dikonfirmasi',
                'dikonfirmasi_at' => now(),
            ]);
            $les->update(['pembayaran_status' => 'lunas']);
        }

        return redirect('/tutor/les-privat')->with('sukses', 'Sesi berhasil ditandai selesai!');
    });

    // ── Lainnya ────────────────────────────────────────────────────────────
    Route::get('/jadwal/kalender', function (Request $request) {
        $tgl   = (int) $request->query('tgl', now()->day);
        $bulan = (int) $request->query('bulan', now()->month);
        $tahun = (int) $request->query('tahun', now()->year);

        $tanggal = \Carbon\Carbon::create($tahun, $bulan, $tgl);

        $jadwal = LesPrivat::where('tutor_id', auth()->id())
            ->whereDate('jadwal', $tanggal->toDateString())
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->with('siswa')
            ->orderBy('jadwal', 'asc')
            ->get()
            ->map(fn($l) => [
                'waktu' => $l->jadwal->format('H.i'),
                'mapel' => $l->mata_pelajaran,
                'siswa' => $l->siswa->name ?? '-',
                'mode'  => $l->mode,
            ]);

        return response()->json([
            'label'  => $tanggal->translatedFormat('l, d M Y'),
            'total'  => $jadwal->count(),
            'jadwal' => $jadwal->values(),
        ]);
    });

    Route::get('/jadwal', function () {
        $tutorId = auth()->id();
        $today   = now()->toDateString();

        // ── Tab Hari Ini ────────────────────────────────────────────────────
        $jadwalHariIni = LesPrivat::where('tutor_id', $tutorId)
            ->whereDate('jadwal', $today)
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->with('siswa')
            ->orderBy('jadwal', 'asc')
            ->get()
            ->map(function ($les) {
                $sekarang  = now();
                $mulai     = $les->jadwal;
                $selesai   = $les->jadwal->copy()->addMinutes((int)$les->durasi_menit);

                // Tentukan status tampilan
                if ($les->status === 'selesai') {
                    $statusTampil = 'selesai';
                } elseif ($sekarang->between($mulai, $selesai)) {
                    $statusTampil = 'sedang';
                } elseif ($sekarang->lt($mulai)) {
                    $statusTampil = 'akan-datang';
                } else {
                    $statusTampil = 'selesai';
                }

                return array_merge($les->toArray(), [
                    'status_tampil' => $statusTampil,
                    'waktu_mulai'   => $mulai->format('H.i'),
                    'siswa_nama'    => $les->siswa->name ?? '-',
                    'lokasi_tampil' => $les->mode === 'online'
                        ? ($les->link_meeting ?? 'Via Meeting Online')
                        : ($les->lokasi ?? 'Tatap Muka'),
                ]);
            });

        // Ringkasan hari ini
        $selesaiHariIni   = $jadwalHariIni->where('status_tampil', 'selesai')->count();
        $sedangHariIni    = $jadwalHariIni->where('status_tampil', 'sedang')->count();
        $akanDatangHariIni = $jadwalHariIni->where('status_tampil', 'akan-datang')->count();
        $totalDurasi      = $jadwalHariIni->sum('durasi_menit');
        $penghasilanHariIni = $jadwalHariIni
            ->where('status_tampil', 'selesai')
            ->sum('harga');

        // Sesi berikutnya
        $sesiBerikutnya = $jadwalHariIni
            ->where('status_tampil', 'akan-datang')
            ->sortBy('jadwal')
            ->first();

        // ── Tab Permintaan ──────────────────────────────────────────────────
        $permintaan = LesPrivat::where('tutor_id', $tutorId)
            ->where('status', 'menunggu')
            ->with('siswa')
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik permintaan bulan ini
        $statPermintaan = [
            'masuk'    => LesPrivat::where('tutor_id', $tutorId)->whereMonth('created_at', now()->month)->count(),
            'diterima' => LesPrivat::where('tutor_id', $tutorId)->whereMonth('created_at', now()->month)->where('status', 'dikonfirmasi')->count(),
            'ditolak'  => LesPrivat::where('tutor_id', $tutorId)->whereMonth('created_at', now()->month)->where('status', 'dibatalkan')->count(),
            'menunggu' => $permintaan->count(),
        ];

        // ── Tab Semua Jadwal ────────────────────────────────────────────────
        $semuaJadwal = LesPrivat::where('tutor_id', $tutorId)
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->with('siswa')
            ->orderBy('jadwal', 'desc')
            ->get();

        // ── Stat Cards ──────────────────────────────────────────────────────
        $statCards = [
            'sesi_hari_ini'  => $jadwalHariIni->count(),
            'sesi_minggu_ini' => LesPrivat::where('tutor_id', $tutorId)
                ->whereBetween('jadwal', [now()->startOfWeek(), now()->endOfWeek()])
                ->whereIn('status', ['dikonfirmasi', 'selesai'])
                ->count(),
            'siswa_aktif'    => LesPrivat::where('tutor_id', $tutorId)
                ->where('status', 'dikonfirmasi')
                ->distinct('user_id')
                ->count(),
            'permintaan_baru' => $permintaan->count(),
        ];

        // ── Data Kalender (hari yang ada sesi bulan ini) ─────────────────────
        $hariAdaSesi = LesPrivat::where('tutor_id', $tutorId)
            ->whereMonth('jadwal', now()->month)
            ->whereYear('jadwal', now()->year)
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->get()
            ->map(fn($l) => $l->jadwal->day)
            ->unique()
            ->values()
            ->toArray();

        return view('tutor.jadwal', compact(
            'jadwalHariIni',
            'selesaiHariIni',
            'sedangHariIni',
            'akanDatangHariIni',
            'totalDurasi',
            'penghasilanHariIni',
            'sesiBerikutnya',
            'permintaan',
            'statPermintaan',
            'semuaJadwal',
            'statCards',
            'hariAdaSesi',
        ));
    });
    Route::post('/jadwal/{id}/terima', function ($id) {
        $les = LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $les->update([
            'status'       => 'dikonfirmasi',
            'link_meeting' => $les->mode === 'online'
                ? 'https://meet.google.com/alilmi-' . strtolower(substr(str_replace(' ', '', auth()->user()->name), 0, 6))
                : null,
        ]);

        // Kirim notifikasi ke siswa
        \App\Models\Notifikasi::create([
            'user_id'  => $les->user_id,
            'judul'    => '✅ Les Privat Dikonfirmasi',
            'pesan'    => 'Tutor <strong>' . auth()->user()->name . '</strong> mengkonfirmasi sesi <strong>' . $les->mata_pelajaran . '</strong> pada ' . $les->jadwal->translatedFormat('d M Y · H:i') . ' WIB.',
            'tipe'     => 'les_privat',
            'ikon'     => 'bi bi-calendar-check-fill',
            'warna'    => 'var(--success-soft)',
            'url_aksi' => '/siswa/les-privat',
            'label_aksi' => 'Lihat',
        ]);

        return redirect('/tutor/jadwal')->with('sukses', 'Pesanan berhasil dikonfirmasi!');
    });

    Route::post('/jadwal/{id}/tolak', function ($id) {
        $les = LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $les->update(['status' => 'dibatalkan']);

        // Kirim notifikasi ke siswa
        \App\Models\Notifikasi::create([
            'user_id'  => $les->user_id,
            'judul'    => '❌ Les Privat Ditolak',
            'pesan'    => 'Maaf, tutor tidak dapat menerima sesi <strong>' . $les->mata_pelajaran . '</strong> pada ' . $les->jadwal->translatedFormat('d M Y · H:i') . ' WIB. Silakan pesan ulang dengan jadwal lain.',
            'tipe'     => 'les_privat',
            'ikon'     => 'bi bi-calendar-x-fill',
            'warna'    => 'var(--danger-soft)',
            'url_aksi' => '/siswa/les-privat',
            'label_aksi' => 'Pesan Ulang',
        ]);

        return redirect('/tutor/jadwal')->with('sukses', 'Pesanan berhasil ditolak.');
    });

    Route::post('/jadwal/{id}/selesai', function ($id) {
        $les = LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'dikonfirmasi')
            ->firstOrFail();

        $les->update(['status' => 'selesai']);

        // Kirim notifikasi ke siswa
        \App\Models\Notifikasi::create([
            'user_id'  => $les->user_id,
            'judul'    => '🎓 Sesi Les Selesai',
            'pesan'    => 'Sesi <strong>' . $les->mata_pelajaran . '</strong> bersama tutor <strong>' . auth()->user()->name . '</strong> telah selesai.',
            'tipe'     => 'les_privat',
            'ikon'     => 'bi bi-check-circle-fill',
            'warna'    => 'var(--success-soft)',
            'url_aksi' => '/siswa/les-privat',
            'label_aksi' => 'Lihat Riwayat',
        ]);

        return redirect('/tutor/jadwal')->with('sukses', 'Sesi berhasil ditandai selesai!');
    });

    Route::get('/daftar-siswa', function () {
        $siswaList = LesPrivat::where('tutor_id', auth()->id())
            ->with('siswa')
            ->select('user_id')
            ->distinct()
            ->get()
            ->pluck('siswa')
            ->filter();

        return view('tutor.daftar-siswa', compact('siswaList'));
    });


    // ── Pembayaran Tutor ───────────────────────────────────────────────────
    Route::get('/pembayaran', function () {
        $user = auth()->user();

        $menunggu = Pembayaran::where('tutor_id', $user->id)
            ->where('status', 'menunggu')
            ->with(['lesPrivat', 'siswa'])
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayat = Pembayaran::where('tutor_id', $user->id)
            ->whereIn('status', ['dikonfirmasi', 'ditolak'])
            ->with(['lesPrivat', 'siswa'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'menunggu'          => $menunggu->count(),
            'total_dikonfirmasi' => Pembayaran::where('tutor_id', $user->id)->where('status', 'dikonfirmasi')->count(),
            'penghasilan_bulan' => Pembayaran::where('tutor_id', $user->id)->where('status', 'dikonfirmasi')->whereMonth('dikonfirmasi_at', now()->month)->sum('jumlah'),
            'total_ditolak'     => Pembayaran::where('tutor_id', $user->id)->where('status', 'ditolak')->count(),
        ];

        return view('tutor.pembayaran', compact('menunggu', 'riwayat', 'stats'));
    });

    Route::post('/pembayaran/{id}/konfirmasi', function ($id) {
        $pembayaran = Pembayaran::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $pembayaran->update([
            'status'          => 'dikonfirmasi',
            'dikonfirmasi_at' => now(),
        ]);

        $pembayaran->lesPrivat->update(['pembayaran_status' => 'lunas']);

        return back()->with('sukses', 'Pembayaran berhasil dikonfirmasi!');
    });

    Route::post('/pembayaran/{id}/tolak', function (Request $request, $id) {
        $pembayaran = Pembayaran::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $pembayaran->update([
            'status'        => 'ditolak',
            'catatan_tutor' => $request->input('catatan', 'Bukti transfer tidak valid.'),
        ]);

        $pembayaran->lesPrivat->update(['pembayaran_status' => 'belum']);

        return back()->with('sukses', 'Pembayaran ditolak.');
    });

    Route::get('/notifikasi', function () {
        $user = auth()->user();

        // Kumpulkan tipe yang dinonaktifkan user
        $tipeDisabled = [];
        if (!$user->notif_permintaan_jadwal) $tipeDisabled[] = 'les_privat';
        if (!$user->notif_pembayaran)        $tipeDisabled[] = 'pembayaran';
        if (!$user->notif_ulasan)            $tipeDisabled[] = 'ulasan';
        // notif_pengingat_sesi & notif_newsletter = tipe 'sistem'
        // hanya disable sistem jika keduanya off
        if (!$user->notif_pengingat_sesi && !$user->notif_newsletter) $tipeDisabled[] = 'sistem';

        // Kumpulkan tipe yang dinonaktifkan user
        $tipeDisabled = [];
        if (!$user->notif_permintaan_jadwal) $tipeDisabled[] = 'les_privat';
        if (!$user->notif_pembayaran)        $tipeDisabled[] = 'pembayaran';
        if (!$user->notif_ulasan) $tipeDisabled[] = 'sistem';

        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->when(count($tipeDisabled), fn($q) => $q->whereNotIn('tipe', $tipeDisabled))
            ->orderBy('created_at', 'desc')
            ->get();

        $jumlahBelumDibaca = $notifikasi->where('sudah_dibaca', false)->count();

        $hariIni   = $notifikasi->filter(fn($n) => $n->created_at->isToday());
        $kemarin   = $notifikasi->filter(fn($n) => $n->created_at->isYesterday());
        $mingguIni = $notifikasi->filter(
            fn($n) =>
            !$n->created_at->isToday() &&
                !$n->created_at->isYesterday() &&
                $n->created_at->diffInDays(now()) <= 7
        );
        $lebihLama = $notifikasi->filter(fn($n) => $n->created_at->diffInDays(now()) > 7);

        $perTipe = [
            'les_privat' => $notifikasi->where('tipe', 'les_privat')->count(),
            'pembayaran' => $notifikasi->where('tipe', 'pembayaran')->count(),
            'sistem'     => $notifikasi->where('tipe', 'sistem')->count(),
        ];

        return view('tutor.notifikasi', compact(
            'notifikasi',
            'jumlahBelumDibaca',
            'hariIni',
            'kemarin',
            'mingguIni',
            'lebihLama',
            'perTipe',
            'tipeDisabled'
        ));
    });

    Route::post('/notifikasi/tandai-semua', function () {
        Notifikasi::where('user_id', auth()->id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return back()->with('sukses', 'Semua notifikasi ditandai dibaca.');
    });

    Route::post('/notifikasi/{id}/buka', function ($id) {
        $notif = Notifikasi::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->tandaiDibaca();

        return redirect($notif->url_aksi ?? '/tutor/notifikasi');
    });

    Route::get('/profil', function () {
        $user = auth()->user();

        $totalSiswa = LesPrivat::where('tutor_id', $user->id)->distinct('user_id')->count();
        $totalSesi  = LesPrivat::where('tutor_id', $user->id)->whereIn('status', ['dikonfirmasi', 'selesai'])->count();
        $pengalaman = $user->tahun_mengajar ? (now()->year - $user->tahun_mengajar) : 0;

        // Data ulasan dari DB
        $ulasanList = \App\Models\Ulasan::where('tutor_id', $user->id)
            ->with('siswa')
            ->latest()
            ->get();

        $totalUlasan  = $ulasanList->count();
        $ratingRata   = $totalUlasan > 0 ? round($ulasanList->avg('bintang'), 1) : 0;

        // Distribusi bintang (persentase)
        $distribusi = [];
        for ($b = 5; $b >= 1; $b--) {
            $jumlah = $ulasanList->where('bintang', $b)->count();
            $distribusi[$b] = $totalUlasan > 0 ? round($jumlah / $totalUlasan * 100) : 0;
        }

        return view('tutor.profil', compact(
            'user',
            'totalSiswa',
            'totalSesi',
            'pengalaman',
            'ulasanList',
            'totalUlasan',
            'ratingRata',
            'distribusi'
        ));
    });
    Route::get('/profil', function () {
        $user = auth()->user();

        $totalSiswa = LesPrivat::where('tutor_id', $user->id)->distinct('user_id')->count();
        $totalSesi  = LesPrivat::where('tutor_id', $user->id)->whereIn('status', ['dikonfirmasi', 'selesai'])->count();
        $pengalaman = $user->tahun_mengajar ? (now()->year - $user->tahun_mengajar) : 0;

        // Data ulasan dari DB
        $ulasanList  = \App\Models\Ulasan::where('tutor_id', $user->id)->with('siswa')->latest()->get();
        $totalUlasan = $ulasanList->count();
        $ratingRata  = $totalUlasan > 0 ? round($ulasanList->avg('bintang'), 1) : 0;

        // Distribusi bintang
        $distribusi = [];
        for ($b = 5; $b >= 1; $b--) {
            $jumlah       = $ulasanList->where('bintang', $b)->count();
            $distribusi[$b] = $totalUlasan > 0 ? round($jumlah / $totalUlasan * 100) : 0;
        }

        return view('tutor.profil', compact(
            'user',
            'totalSiswa',
            'totalSesi',
            'pengalaman',
            'ulasanList',
            'totalUlasan',
            'ratingRata',
            'distribusi'
        ));
    });

    Route::post('/profil/update-info', function (Request $request) {
        $user = auth()->user();

        $request->validate([
            'name'           => 'required|string|max:100',
            'no_hp'          => 'nullable|string|max:20',
            'kota'           => 'nullable|string|max:100',
            'pendidikan'     => 'nullable|string|max:50',
            'jurusan'        => 'nullable|string|max:100',
            'tahun_mengajar' => 'nullable|integer|min:1990|max:' . now()->year,
            'mode_mengajar'  => 'nullable|string|max:50',
            'bio'            => 'nullable|string|max:500',
        ]);

        $user->update($request->only([
            'name',
            'no_hp',
            'kota',
            'pendidikan',
            'jurusan',
            'tahun_mengajar',
            'mode_mengajar',
            'bio',
        ]));

        return redirect('/tutor/profil')->with('sukses_info', 'Informasi pribadi berhasil diperbarui!');
    });

    Route::post('/profil/ganti-password', function (Request $request) {
        $user = auth()->user();

        $request->validate([
            'password_lama'              => 'required',
            'password_baru'              => 'required|min:8|confirmed',
            'password_baru_confirmation' => 'required',
        ], [
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_baru.min'       => 'Password baru minimal 8 karakter.',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password saat ini tidak sesuai.'])
                ->with('tab', 'keamanan');
        }

        $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password_baru)]);

        return redirect('/tutor/profil')->with('sukses_password', 'Password berhasil diubah!');
    });

    Route::post('/profil/upload-avatar', function (Request $request) {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect('/tutor/profil')->with('sukses_info', 'Foto profil berhasil diperbarui!');
    });
    Route::post('/profil/simpan-notifikasi', function (Request $request) {
        auth()->user()->update([
            'notif_permintaan_jadwal' => $request->boolean('notif_permintaan_jadwal'),
            'notif_pengingat_sesi'    => $request->boolean('notif_pengingat_sesi'),
            'notif_pembayaran'        => $request->boolean('notif_pembayaran'),
            'notif_ulasan'            => $request->boolean('notif_ulasan'),
            'notif_newsletter'        => $request->boolean('notif_newsletter'),
        ]);

        return back()->with('sukses_info', 'Pengaturan notifikasi berhasil disimpan!');
    });

    Route::post('/profil/simpan-keahlian', function (Request $request) {
        $request->validate([
            'mata_pelajaran'      => 'required|array|min:1',
            'mata_pelajaran.*'    => 'string|max:50',
            'jenjang'             => 'required|array|min:1',
            'jenjang.*'           => 'in:sd,smp,sma,perguruan_tinggi',
            'tarif_per_sesi'      => 'required|integer|min:0',
            'maks_siswa_per_hari' => 'required|integer|min:1|max:20',
        ]);

        auth()->user()->update([
            'mata_pelajaran_tutor' => $request->mata_pelajaran,
            'jenjang_tutor'        => $request->jenjang,
            'tarif_per_sesi'       => $request->tarif_per_sesi,
            'maks_siswa_per_hari'  => $request->maks_siswa_per_hari,
        ]);

        return redirect('/tutor/profil')->with('sukses_info', 'Keahlian & jadwal berhasil disimpan!');
    });
    // Route baru yang belum ada:
    Route::delete('/tutor/profil/nonaktifkan', [TutorProfilController::class, 'nonaktifkan']);
    Route::post('/tutor/profil/simpan-ketersediaan', [TutorProfilController::class, 'simpanKetersediaan']);
});
