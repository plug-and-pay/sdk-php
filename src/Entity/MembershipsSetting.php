<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class MembershipsSetting extends AbstractEntity
{
    use HasDynamicFields;

    protected int $id;
    protected string $driver;
    protected bool $isActive;
    protected int $tenantId;
    protected string $apiToken;
    protected DateTimeImmutable $createdAt;
    protected ?DateTimeImmutable $updatedAt;


    public function id(): int
    {
        return $this->id;
    }

    public function driver(): string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function tenantId(): int
    {
        return $this->tenantId;
    }

    public function setTenantId(int $tenantId): self
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    public function apiToken(): string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
