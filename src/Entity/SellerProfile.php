<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class SellerProfile extends AbstractEntity
{
    use HasDynamicFields;

    protected int $id;

    public function id(): int
    {
        return $this->id;
    }
}
