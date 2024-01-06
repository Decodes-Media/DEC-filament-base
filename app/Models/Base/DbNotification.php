<?php

namespace App\Models\Base;

use Illuminate\Notifications\DatabaseNotification;

class DbNotification extends DatabaseNotification
{
    protected $table = 'base_notifications';
}
