<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\SubscriptionPricing;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class SubscriptionPricingToBody
{
    /**
     * @throws RelationNotLoadedException
     */
    public static function build(SubscriptionPricing $pricing): array
    {
        $result = [];

        if ($pricing->isset('amount')) {
            $result['amount'] = $pricing->amount();
        }

        if ($pricing->isset('amountWithTax')) {
            $result['amount_with_tax'] = $pricing->amountWithTax();
        }

        if ($pricing->isset('discounts')) {
            $result['discounts'] = $pricing->discounts();
        }

        if ($pricing->isset('quantity')) {
            $result['quantity'] = $pricing->quantity();
        }

        if ($pricing->isset('tax')) {
            $result['tax'] = TaxToBody::build($pricing->tax());
        }

        if ($pricing->isset('isTaxIncluded')) {
            $result['is_tax_included'] = $pricing->isTaxIncluded();
        }

        return $result;
    }
}
