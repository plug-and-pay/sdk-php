<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentType;

class SubscriptionPaymentOptions
{
    private ?string $customerId;
    private ?string $mandateId;
    private ?PaymentProvider $provider;
    private ?int $transactionId;
    private PaymentType $type;
    private ?string $iban;
    private ?string $name;

    public function customerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(?string $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function mandateId(): ?string
    {
        return $this->mandateId;
    }

    public function setMandateId(?string $mandateId): self
    {
        $this->mandateId = $mandateId;
        return $this;
    }

    public function provider(): ?PaymentProvider
    {
        return $this->provider;
    }

    public function setProvider(?PaymentProvider $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    public function transactionId(): ?int
    {
        return $this->transactionId;
    }

    public function setTransactionId(?int $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function type(): PaymentType
    {
        return $this->type;
    }

    public function setType(PaymentType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function iban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): self
    {
        $this->iban = $iban;
        return $this;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
