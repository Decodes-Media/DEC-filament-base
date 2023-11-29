<?php

namespace App\Support\FilamentLogManager;

use Filament\Panel;
use FilipFonal\FilamentLogManager\FilamentLogManager as Plugin;
use FilipFonal\FilamentLogManager\Pages\Logs;

class LogPlugin extends Plugin
{
    protected string $page = Logs::class;

    public function register(Panel $panel): void
    {
        $panel->pages([$this->getPage()]);
    }

    public function usingPage(string $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): string
    {
        return $this->page;
    }
}
