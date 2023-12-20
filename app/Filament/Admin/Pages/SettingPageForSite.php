<?php

namespace App\Filament\Admin\Pages;

use Illuminate\Contracts\Support\Htmlable;

/**
 * @property \Filament\Forms\ComponentContainer $form
 */
class SettingPageForSite extends SettingPage
{
    protected static ?string $subSlug = '/site';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string|Htmlable
    {
        return __('admin.setting_site');
    }

    public function afterMount(): void
    {
        $this->form->fill(setting('site'));
    }
}
