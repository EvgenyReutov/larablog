<?php

namespace Tests\Unit;

use App\Services\CalcService;
use PHPUnit\Framework\TestCase;

/**
 * @group calc
 */
class CalcServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     *
     * @group  service
     * @dataProvider sumCalcValues
     */
    public function test_correct_sum($a, $b, $expected)
    {

        $service = app(CalcService::class);
        $actual = $service->sum($a, $b);

        return $this->assertEquals($expected, $actual);
    }


    public function sumCalcValues()
    {
        return [
            'with first zero' => [0, 5, 5],
            'random nums' => [2, 5, 7],
            'negative nums' => [-2, 5, 3],
        ];
    }
}
