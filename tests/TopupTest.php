<?php

/**
 * Class TopupTest
 */
class TopupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\Topup
     */
    protected $topup;

    /**
     *  Set up a card instance
     */
    protected function setUp()
    {
        // Set up topup
        $fee = new \RebateCalculator\PercentageFee(10);
        $this->topup = new \RebateCalculator\Topup($fee, 0, 0);
    }

    /**
     * Valid values for minimum topup/amount
     *
     * @return array
     */
    public function providerCurrencyAmounts()
    {
        return array(
            array(25, 25),
            array('25', 25),
            array(-10, -10),
            array(1.234, 1.234)
        );
    }

    /**
     * @param $input
     * @param $expectedValue
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testValue($input, $expectedValue)
    {
        $this->topup->setAmount($input);

        $this->assertEquals($expectedValue, $this->topup->getAmount());
    }

    /**
     * @param $input
     * @param $expectedMinimumTopup
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testMinimumTopup($input, $expectedMinimumTopup)
    {
        $this->topup->setMinimum($input);

        $this->assertEquals($expectedMinimumTopup, $this->topup->getMinimum());
    }

    /**
     * Values for minimum topup/value that should throw an exception
     *
     * @return array
     */
    public function providerCurrencyAmountsException()
    {
        return array(
            array('abc'),
            array(false),
            array(null),
        );
    }

    /**
     * @param $amount
     *
     * @expectedException \Exception
     * @dataProvider providerCurrencyAmountsException
     */
    public function testValueException($amount)
    {
        $this->topup->setAmount($amount);
    }

    /**
     * @param $minimum
     *
     * @expectedException \Exception
     * @dataProvider providerCurrencyAmountsException
     */
    public function testMinimumException($minimum)
    {
        $this->topup->setMinimum($minimum);
    }
}