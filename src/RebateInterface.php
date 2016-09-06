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
     * @param  $cost
     *
     * @return mixed
     */
    public function calculate($cost);
}