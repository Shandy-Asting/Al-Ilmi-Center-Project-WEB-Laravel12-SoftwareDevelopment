<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('landing.index');
});

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->middleware('auth');

Route::get('/tutor/dashboard', function () {
    return view('tutor.dashboard');
})->middleware('auth');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');