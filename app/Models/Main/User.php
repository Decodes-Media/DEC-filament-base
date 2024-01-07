<?php

namespace App\Models\Main;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\ModelActivityLogOptions;
use App\Concerns\ModelHasDbNotification;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasUlids;
    use LogsActivity;
    use ModelActivityLogOptions;
    use ModelHasDbNotification;

    protected $table = 'main_users';

    protected $fillable = [
        'name',
        'email',
        // 'email_verified_at',
        'phone',
        // 'password',
        // 'password_updated_at',
        // 'remember_token',
        // 'is_active',
        'note',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
}
