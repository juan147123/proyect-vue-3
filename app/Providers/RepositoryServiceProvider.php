<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    EloquentRepositoryInterface,
    UserRepositoryInterface,
    SupplierRepositoryInterface,
    SupplierContactRepositoryInterface,
    TiposRepositoryInterface
};
use App\Repositories\{
    BaseRepository,
    UserRepository,
    SupplierRepository,
    SupplierContactRepository,
    TiposRepository
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
