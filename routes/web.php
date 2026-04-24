<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
});
Route::get('/siswa/belajar-tka', function () {
    return view('siswa.belajar-tka');
});
Route::get('/siswa/les-privat', function () {
    return view('siswa.les-privat');
});
Route::get('/siswa/hasil-progres', function () {
    return view('siswa.hasil-progres');
});
Route::get('/siswa/pembayaran', function () {
    return view('siswa.pembayaran');
});
Route::get('/siswa/profil', function () {
    return view('siswa.profil');
});

// ── TUTOR ──
Route::get('/tutor/dashboard', function () {
    return view('tutor.dashboard');
});
Route::get('/tutor/materi', function () {
    return view('tutor.materi');
});
Route::get('/tutor/soal', function () {
    return view('tutor.soal');
});
Route::get('/tutor/jadwal', function () {
    return view('tutor.jadwal');
});
Route::get('/tutor/les-privat', function () {
    return view('tutor.les-privat');
});
Route::get('/tutor/profil', function () {
    return view('tutor.profil');
});

// ── ADMIN ──
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/admin/pengguna', function () {
    return view('admin.pengguna');
});
Route::get('/admin/paket', function () {
    return view('admin.paket');
});
Route::get('/admin/transaksi', function () {
    return view('admin.transaksi');
});
Route::get('/admin/laporan', function () {
    return view('admin.laporan');
});