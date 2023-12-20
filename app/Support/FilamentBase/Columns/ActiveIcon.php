<?php

namespace App\Support\FilamentBase\Columns;

use Filament\Tables\Columns\IconColumn;

class ActiveIcon
{
    public static function make(): IconColumn
    {
        return IconColumn::make('is_active')
            ->label(__('admin.active'))
            ->boolean()
            ->trueColor('primary')
            ->sortable()
            ->extraHeaderAttributes(['style' => 'width:48px']);
    }
}
