<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Passport\Client;
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

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            // Passport::loadKeysFrom(storage_path());
        }
        Passport::tokensExpireIn(now()->addDays(10));
        Passport::refreshTokensExpireIn(now()->addDays(15));
        Passport::personalAccessTokensExpireIn(now()->addMonths(1));
        Passport::viewPrefix('passport');
        Passport::useClientModel(Client::class);
    }
}
