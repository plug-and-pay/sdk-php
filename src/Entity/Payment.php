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
    protected ?string $customerId;
    protected ?string $mandateId;
    protected ?PaymentMethod $method;
    protected ?int $orderId;
    protected ?DateTimeImmutable $paidAt;
    protected ?PaymentProvider $provider;
    protected ?PaymentStatus $status;
    protected ?string $transactionId;
    protected ?PaymentType $type;
    protected ?string $url;

    public function customerId(): ?string
    {
        return $this->customerId;
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

    public function orderId(): ?int
    {
        return $this->orderId;
    }

    public function paidAt(): ?DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function provider(): ?PaymentProvider
    {
        return $this->provider;
    }

    public function status(): ?PaymentStatus
    {
        return $this->status;
    }

    public function setStatus(?PaymentStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function transactionId(): ?string
    {
        return $this->transactionId;
    }

    public function type(): ?PaymentType
    {
        return $this->type;
    }

    public function setType(?PaymentType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function url(): ?string
    {
        return $this->url;
    }

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
