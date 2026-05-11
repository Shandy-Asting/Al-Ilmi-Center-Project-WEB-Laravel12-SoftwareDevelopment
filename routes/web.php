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
            'namaUser' => $user->name,
            'rataRataNilai' => $rataRataNilai,
            'soalDiselesaikan' => $soalDiselesaikan,
            'jamBelajar' => $jamBelajar,
            'lesPrivat' => $lesPrivat,
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
    // Ambil soal berdasarkan materi
    Route::get('/belajar-tka/{materi_id}/soal', function ($materi_id) {
        $user = auth()->user();
        $materi = \App\Models\Materi::with('soal')->findOrFail($materi_id);
        $soal = $materi->soal()->inRandomOrder()->take(15)->get();
        $hasilSebelumnya = \App\Models\HasilKuis::where('user_id', $user->id)
            ->where('materi_id', $materi_id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('siswa.latihan-soal', [
            'materi' => $materi,
            'soal' => $soal,
            'hasilSebelumnya' => $hasilSebelumnya,
        ]);
    });

    // Submit jawaban
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
                'soal_id' => $soalId,
                'pertanyaan' => $soal->pertanyaan,
                'jawaban_siswa' => $jawabanSiswa,
                'jawaban_benar' => $soal->jawaban_benar,
                'benar' => $benar,
                'pembahasan' => $soal->pembahasan,
            ];
        }

        $totalSoal = count($jawaban);
        $nilai = $totalSoal > 0 ? round(($soalBenar / $totalSoal) * 100) : 0;
        $durasi = $request->input('durasi_menit', 0);

        $hasilId = (string) \Illuminate\Support\Str::uuid();

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
            'user_id' => $user->id,
            'mata_pelajaran' => $materi->mata_pelajaran,
            'nilai' => $nilai,
            'jumlah_soal' => $totalSoal,
            'soal_benar' => $soalBenar,
            'durasi_menit' => $durasi,
        ]);

        \App\Models\AktivitasBelajar::create([
            'user_id' => $user->id,
            'tanggal' => now()->toDateString(),
            'durasi_menit' => $durasi,
            'mata_pelajaran' => $materi->mata_pelajaran,
        ]);

        return redirect('/siswa/belajar-tka/' . $materi_id . '/hasil/' . $hasilId);
    });

    // Lihat hasil kuis
    Route::get('/belajar-tka/{materi_id}/hasil/{hasil_id}', function ($materi_id, $hasil_id) {
        $materi = \App\Models\Materi::findOrFail($materi_id);
        $hasil = \App\Models\HasilKuis::findOrFail($hasil_id);
        return view('siswa.hasil-kuis', [
            'materi' => $materi,
            'hasil' => $hasil,
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

    // POST pesan les (dari form di les-privat)
    Route::post('/les-privat/pesan', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'tutor_id'      => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'topik'         => 'nullable|string|max:255',
            'catatan'       => 'nullable|string',
            'jadwal'        => 'required|date|after:now',
            'durasi_menit'  => 'required|in:60,90,120',
            'mode'          => 'required|in:online,tatap_muka',
            'lokasi'        => 'nullable|string',
        ]);

        $tutor = \App\Models\User::findOrFail($request->tutor_id);

        // Cek bentrok jadwal tutor
        $bentrok = \App\Models\LesPrivat::where('tutor_id', $request->tutor_id)
            ->where('status', 'dikonfirmasi')
            ->whereRaw("ABS(TIMESTAMPDIFF(MINUTE, jadwal, ?)) < durasi_menit", [$request->jadwal])
            ->exists();

        if ($bentrok) {
            return back()->withErrors(['jadwal' => 'Tutor sudah memiliki sesi di waktu tersebut.'])->withInput();
        }

        // Harga dasar berdasarkan durasi
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

    // Batalkan pesanan (siswa)
    Route::post('/les-privat/{id}/batalkan', function ($id) {
        $les = \App\Models\LesPrivat::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu') // hanya bisa batalkan jika masih menunggu
            ->firstOrFail();

        $les->update(['status' => 'dibatalkan']);

        return redirect('/siswa/les-privat')
            ->with('sukses', 'Pesanan berhasil dibatalkan.');
    });

    // Detail pesanan (siswa)
    Route::get('/les-privat/{id}', function ($id) {
        $les = \App\Models\LesPrivat::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('tutor')
            ->firstOrFail();

        return response()->json($les); // untuk AJAX di modal
    });
    Route::get('/hasil-progres', function () {
        $user = auth()->user();
        $rataRataNilai = round(\App\Models\HasilLatihan::where('user_id', $user->id)->avg('nilai') ?? 0);
        $soalDiselesaikan = \App\Models\HasilLatihan::where('user_id', $user->id)->sum('soal_benar') ?? 0;
        $jamBelajar = round(\App\Models\AktivitasBelajar::where('user_id', $user->id)->sum('durasi_menit') / 60, 1) ?? 0;
        $hasilLatihan = \App\Models\HasilLatihan::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('siswa.hasil-progres', [
            'rataRataNilai' => $rataRataNilai,
            'soalDiselesaikan' => $soalDiselesaikan,
            'jamBelajar' => $jamBelajar,
            'hasilLatihan' => $hasilLatihan,
        ]);
    });
    Route::get('/hasil-progres/export-excel', function () {
        $user = auth()->user();
        return Excel::download(
            new \App\Exports\HasilBelajarExport($user->id),
            'laporan-hasil-belajar-' . now()->format('d-m-Y') . '.xlsx'
        );
    });
    Route::get('/hasil-progres/export-pdf', function () {
        $user = auth()->user();
        $hasilLatihan = \App\Models\HasilLatihan::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('siswa.laporan-pdf', [
            'user' => $user,
            'hasilLatihan' => $hasilLatihan,
        ]);
        return $pdf->download('laporan-hasil-belajar-' . now()->format('d-m-Y') . '.pdf');
    });
    Route::get('/notifikasi', function () {
        return view('siswa.notifikasi');
    });
    Route::get('/pembayaran', function () {
        return view('siswa.pembayaran');
    });
    Route::get('/profil', function () {
        return view('siswa.profil');
    });
    Route::get('/pesan-jadwal', function () {
        $tutors = \App\Models\User::where('role', 'tutor')->get();
        $paketDipilih = session('paket_dipilih');
        return view('siswa.pesan-jadwal', [
            'tutors' => $tutors,
            'paketDipilih' => $paketDipilih,
        ]);
    });
    Route::post('/pesan-jadwal', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'jadwal' => 'required|date',
            'mode' => 'required|in:online,tatap_muka',
        ]);

        \App\Models\LesPrivat::create([
            'user_id' => auth()->user()->id,
            'tutor_id' => $request->tutor_id,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jadwal' => $request->jadwal,
            'status' => 'menunggu',
            'mode' => $request->mode,
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
