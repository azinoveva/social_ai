<?php

namespace App\Providers;

use App\Entries\EloquentSearchRepository;
use App\Entries\SearchRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SearchRepository::class, EloquentSearchRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
