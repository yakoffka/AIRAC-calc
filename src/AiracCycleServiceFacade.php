<?php
declare(strict_types=1);

namespace Yakoffka\AiracCycleDatesForLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * Yakoffka\AiracCycleDatesForLaravel\AiracCycleServiceFacade
 */
class AiracCycleServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return AiracCycleService::class;
    }
}