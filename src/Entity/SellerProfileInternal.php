<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class SellerProfileInternal extends SellerProfile
{
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}