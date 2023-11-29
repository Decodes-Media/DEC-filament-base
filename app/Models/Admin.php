<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasUlids;
    use Notifiable;

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
        static::creating(fn (self $model) => $model->password_updated_at = now());
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }
}
