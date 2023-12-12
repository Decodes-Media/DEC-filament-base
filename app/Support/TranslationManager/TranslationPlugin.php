<?php

namespace App\Support\TranslationManager;

use Filament\Panel;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use Kenepa\TranslationManager\TranslationManagerPlugin as Plugin;

class TranslationPlugin extends Plugin
{
    public function register(Panel $panel): void
    {
        $panel
            ->resources([LanguageLinesResource::class])
            ->pages([QuickTranslatePage::class]);

        if (config('translation-manager.language_switcher')) {
            $panel->renderHook(
                config('translation-manager.language_switcher_render_hook'),
                fn (): View => $this->getLanguageSwitcherView()
            );
            $panel->authMiddleware([SetLanguage::class]);
        }
    }

    private function getLanguageSwitcherView(): View
    {
        $locales = config('translation-manager.available_locales');
        $currentLocale = app()->getLocale();
        $currentLanguage = collect((array) $locales)->firstWhere('code', $currentLocale);
        $otherLanguages = $locales;
        $showFlags = config('translation-manager.show_flags');

        return view('translation-manager::language-switcher', compact(
            'otherLanguages',
            'currentLanguage',
            'showFlags',
        ));
    }
}
