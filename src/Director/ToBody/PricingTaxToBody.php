<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PricingTax;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class PricingTaxToBody
{
    /**
     * @throws RelationNotLoadedException
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
