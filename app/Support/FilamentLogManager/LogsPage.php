<?php

namespace App\Support\FilamentLogManager;

use FilipFonal\FilamentLogManager\Pages\Logs as Page;

class LogsPage extends Page
{
    protected static ?string $slug = 'system/application-logs';

    protected static ?int $navigationSort = 2;
}
