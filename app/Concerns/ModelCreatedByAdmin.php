<?php

namespace App\Concerns;

use App\Models\Main\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ModelCreatedByAdmin
{
    public static function bootModelCreatedByAdmin(): void
    {
        $id = filament_user_id();

        self::creating(fn (Model $record) => $record->created_by_id = $id);
        self::updating(fn (Model $record) => $record->updated_by_id = $id);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by_id');
    }
}
