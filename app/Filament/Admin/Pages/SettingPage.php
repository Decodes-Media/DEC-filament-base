<?php

namespace App\Filament\Admin\Pages;

use Filament\Actions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Http\Response;

class SettingPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $slug = 'system/settings';

    protected static ?string $subSlug = '';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.admin--setting-page';

    public bool $disableForm = true;

    public ?array $data = [];

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public static function getSlug(): string
    {
        return parent::getSlug().static::$subSlug;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('permission.system');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.setting');
    }

    public function getTitle(): string|Htmlable
    {
        return __('admin.setting');
    }

    public function getBreadcrumbs(): array
    {
        return [
            static::getNavigationGroup(),
            static::getNavigationLabel(),
        ];
    }

    public function getSubNavigation(): array
    {
        return [
            NavigationItem::make(__('admin.app'))
                ->icon('heroicon-o-document-text')
                ->url(SettingPageForApp::getUrl())
                ->isActiveWhen(fn () => static::class == SettingPageForApp::class),
            NavigationItem::make(__('admin.site'))
                ->icon('heroicon-o-document-text')
                ->url(SettingPageForSite::getUrl())
                ->isActiveWhen(fn () => static::class == SettingPageForSite::class),
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
                ->url($this->getUrl(['mode' => 'edit']))
                ->visible(fn ($livewire) => $livewire->disableForm),
        ];
    }

    public function getCancelButtonUrlProperty(): string
    {
        return static::getUrl();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return user('admin')->can('system.setting');
    }

    public static function checkPermission(): void
    {
        abort_unless(static::shouldRegisterNavigation(), Response::HTTP_FORBIDDEN);
    }

    public function mount(): void
    {
        $this->checkPermission();

        $this->disableForm = request('mode', 'view') == 'view';

        if (request('save') == 'ok') {
            Notification::make()->success()->title(__('admin.saved'))->send();
        }

        $this->afterMount();
    }

    public function afterMount(): void
    {
        $this->redirect(SettingPageForApp::getUrl());
    }
}
