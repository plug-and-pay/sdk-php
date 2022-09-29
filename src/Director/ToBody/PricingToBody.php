<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\ProductPricing;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class PricingToBody
{
    /**
     * @throws RelationNotLoadedException
     */
    public static function build(ProductPricing $pricing): array
    {
        $result = [];

        if ($pricing->isset('taxIncluded')) {
            $result['is_tax_included'] = $pricing->isTaxIncluded();
        }

        if ($pricing->isset('prices')) {
            $result['prices'] = PriceToBody::buildMulti($pricing->prices());
        }

        if ($pricing->isset('shipping')) {
            $result['shipping'] = ShippingToBody::build($pricing->shipping());
        }

        if ($pricing->isset('tax')) {
            $result['tax'] = PricingTaxToBody::build($pricing->tax());
        }

        if ($pricing->isset('trial')) {
            $result['trial'] = PricingTrialToBody::build($pricing->trial());
        }

        return $result;
    }
}
