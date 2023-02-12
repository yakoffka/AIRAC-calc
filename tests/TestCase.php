<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Yakoffka\AiracCalc\AiracCalcService;
use Yakoffka\AiracCalc\AiracCalcServiceFacade;
use Yakoffka\AiracCalc\AiracCalcServiceProvider;

/**
 * Yakoffka\AiracCalc\Tests\TestCase
 *
 * Пример вызова тестов: $ docker-compose exec php vendor/bin/testbench package:test
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Стартовая дата тестового интервала. Является первым(!) днем цикла.
     *
     * Источник https://en.wikipedia.org/wiki/Aeronautical_Information_Publication#AIRAC_effective_dates_(28-day_cycle)
     */
    protected const START = '2016-01-07';

    /**
     * Конечная дата тестового интервала. Является первым(!) днем цикла.
     *
     * Источник https://en.wikipedia.org/wiki/Aeronautical_Information_Publication#AIRAC_effective_dates_(28-day_cycle)
     */
    protected const END = '2040-12-06';

    protected ?AiracCalcService $service;

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new AiracCalcService();
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            // AiracCalcServiceProvider::class,
        ];
    }

    /**
     * Override application aliases.
     *
     * @param Application $app
     *
     * @return array<string, class-string<Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [
            // 'AiracCalc' => AiracCalcServiceFacade::class,
        ];
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}