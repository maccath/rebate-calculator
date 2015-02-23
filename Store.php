<?php

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
     * @param String $name
     * @param Float  $rebate
     */
    public function __construct(String $name, Float $rebate)
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
     * @return Rebate
     */
    public function getRebate()
    {
        return $this->rebate;
    }

    /**
     * @param Rebate $rebate
     */
    public function setRebate($rebate)
    {
        $this->rebate = $rebate;
    }
}