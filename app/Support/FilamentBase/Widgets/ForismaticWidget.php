<?php

namespace App\Support\FilamentBase\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;

class ForismaticWidget extends Widget
{
    protected static string $view = 'filament.widgets.forismatic-widget';

    protected string $url = 'http://api.forismatic.com/api/1.0/?method=getQuote&format=json&lang=en';

    protected int|string|array $columnSpan = 2;

    public array $quote = [
        'quoteAuthor' => 'Brian Tracy',
        'quoteText' => ' There is never enough time to do everything, but there is always enough time to do the most important thing.',
    ];

    public string $username = 'Admin';

    public function mount(): void
    {
        try {
            $response = Http::acceptJson()->timeout(3)->get($this->url);
            $quote = $response->json() ?: $this->quote;
        } catch (\Throwable $th) {
            // pass
        }

        $this->quote = isset($quote) ? $quote : $this->quote;

        $this->username = filament_user()->name ?: 'Admin';
    }
}
