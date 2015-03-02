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
        $this->amount = $amount;
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
        if (!$amount) {
            $this->amount = 0;

            return;
        }

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
        if ($topup && (!is_numeric($topup) || $topup < 0)) {
            throw new \Exception(
                sprintf(
                    "Topup (%s) must be a positive numeric value.",
                    $topup
                )
            );
        }

        return round($topup / 100 * $this->amount, 2);
    }
}