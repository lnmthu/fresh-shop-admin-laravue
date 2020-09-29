<?php

namespace App\Providers;

use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryEloquentRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Product\ProductEloquentRepository;
use Illuminate\Support\ServiceProvider;

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
        //
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
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
