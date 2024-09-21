<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Product extends AbstractEntity
{
    use HasDynamicFields;

    protected bool $allowEmptyRelations;
    protected int $id;
    protected DateTimeImmutable $createdAt;
    protected ?DateTimeImmutable $deletedAt;
    protected string $description;
    protected ?int $ledger;
    protected bool $physical;
    protected ProductPricing $pricing;
    protected string $publicTitle;
    protected ?string $sku;
    protected ?string $slug;
    protected Stock $stock;
    protected string $title;
    protected ContractType $type;
    protected DateTimeImmutable $updatedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function id(): int
    {
        return $this->id;
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

    public function sku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): self
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

    public function type(): ContractType
    {
        return $this->type;
    }

    public function setType(ContractType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
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
}
