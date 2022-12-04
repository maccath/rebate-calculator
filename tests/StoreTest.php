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
     * @var \RebateCalculator\RebateInterface
     */
    protected $rebate;

    /**
     *  Set up a default store instance with 10% rebate
     */
    protected function setUp()
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
        $this->assertInternalType('string', $this->store->getName());
    }

    /**
     * Test that store name is set correctly and can be fetched
     *
     * @param mixed $name the store name
     *
     * @expectedException \Exception
     * @dataProvider providerInvalidNames
     */
    public function testSetInvalidName($name)
    {
        new \RebateCalculator\Store($name, $this->rebate);
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
     * Test that the rebate will be fetched from the rebate class
     */
    public function testGetRebate()
    {
        $this->rebate->expects($this->once())
            ->method('getAmount')
            ->willReturn('10');

        $this->store->getRebateAmount();
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
        ];
    }

    /**
     * Invalid values for name
     *
     * @return array
     */
    public function providerInvalidNames()
    {
        return [
            [25, '25'],
            [-10, '-10'],
            [false, ''],
        ];
    }
}
