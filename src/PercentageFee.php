<?php

namespace RebateCalculator;

/**
 * Class PercentageFee
 *
 * @package RebateCalculator
 */
class PercentageFee implements FeeInterface
{
    protected float $amount;

    /**
     * PercentageFee constructor
     */
    function __construct(float $amount)
    {
        $this->setAmount($amount);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Set the fee percentage amount
     *
     * @throws \Exception if fee amount invalid
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
     * Calculate the fee charged for a given top-up amount
     *
     * @throws \Exception if top-up amount invalid
     */
    public function calculate(float $topUpAmount = 0.0): float
    {
        if ($topUpAmount < 0) {
            throw new \Exception(
                sprintf(
                    "Top-up (%s) must be a positive numeric value.",
                    $topUpAmount
                )
            );
        }

        // No fee if no top-up
        if (! $topUpAmount) {
            return 0;
        }

        return round($topUpAmount / 100 * $this->amount, 2);
    }
}
