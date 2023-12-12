<?php

namespace App\Support\FilamentLogManager;

use FilipFonal\FilamentLogManager\FilamentLogManager as Plugin;

class LogPlugin extends Plugin
{
    protected string $page = LogsPage::class;
}
