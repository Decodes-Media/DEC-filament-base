<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->maxContentWidth(MaxWidth::Full)
            ->id('admin')
            ->domain(config('base.route.admin_domain'))
            ->path(config('base.route.admin_path'))
            ->favicon(asset('faviconx.ico'))
            ->sidebarCollapsibleOnDesktop(true)
            ->viteTheme('resources/css/filament-base-theme.css')
            ->login()
            ->login(\App\Support\FilamentBase\Pages\LoginPage::class)
            // ->registration()
            // ->passwordReset()
            // ->emailVerification()
            // ->profile()
            ->authGuard('admin')
            ->databaseNotifications()
            ->colors(['primary' => Color::Indigo])
            ->discoverResources(
                in: app_path('Filament/Admin/Resources'),
                for: 'App\\Filament\\Admin\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Admin/Pages'),
                for: 'App\\Filament\\Admin\\Pages',
            )
            ->pages([
                // \App\Filament\Admin\Pages\DashboardPage::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Admin/Widgets'),
                for: 'App\\Filament\\Admin\\Widgets',
            )
            ->widgets([
                \App\Support\FilamentBase\Widgets\ForismaticWidget::class,
            ])
            ->middleware(config('filament.default_middlewares'))
            ->authMiddleware(config('filament.default_auth_middlewares'))
            ->plugins([
                \App\Support\FilamentLogManager\LogPlugin::make(),
                \App\Support\TranslationManager\TranslationPlugin::make(),
                \ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(\App\Support\FilamentSpatieBackup\BackupPage::class),
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
                    __('permission.access'),
                    __('permission.system'),
                ]);

                FilamentAsset::register([
                    Js::make('theme-js', url(Vite::asset('resources/js/filament-base-theme.js'))),
                ]);

                // FilamentView::registerRenderHook('panels::head.end', fn () => '
                //     <meta name="developer" content="Decodes Media" />
                // ');
            }
        });

        Gate::define('use-translation-manager', function ($user) {
            return $user !== null;
        });
    }
}
