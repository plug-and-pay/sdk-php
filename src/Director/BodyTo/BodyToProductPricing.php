<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\ProductPricing;

class BodyToProductPricing
{
    public static function build(array $data): ProductPricing
    {
        return (new ProductPricing())
            ->setTaxIncluded($data['is_tax_included'])
            ->setShipping($data['shipping'] ? BodyToPricingShipping::build($data['shipping']) : null)
            ->setTrial($data['trial'] ? BodyToPricingTrial::build($data['trial']) : null)
            ->setTax(BodyToPricingTax::build($data['tax']))
            ->setPrices(BodyToPrice::buildMulti($data['prices']));
    }
}
