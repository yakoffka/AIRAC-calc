<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCurrentCycleTest - тестирование метода AiracCalc::isValidCycle()
 */
class IsValidCycleTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['0001', true],
            ['2301', true],
            ['2302', true],
            ['2303', true],
            ['2304', true],
            ['2305', true],
            ['2306', true],
            ['2307', true],
            ['2308', true],
            ['2309', true],
            ['2310', true],
            ['2311', true],
            ['2312', true],
            ['2313', true],

            ['2300', false],
            ['2314', false],
            ['-2301', false],
            ['234v', false],
            ['0000', false],
            ['2000', false],
            ['0', false],
            ['string', false],
            ['9999', false],
            ['23454', false],
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function is_valid_cycle(string $cycle, bool $expected): void
    {
        $actual = $this->service->isValidCycle($cycle);
        // echo $cycle . ($expected ? ' true' : ' false') . ($actual ? ' true' : ' false') . ($actual!==$expected ? ' ERROR' : '') . PHP_EOL;

        $this->assertSame($expected, $actual);
    }
}