<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait ModelHasActiveState
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }

    public function setAsActive(): bool
    {
        return $this->update(['is_active' => true]);
    }

    public function setAsInactive(): bool
    {
        return $this->update(['is_active' => false]);
    }
}
