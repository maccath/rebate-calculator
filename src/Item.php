<?php

declare(strict_types=1);

namespace RebateCalculator;

use Exception;

class Item
{
    /**
     * @throws Exception If cost is non-positive
     */
    public function __construct(private readonly float $cost)
    {
        if ($cost < 0) {
            throw new Exception(
                sprintf(
                    "Item cost (£%d) must be a positive value.",
                    $cost
                )
            );
        }
    }

    public function getCost(): float
    {
        return $this->cost;
    }
}
