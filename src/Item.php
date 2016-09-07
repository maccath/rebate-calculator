<?php

namespace RebateCalculator;

/**
 * Class Item
 *
 * @package RebateCalculator
 */
class Item
{
    /**
     * The cost of the item
     *
     * @var float
     */
    protected $cost;

    /**
     * Item constructor
     *
     * @param float $cost the cost of the item
     * @throws \Exception if the item cost is invalid
     */
    function __construct($cost)
    {
        $this->setCost($cost);
    }

    /**
     * Get the item cost
     *
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set the item cost
     *
     * @param float $cost the cost of the item
     * @throws \Exception if the item cost is invalid
     */
    private function setCost($cost)
    {
        if ( ! is_numeric($cost) || $cost < 0) {
            throw new \Exception(
                sprintf(
                    "Item cost (£%d) must be a positive numeric value.",
                    $cost
                )
            );
        }

        $this->cost = (float) $cost;
    }
}