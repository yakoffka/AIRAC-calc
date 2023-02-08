<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc;

use Illuminate\Support\ServiceProvider;

/**
 * Yo\AiracCalc\AiracCalcServiceProvider
 */
class AiracCalcServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(AiracCalcService::class);
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
