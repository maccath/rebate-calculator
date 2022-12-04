<?php

namespace RebateCalculator\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RebateCalculator\FeeInterface;
use RebateCalculator\TopUpFacility;

class TopupFacilityTest extends TestCase
{
    protected FeeInterface $fee;

    public function setUp(): void
    {
        $this->fee = $this->getMockBuilder(FeeInterface::class)
            ->getMock();
    }

    public function testSetGetMinimum(): void
    {
        $topUpFacility = new TopUpFacility($this->fee, 23.5);

        $this->assertEquals(23.5, $topUpFacility->getMinimum());
    }

    /**
     * Test that negative top-up amounts can't be validated
     */
    public function testValueException(): void
    {
        $topUpFacility = new TopUpFacility($this->fee, 0);

        $this->expectException(Exception::class);

        $topUpFacility->validateTopUp(-10);
    }

    /**
     * Check that top-up amounts must exceed the minimum top-up amount
     */
    public function testMinimumTopUpAmountsException(): void
    {
        $this->expectException(Exception::class);

        $topUpFacility = new TopUpFacility($this->fee, 20);

        $topUpFacility->validateTopUp(10);
    }

    /**
     * Test that minimum can't be set to a negative value
     */
    public function testMinimumException(): void
    {
        $this->expectException(Exception::class);

        new TopUpFacility($this->fee, -10);
    }

    /**
     * Test that the top-up cost is calculated according to given fee
     */
    public function testCalculateTopUpCost(): void
    {
        $topUpFacility = new TopUpFacility($this->fee, 0);

        $this->assertEquals(0, $topUpFacility->getTopUpCost(25));
    }
}
