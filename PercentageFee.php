<?php

/**
 * Class PercentageFee
 */
class PercentageFee implements FeeInterface
{
    /**
     * @param      $amount
     * @param int  $topup
     * @param bool $card
     *
     * @return float
     */
    public function calculate($amount, $topup = 0, $card = false)
    {
        return $topup / 100 * $amount;
    }
}