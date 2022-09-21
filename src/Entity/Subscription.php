<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Subscription
{
    private bool $allowEmptyRelations;
    private int $id;
    private ?DateTimeImmutable $cancelledAt;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $deletedAt;
    private Mode $mode;
    private Pricing $pricing;
    private Product $product;
    private SubscriptionStatus $status;
    private Source $source;

    // /** @var string[] */
    // private array $tags; TODO:: make relation
    // private string $meta; TODO:: make relation
    // private Trial $trial; TODO:: make relation

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function cancelledAt(): ?DateTimeImmutable
    {
        return $this->cancelledAt;
    }

    /**
     * @internal
     */
    public function setCancelledAt(?DateTimeImmutable $cancelledAt): self
    {
        $this->cancelledAt = $cancelledAt;
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

    public function mode(): Mode
    {
        return $this->mode;
    }

    public function setMode(Mode $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    public function pricing(): Pricing
    {
        if (!isset($this->pricing)) {
            if ($this->allowEmptyRelations) {
                $this->pricing = new Pricing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('billing');
            }
        }

        return $this->pricing;
    }

    public function setPricing(Pricing $pricing): self
    {
        $this->pricing = $pricing;
        return $this;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function status(): SubscriptionStatus
    {
        return $this->status;
    }

    public function setStatus(SubscriptionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }
        return isset($this->{$field});
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
}
