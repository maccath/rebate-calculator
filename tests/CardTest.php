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
     *  Set up a card instance
     */
    protected function setUp()
    {
        // Set up card
        $fee = new \RebateCalculator\PercentageFee(10);
        $topup = new \RebateCalculator\Topup($fee);
        $this->card = new \RebateCalculator\Card($topup);
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
     * @param $input
     * @param $expectedBalance
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testGetSetBalance($input, $expectedBalance)
    {
        $this->card->setBalance($input);

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
     * @param $balance
     *
     * @expectedException \Exception
     * @dataProvider providerCurrencyAmountsException
     */
    public function testBalanceException($balance)
    {
        $this->card->setBalance($balance);
    }

    /**
     * Test setting and getting of topup
     */
    public function testGetSetTopup()
    {
        $topup = new \RebateCalculator\Topup(new \RebateCalculator\PercentageFee(10), 0, 25);

        $this->card->setTopup($topup);

        $this->assertInstanceOf('\RebateCalculator\Topup', $this->card->getTopup());
        $this->assertEquals($topup, $this->card->getTopup());
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

        $this->card->setBalance($balance);
        $this->card->getTopup()->setMinimum($minimumTopup);

        $this->assertEquals($expectedTopupRequired, $this->card->calculateTopupRequired($item));
    }

    /**
     * @param $topup
     *
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerTopupException
     */
    public function testSetTopupException($topup)
    {
        $this->card->setTopup($topup);
    }
}
