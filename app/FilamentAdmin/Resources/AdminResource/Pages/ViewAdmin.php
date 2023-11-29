<?php

namespace App\FilamentAdmin\Resources\AdminResource\Pages;

use App\FilamentAdmin\Resources\AdminResource;
use App\Models\Base\Admin;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('reset-password')
                ->label(__('Reset password'))
                ->modalWidth('lg')
                ->outlined()
                ->requiresConfirmation()
                ->form([
                    Forms\Components\TextInput::make('new_password')
                        ->label(__('New password'))
                        ->password()
                        ->required()
                        ->confirmed()
                        ->rule(Password::default())
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    Forms\Components\TextInput::make('new_password_confirmation')
                        ->label(__('New password confirmation'))
                        ->password()
                        ->required(),
                ])
                ->action(function (array $data) {
                    //
                    /** @var Admin $record */
                    $record = $this->record;
                    $record->password = $data['new_password'];
                    $record->password_updated_at = now();
                    $record->save();

                    $msg = __('Successfully reset admin password');
                    Notification::make()->success()->title($msg)->send();
                }),
            Actions\DeleteAction::make()
                ->outlined()
                ->before(function (Actions\DeleteAction $action) {
                    //
                    /** @var Admin $record */
                    $record = $this->record;

                    if ($record->id == user_id('admin')) {
                        $msg = __('Failed, cannot delete your self');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }

                    if ($record->email == config('base.superadmin_email')) {
                        $msg = __('Failed, cannot delete Superadmin user');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }

                    if ($record->is_active) {
                        $msg = __('Failed, cannot delete active admin');
                        Notification::make()->danger()->title($msg)->send();
                        $action->cancel();
                    }
                }),
        ];
    }
}
