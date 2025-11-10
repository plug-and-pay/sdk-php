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
    protected int $paidout;
    protected int $pending;
    protected int $recurring;
    protected int $sales;
    protected int $value;

    public function clicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(?int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function commission(): float
    {
        return $this->commission;
    }

    public function setCommission(float $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function locked(): float
    {
        return $this->locked;
    }

    public function setLocked(float $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function orders(): int
    {
        return $this->orders;
    }

    public function setOrders(int $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function paidout(): int
    {
        return $this->paidout;
    }

    public function setPaidout(int $paidout): self
    {
        $this->paidout = $paidout;

        return $this;
    }

    public function pending(): int
    {
        return $this->pending;
    }

    public function setPending(int $pending): self
    {
        $this->pending = $pending;

        return $this;
    }

    public function recurring(): int
    {
        return $this->recurring;
    }

    public function setRecurring(int $recurring): self
    {
        $this->recurring = $recurring;

        return $this;
    }

    public function sales(): int
    {
        return $this->sales;
    }

    public function setSales(int $sales): self
    {
        $this->sales = $sales;

        return $this;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
