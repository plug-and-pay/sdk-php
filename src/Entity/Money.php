<?php

namespace PlugAndPay\Sdk\Entity;


class Money
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }
}
