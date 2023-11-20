<?php

namespace RebateCalculator\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RebateCalculator\PercentageFee;

class PercentageFeeTest extends TestCase
{
    /**
     * Test that a negative fee amount throws an error
     */
    public function testAmountException(): void
    {
        $this->expectException(Exception::class);

        new PercentageFee(-10);
    }

    /**
     * Test that fee values are calculated correctly
     *
     * @param mixed $amount the fee amount
     * @param mixed $topUp the top-up amount
     * @param float $expectedResult the expected fee cost
     *
     * @dataProvider providerCalculateValues
     */
    public function testCalculate($amount, $topUp, float $expectedResult): void
    {
        $fee = new PercentageFee($amount);

        $this->assertEquals($expectedResult, $fee->calculate($topUp));
    }

    /**
     * Valid values for fee amounts
     */
    public function providerValidFeeAmounts(): array
    {
        return [
            [25,    25],
            ['25',  25],
            [1.234, 1.234],
        ];
    }

    /**
     * Values for fee amounts, top-up values and expected fee totals
     */
    public static function providerCalculateValues(): array
    {
        // fee amount, top-up value, expected total fee
        return [
            [10,    25,    2.5],
            ["10",  25,    2.5],
            [0,     25,    0],
            [10,    0,     0],
            [10,    "25",  2.5],
        ];
    }
}
