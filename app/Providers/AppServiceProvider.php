<?php

namespace App\Providers;

use App\Models\Base\PersonalAccessToken;
use App\Support\CollectionPaginateMacro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
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

        Collection::macro('paginate', app(CollectionPaginateMacro::class)());

        Relation::enforceMorphMap(array_flip(config('base.model_morphs')));

        Model::preventLazyLoading(App::isLocal()); // safe on production

        // Paginator::useTailwind(); // or useBootstrapFive();
    }
}
