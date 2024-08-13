<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class PricingTrial extends AbstractEntity
{
    use ValidatesFieldMethods;

    private float $amount;
    private float $amountWithTax;
    private int $duration;

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

    public function duration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
