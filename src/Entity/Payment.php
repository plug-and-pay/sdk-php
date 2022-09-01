<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class Payment
{
    private string $customerId;
    private string $mandateId;
    private string $method;
    private int $orderId;
    private ?DateTimeImmutable $paidAt;
    private string $provider;
    private string $status;
    private string $transactionId;
    private string $type;
    private string $url;

    public function customerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): Payment
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function mandateId(): string
    {
        return $this->mandateId;
    }

    public function setMandateId(string $mandateId): Payment
    {
        $this->mandateId = $mandateId;
        return $this;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): Payment
    {
        $this->method = $method;
        return $this;
    }

    public function orderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): Payment
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function paidAt(): ?DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(?DateTimeImmutable $paidAt): Payment
    {
        $this->paidAt = $paidAt;
        return $this;
    }

    public function provider(): string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): Payment
    {
        $this->provider = $provider;
        return $this;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Payment
    {
        $this->status = $status;
        return $this;
    }

    public function transactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): Payment
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setType(string $type): Payment
    {
        $this->type = $type;
        return $this;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Payment
    {
        $this->url = $url;
        return $this;
    }
}
