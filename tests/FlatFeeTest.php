<?php

namespace RebateCalculator\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RebateCalculator\FlatFee;

class FlatFeeTest extends TestCase
{
    /**
     * Test that a negative fee amounts throw an error
     */
    public function testAmountException(): void
    {
        $this->expectException(Exception::class);

        new FlatFee(-10);
    }

    /**
     * Test that fee values are calculated correctly
     *
     * @param float $amount the fee amount
     * @param float $topUp the top-up amount
     * @param float $expectedResult the expected fee cost
     *
     * @dataProvider providerCalculateValues
     */
    public function testCalculate(float $amount, float $topUp, float $expectedResult): void
    {
        $fee = new FlatFee($amount);

        $this->assertEquals($expectedResult, $fee->calculate($topUp));
    }

    /**
     * Test that a negative top-up amount throws an exception
     */
    public function testCalculateException(): void
    {
        $fee = new FlatFee(10);

        $this->expectException(Exception::class);

        $fee->calculate(-10);
    }

    /**
     * Valid values for fee amounts
     */
    public static function providerValidFeeAmounts(): array
    {
        return [
            [25, 25],
            ['25', 25],
            [1.234, 1.234],
            [0, 0]
        ];
    }

    /**
     * Values for fee amounts, top-up values and expected fee totals
     */
    public static function providerCalculateValues(): array
    {
        // fee amount, top-up amount, expected fee total
        return [
            [10,    25,    10],
            [10,  25,    10],
            [0,     25,    0],
            [1.252, 25,    1.25],
            [10,    0,     0],
            [10,    25,  10],
        ];
    }
}
