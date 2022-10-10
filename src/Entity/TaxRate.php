<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Enum\CountryCode;

class TaxRate
{
    protected int $id;
    protected CountryCode $country;
    protected float $percentage;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function country(): CountryCode
    {
        return $this->country;
    }

    public function percentage(): float
    {
        return $this->percentage;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
