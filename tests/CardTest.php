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
     * Valid values for topup/balance
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
     * Values for topup/balance that should throw an exception
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
     * Test setting and getting of top up facility
     *
     * Note: top up facility can only be set on construction
     */
    public function testGetSetTopup()
    {
        $topUpFacility = new \RebateCalculator\TopUpFacility(new \RebateCalculator\PercentageFee(10), 0, 25);
        $this->card = new \RebateCalculator\Card($topUpFacility);

        $this->assertInstanceOf('\RebateCalculator\TopupFacility', $this->card->getTopUpFacility());
        $this->assertEquals($topUpFacility, $this->card->getTopUpFacility());
    }

    /**
     * Values for topup that should throw an exception
     *
     * @return array
     */
    public function providerTopupException()
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
    public function providerCalculateTopupRequired() {
        // item cost, current balance, minimum topup, expected topup
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
     * @param $minimumTopup
     * @param $expectedTopupRequired
     *
     * @dataProvider providerCalculateTopupRequired
     */
    public function testCalculateTopupRequired($cost, $balance, $minimumTopup, $expectedTopupRequired)
    {
        $item = new \RebateCalculator\Item($cost);
        $this->topUpFacility = new \RebateCalculator\TopUpFacility($this->fee, $minimumTopup);
        $this->card = new \RebateCalculator\Card($this->topUpFacility, $balance);

        $this->assertEquals($expectedTopupRequired, \RebateCalculator\TopUpCalculator::calculateTopUpRequired($this->card, $item));
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
