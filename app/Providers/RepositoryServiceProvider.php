<?php

namespace App\Providers;

use App\Repositories\GameRepository;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\TeamRepository;
use App\Repositories\TeamRepositoryInterface;
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
            GameRepositoryInterface::class,
            GameRepository::class
        );
        $this->app->bind(
            TeamRepositoryInterface::class,
            TeamRepository::class
        );
    }
}
