<?php

namespace App\Providers\Filament;

//use App\Livewire\CustomProfileInfo;

use App\Filament\Resources;
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
use Rawilk\ProfileFilament\Filament\Clusters\Profile\Settings;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Awcodes\LightSwitch\Enums\Alignment;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Hasnayeen\Themes\ThemesPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            //->registration()
            ->unsavedChangesAlerts(0)
            ->colors([
                'primary' => Color::Indigo,
                'secondary' => Color::Gray,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([

                NavigationGroup::make()
                    ->label('People'),
                NavigationGroup::make()
                    ->label('Items'),
                NavigationGroup::make()
                    ->label('Transactions'),

            ])
            ->navigationItems([
                // NavigationItem::make('Analytics')
                //     ->url('https://filament.pirsch.io', shouldOpenInNewTab: true)
                //     ->icon('heroicon-o-presentation-chart-line')
                //     ->group('Reports')
                //     ->sort(3),
                NavigationItem::make('dashboard')
                    ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                    ->icon('heroicon-o-home')
                    ->url(fn (): string => Dashboard::getUrl())
                    ->isActiveWhen(fn () => request()->routeIs('filament.admin.pages.dashboard')),

                NavigationItem::make('dentist')
                    ->label('Dentists')
                    ->icon('healthicons-o-doctor-male')
                    ->url(fn (): string => Resources\DentistResource::getUrl())
                    ->group('People')
                    ->sort(0),
                NavigationItem::make('patient')
                    ->label('Patients')
                    ->icon('ri-contacts-book-3-line')
                    ->url(fn (): string => Resources\PatientsResource::getUrl())
                    ->group('People')
                    ->sort(1),
                    // NavigationItem::make('paitent.create')
                    // ->label('Create Patient')
                    // ->icon('ri-contacts-book-3-line')
                    // ->group('People')
                    // ->url(fn (): string => Resources\PatientsResource\Pages\CreatePatients::getUrl()),

                NavigationItem::make('lab')
                    ->label('Labs')
                    ->url(fn (): string => Resources\LabResource::getUrl())
                    ->group('Items')
                    ->icon('fluentui-dentist-16-o') 
                    ->sort(1),
                NavigationItem::make('item')
                    ->label('Lab Items')
                    ->url(fn (): string => Resources\ItemResource::getUrl())
                    ->group('Items')
                    ->icon('fluentui-toolbox-24-o')
                    ->sort(2),
                NavigationItem::make('treatment')
                    ->label('Treatments')
                    ->url(fn (): string => Resources\TreatmentResource::getUrl())
                    ->icon('ri-health-book-line')
                    ->group('Items')
                    ->sort(0),

                NavigationItem::make('appointment')
                    ->label('Appointments')
                    ->icon('vaadin-dental-chair')
                    ->url(fn (): string => Resources\AppointmentResource::getUrl())
                    ->group('Transactions')
                    ->sort(0),
                    NavigationItem::make('purchaselog')
                    ->label('Expenses')
                    ->icon('heroicon-o-shopping-cart')
                    ->url(fn (): string => Resources\PurchaselogResource::getUrl())
                    ->group('Transactions')
                    ->sort(1),


            ])
            ->userMenuItems([
                'Settings' => MenuItem::make()->label('Settings')
                    ->icon('heroicon-o-cog')
                    ->sort(0)
                    ->url(fn (): string => Settings::getUrl()),
            ])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->sidebarWidth('16rem')
            ->maxContentWidth('7xl')
            ->sidebarCollapsibleOnDesktop()
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
