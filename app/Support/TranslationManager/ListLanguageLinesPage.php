<?php

namespace App\Support\TranslationManager;

use Filament\Actions\Action;
use Kenepa\TranslationManager\Actions\SynchronizeAction;
use Kenepa\TranslationManager\Resources\LanguageLineResource\Pages\ListLanguageLines as Page;

class ListLanguageLinesPage extends Page
{
    protected static string $resource = LanguageLinesResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('quick-translate')
                ->icon('heroicon-o-bolt')
                ->label(__('translation-manager::translations.quick-translate'))
                ->url(static::$resource::getUrl('quick-translate')),
            SynchronizeAction::make('synchronize')
                ->action('synchronize'),
        ];
    }
}
