<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\DiscountType;

class Discount
{
    private float $amount;
    private ?string $code;
    private DiscountType $type;

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

    public function setType(DiscountType $type): Discount
    {
        $this->type = $type;
        return $this;
    }

    public function type(): DiscountType
    {
        return $this->type;
    }
}
