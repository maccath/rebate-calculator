<?php

namespace RebateCalculator;

/**
 * Interface FeeInterface
 */
interface FeeInterface
{
    /**
     * Get the fee amount
     *
     * @return float
     */
    public function getAmount();

    /**
     * Calculate the fee for the given top-up amount
     *
     * @param float $topUpAmount the amount to top up by
     * @return float
     */
    public function calculate($topUpAmount = 0.0);
}