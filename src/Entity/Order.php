<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Order
{
    protected int $id;

    protected bool $allowEmptyRelations;

    protected float $amount;
    protected float $amountWithTax;

    protected OrderBilling $billing;

    /** @var Comment[] */
    protected array $comments;

    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable | null $deletedAt;

    /** @var Discount[] */
    protected array $totalDiscounts;

    protected bool $first;
    protected bool $hidden;

    protected string | null $invoiceNumber;

    protected InvoiceStatus $invoiceStatus;

    /** @var Item[] */
    protected array $items;

    protected Mode $mode;

    protected Payment $payment;
    protected string $reference;

    protected Source $source;

    /** @var string[] */
    protected array $tags;

    /** @var Tax[] */
    protected array $taxes;

    protected DateTimeImmutable $updatedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function id(): int
    {
        return $this->id;
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

    public function setAmountWithTax(float $amountWithTax): self
    {
        $this->amountWithTax = $amountWithTax;

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function billing(): OrderBilling
    {
        if (!isset($this->billing)) {
            if ($this->allowEmptyRelations) {
                $this->billing = new OrderBilling($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('billing');
            }
        }

        return $this->billing;
    }

    public function setBilling(OrderBilling $billing): self
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

    public function deletedAt(): DateTimeImmutable | null
    {
        return $this->deletedAt;
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

    public function isFirst(): bool
    {
        return $this->first;
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

    public function invoiceNumber(): string | null
    {
        return $this->invoiceNumber;
    }

    public function invoiceStatus(): InvoiceStatus
    {
        return $this->invoiceStatus;
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

    public function source(): Source
    {
        return $this->source;
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

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
