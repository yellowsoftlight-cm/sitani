<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Gunakan tampilan paginasi kustom bertema SiTani (bukan Tailwind bawaan),
        // supaya tampilannya konsisten dengan seluruh halaman lain.
        Paginator::defaultView('vendor.pagination.sitani');
    }
}
