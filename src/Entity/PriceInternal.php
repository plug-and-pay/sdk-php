<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

/**
 * @internal
 */
class PriceInternal extends Price
{
    /**
     * @internal
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}
