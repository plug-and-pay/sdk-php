<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class ProductPricing extends AbstractEntity
{
    use HasDynamicFields;

    private ?string $discountType;
    private bool $allowEmptyRelations;
    private bool $taxIncluded;
    /*** @var Price[] */
    private array $prices;
    private ?Shipping $shipping;
    private PricingTax $tax;
    private ?PricingTrial $trial;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function discountType(): string
    {
        return $this->discountType;
    }

    public function setDiscountType(string $discountType): self
    {
        $this->discountType = $discountType;

        return $this;
    }

    public function isTaxIncluded(): bool
    {
        return $this->taxIncluded;
    }

    public function setTaxIncluded(bool $isTaxIncluded): self
    {
        $this->taxIncluded = $isTaxIncluded;

        return $this;
    }

    public function prices(): array
    {
        return $this->prices;
    }

    public function setPrices(array $prices): self
    {
        $this->prices = $prices;

        return $this;
    }

    public function shipping(): ?Shipping
    {
        return $this->shipping;
    }

    public function setShipping(?Shipping $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function tax(): PricingTax
    {
        if (!isset($this->tax)) {
            if ($this->allowEmptyRelations) {
                $this->tax = new PricingTax($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('tax');
            }
        }

        return $this->tax;
    }

    public function setTax(PricingTax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function trial(): ?PricingTrial
    {
        return $this->trial;
    }

    public function setTrial(?PricingTrial $trial): self
    {
        $this->trial = $trial;

        return $this;
    }
}
