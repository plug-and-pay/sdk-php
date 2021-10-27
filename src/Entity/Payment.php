<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class Payment
{
    private int $orderId;
    private DateTimeImmutable $paidAt;
    private string $status;
    private string $url;

    public function orderId(): int
    {
        return $this->orderId;
    }

    public function paidAt(): DateTimeImmutable
    {
        return $this->paidAt;
    }

    /**
     * @internal
     */
    public function setOrderId(int $orderId): Payment
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @internal
     */
    public function setPaidAt(DateTimeImmutable $paidAt): Payment
    {
        $this->paidAt = $paidAt;
        return $this;
    }

    public function setStatus(string $status): Payment
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @internal
     */
    public function setUrl(string $url): Payment
    {
        $this->url = $url;
        return $this;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function url(): string
    {
        return $this->url;
    }
}
