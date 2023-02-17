<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Carbon\Carbon;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetPrevCycleTest - тестирование метода AiracCalc::getPrevCycle()
 */
class GetPrevCycleTest extends TestCase
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
            ['2016-01-07', '1513'], // 01-го цикла
            ['2016-05-26', '1605'], // 06-го цикла
            ['2016-11-10', '1611'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2016-12-08', '1612'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-03', '2012'], // 13-го (предпоследнего) цикла в високосном году
            ['2020-12-31', '2013'], // 14-го (предпоследнего) цикла в високосном году
            ['2021-01-28', '2014'], // 01-го цикла, следующего за високосным годом

            // 28-ой день
            ['2016-02-03', '1513'], // 01-го цикла
            ['2016-06-22', '1605'], // 06-го цикла
            ['2016-12-07', '1611'], // 12-го (предпоследнего) цикла в невисокосном году
            ['2017-01-04', '1612'], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-30', '2012'], // 13-го (предпоследнего) цикла в високосном году
            ['2021-01-27', '2013'], // 14-го (предпоследнего) цикла в високосном году
            ['2021-02-24', '2014'], // 01-го цикла, следующего за високосным годом
        ];

        return array_map(static function (array $set) {
            return [Carbon::createFromDate(...(explode('-', $set[0]))), $set[1]];
        }, $sets);
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_prev_cycle(Carbon $date, string $expected): void
    {
        $actual = $this->service->getPrevCycle($date);

        $this->assertSame($expected, $actual);
    }
}