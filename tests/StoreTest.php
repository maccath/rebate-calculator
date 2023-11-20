<?php

namespace RebateCalculator\Tests;

use PHPUnit\Framework\TestCase;
use RebateCalculator\Item;
use RebateCalculator\PercentageRebate;
use RebateCalculator\Store;

class StoreTest extends TestCase
{
    /**
     * Test that store name is set correctly and can be fetched
     *
     * @dataProvider providerValidNames
     */
    public function testSetGetName($inputName, string $expectedName): void
    {
        $store = new Store($inputName, new PercentageRebate(10));

        $this->assertEquals($expectedName, $store->getName());
    }

    /**
     * Test that the rebate will be calculated correctly
     */
    public function testCalculateRebate(): void
    {
        $item = new Item(200);
        $store = new Store("Store Name", new PercentageRebate(10));

        $this->assertEquals(20, $store->calculateRebateValue($item));
    }

    public static function providerValidNames(): array
    {
        return [
            ['Store Name', 'Store Name'],
            ['日本語', '日本語'],
            [25, '25'],
            [-10, '-10'],
            [false, ''],
        ];
    }
}
