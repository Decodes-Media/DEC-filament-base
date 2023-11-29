<?php

namespace App\Contracts;

use Spatie\Activitylog\LogOptions;

interface ModelWithLogActivity
{
    public function getActivitylogOptions(): LogOptions;

    public function logIdentifier(): string;

    public function logAttributes(): array;
}
