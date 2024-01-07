<?php

namespace App\Filament\Admin\Pages;

use App\Models\Base\Setting;
use Filament\Forms;
use Filament\Forms\Form;
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
        return __('admin.site_setting');
    }

    public function afterMount(): void
    {
        $this->form->fill(setting('site'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->label(__('admin.contact_email'))
                            ->columnSpanFull()
                            ->email()
                            ->disabled($this->disableForm)
                            ->required(),
                        Forms\Components\FileUpload::make('logo_light_path')
                            ->label(__('admin.logo_light'))
                            ->imagePreviewHeight('256px')
                            ->directory('uploads')
                            ->getUploadedFileNameForStorageUsing(fn ($file) => uniqid().$file->hashName())
                            ->downloadable()
                            ->openable()
                            ->disabled($this->disableForm)
                            ->required(),
                        Forms\Components\FileUpload::make('logo_dark_path')
                            ->label(__('admin.logo_dark'))
                            ->imagePreviewHeight('256px')
                            ->directory('uploads')
                            ->getUploadedFileNameForStorageUsing(fn ($file) => uniqid().$file->hashName())
                            ->downloadable()
                            ->openable()
                            ->disabled($this->disableForm)
                            ->required(),
                    ]),
            ]);
    }

    public function submit(): void
    {
        $changes = array_diff($this->form->getState(), setting('app'));

        foreach ($changes as $key => $value) {
            Setting::set("app.{$key}", $value);
        }

        Setting::clearCache();

        $this->redirect(static::getUrl(['save' => 'ok']));
    }
}
