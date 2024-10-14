<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

class MembershipsSettingFilter
{
    private array $parameters = [];

    public function driver(string $value): self
    {
        $this->parameters['driver'] = $value;

        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
