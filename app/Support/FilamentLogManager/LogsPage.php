<?php

namespace App\Support\FilamentLogManager;

use FilipFonal\FilamentLogManager\Pages\Logs as Page;

class LogsPage extends Page
{
    protected static ?string $slug = 'system/application-logs';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return filament_user()->can('system.log_activity');
    }

    public function mount(): void
    {
        abort_unless(static::shouldRegisterNavigation(), 403);
    }
}
