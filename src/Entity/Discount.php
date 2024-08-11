<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\DiscountType;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class Discount
{
    use ValidatesFieldMethods;

    private float $amount;
    private float $amountWithTax;
    private ?string $code;
    private DiscountType $type;

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

    public function code(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function type(): DiscountType
    {
        return $this->type;
    }

    public function setType(DiscountType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
