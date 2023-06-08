<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * Тестирование метода AiracCalc::getStartDate()
 */
class GetStartDateTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['2301', '2023-01-26'],
            ['2312', '2023-11-30'],
            ['2212', '2022-12-01'],
            // ['2215', '2022-12-01'], // @todo добавить exception для неверных входных данных!
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_start_date(string $cycle, string $expected): void
    {
        $actual = $this->service->getStartDate($cycle);

        $this->assertSame($expected, $actual);
    }
}
