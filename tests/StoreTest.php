<?php

namespace RebateCalculator\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class StoreTest
 */
class StoreTest extends TestCase
{
    /**
     * @var \RebateCalculator\Store
     */
    protected $store;

    /**
     * @var \RebateCalculator\RebateInterface
     */
    protected $rebate;

    /**
     *  Set up a default store instance with 10% rebate
     */
    public function setUp(): void
    {
        $this->rebate = $this->getMockBuilder(\RebateCalculator\PercentageRebate::class)
            ->setConstructorArgs([10])
            ->getMock();
        $this->store = new \RebateCalculator\Store("Store Name", $this->rebate);
    }

    /**
     * Test that store name is set correctly and can be fetched
     *
     * @param mixed $inputName the store name
     * @param string $expectedName the actual store name
     *
     * @dataProvider providerValidNames
     */
    public function testSetGetName($inputName, $expectedName)
    {
        $this->store = new \RebateCalculator\Store($inputName, $this->rebate);

        $this->assertEquals($expectedName, $this->store->getName());
        $this->assertIsString($this->store->getName());
    }

    /**
     * Test that the rebate will be calculated by rebate class
     */
    public function testCalculateRebate()
    {
        $item = new \RebateCalculator\Item(200);

        $this->rebate->expects($this->once())
            ->method('calculate')
            ->with($item);

        $this->store->calculateRebateValue($item);
    }

    /**
     * Valid values for name
     *
     * @return array
     */
    public function providerValidNames()
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
