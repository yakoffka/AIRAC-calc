<?php
declare(strict_types=1);

namespace Yakoffka\AiracCalc\Tests\Unit;

use Yakoffka\AiracCalc\AiracCalcService;
use Yakoffka\AiracCalc\Tests\TestCase;

/**
 * TestCase
 */
class EffectiveDatesTest extends TestCase
{
    /**
     * @test
     */
    public function get_effective_dates()
    {
        $effectiveDates = (new AiracCalcService())->getEffectiveDates('2016-01-07', '2021-01-07');

        // dd($effectiveDates);
         $dates = $effectiveDates->toArray();

        $this->assertCount(5, $effectiveDates);
        $this->assertCount(13, $dates['2016']);
        $this->assertCount(13, $dates['2017']);
        $this->assertCount(13, $dates['2018']);
        $this->assertCount(13, $dates['2019']);
        $this->assertCount(14, $dates['2020']);
    }
    /**
     * @test
     */
    public function show_effective_dates()
    {
        (new AiracCalcService())->showEffectiveDates();
        (new AiracCalcService())->showEffectiveDates('2016-01-07', '2021-01-07');

        $this->assertSame(1,1);
    }
}