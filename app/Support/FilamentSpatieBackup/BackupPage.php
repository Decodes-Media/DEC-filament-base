<?php

namespace App\Support\FilamentSpatieBackup;

use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as Page;

class BackupPage extends Page
{
    protected static ?string $slug = 'system/backups';

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return filament_user()->can('system.backup');
    }

    public function mount(): void
    {
        abort_unless(static::shouldRegisterNavigation(), 403);
    }
}
