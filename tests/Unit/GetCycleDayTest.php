<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * GetCycleDayTest тестирование метода AiracCalc::getCycleDay() - получения дня цикла AIRAC.
 */
class GetCycleDayTest extends TestCase
{
    /**
     * Получение массива, содержащего входной параметр и ожидаемый результат для выборочных случаев
     */
    public static function provider(): array
    {
        return [
            // 01-ый день
            ['2016-01-07', 1], // 01-го цикла
            ['2016-05-26', 1], // 06-го цикла
            ['2016-11-10', 1], // 12-го (предпоследнего) цикла в невисокосном году
            ['2016-12-08', 1], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-03', 1], // 13-го (предпоследнего) цикла в високосном году
            ['2020-12-31', 1], // 14-го (предпоследнего) цикла в високосном году
            ['2021-01-28', 1], // 01-го цикла, следующего за високосным годом

            // 28-ой день
            ['2016-02-03', 28], // 01-го цикла
            ['2016-06-22', 28], // 06-го цикла
            ['2016-12-07', 28], // 12-го (предпоследнего) цикла в невисокосном году
            ['2017-01-04', 28], // 13-го (последнего) цикла в невисокосном году
            ['2020-12-30', 28], // 13-го (предпоследнего) цикла в високосном году
            ['2021-01-27', 28], // 14-го (предпоследнего) цикла в високосном году
            ['2021-02-24', 28], // 01-го цикла, следующего за високосным годом
        ];
    }

    #[Test]
    #[DataProvider('provider')]
    public function get_cycle_day_with_arg(string $date, int $expected): void
    {
        $actual = $this->service->getCycleDay($date);

        $this->assertSame($expected, $actual);
    }

    #[Test]
    public function get_cycle_day_without_arg(): void
    {
        $actual = $this->service->getCycleDay();

        $this->assertTrue($actual > 0);
        $this->assertTrue($actual < 28);
    }

    /**
     * Проверка правильного чередования номера дня цикла для каждого дня на протяжении всего тестового интервала
     */
    #[Test]
    public function get_cycle_day_correct_sequence(): void
    {
        $currentDay = Carbon::createFromDate($this::START);

        $diffInDays = $currentDay->diffInDays(Carbon::createFromDate($this::END));

        $j = 1;
        foreach (range(1, $diffInDays) as $i) {
            $cycleDay = $this->service->getCycleDay($currentDay->format('Y-m-d'));
            $this->assertSame($j, $cycleDay);

            $currentDay->addDay();

            if (++$j === 29) {
                $j = 1;
            }
        }
    }
}