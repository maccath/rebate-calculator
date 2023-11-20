<?php

namespace RebateCalculator\Tests;

use PHPUnit\Framework\TestCase;
use RebateCalculator\Card;
use RebateCalculator\FlatFee;
use RebateCalculator\Item;
use RebateCalculator\TopUpCalculator;
use RebateCalculator\TopUpFacility;

class TopUpCalculatorTest extends TestCase
{
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
    public function testCalculateTopUpRequired(float $cost, float $balance, float $minimumTopUp, float $expectedTopUpRequired)
    {
        $card = new Card(new TopUpFacility(new FlatFee(0.0), $minimumTopUp), $balance);
        $item = new Item($cost);

        $topUpCalculator = new TopUpCalculator($card, $item);

        $this->assertEquals($expectedTopUpRequired, $topUpCalculator->calculateTopUpRequired());
    }

    /**
     * Calculator input values and expected output
     */
    public static function providerCalculateTopUpRequired(): array
    {
        // item cost, current balance, minimum top-up, expected top-up required
        return [
            [10.0, 0.0, 25.0, 25.0],
            [30.0, 0.0, 25.0, 30.0],
            [30.0, 10.0, 25.0, 25.0],
            [30.0, 10.0, 0.0, 20.0],
            [100.0, 100.0, 10.0, 0.0],
        ];
    }
}
