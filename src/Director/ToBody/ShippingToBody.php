<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Shipping;

class ShippingToBody
{
    public static function build(Shipping $shipping): array
    {
        $result = [];

        if ($shipping->isset('amount')) {
            $result['amount'] = (string) $shipping->amount();
        }

        if ($shipping->isset('amountWithTax')) {
            $result['amount_with_tax'] = (string) $shipping->amountWithTax();
        }

        return $result;
    }
}
