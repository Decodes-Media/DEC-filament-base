<?php

namespace App\FilamentAdmin\Resources\AdminResource\Pages;

use App\FilamentAdmin\Resources\AdminResource;
use App\Models\Admin;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\URL;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    public function mount(): void
    {
        if (Admin::count() >= config('base.records_limit.admins')) {
            $msg = __('Cannot create new record, limit excedeed');
            Notification::make()->danger()->title($msg)->send();
            $this->redirect(URL::previous());
        }

        parent::mount();
    }

    public function afterCreate(): void
    {
        /** @var Admin $record */
        $record = $this->record;
        $record->password = $this->data['password'];
        $record->save();
    }
}
