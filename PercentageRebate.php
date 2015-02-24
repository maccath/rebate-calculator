<?php

/**
 * Class PercentageRebate
 */
class PercentageRebate implements RebateInterface
{

    /**
     * @param $amount
     * @param $price
     *
     * @return float
     */
    public function calculate($amount, $price)
    {
        return $price / 100 * $amount;
    }
}