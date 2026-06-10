<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $totalSiswa  = \App\Models\User::where('role', 'siswa')->count();
    $totalTutor  = \App\Models\User::where('role', 'tutor')->count();

    $ulasan      = \App\Models\Ulasan::all();
    $kepuasan    = $ulasan->count() > 0
        ? round(($ulasan->avg('bintang') / 5) * 100)
        : 98;

    $pakets      = \App\Models\Paket::orderBy('harga_min', 'asc')->get();

    $testimoni   = \App\Models\Ulasan::with(['siswa', 'lesPrivat'])
        ->whereNotNull('komentar')
        ->where('bintang', '>=', 4)
        ->latest()
        ->take(3)
        ->get();

    // Hero card
    $progresHero = DB::table('hasil_latihan')
        ->select('mata_pelajaran', DB::raw('ROUND(AVG(nilai), 1) as rata_nilai'))
        ->where('created_at', '>=', now()->startOfWeek())
        ->groupBy('mata_pelajaran')
        ->orderByDesc('rata_nilai')
        ->limit(4)
        ->get();

    $rataRataGlobal = round(
        DB::table('hasil_latihan')
            ->where('created_at', '>=', now()->startOfWeek())
            ->avg('nilai') ?? 0,
        1
    );

    return view('landing.index', compact(
        'totalSiswa',
        'totalTutor',
        'kepuasan',
        'pakets',
        'testimoni',
        'progresHero',
        'rataRataGlobal',
    ));
});

/*
|--------------------------------------------------------------------------
| Auth (Livewire)
|--------------------------------------------------------------------------
*/

Route::get('/login',    \App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');

Route::post('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Role Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/siswa.php';
require __DIR__ . '/tutor.php';
require __DIR__ . '/admin.php';