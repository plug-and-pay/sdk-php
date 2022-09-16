<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PricingTax;

class PricingTaxToBody
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public static function build(PricingTax $tax): array
    {
        $result = [];

        if ($tax->isset('rate')) {
            $result['rate'] = TaxRateToBody::build($tax->rate());
        }

        if ($tax->isset('profile')) {
            $result['profile'] = TaxProfileToBody::build($tax->profile());
        }

        return $result;
    }
}
