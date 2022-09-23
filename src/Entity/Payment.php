<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\PaymentMethod;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Enum\PaymentType;

class Payment
{
    private ?string $customerId;
    private ?string $mandateId;
    private ?PaymentMethod $method;
    private int $orderId;
    private ?DateTimeImmutable $paidAt;
    private ?PaymentProvider $provider;
    private PaymentStatus $status;
    private ?string $transactionId;
    private PaymentType $type;
    private ?string $url;

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

    public function method(): ?PaymentMethod
    {
        return $this->method;
    }

    public function setMethod(?PaymentMethod $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function orderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function paidAt(): ?DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(?DateTimeImmutable $paidAt): self
    {
        $this->paidAt = $paidAt;
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

    public function status(): PaymentStatus
    {
        return $this->status;
    }

    public function setStatus(PaymentStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function transactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(?string $transactionId): self
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

    public function url(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
