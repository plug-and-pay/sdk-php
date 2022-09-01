<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Discount
{
    private float $amount;
    private ?string $code;
    /**
     * @see \PlugAndPay\Sdk\Entity\DiscountType
     */
    private string $type;

    public function amount(): float
    {
        return $this->amount;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function setAmount(float $amount): Discount
    {
        $this->amount = $amount;
        return $this;
    }

    public function setCode(?string $code): Discount
    {
        $this->code = $code;
        return $this;
    }

    public function setType(string $type): Discount
    {
        $this->type = $type;
        return $this;
    }

    public function type(): string
    {
        return $this->type;
    }
}
