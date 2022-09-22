<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use PlugAndPay\Sdk\Enum\CountryCode;

class TaxRateFilter
{
    private array $parameters = [];

    public function country(CountryCode $value): self
    {
        $this->parameters['country'] = $value->value;
        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
