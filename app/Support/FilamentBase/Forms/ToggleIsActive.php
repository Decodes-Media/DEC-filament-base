<?php

namespace App\Support\FilamentBase\Forms;

use Filament\Forms\Components\Toggle as BaseToggle;

class ToggleIsActive
{
    public static function make(string $label): BaseToggle
    {
        return Toggle::make('is_active', $label);
    }
}
