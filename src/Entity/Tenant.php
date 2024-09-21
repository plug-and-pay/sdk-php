<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Tenant extends AbstractEntity
{
    protected int $id;

    public function id(): int
    {
        return $this->id;
    }
}
