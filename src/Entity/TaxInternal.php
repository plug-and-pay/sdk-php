<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

/**
 * @internal
 */
class TaxInternal extends Tax
{
    /**
     * @internal
     */
    public function setRate(TaxRate $rate): self
    {
        $this->rate = $rate;
        return $this;
    }
}
