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
     */
    public function calculateCost()
    {
        $itemCost = $this->item->getCost();
        $currentBalance = $this->card->getBalance();

        $topupRequired = $itemCost - $currentBalance;

        $topupFee = $this->card->getFee()->calculate($topupRequired);
        $rebate = $this->store->getRebate()->calculate($itemCost);

        $totalCost = $itemCost + $topupFee - $rebate;

        return $totalCost;
    }
}