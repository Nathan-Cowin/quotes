<?php

namespace App\Providers;

use App\Services\Quotes\QuotesManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: QuotesManager::class,
            concrete: fn (Applicatixon $app) => new QuotesManager($app),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
