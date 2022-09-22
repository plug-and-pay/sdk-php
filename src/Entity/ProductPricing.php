<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class ProductPricing
{
    private bool $allowEmptyRelations;
    private bool $taxIncluded;
    /***
     * @var Price[]
     */
    private array $prices;
    private ?Shipping $shipping;
    private PricingTax $tax;
    private ?PricingTrial $trial;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function isAllowEmptyRelations(): bool
    {
        return $this->allowEmptyRelations;
    }

    public function setAllowEmptyRelations(bool $allowEmptyRelations): ProductPricing
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
        return $this;
    }

    public function isTaxIncluded(): bool
    {
        return $this->taxIncluded;
    }

    public function setTaxIncluded(bool $isTaxIncluded): ProductPricing
    {
        $this->taxIncluded = $isTaxIncluded;
        return $this;
    }

    /**
     * @return Price[]
     */
    public function prices(): array
    {
        return $this->prices;
    }

    /**
     * @param Price[] $prices
     * @return $this
     */
    public function setPrices(array $prices): ProductPricing
    {
        $this->prices = $prices;
        return $this;
    }

    public function shipping(): ?Shipping
    {
        return $this->shipping;
    }

    public function setShipping(?Shipping $shipping): ProductPricing
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function setTax(PricingTax $tax): ProductPricing
    {
        $this->tax = $tax;
        return $this;
    }

    public function trial(): ?PricingTrial
    {
        return $this->trial;
    }

    public function setTrial(?PricingTrial $trial): ProductPricing
    {
        $this->trial = $trial;
        return $this;
    }

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

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }
        return isset($this->{$field});
    }
}
