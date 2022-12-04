<?php

namespace RebateCalculator;

/**
 * Interface FeeInterface
 *
 * @package RebateCalculator
 */
interface FeeInterface
{
    /**
     * Calculate the fee for the given top-up amount
     */
    public function calculate(float $topUpAmount = 0.0): float;
}
