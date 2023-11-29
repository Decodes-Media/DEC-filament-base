<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            //
            Route::middleware('web')
                ->domain(config('base.route.web_domain'))
                ->prefix(config('base.route.web_path'))
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->domain(config('base.route.api_domain'))
                ->prefix(config('base.route.api_path'))
                ->group(base_path('routes/api.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                user('api')?->id ?: $request->ip(),
            );
        });
    }
}
