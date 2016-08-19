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
     * @var float current balance
     */
    private $balance;

    /**
     * @var TopUpFacility the card's top-up facility
     */
    private $topUpFacility;

    /**
     * @param TopUpFacility $topUpFacility
     * @param int $balance
     */
    function __construct(TopUpFacility $topUpFacility, $balance = 0)
    {
        $this->setBalance($balance);
        $this->topUpFacility = $topUpFacility;
    }

    /**
     * Get the current card balance
     *
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set the card balance
     *
     * @param $balance
     *
     * @throws \Exception
     */
    private function setBalance($balance)
    {
        if (!is_numeric($balance)) {
            throw new \Exception('Balance must be a numeric value.');
        }

        $this->balance = $balance;
    }

    /**
     * @return TopUpFacility
     */
    public function getTopUpFacility()
    {
        return $this->topUpFacility;
    }

    /**
     * Top up the card by the given amount
     *
     * @param float $amount the amount to top up
     * @throws \Exception if card could not be topped up
     */
    public function topUp($amount)
    {
        $this->adjustBalance($this->getTopUpFacility()->getTopUpValue($amount));
    }

    /**
     * @param Item $item
     *
     * @throws \Exception
     */
    public function payFor(Item $item)
    {
        if ($this->getBalance() >= $item->getCost()) {
            $this->adjustBalance(-$item->getCost());
        } else {
            throw new \Exception(sprintf(
                "There isn't sufficient balance (£%s) to purchase the item for %s",
                $this->getBalance(),
                $item->getCost()
            ));
        }
    }

    /**
     * Receive rebate for buying $item from $store
     *
     * @param Item  $item
     * @param Store $store
     */
    public function receiveRebate(Item $item, Store $store)
    {
        $this->adjustBalance($store->calculateRebateAmount($item));
    }

    /**
     * Adjust the card balance by the given amount
     *
     * @param $amount
     */
    private function adjustBalance($amount)
    {
        $this->setBalance($this->getBalance() + $amount);
    }
}