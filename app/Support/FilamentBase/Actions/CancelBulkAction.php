<?php

namespace App\Support\FilamentBase\Actions;

use Filament\Tables\Actions\BulkAction;

class CancelBulkAction
{
    public static function make(): BulkAction
    {
        return BulkAction::make('cancel-bulk-action')
            ->label(__('admin.cancel_all_selection'))
            ->icon('heroicon-o-x-circle')
            ->action(fn () => null)
            ->deselectRecordsAfterCompletion();
    }
}
