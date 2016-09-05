<?php

/**
 * Class FlatFeeTest
 */
class FlatFeeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\FlatFee
     */
    protected $fee;

    /**
     *  Set up a flat fee instance
     */
    protected function setUp()
    {
        $this->fee = new \RebateCalculator\FlatFee(10);
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
        $this->fee = new \RebateCalculator\FlatFee($amount);

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
        new \RebateCalculator\FlatFee($amount);
    }

    /**
     * @return array
     */
    public function providerCalculateValues()
    {
        // array(fee amount, top-up value, expected cost)
        return array(
            array(10,    25,    10),
            array("10",  25,    10),
            array(0,     25,    0),
            array(1.252, 25,    1.25),
            array(10,    0,     0),
            array(10,    "25",  10),
        );
    }

    /**
     * @param $amount
     * @param $topUp
     * @param $expectedResult
     *
     * @dataProvider providerCalculateValues
     */
    public function testCalculate($amount, $topUp, $expectedResult)
    {
        $this->fee = new \RebateCalculator\FlatFee($amount);

        $this->assertEquals($expectedResult, $this->fee->calculate($topUp));
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
     * @param $topUp
     *
     * @expectedException \Exception
     * @dataProvider providerCalculateValuesException
     */
    public function testCalculateException($topUp)
    {
        $this->fee->calculate($topUp);
    }
}
