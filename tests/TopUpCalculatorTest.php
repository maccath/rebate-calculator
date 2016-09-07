<?php

/**
 * Class TopUpCalculatorTest
 */
class TopUpCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\Card
     */
    protected $card;

    /**
     * @var \RebateCalculator\Item
     */
    protected $item;

    /**
     * Set up default card and item instances
     */
    protected function setUp()
    {
        $this->card = $this->getMockBuilder(\RebateCalculator\Card::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->item = $this->getMockBuilder(\RebateCalculator\Item::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test that the correct required top-up is calculated based on item cost, current balance and minimum top-up
     *
     * @param float $cost the item cost
     * @param float $balance the current card balance
     * @param float $minimumTopUp the minimum top-up
     * @param float $expectedTopUpRequired the expected required top-up
     *
     * @dataProvider providerCalculateTopUpRequired
     */
    public function testCalculateTopUpRequired($cost, $balance, $minimumTopUp, $expectedTopUpRequired)
    {
        $this->card->expects($this->once())->method('getBalance')->willReturn($balance);
        $this->card->expects($this->any())->method('getMinimumTopUp')->willReturn($minimumTopUp);

        $this->item->expects($this->once())->method('getCost')->willReturn($cost);

        $topUpCalculator = new \RebateCalculator\TopUpCalculator($this->card, $this->item);

        $this->assertEquals($expectedTopUpRequired, $topUpCalculator->calculateTopUpRequired());
    }

    /**
     * Calculator input values and expected output
     *
     * @return array
     */
    public function providerCalculateTopUpRequired() {
        // item cost, current balance, minimum top-up, expected top-up required
        return [
            [10, 0, 25, 25],
            [30, 0, 25, 30],
            [30, 10, 25, 25],
            [30, 10, 0, 20],
            [100, 100, 10, 0],
        ];
    }
}
