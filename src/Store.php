<?php

namespace RebateCalculator;

class Store
{

    /**
     * @var Store name
     */
    protected $name;

    /**
     * @var Rebate percentage
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
    public function setRebate(Rebateinterface $rebate)
    {
        $this->rebate = $rebate;
    }
}