<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Carbon\Carbon;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::getCurrentCycle()
 */
class GetCurrentCycleTest extends TestCase
{
    /**
     * Получение ожидаемых результатов для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        $sets = [
            // 01-ый день
            ['2016-01-07', '1601'], // 01-го цикла
            ['2016-05-26', '1606'], // 06-го цикла
            ['2016-11-10', '1612'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2016-12-08', '1613'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-03', '2013'], // 13-го (предпоследнего) цикла в високосном году
            ['2020-12-31', '2014'], // 14-го (предпоследнего) цикла в високосном году

            // 28-ой день
            ['2016-02-03', '1601'], // 01-го цикла
            ['2016-06-22', '1606'], // 06-го цикла
            ['2016-12-07', '1612'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2017-01-04', '1613'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-30', '2013'], // 13-го (предпоследнего) цикла в високосном году
            ['2021-01-27', '2014'], // 14-го (предпоследнего) цикла в високосном году
        ];

        return array_map(static function (array $set) {
            return [Carbon::createFromDate(...(explode('-', $set[0]))), $set[1]];
        }, $sets);
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_current_cycle(Carbon $date, string $expected): void
    {
        $actual = $this->service->getCurrentCycle($date);

        $this->assertSame($expected, $actual);
    }
}