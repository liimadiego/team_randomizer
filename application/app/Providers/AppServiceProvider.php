<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\PlayerRepository;
use App\Repositories\Interfaces\DrawRepositoryInterface;
use App\Repositories\DrawRepository;
use App\Repositories\Interfaces\TeamRepositoryInterface;
use App\Repositories\TeamRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
        $this->app->bind(DrawRepositoryInterface::class, DrawRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
