<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Lib\RecipeCategories\RecipeCategoriesInterface::class, \App\Lib\RecipeCategories\RecipeCategories::class);
        $this->app->bind(\App\Lib\RecipeMenus\RecipeMenusInterface::class, \App\Lib\RecipeMenus\RecipeMenus::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
