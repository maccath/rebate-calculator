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
            array(-10),
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
     * @param $expectedCost
     *
     * @dataProvider providerCalculatorConfiguration
     */
    public function testCalculateTopupCost($fee, $minimum, $amount, $expectedCost)
    {
        $this->topup->setFee($fee);
        $this->topup->setMinimum($minimum);
        $this->topup->setAmount($amount);

        $this->assertEquals($expectedCost, $this->topup->calculateTopupCost());
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
    public function testCalculateTopupCostException($fee, $minimum, $amount)
    {
        $this->topup->setFee($fee);
        $this->topup->setMinimum($minimum);
        $this->topup->setAmount($amount);

        $this->topup->calculateTopupCost();
    }
}