<?php

class CardTest extends PHPUnit_Framework_TestCase
{
    protected $card;

    protected function setUp()
    {
        // Set up card
        $this->card = new \RebateCalculator\Card(new \RebateCalculator\PercentageFee(10), 100);
    }

    public function testBalance()
    {
        $this->assertEquals(100, $this->card->getBalance());

        $this->card->setBalance(25);

        $this->assertEquals(25, $this->card->getBalance());
    }

    public function testMinimumTopup()
    {
        $this->assertEquals(0, $this->card->getMinimumTopup());

        $this->card->setMinimumTopup(25);

        $this->assertEquals(25, $this->card->getMinimumTopup());
    }

    public function testFee()
    {
        $this->assertInstanceOf('\RebateCalculator\FeeInterface', $this->card->getFee());
    }

    /**
     * @expectedException \Exception
     */
    public function testTopupException()
    {
        $this->card->setMinimumTopup("djkdjlasd");
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testFeeException()
    {
        $this->card->setFee("djkdjlasd");
    }
}
