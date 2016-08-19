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
     * @var
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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @throws \Exception
     */
    public function setAmount($amount)
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
     * @param int $topup
     *
     * @return float
     * @throws \Exception
     */
    public function calculate($topup = 0)
    {
        if (!is_numeric($topup) || $topup < 0) {
            throw new \Exception(
                sprintf(
                    "Topup (%s) must be a positive numeric value.",
                    $topup
                )
            );
        }

        // No fee if no top-up
        if (! $topup) return 0;

        return round($topup / 100 * $this->amount, 2);
    }
}