<?php

namespace App\Concerns;

use App\Contracts\ModelWithLogActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

trait ModelActivityLogOptions
{
    public function getActivitylogOptions(): LogOptions
    {
        /** @var Model&ModelWithLogActivity $this */
        //
        $morphName = @config('base.model_morphs')[get_class($this)]
                   ?: $this->getMorphClass();

        $translated = trans("permission.{$morphName}");

        $record = is_string($translated) ? $translated : $morphName;

        if (! method_exists($this, 'logAttributes')) {
            throw new \Exception('Missing logAttributes method', 1);
        }

        return LogOptions::defaults()
            ->useLogName('Database')
            ->logOnlyDirty()
            ->logOnly($this->logAttributes())
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function ($eventName) use ($record) {
                return match ($eventName) {
                    'created' => __('admin.successfully_create_new_record', ['record' => $record]),
                    'updated' => __('admin.successfully_update_a_record', ['record' => $record]),
                    'deleted' => __('admin.successfully_delete_a_record', ['record' => $record]),
                    'restored' => __('admin.successfully_restore_deleted_record', ['record' => $record]),
                    default => null,
                };
            });
    }
}
