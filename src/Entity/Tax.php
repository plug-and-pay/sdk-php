<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Tax
{
    private bool $allowEmptyRelations;
    private float $amount;
    private TaxRate $rate;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function rate(): TaxRate
    {
        if (!isset($this->rate)) {
            if ($this->allowEmptyRelations) {
                $this->rate = new TaxRate();
            } else {
                throw new RelationNotLoadedException('rate');
            }
        }

        return $this->rate;
    }

    public function setRate(TaxRate $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
