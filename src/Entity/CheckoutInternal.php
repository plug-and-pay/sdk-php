<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

class CheckoutInternal extends Checkout
{
    /**
     * @internal
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @internal
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @internal
     */
    public function setProductPricing(ProductPricing $productPricing): self
    {
        $this->productPricing = $productPricing;

        return $this;
    }

    /**
     * @internal
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @internal
     */
    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @internal
     */
    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @internal
     */
    public function setHasRedirects(bool $hasRedirects): self
    {
        $this->hasRedirects = $hasRedirects;

        return $this;
    }

    /**
     * @internal
     */
    public function setIsBlueprint(bool $isBlueprint): self
    {
        $this->isBlueprint = $isBlueprint;

        return $this;
    }

    /**
     * @internal
     */
    public function setPixel(?string $pixel): self
    {
        $this->pixel = $pixel;

        return $this;
    }

    /**
     * @internal
     */
    public function setPrimaryColor(?string $primaryColor): self
    {
        $this->primaryColor = $primaryColor;

        return $this;
    }

    /**
     * @internal
     */
    public function setSecondaryColor(?string $secondaryColor): self
    {
        $this->secondaryColor = $secondaryColor;

        return $this;
    }

    /**
     * @internal
     */
    public function setSplitTestId(?int $splitTestId): self
    {
        $this->splitTestId = $splitTestId;

        return $this;
    }
}
