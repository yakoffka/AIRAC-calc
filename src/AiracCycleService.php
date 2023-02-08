<?php
declare(strict_types=1);

namespace Yakoffka\AiracCycleDatesForLaravel;

use Carbon\Carbon;

/**
 * Методы для расчетов, связанных с циклами AIRAC.
 *
 * AIRAC - система заблаговременного уведомления об изменениях аэронавигационных данных по единой таблице дат вступления
 * их в силу. Аббревиатура AIRAC расшифровывается как Aeronautical Information Regulation And Control, что означает
 * Регламентирование и контроль аэронавигационной информации.
 * Обычно один год содержит 13 циклов AIRAC, но иногда бывает 14 циклов AIRAC (1976, 1998 и 2020).
 */
class AiracCycleService
{
    /**
     * Количество дней в цикле
     */
    public const DAYS_IN_CYCLE = 28;

    /**
     * Массив дат начала эталонного (для данного класса) первого цикла AIRAC
     */
    public const STANDARD_DATA = [2023, 01, 26];

     /**
      * @var Carbon|null Дата начала эталонного (для данного класса) первого цикла AIRAC
      */
     public ?Carbon $standard = null;

    /**
     *
     */
    public function __construct()
    {
         $this->standard = Carbon::createFromDate(2023, 01, 26);
    }

    /**
     * Получение дня цикла для переданной (или текущей) даты: от 1 до 28
     *
     * @param Carbon|null $datetime
     * @return int
     */
    public function getCycleDay(?Carbon $datetime = null): int
    {
        // App\Services\Airac\AiracService::getCycleDay(now()->subDays(2));
        // App\Services\Airac\AiracService::getCycleDay(\Carbon\Carbon::createFromDate(2023, 01, 26));
        $datetime ??= now();
        $datetime->setTime(0, 0);

        $signDiffInDays = $this->getSignDiffInDays($datetime);
        $modulo = $signDiffInDays % self::DAYS_IN_CYCLE;

        $cycleDay = $modulo < 0 ? 28 + $modulo : $modulo;

        dump("diff = $signDiffInDays; modulo = $modulo");

        return ++$cycleDay;
    }

    /**
     * Получение разницы между эталонной и переданной датами.
     * Если переданная дата находится в прошлом относительно эталонной, то возвращает отрицательное значение
     *
     * @param Carbon $datetime
     * @return int
     */
    private function getSignDiffInDays(Carbon $datetime): int
    {
        // $standard = Carbon::createFromDate(...self::STANDARD_DATA);
        // $standard->setTime(0, 0);
        $diffInDays = $this->standard->diffInDays($datetime);
        dump('standart = ' . $this->standard->format('Y-m-d H:i:s'));
        dump('$datetime = ' . $datetime->format('Y-m-d H:i:s'));
        dump('diffInDays = ' . $diffInDays);
        $sign = $this->standard->greaterThan($datetime) ? -1 : 1;
        dump('$sign = ' . $sign);
        dump('DiffInDays = ' . ($sign * $diffInDays));

        return $sign * $diffInDays;
    }
}