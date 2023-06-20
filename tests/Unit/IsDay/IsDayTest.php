<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit\IsDay;

use Yakoffka\AiracCalc\IsDayService;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::isDay()
 */
class IsDayTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            [1, '2016-01-07', true],
            [2, '2016-01-08', true],
            [3, '2016-01-09', true],
            [4, '2016-01-10', true],
            [5, '2016-01-11', true],
            [6, '2016-01-12', true],
            [7, '2016-01-13', true],
            [8, '2016-01-14', true],
            [9, '2016-01-15', true],
            [10, '2016-01-16', true],
            [11, '2016-01-17', true],
            [12, '2016-01-18', true],
            [13, '2016-01-19', true],
            [14, '2016-01-20', true],
            [15, '2016-01-21', true],
            [16, '2016-01-22', true],
            [17, '2016-01-23', true],
            [18, '2016-01-24', true],
            [19, '2016-01-25', true],
            [20, '2016-01-26', true],
            [21, '2016-01-27', true],
            [22, '2016-01-28', true],
            [23, '2016-01-29', true],
            [24, '2016-01-30', true],
            [25, '2016-01-31', true],
            [26, '2016-02-01', true],
            [27, '2016-02-02', true],
            [28, '2016-02-03', true],

            [2, '2021-01-28', false], // 1
            [3, '2016-02-03', false], // 28

            [29, '2016-02-03', false], // Exception
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function is_day(int $day, string $date, bool $expected): void
    {
        $actual = resolve(IsDayService::class)->isDay($day, $date);
        // dump("$day $date " . ($actual ? 'true' : 'false'));

        $this->assertSame($expected, $actual);
    }
}