<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

/**
 * @internal
 */
class CommentInternal extends Comment
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
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
