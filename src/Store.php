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
     * @param Item $item
     *
     * @return mixed
     */
    public function calculateRebateAmount(Item $item)
    {
        return $this->getRebate()->calculate($item->getCost());
    }
}