<?php

namespace App\Support\FilamentBase\Filters;

use Filament\Tables\Filters\TernaryFilter;

class TernaryActiveStatusFilter
{
    public static function make(): TernaryFilter
    {
        return TernaryFilter::make('active_status')
            ->label(__('admin.active_status'))
            ->attribute('is_active')
            ->trueLabel(__('admin.active'))
            ->falseLabel(__('admin.inactive'));
    }
}
