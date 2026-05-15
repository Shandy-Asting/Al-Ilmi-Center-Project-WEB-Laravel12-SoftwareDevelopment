<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('landing.index'));

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