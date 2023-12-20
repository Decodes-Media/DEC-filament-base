<?php

namespace App\Support\FilamentBase\Forms;

use Filament\Forms\Components\Toggle as BaseToggle;

class Toggle
{
    public static function make(string $column, string $label): BaseToggle
    {
        return BaseToggle::make($column)
            ->label($label)
            ->onIcon('heroicon-s-check-circle')
            ->offIcon('heroicon-s-x-circle')
            ->default(true)
            ->onColor('primary');
    }
}
