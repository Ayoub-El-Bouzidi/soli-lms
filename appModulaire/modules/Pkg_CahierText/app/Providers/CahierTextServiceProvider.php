<?php

namespace Modules\Pkg_CahierText\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Pkg_CahierText\app\Models\CahierEntry;
use Modules\Pkg_CahierText\app\Policies\CahierEntryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class CahierTextServiceProvider extends ServiceProvider
{
    protected $policies = [
        CahierEntry::class => CahierEntryPolicy::class,
    ];

    public function boot()
    {
        // Register middleware
        $router = $this->app['router'];

        // Ensure all necessary middleware is registered in the web group
        $router->pushMiddlewareToGroup('web', EncryptCookies::class);
        $router->pushMiddlewareToGroup('web', AddQueuedCookiesToResponse::class);
        $router->pushMiddlewareToGroup('web', StartSession::class);
        $router->pushMiddlewareToGroup('web', ShareErrorsFromSession::class);
        $router->pushMiddlewareToGroup('web', VerifyCsrfToken::class);

        // Register policies
        $this->registerPolicies();

        // Charger les routes
        $this->loadRoutesFrom(__DIR__ . '/../../Routes/web.php');

        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        // Charger les vues
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views', 'Pkg_CahierText');

        // Publier les assets si nécessaire
        $this->publishes([
            __DIR__ . '/../../Resources/views' => resource_path('views/vendor/Blog'),
        ], 'Blog-views');
    }

    public function register()
    {
        // Enregistrer d'autres services si nécessaire
    }

    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
