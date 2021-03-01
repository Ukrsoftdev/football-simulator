<?php

namespace App\Providers;

use App\Services\GameSimulateService;
use App\Services\GameSimulateServiceInterface;
use App\Services\PlayoffSimulateService;
use App\Services\PlayoffSimulateServiceInterface;
use App\Services\SeasonSimulateSarvice;
use App\Services\SeasonSimulateSarviceInterface;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            GameSimulateServiceInterface::class,
            GameSimulateService::class
        );
        $this->app->bind(
            PlayoffSimulateServiceInterface::class,
            PlayoffSimulateService::class
        );
        $this->app->bind(
            SeasonSimulateSarviceInterface::class,
            SeasonSimulateSarvice::class
        );
    }
}
