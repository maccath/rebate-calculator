<?php

namespace RebateCalculator;

/**
 * Class Topup
 *
 * @package RebateCalculator
 */
class Topup
{
    /**
     * @var FeeInterface topup fee
     */
    protected $fee;

    protected $minimum;

    protected $amount;

    /**
     * @param FeeInterface $fee
     * @param              $minimum
     * @param              $amount
     *
     * @throws \Exception
     */
    function __construct(FeeInterface $fee, $minimum, $amount)
    {
        if (!is_numeric($minimum)) {
            throw new \Exception('Minimum must be a numeric value.');
        }

        if (!is_numeric($amount)) {
            throw new \Exception('Amount must be a numeric value.');
        }

        $this->fee = $fee;
        $this->minimum = $minimum;
        $this->amount = $amount;
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
     * @param $minimum
     *
     * @throws \Exception
     */
    public function setMinimum($minimum)
    {
        if (!is_numeric($minimum)) {
            throw new \Exception('Amount must be a numeric value.');
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
     * @param $amount
     *
     * @throws \Exception
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new \Exception('Amount must be a numeric value.');
        }

        $this->amount = $amount;
    }

    public function calculateTopupCost()
    {

    }
}