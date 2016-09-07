<?php

namespace RebateCalculator;

class Store
{

    /**
     * @var Store name
     */
    protected $name;

    /**
     * @var float Rebate percentage
     */
    protected $rebate;

    /**
     * @param                 $name
     * @param RebateInterface $rebate
     */
    public function __construct($name, RebateInterface $rebate)
    {
        $this->name = $name;
        $this->rebate = $rebate;
    }

    /**
     * @return store
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param store $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return RebateInterface
     */
    public function getRebate()
    {
        return $this->rebate;
    }

    /**
     * @param RebateInterface $rebate
     */
    public function setRebate(RebateInterface $rebate)
    {
        $this->rebate = $rebate;
    }

    /**
     * Calculate the rebate given by the store for given item
     *
     * @param Item $item the item to calculate rebate for
     * @return float
     */
    public function calculateRebateAmount(Item $item)
    {
        return $this->rebate->calculate($item);
    }
}