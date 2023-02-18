<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetNextByAiracTest - тестирование метода AiracCalc::getNextByAirac()
 */
class GetNextByAiracTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['1601', '1602'], // идентификатор 01-го цикла
            ['1606', '1607'], // идентификатор 06-го цикла
            ['1612', '1613'], // идентификатор 12-го (предпоследнего) цикла в невисокосном году
            ['1613', '1701'], // идентификатор 13-го (последнего) цикла в невисокосном году
            ['2013', '2014'], // идентификатор 13-го (предпоследнего) цикла в високосном году
            ['2014', '2101'], // идентификатор 14-го (предпоследнего) цикла в високосном году
            ['2101', '2102'], // идентификатор 01-го цикла, следующего за високосным годом
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_next_by_airac(string $cycle, string $expected): void
    {
        $actual = $this->service->getNextByAirac($cycle);

        $this->assertSame($expected, $actual);
    }
}