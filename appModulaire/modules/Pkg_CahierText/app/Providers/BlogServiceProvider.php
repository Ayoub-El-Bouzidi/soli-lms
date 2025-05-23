<?php

namespace Modules\Blog\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
// use Modules\Blog\Models\Article;
// use Modules\Blog\Policies\ArticlePolicy;

class BlogServiceProvider extends ServiceProvider
{
    // protected $policies = [
    //     Article::class => ArticlePolicy::class,
    // ];
    public function boot()
    {
        // Charger les routes
        $this->loadRoutesFrom(__DIR__.'/../../Routes/web.php');

        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__.'/../../Database/Migrations');

        // Charger les vues
        $this->loadViewsFrom(__DIR__.'/../../Resources/views', 'Blog');

        // Publier les assets si nécessaire
        $this->publishes([
            __DIR__.'/../../Resources/views' => resource_path('views/vendor/Blog'),
        ], 'Blog-views');
    }

    public function register()
    {
        // Enregistrer d'autres services si nécessaire
    }
}
