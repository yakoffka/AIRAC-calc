<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * EffectiveDatesTest - тестирование получения и показа дат вступления в силу циклов AIRAC:
 * методы AiracCalc::getEffectiveDates() и AiracCalc::showEffectiveDates()
 */
class EffectiveDatesTest extends TestCase
{
    private const SHOWED_DATES_20160107_20210107 = '
          2016 year
         1 2016-01-07
         2 2016-02-04
         3 2016-03-03
         4 2016-03-31
         5 2016-04-28
         6 2016-05-26
         7 2016-06-23
         8 2016-07-21
         9 2016-08-18
        10 2016-09-15
        11 2016-10-13
        12 2016-11-10
        13 2016-12-08
        
          2017 year
         1 2017-01-05
         2 2017-02-02
         3 2017-03-02
         4 2017-03-30
         5 2017-04-27
         6 2017-05-25
         7 2017-06-22
         8 2017-07-20
         9 2017-08-17
        10 2017-09-14
        11 2017-10-12
        12 2017-11-09
        13 2017-12-07
        
          2018 year
         1 2018-01-04
         2 2018-02-01
         3 2018-03-01
         4 2018-03-29
         5 2018-04-26
         6 2018-05-24
         7 2018-06-21
         8 2018-07-19
         9 2018-08-16
        10 2018-09-13
        11 2018-10-11
        12 2018-11-08
        13 2018-12-06
        
          2019 year
         1 2019-01-03
         2 2019-01-31
         3 2019-02-28
         4 2019-03-28
         5 2019-04-25
         6 2019-05-23
         7 2019-06-20
         8 2019-07-18
         9 2019-08-15
        10 2019-09-12
        11 2019-10-10
        12 2019-11-07
        13 2019-12-05
        
          2020 year
         1 2020-01-02
         2 2020-01-30
         3 2020-02-27
         4 2020-03-26
         5 2020-04-23
         6 2020-05-21
         7 2020-06-18
         8 2020-07-16
         9 2020-08-13
        10 2020-09-10
        11 2020-10-08
        12 2020-11-05
        13 2020-12-03
        14 2020-12-31
        ';

    /**
     * Проверка количества элементов в полученной коллекции на ограниченном интервале времени (5 лет)
     *      полученная коллекция должна состоять из 5 вложенных коллекций;
     *      каждая вложенная коллекция (кроме последней) должна содержать 13 циклов
     *      последняя вложенная коллекция должна содержать 14 циклов (2020 - високосный год AIRAC)
     *
     * @test
     */
    public function get_effective_dates_count(): void
    {
        $effectiveDates = $this->service->getEffectiveDates('2016-01-07', '2021-01-07');

        $dates = $effectiveDates->toArray();

        $this->assertCount(5, $effectiveDates);
        $this->assertCount(13, $dates['2016']);
        $this->assertCount(13, $dates['2017']);
        $this->assertCount(13, $dates['2018']);
        $this->assertCount(13, $dates['2019']);
        $this->assertCount(14, $dates['2020']); // 2020 - високосный год AIRAC
    }

    /**
     * Проверка показа дат вступления в силу циклов AIRAC на ограниченном интервале времени (5 лет)
     *
     * @test
     */
    public function show_effective_dates(): void
    {
        // $this->service->showEffectiveDates('2016-01-07', '2021-01-07');
        // $this->service->showEffectiveDates('2016-01-07', '2024-12-31');

        ob_start();
        $this->service->showEffectiveDates('2016-01-07', '2021-01-07');
        $out1 = ob_get_clean();

        $this->assertSame($this::SHOWED_DATES_20160107_20210107, $out1);
    }
}