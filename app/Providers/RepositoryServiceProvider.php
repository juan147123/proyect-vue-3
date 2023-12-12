<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    EloquentRepositoryInterface,
    UserRepositoryInterface,
    SupplierRepositoryInterface,
    SupplierContactRepositoryInterface,
    TiposRepositoryInterface,
    ProductRepositoryInterface
};
use App\Repositories\{
    BaseRepository,
    UserRepository,
    SupplierRepository,
    SupplierContactRepository,
    TiposRepository,
    ProductRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class,  SupplierRepository::class);
        $this->app->bind(SupplierContactRepositoryInterface::class,  SupplierContactRepository::class);
        $this->app->bind(TiposRepositoryInterface::class,  TiposRepository::class);
        $this->app->bind(ProductRepositoryInterface::class,  ProductRepository::class);
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
