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
        $this->card = new \RebateCalculator\Card($fee);
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
     * @param $input
     * @param $expectedMinimumTopup
     *
     * @dataProvider providerCurrencyAmounts
     */
    public function testMinimumTopup($input, $expectedMinimumTopup)
    {
        $this->card->setMinimumTopup($input);

        $this->assertEquals($expectedMinimumTopup, $this->card->getMinimumTopup());
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
     * @expectedException \Exception
     *
     * @dataProvider providerCurrencyAmountsException
     */
    public function testBalanceException($balance)
    {
        $this->card->setBalance($balance);
    }

    /**
     * @expectedException \Exception
     *
     * @dataProvider providerCurrencyAmountsException
     */
    public function testMinimumTopupException($topup)
    {
        $this->card->setMinimumTopup($topup);
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
}
