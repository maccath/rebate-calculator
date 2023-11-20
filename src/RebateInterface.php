<?php

declare(strict_types=1);

namespace RebateCalculator;

interface RebateInterface
{
    /**
     * Calculate the rebate awarded
     */
    public function calculate(Item $item): float;
}
