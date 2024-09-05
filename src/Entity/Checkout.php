<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Checkout extends AbstractEntity
{
    use HasDynamicFields;

    protected int $id;
    protected bool $isActive;
    protected bool $isExpired;
    protected string $name;
    protected string $previewUrl;
    protected string $primaryColor;
    protected Product $product;
    protected ?string $returnUrl;
    protected ?string $secondaryColor;
    protected string $slug;
    protected string $url;
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    protected ?DateTimeImmutable $deletedAt;

    public function id(): int
    {
        return $this->id;
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

    public function primaryColor(): string
    {
        return $this->primaryColor;
    }

    public function setPrimaryColor(string $primaryColor): self
    {
        $this->primaryColor = $primaryColor;

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
