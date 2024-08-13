<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class Comment extends AbstractEntity
{
    protected DateTimeImmutable $createdAt;
    protected int $id;
    protected DateTimeImmutable $updatedAt;
    protected string $value;

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function value(): string
    {
        return $this->value;
    }
}
