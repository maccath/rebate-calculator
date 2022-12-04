<?php

namespace RebateCalculator;

/**
 * Class Store
 *
 * @package RebateCalculator
 */
class Store
{
    protected string $name;
    protected RebateInterface $rebate;

    public function __construct(string $name, RebateInterface $rebate)
    {
        $this->name = $name;
        $this->rebate = $rebate;
    }

    /**
     * Get the store name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the store's rebate amount
     */
    public function getRebateAmount(): float
    {
        return $this->rebate->getAmount();
    }

    /**
     * Calculate the rebate given by the store for given item
     */
    public function calculateRebateValue(Item $item): float
    {
        return $this->rebate->calculate($item);
    }
}
