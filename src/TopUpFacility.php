<?php

namespace RebateCalculator;

/**
 * Class TopUpFacility
 *
 * @package RebateCalculator
 */
class TopUpFacility
{
    private FeeInterface $fee;
    private float $minimum;

    /**
     * TopUpFacility constructor
     *
     * @throws \Exception if the minimum top-up amount is not numeric or negative
     */
    function __construct(FeeInterface $fee, float $minimum = 0.0)
    {
        $this->fee = $fee;
        $this->setMinimum($minimum);
    }

    public function getMinimum(): float
    {
        return $this->minimum;
    }

    /**
     * Set the minimum top-up amount
     *
     * @param float $minimum the minimum top-up amount
     * @throws \Exception if the minimum top-up amount is not numeric or negative
     */
    private function setMinimum(float $minimum): void
    {
        if ($minimum < 0) {
            throw new \Exception(
                sprintf(
                    'Minimum (%s) must be a positive numeric value.',
                    $minimum
                )
            );
        }

        $this->minimum = $minimum;
    }

    /**
     * Calculate the cost of a top-up of the given amount
     *
     * @throws \Exception if top-up amount is not positive, or falls short of the minimum top-up value
     */
    public function getTopUpCost(float $amount): float
    {
        $this->validateTopUp($amount);

        return $this->fee->calculate($amount);
    }

    /**
     * Verify that the amount is a positive numeric value equal to or over the minimum top up amount
     *
     * @throws \Exception if top-up amount is not positive, or falls short of the minimum top-up value
     */
    public function validateTopUp(float $amount): void
    {
        if ($amount < 0) {
            throw new \Exception(
                sprintf(
                    'Top-up amount (£%d) must be a positive value.',
                    $amount
                )
            );
        }

        if ($amount < $this->getMinimum()) {
            throw new \Exception(sprintf(
                "Top-up amount £%d must exceed the minimum top-up amount of £%d",
                $amount,
                $this->getMinimum()
            ));
        }
    }
}
