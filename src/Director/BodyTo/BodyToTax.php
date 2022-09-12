<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\CountryCode;

class BodyToTax
{
    public static function build(array $data): Tax
    {
        return (new Tax())
            ->setAmount((float)$data['amount'])
            ->setRate(
                (new TaxRate())
                    ->setId($data['rate']['id'])
                    ->setCountry($data['rate']['country'] ? CountryCode::from($data['rate']['country']) : null)
                    ->setPercentage((float)$data['rate']['percentage'])
            );
    }

    /**
     * @return Tax[]
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $tax) {
            $result[] = self::build($tax);
        }
        return $result;
    }
}
