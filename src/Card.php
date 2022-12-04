<?php

namespace RebateCalculator;

/**
 * Class Card
 *
 * @package RebateCalculator
 */
class Card
{
    private float $balance;
    private TopUpFacility $topUpFacility;

    /**
     * @param TopUpFacility $topUpFacility the card's top up facility
     * @param float $balance the card's current balance
     */
    function __construct(TopUpFacility $topUpFacility, float $balance = 0.0)
    {
        $this->setBalance($balance);
        $this->topUpFacility = $topUpFacility;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    private function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * Calculate the cost of topping up by the given amount
     */
    public function getTopUpCost(float $amount): float
    {
        return $this->topUpFacility->getTopUpCost($amount);
    }

    /**
     * Get the card's minimum top-up amount
     */
    public function getMinimumTopUp(): float
    {
        return $this->topUpFacility->getMinimum();
    }

    /**
     * Top up the card by the given amount
     *
     * @param float $amount the amount to top up
     * @throws \Exception if card could not be topped up
     */
    public function topUp(float $amount): void
    {
        $this->topUpFacility->validateTopUp($amount);

        $this->adjustBalance($amount);
    }

    /**
     * Pay for the given item
     *
     * @param Item $item the item to pay for
     * @throws \Exception if the item could not be paid for
     */
    public function payFor(Item $item): void
    {
        if ($this->getBalance() < $item->getCost()) {
            throw new \Exception(sprintf(
                "There isn't sufficient balance (£%d) to purchase the item for %d",
                $this->getBalance(),
                $item->getCost()
            ));
        }

        $this->adjustBalance(-$item->getCost());
    }

    /**
     * Receive rebate for buying $item from $store
     *
     * @param Item $item the item paid for
     * @param Store $store the store item purchased from
     */
    public function receiveRebate(Item $item, Store $store): void
    {
        $this->adjustBalance($store->calculateRebateValue($item));
    }

    /**
     * Adjust the card balance by the given amount
     *
     * @param float $amount the amount to adjust the card balance by
     */
    private function adjustBalance(float $amount): void
    {
        $this->balance += $amount;
    }
}
