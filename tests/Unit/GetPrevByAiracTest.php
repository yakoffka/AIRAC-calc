<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetPrevByAiracTest - тестирование метода AiracCalc::GetPrevByAirac()
 */
class GetPrevByAiracTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['1601', '1513'], // идентификатор 01-го цикла
            ['1606', '1605'], // идентификатор 06-го цикла
            ['1612', '1611'], // идентификатор 12-го (предпоследнего) цикла в невисокосном году
            ['1613', '1612'], // идентификатор 13-го (последнего) цикла в невисокосном году
            ['2013', '2012'], // идентификатор 13-го (предпоследнего) цикла в високосном году
            ['2014', '2013'], // идентификатор 14-го (предпоследнего) цикла в високосном году
            ['2101', '2014'], // идентификатор 01-го цикла, следующего за високосным годом
        ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function get_prev(string $cycle, string $expected): void
    {
        $actual = $this->service->getPrevByAirac($cycle);

        $this->assertSame($expected, $actual);
    }
}