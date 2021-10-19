<?php

namespace PlugAndPay\Sdk\Entity;


class Money
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
