<?php

namespace RebateCalculator\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RebateCalculator\Item;

class ItemTest extends TestCase
{
    /**
     * Test that item cost is set correctly and can be fetched for valid values
     */
    public function testCost(): void
    {
        $item = new Item(10);

        $this->assertEquals(10, $item->getCost());
    }

    /**
     * Test that balance can't be set to an invalid value
     */
    public function testCostExceptions(): void
    {
        $this->expectException(Exception::class);

        new Item(-10);
    }
}
