<?php

namespace App\Support\TranslationManager;

use App\Models\Base\LanguageLine;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Kenepa\TranslationManager\Filters\NotTranslatedFilter;
use Kenepa\TranslationManager\Resources\LanguageLineResource as Resource;

class LanguageLinesResource extends Resource
{
    protected static ?string $slug = 'system/translations';

    protected static ?int $navigationSort = 3;

    public static function getModel(): string
    {
        return config('translation-loader.model', LanguageLine::class);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getColumns())
            ->filters([
                NotTranslatedFilter::make(),
                SelectFilter::make('group')
                    ->label(__('admin.group'))
                    ->options(array_mirror(
                        LanguageLine::query()
                            ->selectRaw('distinct `group` as x')
                            ->pluck('x')
                    )),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([])
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(25);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLanguageLinesPage::route('/'),
            'edit' => EditLanguageLinePage::route('/{record}/edit'),
            'quick-translate' => QuickTranslatePage::route('/quick-translate'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('permission.system');
    }
}
