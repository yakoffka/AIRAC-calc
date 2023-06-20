<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::getNumberCyclesPerYear()
 */
class GetNumberCyclesPerYearTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['2016', 13],
            ['2017', 13],
            ['2018', 13],
            ['2019', 13],
            ['2020', 14],
            ['2021', 13],
            ['2022', 13],
            ['2023', 13],
            ['2024', 13],
            ['2025', 13],
            ['2026', 13],
            ['2027', 13],
            ['2028', 13],
            ['2029', 13],
            ['2030', 13],
            ['2031', 13],
            ['2032', 13],
            ['2033', 13],
            ['2034', 13],
            ['2035', 13],
            ['2036', 13],
            ['2037', 13],
            ['2038', 13],
            ['2039', 13],
            ['2040', 13],
            ['2043', 14],
            ['2065', 14],
            ['2088', 14],
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_number_cycles_per_year(string $year, int $expected): void
    {
        $actual = $this->service->getNumberCyclesPerYear($year);
        // echo "$year  $expected/$actual" . ($actual !== $expected ? ' ERROR' : '') . PHP_EOL;

        $this->assertSame($expected, $actual);
    }
}