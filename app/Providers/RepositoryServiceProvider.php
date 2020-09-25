<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Repositories\BlogCategory\BlogCategoryRepository;
use App\Repositories\BlogCategory\BlogCategoryRepositoryInterface;
use App\Repositories\BlogItem\BlogItemRepository;
use App\Repositories\BlogItem\BlogItemRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogCategoryRepositoryInterface::class, BlogCategoryRepository::class);
        $this->app->bind(BlogItemRepositoryInterface::class, BlogItemRepository::class);
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
