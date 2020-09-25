<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Repositories\Category\CategoryRepositoryInterface;
use \App\Repositories\Category\CategoryEloquentRepository;
use \App\Repositories\Product\ProductRepositoryInterface;
use \App\Repositories\Product\ProductEloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryEloquentRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductEloquentRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
