<?php

declare(strict_types=1);

namespace RebateCalculator;

use Exception;

final class TopUpFacility
{
    /**
     * @throws Exception if the minimum top-up amount is non-positive
     */
    public function __construct(private readonly FeeInterface $fee, private readonly float $minimum = 0.0)
    {
        if ($minimum < 0) {
            throw new Exception(
                sprintf(
                    'Minimum (%s) must be a positive value.',
                    $minimum
                )
            );
        }
    }

    public function getMinimum(): float
    {
        return $this->minimum;
    }

    /**
     * Calculate the cost of a top-up of the given amount
     *
     * @throws Exception if top-up amount is not positive, or falls short of the minimum top-up value
     */
    public function getTopUpCost(float $amount): float
    {
        $this->validateTopUp($amount);

        return $this->fee->calculate($amount);
    }

    /**
     * @throws Exception if top-up amount is not positive, or falls short of the minimum top-up value
     */
    public function validateTopUp(float $amount): void
    {
        if ($amount < 0) {
            throw new Exception(
                sprintf(
                    'Top-up amount (£%d) must be a positive value.',
                    $amount
                )
            );
        }

        if ($amount < $this->getMinimum()) {
            throw new Exception(sprintf(
                "Top-up amount £%d must exceed the minimum top-up amount of £%d",
                $amount,
                $this->getMinimum()
            ));
        }
    }
}
