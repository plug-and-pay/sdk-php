<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Pricing
{
    private bool $allowEmptyRelations;
    private bool $taxIncluded;
    /***
     * @var Price[]
     */
    private array $prices;
    private ?bool $shipping;
    private Tax $tax;
    private ?bool $trial;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function isAllowEmptyRelations(): bool
    {
        return $this->allowEmptyRelations;
    }

    public function setAllowEmptyRelations(bool $allowEmptyRelations): Pricing
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
        return $this;
    }

    public function isTaxIncluded(): bool
    {
        return $this->taxIncluded;
    }

    public function setTaxIncluded(bool $isTaxIncluded): Pricing
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
    public function setPrices(array $prices): Pricing
    {
        $this->prices = $prices;
        return $this;
    }

    public function shipping(): ?bool
    {
        return $this->shipping;
    }

    public function setShipping(?bool $shipping): Pricing
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function setTax(Tax $tax): Pricing
    {
        $this->tax = $tax;
        return $this;
    }

    public function trial(): ?bool
    {
        return $this->trial;
    }

    public function setTrial(?bool $isTrial): Pricing
    {
        $this->trial = $isTrial;
        return $this;
    }

    public function tax(): Tax
    {
        if (!isset($this->tax)) {
            if ($this->allowEmptyRelations) {
                $this->tax = new Tax($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('tax');
            }
        }

        return $this->tax;
    }
}
