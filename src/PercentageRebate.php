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
        $this->setAmount($amount);
    }

    /**
     * Get the rebate amount
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Set the rebate amount as a percentage
     *
     * @throws \Exception if the amount is invalid
     */
    private function setAmount(float $amount): void
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
     * Calculate rebate due for an item of given cost
     */
    public function calculate(Item $item): float
    {
        return $item->getCost() / 100 * $this->amount;
    }
}
