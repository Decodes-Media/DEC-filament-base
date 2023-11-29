<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Vite;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->domain(config('base.route.admin_domain'))
            ->path(config('base.route.admin_path'))
            ->favicon(asset('favicox.ico'))
            ->sidebarCollapsibleOnDesktop(true)
            ->viteTheme('resources/css/filament-base-theme.css')
            ->login()
            // ->login(\App\Livewire\Auth\FilamentLogin::class)
            // ->registration()
            // ->passwordReset()
            // ->emailVerification()
            // ->profile()
            ->authGuard('admin')
            ->databaseNotifications()
            ->colors(['primary' => Color::Indigo])
            ->discoverResources(
                in: app_path('FilamentAdmin/Resources'),
                for: 'App\\FilamentAdmin\\Resources',
            )
            ->discoverPages(
                in: app_path('FilamentAdmin/Pages'),
                for: 'App\\FilamentAdmin\\Pages',
            )
            ->pages([
                // \App\FilamentAdmin\Pages\DashboardPage::class,
            ])
            ->discoverWidgets(
                in: app_path('FilamentAdmin/Widgets'),
                for: 'App\\FilamentAdmin\\Widgets',
            )
            ->widgets([
                \App\Filament\MyWidgets\ForismaticWidget::class,
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                // \Filament\Http\Middleware\DisableBladeIconComponents::class,
                \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ])
            ->plugins([
                \FilipFonal\FilamentLogManager\FilamentLogManager::make(),
            ]);
    }

    public function boot(): void
    {
        Filament::serving(function () {
            //
            $panel = Filament::getCurrentPanel();

            if ($panel->getId() == 'admin') {
                //
                $panel->navigationGroups([
                    NavigationGroup::make()->label(__('base.access')),
                    NavigationGroup::make()->label(__('base.system')),
                ]);

                FilamentAsset::register([
                    Js::make('theme-js', url(Vite::asset('resources/js/filament-base-theme.js'))),
                ]);

                FilamentView::registerRenderHook('panels::head.end', fn () => '
                    <meta name="developer" content="Decodes Media" />
                ');
            }
        });
    }
}
