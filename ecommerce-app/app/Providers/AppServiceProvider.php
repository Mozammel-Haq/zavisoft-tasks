<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any app services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any app services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addDays(10));
        Passport::refreshTokensExpireIn(now()->addDays(15));
        Passport::personalAccessTokensExpireIn(now()->addMonths(1));
        Passport::viewPrefix('passport');
    }
}
