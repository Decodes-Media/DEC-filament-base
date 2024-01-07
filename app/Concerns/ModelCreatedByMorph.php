<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

trait ModelCreatedByMorph
{
    public static function bootModelCreatedByMorph(): void
    {
        if (method_exists(__CLASS__, 'creatorBy')) {
            $user = static::creatorBy();
        }

        $user = @$user ?: filament_user() ?: user('web');

        self::creating(function (Model $record) use ($user) {
            $record->created_by_id = $user->id;
            $record->created_by_type = $user->getMorphClass();
        });

        self::updating(function (Model $record) use ($user) {
            $record->updated_by_id = $user->id;
            $record->updated_by_type = $user->getMorphClass();
        });
    }

    public function creator(): MorphTo
    {
        return $this->morphTo('created_by');
    }

    public function editor(): MorphTo
    {
        return $this->morphTo('updated_by');
    }
}
