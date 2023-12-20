<?php

namespace App\Support\FilamentBase\Columns;

use Filament\Tables\Columns\TextColumn;

class CreatedAt
{
    public static function make(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label(__('admin.created_at_date'))
            ->formatStateUsing(fn ($state) => $state->translatedFormat('d M Y H:i'))
            ->sortable()
            ->toggleable(true, true);
    }
}
