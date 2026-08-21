<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set bahasa untuk Carbon (untuk format hari/bulan seperti "Senin", "Januari")
        \Carbon\Carbon::setLocale(config('app.locale'));
        
        // Set locale PHP secara global (mempengaruhi fungsi date() bawaan jika digunakan)
        setlocale(LC_TIME, 'id_ID', 'id_ID.utf8', 'id_ID.UTF-8', 'Indonesian');
        
        // Pastikan timezone mengikuti konfigurasi aplikasi
        date_default_timezone_set(config('app.timezone'));
    }
}
