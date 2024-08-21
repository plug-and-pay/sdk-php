<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use function array_key_exists;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\PricingTax;
use PlugAndPay\Sdk\Entity\PricingTaxInternal;
use PlugAndPay\Sdk\Entity\TaxProfileInternal;
use PlugAndPay\Sdk\Entity\TaxRateInternal;
use PlugAndPay\Sdk\Enum\CountryCode;

class BodyToPricingTax implements BuildObjectInterface
{
    public static function build(array $data): PricingTax
    {
        $tax = (new PricingTaxInternal());

        if (array_key_exists('rate', $data)) {
            $rate = (new TaxRateInternal())
                ->setId($data['rate']['id'])
                ->setCountry($data['rate']['country'] ? CountryCode::from($data['rate']['country']) : null)
                ->setPercentage((float) $data['rate']['percentage']);

            $tax->setRate($rate);
        }

        if (array_key_exists('profile', $data)) {
            $profile = (new TaxProfileInternal())
                ->setId($data['profile']['id'])
                ->setEditable($data['profile']['is_editable'])
                ->setLabel($data['profile']['label'])
                ->setRates(BodyToRate::buildMulti($data['profile']['rates']));

            $tax->setProfile($profile);
        }

        return $tax;
    }
}
