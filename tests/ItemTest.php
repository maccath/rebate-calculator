<?php

/**
 * Class ItemTest
 */
class ItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function providerCosts()
    {
        return array(
            array(10, 10),
            array('25', 25),
        );
    }

    /**
     * @param $input
     * @param $expectedCost
     *
     * @dataProvider providerCosts
     */
    public function testCost($input, $expectedCost)
    {
        $item = new \RebateCalculator\Item($input);

        $this->assertEquals($expectedCost, $item->getCost());
    }

    /**
     * @return array
     */
    public function providerCostsException()
    {
        return array(
            array('abc'),
            array(false),
            array(null),
        );
    }

    /**
     * @param $input
     *
     * @expectedException \Exception
     * @dataProvider providerCostsException
     */
    public function testCostExceptions($input)
    {
        new \RebateCalculator\Item($input);
    }
}
