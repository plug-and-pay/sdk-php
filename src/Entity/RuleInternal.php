<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class RuleInternal extends Rule
{
    /**
     * @internal
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): self
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
    public function setUpdatedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
