<?php

declare(strict_types=1);

namespace RebateCalculator;

use Exception;

class FlatFee implements FeeInterface
{
    /**
     * @throws Exception If amount is non-positive
     */
    public function __construct(private readonly float $amount)
    {
        if ($amount < 0) {
            throw new Exception(
                sprintf(
                    "Fee amount (£%d) must be a positive value.",
                    $amount,
                ),
            );
        }
    }

    /**
     * Calculate the fee charged for a given top-up amount
     *
     * @throws Exception if top-up amount is not a positive value
     */
    public function calculate(float $topUpAmount = 0.0): float
    {
        if ($topUpAmount < 0) {
            throw new Exception(
                sprintf(
                    "Top-up amount (£%d) must be a positive value.",
                    $topUpAmount,
                ),
            );
        }

        // No fee if no top-up
        if (! $topUpAmount) {
            return 0;
        }

        return round($this->amount, 2);
    }
}
