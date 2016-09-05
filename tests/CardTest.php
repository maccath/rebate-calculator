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
     *  Set up a card instance
     */
    protected function setUp()
    {
        // Set up card
        $this->fee = new \RebateCalculator\PercentageFee(10);
        $this->topUpFacility = new \RebateCalculator\TopUpFacility($this->fee);
        $this->card = new \RebateCalculator\Card($this->topUpFacility);
    }

    /**
     * Valid values for top-up/balance
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
     * @param $inputBalance float
     * @param $expectedBalance
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testGetSetBalance($inputBalance, $expectedBalance)
    {
        $this->card = new \RebateCalculator\Card($this->topUpFacility, $inputBalance);

        $this->assertEquals($expectedBalance, $this->card->getBalance());
    }

    /**
     * Values for top-up/balance that should throw an exception
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
     * @param mixed $inputBalance the balance to set the card to
     *
     * @expectedException \Exception
     * @dataProvider providerCurrencyAmountsException
     */
    public function testBalanceException($inputBalance)
    {
        new \RebateCalculator\Card($this->topUpFacility, $inputBalance);
    }

    /**
     * Values for top-up that should throw an exception
     *
     * @return array
     */
    public function providerTopUpException()
    {
        return array(
            array('abc'),
            array(false),
            array(null),
            array(0),
        );
    }

    /**
     * @return array
     */
    public function providerCalculateTopUpRequired() {
        // item cost, current balance, minimum top-up, expected top-up
        return array(
            array(10, 0, 25, 25),
            array(30, 0, 25, 30),
            array(30, 10, 25, 25),
            array(30, 10, 0, 20),
            array(100, 100, 10, 0),
        );
    }

    /**
     * @param $cost
     * @param $balance
     * @param $minimumTopUp
     * @param $expectedTopUpRequired
     *
     * @dataProvider providerCalculateTopUpRequired
     */
    public function testCalculateTopupRequired($cost, $balance, $minimumTopUp, $expectedTopUpRequired)
    {
        $item = new \RebateCalculator\Item($cost);
        $this->topUpFacility = new \RebateCalculator\TopUpFacility($this->fee, $minimumTopUp);
        $this->card = new \RebateCalculator\Card($this->topUpFacility, $balance);

        $topUpCalculator = new \RebateCalculator\TopUpCalculator($this->card, $item);

        $this->assertEquals($expectedTopUpRequired, $topUpCalculator->calculateTopUpRequired());
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
}
