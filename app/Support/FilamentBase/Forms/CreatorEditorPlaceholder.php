<?php

namespace App\Support\FilamentBase\Forms;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;

class CreatorEditorPlaceholder
{
    public static function make(): Section
    {
        return Section::make()
            ->columns(4)
            ->visibleOn(['view'])
            ->extraAttributes(['class' => 'bg-gray-100'])
            ->schema([
                Placeholder::make(__('admin.created_at'))
                    ->content(fn ($record) => $record->created_at),
                Placeholder::make(__('admin.created_by'))
                    ->content(fn ($record) => $record->creator?->name ?: '-'),
                Placeholder::make(__('admin.updated_at'))
                    ->content(fn ($record) => $record->updated_at),
                Placeholder::make(__('admin.updated_by'))
                    ->content(fn ($record) => $record->editor?->name ?: '-'),
            ]);
    }
}
