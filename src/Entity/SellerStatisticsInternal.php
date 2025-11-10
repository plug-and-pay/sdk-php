<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

/**
 * @internal
 */
class SellerStatisticsInternal extends SellerStatistics
{
    public function setClicks(?int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function setCommission(float $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function setLocked(float $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function setOrders(int $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function setPaidout(float $paidout): self
    {
        $this->paidout = $paidout;

        return $this;
    }

    public function setPending(float $pending): self
    {
        $this->pending = $pending;

        return $this;
    }

    public function setRecurring(float $recurring): self
    {
        $this->recurring = $recurring;

        return $this;
    }

    public function setSales(int $sales): self
    {
        $this->sales = $sales;

        return $this;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
