<?php

namespace App\Providers\Filament;

//use App\Livewire\CustomProfileInfo;

use App\Filament\Resources;
use App\Filament\Widgets\ExpenseChart;
use App\Filament\Widgets\IncomeChart;
use App\Filament\Widgets\SummaryChart;
use App\Filament\Widgets\SummaryStat;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
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
use Filament\Widgets\Widget;
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
                return $builder->groups([
            
                    NavigationGroup::make('People')
                        ->items([
                            NavigationItem::make('dentist')
                                ->label('Dentists')
                                ->icon('healthicons-o-doctor-male')
                                ->url(fn (): string => Resources\DentistResource::getUrl())
                                ->sort(0),
                            NavigationItem::make('patient')
                                ->label('Patients')
                                ->icon('ri-contacts-book-3-line')
                                ->url(fn (): string => Resources\PatientsResource::getUrl())
                                ->sort(1),
                        ]),
                    NavigationGroup::make('Items')
                        ->items([
                            NavigationItem::make('treatment')
                                ->label('Treatments')
                                ->url(fn (): string => Resources\TreatmentResource::getUrl())
                                ->icon('ri-health-book-line')
                                ->sort(0),
                            NavigationItem::make('lab')
                                ->label('Labs')
                                ->url(fn (): string => Resources\LabResource::getUrl())
                                ->icon('fluentui-dentist-16-o')
                                ->sort(1),
                            NavigationItem::make('item')
                                ->label('Lab Items')
                                ->url(fn (): string => Resources\ItemResource::getUrl())
                                ->icon('fluentui-toolbox-24-o')
                                ->sort(2),
                        ]),
                    NavigationGroup::make('Transactions')
                        ->items([
                            NavigationItem::make('appointment')
                                ->label('Appointments')
                                ->icon('vaadin-dental-chair')
                                ->url(fn (): string => Resources\AppointmentResource::getUrl())
                                ->sort(0),
                            NavigationItem::make('purchaselog')
                                ->label('Expenses')
                                ->icon('heroicon-o-shopping-cart')
                                ->url(fn (): string => Resources\PurchaselogResource::getUrl())
                                ->sort(1),
                        ]),

                        NavigationGroup::make('Page Control')
                        ->items([
                        NavigationItem::make('home')
                                ->label('Home')
                                ->icon('heroicon-o-home')
                                ->url(fn (): string => Resources\HomeassetResource::getUrl())
                                ->sort(0),
                            NavigationItem::make('cards')
                                ->label('Cards')
                                ->icon('heroicon-c-window')
                                ->url(fn (): string => Resources\CardResource::getUrl())
                                ->sort(1),
                            NavigationItem::make('Faqs')
                                ->label('Faqs')
                                ->icon('heroicon-o-question-mark-circle')
                                ->url(fn (): string => Resources\FaqResource::getUrl())
                                ->sort(2),
                                NavigationItem::make('About Us')
                                ->label('Cards')
                                ->icon('heroicon-o-exclamation-circle')
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

            //  ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
