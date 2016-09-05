<?php

namespace RebateCalculator;

/**
 * Interface RebateInterface
 *
 * @package RebateCalculator
 */
interface RebateInterface
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
     * @param  $cost
     *
     * @return mixed
     */
    public function calculate($cost);
}