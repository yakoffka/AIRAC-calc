<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit\IsDay;

use Yakoffka\AiracCalc\IsDayService;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::isFirstDay()
 */
class IsFirstDayTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['2016-01-07', true],
            ['2021-01-28', true],
            ['2016-01-08', false],
            ['2016-01-09', false],
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function is_first_day(string $date, bool $expected): void
    {
        $actual = resolve(IsDayService::class)->isFirstDay($date);
        // dump("$date " . ($actual ? 'true' : 'false'));

        $this->assertSame($expected, $actual);
    }
}