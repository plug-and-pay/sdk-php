<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class PayoutMethod extends AbstractEntity
{
    protected DateTimeImmutable $createdAt;
    protected int $id;
    protected string $method;
    protected ?array $settings;
    protected DateTimeImmutable $updatedAt;

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function settings(): ?array
    {
        return $this->settings;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}