<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetNextCycleTest - тестирование метода AiracCalc::getNextCycle()
 */
class GetNextCycleTest extends TestCase
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
            ['2016-01-07', '1602'], // 01-го цикла
            ['2016-05-26', '1607'], // 06-го цикла
            ['2016-11-10', '1613'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2016-12-08', '1701'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-03', '2014'], // 13-го (предпоследнего) цикла в високосном году
            ['2020-12-31', '2101'], // 14-го (предпоследнего) цикла в високосном году
            ['2021-01-28', '2102'], // 01-го цикла, следующего за високосным годом

            // 28-ой день
            ['2016-02-03', '1602'], // 01-го цикла
            ['2016-06-22', '1607'], // 06-го цикла
            ['2016-12-07', '1613'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2017-01-04', '1701'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-30', '2014'], // 13-го (предпоследнего) цикла в високосном году
            ['2021-01-27', '2101'], // 14-го (предпоследнего) цикла в високосном году
            ['2021-02-24', '2102'], // 01-го цикла, следующего за високосным годом
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_next_cycle_with_arg(string $date, string $expected): void
    {
        $actual = $this->service->getNextCycle($date);

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function get_next_cycle_without_arg(): void
    {
        $actual = $this->service->getNextCycle();

        $this->assertSame(4, strlen($actual));
    }
}