<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class ProductPricingTax
{
    private bool $allowEmptyRelations;
    private TaxRate $taxRate;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }
        return isset($this->{$field});
    }

    public function taxRate(): TaxRate
    {
        if (!isset($this->taxRate)) {
            if ($this->allowEmptyRelations) {
                $this->taxRate = new TaxRate();
            } else {
                throw new RelationNotLoadedException('taxRate');
            }
        }

        return $this->taxRate;
    }
}
