<?php

namespace App\Providers;

use App\Macros\CollectionPaginate;
use App\Models\PersonalAccessToken;
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

        Relation::enforceMorphMap(array_flip(config('base.model_names')));

        Model::preventLazyLoading(App::isLocal());

        // Paginator::useBootstrapFive();

        // View::share('siteSetting', app(SiteSetting::class));
    }
}
