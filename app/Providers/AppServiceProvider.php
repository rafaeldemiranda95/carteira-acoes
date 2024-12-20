<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Repositories\StockRepository;
use App\Interfaces\Repositories\StockRepositoryInterface;
use App\Interfaces\Services\StockServiceInterface;
use App\Services\StockService;
use URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
        $this->app->bind(StockServiceInterface::class, StockService::class);

        if ($this->app->environment('prod')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
