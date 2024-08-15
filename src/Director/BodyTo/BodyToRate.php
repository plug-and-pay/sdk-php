<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Entity\TaxRateInternal;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToRate implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    public static function build(array $data): TaxRate
    {
        return (new TaxRateInternal())
            ->setId($data['id'])
            ->setCountry($data['country'] ? CountryCode::from($data['country']) : null)
            ->setPercentage((float) $data['percentage']);
    }
}
