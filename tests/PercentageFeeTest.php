<?php

namespace RebateCalculator\Tests;

/**
 * Class PercentageFeeTest
 */
class PercentageFeeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\PercentageFee
     */
    protected $fee;

    /**
     * Set up a default percentage fee instance
     */
    protected function setUp()
    {
        $this->fee = new \RebateCalculator\PercentageFee(10);
    }

    /**
     * Test that fee amount is set correctly and can be fetched
     *
     * @param mixed $amount the fee amount
     * @param float $expectedValue the actual fee amount
     *
     * @dataProvider providerValidFeeAmounts
     */
    public function testAmount($amount, $expectedValue)
    {
        $this->fee = new \RebateCalculator\PercentageFee($amount);

        $this->assertEquals($expectedValue, $this->fee->getAmount());
        $this->assertInternalType('float', $this->fee->getAmount());
    }

    /**
     * Test that invalid fee amounts throw an error
     *
     * @param mixed $amount the fee amount
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidAmounts
     */
    public function testAmountException($amount)
    {
        new \RebateCalculator\PercentageFee($amount);
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
        $this->fee = new \RebateCalculator\PercentageFee($amount);

        $this->assertEquals($expectedResult, $this->fee->calculate($topUp));
    }

    /**
     * Test that an invalid top-up amount throws an exception
     *
     * @param mixed $topUp the top-up amount
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidAmounts
     */
    public function testCalculateException($topUp)
    {
        $this->fee->calculate($topUp);
    }

    /**
     * Valid values for fee amounts
     *
     * @return array
     */
    public function providerValidFeeAmounts()
    {
        return array(
            [25,    25],
            ['25',  25],
            [1.234, 1.234],
        );
    }

    /**
     * Invalid values for fee amounts
     *
     * @return array
     */
    public function providerInvalidAmounts()
    {
        return [
            ['abc'],
            [-10],
            [false],
            [null],
        ];
    }

    /**
     * Values for fee amounts, top-up values and expected fee totals
     *
     * @return array
     */
    public function providerCalculateValues()
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
