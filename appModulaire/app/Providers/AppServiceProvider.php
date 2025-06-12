<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

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
    }
}
