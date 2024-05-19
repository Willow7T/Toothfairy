<?php

namespace App\Providers\Filament;

//use App\Filament\App\Pages\Dashboard;
use App\Filament\Pages\Home;
use App\Filament\Resources\TreatmentResource;
use App\Filament\Resources\TreatmentResource\Pages\ViewTreatment;
use App\Http\Middleware\StoreSessionData;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Awcodes\LightSwitch\Enums\Alignment;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Rawilk\ProfileFilament\Features;
use Rawilk\ProfileFilament\ProfileFilamentPlugin;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('')
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
            //->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
           // ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
           ->resources([
                TreatmentResource::class,
            ]) 
           ->pages([
                Home::class,
                //ViewTreatment::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([])
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
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->sidebarWidth('16rem')
            ->maxContentWidth('7xl')
                //->sidebarFullyCollapsibleOnDesktop()
            ->topNavigation()
            ->breadcrumbs()
            ->plugins(
                [
                    LightSwitchPlugin::make()
                        ->position(Alignment::BottomCenter),
                    ThemesPlugin::make(),
                    BreezyCore::make()
                        ->avatarUploadComponent(
                            fn () =>
                            FileUpload::make('avatar_url')
                                ->avatar()
                                ->image()
                                ->imageEditor()
                                ->circleCropper()
                                ->label('Profile Picture')
                                ->directory('avatars')
                                ->multiple(false)
                                ->maxSize(1024)
                        )
                        ->myProfile(
                            hasAvatars: true,
                            slug: 'profile/info',

                        )->withoutMyProfileComponents([
                            'update_password'
                        ]),
                    ProfileFilamentPlugin::make()
                        ->usingClusterSlug('profile')
                        ->profile(
                            enabled: false,
                        )
                        ->accountSettings(
                            slug: 'account',
                        )
                        ->features(
                            Features::defaults()
                                ->twoFactorAuthentication(
                                    enabled: true,
                                    authenticatorApps: true,
                                    webauthn: false,
                                )
                        )
                ]
            );
    }
}
