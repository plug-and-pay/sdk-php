<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

/**
 * @internal
 */
class PricingTaxInternal extends PricingTax
{
    /**
     * @internal
     */
    public function setProfile(TaxProfile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @internal
     */
    public function setRate(TaxRate $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
