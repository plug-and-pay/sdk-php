<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Tenant extends AbstractEntity
{
    protected int $id;
    protected string $plan;

    public function id(): int
    {
        return $this->id;
    }

    public function plan(): string
    {
        return $this->plan;
    }
}
