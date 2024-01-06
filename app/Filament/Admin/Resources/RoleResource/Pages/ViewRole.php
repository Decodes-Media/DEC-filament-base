<?php

namespace App\Filament\Admin\Resources\RoleResource\Pages;

use App\Filament\Admin\Resources\RoleResource;
use App\Models\Base\Role;
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
                        $msg = __('admin.failed_cannot_delete_superadmin_role');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }

                    if ($record->users()->exists()) {
                        $msg = __('admin.failed_cannot_delete_role_that_has_been_attached_to_admins');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }
                }),
        ];
    }
}
