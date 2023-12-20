<?php

namespace App\Support\FilamentBase\Forms;

use Carbon\Carbon;
use Filament\Forms\Components\TextInput;

class DatetimeForHumans
{
    public static function make(string $column, string $format = 'd F Y H:i:s'): TextInput
    {
        return TextInput::make($column)->formatStateUsing(function ($state) use ($format) {
            //
            if (blank($state)) {
                return '-';
            }

            $state = $state instanceof Carbon ? $state : Carbon::parse($state);

            return $state->translatedFormat($format).' ('.$state->diffForHumans().') ';
        });
    }
}
