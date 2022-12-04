<?php

namespace RebateCalculator;

/**
 * Class PercentageRebate
 *
 * @package RebateCalculator
 */
class PercentageRebate implements RebateInterface
{
    /**
     * The rebate amount
     *
     * @var
     */
    protected $amount;

    /**
     * PercentageRebate constructor
     *
     * @param float $amount the rebate amount
     * @throws \Exception if the amount is invalid
     */
    public function __construct($amount)
    {
        $this->setAmount($amount);
    }

    /**
     * Get the rebate amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the rebate amount as a percentage
     *
     * @param float $amount the rebate amount
     * @throws \Exception if the amount is invalid
     */
    private function setAmount($amount)
    {
        if (! is_numeric($amount) || $amount < 0) {
            throw new \Exception(
                sprintf(
                    'Amount (%s) must be a positive numeric value.',
                    $amount
                )
            );
        }

        $this->amount = (float) $amount;
    }

    /**
     * Calculate rebate due for an item of given cost
     *
     * @param Item $item the item to rebate for
     * @return float
     * @throws \Exception if cost is invalid
     */
    public function calculate(Item $item)
    {
        return $item->getCost() / 100 * $this->amount;
    }
}
