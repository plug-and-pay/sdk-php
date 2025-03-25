<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Tenant;
use PlugAndPay\Sdk\Entity\TenantInternal;

class BodyToTenant implements BuildObjectInterface
{
    public static function build(array $data): Tenant
    {
        return (new TenantInternal())
            ->setId($data['id'])
            ->setPlan($data['plan']);
    }
}
