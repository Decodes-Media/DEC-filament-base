<?php

namespace App\Support\FilamentSpatieBackup;

use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as Page;

class BackupPage extends Page
{
    protected static ?string $slug = 'system/site-backup';

    protected static ?int $navigationSort = 3;
}
