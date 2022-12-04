<?php

namespace RebateCalculator;

/**
 * Class TopUpCalculator
 *
 * @package RebateCalculator
 */
class TopUpCalculator
{
    /**
     * The card to purchase item with
     *
     * @var Card
     */
    private $card;

    /**
     * The item to purchase
     *
     * @var Item
     */
    private $item;

    /**
     * TopUpCalculator constructor
     *
     * @param Card $card the card to purchase item with
     * @param Item $item the item to purchase
     */
    public function __construct(Card $card, Item $item)
    {
        $this->card = $card;
        $this->item = $item;
    }

    /**
     * Calculate top up required to purchase item
     *
     * @return mixed
     */
    public function calculateTopUpRequired()
    {
        $additionalFundingRequired = $this->getAdditionalFundingRequiredForPurchase();

        if (! $additionalFundingRequired) {
            return 0;
        }

        $minimumTopUp = $this->card->getMinimumTopUp();

        if ($additionalFundingRequired < $minimumTopUp) {
            return $minimumTopUp;
        }

        return $additionalFundingRequired;
    }

    /**
     * Calculate the additional funding required to purchase item
     *
     * @return int|mixed
     */
    private function getAdditionalFundingRequiredForPurchase()
    {
        $itemCost = $this->item->getCost();
        $currentBalance = $this->card->getBalance();

        if ($itemCost <= $currentBalance) {
            return 0;
        }

        return $itemCost - $currentBalance;
    }
}
