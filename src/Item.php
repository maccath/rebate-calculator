<?php

namespace RebateCalculator;

/**
 * Class Item
 *
 * @package RebateCalculator
 */
class Item
{
    protected float $cost;

    /**
     * Item constructor
     *
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

    /**
     * Get the item cost
     */
    public function getCost(): float
    {
        return $this->cost;
    }
}
