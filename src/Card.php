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
     * @var topup fee
     */
    protected $fee;

    /**
     * @param FeeInterface $fee
     * @param              $balance
     * @param              $minimumTopup
     */
    function __construct(FeeInterface $fee, $balance, $minimumTopup = 0)
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
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
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
        $this->fee = fee;
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