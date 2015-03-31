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
     * @var Topup topup
     */
    protected $topup;

    /**
     * @param Topup $topup
     * @param int   $balance
     */
    function __construct(Topup $topup, $balance = 0)
    {
        $this->topup = $topup;
        $this->balance = $balance;
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
     * @return Topup
     */
    public function getTopup()
    {
        return $this->topup;
    }

    /**
     * @param Topup $topup
     */
    public function setTopup(Topup $topup)
    {
        $this->topup = $topup;
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
        $minimumTopup = $this->getTopup()->getMinimum();

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

        $this->getTopup()->setAmount($topupAmount);

        $this->amendBalance($topupAmount);
    }

    /**
     * @param Item $item
     *
     * @throws \Exception
     */
    public function payFor(Item $item)
    {
        if ($this->getBalance() >= $item->getCost()) {
            $this->amendBalance(-$item->getCost());
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
        $this->amendBalance($store->calculateRebateAmount($item));
    }

    /**
     * Amend the card balance by the given amount
     *
     * @param $amount
     */
    public function amendBalance($amount)
    {
        $this->setBalance($this->getBalance() + $amount);
    }
}