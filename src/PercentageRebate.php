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
     * @param $price
     *
     * @return float
     * @throws \Exception
     */
    public function calculate($price)
    {
        if ($price && (!is_numeric($price) || $price < 0)) {
            throw new \Exception(
                sprintf(
                    "Price (%s) must be a positive numeric value.",
                    $price
                )
            );
        }

        return (Float)$price / 100 * (float)$this->amount;
    }
}