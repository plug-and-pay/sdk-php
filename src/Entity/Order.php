<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\TaxExempt;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Order
{
    private bool $allowEmptyRelations;
    private float $amount;
    private float $amountWithTax;
    private Billing $billing;
    /** @var Comment[] */
    private array $comments;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $deletedAt;
    /** @var Discount[] */
    private array $totalDiscounts;
    private bool $first;
    private bool $hidden;
    private int $id;
    private ?string $invoiceNumber;
    private InvoiceStatus $invoiceStatus;
    /** @var Item[] */
    private array $items;
    private Mode $mode;
    private Payment $payment;
    private string $reference;
    private Source $source;
    /** @var string[] */
    private array $tags;
    private TaxExempt $taxExempt;
    /** @var Tax[] */
    private array $taxes;
    private DateTimeImmutable $updatedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function id(): int
    {
        return $this->id;
    }

    /**
     * @internal
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function amountWithTax(): float
    {
        return $this->amountWithTax;
    }

    public function setTotal(float $amountWithTax): self
    {
        $this->amountWithTax = $amountWithTax;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
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

    public function setBilling(Billing $billing): self
    {
        $this->billing = $billing;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function comments(): array
    {
        if (!isset($this->comments)) {
            throw new RelationNotLoadedException('comments');
        }

        return $this->comments;
    }

    public function setComments(array $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @internal
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    /**
     * @internal
     */
    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function totalDiscounts(): array
    {
        if (!isset($this->totalDiscounts)) {
            throw new RelationNotLoadedException('totalDiscounts');
        }

        return $this->totalDiscounts;
    }

    public function setTotalDiscounts(array $totalDiscounts): self
    {
        $this->totalDiscounts = $totalDiscounts;
        return $this;
    }

    public function invoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    /**
     * @internal
     */
    public function setInvoiceNumber(?string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function invoiceStatus(): InvoiceStatus
    {
        return $this->invoiceStatus;
    }

    /**
     * @internal
     */
    public function setInvoiceStatus(InvoiceStatus $invoiceStatus): self
    {
        $this->invoiceStatus = $invoiceStatus;
        return $this;
    }

    public function isFirst(): bool
    {
        return $this->first;
    }

    /**
     * @internal
     */
    public function setFirst(bool $first): self
    {
        $this->first = $first;
        return $this;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function items(): array
    {
        if (!isset($this->items)) {
            throw new RelationNotLoadedException('items');
        }

        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function mode(): Mode
    {
        return $this->mode;
    }

    public function setMode(Mode $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
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

    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;
        return $this;
    }

    public function reference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function source(): Source
    {
        return $this->source;
    }

    public function setSource(Source $source): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function tags(): array
    {
        if (!isset($this->tags)) {
            throw new RelationNotLoadedException('tags');
        }

        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function taxExempt(): TaxExempt
    {
        return $this->taxExempt;
    }

    public function setTaxExempt(TaxExempt $taxExempt): self
    {
        $this->taxExempt = $taxExempt;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function taxes(): array
    {
        if (!isset($this->taxes)) {
            throw new RelationNotLoadedException('taxes');
        }

        return $this->taxes;
    }

    public function setTaxes(array $taxes): self
    {
        $this->taxes = $taxes;
        return $this;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @internal
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
