<?php

namespace RebateCalculator\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class FlatFeeTest
 */
class FlatFeeTest extends TestCase
{
    /**
     * @var \RebateCalculator\FlatFee
     */
    protected $fee;

    /**
     * Set up a default flat fee instance
     */
    public function setUp(): void
    {
        $this->fee = new \RebateCalculator\FlatFee(10);
    }

    /**
     * Test that fee amount is set correctly and can be fetched
     *
     * @param mixed $amount the fee amount
     * @param $expectedValue
     *
     * @dataProvider providerValidFeeAmounts
     */
    public function testAmount($amount, $expectedValue)
    {
        $this->fee = new \RebateCalculator\FlatFee($amount);

        $this->assertEquals($expectedValue, $this->fee->getAmount());
        $this->assertIsFloat($this->fee->getAmount());
    }

    /**
     * Test that invalid fee amounts throw an error
     *
     * @param mixed $amount the fee amount
     *
     * @dataProvider providerInvalidAmounts
     */
    public function testAmountException($amount)
    {
        $this->expectException(\Exception::class);

        new \RebateCalculator\FlatFee($amount);
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
    public function testCalculate($amount, $topUp, $expectedResult)
    {
        $this->fee = new \RebateCalculator\FlatFee($amount);

        $this->assertEquals($expectedResult, $this->fee->calculate($topUp));
    }

    /**
     * Test that an invalid top-up amount throws an exception
     *
     * @param mixed $topUp the top-up amount
     *
     * @dataProvider providerInvalidAmounts
     */
    public function testCalculateException($topUp)
    {
        $this->expectException(\Exception::class);

        $this->fee->calculate($topUp);
    }

    /**
     * Valid values for fee amounts
     *
     * @return array
     */
    public function providerValidFeeAmounts()
    {
        return [
            [25, 25],
            ['25', 25],
            [1.234, 1.234],
            [0, 0]
        ];
    }

    /**
     * Invalid currency amounts that should throw an exception
     *
     * @return array
     */
    public function providerInvalidAmounts()
    {
        return [
            [-10],
        ];
    }

    /**
     * Values for fee amounts, top-up values and expected fee totals
     *
     * @return array
     */
    public function providerCalculateValues()
    {
        // fee amount, top-up amount, expected fee total
        return [
            [10,    25,    10],
            ["10",  25,    10],
            [0,     25,    0],
            [1.252, 25,    1.25],
            [10,    0,     0],
            [10,    "25",  10],
        ];
    }
}
