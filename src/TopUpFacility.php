<?php

namespace RebateCalculator;

/**
 * Class TopUpFacility
 *
 * @package RebateCalculator
 */
class TopUpFacility
{
    /**
     * @var FeeInterface topup fee
     */
    protected $fee;

    /**
     * @var
     */
    protected $minimum;

    /**
     * @var
     */
    protected $amount;

    /**
     * @param FeeInterface $fee
     * @param              $minimum
     * @param              $amount
     *
     * @throws \Exception
     */
    function __construct(FeeInterface $fee, $minimum = 0, $amount = 0)
    {
        $this->setFee($fee);
        $this->setMinimum($minimum);
        $this->setAmount($amount);
    }

    /**
     * @return FeeInterface
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param FeeInterface $fee
     */
    public function setFee(FeeInterface $fee)
    {
        $this->fee = $fee;
    }

    /**
     * @return mixed
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param mixed $minimum
     *
     * @throws \Exception
     */
    public function setMinimum($minimum)
    {
        if (!is_numeric($minimum) || $minimum < 0) {
            throw new \Exception(
                sprintf(
                    'Minimum (%s) must be a positive numeric value.',
                    $minimum
                )
            );
        }

        $this->minimum = $minimum;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     *
     * @throws \Exception
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount) || $amount < 0) {
            throw new \Exception(
                sprintf(
                    'Amount (%s) must be a positive numeric value.',
                    $amount
                )
            );
        }

        if ($amount < $this->minimum)
        {
            throw new \Exception(
                sprintf(
                    'Amount (%s) must be greater than or equal to the minimum (%s).',
                    $amount,
                    $this->minimum
                )
            );
        }

        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function calculateTopupCost()
    {
        return $this->fee->calculate($this->amount);
    }
}