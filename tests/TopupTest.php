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
     *  Set up a topup instance
     */
    protected function setUp()
    {
        // Set up fee
        $fee = new \RebateCalculator\PercentageFee(10);

        // Set up a topup
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
            array(1.234, 1.234),
            array(false, 0),
            array(null, 0),
        );
    }

    /**
     * @param $input
     * @param $expectedValue
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testSetGetAmount($input, $expectedValue)
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
    public function testSetGetMinimum($input, $expectedMinimumTopup)
    {
        $this->topup->setMinimum($input);

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
     * Test setting and getting of fee
     */
    public function testGetSetFee()
    {
        $fee = new \RebateCalculator\PercentageFee(10);

        $this->topup->setFee($fee);

        $this->assertInstanceOf('\RebateCalculator\Fee', $this->topup->getFee());
        $this->assertEquals($fee, $this->topup->getFee());
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
        $this->topup->setFee($fee);
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