<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Pricing;

class BodyToPricing
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public static function build(array $data): Pricing
    {
        $pricing = (new Pricing())
            ->setTaxIncluded($data['is_tax_included'])
            ->setShipping($data['shipping'] ? BodyToPricingShipping::build($data['shipping']) : null)
            ->setTrial($data['trial'] ? BodyToPricingTrial::build($data['trial']) : null)
            ->setTax(BodyToPricingTax::build($data['tax']))
            ->setPrices(BodyToPrice::build($data['prices']));

        return $pricing;
    }
}
