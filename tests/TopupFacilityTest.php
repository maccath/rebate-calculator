<?php

/**
 * Class TopUpFacilityTest
 */
class TopUpFacilityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\TopUpFacility
     */
    protected $topUp;

    /**
     *  Set up a top-up instance
     */
    protected function setUp()
    {
        // Set up fee
        $this->fee = new \RebateCalculator\PercentageFee(10);

        // Set up a top-up
        $this->topUp = new \RebateCalculator\TopUpFacility($this->fee, 0);
    }

    /**
     * Valid values for minimum top-up/amount
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
     * @param $expectedMinimumTopUp
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testSetGetMinimum($input, $expectedMinimumTopUp)
    {
        $this->topUp = new \RebateCalculator\TopUpFacility($this->fee, $input);

        $this->assertEquals($expectedMinimumTopUp, $this->topUp->getMinimum());
    }

    /**
     * Values for minimum top-up/amount that should throw an exception
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
        $this->topUp->validateTopUp($amount);
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
        // $fee, $minimum, $amount, $expectedCost
        return array(
            array(
                new \RebateCalculator\PercentageFee(0),
                0,
                20,
                0
            ),
            array(
                new \RebateCalculator\FlatFee(2),
                20,
                20,
                2
            ),
            array(
                new \RebateCalculator\FlatFee(0),
                15,
                20,
                0
            ),
            array(
                new \RebateCalculator\PercentageFee(2),
                10,
                15,
                0.3
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
    public function testCalculateTopUpCost($fee, $minimum, $amount, $expectedValue)
    {
        $this->topUp = new \RebateCalculator\TopUpFacility($fee, $minimum);

        $this->assertEquals($expectedValue, $this->topUp->getTopUpCost($amount), sprintf("Cost of a top up of %d is %d not %d", $amount, $this->topUp->getTopUpCost($amount), $expectedValue));
    }

    /**
     * Test that no flat topup fee is charged when top-up amount is zero
     *
     * @throws Exception
     */
    public function testCalculateTopUpCostWithFlatFeeWhenAmountZero()
    {
        $this->topUp = new \RebateCalculator\TopUpFacility(new \RebateCalculator\FlatFee(1));

        $this->assertEquals($this->topUp->getTopUpCost(0), 0);
    }
}