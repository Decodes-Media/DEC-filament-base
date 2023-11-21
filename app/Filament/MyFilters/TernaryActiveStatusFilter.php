<?php

namespace App\Filament\MyFilters;

use Filament\Tables\Filters\TernaryFilter;

class TernaryActiveStatusFilter
{
    public static function make(): TernaryFilter
    {
        return TernaryFilter::make('active_status')
            ->label(__('base.active_status'))
            ->attribute('is_active')
            ->trueLabel(__('base.active'))
            ->falseLabel(__('base.inactive'));
    }
}
