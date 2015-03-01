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
    public function testBalance($input, $expectedBalance)
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
}
