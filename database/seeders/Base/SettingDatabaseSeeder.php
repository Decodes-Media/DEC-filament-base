<?php

namespace Database\Seeders\Base;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Base\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $groups = ['app', 'site'];
        array_walk($groups, fn ($g) => $this->loadAndSaveSetting($g));
    }

    protected function loadAndSaveSetting(string $group): void
    {
        $settings = require database_path("_raw_/settings/{$group}.php");

        foreach ($settings as $key => $value) {
            Setting::set("{$group}.{$key}", $value);
        }

        Setting::clearCache();
    }
}
