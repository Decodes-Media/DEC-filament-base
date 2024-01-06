<?php

namespace App\Filament\Admin\Resources\RoleResource\Pages;

use App\Filament\Admin\Resources\RoleResource;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [Actions\ViewAction::make()];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        /** @var ?Role $record */
        $record = $this->record;

        if ($record?->name == 'Superadmin') {
            $msg = __('admin.failed_cannot_edit_superadmin_role');
            Notification::make()->danger()->title($msg)->send();
            $this->redirect($this->previousUrl);
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return RoleResource::mutateDateForPermissions($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var Role $record */
        $record->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'],
        ]);

        $permissionIds = Permission::query()
            ->where('guard_name', 'admin')
            ->whereIn('name', $data['permissions'])
            ->pluck('id');

        $record->permissions()->sync($permissionIds);

        return $record;
    }
}
