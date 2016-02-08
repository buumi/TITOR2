<?php


/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 2/8/16
 * Time: 5:05 PM
 */
class Money
{
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function negate()
    {
        return new Money(-1 * $this->amount);
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}