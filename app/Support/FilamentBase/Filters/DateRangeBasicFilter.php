<?php

namespace App\Support\FilamentBase\Filters;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateRangeBasicFilter
{
    public static function make(
        string $column = 'created_at',
        string $fromLabel = 'Created from',
        string $untilLabel = 'Created until',
    ): Filter {
        return Filter::make($column)
            ->form([
                DatePicker::make("{$column}_from")
                    ->label($fromLabel)
                    ->native(false)
                    ->displayFormat('d M Y')
                    ->reactive(),
                DatePicker::make("{$column}_until")
                    ->label($untilLabel)
                    ->native(false)
                    ->displayFormat('d M Y')
                    ->minDate(fn ($get) => $get("{$column}_from")),
            ])
            ->query(fn (Builder $query, array $data) => $query
                ->when($data["{$column}_from"], fn ($query, $date) => //
                    $query->whereDate($column, '>=', $date),
                )
                ->when($data["{$column}_until"], fn ($query, $date) => //
                    $query->whereDate($column, '<=', $date),
                ),
            )
            ->indicateUsing(function (array $data) use ($column, $fromLabel, $untilLabel) {
                //
                if ($data["{$column}_from"] ?? null) {
                    @$indicators["{$column}_from"] = $fromLabel.': '
                        .Carbon::parse($data["{$column}_from"])->translatedFormat('d M Y');
                }

                if ($data["{$column}_until"] ?? null) {
                    @$indicators["{$column}_from"] = $untilLabel.': '
                        .Carbon::parse($data["{$column}_until"])->translatedFormat('d M Y');
                }

                return isset($indicators) ? $indicators : [];
            });
    }
}
