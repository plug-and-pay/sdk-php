<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class PricingTax extends AbstractEntity
{
    use ValidatesFieldMethods;

    protected bool $allowEmptyRelations;
    protected TaxRate $rate;
    protected TaxProfile $profile;

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

    public function setRateId(int $int): self
    {
        $this->rate = (new TaxRateInternal())->setId($int);

        return $this;
    }

    public function setProfileId(int $int): self
    {
        $this->profile = (new TaxProfileInternal())->setId($int);

        return $this;
    }
}
