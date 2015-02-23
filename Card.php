<?php

/**
 * Class card
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
    function __construct(FeeInterface $fee, Float $balance, Float $minimumTopup)
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
     * @param mixed $minimumTopup
     */
    public function setMinimumTopup($minimumTopup)
    {
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
}