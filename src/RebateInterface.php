<?php

namespace RebateCalculator;

/**
 * Interface RebateInterface
 *
 * @package RebateCalculator
 */
interface RebateInterface
{
    public function getAmount(): float;

    /**
     * Calculate the rebate awarded
     */
    public function calculate(Item $item): float;
}
