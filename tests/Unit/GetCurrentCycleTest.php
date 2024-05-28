<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::getCurrentCycle()
 */
class GetCurrentCycleTest extends TestCase
{
    #[Test]
    #[DataProvider('provider2')]
    #[TestDox('Получение текущего цикла с указанием даты')]
    public function get_current_cycle_with_arg(string $date, string $expected): void
    {
        $actual = $this->service->getCurrentCycle($date);

        $this->assertSame($expected, $actual);
    }

    #[Test]
    #[TestDox('Получение текущего цикла без указания даты')]
    public function test_get_current_cycle_without_arg(): void
    {
        $actual = $this->service->getCurrentCycle();

        $this->assertSame(4, strlen($actual));
    }

    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     */
    public static function provider2(): array
    {
        return [
            ['2023-01-26' , '2301'], // эталонная дата! 1 день 01-го цикла

            // 01-ый день
            ['2016-01-07', '1601'], // 01-го цикла
            ['2016-05-26', '1606'], // 06-го цикла
            ['2016-11-10', '1612'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2016-12-08', '1613'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-03', '2013'], // 13-го (предпоследнего) цикла в високосном году
            ['2020-12-31', '2014'], // 14-го (предпоследнего) цикла в високосном году
            ['2021-01-28', '2101'], // 01-го цикла, следующего за високосным годом

            // 28-ой день
            ['2016-02-03', '1601'], // 01-го цикла
            ['2016-06-22', '1606'], // 06-го цикла
            ['2016-12-07', '1612'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2017-01-04', '1613'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-30', '2013'], // 13-го (предпоследнего) цикла в високосном году
            ['2021-01-27', '2014'], // 14-го (предпоследнего) цикла в високосном году
            ['2021-02-24', '2101'], // 01-го цикла, следующего за високосным годом

            // рандомный день
            ['2020-01-10', '2001'], // 01-го цикла
            ['2022-01-10', '2113'], // 13-го цикла предыдущего года
        ];
    }
}