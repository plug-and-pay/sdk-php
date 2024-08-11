<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Shipping
{
    use HasDynamicFields;

    private float $amount;
    private float $amountWithTax;

    public function amount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function amountWithTax(): float
    {
        return $this->amountWithTax;
    }

    public function setAmountWithTax(float $amountWithTax): self
    {
        $this->amountWithTax = $amountWithTax;

        return $this;
    }
}
