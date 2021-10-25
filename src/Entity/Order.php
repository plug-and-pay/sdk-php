<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Order
{
    private Billing $billing;
    /** @var Comment[] */
    private array $comments;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $deletedAt;
    private bool $first;
    private bool $hidden;
    private int $id;
    private string $invoiceNumber;
    private string $invoiceStatus;
    /** @var Item[] */
    private array $items;
    private string $mode;
    private Payment $payment;
    private string $reference;
    private string $source;
    private Money $subtotal;
    /** @var string[] */
    private array $tags;
    /** @var Payment[] */
    private array $taxes;
    private Money $total;
    private DateTimeImmutable $updatedAt;

    public function billing(): Billing
    {
        if (!isset($this->billing)) {
            throw new RelationNotLoadedException('billing');
        }

        return $this->billing;
    }

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
        return $this->first;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

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
            throw new RelationNotLoadedException('payment');
        }

        return $this->payment;
    }

    public function reference(): string
    {
        return $this->reference;
    }

    public function setBilling(Billing $billing): Order
    {
        $this->billing = $billing;
        return $this;
    }

    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Order
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): Order
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function setFirst(bool $first): Order
    {
        $this->first = $first;
        return $this;
    }

    public function setHidden(bool $hidden): Order
    {
        $this->hidden = $hidden;
        return $this;
    }

    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function setInvoiceNumber(string $invoiceNumber): Order
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function setInvoiceStatus(string $invoiceStatus): Order
    {
        $this->invoiceStatus = $invoiceStatus;
        return $this;
    }

    public function setItems(array $items): Order
    {
        $this->items = $items;
        return $this;
    }

    public function setMode(string $mode): Order
    {
        $this->mode = $mode;
        return $this;
    }

    public function setPayment(Payment $payment): Order
    {
        $this->payment = $payment;
        return $this;
    }

    public function setReference(string $reference): Order
    {
        $this->reference = $reference;
        return $this;
    }

    public function setSource(string $source): Order
    {
        $this->source = $source;
        return $this;
    }

    public function setSubtotal(Money $subtotal): Order
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function setTaxes(array $taxes): Order
    {
        $this->taxes = $taxes;
        return $this;
    }

    public function setTotal(Money $total): Order
    {
        $this->total = $total;
        return $this;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): Order
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

    public function tags(): array
    {
        return $this->tags;
    }

    /**
     * @return Tax[]
     * @throws RelationNotLoadedException
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
