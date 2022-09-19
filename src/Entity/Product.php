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
    private Pricing $pricing;
    private Shipping $shipping;
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
        return $this->physical;
    }

    public function ledger(): ?int
    {
        return $this->ledger;
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

    public function setPhysical(bool $physical): Product
    {
        $this->physical = $physical;
        return $this;
    }

    public function setLedger(?int $ledger): self
    {
        $this->ledger = $ledger;
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

    public function setSlug(?string $slug): Product
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

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function stock(): Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        $this->stock = $stock;
        return $this;
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
                throw new RelationNotLoadedException('pricing');
            }
        }

        return $this->pricing;
    }

    public function setPricing(Pricing $pricing): self
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
