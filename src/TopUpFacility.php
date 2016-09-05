<?php

namespace RebateCalculator;

/**
 * Class TopUpFacility
 *
 * @package RebateCalculator
 */
class TopUpFacility
{
    /**
     * The top-up fee
     *
     * @var FeeInterface
     */
    private $fee;

    /**
     * The minimum top-up amount
     *
     * @var float
     */
    private $minimum;

    /**
     * TopUpFacility constructor
     *
     * @param FeeInterface $fee the top-up fee
     * @param float $minimum the minimum top-up amount
     * @throws \Exception if the minimum top-up amount is not numeric or negative
     */
    function __construct(FeeInterface $fee, $minimum = 0.0)
    {
        $this->fee = $fee;
        $this->setMinimum($minimum);
    }

    /**
     * Get the minimum top-up amount
     *
     * @return float
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * Set the minimum top-up amount
     *
     * @param float $minimum the minimum top-up amount
     * @throws \Exception if the minimum top-up amount is not numeric or negative
     */
    private function setMinimum($minimum)
    {
        if (!is_numeric($minimum) || $minimum < 0) {
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
     * @param float $amount the amount to top up by
     * @return float
     */
    public function getTopUpCost($amount)
    {
        $this->validateTopUp($amount);

        return $this->fee->calculate($amount);
    }

    /**
     * Verify that the amount is a positive numeric value equal to or over the minimum top up amount
     *
     * @param float $amount the amount to top up by
     * @throws \Exception if top-up amount is not numeric, or falls short of the minimum top-up value
     */
    public function validateTopUp($amount)
    {
        if ( ! is_numeric($amount) || $amount < 0) {
            throw new \Exception(
                sprintf(
                    'Top-up amount (£%d) must be a positive numeric value.',
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