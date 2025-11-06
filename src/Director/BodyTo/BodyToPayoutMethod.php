<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\PayoutMethod;
use PlugAndPay\Sdk\Entity\PayoutMethodInternal;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToPayoutMethod implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    public static function build(array $data): PayoutMethod
    {
        return (new PayoutMethodInternal())
            ->setId($data['id'])
            ->setMethod($data['method'])
            ->setSettings($data['settings'] ?? null)
            ->setCreatedAt(new DateTimeImmutable($data['created_at']))
            ->setUpdatedAt(new DateTimeImmutable($data['updated_at']));
    }
}
