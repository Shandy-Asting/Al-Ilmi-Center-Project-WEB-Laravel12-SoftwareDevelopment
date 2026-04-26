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
        $materi = \App\Models\Materi::where('status', 'aktif')->get();
        return view('siswa.belajar-tka', ['materi' => $materi]);
    });
    Route::get('/les-privat', function () { return view('siswa.les-privat'); });
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
    Route::get('/pembayaran', function () { return view('siswa.pembayaran'); });
    Route::get('/profil', function () { return view('siswa.profil'); });
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
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $today = now()->toDateString();

        $totalSiswa = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->distinct('user_id')->count();

        $sesiMingguIni = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->whereBetween('jadwal', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'dikonfirmasi')
            ->count();

        $totalMateri = \App\Models\Materi::where('tutor_id', $user->id)->count();
        $totalSoal = \App\Models\Soal::where('tutor_id', $user->id)->count();

        $jadwalHariIni = \App\Models\LesPrivat::where('tutor_id', $user->id)
            ->whereDate('jadwal', $today)
            ->where('status', 'dikonfirmasi')
            ->with('siswa')
            ->orderBy('jadwal', 'asc')
            ->get();

        return view('tutor.dashboard', [
            'namaUser' => $user->name,
            'totalSiswa' => $totalSiswa,
            'sesiMingguIni' => $sesiMingguIni,
            'totalMateri' => $totalMateri,
            'totalSoal' => $totalSoal,
            'jadwalHariIni' => $jadwalHariIni,
            'tanggalHariIni' => now()->translatedFormat('d M Y'),
        ]);
    });
    Route::get('/materi', function () {
        $materi = \App\Models\Materi::where('tutor_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('tutor.materi', ['materi' => $materi]);
    });
    Route::post('/materi', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'judul' => 'required|string',
            'jenjang' => 'required|in:sd,smp,sma',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);
        \App\Models\Materi::create([
            'tutor_id' => auth()->user()->id,
            'judul' => $request->judul,
            'jenjang' => $request->jenjang,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);
        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil ditambahkan!');
    });
    Route::delete('/materi/{id}', function ($id) {
        \App\Models\Materi::findOrFail($id)->delete();
        return redirect('/tutor/materi')->with('sukses', 'Materi berhasil dihapus!');
    });
    Route::get('/soal', function () {
        $soal = \App\Models\Soal::where('tutor_id', auth()->user()->id)->with('materi')->orderBy('created_at', 'desc')->get();
        $materi = \App\Models\Materi::where('tutor_id', auth()->user()->id)->get();
        return view('tutor.soal', ['soal' => $soal, 'materi' => $materi]);
    });
    Route::post('/soal', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'materi_id' => 'required|exists:materi,id',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
            'pembahasan' => 'nullable|string',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
        ]);
        \App\Models\Soal::create([
            'materi_id' => $request->materi_id,
            'tutor_id' => auth()->user()->id,
            'pertanyaan' => $request->pertanyaan,
            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,
            'jawaban_benar' => $request->jawaban_benar,
            'pembahasan' => $request->pembahasan,
            'tingkat_kesulitan' => $request->tingkat_kesulitan,
        ]);
        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil ditambahkan!');
    });
    Route::delete('/soal/{id}', function ($id) {
        \App\Models\Soal::findOrFail($id)->delete();
        return redirect('/tutor/soal')->with('sukses', 'Soal berhasil dihapus!');
    });
    Route::get('/jadwal', function () { return view('tutor.jadwal'); });
    Route::get('/les-privat', function () {
        $pesanan = \App\Models\LesPrivat::where('tutor_id', auth()->user()->id)
            ->with('siswa')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('tutor.les-privat', ['pesanan' => $pesanan]);
    });
    Route::post('/les-privat/{id}/terima', function ($id) {
        $les = \App\Models\LesPrivat::findOrFail($id);
        $les->update(['status' => 'dikonfirmasi']);
        return redirect('/tutor/les-privat')->with('sukses', 'Pesanan berhasil diterima!');
    });
    Route::post('/les-privat/{id}/tolak', function ($id) {
        $les = \App\Models\LesPrivat::findOrFail($id);
        $les->update(['status' => 'dibatalkan']);
        return redirect('/tutor/les-privat')->with('sukses', 'Pesanan berhasil ditolak!');
    });
    Route::get('/profil', function () { return view('tutor.profil'); });
});

// ── ADMIN ──
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); });
    Route::get('/pengguna', function () { return view('admin.pengguna'); });
    Route::get('/paket', function () { return view('admin.paket'); });
    Route::get('/transaksi', function () { return view('admin.transaksi'); });
    Route::get('/laporan', function () { return view('admin.laporan'); });
});