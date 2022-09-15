<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Enum\CountryCode;

class Rate
{
    private CountryCode $country;
    private int $id;
    private float $percentage;

    public function __construct(?float $percentage, ?CountryCode $country, int $id = null)
    {
        if ($percentage !== null) {
            $this->percentage = $percentage;
        }
        if ($country !== null) {
            $this->country = $country;
        }
        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function country(): CountryCode
    {
        return $this->country;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }
        return isset($this->{$field});
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}
