<?php

namespace RebateCalculator;

/**
 * Class Card
 *
 * @package RebateCalculator
 */
class Card
{
    /**
     * The card's current balance
     *
     * @var float
     */
    private $balance;

    /**
     * The card's top-up facility
     *
     * @var TopUpFacility
     */
    private $topUpFacility;

    /**
     * @param TopUpFacility $topUpFacility the card's top up facility
     * @param float $balance the card's current balance
     */
    function __construct(TopUpFacility $topUpFacility, $balance = 0.0)
    {
        $this->setBalance($balance);
        $this->topUpFacility = $topUpFacility;
    }

    /**
     * Get the current card balance
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set the card balance
     *
     * @param float $balance the current card balance
     * @throws \Exception if balance not valid value
     */
    private function setBalance($balance)
    {
        if (! is_numeric($balance)) {
            throw new \Exception('Balance must be a numeric value.');
        }

        $this->balance = (float) $balance;
    }

    /**
     * Calculate the cost of topping up by the given amount
     *
     * @param float $amount the amount to top up by
     * @return float
     */
    public function getTopUpCost($amount)
    {
        return $this->topUpFacility->getTopUpCost($amount);
    }

    /**
     * Get the card's minimum top-up amount
     *
     * @return float
     */
    public function getMinimumTopUp()
    {
        return $this->topUpFacility->getMinimum();
    }

    /**
     * Top up the card by the given amount
     *
     * @param float $amount the amount to top up
     * @throws \Exception if card could not be topped up
     */
    public function topUp($amount)
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
    public function payFor(Item $item)
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
    public function receiveRebate(Item $item, Store $store)
    {
        $this->adjustBalance($store->calculateRebateValue($item));
    }

    /**
     * Adjust the card balance by the given amount
     *
     * @param float $amount the amount to adjust the card balance by
     */
    private function adjustBalance($amount)
    {
        $this->balance += $amount;
    }
}
