<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use HasUlids;
}
