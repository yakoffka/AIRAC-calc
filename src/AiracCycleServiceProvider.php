<?php
declare(strict_types=1);

namespace Yakoffka\AiracCycleDatesForLaravel;

use Illuminate\Support\ServiceProvider;

/**
 * Yo\AiracCycleDatesForLaravel\AiracCycleServiceProvider
 */
class AiracCycleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(AiracCycleService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
