<?php

class CardTest extends PHPUnit_Framework_TestCase
{
    public function testGetBalance()
    {
        // Arrange
        $a = new \RebateCalculator\Card(new \RebateCalculator\PercentageFee(10), 100);

        // Assert
        $this->assertEquals(100, $a->getBalance());
    }
}
