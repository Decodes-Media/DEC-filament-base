<?php

namespace App\Support\TranslationManager;

use Kenepa\TranslationManager\Pages\QuickTranslate as Page;

class QuickTranslatePage extends Page
{
    protected static string $resource = LanguageLinesResource::class;
}
