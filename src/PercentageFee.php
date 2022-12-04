<?php

namespace RebateCalculator;

use Exception;

class PercentageFee implements FeeInterface
{
    protected float $amount;

    /**
     * @throws Exception If amount is non-positive
     */
    function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new Exception(
                sprintf(
                    'Amount (%s) must be a positive value.',
                    $amount
                )
            );
        }

        $this->amount = $amount;
    }

    /**
     * Calculate the fee charged for a given top-up amount
     *
     * @throws Exception if top-up amount invalid
     */
    public function calculate(float $topUpAmount = 0.0): float
    {
        if ($topUpAmount < 0) {
            throw new Exception(
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
