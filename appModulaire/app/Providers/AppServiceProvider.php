<?php

namespace App\Providers;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Support\ServiceProvider;
use Modules\Blog\app\Providers\BlogServiceProvider;
use Modules\Blog\app\Providers\CahierTextServiceProvider;

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
        $this->app->register(BlogServiceProvider::class);
        $this->app->register(CahierTextServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
