<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Stock extends AbstractEntity
{
    use HasDynamicFields;

    private bool $enabled;
    private bool $hidden;
    private ?int $value;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function value(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
