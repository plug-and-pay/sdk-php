<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class PayoutMethod extends AbstractEntity
{
    protected string $method;
    protected ?array $settings;

    public function method(): string
    {
        return $this->method;
    }

    public function settings(): ?array
    {
        return $this->settings;
    }
}
