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
     * @var float the fee amount
     */
    protected $amount;

    /**
     * @param $amount
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
     * Set the fee amount in a percentage
     *
     * @param float $amount the fee amount
     * @throws \Exception if fee amount invalid
     */
    private function setAmount($amount)
    {
        if (!is_numeric($amount) || $amount < 0) {
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
     * Calculate the fee for a given top-up amount
     *
     * @param float $topUpAmount
     * @return float the fee
     * @throws \Exception if top-up amount invalid
     */
    public function calculate($topUpAmount = 0.0)
    {
        if (!is_numeric($topUpAmount) || $topUpAmount < 0) {
            throw new \Exception(
                sprintf(
                    "Topup (%s) must be a positive numeric value.",
                    $topUpAmount
                )
            );
        }

        // No fee if no top-up
        if (! $topUpAmount) return 0;

        return round($topUpAmount / 100 * $this->amount, 2);
    }
}