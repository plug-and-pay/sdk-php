<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class TenantInternal extends Tenant
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
