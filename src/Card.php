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
    protected $balance;

    /**
     * @var TopUpFacility the card's top-up facility
     */
    protected $topUpFacility;

    /**
     * @param TopUpFacility $topUpFacility
     * @param int $balance
     */
    function __construct(TopUpFacility $topUpFacility, $balance = 0)
    {
        $this->balance = $balance;
        $this->topUpFacility = $topUpFacility;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param $balance
     *
     * @throws \Exception
     */
    public function setBalance($balance)
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
     * @param TopUpFacility $topUpFacility
     */
    public function setTopUpFacility(TopUpFacility $topUpFacility)
    {
        $this->topUpFacility = $topUpFacility;
    }

    /**
     * Calculate top up required to purchase item
     *
     * @param Item $item
     *
     * @return mixed
     */
    public function calculateTopupRequired(Item $item)
    {
        $itemCost = $item->getCost();
        $currentBalance = $this->getBalance();

        $additionalBalanceRequired = $itemCost - $currentBalance;
        $minimumTopup = $this->getTopUpFacility()->getMinimum();

        if ($additionalBalanceRequired && $additionalBalanceRequired < $minimumTopup) {
            return $minimumTopup;
        } else {
            return $additionalBalanceRequired;
        }
    }

    /**
     * Top up the card based on the required amount to purchase $item
     *
     * @param Item $item
     *
     * @throws \Exception
     */
    public function topUp(Item $item)
    {
        $topupAmount = $this->calculateTopupRequired($item);

        $this->getTopUpFacility()->setAmount($topupAmount);

        $this->adjustBalance($topupAmount);
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