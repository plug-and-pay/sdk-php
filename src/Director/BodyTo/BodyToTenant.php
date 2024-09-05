<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\TenantInternal;
use PlugAndPay\Sdk\Entity\Tenant;

class BodyToTenant implements BuildObjectInterface
{
    public static function build(array $data): Tenant
    {
        return (new TenantInternal())->setId($data['id']);
    }
}
