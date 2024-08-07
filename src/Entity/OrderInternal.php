<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\Source;

/**
 * @internal
 */
class OrderInternal extends Order
{
    /**
     * @internal
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @internal
     */
    public function setDeletedAt(DateTimeImmutable | null $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @internal
     */
    public function setFirst(bool $first): self
    {
        $this->first = $first;

        return $this;
    }

    /**
     * @internal
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @internal
     */
    public function setInvoiceNumber(string | null $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @internal
     */
    public function setInvoiceStatus(InvoiceStatus $invoiceStatus): self
    {
        $this->invoiceStatus = $invoiceStatus;

        return $this;
    }

    /**
     * @internal
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @internal
     */
    public function setSource(Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @internal
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
