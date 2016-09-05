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
     *  Set up a percentage rebate instance
     */
    protected function setUp()
    {
        $this->rebate = new \RebateCalculator\PercentageRebate(10);
    }

    /**
     * Valid values for rebate amounts
     *
     * @return array
     */
    public function providerRebateAmounts()
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
     * @dataProvider providerRebateAmounts
     */
    public function testAmount($amount, $expectedValue)
    {
        $this->rebate->setAmount($amount);

        $this->assertEquals($expectedValue, $this->rebate->getAmount());
    }

    /**
     * Rebate amounts that should throw an exception
     *
     * @return array
     */
    public function providerRebateAmountsException()
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
     * @dataProvider providerRebateAmountsException
     */
    public function testAmountException($amount)
    {
        $this->rebate->setAmount($amount);
    }

    /**
     * @return array
     */
    public function providerCalculateValues()
    {
        // array(rebate amount, price, expected rebate)
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
     * @param $price
     * @param $expectedResult
     *
     * @dataProvider providerCalculateValues
     */
    public function testCalculate($amount, $price, $expectedResult)
    {
        $this->rebate->setAmount($amount);

        $this->assertEquals($expectedResult, $this->rebate->calculate($price));
    }

    /**
     * @return array
     */
    public function providerCalculateValuesException()
    {
        return array(
            array("abc"),
            array(-25),
            array(false),
            array(null),
        );
    }

    /**
     * @param $price
     *
     * @expectedException \Exception
     * @dataProvider providerCalculateValuesException
     */
    public function testCalculateException($price)
    {
        $this->rebate->calculate($price);
    }
}
