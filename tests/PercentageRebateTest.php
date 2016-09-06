<?php

/**
 * Class PercentageRebateTest
 */
class PercentageRebateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\PercentageRebate
     */
    protected $rebate;

    /**
     *  Set up a default percentage rebate instance
     */
    protected function setUp()
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
    }

    /**
     * Test that invalid rebate amounts throw an error
     *
     * @param mixed $amount the rebate amount
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidValues
     */
    public function testAmountException($amount)
    {
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

        $this->assertEquals($expectedResult, $this->rebate->calculate($cost));
    }

    /**
     * Test that an invalid item cost throws an exception
     *
     * @param mixed $cost the item cost
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidValues
     */
    public function testCalculateException($cost)
    {
        $this->rebate->calculate($cost);
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
            ["abc"],
            [-25],
            [false],
            [null],
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
