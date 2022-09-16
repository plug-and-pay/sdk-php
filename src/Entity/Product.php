<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\ProductType;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Product
{
    private bool $allowEmptyRelations;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $deletedAt;
    private string $description;
    private int $id;
    private bool $isPhysical;
    private Pricing $pricing;
    private string $publicTitle;
    private string $sku;
    private string $slug;
    private string $title;
    private ProductType $type;
    private DateTimeImmutable $updatedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isPhysical(): bool
    {
        return $this->isPhysical;
    }

    public function publicTitle(): string
    {
        return $this->publicTitle;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Product
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): Product
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function setIsPhysical(bool $isPhysical): Product
    {
        $this->isPhysical = $isPhysical;
        return $this;
    }

    public function setPublicTitle(string $publicTitle): Product
    {
        $this->publicTitle = $publicTitle;
        return $this;
    }

    public function setSku(string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    public function setSlug(string $slug): Product
    {
        $this->slug = $slug;
        return $this;
    }

    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    public function setType(ProductType $type): Product
    {
        $this->type = $type;
        return $this;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): Product
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function type(): ProductType
    {
        return $this->type;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
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

    public function statistics(): Billing
    {
        if (!isset($this->billing)) {
            if ($this->allowEmptyRelations) {
//                $this->billing = new Billing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('statistics');
            }
        }

        return $this->billing;
    }

    public function customFields(): Billing
    {
        if (!isset($this->billing)) {
            if ($this->allowEmptyRelations) {
//                $this->billing = new Billing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('customFields');
            }
        }

        return $this->billing;
    }
}
