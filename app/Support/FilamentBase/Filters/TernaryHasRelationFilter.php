<?php

namespace App\Support\FilamentBase\Filters;

use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class TernaryHasRelationFilter
{
    public static function make(string $relation, string $label = ''): TernaryFilter
    {
        return TernaryFilter::make("has_{$relation}")
            ->label($label)
            ->queries(
                true: fn (Builder $query) => $query->whereHas($relation),
                false: fn (Builder $query) => $query->whereDoesntHave($relation),
            );
    }
}
