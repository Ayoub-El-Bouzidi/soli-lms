<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

use Modules\Pkg_CahierText\app\Providers\CahierTextServiceProvider;
use Modules\Pkg_Emploi\app\Providers\EmploiServiceProvider;




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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
