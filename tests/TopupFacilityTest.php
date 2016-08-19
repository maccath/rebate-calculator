<?php

/**
 * Class TopupTest
 */
class TopupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\TopUpFacility
     */
    protected $topup;

    /**
     *  Set up a topup instance
     */
    protected function setUp()
    {
        // Set up fee
        $this->fee = new \RebateCalculator\PercentageFee(10);

        // Set up a topup
        $this->topup = new \RebateCalculator\TopUpFacility($this->fee, 0);
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
            array(1.234, 1.234),
        );
    }

    /**
     * @param $input
     * @param $expectedMinimumTopup
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testSetGetMinimum($input, $expectedMinimumTopup)
    {
        $this->topup = new \RebateCalculator\TopUpFacility($this->fee, $input);

        $this->assertEquals($expectedMinimumTopup, $this->topup->getMinimum());
    }

    /**
     * Values for minimum topup/amount that should throw an exception
     *
     * @return array
     */
    public function providerCurrencyAmountsException()
    {
        return array(
            array('abc'),
            array(-10),
            array(false, 0),
            array(null, 0),
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
        $this->topup->getTopUpValue($amount);
    }

    /**
     * @param $minimum
     *
     * @expectedException \Exception
     * @dataProvider providerCurrencyAmountsException
     */
    public function testMinimumException($minimum)
    {
        new \RebateCalculator\TopUpFacility($this->fee, $minimum);
    }

    /**
     * Values for fee that should throw an exception
     *
     * @return array
     */
    public function providerFeeException()
    {
        return array(
            array('abc'),
            array(false),
            array(null),
            array(0),
        );
    }

    /**
     * @param $fee
     *
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerFeeException
     */
    public function testSetFeeException($fee)
    {
        new \RebateCalculator\TopUpFacility($fee);
    }

    /**
     * @return array
     */
    public function providerCalculatorConfiguration()
    {
        return array(
            array(
                new \RebateCalculator\PercentageFee(0),
                0,
                20,
                20
            ),
            array(
                new \RebateCalculator\FlatFee(2),
                20,
                20,
                18
            ),
            array(
                new \RebateCalculator\FlatFee(0),
                15,
                20,
                20
            ),
            array(
                new \RebateCalculator\PercentageFee(2),
                10,
                15,
                14.70
            ),
        );
    }

    /**
     * @param $fee
     * @param $minimum
     * @param $amount
     * @param $expectedValue
     *
     * @dataProvider providerCalculatorConfiguration
     */
    public function testCalculateTopupCost($fee, $minimum, $amount, $expectedValue)
    {
        $this->topup = new \RebateCalculator\TopUpFacility($fee, $minimum);

        $this->assertEquals($expectedValue, $this->topup->getTopUpValue($amount), sprintf("Value of a top up of %d is %d not %d", $amount, $this->topup->getTopUpValue($amount), $expectedValue));
    }

    /**
     * @return array
     */
    public function providerCalculatorConfigurationException()
    {
        return array(
            array(
                new \RebateCalculator\PercentageFee(10),
                25,
                20
            )
        );
    }

    /**
     * @param $fee
     * @param $minimum
     * @param $amount
     *
     * @expectedException \Exception
     * @dataProvider providerCalculatorConfigurationException
     */
    public function testCalculateTopupValueException($fee, $minimum, $amount)
    {
        $this->topup = new \RebateCalculator\TopUpFacility($fee, $minimum);

        $this->topup->getTopUpValue($amount);
    }

    /**
     * Test that no flat topup fee is charged when top-up amount is zero
     *
     * @throws Exception
     */
    public function testCalculateTopupCostWithFlatFeeWhenAmountZero()
    {
        $this->topup = new \RebateCalculator\TopUpFacility(new \RebateCalculator\FlatFee(1));

        $this->assertEquals($this->topup->getTopUpValue(0), 0);
    }
}