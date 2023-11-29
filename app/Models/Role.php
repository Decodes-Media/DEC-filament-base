<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use HasUlids;
}
