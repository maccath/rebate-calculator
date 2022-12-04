<?php

namespace RebateCalculator;

/**
 * Class PercentageRebate
 *
 * @package RebateCalculator
 */
class PercentageRebate implements RebateInterface
{
    protected float $amount;

    /**
     * PercentageRebate constructor
     *
     * @throws \Exception if the amount is invalid
     */
    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new \Exception(
                sprintf(
                    'Amount (%s) must be a positive numeric value.',
                    $amount
                )
            );
        }

        $this->amount = $amount;
    }

    /**
     * Get the rebate amount
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Calculate rebate due for an item of given cost
     */
    public function calculate(Item $item): float
    {
        return $item->getCost() / 100 * $this->amount;
    }
}
