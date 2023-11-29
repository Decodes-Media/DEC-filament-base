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

        $record = trans($morphName);

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
                    'created' => __('Successfully create new :record', ['record' => $record]),
                    'updated' => __('Successfully update a :record', ['record' => $record]),
                    'deleted' => __('Successfully delete a :record', ['record' => $record]),
                    'restored' => __('Successfully restore deleted :record', ['record' => $record]),
                    default => null,
                };
            });
    }
}
