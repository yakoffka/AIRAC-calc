<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Carbon\Carbon;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCycleDayTest - тестирование метода AiracCalc::getCycleDay()
 */
class GetCycleDayTest extends TestCase
{
     /**
      * Тестирование получения дня цикла AIRAC.
      * Проверка правильного чередования номера дня цикла для каждого дня на протяжении всего тестового интервала
      *
      * @test
      */
     public function getCycleDayCorrectSequence(): void
     {
         $currentDay = Carbon::createFromDate($this::START);

         $diffInDays = $currentDay->diffInDays(Carbon::createFromDate($this::END));

         $j = 1;
         foreach (range(1, $diffInDays) as $i) {
             $cycleDay = $this->service->getCycleDay($currentDay);
             $this->assertSame($j, $cycleDay);

             $currentDay->addDay();

             if (++$j === 29) {
                 $j = 1;
             }
         }
     }

    //    /**
    //     * Массив смещения относительно стартовой даты дат для всех дней тестового интервала
    //     *
    //     * @return array
    //     */
    //    public function provider(): array
    //    {
    //        $startAt = Carbon::createFromDate($this::START);
    //        $endAt = Carbon::createFromDate($this::END);
    //        $diffInDays = $startAt->diffInDays($endAt);
    //
    //        return range(0, $diffInDays);
    //    }
    //
    //    /**
    //     * @test
    //     *
    //     * Тестирование получения дня цикла AIRAC для смещенного на $i относительно начала периода дня
    //     */
    //    public function getCycleDayCorrectSequence(int $offset): void
    //    {
    //        $startAt = Carbon::createFromDate($this::START)->addDays($offset);
    //
    //        $cycleDay = $this->service->getCycleDay($startAt);
    //    }
}