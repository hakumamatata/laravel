<?php

namespace App\Providers;

use App\Repositories\Report\Price\PriceRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Report\Price\PriceRepository;

class PriceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PriceRepository::class,
            PriceRepositoryEloquent::class
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

    /**
     * @return array
     */
    public function provides()
    {
        return [
            PriceRepository::class,
        ];
    }
}
