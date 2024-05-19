<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rawilk\ProfileFilament\Facades\Webauthn;
use Filament\Support\Assets\Css;
use Rawilk\ProfileFilament\Features;
use App\Models\AppointmentTreatment;
use App\Models\PurchaselogItem;
use App\Observers\AppointmentTreatmentObserver;
use App\Observers\PurchaselogObserver;
use Filament\Support\Facades\FilamentAsset;


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
                ->usePasskeys(false);
        });
        AppointmentTreatment::observe(AppointmentTreatmentObserver::class);
        PurchaselogItem::observe(PurchaselogObserver::class);
        FilamentAsset::register([
            Css::make('customapp', __DIR__ . '/../../public/build/assets/app.css')->loadedOnRequest(),
        ]);
    }
}
// public/build/assets/app.css