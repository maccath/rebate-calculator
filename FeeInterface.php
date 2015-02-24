<?php

namespace RebateCalculator;

/**
 * Interface FeeInterface
 */
interface FeeInterface
{
    /**
     * @return mixed
     */
    public function getAmount();

    /**
     * @param $amount
     */
    public function setAmount($amount);

    /**
     * @param $topup
     *
     * @return mixed
     */
    public function calculate($topup = 0);
}