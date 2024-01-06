<?php

namespace App\Support\TranslationManager;

use Kenepa\TranslationManager\Pages\QuickTranslate as Page;

class QuickTranslatePage extends Page
{
    protected static string $resource = LanguageLinesResource::class;

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        $parent = parent::shouldRegisterNavigation($parameters);

        return $parent && filament_user()->can('system.translation');
    }

    public function mount(): void
    {
        abort_unless(static::shouldRegisterNavigation(), 403);
    }
}
