<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Checkout extends AbstractEntity
{
    use HasDynamicFields;

    protected bool $allowEmptyRelations;
    protected int $id;
    protected bool $hasRedirects;
    protected bool $isActive;
    protected bool $isBlueprint;
    protected bool $isExpired;
    protected string $name;
    protected ?string $pixel;
    protected string $previewUrl;
    protected ?string $primaryColor;
    protected Product $product;
    protected ProductPricing $productPricing;
    protected ?string $returnUrl;
    protected ?string $secondaryColor;
    protected ?int $splitTestId;
    protected string $slug;
    protected string $url;
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    protected ?DateTimeImmutable $deletedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function hasRedirects(): bool
    {
        return $this->hasRedirects;
    }

    public function setHasRedirects(bool $hasRedirects): self
    {
        $this->hasRedirects = $hasRedirects;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isBlueprint(): bool
    {
        return $this->isBlueprint;
    }

    public function setIsBlueprint(bool $isBlueprint): self
    {
        $this->isBlueprint = $isBlueprint;

        return $this;
    }

    public function isExpired(): bool
    {
        return $this->isExpired;
    }

    public function setIsExpired(bool $isExpired): self
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function previewUrl(): string
    {
        return $this->previewUrl;
    }

    public function setPreviewUrl(string $previewUrl): self
    {
        $this->previewUrl = $previewUrl;

        return $this;
    }

    public function primaryColor(): ?string
    {
        return $this->primaryColor;
    }

    public function setPrimaryColor(?string $primaryColor): self
    {
        $this->primaryColor = $primaryColor;

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function product(): Product
    {
        if (!isset($this->product)) {
            throw new RelationNotLoadedException('product');
        }

        return $this->product;
    }

    public function setProductId(int $id): self
    {
        $this->product = (new ProductInternal())->setId($id);

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function productPricing(): ProductPricing
    {
        if (!isset($this->productPricing)) {
            if ($this->allowEmptyRelations) {
                $this->productPricing = new ProductPricing($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('pricing');
            }
        }

        return $this->productPricing;
    }

    public function pixel(): ?string
    {
        return $this->pixel;
    }

    public function setPixel(?string $pixel): self
    {
        $this->pixel = $pixel;

        return $this;
    }

    public function returnUrl(): ?string
    {
        return $this->returnUrl;
    }

    public function setReturnUrl(?string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    public function secondaryColor(): ?string
    {
        return $this->secondaryColor;
    }

    public function setSecondaryColor(?string $secondaryColor): self
    {
        $this->secondaryColor = $secondaryColor;

        return $this;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function splitTestId(): ?int
    {
        return $this->splitTestId;
    }

    public function setSplitTestId(?int $splitTestId): self
    {
        $this->splitTestId = $splitTestId;

        return $this;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
