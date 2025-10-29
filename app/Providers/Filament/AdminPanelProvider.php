<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('readloop')
            ->brandLogo(asset('images/logo.svg'))
            ->brandLogoHeight('2.5rem')
            ->darkModeBrandLogo(asset('images/logo-dark.svg'))
            ->favicon(asset('images/favicon.svg'))
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Orange,
            ])
            ->font('Inter')
            ->maxContentWidth(MaxWidth::Full)
            ->sidebarCollapsibleOnDesktop()
            ->darkMode(true)
            ->topNavigation(false)
            ->breadcrumbs(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->databaseTransactions()
            ->spa()
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                \App\Filament\Admin\Widgets\StatsOverviewWidget::class,
                \App\Filament\Admin\Widgets\NewUsersChart::class,
                \App\Filament\Admin\Widgets\ActivityChart::class,
                \App\Filament\Admin\Widgets\GenreDistributionChart::class,
                \App\Filament\Admin\Widgets\GroupsStatsChart::class,
                \App\Filament\Admin\Widgets\TopBooksWidget::class,
                \App\Filament\Admin\Widgets\RecentActivityWidget::class,
                \App\Filament\Admin\Widgets\PopularAuthorsWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('Бібліотека')
                    ->icon('heroicon-o-book-open')
                    ->collapsed(false),
                NavigationGroup::make('Користувачі')
                    ->icon('heroicon-o-users')
                    ->collapsed(false),
                NavigationGroup::make('Контент')
                    ->icon('heroicon-o-document-text')
                    ->collapsed(true),
                NavigationGroup::make('Групи')
                    ->icon('heroicon-o-user-group')
                    ->collapsed(true),
                NavigationGroup::make('Нагороди')
                    ->icon('heroicon-o-trophy')
                    ->collapsed(true),
                NavigationGroup::make('Комерція')
                    ->icon('heroicon-o-shopping-cart')
                    ->collapsed(true),
                NavigationGroup::make('Системні')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(true),
            ])
            ->userMenuItems([
                'profile' => \Filament\Navigation\MenuItem::make()
                    ->label('Профіль')
                    ->url(fn () => '#')
                    ->icon('heroicon-o-user-circle'),
                'settings' => \Filament\Navigation\MenuItem::make()
                    ->label('Налаштування')
                    ->url(fn () => '#')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => view('filament.components.footer')->render()
            )
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
