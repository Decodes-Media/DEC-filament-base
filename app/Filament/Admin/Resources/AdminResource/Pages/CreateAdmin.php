<?php

namespace App\Filament\Admin\Resources\AdminResource\Pages;

use App\Filament\Admin\Resources\AdminResource;
use App\Models\Main\Admin;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    public function mount(): void
    {
        parent::mount();

        if (Admin::count() >= config('base.records_limit.admins')) {
            $msg = __('admin.failed_to_create_new_record_limit_excedeed');
            Notification::make()->danger()->title($msg)->send();
            $this->redirect($this->previousUrl);
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        /** @var Admin $record */
        $record = new ($this->getModel())($data);
        $record->password = $this->data['password'];
        $record->save();

        // Note: we removed tenant association
        // Please re-add if we use tenant system

        return $record;
    }
}
