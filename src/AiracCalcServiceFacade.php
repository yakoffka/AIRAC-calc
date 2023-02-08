<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc;

use Illuminate\Support\Facades\Facade;

/**
 * Yakoffka\AiracCalc\AiracCalcServiceFacade
 */
class AiracCalcServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return AiracCalcService::class;
    }
}