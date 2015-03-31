<?php

namespace RebateCalculator;

/**
 * Class SavingsCalculator
 *
 * @package RebateCalculator
 */
class SavingsCalculator
{
    /**
     * @var Card
     */
    protected $card;

    /**
     * @var Store
     */
    protected $store;

    /**
     * @var Item
     */
    protected $item;

    /**
     * @param Card  $card
     * @param Store $store
     * @param Item  $item
     */
    public function __construct(Card $card, Store $store, Item $item)
    {
        $this->card = $card;
        $this->store = $store;
        $this->item = $item;
    }

    /**
     * @return Item mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param Card $card
     */
    public function setCard(Card $card)
    {
        $this->card = $card;
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param Store $store
     */
    public function setStore(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Calculate total cost to buy item
     *
     * @return mixed
     */
    public function calculateCost()
    {
        $this->card->topup($this->getItem());
        $topupCost = $this->card->getTopup()->calculateTopupCost();
        $rebate = $this->calculateRebateAmount();

        $totalCost = $this->item->getCost() + $topupCost - $rebate;

        return $totalCost;
    }

    /**
     * Calculate balance that will remain in card account after rebate processed
     *
     * @return mixed
     */
    public function calculateRemainingBalance()
    {
        $topup = $this->card->calculateTopupRequired($this->item);
        $rebate = $this->calculateRebateAmount();

        return $this->card->getBalance() + $topup - $this->item->getCost() + $rebate;
    }

    /**
     * Calculate rebate
     *
     * @return mixed
     */
    public function calculateRebateAmount()
    {
        return $this->store->getRebate()->calculate($this->item->getCost());
    }
}