<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Resources\TreatmentResource;
use App\Filament\Dentist\Resources\AppointmentResource;
use App\Filament\Pages;
use App\Filament\Resources\PatientResource;
use Filament\Panel;
use App\Filament\Widgets\ExpenseChart;
use App\Filament\Widgets\IncomeChart;
use App\Filament\Widgets\IncomeDent;
use App\Filament\Widgets\SummaryChart;
use App\Filament\Widgets\SummaryDent;
use App\Filament\Widgets\SummaryStat;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\FileUpload;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\StoreSessionData;
use App\Livewire\CustomProfileComponentD;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Rawilk\ProfileFilament\ProfileFilamentPlugin;
use Rawilk\ProfileFilament\Features;
use Rawilk\ProfileFilament\Filament\Clusters\Profile\Settings;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Awcodes\LightSwitch\Enums\Alignment;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Hasnayeen\Themes\ThemesPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;

class DentistPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $appName = env('APP_NAME', 'Tooth Fairy');
        $appName = preg_replace_callback('/([A-Z0-9])/', function ($match) {
            return ' ' . $match[0];
        }, $appName);
        $brandname = strtoupper($appName);

        return $panel
            ->id('dentist')
            ->path('dentist')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                AppointmentResource::class,
                PatientResource::class,
                TreatmentResource::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('dashboard')
                        ->label('Dashboard')
                        ->icon('heroicon-o-home')
                        ->url(fn (): string => Pages\Dashboard::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.dentist.pages.dashboard'))
                        ->sort(0),
                    NavigationItem::make('treatment')
                        ->label('Treatments')
                        ->url(fn (): string => TreatmentResource::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.dentist.resources.' . TreatmentResource::getRoutePrefix() . '.*'))
                        ->icon('ri-health-book-line')
                        ->sort(1),
                    NavigationItem::make('patient')
                        ->label('Patients')
                        ->icon('ri-contacts-book-3-line')
                        ->url(fn (): string => PatientResource::getUrl())
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.dentist.resources.' . PatientResource::getRoutePrefix() . '.*'))
                        ->sort(2),
                    NavigationItem::make('appointment')
                        ->label('Appointments')
                        ->icon('vaadin-dental-chair')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.dentist.resources.' . AppointmentResource::getRoutePrefix() . '.*'))
                        ->url(fn (): string => AppointmentResource::getUrl())
                        ->sort(3),
                ]);
            })
            ->widgets([
                SummaryDent::class,
                IncomeDent::class,
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
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarWidth('16rem')
            ->maxContentWidth('7xl')
            ->sidebarCollapsibleOnDesktop()
            ->font('Fira Code')
            ->favicon('uploads/Favicon.png')
            ->brandName($brandname)
            ->userMenuItems([
                'Settings' => MenuItem::make()->label('Settings')
                    ->icon('heroicon-o-cog')
                    ->sort(0)
                    ->url(fn (): string => Settings::getUrl()),
            ])
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

                        )
                        ->myProfileComponents([CustomProfileComponentD::class])
                        ->withoutMyProfileComponents([
                            'update_password'
                        ]),
                    ProfileFilamentPlugin::make()
                        //->usingRootProfilePage(Settings::class)
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
