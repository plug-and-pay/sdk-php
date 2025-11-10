<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class SellerProfile extends AbstractEntity
{
    use HasDynamicFields;

    protected int $id;
    protected bool $defaultRecurring;
    protected string $defaultType;
    protected float $defaultValue;
    protected float $defaultFormValue;
    protected string $label;
    protected int $sessionLifetime;
    protected int $tenantId;

    public function id(): int
    {
        return $this->id;
    }

    public function defaultRecurring(): bool
    {
        return $this->defaultRecurring;
    }

    public function defaultType(): string
    {
        return $this->defaultType;
    }

    public function defaultValue(): float
    {
        return $this->defaultValue;
    }

    public function defaultFormValue(): float
    {
        return $this->defaultFormValue;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function sessionLifetime(): int
    {
        return $this->sessionLifetime;
    }

    public function tenantId(): int
    {
        return $this->tenantId;
    }
}
