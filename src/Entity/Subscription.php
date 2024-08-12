<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Subscription
{
    use HasDynamicFields;

    protected bool $allowEmptyRelations;
    protected int $id;
    protected ?DateTimeImmutable $cancelledAt;
    protected DateTimeImmutable $createdAt;
    protected ?DateTimeImmutable $deletedAt;
    protected Mode $mode;
    protected SubscriptionPricing $pricing;
    protected Product $product;
    protected SubscriptionStatus $status;
    protected Source $source;
    protected SubscriptionBilling $billing;
    /** @var string[] */
    protected array $tags;
    protected SubscriptionTrial $trial;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function cancelledAt(): ?DateTimeImmutable
    {
        return $this->cancelledAt;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
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
                $this->pricing = new SubscriptionPricing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('pricing');
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

    public function setProductId(int $id): self
    {
        $this->product = (new ProductInternal())->setId($id);

        return $this;
    }

    public function status(): SubscriptionStatus
    {
        return $this->status;
    }

    public function source(): Source
    {
        return $this->source;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function billing(): SubscriptionBilling
    {
        if (!isset($this->billing)) {
            if ($this->allowEmptyRelations) {
                $this->billing = new SubscriptionBilling($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('subscriptionBilling');
            }
        }

        return $this->billing;
    }

    public function setBilling(SubscriptionBilling $billing): self
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
}
