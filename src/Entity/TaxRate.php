<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class TaxRate
{
    use ValidatesFieldMethods;

    protected int $id;
    protected CountryCode $country;
    protected float $percentage;

    public function id(): int
    {
        return $this->id;
    }

    public function country(): CountryCode
    {
        return $this->country;
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}
