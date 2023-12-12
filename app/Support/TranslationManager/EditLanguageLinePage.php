<?php

namespace App\Support\TranslationManager;

use Kenepa\TranslationManager\Resources\LanguageLineResource\Pages\EditLanguageLine as Page;

class EditLanguageLinePage extends Page
{
    protected static string $resource = LanguageLinesResource::class;
}
