<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $totalSiswa  = \App\Models\User::where('role', 'siswa')->count();
    $totalTutor  = \App\Models\User::where('role', 'tutor')->count();

    // Tingkat kepuasan: rata-rata bintang ulasan, dikonversi ke persen
    $ulasan      = \App\Models\Ulasan::all();
    $kepuasan    = $ulasan->count() > 0
        ? round(($ulasan->avg('bintang') / 5) * 100)
        : 98;

    // Paket harga dari DB, urutkan harga_min ascending
    $pakets      = \App\Models\Paket::orderBy('harga_min', 'asc')->get();

    // Testimoni dari DB: ulasan bintang >= 4, ambil 3
    $testimoni   = \App\Models\Ulasan::with(['siswa', 'lesPrivat'])
        ->whereNotNull('komentar')
        ->where('bintang', '>=', 4)
        ->latest()
        ->take(3)
        ->get();

    return view('landing.index', compact(
        'totalSiswa',
        'totalTutor',
        'kepuasan',
        'pakets',
        'testimoni',
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
