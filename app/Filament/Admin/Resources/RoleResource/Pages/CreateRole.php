<?php

namespace App\Filament\Admin\Resources\RoleResource\Pages;

use App\Filament\Admin\Resources\RoleResource;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function mount(): void
    {
        parent::mount();

        if (Role::count() >= config('base.records_limit.roles')) {
            $msg = __('admin.failed_to_create_new_record_limit_excedeed');
            Notification::make()->danger()->title($msg)->send();
            $this->redirect($this->previousUrl);
        }
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

        $permissionIds = Permission::query()
            ->where('guard_name', 'admin')
            ->whereIn('name', $data['permissions'])
            ->pluck('id');

        $record->permissions()->sync($permissionIds);

        return $record;
    }
}
