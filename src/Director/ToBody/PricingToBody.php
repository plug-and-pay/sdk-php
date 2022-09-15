<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Pricing;

class PricingToBody
{
    public static function build(Pricing $pricing): array
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

        return $result;
    }
}
