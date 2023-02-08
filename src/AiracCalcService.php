<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc;

use Carbon\Carbon;

/**
 * Методы для расчетов, связанных с циклами AIRAC.
 *
 * AIRAC - система заблаговременного уведомления об изменениях аэронавигационных данных по единой таблице дат вступления
 * их в силу.
 *
 * AIRAC - Aeronautical Information Regulation And Control (Регламентирование и контроль аэронавигационной информации).
 * Один год содержит 13, реже 14 (1976, 1998 и 2020) циклов AIRAC.
 */
class AiracCalcService
{
    /**
     * Количество дней в цикле
     */
    public const DAYS_IN_CYCLE = 28;

    /**
     * Массив даты первого дня эталонного (для данного класса) первого цикла AIRAC
     */
    public const STANDARD_DATA = [2023, 1, 26];

    /**
     * @var Carbon|null Дата первого дня эталонного (для данного класса) первого цикла AIRAC
     */
    public ?Carbon $standard = null;

    /**
     * Установка значения даты начала эталонного первого цикла AIRAC
     */
    public function __construct()
    {
        $this->setStandardDateTime();
    }

    /**
     * Получение дня цикла AIRAC для переданной (или текущей) даты: от 1 до 28
     * При передаче даты 2023-02-08 получим '2301'
     *
     * @param Carbon|null $datetime
     * @return int
     */
    public function getCycleDay(?Carbon $datetime = null): int
    {
        $datetime = $this->normalizeDate($datetime);

        $signDiffInDays = $this->getSignDiffInDays($datetime);
        $modulo = $signDiffInDays % self::DAYS_IN_CYCLE;

        $cycleDay = $modulo < 0 ? 28 + $modulo : $modulo;

        return ++$cycleDay;
    }

    /**
     * Получение цикла AIRAC для переданной (или текущей) даты.
     * При передаче даты 2023-02-08 получим '2301'
     *
     * @param Carbon|null $datetime
     * @return string
     */
    public function getCurrentCycle(?Carbon $datetime = null): string
    {
        $datetime = $this->normalizeDate($datetime);

        $cycleDay = $this->getCycleDay($datetime);
        $datetimeStartCurrentCycle = $datetime->subDays($cycleDay);
        $dayOfYear = $datetimeStartCurrentCycle->dayOfYear();
        $numCycle = intdiv($dayOfYear, $this::DAYS_IN_CYCLE) + 1;

        return $datetime->format('y') . str_pad((string)$numCycle, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Получение цикла AIRAC, следующего за текущим для переданной (или текущей) даты.
     * При передаче даты 2023-02-08 получим '2302'
     *
     * @param Carbon|null $datetime
     * @return string
     */
    public function getNextCycle(?Carbon $datetime = null): string
    {
        $datetime = $this->normalizeDate($datetime);

        $cycleDay = $this->getCycleDay($datetime);
        $datetimeStartCurrentCycle = $datetime->subDays($cycleDay);
        $dayOfYear = $datetimeStartCurrentCycle->dayOfYear();
        $numCycle = intdiv($dayOfYear, $this::DAYS_IN_CYCLE) + 1;

        $startNextYear = Carbon::createFromDate($datetime->year + 1, 1, 1);
        $startNextYear->setTime(0, 0);

        $daysLeftInYear = $datetimeStartCurrentCycle->diffInDays($startNextYear);

        if (intdiv($daysLeftInYear, $this::DAYS_IN_CYCLE) > 0) {
            $year = $datetime->format('y');
            $numCycle++;
        } else {
            $year = $startNextYear->format('y');
            $numCycle = 1;
        }

        return $year . str_pad((string)$numCycle, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Установка даты начала эталонного (для данного класса) первого цикла AIRAC.
     */
    private function setStandardDateTime(): void
    {
        $this->standard = Carbon::createFromDate(...$this::STANDARD_DATA);
        $this->standard->setTime(0, 0);
    }

    /**
     * Получение знаковой разницы между эталонной и переданной датами.
     * Если переданная дата находится в прошлом относительно эталонной, то возвращает отрицательное значение
     *
     * @param Carbon $datetime
     * @return int
     */
    private function getSignDiffInDays(Carbon $datetime): int
    {
        $diffInDays = $this->standard->diffInDays($datetime);
        $sign = $this->standard->greaterThan($datetime) ? -1 : 1;

        return $sign * $diffInDays;
    }

    /**
     * Нормализация даты:
     *  - установка текущего значения, если дата не передана;
     *  - установка времени в 00:00
     *
     * @param Carbon|null $datetime
     * @return Carbon
     */
    private function normalizeDate(?Carbon $datetime): Carbon
    {
        $datetime ??= now();
        $datetime->setTime(0, 0);

        return $datetime;
    }
}
