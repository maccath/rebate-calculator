<?php

namespace RebateCalculator;

/**
 * Class PercentageRebate
 */
class PercentageRebate implements RebateInterface
{

    /**
     * @var
     */
    protected $amount;

    /**
     * @param $amount
     */
    public function __construct($amount)
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
     * @param $price
     *
     * @return float
     */
    public function calculate($price)
    {
        return (Float)$price / 100 * (float)$this->amount;
    }
}