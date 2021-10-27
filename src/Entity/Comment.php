<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class Comment
{
    private DateTimeImmutable $createdAt;
    private int $id;
    private DateTimeImmutable $updatedAt;
    private string $value;

    public static function byValue(string $value)
    {
        return (new self())->setValue($value);
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Comment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setId(int $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): Comment
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setValue(string $value): Comment
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
