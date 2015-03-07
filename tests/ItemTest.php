<?php

/**
 * Class ItemTest
 */
class ItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\Item
     */
    protected $item;

    /**
     *  Set up an item instance
     */
    protected function setUp()
    {
        $this->item = new \RebateCalculator\Item(0);
    }

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
        $this->item->setCost($input);

        $this->assertEquals($expectedCost, $this->item->getCost());
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

    /**
     * @param $input
     *
     * @expectedException \Exception
     * @dataProvider providerCostsException
     */
    public function testSetCostExceptions($input)
    {
       $this->item->setCost($input);
    }
}
