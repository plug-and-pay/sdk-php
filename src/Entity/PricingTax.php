<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class PricingTax
{
    private bool $allowEmptyRelations;
    private TaxRate $rate;
    private TaxProfile $profile;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function profile(): TaxProfile
    {
        if (!isset($this->profile)) {
            if ($this->allowEmptyRelations) {
                $this->profile = new TaxProfile();
            } else {
                throw new RelationNotLoadedException('profile');
            }
        }

        return $this->profile;
    }

    public function setProfile(TaxProfile $profile): self
    {
        $this->profile = $profile;
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
