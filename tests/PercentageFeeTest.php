<?php

/**
 * Class PercentageFeeTest
 */
class PercentageFeeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\PercentageFee
     */
    protected $fee;

    /**
     *  Set up a percentage fee instance
     */
    protected function setUp()
    {
        $this->fee = new \RebateCalculator\PercentageFee(10);
    }

    /**
     * Valid values for fee amounts
     *
     * @return array
     */
    public function providerFeeAmounts()
    {
        return array(
            array(25,    25),
            array('25',  25),
            array(1.234, 1.234),
        );
    }

    /**
     * @param $amount
     * @param $expectedValue
     *
     * @dataProvider providerFeeAmounts
     */
    public function testAmount($amount, $expectedValue)
    {
        $this->fee->setAmount($amount);

        $this->assertEquals($expectedValue, $this->fee->getAmount());
    }

    /**
     * Fee amounts that should throw an exception
     *
     * @return array
     */
    public function providerFeeAmountsException()
    {
        return array(
            array('abc'),
            array(-10),
            array(false, 0),
            array(null,  0),
        );
    }

    /**
     * @param $amount
     *
     * @expectedException \Exception
     * @dataProvider providerFeeAmountsException
     */
    public function testAmountException($amount)
    {
        $this->fee->setAmount($amount);
    }

    /**
     * @return array
     */
    public function providerCalculateValues()
    {
        // array(fee amount, topup value, expected cost)
        return array(
            array(10,    25,    2.5),
            array("10",  25,    2.5),
            array(0,     25,    0),
            array(10,    0,     0),
            array(10,    "25",  2.5),
        );
    }

    /**
     * @param $amount
     * @param $topup
     * @param $expectedResult
     *
     * @dataProvider providerCalculateValues
     */
    public function testCalculate($amount, $topup, $expectedResult)
    {
        $this->fee->setAmount($amount);

        $this->assertEquals($expectedResult, $this->fee->calculate($topup));
    }

    /**
     * @return array
     */
    public function providerCalculateValuesException()
    {
        return array(
            array("abc"),
            array(-25),
        );
    }

    /**
     * @param $topup
     *
     * @expectedException \Exception
     * @dataProvider providerCalculateValuesException
     */
    public function testCalculateException($topup)
    {
        $this->fee->calculate($topup);
    }
}
