<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Order
{
    private string $createdAt;
    private string $deletedAt;
    private int $id;
    private string $invoiceNumber;
    private string $invoiceStatus;
    private bool $isFirst;
    private bool $isHidden;
    private string $mode;
    private string $reference;
    private string $source;
    private Money $money;
    private string $updatedAt;

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function deletedAt(): string
    {
        return $this->deletedAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function invoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function invoiceStatus(): string
    {
        return $this->invoiceStatus;
    }

    public function isFirst(): bool
    {
        return $this->isFirst;
    }

    public function setIsFirst(bool $isFirst): void
    {
        $this->isFirst = $isFirst;
    }

    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    public function setIsHidden(bool $isHidden): void
    {
        $this->isHidden = $isHidden;
    }

    public function mode(): string
    {
        return $this->mode;
    }

    public function money(): Money
    {
        return $this->money;
    }

    public function reference(): string
    {
        return $this->reference;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setDeletedAt(string $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setInvoiceNumber(string $invoiceNumber): void
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    public function setInvoiceStatus(string $invoiceStatus): void
    {
        $this->invoiceStatus = $invoiceStatus;
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function setMoney(Money $money): void
    {
        $this->money = $money;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function source(): string
    {
        return $this->source;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }
}
