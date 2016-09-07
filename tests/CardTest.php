<?php

/**
 * Class CardTest
 */
class CardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\Card
     */
    protected $card;

    /**
     * @var \RebateCalculator\TopUpFacility
     */
    protected $topUpFacility;

    /**
     * Set up a default card instance
     */
    protected function setUp()
    {
        $this->topUpFacility = $this->getMockBuilder(\RebateCalculator\TopUpFacility::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->card = new \RebateCalculator\Card($this->topUpFacility);
    }

    /**
     * Test that balance is set correctly and can be fetched for valid values
     *
     * @param mixed $inputBalance the input card balance
     * @param float $expectedBalance the expected actual card balance
     *
     * @dataProvider providerValidAmounts
     */
    public function testGetSetBalance($inputBalance, $expectedBalance)
    {
        $this->card = new \RebateCalculator\Card($this->topUpFacility, $inputBalance);

        $this->assertEquals($expectedBalance, $this->card->getBalance());
        $this->assertInternalType('float', $this->card->getBalance());
    }

    /**
     * Test that balance can't be set to an invalid value
     * 
     * @param mixed $inputBalance the balance to set the card to
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidAmounts
     */
    public function testBalanceException($inputBalance)
    {
        new \RebateCalculator\Card($this->topUpFacility, $inputBalance);
    }

    /**
     * Test that an affordable item can be paid for
     */
    public function testPayForItem()
    {
        $item = new \RebateCalculator\Item(200);
        $this->card = new \RebateCalculator\Card($this->topUpFacility, 300);

        $this->card->payFor($item);

        $this->assertEquals($this->card->getBalance(), 100);
    }

    /**
     * Test that an unaffordable item cannot be paid for
     *
     * @expectedException Exception
     */
    public function testPayForItemExceptionIfInsufficientBalance()
    {
        $item = new \RebateCalculator\Item(200);
        $this->card = new \RebateCalculator\Card($this->topUpFacility, 100);

        $this->card->payFor($item);
    }

    /**
     * Test that a top-up can be applied to a card
     *
     * @param float $originalBalance the original balance
     * @param float $amount the top-up amount
     * @param float $newBalance the expected card balance after top-up
     * @dataProvider providerValidTopUps
     */
    public function testBeToppedUp($originalBalance, $amount, $newBalance)
    {
        $this->card = new \RebateCalculator\Card($this->topUpFacility, $originalBalance);

        $this->card->topUp($amount);

        $this->assertEquals($this->card->getBalance(), $newBalance);
    }

    /**
     * Test that the minimum top-up amount can be fetched
     */
    public function testGetMinimumTopUp()
    {
        $this->topUpFacility
            ->expects($this->once())
            ->method('getMinimum');

        $this->card->getMinimumTopUp();
    }

    /**
     * Test that a top-up cost can be calculated
     *
     * @param float $amount the top-up amount
     * @dataProvider providerValidTopUps
     */
    public function testGetTopUpCosts($amount)
    {
        $this->topUpFacility
            ->expects($this->once())
            ->method('getTopUpCost')
            ->with($amount);

        $this->card->getTopUpCost($amount);
    }

    /**
     * Test that a rebate for an item from a store can be received
     */
    public function testReceiveRebate()
    {
        $mockStore = $this->getMockBuilder(\RebateCalculator\Store::class)
            ->disableOriginalConstructor()
            ->setMethods(['calculateRebateValue'])
            ->getMock();

        $item = new \RebateCalculator\Item(200);

        $mockStore->expects($this->once())->method('calculateRebateValue')->willReturn('20');

        $this->card->receiveRebate($item, $mockStore);

        $this->assertEquals($this->card->getBalance(), 20);
    }

    /**
     * Invalid values for balances/amounts that should throw an exception
     *
     * @return array
     */
    public function providerInvalidAmounts()
    {
        return [
            ['abc'],
            [false],
            [null],
        ];
    }

    /**
     * Valid values for balances/amounts
     *
     * @return array
     */
    public function providerValidAmounts()
    {
        return [
            [0, 0],
            [25, 25],
            ['25', 25],
            [-10, -10],
            [1.234, 1.234],
        ];
    }

    /**
     * Valid values for top-ups
     *
     * @return array
     */
    public function providerValidTopUps()
    {
        // Original balance, top-up amount, new balance
        return [
            [0, 20, 20],
            [25, 25, 50],
            [25, 0, 25],
            [25, 1.25, 26.25],
        ];
    }
}
