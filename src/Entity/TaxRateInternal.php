<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\CountryCode;

/**
 * @internal
 */
class TaxRateInternal extends TaxRate
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
    public function setCountry(CountryCode $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @internal
     */
    public function setPercentage(float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }
}
