<?php

namespace Modules\Pkg_CahierText\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Pkg_CahierText\Models\CahierEntry;
use Modules\Pkg_CahierText\app\Policies\CahierEntryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class CahierTextServiceProvider extends ServiceProvider
{
    //     protected $policies = [
    //         CahierEntry::class => CahierEntryPolicy::class,
    //     ];

    public function boot()
    {
        // Register policies
        $this->registerPolicies();

        // ✅ Register web middleware with routes
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/web.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views', 'Pkg_CahierText');

        // Publish assets if needed
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
        $policies = [
            CahierEntry::class => CahierEntryPolicy::class,
        ];

        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
