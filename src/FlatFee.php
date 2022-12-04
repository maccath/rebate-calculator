<?php

namespace RebateCalculator;

/**
 * Class FlatFee
 *
 * @package RebateCalculator
 */
class FlatFee implements FeeInterface
{
    private float $amount;

    /**
     * FlatFee constructor
     */
    function __construct(float $amount)
    {
        $this->setAmount($amount);
    }

    /**
     * Get the fee amount
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Set the fee amount in flat currency
     */
    private function setAmount(float $amount)
    {
        if ($amount < 0) {
            throw new \Exception(
                sprintf(
                    "Fee amount (£%d) must be a positive value.",
                    $amount
                )
            );
        }

        $this->amount = $amount;
    }

    /**
     * Calculate the fee charged for a given top-up amount
     *
     * @throws \Exception if top-up amount is not a positive value
     */
    public function calculate(float $topUpAmount = 0.0): float
    {
        if ($topUpAmount < 0) {
            throw new \Exception(
                sprintf(
                    "Top-up amount (£%d) must be a positive value.",
                    $topUpAmount
                )
            );
        }

        // No fee if no top-up
        if (! $topUpAmount) {
            return 0;
        }

        return round($this->amount, 2);
    }
}
