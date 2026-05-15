<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Models\HasilKuis;
use App\Models\LesPrivat;
use App\Models\Materi;
use App\Models\Soal;

Route::middleware(['auth', 'role:tutor'])->prefix('tutor')->group(function () {

    // ── Dashboard ──────────────────────────────────────────────────────────
    Route::get('/dashboard', function () {
        $user  = auth()->user();
        $today = now()->toDateString();

        $totalSiswa    = LesPrivat::where('tutor_id', $user->id)->distinct('user_id')->count();
        $sesiMingguIni = LesPrivat::where('tutor_id', $user->id)
            ->whereBetween('jadwal', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'dikonfirmasi')
            ->count();
        $totalMateri   = Materi::where('tutor_id', $user->id)->count();
        $totalSoal     = Soal::where('tutor_id', $user->id)->count();
        $jadwalHariIni = LesPrivat::where('tutor_id', $user->id)
            ->whereDate('jadwal', $today)
            ->where('status', 'dikonfirmasi')
            ->with('siswa')
            ->orderBy('jadwal', 'asc')
            ->get();

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
        LesPrivat::where('id', $id)
            ->where('tutor_id', auth()->id())
            ->where('status', 'dikonfirmasi')
            ->firstOrFail()
            ->update(['status' => 'selesai']);

        return redirect('/tutor/les-privat')->with('sukses', 'Sesi berhasil ditandai selesai!');
    });

    // ── Lainnya ────────────────────────────────────────────────────────────
    Route::get('/jadwal', fn () => view('tutor.jadwal'));

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

    Route::get('/notifikasi', fn () => view('tutor.notifikasi'));
    Route::get('/pembayaran', fn () => view('tutor.pembayaran'));
    Route::get('/profil',     fn () => view('tutor.profil'));
});