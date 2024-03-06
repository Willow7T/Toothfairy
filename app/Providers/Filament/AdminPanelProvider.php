<?php

namespace App\Providers\Filament;

//use App\Livewire\CustomProfileInfo;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Forms\Components\FileUpload;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\StoreSessionData;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Rawilk\ProfileFilament\ProfileFilamentPlugin;
use Rawilk\ProfileFilament\Features;
use Rawilk\ProfileFilament\Filament\Clusters\Profile\Security;
use Rawilk\ProfileFilament\Filament\Clusters\Profile\Settings;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Indigo,
                'secondary' => Color::Gray,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                StoreSessionData::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins(
                [BreezyCore::make()
                ->avatarUploadComponent(fn() => 
                FileUpload::make('avatar_url')
                ->imageEditor()
                ->avatar()
                ->multiple(false)
                )
                ->myProfile(
                    hasAvatars: true,
                    slug: 'profile/info',
                    
                )->withoutMyProfileComponents([
                    'update_password'
                ]),


                 ProfileFilamentPlugin::make()
                 ->usingRootProfilePage(Settings::class)
                 ->profile(
                   enabled: false,
                 )
                ->features(
                    Features::defaults()
                    ->twoFactorAuthentication(
                        enabled: true,
                        authenticatorApps: true,
                        webauthn: false,
                        
                    )
                )
            
            ])
            // ->plugin(
            //     BreezyCore::make()
            //     ->myProfile(
            //         hasAvatars: false,
            //     )
            // )
                  
    ;}
}

