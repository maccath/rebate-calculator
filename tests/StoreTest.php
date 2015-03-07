<?php

/**
 * Class StoreTest
 */
class StoreTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \RebateCalculator\Store
     */
    protected $store;

    /**
     *  Set up a store
     */
    protected function setUp()
    {
        // Set up rebate
        $rebate = new \RebateCalculator\PercentageRebate(10);

        // Set up store
        $this->store = new \RebateCalculator\Store("Store Name", $rebate);
    }

    /**
     * Valid values for name
     *
     * @return array
     */
    public function providerNames()
    {
        return array(
            array('Store Name', 'Store Name'),
            array(25, '25'),
            array(-10, '-10'),
            array('日本語','日本語')
        );
    }

    /**
     * Test setting and getting of name
     *
     * @param $input
     * @param $expectedName
     *
     * @dataProvider providerNames
     */
    public function testGetSetName($input, $expectedName)
    {
        $this->store->setName($input);

        $this->assertEquals($expectedName, $this->store->getName());
    }

    /**
     * Test setting and getting of rebate
     */
    public function testGetSetRebate()
    {
        $rebate = new \RebateCalculator\PercentageRebate(25);

        $this->store->setRebate($rebate);

        $this->assertInstanceOf('\RebateCalculator\RebateInterface', $this->store->getRebate());
        $this->assertEquals($rebate, $this->store->getRebate());
    }

    /**
     * Values for rebate that should throw an exception
     *
     * @return array
     */
    public function providerRebateException()
    {
        return array(
            array('abc'),
            array(false),
            array(null),
            array(0),
            array(new \RebateCalculator\PercentageFee(10)),
        );
    }

    /**
     * @param $rebate
     *
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerRebateException
     */
    public function testSetRebateException($rebate)
    {
        $this->store->setRebate($rebate);
    }
}
