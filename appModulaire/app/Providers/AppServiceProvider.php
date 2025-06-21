<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

use Modules\Pkg_CahierText\app\Providers\CahierTextServiceProvider;
use Modules\Pkg_Emploi\app\Providers\EmploiServiceProvider;
use Modules\Pkg_PlanFormation\app\Providers\PlanServiceProvider;

// Add the correct imports for the repositories
use Modules\Pkg_CahierText\Repositories\ModuleRepository;
use Modules\Pkg_CahierText\Repositories\SeanceRepository;
use Modules\Pkg_CahierText\Repositories\GroupeRepository;

class AppServiceProvider extends ServiceProvider
{
    // protected $policies = [
    //     Article::class => ArticlePolicy::class,
    // ];


    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(CahierTextServiceProvider::class);
        $this->app->register(EmploiServiceProvider::class);
        $this->app->bind(ModuleRepository::class);
        $this->app->bind(SeanceRepository::class);
        $this->app->bind(GroupeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(
            base_path('appModulaire/modules/Pkg_CahierText/Resources/views'),
            'cahier'
        );

        // Custom Blade directive for multi-guard role checking
        Blade::directive('role', function ($role) {
            return "<?php
                \$guard = session('auth.guard', 'web');
                \$user = app('auth')->guard(\$guard)->user();
                \$hasRole = false;

                if (\$user) {
                    // Check if the current user has the role
                    \$hasRole = \$user->hasRole({$role});

                    // If not, and it's a multi-guard user, check the User model
                    if (!\$hasRole && (\$guard === 'formateurs' || \$guard === 'responsables')) {
                        \$userModel = \App\Models\User::find(\$user->user_id ?? \$user->id);
                        if (\$userModel) {
                            \$hasRole = \$userModel->hasRole({$role});
                        }
                    }
                }

                if (\$hasRole):
            ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // Add a helper function for role checking
        \Illuminate\Support\Facades\Blade::if('hasRole', function ($role) {
            $guard = session('auth.guard', 'web');
            $user = app('auth')->guard($guard)->user();

            if ($user) {
                // Check if the current user has the role
                if ($user->hasRole($role)) {
                    return true;
                }

                // If not, and it's a multi-guard user, check the User model
                if ($guard === 'formateurs' || $guard === 'responsables') {
                    $userModel = \App\Models\User::find($user->user_id ?? $user->id);
                    if ($userModel && $userModel->hasRole($role)) {
                        return true;
                    }
                }
            }

            return false;
        });
    }
}
