<?php

namespace App\Models\Base;

use App\Concerns\ModelActivityLogOptions;
use App\Contracts\ModelWithLogActivity;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as Model;

class Role extends Model implements ModelWithLogActivity
{
    use HasUlids;
    use LogsActivity;
    use ModelActivityLogOptions;

    public function logIdentifier(): string
    {
        return $this->name;
    }

    public function logAttributes(): array
    {
        return $this->fillable;
    }
}
