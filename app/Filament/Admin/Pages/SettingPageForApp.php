<?php

namespace App\Filament\Admin\Pages;

use App\Models\Base\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property \Filament\Forms\ComponentContainer $form
 */
class SettingPageForApp extends SettingPage
{
    protected static ?string $subSlug = '/app';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string|Htmlable
    {
        return __('admin.app_setting');
    }

    public function afterMount(): void
    {
        $this->form->fill(setting('app'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('short_name')
                            ->label(__('admin.short_name'))
                            ->required()
                            ->disabled(),
                        Forms\Components\Select::make('locale')
                            ->label(__('admin.locale'))
                            ->options([
                                'id' => 'Indonesia',
                                'en' => 'English',
                            ])
                            ->required()
                            ->disabled($this->disableForm),
                        Forms\Components\TextInput::make('backup_password')
                            ->label(__('admin.backup_file_password'))
                            ->nullable()
                            ->disabled($this->disableForm),
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
