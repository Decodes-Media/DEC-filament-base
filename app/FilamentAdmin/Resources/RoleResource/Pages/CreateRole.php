<?php

namespace App\FilamentAdmin\Resources\RoleResource\Pages;

use App\FilamentAdmin\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function mount(): void
    {
        if (Role::count() >= config('base.records_limit.roles')) {
            $msg = __('Cannot create new record, limit excedeed');
            Notification::make()->danger()->title($msg)->send();
            $this->redirect(URL::previous());
        }

        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return RoleResource::mutateDateForPermissions($data);
    }

    protected function handleRecordCreation(array $data): Model
    {
        /** @var Role $record */
        $record = Role::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'],
        ]);

        $permissionIds = Permission::whereIn('name', $data['permissions'])->pluck('id');

        $record->permissions()->sync($permissionIds);

        return $record;
    }
}
