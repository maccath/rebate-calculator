<?php

declare(strict_types=1);

namespace RebateCalculator;

final class TopUpCalculator
{
    public function __construct(private readonly Card $card, private readonly Item $item)
    {
    }

    /**
     * Calculate top up required to purchase item
     */
    public function calculateTopUpRequired(): float
    {
        $additionalFundingRequired = $this->getAdditionalFundingRequiredForPurchase();

        if (! $additionalFundingRequired) {
            return 0.0;
        }

        $minimumTopUp = $this->card->getMinimumTopUp();

        if ($additionalFundingRequired < $minimumTopUp) {
            return $minimumTopUp;
        }

        return $additionalFundingRequired;
    }

    /**
     * Calculate the additional funding required to purchase item
     */
    private function getAdditionalFundingRequiredForPurchase(): float
    {
        $itemCost = $this->item->getCost();
        $currentBalance = $this->card->getBalance();

        if ($itemCost <= $currentBalance) {
            return 0.0;
        }

        return $itemCost - $currentBalance;
    }
}
