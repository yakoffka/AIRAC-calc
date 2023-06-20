<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc;

/**
 * Методы, проверяющие принадлежность даты дню цикла AIRAC.
 */
class IsDayService
{
    private AiracCalcService $airacCalcService;

    /**
     * Дата является первым днем цикла AIRAC
     */
    public function __construct()
    {
         $this->airacCalcService = resolve(AiracCalcService::class);
    }

    /**
     * Является ли переданная дата указанным днем цикла AIRAC
     *
     * @param int $day - Предполагаемый день цикла (1-28)
     * @param string|null $dateString - Проверяемая дата в строковом представлении 'Y-m-d'. По умолчанию - текущая дата
     * @return bool
     */
    public function isDay(int $day, ?string $dateString = null): bool
    {
        return $this->airacCalcService->getCycleDay($dateString) === $day;
    }

    /**
     * Является ли переданная дата первым днем цикла AIRAC
     *
     * @param string|null $dateString Дата в строковом представлении 'Y-m-d'
     * @return bool
     */
    public function isFirstDay(?string $dateString = null): bool
    {
        return $this->isDay(1, $dateString);
    }

    /**
     * Является ли переданная дата последним днем цикла AIRAC
     *
     * @param string|null $dateString Дата в строковом представлении 'Y-m-d'
     * @return bool
     */
    public function isLastDay(?string $dateString = null): bool
    {
        return $this->isDay(28, $dateString);
    }

}