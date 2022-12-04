<?php

namespace RebateCalculator;

/**
 * Class Store
 *
 * @package RebateCalculator
 */
class Store
{
    /**
     * The store name
     *
     * @var string
     */
    protected $name;

    /**
     * The store rebate facility
     *
     * @var RebateInterface
     */
    protected $rebate;

    /**
     * Store constructor
     *
     * @param string $name the store name
     * @param RebateInterface $rebate the store rebate facility
     */
    public function __construct($name, RebateInterface $rebate)
    {
        $this->setName($name);
        $this->rebate = $rebate;
    }

    /**
     * Set the store name
     *
     * @param string $name the name string
     * @throws \Exception when name not a string
     */
    private function setName($name)
    {
        if (! $name || ! is_string($name)) {
            throw new \Exception(sprintf("The given store name (%s) is not a string.", $name));
        }

        $this->name = $name;
    }

    /**
     * Get the store name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the store's rebate amount
     *
     * @return float
     */
    public function getRebateAmount()
    {
        return $this->rebate->getAmount();
    }

    /**
     * Calculate the rebate given by the store for given item
     *
     * @param Item $item the item to calculate rebate for
     * @return float
     */
    public function calculateRebateValue(Item $item)
    {
        return $this->rebate->calculate($item);
    }
}
