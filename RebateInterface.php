<?php

/**
 * Interface RebateInterface
 */
interface RebateInterface
{
    /**
     * @param  $amount
     * @param  $price
     * @return mixed
     */
    public function calculate($amount, $price);
}