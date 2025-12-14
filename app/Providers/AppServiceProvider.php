<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Ép buộc dùng HTTPS nếu đang ở trên môi trường Production (Railway)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
