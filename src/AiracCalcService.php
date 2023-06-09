<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

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
     * Эталонный цикл AIRAC.
     * В качестве эталона принимаю первый цикл AIRAC 2023 года.
     */
    public const STANDARD_CYCLE = '2301';

    /**
     * Дата первого дня эталонного (для данного класса) первого цикла AIRAC в строковом представлении.
     * В качестве эталона принимаю первый цикл AIRAC 2023 года.
     */
    public const STANDARD_DATA = '2023-01-26';

    private const DUMP_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var CarbonImmutable|null Дата первого дня эталонного (для данного класса) первого цикла AIRAC
     */
    public ?CarbonImmutable $standardFirstDay = null;

    /**
     * Установка значения даты начала эталонного первого цикла AIRAC
     */
    public function __construct()
    {
        $this->setStandardFirstDay();
    }

    /**
     * Получение дня цикла AIRAC для переданной (или текущей) даты: от 1 до 28
     *
     * @param string|null $dateString Дата в строковом представлении 'Y-m-d'
     * @return int
     */
    public function getCycleDay(?string $dateString = null): int
    {
        $carbonDate = $this->toCarbonImmutableDate($dateString);
        $signDiffInDays = $this->getSignDiffToStandardDateInDays($carbonDate);
        $modulo = $signDiffInDays % self::DAYS_IN_CYCLE;

        $cycleDay = $modulo < 0 ? 28 + $modulo : $modulo;

        return ++$cycleDay;
    }

    /**
     * Получение цикла AIRAC для переданной (или текущей) даты.
     *
     * @param string|null $dateString Дата в строковом представлении 'Y-m-d'
     * @return string
     */
    public function getCurrentCycle(?string $dateString = null): string
    {
        $cycleDay = $this->getCycleDay($dateString);
        $firstDay = $this->toCarbonImmutableDate($dateString)->subDays($cycleDay - 1);
        $dayOfYear = $firstDay->dayOfYear();
        $numCycle = intdiv($dayOfYear - 1, $this::DAYS_IN_CYCLE) + 1;

        return $firstDay->format('y') . str_pad((string)$numCycle, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Получение цикла AIRAC, предшествующего текущему для переданной (или текущей) даты.
     *
     * @param string|null $dateString Дата в строковом представлении 'Y-m-d'
     * @return string
     */
    public function getPrevCycle(?string $dateString = null): string
    {
        $dateFromPrevCycle = $this->toCarbonImmutableDate($dateString)->subDays($this::DAYS_IN_CYCLE);

        return $this->getCurrentCycle($dateFromPrevCycle->toDateString());
    }

    /**
     * Получение цикла AIRAC, следующего за текущим для переданной (или текущей) даты.
     *
     * @param string|null $dateString Дата в строковом представлении 'Y-m-d'
     * @return string
     */
    public function getNextCycle(?string $dateString = null): string
    {
        $dateFromNextCycle = $this->toCarbonImmutableDate($dateString)->addDays($this::DAYS_IN_CYCLE);

        return $this->getCurrentCycle($dateFromNextCycle->toDateString());
    }

    /**
     * Получение цикла AIRAC, предшествующего переданному циклу.
     *
     * @param string $airacCycle Идентификатор цикла AIRAC
     * @return string
     */
    public function getPrevByAirac(string $airacCycle): string
    {
        $firstDay = $this->getFirstDayByAirac($airacCycle);

        return $this->getPrevCycle($firstDay->toDateString());
    }

    /**
     * Получение цикла AIRAC, следующего за переданным циклом.
     *
     * @param string $airacCycle Идентификатор цикла AIRAC
     * @return string
     */
    public function getNextByAirac(string $airacCycle): string
    {
        $firstDay = $this->getFirstDayByAirac($airacCycle);

        return $this->getNextCycle($firstDay->toDateString());
    }

    /**
     * Получение массива дат вступления в силу циклов AIRAC из интервала, полученного по необязательным параметрам $start и $end.
     * Если параметры не переданы, то используется даты '2016-01-07' - '2040-12-06'.
     *
     * @param string $start Дата в строковом представлении 'Y-m-d'
     * @param string $end Дата в строковом представлении 'Y-m-d'
     * @return Collection
     */
    public function getEffectiveDates(string $start = '2016-01-07', string $end = '2040-12-06'): Collection
    {
        $startAt = Carbon::createFromDate($start);
        $endAt = CarbonImmutable::createFromDate($end);
        $diffInDays = $startAt->diffInDays($endAt);

        $effectiveDates = collect([]);

        for ($i = 0; $i < $diffInDays; $i++) {
            $cycleDay = $this->getCycleDay($startAt->toDateString());
            if ($cycleDay === 1) {
                $effectiveDates->push($startAt->toDateString());
            }
            $startAt->addDay();
        }

        return $effectiveDates->groupBy(function (string $dateString) {
            return substr($dateString, 0, 4);
        });
    }

    /**
     * Получение даты указанного дня цикла AIRAC
     *
     * @param int $cycleDay
     * @param string $cycle
     * @return string
     */
     public function getDayDate(int $cycleDay, string $cycle): string
     {
         return $this->getFirstDayByAirac($cycle)->addDays($cycleDay -1)->toDateString();
     }

    // /**
    //  * Получение цикла AIRAC годичной давности.
    //  * @todo добавить getCycleSub(['year', count = 1], ['month', count = 1] ...)
    //  *
    //  * @return string
    //  */
    // public function getSubYearCycle(): string
    // {
    //     return $this->getCurrentCycle(now()->subYear()->toDateString());
    // }

    /**
     * Вывод массива дат вступления в силу циклов AIRAC из интервала, полученного по необязательным параметрам $start и $end.
     * Если параметры не переданы, то используется даты '2016-01-07' - '2040-12-06'.
     * Сравнение с источником данных https://en.wikipedia.org/wiki/Aeronautical_Information_Publication
     *
     * @param string $start Дата в строковом представлении 'Y-m-d'
     * @param string $end Дата в строковом представлении 'Y-m-d'
     * @return void
     */
    public function showEffectiveDates(string $start = '2016-01-07', string $end = '2040-12-06'): void
    {
        $grouped = $this->getEffectiveDates($start, $end);
        $eol = PHP_EOL . "        ";

        $result = '';
        $grouped->each(function (Collection $yearDates, string $year) use (&$result, $eol) {
            $result .= "$eol  $year year$eol";
            $yearDates->each(function (string $date, $key) use (&$result, $eol) {
                $result .= str_pad((string)++$key, 2, ' ', STR_PAD_LEFT) . ' ' . $date . $eol;
            });
        });

        echo $result;
    }

    /**
     * Установка даты начала эталонного (для данного класса) первого цикла AIRAC.
     */
    private function setStandardFirstDay(): void
    {
        $this->standardFirstDay = $this->toCarbonImmutableDate(self::STANDARD_DATA);
    }

    /**
     * Преобразование даты в строковом представлении в экземпляр класса CarbonImmutable:
     *  - установка текущей даты, если аргумент равен null;
     *  - сброс времени на 00:00
     *
     * @param string|null $date
     * @return CarbonImmutable
     */
    private function toCarbonImmutableDate(?string $date): CarbonImmutable
    {
        if ($date === null) {
            return CarbonImmutable::today();
        }

        return CarbonImmutable::createFromFormat('Y-m-d', $date)->setTime(0, 0);
    }

    /**
     * Преобразование даты в строковом представлении в экземпляр класса Carbon:
     *  - установка текущей даты, если аргумент равен null;
     *  - сброс времени на 00:00
     *
     * @param string|null $date
     * @return Carbon
     */
    private function toCarbonDate(?string $date): Carbon
    {
        if ($date === null) {
            return Carbon::today();
        }

        return Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0);
    }

    /**
     * Получение знаковой разницы между эталонной и переданной датами.
     * Если переданная дата находится в прошлом относительно эталонной, то возвращает отрицательное значение
     *
     * @param CarbonImmutable $date
     * @return int
     */
    private function getSignDiffToStandardDateInDays(CarbonImmutable $date): int
    {
        $diffInDays = $this->standardFirstDay->diffInDays($date);
        $sign = $this->standardFirstDay->greaterThan($date) ? -1 : 1;

        return $sign * $diffInDays;
    }

    /**
     * Получение даты первого дня AIRAC цикла по его идентификатору
     *
     * @param string $airacCycle
     * @return Carbon
     * @todo оптимизировать!
     */
    private function getFirstDayByAirac(string $airacCycle): Carbon
    {
        $firstDay = $this->toCarbonDate(self::STANDARD_DATA);
        $method = substr($airacCycle, 0, 2) < $firstDay->format('y')
            ? 'subDays'
            : 'addDays';

        while ($this->getCurrentCycle($firstDay->toDateString()) !== $airacCycle) {
            $firstDay->$method($this::DAYS_IN_CYCLE);
            // dump($firstDay->format($this::DUMP_FORMAT));
        }

        return $firstDay;
    }
}
