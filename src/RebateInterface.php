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
     * Get the rebate amount
     *
     * @return float
     */
    public function getAmount();

    /**
     * Calculate the rebate awarded
     *
     * @param Item $item the item to rebate for
     * @return float
     */
    public function calculate(Item $item);
}
