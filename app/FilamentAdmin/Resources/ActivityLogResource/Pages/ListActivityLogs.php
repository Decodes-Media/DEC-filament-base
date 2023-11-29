<?php

namespace App\FilamentAdmin\Resources\ActivityLogResource\Pages;

use App\FilamentAdmin\Resources\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;
}
