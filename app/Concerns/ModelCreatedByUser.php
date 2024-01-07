<?php

namespace App\Concerns;

use App\Models\Main\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ModelCreatedByUser
{
    public static function bootModelCreatedByUser(): void
    {
        $id = user();

        self::creating(fn (Model $record) => $record->created_by_id = $id);
        self::updating(fn (Model $record) => $record->updated_by_id = $id);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }
}
