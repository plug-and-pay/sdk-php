<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class SellerProfileInternal extends SellerProfile
{
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setDefaultRecurring(bool $defaultRecurring): self
    {
        $this->defaultRecurring = $defaultRecurring;

        return $this;
    }

    public function setDefaultType(string $defaultType): self
    {
        $this->defaultType = $defaultType;

        return $this;
    }

    public function setDefaultValue(float $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function setDefaultFormValue(float $defaultFormValue): self
    {
        $this->defaultFormValue = $defaultFormValue;

        return $this;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setSessionLifetime(int $sessionLifetime): self
    {
        $this->sessionLifetime = $sessionLifetime;

        return $this;
    }

    public function setTenantId(int $tenantId): self
    {
        $this->tenantId = $tenantId;

        return $this;
    }
}