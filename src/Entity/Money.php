<?php

namespace PlugAndPay\Sdk\Entity;


use PlugAndPay\Sdk\Enum\CurrencyCodeIso;

class Money
{
    private string $currency;
    private float $value;

    public function __construct(float $value, string $currency = CurrencyCodeIso::EUR)
    {
        $this->value    = $value;
        $this->currency = $currency;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function value(): float
    {
        return $this->value;
    }
}
