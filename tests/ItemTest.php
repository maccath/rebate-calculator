<?php

/**
 * Class ItemTest
 */
class ItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test that item cost is set correctly and can be fetched for valid values
     *
     * @param mixed $inputCost the input item cost
     * @param float $expectedCost the actual item cost
     *
     * @dataProvider providerValidCosts
     */
    public function testCost($inputCost, $expectedCost)
    {
        $item = new \RebateCalculator\Item($inputCost);

        $this->assertEquals($expectedCost, $item->getCost());
        $this->assertInternalType('float', $item->getCost());
    }

    /**
     * Test that balance can't be set to an invalid value
     *
     * @param mixed $cost the input item cost
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidCosts
     */
    public function testCostExceptions($cost)
    {
        new \RebateCalculator\Item($cost);
    }

    /**
     * Valid item costs
     *
     * @return array
     */
    public function providerValidCosts()
    {
        return [
            [10, 10],
            ['25', 25],
            [10.25, 10.25],
        ];
    }

    /**
     * Invalid item costs
     *
     * @return array
     */
    public function providerInvalidCosts()
    {
        return [
            ['abc'],
            [false],
            [null],
        ];
    }
}
