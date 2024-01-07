<?php

namespace App\Models\Main;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\ModelActivityLogOptions;
use App\Concerns\ModelHasDbNotification;
use App\Contracts\ModelWithLogActivity;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements FilamentUser, ModelWithLogActivity
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasUlids;
    use LogsActivity;
    use ModelActivityLogOptions;
    use ModelHasDbNotification;

    protected $table = 'main_admins';

    protected $fillable = [
        'name',
        'email',
        'phone',
        // 'password',
        // 'password_updated_at',
        // 'remember_token',
        'is_active',
        'note',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'password_updated_at' => 'datetime',
        'is_active' => 'bool',
    ];

    public static function booted(): void
    {
        static::creating(fn (self $model) => //
            $model->password_updated_at = now()
        );
    }

    public function logIdentifier(): string
    {
        return $this->name;
    }

    public function logAttributes(): array
    {
        return array_merge($this->fillable, [
            'password',
            'password_updated_at',
        ]);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }
}
