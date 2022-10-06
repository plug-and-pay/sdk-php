<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\PaymentProvider;

/**
 * @internal
 */
class SubscriptionPaymentOptionsInternal extends SubscriptionPaymentOptions
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
    public function setProvider(?PaymentProvider $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @internal
     */
    public function setTransactionId(?int $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}
