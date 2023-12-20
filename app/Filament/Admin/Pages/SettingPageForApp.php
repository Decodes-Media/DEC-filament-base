<?php

namespace App\Filament\Admin\Pages;

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
        return __('admin.setting_app');
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
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.name'))
                            ->disabled($this->disableForm)
                            ->required(),
                        Forms\Components\TextInput::make('short_name')
                            ->label(__('admin.short_name'))
                            ->disabled($this->disableForm)
                            ->required(),
                        Forms\Components\Select::make('locale')
                            ->label(__('admin.locale'))
                            ->disabled($this->disableForm)
                            ->options([
                                'id' => 'Indonesia',
                                'en' => 'English',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('backup_password')
                            ->label(__('admin.backup_password'))
                            ->password()
                            ->disabled($this->disableForm)
                            ->nullable(),
                    ]),
            ]);
    }

    public function submit(): void
    {
        dd($this->form->getState());
    }
}
