<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\PaymentMethod;
use PlugAndPay\Sdk\Enum\PaymentProvider;

/**
 * @internal
 */
class PaymentInternal extends Payment
{
    /**
     * @internal
     */
    public function setCustomerId(?string $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @internal
     */
    public function setMethod(?PaymentMethod $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @internal
     */
    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @internal
     */
    public function setPaidAt(?DateTimeImmutable $paidAt): self
    {
        $this->paidAt = $paidAt;
        return $this;
    }

    /**
     * @internal
     */
    public function setProvider(?PaymentProvider $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @internal
     */
    public function setTransactionId(?string $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @internal
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }
}
