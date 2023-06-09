<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * Тестирование метода AiracCalc::getDayDate()
 */
class GetDayDateTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            [1,'2301', '2023-01-26'],
            [1,'2312', '2023-11-30'],
            [1,'2212', '2022-12-01'],
            [14, '2301', '2023-02-08'],
            [14, '2312', '2023-12-13'],
            [14, '2212', '2022-12-14'],
            [14, '2302', '2023-03-08'],
            // [29, '2215', '2022-12-01'], // @todo добавить exception для неверных входных данных!
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_start_date(int $cycleDay, string $cycle, string $expected): void
    {
        $actual = $this->service->getDayDate($cycleDay, $cycle);

        $this->assertSame($expected, $actual);
    }
}
