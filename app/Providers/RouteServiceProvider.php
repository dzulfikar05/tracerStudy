<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot()
    {
        $this->routes(function () {
            Route::middleware(['web'])->group(function () {
                foreach (glob(base_path('routes/web/*.php')) as $file) {
                    require $file;
                }
                foreach (glob(base_path('routes/web/backoffice/*.php')) as $file) {
                    require $file;
                }
            });


            Route::middleware('api')
                ->prefix('api')
                ->group(function () {
                    foreach (glob(base_path('routes/api/*.php')) as $file) {
                        require $file;
                    }
                });
        });
    }
}
