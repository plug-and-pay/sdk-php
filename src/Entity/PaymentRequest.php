<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class PaymentRequest
{
    private string $iban;
    private string $name;
    private string $type;

    public function iban(): string
    {
        return $this->iban;
    }

    public function setIban(string $iban): PaymentRequest
    {
        $this->iban = $iban;
        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): PaymentRequest
    {
        $this->name = $name;
        return $this;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setType(string $type): PaymentRequest
    {
        $this->type = $type;
        return $this;
    }
}
