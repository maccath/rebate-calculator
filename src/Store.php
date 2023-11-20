<?php

declare(strict_types=1);

namespace RebateCalculator;

final class Store
{
    public function __construct(private readonly string $name, private readonly RebateInterface $rebate)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Calculate the rebate given by the store for given item
     */
    public function calculateRebateValue(Item $item): float
    {
        return $this->rebate->calculate($item);
    }
}
