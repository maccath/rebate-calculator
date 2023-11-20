<?php

declare(strict_types=1);

namespace RebateCalculator;

use Exception;

class PercentageRebate implements RebateInterface
{
    /**
     * @throws Exception If amount is non-positive
     */
    public function __construct(private readonly float $amount)
    {
        if ($amount < 0) {
            throw new Exception(
                sprintf(
                    'Amount (%s) must be a positive value.',
                    $amount
                )
            );
        }
    }

    /**
     * Calculate rebate due for an item of given cost
     */
    public function calculate(Item $item): float
    {
        return $item->getCost() / 100 * $this->amount;
    }
}
