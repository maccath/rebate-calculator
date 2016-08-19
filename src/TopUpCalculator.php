<?php

namespace RebateCalculator;

class TopUpCalculator
{
    /**
     * Calculate top up required to purchase item
     *
     * @param Card $card the card to top up
     * @param Item $item the item to purchase
     *
     * @return mixed
     */
    public static function calculateTopUpRequired(Card $card, Item $item)
    {
        $itemCost = $item->getCost();
        $currentBalance = $card->getBalance();

        $additionalBalanceRequired = $itemCost - $currentBalance;
        $minimumTopup = $card->getTopUpFacility()->getMinimum();

        if ($additionalBalanceRequired && $additionalBalanceRequired < $minimumTopup) {
            return $minimumTopup;
        } else {
            return $additionalBalanceRequired;
        }
    }
}