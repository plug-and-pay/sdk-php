<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Discount;

class SubscriptionPricingDiscountToBody
{
    public static function build(Discount $discount): array
    {
        $result = [];

        if ($discount->isset('amount')) {
            $result['amount'] = (string) $discount->amount();
        }

        if ($discount->isset('amountWithTax')) {
            $result['amount_with_tax'] = (string) $discount->amountWithTax();
        }

        if ($discount->isset('code')) {
            $result['code'] = $discount->code();
        }

        if ($discount->isset('type')) {
            $result['type'] = $discount->type()->value;
        }

        return $result;
    }

    public static function buildMulti(array $discounts): array
    {
        $result = [];

        foreach ($discounts as $discount) {
            $result[] = self::build($discount);
        }

        return $result;
    }
}
