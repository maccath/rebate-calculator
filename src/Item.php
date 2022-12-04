<?php

namespace RebateCalculator;

use Exception;

class Item
{
    protected float $cost;

    /**
     * @throws Exception If cost is non-positive
     */
    function __construct(float $cost)
    {
        if ($cost < 0) {
            throw new Exception(
                sprintf(
                    "Item cost (£%d) must be a positive value.",
                    $cost
                )
            );
        }

        $this->cost = $cost;
    }

    public function getCost(): float
    {
        return $this->cost;
    }
}
