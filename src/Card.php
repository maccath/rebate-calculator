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
     * @var current balance
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
     * Calculate topup required to purchase item
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
     * Top up the card based on the required amount to purchase item
     *
     * @param Item $item
     *
     * @throws \Exception
     */
    public function topUp(Item $item)
    {
        $topupAmount = $this->calculateTopupRequired($item);

        $this->getTopup()->setAmount($topupAmount);

        $this->setBalance($this->getBalance() + $topupAmount);
    }

    public function payFor(Item $item)
    {
        if ($this->getBalance() >= $item->getCost()) {
            $this->setBalance($this->getBalance() - $item->getCost());
        } else {
            throw new \Exception(sprintf(
                "There isn't sufficient balance (£%s) to purchase the item for %s",
                $this->getBalance(),
                $item->getCost()
            ));
        }
    }
}