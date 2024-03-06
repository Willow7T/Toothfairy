<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rawilk\ProfileFilament\Facades\Webauthn;
use Rawilk\ProfileFilament\Features;

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
        Features::defaults(function () {
            return Features::make()
                ->usePasskeys(false)
                ;
        });
    }
}
