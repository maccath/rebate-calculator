<?php

namespace RebateCalculator\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RebateCalculator\Item;
use RebateCalculator\PercentageRebate;

class PercentageRebateTest extends TestCase
{
    public function testInvalidRebateAmount(): void
    {
        $this->expectException(Exception::class);

        new PercentageRebate(-25);
    }

    /**
     * @dataProvider providerCalculateValues
     */
    public function testCalculate(float $percentage, float $itemCost, float $expectedRebate): void
    {
        $rebate = new PercentageRebate($percentage);
        $item = new Item($itemCost);

        $this->assertEquals($expectedRebate, $rebate->calculate($item));
    }

    public static function providerCalculateValues(): array
    {
        // rebate amount, item cost, expected rebate
        return [
            [10,    25,    2.5],
            [0,     25,    0],
            [10,    0,     0],
        ];
    }
}
