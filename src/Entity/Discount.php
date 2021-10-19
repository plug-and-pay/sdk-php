<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Discount
{
    private Money $amount;
    private ?string $code;
    private string $type;

    public function amount(): Money
    {
        return $this->amount;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function setAmount(Money $amount): Discount
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
