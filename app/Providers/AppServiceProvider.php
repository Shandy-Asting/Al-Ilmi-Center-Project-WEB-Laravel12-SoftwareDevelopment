<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (auth()->check()) {
                $view->with(
                    'jumlahNotifBelumDibaca',
                    Notifikasi::where('user_id', auth()->id())
                        ->where('sudah_dibaca', false)
                        ->count()
                );
            } else {
                $view->with('jumlahNotifBelumDibaca', 0);
            }
        });
    }
}