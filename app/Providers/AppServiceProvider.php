<?php

namespace App\Providers;

use App\Macros\CollectionPaginate;
use App\Models\Base\PersonalAccessToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    public function boot(): void
    {
        URL::forceScheme(config('app.use_https') ? 'https' : 'http');

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Collection::macro('paginate', app(CollectionPaginate::class)());

        Relation::enforceMorphMap(array_flip(config('base.model_morphs')));

        Model::preventLazyLoading(App::isLocal()); // safe on production

        $this->loadJsonTranslationsFrom(lang_path('json/1.base'));
        $this->loadJsonTranslationsFrom(lang_path('json/2.permission'));
        $this->loadJsonTranslationsFrom(lang_path('json/3.extra'));

        // Paginator::useTailwind(); // or useBootstrapFive();

        // View::share('siteSetting', app(SiteSetting::class));
    }
}
