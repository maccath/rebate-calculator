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
     * @var Topup topup
     */
    protected $topup;

    /**
     * @param Topup $topup
     * @param int   $balance
     */
    function __construct(Topup $topup, $balance = 0)
    {
        $this->topup = $topup;
        $this->balance = $balance;
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
     * @return Topup
     */
    public function getTopup()
    {
        return $this->topup;
    }

    /**
     * @param Topup $topup
     */
    public function setTopup(Topup $topup)
    {
        $this->topup = $topup;
    }
}