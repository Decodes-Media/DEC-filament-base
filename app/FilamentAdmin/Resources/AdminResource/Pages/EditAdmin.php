<?php

namespace App\FilamentAdmin\Resources\AdminResource\Pages;

use App\FilamentAdmin\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
