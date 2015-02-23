<?php

/**
 * Interface FeeInterface
 */
interface FeeInterface
{
    /**
     * @param      $amount
     * @param int  $topup
     * @param bool $card
     *
     * @return mixed
     */
    public function calculate($amount, $topup = 0, $card = false);
}