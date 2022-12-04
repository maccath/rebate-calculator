<?php

namespace RebateCalculator;

class Item
{
    protected float $cost;

    /**
     * @throws \Exception if the item cost is invalid
     */
    function __construct(float $cost)
    {
        if ($cost < 0) {
            throw new \Exception(
                sprintf(
                    "Item cost (£%d) must be a positive numeric value.",
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
