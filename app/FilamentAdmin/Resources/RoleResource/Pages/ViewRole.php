<?php

namespace App\FilamentAdmin\Resources\RoleResource\Pages;

use App\FilamentAdmin\Resources\RoleResource;
use App\Models\Role;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->outlined()
                ->before(function (Actions\DeleteAction $action) {
                    //
                    /** @var Role $record */
                    $record = $this->record;

                    if ($record->name == 'Superadmin') {
                        $msg = __('Failed, cannot delete Superadmin role');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }

                    if ($record->users()->exists()) {
                        $msg = __('Failed, cannot delete role that has been attached to admins');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }
                }),
        ];
    }
}
