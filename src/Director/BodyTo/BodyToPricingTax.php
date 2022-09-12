<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\PricingTax;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\CountryCode;

class BodyToPricingTax
{
    public static function build(array $data): PricingTax
    {
        return (new PricingTax())
            ->setRate(
                (new TaxRate())
                    ->setId($data['rate']['id'])
                    ->setCountry($data['rate']['country'] ? CountryCode::from($data['rate']['country']) : null)
                    ->setPercentage((float)$data['rate']['percentage'])
            );
    }
}
