<?php

namespace App\Providers;

use App\Filament\Pages\Home;
use App\Models\About;
use Illuminate\Support\ServiceProvider;
use Rawilk\ProfileFilament\Facades\Webauthn;
use Filament\Support\Assets\Css;
use Rawilk\ProfileFilament\Features;
use App\Models\AppointmentTreatment;
use App\Models\Card;
use App\Models\Homeasset;
use App\Models\PurchaselogItem;
use App\Models\Treatment;
use App\Observers\AboutObserver;
use App\Observers\AppointmentTreatmentObserver;
use App\Observers\CardObserver;
use App\Observers\HomeObserver;
use App\Observers\PurchaselogObserver;
use App\Observers\TreatmentObserver;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Blade;

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
        About::observe(AboutObserver::class);
        Card::observe(CardObserver::class);
        Homeasset::observe(HomeObserver::class);
        PurchaselogItem::observe(PurchaselogObserver::class);
        Treatment::observe(TreatmentObserver::class);
        Blade::directive('safeSvg', function ($expression) {
            return "<?php try { echo svg({$expression})->toHtml(); } catch (\Exception \$e) { echo svg('heroicon-o-x-mark', 'h-6 w-6 text-primary-600 dark:text-primary-500')->toHtml(); } ?>";
        });
        Blade::directive('safeSvgW', function ($expression) {
            return "<?php try { echo svg({$expression})->toHtml(); } catch (\Exception \$e) { echo svg('heroicon-o-x-mark', 'h-6 w-6 text-rose-600 dark:text-rose-500')->toHtml(); } ?>";
        });
        FilamentAsset::register([
            Css::make('final_2.2', __DIR__ . '/../../public/build/assets/app.css')->loadedOnRequest(),
        ]);
    }
}
// public/build/assets/app.css