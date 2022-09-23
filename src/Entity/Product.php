<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
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
    private ?int $ledger;
    private bool $physical;
    private ProductPricing $pricing;
    private string $publicTitle;
    private string $sku;
    private ?string $slug;
    private Stock $stock;
    private string $title;
    private ProductType $type;
    private DateTimeImmutable $updatedAt;

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

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function isPhysical(): bool
    {
        return $this->physical;
    }

    public function setPhysical(bool $physical): self
    {
        $this->physical = $physical;
        return $this;
    }

    public function ledger(): ?int
    {
        return $this->ledger;
    }

    public function setLedger(?int $ledger): self
    {
        $this->ledger = $ledger;
        return $this;
    }

    public function publicTitle(): string
    {
        return $this->publicTitle;
    }

    public function setPublicTitle(string $publicTitle): self
    {
        $this->publicTitle = $publicTitle;
        return $this;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function type(): ProductType
    {
        return $this->type;
    }

    public function setType(ProductType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function stock(): Stock
    {
        if (!isset($this->stock)) {
            if ($this->allowEmptyRelations) {
                $this->stock = new Stock();
            } else {
                throw new RelationNotLoadedException('stock');
            }
        }

        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function pricing(): ProductPricing
    {
        if (!isset($this->pricing)) {
            if ($this->allowEmptyRelations) {
                $this->pricing = new ProductPricing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('pricing');
            }
        }

        return $this->pricing;
    }

    public function setPricing(ProductPricing $pricing): self
    {
        $this->pricing = $pricing;
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
