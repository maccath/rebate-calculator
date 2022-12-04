<?php

namespace RebateCalculator\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use RebateCalculator\Card;
use RebateCalculator\FeeInterface;
use RebateCalculator\Item;
use RebateCalculator\Store;
use RebateCalculator\TopUpFacility;

class CardTest extends TestCase
{
    protected TopUpFacility $topUpFacility;

    public function setUp(): void
    {
        $fee = $this->getMockBuilder(FeeInterface::class)->getMock();
        $this->topUpFacility = new TopUpFacility($fee, 5.0);
    }

    /**
     * Test that balance is set correctly and can be fetched for valid values
     *
     * @dataProvider providerValidAmounts
     */
    public function testGetSetBalance(float $inputBalance, float $expectedBalance): void
    {
        $card = new Card($this->topUpFacility, $inputBalance);

        $this->assertEquals($expectedBalance, $card->getBalance());
    }

    /**
     * Test that an affordable item can be paid for
     */
    public function testPayForItem(): void
    {
        $item = new Item(200);
        $card = new Card($this->topUpFacility, 300);

        $card->payFor($item);

        $this->assertEquals($card->getBalance(), 100);
    }

    /**
     * Test that an unaffordable item cannot be paid for
     */
    public function testPayForItemExceptionIfInsufficientBalance(): void
    {
        $item = new Item(200);
        $card = new Card($this->topUpFacility, 100);

        $this->expectException(Exception::class);

        $card->payFor($item);
    }

    /**
     * Test that a top-up can be applied to a card
     *
     * @param float $originalBalance the original balance
     * @param float $amount the top-up amount
     * @param float $newBalance the expected card balance after top-up
     *
     * @dataProvider providerValidTopUps
     */
    public function testBeToppedUp(float $originalBalance, float $amount, float $newBalance): void
    {
        $card = new Card($this->topUpFacility, $originalBalance);

        $card->topUp($amount);

        $this->assertEquals($newBalance, $card->getBalance());
    }

    /**
     * Test that the minimum top-up amount can be fetched
     */
    public function testGetMinimumTopUp(): void
    {
        $card = new Card($this->topUpFacility);

        $this->assertEquals(5.0, $card->getMinimumTopUp());
    }

    /**
     * Test that a rebate for an item from a store can be received
     */
    public function testReceiveRebate(): void
    {
        $card = new Card($this->topUpFacility);

        $mockStore = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->setMethods(['calculateRebateValue'])
            ->getMock();

        $item = new Item(200);

        $mockStore->expects($this->once())->method('calculateRebateValue')->willReturn(20.0);

        $card->receiveRebate($item, $mockStore);

        $this->assertEquals($card->getBalance(), 20);
    }

    /**
     * Valid values for balances/amounts
     */
    public function providerValidAmounts(): array
    {
        return [
            [0, 0],
            [25, 25],
            [-10, -10],
            [1.234, 1.234],
        ];
    }

    /**
     * Valid values for top-ups
     */
    public function providerValidTopUps(): array
    {
        // Original balance, top-up amount, new balance
        return [
            [0, 20, 20],
            [25, 25, 50],
            [25, 5.25, 30.25],
        ];
    }
}
