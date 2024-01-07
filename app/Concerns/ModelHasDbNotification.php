<?php

namespace App\Concerns;

use App\Models\Base\DbNotification;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\RoutesNotifications;

/**
 * @see vendor/laravel/framework/src/Illuminate/Notifications/HasDatabaseNotifications.php
 */
trait ModelHasDbNotification
{
    use RoutesNotifications;

    /**
     * Get the entity's notifications.
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DbNotification::class, 'notifiable')->latest();
    }

    /**
     * Get the entity's read notifications.
     */
    public function readNotifications(): Builder
    {
        return $this->notifications()->read();
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications(): Builder
    {
        return $this->notifications()->unread();
    }
}
