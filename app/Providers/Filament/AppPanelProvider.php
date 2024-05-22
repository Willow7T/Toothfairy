<?php

namespace App\Providers\Filament;

//use App\Filament\App\Pages\Dashboard;

use App\Filament\App\Resources\AppointmentResource;
use App\Filament\Pages\AboutUs;
use App\Filament\Pages\FAQs;
use App\Filament\Pages\Gallery;
use App\Filament\Pages\Home;
use App\Filament\Resources\TreatmentResource;
use App\Http\Middleware\StoreSessionData;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Awcodes\LightSwitch\Enums\Alignment;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
        // dd(Gallery::getRouteName());
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
                AppointmentResource::class,

                TreatmentResource::class,
            ])
            ->pages([
                Home::class,
                Gallery::class,
                FAQs::class,
                AboutUs::class,
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
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Home')
                        ->icon('heroicon-o-home')
                        ->url(fn (): string => Home::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs(Home::getRouteName()))
                        ->sort(0),

                    NavigationItem::make('Treatment')
                        ->icon('ri-health-book-line')
                        ->url(fn (): string => TreatmentResource::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.app.resources.' . TreatmentResource::getRoutePrefix(). '.*'))
                        ->sort(1),
                    NavigationItem::make('Gallery')
                        ->icon('vaadin-picture')
                        ->url(fn (): string => Gallery::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs(Gallery::getRouteName()))
                        ->sort(2),
                    NavigationItem::make('FAQs')
                        ->icon('heroicon-o-question-mark-circle')
                        ->url(fn (): string => FAQs::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs(FAQs::getRouteName()))
                        ->sort(3),
                    NavigationItem::make('Appointment')
                        ->icon('heroicon-o-book-open')
                        ->url(fn (): string => AppointmentResource::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.app.resources.' . AppointmentResource::getRoutePrefix() . '.*'))
                        ->sort(4),
                    NavigationItem::make('About Us')
                        ->icon('heroicon-o-exclamation-circle')
                        ->url(fn (): string => AboutUs::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs(AboutUs::getRouteName()))
                        ->sort(5),


                ]);
            })
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
