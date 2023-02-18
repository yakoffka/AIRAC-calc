<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::getCurrentCycle()
 */
class GetCurrentCycleTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
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
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_current_cycle_with_arg(string $date, string $expected): void
    {
        $actual = $this->service->getCurrentCycle($date);

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function get_current_cycle_without_arg(): void
    {
        $actual = $this->service->getCurrentCycle();

        $this->assertSame(4, strlen($actual));
    }
}