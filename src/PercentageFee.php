<?php

namespace RebateCalculator;

/**
 * Class PercentageFee
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
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


    /**
     * @param $topup
     *
     * @return float
     */
    public function calculate($topup = 0)
    {
        return (float)$topup / 100 * (float)$this->amount;
    }
}