<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Yakoffka\AiracCalc\AiracCalcServiceFacade;
use Yakoffka\AiracCalc\AiracCalcServiceProvider;

/**
 *
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            AiracCalcServiceProvider::class,
        ];
    }

    /**
     * Override application aliases.
     *
     * @param Application $app
     *
     * @return array<string, class-string<Facade>>
     */
    protected function getPackageAliases($app)
    {
        return [
            'AiracCalc' => AiracCalcServiceFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}