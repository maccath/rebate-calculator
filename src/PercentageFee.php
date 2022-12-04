<?php

namespace RebateCalculator;

/**
 * Class PercentageFee
 *
 * @package RebateCalculator
 */
class PercentageFee implements FeeInterface
{
    /**
     * The fee amount
     *
     * @var float
     */
    protected $amount;

    /**
     * PercentageFee constructor
     *
     * @param float $amount the fee amount
     */
    function __construct($amount)
    {
        $this->setAmount($amount);
    }

    /**
     * Get the fee amount
     *
     * @return float the fee amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the fee percentage amount
     *
     * @param float $amount the fee amount
     * @throws \Exception if fee amount invalid
     */
    private function setAmount($amount)
    {
        if (! is_numeric($amount) || $amount < 0) {
            throw new \Exception(
                sprintf(
                    'Amount (%s) must be a positive numeric value.',
                    $amount
                )
            );
        }

        $this->amount = (float) $amount;
    }

    /**
     * Calculate the fee charged for a given top-up amount
     *
     * @param float $topUpAmount the amount to top up by
     * @return float
     * @throws \Exception if top-up amount invalid
     */
    public function calculate($topUpAmount = 0.0)
    {
        if (! is_numeric($topUpAmount) || $topUpAmount < 0) {
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
