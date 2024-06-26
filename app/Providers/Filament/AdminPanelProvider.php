<?php

namespace App\Providers\Filament;

//use App\Livewire\CustomProfileInfo;

use App\Filament\Resources;
use App\Filament\Pages;
use App\Filament\Widgets\ExpenseChart;
use App\Filament\Widgets\IncomeChart;
use App\Filament\Widgets\SummaryChart;
use App\Filament\Widgets\SummaryStat;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
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
use Filament\Pages\Dashboard;
use Hasnayeen\Themes\ThemesPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;

class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        $appName = env('APP_NAME', 'Tooth Fairy');
        $appName = preg_replace_callback('/([A-Z0-9])/', function ($match) {
            return ' ' . $match[0];
        }, $appName);
        $brandname = strtoupper($appName);
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
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

            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder
                    ->items([
                        //navigation for dashboard
                        NavigationItem::make('dashboard')
                            ->label('Dashboard')
                            ->icon('heroicon-o-home')
                            ->url(fn (): string => Pages\Dashboard::getUrl())
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                            ->sort(0),
                    ])
                    ->groups([
                        NavigationGroup::make('People')
                            ->items([
                                NavigationItem::make('dentist')
                                    ->label('Dentists')
                                    ->icon('healthicons-o-doctor-male')
                                    ->url(fn (): string => Resources\DentistResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\DentistResource::getRoutePrefix() . '.*'))->sort(0),
                                NavigationItem::make('patient')
                                    ->label('Patients')
                                    ->icon('ri-contacts-book-3-line')
                                    ->url(fn (): string => Resources\PatientResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\PatientResource::getRoutePrefix() . '.*'))->sort(1),
                            ]),
                        NavigationGroup::make('Items')
                            ->items([
                                NavigationItem::make('treatment')
                                    ->label('Treatments')
                                    ->url(fn (): string => Resources\TreatmentResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\TreatmentResource::getRoutePrefix() . '.*'))
                                    ->icon('ri-health-book-line')
                                    ->sort(0),
                                NavigationItem::make('lab')
                                    ->label('Labs')
                                    ->url(fn (): string => Resources\LabResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\LabResource::getRoutePrefix() . '.*'))
                                    ->icon('fluentui-dentist-16-o')
                                    ->sort(1),
                                NavigationItem::make('item')
                                    ->label('Lab Items')
                                    ->url(fn (): string => Resources\ItemResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\ItemResource::getRoutePrefix() . '.*'))
                                    ->icon('fluentui-toolbox-24-o')
                                    ->sort(2),
                            ]),
                        NavigationGroup::make('Transactions')
                            ->items([
                                NavigationItem::make('appointment')
                                    ->label('Appointments')
                                    ->icon('vaadin-dental-chair')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\AppointmentResource::getRoutePrefix() . '.*'))
                                    ->url(fn (): string => Resources\AppointmentResource::getUrl())
                                    ->sort(0),
                                NavigationItem::make('purchaselog')
                                    ->label('Expenses')
                                    ->icon('heroicon-o-shopping-cart')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\PurchaselogResource::getRoutePrefix() . '.*'))
                                    ->url(fn (): string => Resources\PurchaselogResource::getUrl())
                                    ->sort(1),
                            ]),

                        NavigationGroup::make('Page Control')
                            ->items([
                                NavigationItem::make('home')
                                    ->label('Home Assets')
                                    ->icon('heroicon-o-home')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\HomeassetResource::getRoutePrefix() . '.*'))
                                    ->url(fn (): string => Resources\HomeassetResource::getUrl())
                                    ->sort(0),
                                NavigationItem::make('cards')
                                    ->label('Cards')
                                    ->icon('heroicon-c-window')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\CardResource::getRoutePrefix() . '.*'))
                                    ->url(fn (): string => Resources\CardResource::getUrl())
                                    ->sort(1),
                                NavigationItem::make('Faqs')
                                    ->label('Faqs')
                                    ->icon('heroicon-o-question-mark-circle')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\FaqResource::getRoutePrefix() . '.*'))
                                    ->url(fn (): string => Resources\FaqResource::getUrl())
                                    ->sort(2),
                                NavigationItem::make('About Us')
                                    ->label('About Us')
                                    ->icon('heroicon-o-exclamation-circle')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.' . Resources\AboutResource::getRoutePrefix() . '.*'))
                                    ->url(fn (): string => Resources\AboutResource::getUrl())
                                    ->sort(3),
                            ]),
                    ]);
            })
            ->userMenuItems([
                'Settings' => MenuItem::make()->label('Settings')
                    ->icon('heroicon-o-cog')
                    ->sort(0)
                    ->url(fn (): string => Settings::getUrl()),
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                SummaryStat::class,
                SummaryChart::class,
                IncomeChart::class,
                ExpenseChart::class,
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
