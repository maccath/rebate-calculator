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
     * @var
     */
    protected $cost;

    /**
     * @param $cost
     *
     * @throws \Exception
     */
    function __construct($cost)
    {
        if (!is_numeric($cost)) {
            throw new \Exception('Item cost must be a numeric value.');
        }

        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param $cost
     *
     * @throws \Exception
     */
    public function setCost($cost)
    {
        if (!is_numeric($cost)) {
            throw new \Exception('Item cost must be a numeric value.');
        }

        $this->cost = $cost;
    }
}