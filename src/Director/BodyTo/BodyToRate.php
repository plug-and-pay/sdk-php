<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\CountryCode;

class BodyToRate
{
    public static function build(array $data): TaxRate
    {
        return (new TaxRate())
            ->setId($data['id'])
            ->setCountry($data['country'] ? CountryCode::from($data['country']) : null)
            ->setPercentage((float)$data['percentage']);
    }

    /**
     * @return Tax[]
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $rate) {
            $result[] = self::build($rate);
        }
        return $result;
    }
}
