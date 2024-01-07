<?php

namespace App\Models\Base;

use App\Concerns\ModelActivityLogOptions;
use App\Contracts\ModelWithLogActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model implements ModelWithLogActivity
{
    use LogsActivity;
    use ModelActivityLogOptions;

    protected $table = 'base_settings';

    protected $fillable = [
        'key',
        'value',
        'locked',
    ];

    public function logIdentifier(): string
    {
        return $this->key;
    }

    public function logAttributes(): array
    {
        return $this->fillable;
    }

    public static function set(string $key, mixed $value, bool $locked = false): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['key' => $key, 'value' => $value, 'locked' => $locked],
        );
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return setting($key, $default);
    }

    public static function forget(string $key): mixed
    {
        return setting()->forget($key);
    }

    public static function clearCache(): bool
    {
        return Cache::forget(config('setting.cache.key'));
    }
}
