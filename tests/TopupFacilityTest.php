<?php

/**
 * Class TopUpFacilityTest
 */
class TopUpFacilityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\TopUpFacility
     */
    protected $topUpFacility;

    /**
     * @var \RebateCalculator\FeeInterface
     */
    protected $fee;

    /**
     * Set up a default top-up instance
     */
    protected function setUp()
    {
        $this->fee = $this->getMockBuilder(\RebateCalculator\FeeInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['calculate', 'getAmount'])
            ->getMock();

        $this->topUpFacility = new \RebateCalculator\TopUpFacility($this->fee, 0);
    }

    /**
     * Test that minimum top-up amount is set correctly and can be fetched for valid values
     *
     * @param mixed $minimumTopUp the input minimum top-up value
     * @param float $expectedMinimumTopUp the actual minimum top-up value
     *
     * @dataProvider providerValidAmounts
     */
    public function testSetGetMinimum($minimumTopUp, $expectedMinimumTopUp)
    {
        $this->topUpFacility = new \RebateCalculator\TopUpFacility($this->fee, $minimumTopUp);

        $this->assertInternalType('float', $this->topUpFacility->getMinimum());
        $this->assertEquals($expectedMinimumTopUp, $this->topUpFacility->getMinimum());
    }

    /**
     * Test that invalid top-up amounts can't be validated
     *
     * @param mixed $amount the top-up amount
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidAmounts
     */
    public function testValueException($amount)
    {
        $this->topUpFacility->validateTopUp($amount);
    }

    /**
     * Check that top-up amounts must exceed the minimum top-up amount
     *
     * @param float $amount the top-up amount
     * @param float $minimum the minimum top-up amount
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidMinimumAndTopUpAmounts
     */
    public function testMinimumTopUpAmountsException($amount, $minimum)
    {
        $this->topUpFacility = new \RebateCalculator\TopUpFacility($this->fee, $minimum);

        $this->topUpFacility->validateTopUp($amount);
    }

    /**
     * Test that minimum can't be set to an invalid value
     *
     * @param mixed $minimum the minimum top-up
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidAmounts
     */
    public function testMinimumException($minimum)
    {
        new \RebateCalculator\TopUpFacility($this->fee, $minimum);
    }

    /**
     * Test that fee can't be set to an invalid value
     *
     * @param mixed $fee the fee
     *
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerInvalidFees
     */
    public function testSetFeeException($fee)
    {
        new \RebateCalculator\TopUpFacility($fee);
    }

    /**
     * Test that the top-up cost is calculated according to given fee
     *
     * @param $amount
     *
     * @dataProvider providerValidAmounts
     */
    public function testCalculateTopUpCost($amount)
    {
        $mockFee = $this->getMockBuilder(\RebateCalculator\FeeInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['calculate', 'getAmount'])
            ->getMock();

        $mockFee
            ->expects($this->once())
            ->method('calculate')
            ->with($amount);

        $this->topUpFacility = new \RebateCalculator\TopUpFacility($mockFee, 0);

        $this->topUpFacility->getTopUpCost($amount);
    }

    /**
     * Valid values for minimum top-up amount
     *
     * @return array
     */
    public function providerValidAmounts()
    {
        return [
            [25, 25],
            ['25', 25],
            [1.234, 1.234],
        ];
    }

    /**
     * Invalid values for top-up amount
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
     * Incompatible top-up amounts vs minimum top-up amount
     *
     * @return array
     */
    public function providerInvalidMinimumAndTopUpAmounts()
    {
        // top-up amount, minimum top-up
        return [
            [10, 20],
            [15, 50],
        ];
    }

    /**
     * Invalid values for fee
     *
     * @return array
     */
    public function providerInvalidFees()
    {
        return array(
            ['abc'],
            [false],
            [null],
            [0],
        );
    }
}