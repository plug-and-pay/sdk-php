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
            $result['amount'] = $shipping->amount();
        }

        if ($shipping->isset('amount_with_tax')) {
            $result['amount_with_tax'] = $shipping->amountWithTax();
        }

        return $result;
    }
}
