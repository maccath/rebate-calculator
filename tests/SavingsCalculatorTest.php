<?php

/**
 * Class SavingsCalculatorTest
 */
class SavingsCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\SavingsCalculator
     */
    protected $calculator;

    /**
     *  Set up a calculator instance with its dependencies
     */
    protected function setUp()
    {
        // Set up topup
        $fee = new \RebateCalculator\PercentageFee(10);
        $topup = new \RebateCalculator\Topup($fee, 25);

        // Set up card
        $card = new \RebateCalculator\Card($topup);

        // Set up store
        $rebate = new \RebateCalculator\PercentageRebate(10);
        $store = new \RebateCalculator\Store("Sainsbury's", $rebate);

        // Set up item
        $item = new \RebateCalculator\Item(20);

        // Set up calculator
        $this->calculator = new \RebateCalculator\SavingsCalculator($card, $store, $item);
    }

    /**
     * Test setting and getting of card
     */
    public function testSetGetCard()
    {
        $card = new \RebateCalculator\Card(new \RebateCalculator\Topup(new \RebateCalculator\PercentageFee(10)), 10);

        $this->calculator->setCard($card);

        $this->assertInstanceOf('\RebateCalculator\Card', $this->calculator->getCard());
        $this->assertEquals($card, $this->calculator->getCard());
    }

    /**
     * Test setting and getting of store
     */
    public function testSetGetStore()
    {
        $store = new \RebateCalculator\Store("Test Store", new RebateCalculator\PercentageRebate(10));

        $this->calculator->setStore($store);

        $this->assertInstanceOf('\RebateCalculator\Store', $this->calculator->getStore());
        $this->assertEquals($store, $this->calculator->getStore());
    }

    /**
     * Test setting and getting of item
     */
    public function testSetGetItem()
    {
        $item = new \RebateCalculator\Item(10);

        $this->calculator->setItem($item);

        $this->assertInstanceOf('\RebateCalculator\Item', $this->calculator->getItem());
        $this->assertEquals($item, $this->calculator->getItem());
    }

    /**
     * @return array
     */
    public function providerConfiguration()
    {
        return array(
            array(
                new \RebateCalculator\PercentageFee(10),
                10,
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(20),
                20
            ),
            array(
                new \RebateCalculator\PercentageFee(0),
                0,
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(20),
                18
            ),
            array(
                new \RebateCalculator\FlatFee(2),
                5,
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(20),
                20
            ),
            array(
                new \RebateCalculator\FlatFee(0),
                10,
                new \RebateCalculator\PercentageRebate(5),
                new \RebateCalculator\Item(20),
                19
            ),
            array(
                new \RebateCalculator\FlatFee(2),
                15,
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(15),
                15.5
            ),
        );
    }

    /**
     * @param \RebateCalculator\FeeInterface    $fee
     * @param                                   $minimumTopup
     * @param \RebateCalculator\RebateInterface $rebate
     * @param \RebateCalculator\Item            $item
     * @param                                   $expectedCost
     *
     * @dataProvider providerConfiguration
     */
    public function testCalculateCost(
        \RebateCalculator\FeeInterface $fee,
        $minimumTopup,
        \RebateCalculator\RebateInterface $rebate,
        \RebateCalculator\Item $item,
        $expectedCost
    ) {
        $topup = new \RebateCalculator\Topup($fee, $minimumTopup);
        $card = new \RebateCalculator\Card($topup);
        $store = new \RebateCalculator\Store("Sainsbury's", $rebate);

        $this->calculator->setCard($card);
        $this->calculator->setStore($store);
        $this->calculator->setItem($item);

        $this->assertEquals($expectedCost, $this->calculator->calculateCost());
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
        $this->calculator->getItem()->setCost($cost);
        $this->calculator->getCard()->setBalance($balance);
        $this->calculator->getCard()->getTopup()->setMinimum($minimumTopup);

        $this->assertEquals($expectedTopupRequired, $this->calculator->calculateTopupRequired());
    }

    /**
     * @return array
     */
    public function providerCalculateRemainingBalance() {
        // Rebate always = 10%
        // item cost, current balance, minimum topup, expected remaining balance
        return array(
            array(10, 0, 25, 16),
            array(30, 0, 25, 3),
            array(30, 10, 25, 8),
            array(30, 10, 0, 3),
        );
    }

    /**
     * @param $cost
     * @param $balance
     * @param $minimumTopup
     * @param $expectedTopupRequired
     *
     * @dataProvider providerCalculateRemainingBalance
     */
    public function testCalculateRemainingBalance($cost, $balance, $minimumTopup, $expectedTopupRequired)
    {
        $this->calculator->getItem()->setCost($cost);
        $this->calculator->getCard()->setBalance($balance);
        $this->calculator->getCard()->getTopup()->setMinimum($minimumTopup);

        $this->assertEquals($expectedTopupRequired, $this->calculator->calculateRemainingBalance());
    }
}
