<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait ModelHasSlug
{
    public static function bootModelHasSlug(): void
    {
        self::creating(function (Model $record) {
            $record->slug = $record->slug ?: Str::slug($record);
        });
    }
}
