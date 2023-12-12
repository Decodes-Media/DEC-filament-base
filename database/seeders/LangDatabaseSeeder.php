<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\TranslationLoader\LanguageLine;

class LangDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Load and save raw translations
        $groups = ['admin', 'api', 'permission'];
        array_walk($groups, fn ($g) => $this->loadAndSaveTranslation($g));

        // Execute sync translations from kenepa/translation-manager
        // Artisan::call('translations:synchronize');
    }

    protected function loadAndSaveTranslation(string $group): void
    {
        $linesEn = require database_path("translations/en/{$group}.php");
        $linesId = require database_path("translations/id/{$group}.php");

        foreach ($linesEn as $key => $value) {
            LanguageLine::create([
                'group' => $group,
                'key' => $key,
                'text' => [
                    'en' => $linesEn[$key],
                    'id' => $linesId[$key],
                ],
            ]);
        }
    }
}
