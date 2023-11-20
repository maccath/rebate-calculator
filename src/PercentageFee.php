<?php

declare(strict_types=1);

namespace RebateCalculator;

use Exception;

class PercentageFee implements FeeInterface
{
    /**
     * @throws Exception If amount is non-positive
     */
    public function __construct(private readonly float $amount)
    {
        if ($amount < 0) {
            throw new Exception(
                sprintf(
                    'Amount (%s) must be a positive value.',
                    $amount,
                ),
            );
        }
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
                    $topUpAmount,
                ),
            );
        }

        // No fee if no top-up
        if (! $topUpAmount) {
            return 0;
        }

        return round($topUpAmount / 100 * $this->amount, 2);
    }
}
