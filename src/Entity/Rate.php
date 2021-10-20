<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Rate
{
    private string $country;
    private float $percentage;

    public function __construct(float $percentage, string $country)
    {
        $this->country    = $country;
        $this->percentage = $percentage;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}
