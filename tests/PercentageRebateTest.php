<?php

namespace RebateCalculator\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class PercentageRebateTest
 */
class PercentageRebateTest extends TestCase
{
    /**
     * @var \RebateCalculator\PercentageRebate
     */
    protected $rebate;

    /**
     *  Set up a default percentage rebate instance
     */
    public function setUp(): void
    {
        $this->rebate = new \RebateCalculator\PercentageRebate(10);
    }

    /**
     * Test that rebate amount is set correctly and can be fetched
     *
     * @param mixed $amount the rebate amount
     * @param float $expectedValue the actual rebate amount
     *
     * @dataProvider providerRebateAmounts
     */
    public function testAmount($amount, $expectedValue)
    {
        $this->rebate = new \RebateCalculator\PercentageRebate($amount);

        $this->assertEquals($expectedValue, $this->rebate->getAmount());
        $this->assertIsFloat($this->rebate->getAmount());
    }

    /**
     * Test that invalid rebate amounts throw an error
     *
     * @param mixed $amount the rebate amount
     *
     * @dataProvider providerInvalidValues
     */
    public function testAmountException($amount)
    {
        $this->expectException(\Exception::class);

        $this->rebate = new \RebateCalculator\PercentageRebate($amount);
    }

    /**
     * Test that rebate values are calculated correctly
     *
     * @param mixed $amount the rebate amount
     * @param mixed $cost the item cost
     * @param float $expectedResult the expected fee cost
     *
     * @dataProvider providerCalculateValues
     */
    public function testCalculate($amount, $cost, $expectedResult)
    {
        $this->rebate = new \RebateCalculator\PercentageRebate($amount);
        $item = new \RebateCalculator\Item($cost);

        $this->assertEquals($expectedResult, $this->rebate->calculate($item));
    }

    /**
     * Valid values for rebate amounts
     *
     * @return array
     */
    public function providerRebateAmounts()
    {
        return [
            [25, 25],
            ['25', 25],
            [1.234, 1.234],
        ];
    }

    /**
     * Invalid values for rebate amounts
     *
     * @return array
     */
    public function providerInvalidValues()
    {
        return [
            [-25],
        ];
    }

    /**
     * Values for rebate amounts, item costs and expected rebate totals
     *
     * @return array
     */
    public function providerCalculateValues()
    {
        // rebate amount, item cost, expected rebate
        return [
            [10,    25,    2.5],
            ["10",  25,    2.5],
            [0,     25,    0],
            [10,    0,     0],
            [10,    "25",  2.5],
        ];
    }
}
