<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class SellerStatistics extends AbstractEntity
{
    use HasDynamicFields;

    protected ?int $clicks;
    protected float $commission;
    protected float $locked;
    protected int $orders;
    protected float $paidout;
    protected float $pending;
    protected float $recurring;
    protected int $sales;
    protected float $value;

    public function clicks(): ?int
    {
        return $this->clicks;
    }

    public function commission(): float
    {
        return $this->commission;
    }

    public function locked(): float
    {
        return $this->locked;
    }

    public function orders(): int
    {
        return $this->orders;
    }

    public function paidout(): float
    {
        return $this->paidout;
    }

    public function pending(): float
    {
        return $this->pending;
    }

    public function recurring(): float
    {
        return $this->recurring;
    }

    public function sales(): int
    {
        return $this->sales;
    }

    public function value(): float
    {
        return $this->value;
    }
}
