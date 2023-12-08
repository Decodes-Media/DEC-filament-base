<?php

namespace App\Filament\MyInfolists;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class CreatorEditorInfo
{
    public static function make(): Section
    {
        return Section::make()
            ->columns(4)
            ->extraAttributes(['class' => 'bg-gray-100'])
            ->schema([
                TextEntry::make(__('base.created_at'))
                    ->getStateUsing(fn ($record) => $record->created_at),
                TextEntry::make(__('base.created_by'))
                    ->getStateUsing(fn ($record) => $record->creator?->name ?: '-'),
                TextEntry::make(__('base.updated_at'))
                    ->getStateUsing(fn ($record) => $record->updated_at),
                TextEntry::make(__('base.updated_by'))
                    ->getStateUsing(fn ($record) => $record->editor?->name ?: '-'),
            ]);
    }
}
