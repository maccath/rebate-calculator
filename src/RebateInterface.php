<?php

namespace RebateCalculator;

interface RebateInterface
{
    /**
     * Calculate the rebate awarded
     */
    public function calculate(Item $item): float;
}
