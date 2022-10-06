<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\PricingTax;
use PlugAndPay\Sdk\Entity\TaxProfile;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\CountryCode;

class BodyToPricingTax
{
    public static function build(array $data): PricingTax
    {
        $tax = (new PricingTax());

        if (array_key_exists('rate', $data)) {
            $rate = (new TaxRate())
                ->setId($data['rate']['id'])
                ->setCountry($data['rate']['country'] ? CountryCode::from($data['rate']['country']) : null)
                ->setPercentage((float) $data['rate']['percentage']);

            $tax->setRate($rate);
        }

        if (array_key_exists('profile', $data)) {
            $profile = (new TaxProfile())
                ->setId($data['profile']['id'])
                ->setEditable($data['profile']['is_editable'])
                ->setLabel($data['profile']['label'])
                ->setRates(BodyToRate::buildMulti($data['profile']['rates']));

            $tax->setProfile($profile);
        }

        return $tax;
    }
}
