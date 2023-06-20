<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit\IsDay;

use Yakoffka\AiracCalc\IsDayService;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::isLastDay()
 */
class IsLastDayTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['2016-01-07', false],
            ['2016-01-08', false],
            ['2016-02-03', true],
            ['2016-02-03', true],
            ['2016-06-22', true],
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function is_last_day(string $date, bool $expected): void
    {
        $actual = resolve(IsDayService::class)->isLastDay($date);
        // dump("$date " . ($actual ? 'true' : 'false'));

        $this->assertSame($expected, $actual);
    }
}