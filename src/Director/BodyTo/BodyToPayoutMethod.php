<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

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
            ->setMethod($data['method'])
            ->setSettings($data['settings'] ?? null);
    }
}
