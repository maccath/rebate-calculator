<?php

namespace RebateCalculator;

/**
 * Class FlatFee
 */
class FlatFee implements FeeInterface
{

    /**
     * @var float
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
     * @return mixed
     */
    public function calculate($topup = 0)
    {
        return (float)$this->amount;
    }
}