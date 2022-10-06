<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

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
    public function setTransactionId(?int $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}
