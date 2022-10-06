<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;

/**
 * @internal
 */
class SubscriptionInternal extends Subscription
{
    /**
     * @internal
     */
    public function setCancelledAt(?DateTimeImmutable $cancelledAt): self
    {
        $this->cancelledAt = $cancelledAt;
        return $this;
    }

    /**
     * @internal
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @internal
     */
    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @internal
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @internal
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @internal
     */
    public function setSource(Source $source): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @internal
     */
    public function setStatus(SubscriptionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @internal
     */
    public function setTrial(SubscriptionTrial $trial): self
    {
        $this->trial = $trial;
        return $this;
    }
}
