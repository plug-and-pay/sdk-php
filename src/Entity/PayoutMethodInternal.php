<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

/**
 * @internal
 */
class PayoutMethodInternal extends PayoutMethod
{
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
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @internal
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @internal
     */
    public function setSettings(?array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @internal
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}