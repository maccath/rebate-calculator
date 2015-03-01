<?php

/**
 * Class SavingsCalculatorTest
 */
class SavingsCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param \RebateCalculator\FeeInterface    $fee
     * @param \RebateCalculator\RebateInterface $rebate
     * @param \RebateCalculator\Item            $item
     * @param                                   $expectedCost
     *
     * @dataProvider providerConfiguration
     */
    public function testCalculateCost(
        \RebateCalculator\FeeInterface $fee,
        \RebateCalculator\RebateInterface $rebate,
        \RebateCalculator\Item $item,
        $expectedCost
    ) {
        // Set up calculator
        $topup = new \RebateCalculator\Topup($fee, 0, 0);
        $card = new \RebateCalculator\Card($topup);
        $store = new \RebateCalculator\Store("Sainsbury's", $rebate);
        $calculator = new \RebateCalculator\SavingsCalculator($card, $store,
            $item);

        $this->assertEquals($expectedCost, $calculator->calculateCost());
    }

    /**
     * @return array
     */
    public function providerConfiguration()
    {
        return array(
            array(
                new \RebateCalculator\PercentageFee(10),
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(20),
                20
            ),
            array(
                new \RebateCalculator\PercentageFee(0),
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(20),
                18
            ),
            array(
                new \RebateCalculator\FlatFee(2),
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(20),
                20
            ),
            array(
                new \RebateCalculator\FlatFee(0),
                new \RebateCalculator\PercentageRebate(5),
                new \RebateCalculator\Item(20),
                19
            ),
            array(
                new \RebateCalculator\FlatFee(2),
                new \RebateCalculator\PercentageRebate(10),
                new \RebateCalculator\Item(15),
                15.5
            ),
        );
    }
}
