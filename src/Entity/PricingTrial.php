<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class PricingTrial
{
    private float $amount;
    private float $amountWithTax;
    private int $duration;

    public function amount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): PricingTrial
    {
        $this->amount = $amount;
        return $this;
    }

    public function amountWithTax(): float
    {
        return $this->amountWithTax;
    }

    public function setAmountWithTax(float $amountWithTax): PricingTrial
    {
        $this->amountWithTax = $amountWithTax;
        return $this;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): PricingTrial
    {
        $this->duration = $duration;
        return $this;
    }
}
