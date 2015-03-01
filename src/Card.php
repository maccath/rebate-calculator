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
     * @var minimum topup
     */
    protected $minimumTopup;

    /**
     * @var FeeInterface topup fee
     */
    protected $fee;

    /**
     * @param FeeInterface $fee
     * @param              $balance
     * @param              $minimumTopup
     */
    function __construct(FeeInterface $fee, $balance = 0, $minimumTopup = 0)
    {
        $this->fee = $fee;
        $this->balance = $balance;
        $this->minimumTopup = $minimumTopup;
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
     * @return mixed
     */
    public function getMinimumTopup()
    {
        return $this->minimumTopup;
    }

    /**
     * @param $minimumTopup
     *
     * @throws \Exception
     */
    public function setMinimumTopup($minimumTopup)
    {
        if (!is_numeric($minimumTopup)) {
            throw new \Exception('Minimum top-up must be a numeric value.');
        }

        $this->minimumTopup = $minimumTopup;
    }

    /**
     * @return mixed
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
     * @param $topup
     *
     * @return mixed
     */
    public function topupCost($topup)
    {
        return $this->fee->calculate($topup);
    }
}