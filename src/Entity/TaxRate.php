<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\CountryCode;

class TaxRate
{
    private int $id;
    private CountryCode $countryCode;
    private float $percentage;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): TaxRate
    {
        $this->id = $id;
        return $this;
    }

    public function countryCode(): CountryCode
    {
        return $this->countryCode;
    }

    public function setCountryCode(CountryCode $countryCode): TaxRate
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function percentage(): float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): TaxRate
    {
        $this->percentage = $percentage;
        return $this;
    }
}
