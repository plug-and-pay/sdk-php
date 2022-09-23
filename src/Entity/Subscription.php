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
    private SubscriptionPricing $pricing;
    private Product $product;
    private SubscriptionStatus $status;
    private Source $source;
    private Billing $billing;
    /** @var string[] */
    private array $tags;
    private SubscriptionTrial $trial;

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

    /**
     * @throws RelationNotLoadedException
     */
    public function pricing(): SubscriptionPricing
    {
        if (!isset($this->pricing)) {
            if ($this->allowEmptyRelations) {
                $this->pricing = new SubscriptionPricing();
            } else {
                throw new RelationNotLoadedException('billing');
            }
        }

        return $this->pricing;
    }

    public function setPricing(SubscriptionPricing $pricing): self
    {
        $this->pricing = $pricing;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function product(): Product
    {
        if (!isset($this->product)) {
            if ($this->allowEmptyRelations) {
                $this->product = new Product($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('product');
            }
        }

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
    public function trial(): SubscriptionTrial
    {
        if (!isset($this->trial)) {
            if ($this->allowEmptyRelations) {
                $this->trial = new SubscriptionTrial();
            } else {
                throw new RelationNotLoadedException('trial');
            }
        }

        return $this->trial;
    }

    public function setTrial(SubscriptionTrial $trial): self
    {
        $this->trial = $trial;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
