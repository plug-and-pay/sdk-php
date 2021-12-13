<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Order
{
    private Billing $billing;
    /** @var \PlugAndPay\Sdk\Entity\Comment[] */
    private array $comments;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $deletedAt;
    /** @var \PlugAndPay\Sdk\Entity\Discount[] */
    private array $discounts;
    private bool $first;
    private bool $hidden;
    private int $id;
    private bool $allowEmptyRelations;
    private ?string $invoiceNumber;
    private string $invoiceStatus;
    /** @var \PlugAndPay\Sdk\Entity\Item[] */
    private array $items;
    private string $mode;
    private Payment $payment;
    private string $reference;
    private string $source;
    private Money $subtotal;
    /** @var string[] */
    private array $tags;
    private string $taxExempt;
    private bool $taxIncludes;
    /** @var \PlugAndPay\Sdk\Entity\Payment[] */
    private array $taxes;
    private Money $total;
    private DateTimeImmutable $updatedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function billing(): Billing
    {
        if (!isset($this->billing)) {
            if ($this->allowEmptyRelations) {
                $this->billing = new Billing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('billing');
            }
        }

        return $this->billing;
    }

    /**
     * @return \PlugAndPay\Sdk\Entity\Comment[]
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function comments(): array
    {
        if (!isset($this->comments)) {
            throw new RelationNotLoadedException('comments');
        }

        return $this->comments;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    /**
     * @return \PlugAndPay\Sdk\Entity\Discount[]
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function discounts(): array
    {
        if (!isset($this->discounts)) {
            throw new RelationNotLoadedException('discount');
        }

        return $this->discounts;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function invoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function invoiceStatus(): string
    {
        return $this->invoiceStatus;
    }

    public function isFirst(): bool
    {
        return $this->first;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @internal
     */
    public function isTaxIncluded(): bool
    {
        return $this->taxIncludes;
    }

    public function isset(string $field): bool
    {
        return isset($this->{$field});
    }

    /**
     * @return \PlugAndPay\Sdk\Entity\Item[]
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function items(): array
    {
        if (!isset($this->items)) {
            throw new RelationNotLoadedException('items');
        }

        return $this->items;
    }

    public function mode(): string
    {
        return $this->mode;
    }

    public function payment(): Payment
    {
        if (!isset($this->payment)) {
            if ($this->allowEmptyRelations) {
                $this->payment = new Payment();
            } else {
                throw new RelationNotLoadedException('payment');
            }
        }

        return $this->payment;
    }

    public function reference(): string
    {
        return $this->reference;
    }

    public function setBilling(Billing $billing): self
    {
        $this->billing = $billing;
        return $this;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments(array $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

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
    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function setDiscounts(array $discounts): self
    {
        $this->discounts = $discounts;
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

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;
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
    public function setInvoiceNumber(?string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * @internal
     */
    public function setInvoiceStatus(string $invoiceStatus): self
    {
        $this->invoiceStatus = $invoiceStatus;
        return $this;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;
        return $this;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function setSubtotal(Money $subtotal): self
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function setTaxExempt(string $taxExempt): self
    {
        $this->taxExempt = $taxExempt;

        return $this;
    }

    public function setTaxIncluded(bool $taxIncluded): self
    {
        $this->taxIncludes = $taxIncluded;
        return $this;
    }

    public function setTaxes(array $taxes): self
    {
        $this->taxes = $taxes;
        return $this;
    }

    public function setTotal(Money $total): self
    {
        $this->total = $total;
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

    public function source(): string
    {
        return $this->source;
    }

    public function subtotal(): Money
    {
        return $this->subtotal;
    }

    /**
     * @return string[]
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function tags(): array
    {
        if (!isset($this->tags)) {
            throw new RelationNotLoadedException('tags');
        }

        return $this->tags;
    }

    public function taxExempt(): string
    {
        return $this->taxExempt;
    }

    /**
     * @return Tax[]
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException()
     */
    public function taxes(): array
    {
        if (!isset($this->taxes)) {
            throw new RelationNotLoadedException('taxes');
        }

        return $this->taxes;
    }

    public function total(): Money
    {
        return $this->total;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
